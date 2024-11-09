<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUser;
use App\Http\Requests\UpdateProfile;
use App\Models\Profile;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stringable;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = Profile::all()->where('user_id', Auth::user()->id);;

        $user = Auth::user();

        $viewData = [
            'user' => $user,
            'query'    => $request->query(),
            'profiles' => $profiles,
        ];
        return view('user.profile.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $provinces  = Province::all();
        $user = Auth::user();

        $existingAddressesCount = DB::table('profile')
            ->where('user_id', $user->id)
            ->count();

        $viewData = [
            'provinces' => $provinces,
            'existingAddressesCount' => $existingAddressesCount,
        ];

        return view('user.profile.create', $viewData);
    }

    public function store(AddressUser $request)
    {
        try {
            $user = Auth::user();

            $existingAddressesCount = DB::table('profile')
                ->where('user_id', $user->id)
                ->count();

            if ($existingAddressesCount >= 3) {
                toastr()->error('Bạn chỉ được thêm tối đa 3 địa chỉ!', 'Thông báo', ['timeOut' => 2000]);
                return redirect()->route('get.user.update_profile');
            }

            $data = $request->except('_token');
            $data['created_at'] = Carbon::now();
            $data['user_id'] = $user->id;

            // Kiểm tra xem người dùng đã có địa chỉ nào chưa
            if ($existingAddressesCount == 0) {
                // Nếu không có địa chỉ nào, đặt trạng thái của địa chỉ mới là 1
                $data['status'] = 1;
            } else {
                // Nếu đã có địa chỉ, sử dụng giá trị từ form
                $data['status'] = $request->has('status') ? 1 : 0;
            }

            // Nếu địa chỉ mới được thêm là mặc định, cập nhật trạng thái của các địa chỉ khác thành 0
            if ($data['status'] == 1) {
                Profile::where('user_id', $user->id)->update(['status' => 0]);
            }

            // dd($request->all());
            DB::table('profile')->insert($data);
        } catch (\Exception $exception) {
            Log::error("ERROR => ProfileController@store => " . $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.user.update_profile.create-address');
        }
        toastr()->warning('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.update_profile');
    }

    public function editAddress($id)
    {
        $provinces = Province::all();
        $profile = Profile::where('user_id', Auth::user()->id)->findOrFail($id);
        $activeDistricts = DB::table('districts')->where('id', $profile->district_id)->pluck('name', 'id')->toArray();
        $activeWards = DB::table('wards')->where('id', $profile->ward_id)->pluck('name', 'id')->toArray();



        $viewData = [
            'profile' => $profile,
            'provinces' => $provinces,
            'activeDistricts' => $activeDistricts,
            'activeWards' => $activeWards,
        ];
        return view('user.profile.update', $viewData); // compact(): Tạo mảng với giá trị 'product'
    }
    public function updateAddress(AddressUser $request, $id)
    {
        try {
            $user = Auth::user();
            $data = $request->except('_token');
            $data['updated_at'] = Carbon::now();

            // dd($request->all());

            if (!$request->status) {
                $data['status'] = 0;
                Profile::find($id)->update($data);
            } else if ($request->status == 1) {
                $latestAddresses = Profile::where('user_id', $user->id)->latest()->take(3)->get();
                foreach ($latestAddresses as $address) {
                    $address->update(['status' => 0]);
                }
                $data['status'] = 1;
                Profile::find($id)->update($data);
            }
        } catch (\Exception $exception) {

            Log::error("ERROR => ProfileController@update => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.address_update', $id);
        }

        toastr()->warning('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.update_profile');
    }

    public function profile()
    {
        $user = Auth::user();

        $profiles = Profile::with('province:id,name', 'district:id,name', 'ward:id,name')->where('user_id', $user->id);

        // dd($profiles);

        // $provinces  = Province::all();

        $viewData = [
            'user' => $user,
            'profiles' => $profiles,
            // 'provinces' => $provinces,
        ];
        return view('user.update_profile', $viewData);
    }

    public function updateProfile(UpdateProfile $request)
    {

        try {
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->updated_at = Carbon::now();

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) $user->avatar = $file['name'];
            }
            toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
            $user->save();
        } catch (\Exception $exception) {
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => ProfileController@updateProfile => " . $exception->getMessage());
        }
        return redirect()->back();
    }
}
