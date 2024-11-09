<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class PermissionController extends Controller
{
    // Coppy Category
    public function index(){

        $permissions = Permission::orderByDesc('id')->paginate(10); // Phân trang 20 dòng

        $viewData = [
            'permissions' => $permissions
        ];
        return view('backend.permission.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){
        return view('backend.permission.create');
    }

    public function store(PermissionRequest $request){
        // dd($request->all());
        try {

            $data = $request->except('_token'); // Lấy dữ liệu từ $request gửi lên trừ _token và avatar
            $data['created_at'] = Carbon::now();

            Permission::create($data);
        } catch (\Exception $exception) {
            Log::error("ERROR => PermissionController@store => ". $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.permission.index');
        }
        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.permission.index');
    }

    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('backend.permission.update', compact('permission')); // compact(): Tạo mảng với giá trị 'category'
    }

    public function update(PermissionRequest $request, $id){
        try {
            $data = $request->except('_token');
            $data['updated_at'] = Carbon::now();

            Permission::find($id)->update($data);
        } catch (\Exception $exception) {
            Log::error("ERROR => PermissionController@store => ". $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.permission.update', $id);
        }
        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.permission.index');
    }

    public function delete(Request $request, $id){
        try {
            $permission = Permission::findOrFail($id);
            if($permission) $permission->delete();

        } catch (\Exception $exception) {
            Log::error("ERROR => PermissionController@delete => ". $exception->getMessage());
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);

        }
        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.permission.index');
    }
}
