<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 5/6/23 .
 * Time: 9:59 AM .
 */

namespace App\Service;

use App\Models\Otp;
use Carbon\Carbon;

class ServiceOtp
{
    public static function createOtp($data)
    {
        return Otp::create($data);
    }

    public static function updateStatusOtp($otpId, $status)
    {
        return Otp::where('id', $otpId)
            ->update([
                'status'     => $status,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function findOtpByCode($code, $userID)
    {
        return Otp::where([
            'code'    => $code,
            'user_id' => $userID
        ])->whereIn('status', [Otp::STATUS_ERROR, Otp::STATUS_SEND])
            ->orderByDesc('id')->first();

        
    }
}
