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
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" placeholder="lmthang@gmail.com" class="form-control"
                                value="">
                            @error('email')
                                <small id="" class="form-text text-danger">{{ $errors->first('email') }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Xác nhận thông tin</button>
                    </div>
              </form>
        </div>
    </div>
</div>
@stop