<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, $slug){

        $category = Category::where('slug', $slug)->first();

        if(!$category) return abort(404);

        $products = Product::with('province:id,name', 'user:id,name,avatar')->where('status', Product::STATUS_SUCCESS);

        $products = $products->where('category_id', $category->id)->orderByDesc('id')->paginate(20);

        $viewData = [
            'products' => $products,
            'category' => $category,
            
        ];

        return view('frontend.category.index', $viewData);
    }
}
