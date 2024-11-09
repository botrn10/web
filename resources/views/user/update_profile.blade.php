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
        <div class="row">
            <div class="col-lg-5">
                <form method="POST" action="" enctype="multipart/form-data">
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
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" placeholder="Tên " class="form-control"
                                    value="{{ old('name', $user->name ?? '') }}">
                                @error('name')
                                    <small id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone</label>
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
            </div>
            <div class="col-lg-5">
                {{-- <div class="form-group">
                    <label for="exampleInputEmail1">Tỉnh thành</label>
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
                    <label for="exampleInputEmail1">Quận huyện</label>
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
                    <label for="exampleInputEmail1">Phường xã</label>
                    <select name="ward_id" class="form-control" id="wardData">
                        <option value="">---Chọn---</option>
                        @foreach ($activeWards ?? [] as $key => $item)
                            <option value="{{ $key }}" selected>{{ $item }}</option>
                        @endforeach
                    </select>
                    @error('ward_id')
                        <small id="" class="form-text text-danger">{{ $errors->first('ward_id') }}</small>
                    @enderror
                </div> --}}
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Danh sách địa chỉ</h4>
                    <a href="#" class="btn btn-primary mb-2" style="color: white;">Thêm mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Địa chỉ</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profiles ?? [] as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <span> {{ $item->province->name ?? '...' }} - {{ $item->district->name ?? '...' }} -
                                            {{ $item->ward->name ?? '...' }}</span>
                                    </td>
                                    <td>
                                        Xóa, cập nhật
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
