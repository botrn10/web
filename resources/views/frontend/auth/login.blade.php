@extends('frontend.layouts.app_frontend')
@section('title_page', 'Đăng nhập')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="/">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Đăng nhập</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" placeholder="Tên" class="form-control"
                                    value="{{ old('email', $user->email ?? '') }}">
                                @error('email')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" name="password" placeholder="Mật khẩu" class="form-control"
                                    value="">
                                @error('password')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p>Bạn chưa có tài khoản? đăng ký <a href="{{ route('get.register') }}">tại đây</a></p>
                                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@stop
