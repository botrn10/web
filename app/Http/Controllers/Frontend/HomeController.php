<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $productNews = Product::with('user:id,name,avatar', 'province:id,name')->where('status', Product::STATUS_SUCCESS);

        $categories = Category::all();
        $slides = Slide::all();

        $productNews = $productNews
            ->orderByDesc('id')
            ->paginate(10);

        $user = Auth::user();
        if ($user) {
            $user->update(['last_login_at' => Carbon::now()]);
        }

        $viewData = [
            'productNews' => $productNews,
            'categories' => $categories,
            'slides' => $slides,
        ];

        return view('frontend.home.index', $viewData);
    }

    public function checkUnseenMessage()
    {
        $unseenCounter = DB::table('ch_messages')->where('to_id', '=', Auth::user()->id)->where('seen', '=', '0')->count();
        return response()->json(["unseenCounter" => $unseenCounter]);
    }
}
