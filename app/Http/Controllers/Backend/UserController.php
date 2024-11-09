<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UserRequest;
use App\Mail\SendEmailRegisterUser;
use App\Models\Category;
use App\Models\User;
use App\Models\UserType;
use App\Models\UserHasType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $users = User::with('userType'); // Phân trang 20 dòng

        if ($name = $request->n) // Tìm bằng tên
            $users->where('name', 'like', '%' . $name . '%');

        if ($s = $request->status) // Tìm bằng trạng thái
            $users->where('status', $s);

        $users = $users
            ->orderByDesc('id')
            ->paginate(10);

        $model = new User();
        $status = $model->getStatus();

        $viewData = [
            'users' => $users,
            'status' => $status,
            // 'getUsersLogin' => $getUsersLogin,
        ];
        return view('backend.user.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function indexUserNotLogin(Request $request)
    {
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30);
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        $getUsersNotLoggedIn = User::where(function ($query) use ($sub30days, $now) {
            $query->whereNotBetween('last_login_at', [$sub30days, $now])
                ->orWhereNull('last_login_at');
        });

        $getUsersNotLoggedIn = $getUsersNotLoggedIn->orderBy('last_login_at', 'ASC')->paginate(10);

        $viewData = [
            'getUsersNotLoggedIn' => $getUsersNotLoggedIn,
        ];
        return view('backend.user.indexUserNotLogin', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {

        $userType = UserType::all();

        $roles = Role::all();

        $roleActive = $userHasType = [];


        return view('backend.user.create', compact('userType', 'roles', 'roleActive', 'userHasType'));
    }

    public function store(UserRequest $request)
    {
        // dd($request->all());
        try {
            $data = $request->except('_token', 'avatar', 'user_type', 'roles');
            $data['created_at'] = Carbon::now();
            $data['password'] = bcrypt(Carbon::now());
            $data['email_verified_at'] = Carbon::now();
            $data['status'] = $request->status ?? 1;

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }

            $user = User::create($data);

            if ($user) {
                $this->insertOrUpdateHasType($user, $request->user_type);

                if ($request->roles)
                    $user->assignRole($request->roles);

                // 1. Gửi mail không dùng queue
                Mail::to($user->email)->send(new SendEmailRegisterUser($user));

                // 2. Gửi mail dùng queue (rút ngắn thời gian)
                // Mail::to($user->email)->queue(new SendEmailRegisterUser($user));

            }
        } catch (\Exception $exception) {
            Log::error("ERROR => UserController@store => " . $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.user.index');
        }

        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.user.index');
    }

    protected function insertOrUpdateHasType($user, $typeID)
    {
        $check = UserHasType::where('user_id', $user->id)->first();
        if ($check) {
            $check->user_type_id = $typeID;
            $check->updated_at = Carbon::now();
            $check->save();
        } else {
            DB::table('user_has_types')->insert([
                'user_type_id' => $typeID,
                'created_at' => Carbon::now(),
                'user_id' => $user->id
            ]);
        }
    }

    public function edit($id)
    {

        $user = User::findOrFail($id);

        $roles = Role::all();

        $userType = UserType::all();

        $userHasType = DB::table('user_has_types')->where('user_id', $id)->pluck('user_type_id')->toArray();

        $roleActive = DB::table('model_has_roles')->where('model_id', $id)->pluck('role_id')->toArray();

        return view('backend.user.update', compact('user', 'userType', 'roles', 'roleActive', 'userHasType'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $data = $request->except('_token', 'avatar', 'user_type');
            $data['updated_at'] = Carbon::now();

            // dd($request->all());
            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }

            $update = User::find($id)->update($data);
            if ($update) {
                $user = User::find($id);
                $this->insertOrUpdateHasType($user, $request->user_type);

                if ($request->roles) {
                    $roleActive = DB::table('model_has_roles')->where('model_id', $id)->pluck('role_id')->toArray();
                    if (!empty($roleActive)) {
                        foreach ($roleActive as $item)
                            $user->removeRole($item);
                    }

                    $user->assignRole($request->roles);
                }
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => UserController@update => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.user.update', $id);
        }

        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.user.index');
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user) {
                UserHasType::where('user_id', $id)->delete();
                $user->delete();
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => UserController@delete => " . $exception->getMessage());
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
        }
        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.user.index');
    }
}
