<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        
        $products = Product::with('province:id,name')->whereIn('status', [Product::STATUS_SUCCESS, Product::STATUS_FINISH]);
        
        if ($request->k)
            $products->where('name','like','%'.$request->k.'%');

        $products =   $products->orderByDesc('id')->paginate(20);

        $viewData = [
            'products' => $products
        ];

        return view('frontend.search.index', $viewData);
    }
}
