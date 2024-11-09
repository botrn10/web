<?php

namespace App\Http\Controllers;

use App\Events\Notify;
use Illuminate\Http\Request;
use Pusher\Pusher;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class SendMessageController extends Controller
{
    public function index()
    {
        return view('frontend.notifications.send_message');
    }

    public function sendMessage(Request $request)
    {
        // dd($request->all());

        // $user_id = Auth::user()->id;

        // dd($user_id);

        // $request->validate([
        //     'title' => 'required',
        //     'content' => 'required'
        // ]);

        // $data['title'] = $request->input('title');
        // $data['content'] = $request->input('content');

        if ($request->status == 2) {
            $data['title'] = "Đồ dùng đã được duyệt";
            $data['content'] = "Đồ dùng " . $request->name . " đã được duyệt";
        } else if ($request->status == -1) {
            $data['title'] = "Đồ dùng không được duyệt";
            $data['content'] = "Đồ dùng " . $request->name . " không được duyệt";
        } else {
            $data['title'] = "Lỗi thông báo";
            $data['content'] = "Lỗi thông báo";
        }

        $data['from_user_id'] = $request->input('from_user_id'); // Gửi từ 
        $data['to_user_id'] = $request->input('to_user_id'); // Người nhận

        $data['avatar'] = $request->input('notification_avatar');

        // Lưu vào cơ sở dữ liệu
        $notifications = Notification::create($data);

        if ($request->to_user_id == Auth::id()) {
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $pusher->trigger('Notify', 'send-message', $data);
        }

        // return redirect()->route('send');
        return redirect()->back();
    }

    public function getData()
    {
        // Tạo thông báo số lượng tin nhắn đến end
        $messages = Notification::where('to_user_id', '=', Auth::user()->id)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json(['messages' => $messages]);
    }
}
