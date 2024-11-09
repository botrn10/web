<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tạo mới đơn hàng</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/vnpay_php/assets/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('/vnpay_php/assets/jumbotron-narrow.css') }}" rel="stylesheet">
    <script src="{{ asset('/vnpay_php/assets/jumbotron-narrow.css') }}"></script>
</head>

<body>
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">Thông tin đơn hàng</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng: {{$vnpayData['vnp_TxnRef']}}</label>

                <label></label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label>{{$vnpayData['vnp_Amount']}}</label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label>{{$vnpayData['vnp_OrderInfo']}}</label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode): {{$vnpayData['vnp_ResponseCode']}}</label>
                <label></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY: {{$vnpayData['vnp_TransactionNo']}}</label>
                <label></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng: {{$vnpayData['vnp_BankCode']}}</label>
                <label></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán: {{ date('Y-m-d H:i', strtotime($vnpayData['vnp_PayDate'])) }}</label>
                <label></label>
            </div>
            <div class="form-group">
                <label>Kết quả: Giao dịch thành công! </label>
                <label>
                </label>
                <a href="{{route('get.home')}}"><button>Quay lại</button></a>
            </div>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; Website</p>
        </footer>
    </div>
</body>
</html>
