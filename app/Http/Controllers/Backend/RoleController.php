<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){

        $roles = Role::orderByDesc('id')->paginate(10); // Phân trang 20 dòng

        $viewData = [
            'roles' => $roles
        ];
        return view('backend.role.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){

        $permissions = Permission::all();

        $permissionActive = [];

        return view('backend.role.create', compact('permissions', 'permissionActive'));
    }

    public function store(RoleRequest $request){
        // dd($request->all());
        try {
            $data = $request->except('_token', 'permissions');
            $data['created_at'] = Carbon::now();

            $role = Role::create($data);

            if ($role && !empty($request->permissions))
                $role->givePermissionTo($request->permissions);

        } catch (\Exception $exception) {
            Log::error("ERROR => RoleController@store => ". $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.role.index');
        }
        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.role.index');
    }

    public function edit($id){

        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        $permissionActive = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id')->toArray(); // Hiển thị role ở user
        // dd($permissionActive);

        return view('backend.role.update', compact('role', 'permissions', 'permissionActive'));
    }

    public function update(RoleRequest $request, $id){
        try {
            $data = $request->except('_token', 'permissions');
            $data['updated_at'] = Carbon::now();

            $update = Role::find($id)->update($data);
            
            //     dd($request->permissions);

            if ($update && !empty($request->permissions))
            {
                $role = Role::find($id);

                $permissionActive = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id')->toArray();
                if ($permissionActive) {
                    foreach ($permissionActive as $item)
                        $role->revokePermissionTo($item); // Xoá tất cả permission đã ép role hiện tại
                }

                $role->givePermissionTo($request->permissions); // Thêm mới MẢNG [] https://spatie.be/docs/laravel-permission/v5/advanced-usage/seeding
            }

        } catch (\Exception $exception) {
            Log::error("ERROR => RoleController@update => ". $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.role.update', $id);
        }
        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.role.index');
    }

    public function delete(Request $request, $id){
        try {
            $role = Role::findOrFail($id);
            if($role) $role->delete();

        } catch (\Exception $exception) {
            Log::error("ERROR => RoleController@delete => ". $exception->getMessage());
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
        }
        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.role.index');
    }
}
