@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Sản phẩm</h2>
        <a href="{{ route('get_admin.product.create') }}" class="btn btn-primary" style="color: white;">Thêm mới</a>
    </div>
    <div>
        <form class="form-inline">
            <div class="form-group mb-2 mr-2">
                <label for="" class="sr-only">Tên</label>
                <input type="text" name="n" class="form-control" value="{{ Request::get('n') }}"
                    placeholder="Nhập tên sản phẩm ">
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
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Avatar</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Người đăng</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    {{-- <th>Mô tả</th> --}}
                    {{-- <th>Ngày tạo</th> --}}
                    <th>Thao tác</th>
                    {{-- <th>Chỉnh sửa</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($products ?? [] as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            <a href="" style="display: inline-block; position: relative;">
                                <img src="{{ pare_url_file($item->avatar) }}"
                                    style="width: 60px; height: 60px; border-radius: 10px" alt="">
                                <span class="badge badge-danger"
                                    style="position: absolute; right: 10px; top: 10px;">{{ $item->images_count }}</span>
                            </a>

                        </td>
                        <td>
                            {{ $item->name }} <br>
                            <span> {{ $item->province->name ?? '...' }} - {{ $item->district->name ?? '...' }} -
                                {{ $item->ward->name ?? '...' }}</span>
                        </td>
                        <td>{{ $item->category->name ?? '[N\A]' }}</td>
                        <td>{{ $item->user->name ?? '[N\A]' }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                        <td>
                            <span class="{{ $item->getStatus($item->status)['class'] ?? 'badge badge-light' }}">
                                {{ $item->getStatus($item->status)['name'] ?? 'Tạm dừng' }}
                            </span>
                        </td>
                        <td>
                            <div class="product-more position-relative">
                                <span class="justify-content-start">
                                    <i class="fa-regular fa-pen-to-square fa-xl icon"></i>
                                </span>
                                <div class="product-more-option">
                                    <ul class="mb-0" style="list-style: none;padding-left: 0px;">
                                        <li>
                                            <a href="{{ route('get_admin.product.viewDetailProduct', $item->id) }}"
                                                class="d-flex align-items-center p-2 text-decoration-none js_detail_product_item"
                                                data-toggle="modal" data-id="{{ $item->id }}"
                                                data-target="#myModelDetailProduct" style="padding: 5px" id="">
                                                <p><i class="fa-regular fa-eye"></i> - Xem chi tiết</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_admin.product.update', $item->id) }}"
                                                class="d-flex align-items-center p-2 text-decoration-none">
                                                <p><i class="fa-solid fa-pen"></i> - Cập nhật</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_admin.product.delete', $item->id) }}"
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
    
    {{ $products->links() }}

    <div class="modal fade" id="myModelDetailProduct" role="dialog">
        <div class="modal-dialog modal-xl">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="md_content_detail_product">
                    {{-- Dùng js qua --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@stop
