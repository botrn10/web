@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
               
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="background-color: white;">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Lịch sử nạp tiền</h2>
                    <a href="/" class="btn btn-primary">Trở về</a>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã giao dịch</th>
                                <th>Khách hàng</th>
                                <th>Số tiền</th>
                                <th>Thanh toán</th>
                                <th>Ngày nạp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recharges ?? [] as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>MGD{{ $item->id ?? 'NA' }}</td>
                                    <td>{{ $item->user->name ?? '[N\A]' }}</td>
                                    <td> {{ number_format($item->total_money ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($item->payment)
                                            <ul>
                                                <li>Ngân hàng: {{ $item->payment->p_code_bank }}</li>
                                                <li>Mã thanh toán: {{ $item->payment->p_code_vnpay }}</li>
                                                <li>Tổng tiền:
                                                    {{ number_format($item->payment->p_money, 0, ',', '.') }} VNĐ
                                                </li>
                                                <li>Nội dung: {{ $item->payment->p_note }}</li>
                                                <li>Thời gian:
                                                    {{ date('d-m-Y H:i', strtotime($item->payment->p_time)) }}
                                                </li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li>Thanh toán khi nhận hàng</li>
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at ?? '[N\A]' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $recharges->links() }}
            </div>
        </div>
    </div>

@stop
