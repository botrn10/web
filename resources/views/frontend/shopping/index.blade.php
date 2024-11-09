@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="container">
        <div class="row mt-3" style="background-color: white;">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Danh sách sản phẩm Giỏ hàng</h2>
                    <a href="/" class="btn btn-primary">Trở về</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Người bán</th>
                                <th scope="col">Giá</th>
                                {{-- <th scope="col">Số lượng</th> --}}
                                {{-- <th scope="col">Thành tiền</th> --}}
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($products as $key => $item)
                                {{-- {{dd($item->options->user_id)}} --}}
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        <img src="{{ pare_url_file($item->options->avatar) }}"
                                            style="width: 60px;height: 60px; border-radius: 10px" alt="">
                                    </td>
                                    <td scope="row"><a
                                            href="{{ route('get.product.by_slug', ['slug' => $item->options->slug]) }}">{{ $item->name }}</a>
                                    </td>
                                    <td><img src="{{ pare_url_file($item->options->user_avatar) }}"
                                            style="width: 40px;height: 40px; border-radius: 10px"
                                            alt=""> {{ $item->options->user_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($item->price) }} đ</td>
                                    {{-- <td>{{ $item->qty }}</td> --}}
                                    {{-- <td>{{ number_format($item->qty * $item->price) }} đ</td> --}}
                                    <td>
                                        <a href="{{ route('get.deleteProductItem', $key) }}"><i class="fa fa-trash"></i>
                                            Xóa </a>
                                        <a href="{{ route('get.getFormPay', $item->options->user_id) }}"><i
                                                class="fa-brands fa-amazon-pay"></i>
                                            Thanh
                                            toán</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop
