<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        $productOfUser = Product::with('category:id,name', 'user:id,name,avatar,phone', 'province:id,name', 'district:id,name', 'ward:id,name')->where('user_id', $id)->whereIn('status', [Product::STATUS_SUCCESS]);
     
        $productOfUser = $productOfUser->orderByDesc('id')->paginate(20);

        $viewData = [
            'productOfUser' => $productOfUser,
        ];

        return view('frontend.profile.index', $viewData);
    }
}
