<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles'; // Tên table trong database
    protected $guarded = ['']; // Tùy chỉnh mọi dữ liệu

    const STATUS_DEFAULT = 1;

    const STATUS_SUCCESS = 2;

    const STATUS_CANCEL = -1;

    const STATUS_FINISH = 3;

    public $setStatus = [
        self::STATUS_DEFAULT => [
            'name' => 'Khởi tạo',
            'class' => 'badge badge-light'
        ],
        self::STATUS_SUCCESS => [
            'name' => 'Active',
            'class' => 'badge badge-primary'
        ],
        self::STATUS_CANCEL => [
            'name' => 'Hủy bỏ',
            'class' => 'badge badge-danger'
        ],
        self::STATUS_FINISH => [
            'name' => 'Hoàn thành',
            'class' => 'badge badge-success'
        ],
    ];

    public function getStatus()
    {
        return Arr::get($this->setStatus, $this->status, []);
    }

    // Hiển thị tên danh mục ở sản phẩm
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // Sản phẩm thuộc user nào
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
