@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Thêm mới</h2>
        <a href="{{ route('get_admin.article.index') }}" class="btn btn-dark">Trở về</a>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="container">
                @include('backend.article.form')
            </div>
        </div>
    </div>
@stop
