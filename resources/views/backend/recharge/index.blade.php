@extends('backend.layouts.app_backend')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Danh sách nạp tiền</h2>
        {{-- <a href="#" class="btn btn-primary" style="color: white;">Thêm mới</a> --}}
    </div>
    <div>
        {{-- <form class="form-inline">
            <div class="form-group mb-2 mr-2">
                <label for="" class="sr-only">Tên</label>
                <input type="text" name="n" class="form-control" value="{{ Request::get('n') }}" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
        </form> --}}
    </div>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã giao dịch</th>
                        <th>Khách hàng</th>
                        <th>Số tiền</th>
                        <th>Ngày nạp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recharges ?? [] as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>MGD{{ $item->id ?? 'NA' }}</td>
                            <td>{{ $item->user->name ?? '[N\A]' }}</td>
                            <td> {{ number_format($item->total_money ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item->created_at ?? '[N\A]' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $recharges->links() }}

@stop
