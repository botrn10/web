@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Thanh toán</h2>
                </div>
                <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"
                    id="bootstrap-css">

                <div class="cart-body">
                    <form class="form-horizontal" method="post" action="">
                        @csrf
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                            <!--REVIEW ORDER-->

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Sản phẩm <div class="pull-right"><small><a class="afix-1"
                                                href="{{ route('get.listaddProduct') }}">Trờ về</a></small></div>
                                </div>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($products as $key => $product)
                                    <input type="hidden" name="key_of_product[]" class="form-control"
                                        value="{{ $key }}" />
                                    <input type="hidden" name="user_id_sale_product" class="form-control"
                                        value="{{ $product->options->user_id }}" />

                                    {{-- {{dd($product->options)}} --}}

                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-xs-3">
                                                <img class="img-responsive"
                                                    src="{{ pare_url_file($product->options->avatar) }}"
                                                    style="width: 60px;height: 60px; border-radius: 10px" />
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <div class="col-xs-12">{{ $product->name }}</div>
                                                <div class="col-xs-12"><small>Số lượng x
                                                        <span>{{ $product->qty }}</span></small></div>
                                            </div>
                                            <div class="col-sm-3 col-xs-3 text-right">
                                                <h6>{{ number_format($product->price, 0, ',', '.') }} <span>VNĐ</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                    @php $sum += $product->price; @endphp
                                @endforeach
                                <div class="form-group mr-2 ml-2">
                                    <div class="col-xs-12">
                                        <strong>Tổng tiền thanh toán</strong>
                                        <div class="pull-right"><span>{{ number_format($sum) }}</span>
                                            <span>VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--REVIEW ORDER END-->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                            <!--SHIPPING METHOD-->
                            <div class="panel panel-info">
                                <div class="panel-heading">Thông tin thanh toán</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-6"><strong>Địa chỉ:</strong>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('get.user.update_profile') }}">Thay đổi</a>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="text" name="address" class="form-control"
                                                value="{{ $profile->address_detail ?? '' }} - {{ $profile->ward->name ?? '...' }} - {{ $profile->district->name ?? '...' }} - {{ $profile->province->name ?? '...' }}" />

                                            @error('address')
                                                <small id="emailHelp"
                                                    class="form-text text-danger">{{ $errors->first('address') }}</small>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12"><strong>Email:</strong></div>
                                        <div class="col-md-12">
                                            <input type="text" name="email" class="form-control"
                                                value="{{ get_data_user('web', 'email') }}" />
                                            @error('email')
                                                <small id="emailHelp"
                                                    class="form-text text-danger">{{ $errors->first('email') }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12"><strong>Số điện thoại: </strong></div>
                                        <div class="col-md-12"><input type="text" name="phone" class="form-control"
                                                value="{{ get_data_user('web', 'phone') }}" />
                                            @error('phone')
                                                <small id="phoneHelp"
                                                    class="form-text text-danger">{{ $errors->first('phone') }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12"><strong>Ghi chú:</strong></div>
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="note" id="" cols="30" rows="4"></textarea>
                                        </div>
                                         @error('note')
                                                <small id="noteHelp"
                                                    class="form-text text-danger">{{ $errors->first('note') }}</small>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12"></div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Thanh toán khi nhận hàng</button>
                                            <button type="submit" name="payment" value="2"
                                                class="btn btn-primary">Thanh toán online</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--SHIPPING METHOD END-->
                            <!--CREDIT CART PAYMENT-->
                        </div>
                    </form>
                </div>
                <div class="row cart-footer">
                </div>
            </div>
            {{-- JS --}}
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        </div>
    </div>
@stop
