<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \Illuminate\Support\Facades\File;
use App\Models\ProductImage;
use App\Http\Requests\ProductRequest;
use App\Models\Statistic;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::with('category:id,name', 'user:id,name', 'province:id,name', 'district:id,name', 'ward:id,name')
            ->where('user_id', Auth::user()->id) // Check tài khoản nào đang login
            ->withCount('images');

        if ($name = $request->n)
            $products->where('name', 'like', '%' . $name . '%');
        if ($s = $request->status)
            $products->where('status', $s);
        $products = $products
            ->orderByDesc('id')
            ->paginate(5);

        $model  = new Product();
        $status = $model->getStatus();

        $viewData = [
            'products' => $products,
            'query'    => $request->query(),
            'status'   => $status
        ];
        return view('user.product.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $categories = Category::all();
        $model      = new Product();
        $status     = $model->getStatus();
        $provinces  = Province::all();
        $viewData = [
            'categories' => $categories,
            'status' => $status,
            'provinces' => $provinces,
        ];
        return view('user.product.create', $viewData);
    }

    public function store(ProductRequest $request)
    { 
        // dd($request->all());
        try {
            $data = $request->except('_token', 'avatar');
            $data['slug'] = Str::slug($request->name);
            $data['created_at'] = Carbon::now();
            $data['order_date'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }
            $data['user_id'] = Auth::user()->id;
            $data['status'] = Product::STATUS_DEFAULT;

            // Thống kế start
            $order_date = $data['order_date'];
            $statistic = Statistic::where('order_date', $order_date)->get();

            if ($statistic) {
                $statistic_count = $statistic->count();
            } else {
                $statistic_count = 0;
            }
            $total_product = 0;
            $total_product = Product::select('id')->where('order_date', $order_date)->count();
            if ($statistic_count > 0) {
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->total_product = $total_product + 1;
                $statistic_update->save();
            } else {
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->total_product = $total_product + 1;
                $statistic_new->save();
            }
            // Thống kế end

            $product = Product::create($data);
            if ($request->file) {
                $this->sysncAlbumImageAndProduct($request->file, $product->id);
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductControllerOfUser@store => " . $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.user.product_create');
        }
        toastr()->warning('Thêm mới thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.product_index');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $provinces = Province::all();

        $product = Product::where('user_id', Auth::user()->id)->findOrFail($id);

        // Hiển thị district
        $activeDistricts = DB::table('districts')->where('id', $product->district_id)->pluck('name', 'id')->toArray();
        $activeWards = DB::table('wards')->where('id', $product->ward_id)->pluck('name', 'id')->toArray();

        $images = ProductImage::where('product_id', $id)->orderByDesc('id')->get();
        $viewData = [
            'product' => $product,
            'categories' => $categories,
            'images' => $images,
            'provinces' => $provinces,
            'activeDistricts' => $activeDistricts,
            'activeWards' => $activeWards,
        ];
        return view('user.product.update', $viewData); // compact(): Tạo mảng với giá trị 'product'
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $data = $request->except('_token', 'avatar');
            $data['slug'] = Str::slug($request->name);
            $data['updated_at'] = Carbon::now();
            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }
            Product::find($id)->update($data);
            if ($request->file) {
                $this->sysncAlbumImageAndProduct($request->file, $id);
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@store => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.user.product_index', $id);
        }
        toastr()->warning('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.product_index');
    }

    public function delete(Request $request, $id)
    {
        try {
            $product = Product::where('user_id', Auth::user()->id)->findOrFail($id);
            if ($product) $product->delete();
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@delete => " . $exception->getMessage());
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 2000]);
        }
        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.product_index');
    }

    /* Hiển thị album ảnh */
    public function sysncAlbumImageAndProduct($files, $productID)
    {
        foreach ($files as $key => $fileImage) {
            $ext = $fileImage->getClientOriginalExtension();
            $extend = [
                'png', 'jpg', 'jpeg', 'PNG', 'JPG'
            ];
            if (!in_array($ext, $extend)) return false;
            $filename = date('Y-m-d__') . Str::slug($fileImage->getClientOriginalName()) . '.' . $ext;
            $path = public_path() . '/uploads/' . date('Y/m/d/');
            if (!File::exists($path))
                @mkdir($path, 0777, true);
            // di chuyển vào thư mục upload
            $fileImage->move($path, $filename);
            DB::table('products_images')->insert([
                'name' => $fileImage->getClientOriginalName(),
                'path' =>  $filename,
                'product_id' => $productID,
                'created_at' => Carbon::now(),
            ]);
        }
    }

    /* Xóa album ảnh */
    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if ($image) $image->delete();

        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->back();
    }

    // Ẩn tin đã bán start
    public function sold(Request $request, $id)
    {
        try {
            $data = $request->except('_token', 'avatar');
            $data['updated_at'] = Carbon::now();
            $data['status'] = 3;

            // Thống kế start
            $getOrderDayByIdProduct = Product::findOrFail($id);
            $order_date = $getOrderDayByIdProduct['order_date'];

            $statistic = Statistic::where('order_date', $order_date)->get();

            $order_date_update  =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            // Nếu ngày tạo khác ngày ngày cập nhật => Thêm ngày mới vào thống kê
            if ($statistic) {
                if ($order_date == $order_date_update) {
                    $statistic_count = 1;
                } elseif ($order_date != $order_date_update) {
                    $statistic_count = 2;
                } else {
                    $statistic_count = 0;
                }
            } else {
                $statistic_count = 0;
            }
            $finish = 0;
            $finish = Statistic::select('finish')->where('order_date', $order_date)->value('finish');
            $finish += 1;
            $statistic_update = Statistic::where('order_date', $order_date)->first();
            $statistic_update->finish = $finish;
            $statistic_update->save();


            if ($statistic_count == 1) {
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->finish = $finish;
                $statistic_update->save();
            } elseif ($statistic_count == 2) {
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date_update;
                $statistic_new->finish = $finish - 1;
                $statistic_new->save();
            } else {
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->finish = $finish - 1;
                $statistic_new->save();
            }
            // Thống kế end

            Product::find($id)->update($data);
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@sold => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('get.user.product_index', $id);
        }
        toastr()->warning('Cập nhật thành công!', 'Thông báo', ['timeOut' => 2000]);
        return redirect()->route('get.user.product_index');
    }
    // Ẩn tin đã bán end
}
