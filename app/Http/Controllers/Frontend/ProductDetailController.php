<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;


class ProductDetailController extends Controller
{
    public function index(Request $request, $slug)
    {
        $productDetail = Product::with('category:id,name', 'user:id,name,avatar,phone', 'province:id,name', 'district:id,name', 'ward:id,name')
            ->whereIn('status', [Product::STATUS_SUCCESS])
            ->where('slug', $slug)->first();

        if(!$productDetail) return abort(404);

        $productNews = Product::with('province:id,name')->whereIn('status', [Product::STATUS_SUCCESS])
        ->orderByDesc('id')
        ->limit(18)
        ->get();

        // Show album ảnh
        $images = ProductImage::where('product_id', $productDetail->id)->pluck('path','id')->toArray() ?? [];

        if($productDetail->avatar && empty($images)){
            array_push($images, $productDetail->avatar);
        }
        // dd($images);
        $productsCart = \Cart::content();

        $viewData = [
            'productDetail' => $productDetail,
            'productNews' => $productNews,
            'images' => $images,
            'productsCart' => $productsCart
        ];

        return view('frontend.product.index', $viewData);
    }
}
