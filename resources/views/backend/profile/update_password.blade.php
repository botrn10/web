@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Thông tin cá nhân</h2>
    </div>
    @include('backend.profile.include._inc_navbar')
    <div class="row mt-3">
        <form method="POST" action="{{ route('post_admin.profile.update_password', $user->id) }}" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Mật khẩu mới</label>
                    <input type="password" name="password" placeholder="Mật khẩu mới" class="form-control">
                    @error('password')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Xác nhận khẩu mới</label>
                    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" class="form-control">
                    @error('password_confirmation')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password_confirmation') }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
            </div>
        </form>

    </div>
@stop
