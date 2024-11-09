@extends('frontend.layouts.app_frontend')
@section('title_page', 'Đăng ký')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="#">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Đăng ký</span>
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
                                <label for="">Tên <span style="color: red">*</span></label>
                                <input type="text" name="name" placeholder="Tên" class="form-control"
                                    value="{{ old('name', $user->name ?? '') }}">
                                @error('name')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Email <span style="color: red">*</span></label>
                                <input type="email" name="email" placeholder="Tên" class="form-control"
                                    value="{{ old('email', $user->email ?? '') }}">
                                @error('email')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Password <span style="color: red">*</span></label>
                                <input type="password" name="password" placeholder="Mật khẩu" class="form-control"
                                    value="">
                                @error('password')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Số điện thoại <span style="color: red">*</span></label>
                                <input type="number" name="phone" placeholder="0869......" class="form-control"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                                @error('phone')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hình ảnh</label>
                                <input type="file" class="form-control" name="avatar">
                                @if (isset($user->avatar) && $user->avatar)
                                    <img src="{{ pare_url_file($user->avatar) }}"
                                        style="width: 60px; height: 60px; border-radius: 10px; margin-top: 10px"
                                        alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <p>Bạn đã có tài khoản? đăng nhập <a href="{{ route('get.login') }}">tại đây</a></p>
                                <button type="submit" class="btn btn-primary">Đăng ký</button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="">Tỉnh thành <span style="color: red">*</span></label>
                    <select name="province_id" class="form-control" id="loadDistrict">
                        <option value="">---Chọn---</option>
                        @foreach ($provinces ?? [] as $item)
                            <option value="{{ $item->id }}"
                                {{ ($product->province_id ?? 0) == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <small id="" class="form-text text-danger">{{ $errors->first('province_id') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Quận huyện <span style="color: red">*</span></label>
                    <select name="district_id" class="form-control" id="districtsData">
                        <option value="">---Chọn---</option>
                        @foreach ($activeDistricts ?? [] as $key => $item)
                            <option value="{{ $key }}" selected>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('district_id')
                        <small id="" class="form-text text-danger">{{ $errors->first('district_id') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Phường xã <span style="color: red">*</span></label>
                    <select name="ward_id" class="form-control" id="wardData">
                        <option value="">---Chọn---</option>
                        @foreach ($activeWards ?? [] as $key => $item)
                            <option value="{{ $key }}" selected>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('ward_id')
                        <small id="" class="form-text text-danger">{{ $errors->first('ward_id') }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ cụ thể</label>
                    <input type="text" name="address_detail" placeholder="Địa chỉ cụ thể" class="form-control"
                        value="{{ old('address_detail', $user->address_detail ?? '') }}">
                    @error('ward_id')
                        <small id="" class="form-text text-danger">{{ $errors->first('address_detail') }}</small>
                    @enderror
                </div>
            </div>
            </form>
        </div>
    </div>
@stop

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        $("#loadDistrict").change(function() {
            console.log("------LOAD quận huyện----------");
            let province_id = $(this).find(":selected").val();
            console.log("------province_id: ", province_id);

            $.ajax({
                    url: "/account/location/district",
                    data: {
                        province_id: province_id
                    },
                    beforeSend: function(xhr) {
                        // xhr.overrideMimeType("text/plain; charset=x-user-defined");
                    }
                })
                .done(function(data) {
                    console.log("------Data: ", data);

                    let dataOptions = `<option value="">---Chọn quận huyện---</option>`;
                    data.map(function(index, key) {
                        dataOptions += `<option value=${index.id}>${index.name}</option>`
                    });
                    $("#districtsData").html(dataOptions);
                });
        });

        $("#districtsData").change(function() {
            let district_id = $(this).find(":selected").val();

            $.ajax({

                    url: "/account/location/ward",
                    data: {

                        district_id: district_id
                    },
                    beforeSend: function(xhr) {
                        // xhr.overrideMimeType("text/plain; charset=x-user-defined");
                    }
                })
                .done(function(data) {
                    // console.log("------Data: ", data);

                    let dataOptions = `<option value="">---Chọn phường xã---</option>`;
                    data.map(function(index, key) {
                        dataOptions += `<option value=${index.id}>${index.name}</option>`
                    });
                    $("#wardData").html(dataOptions);
                });
        });
    })
</script>
