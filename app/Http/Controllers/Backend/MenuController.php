<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    public function index(){
        $menus = Menu::orderByDesc('id')->paginate(10); // Phân trang 20 dòng
        $viewData = [
            'menus' => $menus
        ];
        return view('backend.menu.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){
        return view('backend.menu.create');
    }

    public function store(MenuRequest $request){
        // dd($request->all());
        try {
            $data = $request->except('_token', 'avatar'); // Lấy dữ liệu từ $request gửi lên trừ _token và avatar
            $data['slug'] = Str::slug($request->name);
            $data['created_at'] = Carbon::now();

            if($request->avatar){
                $file = upload_image('avatar');
                if(isset($file['code']) && $file['code'] == 1){
                    $data['avatar'] = $file['name'];
                }
            }

            $menu = Menu::create($data);
            toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            Log::error("ERROR => MenuController@store => ". $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.menu.index');
        }
      
        return redirect()->route('get_admin.menu.index');
    }

    public function edit($id){
        $menu = Menu::findOrFail($id);
        return view('backend.menu.update', compact('menu')); // compact(): Tạo mảng với giá trị 'category'
    }

    public function update(MenuRequest $request, $id){
        try {
            $data = $request->except('_token', 'avatar');
            $data['slug'] = Str::slug($request->name);
            $data['updated_at'] = Carbon::now();

            // dd($request->all());
            if($request->avatar){
                $file = upload_image('avatar');
                if(isset($file['code']) && $file['code'] == 1){
                    $data['avatar'] = $file['name'];
                }
            }

            Menu::find($id)->update($data);
            toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            Log::error("ERROR => MenuController@store => ". $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.menu.update', $id);
        }
       
        return redirect()->route('get_admin.menu.index');
    }

    public function delete(Request $request, $id){
        try {
            $menu = Menu::findOrFail($id);
            if($menu) $menu->delete();

            toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => MenuController@delete => ". $exception->getMessage());
        }
       
        return redirect()->route('get_admin.menu.index');
    }
}
