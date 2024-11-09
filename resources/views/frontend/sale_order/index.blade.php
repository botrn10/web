@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="container">
        <div class="row mt-3" style="background-color: white;">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Đơn hàng đã bán</h2>
                    <a href="/" class="btn btn-primary">Trở về</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
                                <th>Người mua</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions_sale ?? [] as $transaction)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>DH{{ $transaction->id ?? 'NA' }}</td>
                                    <td>{{ $transaction->user->name ?? 'NA_product' }}</td>
                                    <td>{{ number_format($transaction->tr_total, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        @if ($transaction->tr_status == 1)
                                            <span class="badge badge-warning">
                                                <a href="{{ route('get.user.transaction.shipping', $transaction->id) }}"
                                                    style="text-decoration: none; color: white">Đã xử lý</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-regular fa-pen-to-square fa-3 icon"></i>
                                            </span>
                                        @elseif ($transaction->tr_status == 2)
                                            <span class="badge badge-primary">
                                                <a href="{{ route('get.user.transaction.finish', $transaction->id) }}"
                                                    style="text-decoration: none; color: white">Đang vận
                                                    chuyển</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-regular fa-pen-to-square fa-3 icon"></i>
                                            </span>
                                        @elseif ($transaction->tr_status == 3)
                                            <span class="badge badge-success">
                                                <a href="#" style="text-decoration: none; color: white">Đã giao</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-solid fa-check"></i></span>
                                        @elseif($transaction->tr_status == -1)
                                            <span class="badge badge-danger">
                                                <a href="#" style="text-decoration: none; color: white">Đã hủy</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-solid fa-check"></i></span>
                                        @elseif($transaction->tr_status == 4)
                                            <span class="badge badge-success">
                                                <a href="#" style="text-decoration: none; color: white">Đã nhận
                                                    hàng</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-solid fa-check"></i></span> <br>
                                            <span class="badge badge-success">
                                                <a href="#" style="text-decoration: none; color: white">Đã nhận tiền</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-solid fa-check"></i></span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <a href="{{ route('get.user.transaction.active', $transaction->id) }}"
                                                    style="text-decoration: none; color: white">Chờ xử lý</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-regular fa-pen-to-square fa-3 icon"></i>
                                            </span>
                                            <span class="badge badge-danger">
                                                <a href="{{ route('get.user.transaction.cancel', $transaction->id) }}"
                                                    style="text-decoration: none; color: white">Hủy</a>
                                            </span>
                                            <span class="justify-content-start">
                                                <i class="fa-regular fa-pen-to-square fa-3 icon"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->payment)
                                            <ul>
                                                <li>Ngân hàng: {{ $transaction->payment->p_code_bank }}</li>
                                                <li>Mã thanh toán: {{ $transaction->payment->p_code_vnpay }}</li>
                                                <li>Tổng tiền:
                                                    {{ number_format($transaction->payment->p_money, 0, ',', '.') }} VNĐ
                                                </li>
                                                <li>Nội dung: {{ $transaction->payment->p_note }}</li>
                                                <li>Thời gian:
                                                    {{ date('d-m-Y H:i', strtotime($transaction->payment->p_time)) }}
                                                </li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li>Thanh toán khi nhận hàng</li>
                                            </ul>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('get.user.transaction.viewOrder', $transaction->id) }}"
                                            class="js_order_item" data-toggle="modal" data-id="{{ $transaction->id }}"
                                            data-target="#myModelOrder" style="padding: 5px" id=""><i
                                                class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $transactions_sale->links() }}

    <div class="modal fade" id="myModelOrder" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết đơn hàng #<b class="transaction_id"></b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="md_content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@stop
