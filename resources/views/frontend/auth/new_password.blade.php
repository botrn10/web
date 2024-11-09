@extends('frontend.layouts.app_frontend')
@section('title_page', 'Xác nhận - cập nhật tài khoản')
@section('content')
<div class="breadcrumb-wrapper">
    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb">
                    <a href="#">Tài khoản</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
               
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
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" placeholder="Mật khẩu" class="form-control"
                                value="">
                            @error('password')
                                <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" name="password_confirmation" placeholder="Mật khẩu" class="form-control"
                                value="">
                            @error('password_confirmation')
                                <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password_confirmation') }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kích hoạt</button>
                    </div>
              </form>
        </div>
    </div>
</div>
@stop