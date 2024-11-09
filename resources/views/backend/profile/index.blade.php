@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Thông tin cá nhân</h2>
    </div>
    @include('backend.profile.include._inc_navbar')
    <div class="row mt-3">
        <form method="POST" action="{{ route('post_admin.profile.update', $user->id) }}" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên</label>
                    <input type="text" name="name" placeholder="Tên" class="form-control"
                        value="{{ old('name', $user->name ?? '') }}">
                    @error('name')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" name="email" disabled placeholder="Email" class="form-control"
                        value="{{ old('email', $user->email ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Số điện thoại</label>
                    <input type="number" name="phone" placeholder="0986..." class="form-control"
                        value="{{ old('phone', $user->phone ?? '') }}">
                    @error('phone')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Địa chỉ</label>
                    <input type="text" name="address" placeholder="Cần Thơ" class="form-control"
                        value="{{ old('address', $user->address ?? '') }}" />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Hình ảnh</label>
                    <input type="file" class="form-control" name="avatar">
                    @if (isset($user->avatar) && $user->avatar)
                        <img src="{{ pare_url_file($user->avatar) }}"
                            style="width: 60px;height: 60px; border-radius: 10px; margin-top: 10px" alt="">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
            </div>
        </form>

    </div>
@stop
