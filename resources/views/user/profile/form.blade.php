<form method="POST" id="alert_form_submit" action="" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tỉnh thành</label>
        <select name="province_id" class="form-control" id="loadDistrict">
            <option value="">---Chọn---</option>
            @foreach ($provinces ?? [] as $item)
                <option value="{{ $item->id }}" {{ ($profile->province_id ?? 0) == $item->id ? 'selected' : '' }}>
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
    </div>
    <div class="form-group">
        <label for="">Địa chỉ cụ thể</label>
        <input type="text" name="address_detail" placeholder="Địa chỉ cụ thể" class="form-control"
            value="{{ old('address_detail', $profile->address_detail ?? '') }}">
        @error('address_detail')
            <small id="" class="form-text text-danger">{{ $errors->first('address_detail') }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Mặc định địa chỉ giao hàng <input type="checkbox" name="status" value="1"
                {{ (isset($profile) && $profile->status == 1) ? 'checked' : '' }}></label>
    </div>
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
    </div>
</form>
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
