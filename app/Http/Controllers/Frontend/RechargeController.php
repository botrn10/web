<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveInfoRecharge;
use App\Models\Payment;
use App\Models\Recharge;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RechargeController extends Controller
{
    public function index()
    {
        return view('frontend.recharge.index');
    }

    public function indexAdmin()
    {
        $recharges = Recharge::with('user:id,name');

        $recharges = $recharges
            ->orderByDesc('id')
            ->paginate(10);

        $viewData = [
            'recharges' => $recharges,
            // 'category' => $category,

        ];

        return view('backend.recharge.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    // Xem lịch sử nạp tiền
    public function indexOfUser()
    {
        $user_id = Auth::user()->id;

        $recharges = Recharge::with('payment')->where('user_id', $user_id)->paginate(4);;

        $viewData = [
            'recharges' => $recharges,
        ];
        return view('frontend.recharge.indexOfUser', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function saveInfoRecharge(SaveInfoRecharge $request)
    {
        $data = $request->except("_token", 'payment');
        $data['crated_at'] = Carbon::now();

        // dd( $request->all());

        $totalMoney = $request->total_money;

        session(['info_customer' => $data]);

        return view('frontend.vnpay.indexRecharge', compact('totalMoney'));
    }

    public function createRechargePayment(Request $request)
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
            "vnp_ReturnUrl" => route('vnpay.recharge.return'),
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

    // Sau khi nhập mã xác nhận
    public function vnpayRechargeReturn(Request $request)
    {
        // dd($request->all());
        if (session()->has('info_customer') && $request->vnp_ResponseCode == "00") {
            DB::beginTransaction();
            try {
                $vnpayData = $request->all();
                $vnpayData['vnp_Amount'] = ($vnpayData['vnp_Amount']) / 100;
                $data = session()->get('info_customer');

                $rechargeID = Recharge::insertGetId([
                    'user_id' => $data['user_id'],
                    'total_money' => (int)$data['total_money'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                if ($rechargeID) {

                    $user = User::find($data['user_id']);
                    $newTotalMoney = $user->total_money + (int)$vnpayData['vnp_Amount'];

                    User::where('id', $data['user_id'])->update(['total_money' => $newTotalMoney]);
                }

                $dataPayment = [
                    'p_transaction_id' => $rechargeID,
                    'p_transaction_code' => $vnpayData['vnp_TxnRef'],
                    'p_user_id' => $data['user_id'],
                    'p_money' => (int)$data['total_money'],
                    'p_note' => $vnpayData['vnp_OrderInfo'],
                    'p_vnp_response_code' => $vnpayData['vnp_ResponseCode'],
                    'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
                    'p_code_bank' => $vnpayData['vnp_BankCode'],
                    'p_time' => date('Y-m-d H:i', strtotime($vnpayData['vnp_PayDate'])),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                Payment::insert($dataPayment);
                
                toastr()->success('Nạp tiền hàng thành công!', 'Thông báo', ['timeOut' => 1000]);
                DB::commit();
                return view('frontend.vnpay.vnpay_return', compact('vnpayData'));
            } catch (\Exception $exception) {
                toastr()->error('Nạp tiền thất bại!', 'Thông báo', ['timeOut' => 1000]);
                DB::rollBack();
                return redirect()->to('/');
            }
        } else {
            toastr()->error('Đã xảy ra lỗi khi thanh toán đơn hàng!', 'Thông báo', ['timeOut' => 1000]);
            return redirect()->to('/');
        }
    }
}
