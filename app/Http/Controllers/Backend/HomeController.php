<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::with('userType')->orderByDesc('id')->limit(10)->get();

        $products = Product::with('category:id,name', 'user:id,name')
            ->withCount('images')
            ->limit(10)
            ->orderByDesc('id')
            ->get();

        $toltalUsers = User::select('id')->count();
        $toltalProduct = Product::select('id')->count();
        $toltalCategory = Category::select('id')->count();
        $toltalOrder = Transaction::select('id')->count();

        $user = Auth::user();
        if ($user) {
            $user->update(['last_login_at' => Carbon::now()]);
        }

        $viewData = [
            'users' => $users,
            'products' => $products,
            'toltalUsers' => $toltalUsers,
            'toltalProduct' => $toltalProduct,
            'toltalCategory' => $toltalCategory,
            'toltalOrder' => $toltalOrder,
        ];

        return view('backend.home.index', $viewData);
    }
    public function filter_by_date(Request $request)
    {

        $data = $request->all();

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get =  Statistic::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key) {

            $chart_data[] = array(
                'date_create' => $key->order_date,
                'total_product' => $key->total_product,
                'success' => $key->success,
                'finish' => $key->finish,
                'cancel' => $key->cancel,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function filter_by_option(Request $request)
    {

        $data = $request->all();

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $now =  Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {
            $get = Statistic::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        } else if ($data['dashboard_value'] == 'thangtruoc') {
            $get = Statistic::whereBetween('order_date', [$dauthangtruoc, $cuoithangtruoc])->orderBy('order_date', 'ASC')->get();
        } else if ($data['dashboard_value'] == 'thangnay') {
            $get = Statistic::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        } else {
            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }

        foreach ($get as $key) {

            $chart_data[] = array(
                'date_create' => $key->order_date,
                'total_product' => $key->total_product,
                'success' => $key->success,
                'finish' => $key->finish,
                'cancel' => $key->cancel,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function filter_by_30days()
    {

        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();

        $now =  Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = Statistic::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key) {

            $chart_data[] = array(
                'date_create' => $key->order_date,
                'total_product' => $key->total_product,
                'success' => $key->success,
                'finish' => $key->finish,
                'cancel' => $key->cancel,
            );
        }
        echo $data = json_encode($chart_data);
    }
}
