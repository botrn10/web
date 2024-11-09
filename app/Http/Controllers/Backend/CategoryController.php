<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index(){
        $category = Category::orderByDesc('id')->paginate(10); // Phân trang 20 dòng
        $viewData = [
            'category' => $category
        ];
        return view('backend.category.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){
        return view('backend.category.create');
    }

    public function store(CategoryRequest $request){
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

            $category = Category::create($data);
        } catch (\Exception $exception) {
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => CategoryController@store => ". $exception->getMessage());
            return redirect()->route('get_admin.category.index');
        }
        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.category.index');
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view('backend.category.update', compact('category')); // compact(): Tạo mảng với giá trị 'category'
    }

    public function update(CategoryRequest $request, $id){
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

            Category::find($id)->update($data);
        } catch (\Exception $exception) {
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => CategoryController@store => ". $exception->getMessage());
            return redirect()->route('get_admin.category.update', $id);
        }
        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.category.index');
    }

    public function delete(Request $request, $id){
        try {
            $category = Category::findOrFail($id);
            if($category) $category->delete();

        } catch (\Exception $exception) {
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => CategoryController@delete => ". $exception->getMessage());
        }

        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.category.index');
    }
}
