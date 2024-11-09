<?php

namespace App\Http\Controllers\Backend;

use App\Events\MyEvent;
use App\Events\Notify;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendMessageController as ControllersSendMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\Statistic;
use \Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;

use App\Http\SendMessageController;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category:id,name', 'user:id,name', 'province:id,name', 'district:id,name', 'ward:id,name')->withCount('images');

        // dd($products);

        if ($name = $request->n) // Tìm bằng tên
            $products->where('name', 'like', '%' . $name . '%');

        if ($s = $request->status) // Tìm bằng trạng thái
            $products->where('status', $s);

        $products = $products
            ->orderByDesc('id')
            ->paginate(10);

        $model = new Product();
        $status = $model->getStatus();

        $to_day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

        $viewData = [
            'products' => $products,
            'query' => $request->query(),
            'status' => $status,
            'to_day' => $to_day,
        ];
        return view('backend.product.index', $viewData)->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $categories = Category::all();
        $model = new Product();
        $status = $model->getStatus();
        $provinces = Province::all();

        return view('backend.product.create', compact('categories', 'status', 'provinces'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->except('_token', 'avatar', 'order_date');
            $data['slug'] = Str::slug($request->name);
            $data['created_at'] = Carbon::now();
            $data['order_date'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); // Dùng cho thống kê

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file['code']) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }
            // Thống kế start
            $order_date = $data['order_date'];
            $statistic = Statistic::where('order_date', $order_date)->get();
            if ($statistic) {
                $statistic_count = $statistic->count();
            } else {
                $statistic_count = 0;
            }
            $total_product = 0;
            if ($request->status == 1) {
                $total_product = Product::select('id')->where('order_date', $order_date)->count();
                $total_product += 1;
                if ($statistic_count > 0) {
                    $statistic_update = Statistic::where('order_date', $order_date)->first();
                    $statistic_update->total_product = $total_product;
                    $statistic_update->save();
                } else {
                    $statistic_new = new Statistic();
                    $statistic_new->order_date = $order_date;
                    $statistic_new->total_product = $total_product;
                    $statistic_new->save();
                }
            }
            // Thống kế end
            $data['user_id'] = Auth::user()->id; // Hiển thị user đăng bán

            $product = Product::create($data);

            if ($request->file) {
                $this->sysncAlbumImageAndProduct($request->file, $product->id);
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@store => " . $exception->getMessage());
            toastr()->error('Thêm mới thất bại!', 'Thông báo', ['timeOut' => 1000]);
            return redirect()->route('get_admin.product.index');
        }
        toastr()->success('Thêm mới thành công!', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->route('get_admin.product.index');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $model = new Product();
        $status = $model->getStatus();
        $provinces = Province::all();
        $product = Product::findOrFail($id);

        // Hiển thị district
        $activeDistricts = DB::table('districts')->where('id', $product->district_id)->pluck('name', 'id')->toArray();

        $activeWards = DB::table('wards')->where('id', $product->ward_id)->pluck('name', 'id')->toArray();

        $images = ProductImage::where('product_id', $id)->orderByDesc('id')->get();

        $viewData = [
            'product' => $product,
            'categories' => $categories,
            'status' => $status,
            'images' => $images,
            'provinces' => $provinces,
            'activeDistricts' => $activeDistricts,
            'activeWards' => $activeWards,
        ];

        return view('backend.product.update', $viewData);
    }

    public function update(ProductRequest $request, $id)
    {
        // dd($request->all());

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

            // dd($request->all());

            // Thống kế start
            $order_date = $request->order_date;
            $statistic = Statistic::where('order_date', $order_date)->get();

            if ($statistic) {
                $statistic_count = $statistic->count();
            } else {
                $statistic_count = 0;
            }

            $total_product = 0; // Tổng sản phẩm (tin đăng)
            $success = 0; // Được duyệt active
            $finish = 0;    // Hoàn thành => user đã bán
            $cancel = 0;  // Hủy bỏ => Admin đã hủy

            if ($request->status == 2) { // => Cập nhật active sản phẩm (tin đăng)

                $total_product = Product::select('id')->where('order_date', $order_date)->count();

                $success = Statistic::select('success')->where('order_date', $order_date)->value('success');

                $total_product += 1;
                $success += 1;

                if ($statistic_count > 0) {
                    $statistic_update = Statistic::where('order_date', $order_date)->first();
                    $statistic_update->total_product = $total_product - 1;
                    $statistic_update->success = $success;
                    $statistic_update->save();
                } else {
                    $statistic_new = new Statistic();
                    $statistic_new->order_date = $order_date;
                    $statistic_new->total_product = $total_product - 1;
                    $statistic_new->success = $success;
                    $statistic_new->save();
                }
            } else if ($request->status == -1) {

                $total_product = Product::select('id')->where('order_date', $order_date)->count();
                $cancel = Statistic::select('cancel')->where('order_date', $order_date)->value('cancel');

                $total_product += 1;
                $cancel += 1;

                if ($statistic_count > 0) {
                    $statistic_update = Statistic::where('order_date', $order_date)->first();
                    $statistic_update->total_product = $total_product - 1;
                    $statistic_update->cancel = $cancel;
                    $statistic_update->save();
                } else {
                    $statistic_new = new Statistic();
                    $statistic_new->order_date = $order_date;
                    $statistic_new->total_product = $total_product - 1;
                    $statistic_new->cancel = $cancel;
                    $statistic_new->save();
                }
            } else if ($request->status == 3) {

                $finish = Statistic::select('finish')->where('order_date', $order_date)->value('finish');
                $finish += 1;
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->finish = $finish;
                $statistic_update->save();
            } else {
                $total_product = Product::select('id')->where('order_date', $order_date)->count();
                $total_product += 1;

                if ($statistic_count > 0) {
                    $statistic_update = Statistic::where('order_date', $order_date)->first();
                    $statistic_update->total_product = $total_product - 1;
                    $statistic_update->save();
                } else {
                    $statistic_new = new Statistic();
                    $statistic_new->order_date = $order_date;
                    $statistic_new->total_product = $total_product - 1;
                    $statistic_new->save();
                }
            }
            // Thống kế end

            // Notification start
            if ($request->status == 2 || $request->status == -1) {
                // Tạo thông báo số lượng tin nhắn đến start
                $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                );
                $pusher = new \Pusher\Pusher(
                    '38c38539be23e63dee8d',
                    '6597b271b5b771f7d677',
                    '1616521',
                    $options
                );
                $data['message'] = 'hello world';
                $pusher->trigger('my-channel', 'my-event', $data);
                event(new MyEvent("message sent"));
                // Tạo thông báo số lượng tin nhắn đến end
                $sendMessageController = new ControllersSendMessageController();
                $sendMessageController->sendMessage($request);
            }
            // Notification end

            Product::find($id)->update($data);

            if ($request->file) {
                $this->sysncAlbumImageAndProduct($request->file, $id);
            }
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@update => " . $exception->getMessage());
            toastr()->error('Cập nhật thất bại!', 'Thông báo', ['timeOut' => 1000]);
            return redirect()->route('get_admin.product.update', $id);
        }

        toastr()->success('Cập nhật thành công!', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->route('get_admin.product.index');
    }

    public function delete(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product) $product->delete();
        } catch (\Exception $exception) {
            Log::error("ERROR => ProductController@delete => " . $exception->getMessage());
            toastr()->error('Xóa thất bại!', 'Thông báo', ['timeOut' => 1000]);
        }

        toastr()->success('Xóa thành công!', 'Thông báo', ['timeOut' => 1000]);
        return redirect()->route('get_admin.product.index');
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

            // Di chuyển vào thư mục upload
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

        return redirect()->back();
    }

    public function viewDetailProduct(Request $request, $id)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $products = Product::where('id', $id)->get();

            $html = view('backend.components.product', compact('products'))->render();

            return \response()->json($html);
        }
    }
}
