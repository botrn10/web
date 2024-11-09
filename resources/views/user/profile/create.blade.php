@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="#">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Cập nhật thông tin địa chỉ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="background-color: white;">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Thêm mới địa chỉ</h4>
                    <a href="{{ route('get.user.update_profile') }}" class="btn btn-primary mt-3" style="color: white;">Trở
                        về</a>
                </div>
                @include('user.profile.form')
            </div>
        </div>
    </div>
@stop
