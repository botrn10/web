<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\SendOtpUpdateEmail;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



use Carbon\Carbon;
use App\Models\User;
use App\Service\ServiceOtp;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $viewData = [
            'user' => $user
        ];

        return view('backend.profile.index',  $viewData);
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $data               = $request->except('_token', 'avatar');
            $data['updated_at'] = Carbon::now();

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) $data['avatar'] = $file['name'];
            }

            $update = User::find($id)->update($data);
            toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            Log::error("ERROR => ProfileController@store => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('post_admin.profile.update', $id);
        }
        return redirect()->route('get_admin.profile.index');
    }

    public function updatePassword()
    {

        $user = Auth::user();

        $viewData = [
            'user' => $user
        ];

        return view('backend.profile.update_password',  $viewData);
    }

    public function processUpdatePassword(UpdatePasswordRequest $request, $id)
    {

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->updated_at = Carbon::now();

        $user->save(); // Lỗi nhưng kh sao ??

        return redirect()->back();
    }

    public function updateEmail()
    {
        $user = Auth::user();

        $viewData = [
            'user' => $user
        ];

        return view('backend.profile.update_email', $viewData);
    }

    public function processUpdateEmail(UpdateEmailRequest $request)
    {
        // dd($request->all());
        $userLogin = Auth::user();
        $otp = ServiceOtp::findOtpByCode($request->code, $userLogin->id);

        if (!$otp) {
            toastr()->error('OTP không hợp lệ hoặc không tồn tại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->back();
        }

        $email = User::where('email', $request->email)->first();

        if ($email) {
            toastr()->error('Email đã tồn tại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->back();
        }

        $user = Auth::user();
        $user->email = $request->email;
        $user->updated_at = Carbon::now();
        $user->save();

        ServiceOtp::updateStatusOtp($otp->id, Otp::STATUS_SUCCESS);

        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);

        return redirect()->route('get_admin.profile.index');
    }

    public function sendOtpEmail(Request $request)
    {

        $email = $request->email;

        if (!$email) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email không tồn tại'
            ]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User không tồn tại'
            ]);
        }

        $otp = ServiceOtp::createOtp([
            'code'        => random_int(10000000, 99999999),
            'type_otp'    => Otp::TYPE_UPDATE_PROFILE,
            'status'      => Otp::STATUS_DEFAULT,
            'user_id'     => $user->id,
            'service'     => Otp::SERVICE_EMAIL,
            're_send_otp' => 0,
            'created_at'  => Carbon::now()
        ]);

        if ($otp) {

            try {
                $response = Mail::to($user->email)
                    ->cc('thangb1906766@gmail.com')
                    ->queue(new SendOtpUpdateEmail($user, $otp));

                ServiceOtp::updateStatusOtp($otp->id, Otp::STATUS_SEND);
            } catch (\Exception $exception) {
                ServiceOtp::updateStatusOtp($otp->id, Otp::STATUS_ERROR);
                Log::error("============ Send OTP: " . json_encode($exception->getMessage()));
                return response()->json([
                    'status' => 'error'
                ]);
            }
            // thông báo người dùng nhập

        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
