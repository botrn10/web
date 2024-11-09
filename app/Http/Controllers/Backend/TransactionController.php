<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user:id,name', 'payment', 'userSale:id,name');

        // dd($transactions);
        if ($name = $request->n) // Tìm bằng tên
            $transactions->where('tr_phone', 'like', '%' . $name . '%');

        $transactions = $transactions
            ->orderByDesc('id')
            ->paginate(10);

        $viewData = [
            'transactions' => $transactions,
        ];
        return view('backend.transaction.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function viewOrder(Request $request, $id)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $orders = Order::with('product', 'transaction')->where('or_transaction_id', $id)->get();

            $html = view('backend.components.order', compact('orders'))->render();

            return \response()->json($html);
        }
    }

    public function actionTransaction($id)
    {
        $transaction = Transaction::find($id);
        $orders = Order::where('or_transaction_id', $id)->get();

        if ($orders) {
            foreach ($orders as $order) {
                $product = Product::find($order->or_product_id);
                $product->status = Product::STATUS_FINISH; // Cậo nhật trạng thái ĐÃ BÁN
                $product->save();
            }
        }
        $transaction->tr_status = Transaction::STATUS_DONE; // Cập nhật trạng thái đơn hàng ĐÃ XỬ LÝ
        $transaction->save();

        toastr()->success('Xử lý thành công!', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->back();

    }
}
