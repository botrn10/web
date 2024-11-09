<form method="POST" action="" id="alert_form_submit" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên</label>
        <input type="text" name="name" placeholder="Tên" class="form-control"
            value="{{ old('name', $role->name ?? '') }}">
        @error('name')
            <small id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mô tả</label>
        <input type="text" name="description" placeholder="Mô tả" class="form-control"
            value="{{ old('description', $role->description ?? '') }}">
        @error('description')
            <small id="emailHelp" class="form-text text-danger">{{ $errors->first('description') }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Guard Name</label>
        <input type="text" name="guard_name" placeholder="" class="form-control"
            value="{{ old('guard_name', $role->guard_name ?? 'web') }}">
        @error('guard_name')
            <small id="emailHelp" class="form-text text-danger">{{ $errors->first('guard_name') }}</small>
        @enderror
   
    <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
</form>
