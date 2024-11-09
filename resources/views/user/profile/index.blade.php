@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="#">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Cập nhật thông tin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="background-color: white;">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Thông tin cá nhân</h2>
                    <a href="/" class="btn btn-primary">Trở về</a>
                </div>
            </div>
            <div class="col-lg-5">
                <form method="POST" id="alert_form_submit" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input disabled type="text" name="email" placeholder="Địa chỉ email"
                                    class="form-control" value="{{ old('email', $user->email ?? '') }}">
                                @error('email')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input type="text" name="name" placeholder="Tên " class="form-control"
                                    value="{{ old('name', $user->name ?? '') }}">
                                @error('name')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="number" name="phone" placeholder="0869 . . . " class="form-control"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                                @error('phone')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Avatar</label>
                                <input type="file" name="avatar" class="form-control">
                                @if (isset($user->avatar) && $user->avatar)
                                    <img src="{{ pare_url_file($user->avatar) }}"
                                        style="width: 60px;height: 60px; border-radius: 10px; margin-top: 10px"
                                        alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách địa chỉ</h4>
                    <a href="{{ route('get.user.update_profile.create-address') }}" class="btn btn-primary mb-2 mt-xl-5"
                        style="color: white;">Thêm mới địa chỉ</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Địa chỉ</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($profiles ?? [] as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <span>{{ "$item->address_detail" ?? '' }} {{ $item->ward->name ?? '...' }}
                                            - {{ $item->district->name ?? '...' }} -
                                            {{ $item->province->name ?? '...' }}</span>
                                    </td>
                                    <td>{{ $item->status == 1 ? 'Mặt định' : '' }}</td>
                                    <td>
                                        {{-- <a href="#"><span class="badge bg-danger text-white">Xóa</span></a> --}}
                                        <a href="{{ route('get.address_update', $item->id) }}"><span
                                                class="badge bg-success text-white">Cập nhật</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
