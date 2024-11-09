<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveInfoShoppingCart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Transaction;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function addProduct(Request $request, $id)
    {

        $product = Product::with('user:id,name,avatar')->select('name', 'id', 'price', 'avatar', 'slug', 'user_id')
            ->find($id);
        if (!$product) return redirect('/');

        // Thêm giỏ hàng vào CSDL end
        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' =>
            ['avatar' => $product->avatar, 'slug' => $product->slug, 'user_name' => $product->user->name, 'user_avatar' => $product->user->avatar, 'user_id' => $product->user_id]
        ]);

        toastr()->success('Đã thêm vào danh sách Giỏ hàng', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->back();
    }

    public function getListShoppingCart()
    {
        $products = Cart::content();

        return view('frontend.shopping.index', compact('products'));
    }


    public function getFormPay($user_id)
    {
        $allProducts  = Cart::content();
        // Lọc ra các sản phẩm có user_id trùng nhau

        $products = $allProducts->filter(function ($item) use ($user_id) {
            return $item->options['user_id'] == $user_id;
        });

        $user = Auth::user();

        $profile = Profile::where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        // dd($profile);

        return view('frontend.shopping.pay', compact('products', 'profile'));
    }

    public function deleteProductItem($key)
    {
        Cart::remove($key);
        toastr()->success('Xóa thành công', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->back();
    }

    public function deleteFavourite($key)
    {
        Cart::remove($key);
        toastr()->success('Hủy Giỏ hàng thành công', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->back();
    }

    public function saveInfoShoppingCart(SaveInfoShoppingCart $request)
    {
        $data = $request->except("_token", 'payment');
        $data['data_user_id'] = Auth::user()->id;
        $data['data_total_money'] = str_replace(',', '', Cart::subtotal(0, 3));
        $data['crated_at'] = Carbon::now();
        $user_id_sale_product = $request['user_id_sale_product'];
        $data['user_id_sale_product'] =  $request['user_id_sale_product'];
        // Thanh toán online payment = 2
        if ($request->payment == 2) {
            $allProducts  = Cart::content();
            // Lọc ra các sản phẩm có user_id trùng nhau
            $products = $allProducts->filter(function ($item) use ($user_id_sale_product) {
                return $item->options['user_id'] == $user_id_sale_product;
            });
            $sum = 0;
            foreach ($products as $key => $product) {
                $sum += $product->price;
            }
            $totalMoney = $sum;
            session(['info_customer' => $data]);
            return view('frontend.vnpay.index', compact('totalMoney'));
        } else {
            $totalMoney = str_replace(',', '', Cart::subtotal(0, 3));
            $transactionId = Transaction::insertGetId([
                'tr_user_id' => get_data_user('web'),
                'tr_total' => (int)$totalMoney,
                'tr_note' => $request->note,
                'tr_address' => $request->address,
                'tr_phone' => $request->phone,
                'tr_type_payment' => 1, // 0 là thanh toán online, 1 thanh toán khi nhận hàng
                'tr_user_sale' =>  $request['user_id_sale_product'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($transactionId) {
                $products = Cart::content();
                $formKeys = $request->input('key_of_product');
                foreach ($products as $key => $product) {
                    if (in_array($key, $formKeys)) {
                        Order::insert([
                            'or_transaction_id' => $transactionId,
                            'or_product_id' => $product->id,
                            'or_price' => $product->price,
                            'or_qty' => $product->qty,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                        Cart::remove($key);
                    }
                }
                $orders = Order::where('or_transaction_id', $transactionId)->get();
                if ($orders) {
                    foreach ($orders as $order) {
                        $product = Product::find($order->or_product_id);
                        $product->status = Product::STATUS_FINISH; // Cậo nhật trạng thái HIỂN THỊ
                        $product->save();
                    }
                }
            }
            toastr()->success('Đặt hàng thành công', 'Thông báo', ['timeOut' => 1000]);
            return redirect('/');
        }
    }

    public function createPayment(Request $request)
    {
        // dd($request->toArray());

        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        /**
         * Description of vnpay_ajax
         *
         * @author xonv
         */
        require_once "./vnpay_php/config.php";

        $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY

        $vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = $_POST['order_type'];
        $vnp_Amount = $_POST['amount'] * 100;
        $vnp_Locale = $_POST['language'];
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('vnpay.return'),
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        // dd($vnp_Url);
        return redirect($vnp_Url);
    }



    // Hàm này dùng cho thanh toán online và nạp tiền
    public function vnpayReturn(Request $request)
    {
        // dd($request->all());
        if (session()->has('info_customer') && $request->vnp_ResponseCode == "00") {
            DB::beginTransaction();
            try {
                $vnpayData = $request->all();
                $vnpayData['vnp_Amount'] = ($vnpayData['vnp_Amount']) / 100;
                $data = session()->get('info_customer');

                // dd($data);

                $transactionID = Transaction::insertGetId([
                    'tr_user_id' => $data['data_user_id'],
                    'tr_total' => (int)$data['data_total_money'],
                    'tr_note' => $data['note'],
                    'tr_address' => $data['address'],
                    'tr_phone' => $data['phone'],
                    'tr_type_payment' => 0, // 0 thanh toan online
                    'tr_user_sale' => $data['user_id_sale_product'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                if ($transactionID) {
                    $shopping = Cart::content();
                    $formKeys = $data['key_of_product'];

                    // Gửi mail xác nhận đặt hàng ??

                    foreach ($shopping as $key => $item) {
                        // Lưu chi tiết đơn hàng
                        if (in_array($key, $formKeys)) {
                            Order::insert([
                                'or_transaction_id' => $transactionID,
                                'or_product_id' => $item->id,
                                'or_price' => (int)$item->price,
                                'or_qty' => $item->qty,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            Cart::remove($key);
                        }
                    }
                }
                $dataPayment = [
                    'p_transaction_id' => $transactionID,
                    'p_transaction_code' => $vnpayData['vnp_TxnRef'],
                    'p_user_id' => $data['data_user_id'],
                    'p_money' => (int)$data['data_total_money'],
                    'p_note' => $vnpayData['vnp_OrderInfo'],
                    'p_vnp_response_code' => $vnpayData['vnp_ResponseCode'],
                    'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
                    'p_code_bank' => $vnpayData['vnp_BankCode'],
                    'p_time' => date('Y-m-d H:i', strtotime($vnpayData['vnp_PayDate'])),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                Payment::insert($dataPayment);
                toastr()->success('Đặt hàng thành công!', 'Thông báo', ['timeOut' => 1000]);
                DB::commit();

                return view('frontend.vnpay.vnpay_return', compact('vnpayData'));
            } catch (\Exception $exception) {
                toastr()->error('Đặt hàng thất bại!', 'Thông báo', ['timeOut' => 1000]);
                DB::rollBack();
                return redirect()->to('/');
            }
        } else {
            toastr()->error('Đã xảy ra lỗi khi thanh toán đơn hàng!', 'Thông báo', ['timeOut' => 1000]);
            return redirect()->to('/');
        }
    }
}
