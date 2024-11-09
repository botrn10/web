@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Tài khoản</h2>
        <a href="{{ route('get_admin.user.create') }}" class="btn btn-primary" style="color: white;">Thêm mới</a>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <form class="form-inline">
            <div class="form-group mb-2 mr-2">
                <label for="" class="sr-only">Tên</label>
                <input type="text" name="n" class="form-control" value="{{ Request::get('n') }}"
                    placeholder="Nhập tên thành viên">
            </div>

            <div class="form-group mb-2 mr-2">
                <label for="" class="sr-only">Trạng thái</label>
                <select name="status" class="form-control" id="">
                    <option value="">-- Chọn trạng thái --</option>
                    @foreach ($status ?? [] as $key => $item)
                        <option value="{{ $key }}" {{ (Request::get('status') ?? 0) == $key ? 'selected' : '' }}>
                            {{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
        </form>
        <a href="{{ route('get_admin.user.indexUserNotLogin') }}" class="btn btn-danger" style="color: white;">Danh sách
            không hoạt động</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Avatar</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>Type</th>
                    <th>Đăng nhập lần cuối</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users ?? [] as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            <img src="{{ pare_url_file($item->avatar) }}"
                                style="width: 60px; height: 60px; border-radius: 50%" alt="">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <span class="{{ $item->getStatus($item->status)['class'] ?? 'badge badge-light' }}">
                                {{ $item->getStatus($item->status)['name'] ?? 'Tạm dừng' }}
                            </span>
                        </td>
                        <td>
                            @if (isset($item->userType) && !$item->userType->isEmpty())
                                @foreach ($item->userType as $type)
                                    <span>{{ $type->name }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $item->last_login_at ?? 'NA' }}</td>
                        {{-- <td>
                        <a href="{{ route('get_admin.user.update', $item->id) }}" class="btn btn-info" style="padding: 5px">Edit</a>
                        <a href="#">|</a>
                        <a href="{{ route('get_admin.user.delete', $item->id) }}" class="btn btn-danger" style="padding: 5px" id="delete_alert" >Delete</a>
                        </td> --}}
                        <td>
                            <div class="product-more position-relative">
                                <span class="justify-content-start">
                                    <i class="fa-regular fa-pen-to-square fa-xl icon"></i>
                                </span>
                                <div class="product-more-option">
                                    <ul class="mb-0" style="list-style: none;padding-left: 0px;">
                                        <li>
                                           
                                        </li>
                                        <li>
                                            <a href="{{ route('get_admin.user.update', $item->id) }}"
                                                class="d-flex align-items-center p-2 text-decoration-none">
                                                <p><i class="fa-solid fa-pen"></i> - Cập nhật</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_admin.user.delete', $item->id) }}"
                                                class="d-flex align-items-center p-2 text-decoration-none"
                                                id="delete_alert">
                                                <p><i class="fa-regular fa-trash-can"></i> - Xóa</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@stop
