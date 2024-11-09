<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideRequest;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SlideController extends Controller
{
    public function index(){
        $slides = Slide::orderByDesc('id')->paginate(10);
        $viewData = [
            'slides' => $slides
        ];
        return view('backend.slide.index', $viewData)->with('i', (request()->input('page', 1) -1) *10);
    }

    public function create(){
        return view('backend.slide.create');
    }

    public function store(SlideRequest $request){
        // dd($request->all());
        try {
            $data = $request->except('_token', 'avatar');
            $data['created_at'] = Carbon::now();

            if($request->avatar){
                $file = upload_image('avatar');
                if(isset($file['code']) && $file['code'] == 1){
                    $data['avatar'] = $file['name'];
                }
            }

            $slide = Slide::create($data);
        } catch (\Exception $exception) {
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => SlideController@store => ". $exception->getMessage());
            return redirect()->route('get_admin.slide.index');
        }

        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.slide.index');
    }

    public function edit($id){
        $slide = Slide::findOrFail($id);
        return view('backend.slide.update', compact('slide'));
    }

    public function update(SlideRequest $request, $id){
        try {
            $data = $request->except('_token', 'avatar');
            $data['updated_at'] = Carbon::now();

            // dd($request->all());
            if($request->avatar){
                $file = upload_image('avatar');
                if(isset($file['code']) && $file['code'] == 1){
                    $data['avatar'] = $file['name'];
                }
            }

            Slide::find($id)->update($data);
        } catch (\Exception $exception) {
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => SlideController@store => ". $exception->getMessage());
            return redirect()->route('get_admin.slide.update', $id);
        }

        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.slide.index');
    }

    public function delete(Request $request, $id){
        try {
            $slide = Slide::findOrFail($id);
            if($slide) $slide->delete();

        } catch (\Exception $exception) {
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
            Log::error("ERROR => SlideController@delete => ". $exception->getMessage());
        }

        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get_admin.slide.index');
    }
}
