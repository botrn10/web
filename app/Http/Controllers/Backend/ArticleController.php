<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\MenuRequest;
use App\Models\Article;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request){
        $articles = Article::with('menu:id,name', 'user:id,name');

        if ($name = $request->n) // Tìm bằng tên
        $articles->where('name', 'like', '%' . $name . '%');

        if ($s = $request->status) // Tìm bằng trạng thái
        $articles->where('status', $s);
        
        $articles = $articles->orderByDesc('id')->paginate(10); // Phân trang 20 dòng

        $model = new Article();
        $status = $model->getStatus();

        $viewData = [
            'articles' => $articles,
            'status' => $status,
        ];

        return view('backend.article.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){

        $menus = Menu::all();

        $model = new Article();
        $status = $model->getStatus();

        $viewData = [
            'menus' => $menus,
            'status' => $status
        ];

        return view('backend.article.create', $viewData);
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

            $data['user_id'] = Auth::user()->id; // Hiển thị user đăng bán

            $article = Article::create($data);
            toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            Log::error("ERROR => ArticleController@store => ". $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.article.index');
        }
      
        return redirect()->route('get_admin.article.index');
    }

    public function edit($id){

        $article = Article::findOrFail($id);

        $menus = Menu::all();

        $model = new Article();

        $status = $model->getStatus();

        $viewData = [
            'article' => $article,
            'status' => $status,
            'menus' => $menus,

        ];

        return view('backend.article.update', $viewData); 
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

            Article::find($id)->update($data);
            toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            Log::error("ERROR => ArticleController@store => ". $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get_admin.article.update', $id);
        }
       
        return redirect()->route('get_admin.article.index');
    }

    public function delete(Request $request, $id){
        try {
            $article = Article::findOrFail($id);
            if($article) $article->delete();

            toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        } catch (\Exception $exception) {
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => ArticleController@delete => ". $exception->getMessage());
        }
       
        return redirect()->route('get_admin.article.index');
    }
}
