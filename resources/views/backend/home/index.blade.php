@extends('backend.layouts.app_backend')
@section('content')
    <h2>Tổng quan</h2>
    <div class="row mt-3">
        <div class="col-sm-3">
            <div class="box p-3 mb-2 bg-primary text-white rounded text-center">
                <a href="{{ route('get_admin.user.index') }}" class="text-decoration-none">
                    <h5 class="text-white">Thành viên <b>{{ $toltalUsers }}</b></h5>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="box p-3 mb-2 bg-danger text-white rounded text-center">
                <a href="{{ route('get_admin.product.index') }}" class="text-decoration-none">
                    <h5 class="text-white">Sản phẩm <b>{{ $toltalProduct }}</b></h5>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="box p-3 mb-2 bg-info text-white rounded text-center">
                <a href="{{ route('get_admin.category.index') }}" class="text-decoration-none">
                    <h5 class="text-white">Danh mục <b>{{ $toltalCategory }}</b></h5>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="box p-3 mb-2 bg-success text-white rounded text-center">
                <a href="{{ route('get_admin.transaction.index') }}" class="text-decoration-none">
                    <h5 class="text-white">Đơn hàng <b>{{ $toltalOrder }}</b></h5>
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h4>Thống kê</h4>
        <div class="row mt-3">
            <div class="col">
                @include('backend.home.form')
            </div>
            <div class="col-md-12">
                <div id="chart" style="height: 250px;"></div>
            </div>
        </div>
    </div>
@stop
