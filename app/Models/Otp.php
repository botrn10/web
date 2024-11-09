<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Otp extends Model
{
    use HasFactory;
    protected $table = 'otps';
    protected $guarded = [''];

    const STATUS_DEFAULT = 0;
    const STATUS_SEND = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = -1;

    const TYPE_UPDATE_PROFILE = 'otp_profile';

    const SERVICE_EMAIL = 'email';
    const SERVICE_SMS = 'sms';

    public $setStatus = [
        self::STATUS_DEFAULT => [
            'name' => 'Khởi tạo',
            'class' => 'badge badge-light'
        ],
        self::STATUS_SUCCESS => [
            'name' => 'Hoàn thành',
            'class' => 'badge badge-primary'
        ],
        self::STATUS_ERROR => [
            'name' => 'Gủi lỗi',
            'class' => 'badge badge-danger'
        ],
        self::STATUS_SEND => [
            'name' => 'Đã gủi',
            'class' => 'badge badge-success'
        ],
    ];

    public function getStatus()
    {
        return Arr::get($this->setStatus,$this->status, []);
    }
}
