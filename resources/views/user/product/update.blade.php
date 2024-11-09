@extends('frontend.layouts.app_frontend')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcumb">
                    <a href="/">Trang chủ</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                    <a href="{{ route('get.user.product_index') }}">Sản phẩm</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                    <span>Cập nhật</span>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #fff;">
            <div class="col-md-12">
                <div class="container">
                    <div class="d-flex justify-content-start align-items-center mt-2">
                        <a href="/" class="btn btn-primary ml-auto">Trở về</a>
                    </div>
                    @include('user.product.form')
                </div>
            </div>
        </div>
    </div>
@stop
