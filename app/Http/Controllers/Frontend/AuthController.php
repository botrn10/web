<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckEmailRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateNewPassword;
use App\Mail\SendEmailResetPassword;
use App\Mail\SendMailResetPassword;
use App\Models\Province;
use App\Models\UserType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function postLogin(Request $request)
    {
        // dd($request->all());
        $credentials = [
            'email' => $request->email,
            'password' =>  $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('get.home');
        }

        return redirect()->back();
    }

    public function register()
    {

        $provinces  = Province::all();
        $viewData = [
            'provinces' => $provinces,
        ];
        return view('frontend.auth.register', $viewData);
    }

    public function postRegister(RegisterUserRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $data = $request->except('_token', 'avatar', 'user_type'); // Lấy dữ liệu từ $request gửi lên trừ _token và avatar
            $data['created_at'] = Carbon::now();
            $data['password'] = bcrypt($request->password); // Mã hóa password
            $data['status'] = $request->status ?? 1;

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }

            $userType = UserType::where('name', User::ROLE_USER)->first();

            $user = User::create($data);

            if ($user) {
                DB::table('user_has_types')->insert([
                    'user_type_id' => $userType->id,
                    'created_at' => Carbon::now(),
                    'user_id' => $user->id
                ]);

                // dd($request->all());

                DB::table('profile')->insert([
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'ward_id' => $request->ward_id,
                    'user_id' => $user->id,
                    'address_detail' => $request->address_detail,
                    'created_at' => Carbon::now(),
                    'status' => 1,
                ]);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("ERROR => AuthController@store => " . $exception->getMessage());
            toastr()->error('Đăng ký thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.register');
        }
        toastr()->warning('Đăng ký thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('get.login');
    }

    public function restartPassword()
    {

        return view('frontend.auth.restart_password');
    }

    public function checkRestartPassword(CheckEmailRequest $request)
    {

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            toastr()->error('Không tồn tại tài khoản tương ứng!', 'Thông báo');
            return redirect()->back();
        }

        $token = bcrypt($email) . bcrypt($user->id);
        $passwordResets = DB::table('password_resets')
            ->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

        if (!$passwordResets) {
            toastr()->error('Xử lý dữ liệu thất bại, xin vui lòng kiểm tra lại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->back();
        }

        $link = route('get.new_password', ['token' => $token]);

        Mail::to($user->email)
            ->cc('thangb1906766@gmail.com')
            ->queue(new SendEmailResetPassword($user, $link));

        return  redirect()->route('get.alert_new_password');
    }

    public function alertNewPassword()
    {
        return view('frontend.auth.alert_re_new_password');
    }

    public function newPassword(Request $request)
    {
        $token = $request->token;

        $passwordResets = DB::table('password_resets')
            ->where('token', $token)->first();

        if (!$passwordResets) {
            toastr()->error('Thông tin không hợp lệ, xin vui lòng kiểm tra lại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.restart_password');
        }

        // check token hết hạn chưa
        return view('frontend.auth.new_password');
    }

    public function processNewPassword(UpdateNewPassword $request)
    {
        $token = $request->token;

        $passwordResets = DB::table('password_resets')
            ->where('token', $token)->first();

        if (!$passwordResets) {
            toastr()->error('Thông tin không hợp lệ, xin vui lòng kiểm tra lại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.restart_password');
        }

        User::where('email', $passwordResets->email)
            ->update([
                'password' => bcrypt($request->password),
                'updated_at' => Carbon::now()
            ]);

        DB::table('password_resets')
            ->where('token', $token)->delete();

        toastr()->success('Đổi mật khẩu thành công, xin vui lòng đăng nhập lại!', 'Thông báo', ['timeOut' => 2000]);
        return  redirect()->route('get.login');
    }
}
