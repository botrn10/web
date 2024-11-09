<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // Tên table trong database
    protected $guarded = ['']; // Tùy chỉnh mọi dữ liệu

    const STATUS_DEFAULT = 1;

    const STATUS_SUCCESS = 2;

    const STATUS_CANCEL = -1;

    const STATUS_FINISH = 3;

    public $setStatus = [
        self::STATUS_DEFAULT => [
            'name' => 'Khởi tạo',
            'class' => 'badge badge-warning'
        ],
        self::STATUS_SUCCESS => [
            'name' => 'Hoạt động',
            'class' => 'badge badge-primary'
        ],
        self::STATUS_CANCEL => [
            'name' => 'Không được duyệt',
            'class' => 'badge badge-danger'
        ],
        self::STATUS_FINISH => [
            'name' => 'Đã bán / Ẩn tin',
            'class' => 'badge badge-success'
        ],
    ];

    public function getStatus()
    {
        return Arr::get($this->setStatus, $this->status, []);
    }

    public function category()
    { // Hiển thị tên danh mục ở sản phẩm
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Hiển thị album ảnh ở mục sản phẩm
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Sản phẩm thuộc user nào
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Location
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
}
