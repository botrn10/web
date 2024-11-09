@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Cập nhật email login</h2>
    </div>
    @include('backend.profile.include._inc_navbar')
    <div class="row mt-3">
        <form method="POST" action="" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email mới</label>
                    <input type="email" name="email" placeholder="lmthang@gmail.com" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <small id="" class="form-text text-danger">{{ $errors->first('email') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Mã OTP</label>
                    <div class="d-flex align-items-center">
                        <input type="text" name="code" placeholder="123456" class="form-control">
                        <a href=""  class="ml-1 js-send-otp" data-email="{{ $user->email }}" style="width: 100px;">Gủi OTP</a>
                    </div>
                    @error('code')
                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('code') }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
            </div>
        </form>

    </div>
@stop
