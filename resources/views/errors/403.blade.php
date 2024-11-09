@extends('backend.layouts.app_backend')
@section('content')
    <div class="alert alert-warning" role="alert">
        Bạn không có quyền truy cập <a href="{{ route('get_admin.home') }}">trở về trang chủ</a>
    </div>
@stop
