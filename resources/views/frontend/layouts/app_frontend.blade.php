<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title_page')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Notifications start --}}
    {{-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="https://skywalkapps.github.io/bootstrap-notifications/stylesheets/bootstrap-notifications.css"> --}}
    {{-- Notifications end --}}

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}


</head>

<body>

    @include('frontend.layouts._inc_header')
    <div class="profile-user-mobile">
        <div class="profile-top">
            <div class="info d-flex align-items-start">
                <div class="user-avt position-relative">
                    <a href="#" class="user-avt-main">

                        <img src="/assets/img/25118033.jpg" alt="" width="100%">
                    </a>
                    <img src="/assets/img/edit-filled.svg" alt="edit" class="edit-avt">
                </div>
                <div class="user-info">
                    <h3 class="user-name">
                        <a href="#">Chợ tốt</a>
                    </h3>
                    <div class="user-evaluate d-flex align-items-center">
                        <span class="mr-1 font-weight-bold">0.0</span>
                        <div class="star">
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                        </div>
                        <span style="color: var(--color-star);" class="ml-1">Chưa có đánh giá</span>
                    </div>
                    <div class="is-divider">

                    </div>
                    <div class="user-more-info d-flex">
                        <div class="user-follower">
                            <span class="font-weight-bold">0</span>
                            <span>Người theo dõi</span>
                        </div>
                        <div class="is-divider vertical">

                        </div>
                        <div class="user-follower">
                            <span class="font-weight-bold">0</span>
                            <span>Người theo dõi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-points d-flex">
                <div class="mr-2">
                    <span>Điểm tốt</span>
                    <div class="d-flex align-items-center">
                        <span class="font-weight-bold">0</span>
                        <img class="ml-1" src="/assets/img/good-point.svg" alt="">
                    </div>
                </div>
                <div>
                    <span>Điểm tốt</span>
                    <div class="d-flex align-items-center">
                        <span class="font-weight-bold">0</span>
                        <img class="ml-1" src="/assets/img/good-point.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-bottom d-flex flex-column">
            <ul class="list-manage">
                <h3 class="title-manage">
                    Quản lý đơn hàng
                </h3>
                <li class="item-manage">
                    <a href="#" class="link-manage d-flex align-items-center">
                        <img src="/assets/img/escrow_buy_orders.svg" alt="" class="img-manage" width="24px"
                            height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                    </a>
                </li>
                <li class="item-manage">
                    <a href="#" class="link-manage d-flex align-items-center">
                        <img src="/assets/img/escrow_buy_orders.svg" alt="" class="img-manage" width="24px"
                            height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                    </a>
                </li>
                <li class="item-manage">
                    <a href="#" class="link-manage pay d-flex align-items-center">
                        <img src="/assets/img/escrow.svg" alt="" class="img-manage" width="24px"
                            height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                        <span class="font-weight-bold ml-auto link-now">Liên kết ngay <i
                                class="fa-solid fa-angle-right ml-1"></i></span>
                    </a>
                </li>
            </ul>
            <ul class="list-manage">
                <h3 class="title-manage">
                    Quản lý đơn hàng
                </h3>
                <li class="item-manage">
                    <a href="#" class="link-manage d-flex align-items-center">
                        <img src="/assets/img/escrow_buy_orders.svg" alt="" class="img-manage"
                            width="24px" height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                    </a>
                </li>
                <li class="item-manage">
                    <a href="#" class="link-manage d-flex align-items-center">
                        <img src="/assets/img/escrow_buy_orders.svg" alt="" class="img-manage"
                            width="24px" height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                        <div class="label-new">Mới</div>
                    </a>
                </li>
                <li class="item-manage">
                    <a href="#" class="link-manage pay d-flex align-items-center">
                        <img src="/assets/img/escrow.svg" alt="" class="img-manage" width="24px"
                            height="24px" style="object-fit: contain; margin-right: 12px;">
                        <span>Đơn mua</span>
                        <span class="font-weight-bold ml-auto link-now">Liên kết ngay <i
                                class="fa-solid fa-angle-right ml-1"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @yield('content')
    @yield('content_chat')
    <footer class="wrapper_footer d-none d-md-block" style="padding-top: 20px; margin-top: 20px; ">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-white">
                    <p style="margin-bottom: 5px;
                    ">Designed by MYUEH</p>
                    <p>&copy; 2024 Website. All rights reserved.</p>
                </div>
                <div class="col-lg-4">
                    <div class="item-footer">
                        <h3 class="title-footer text-white">
                            WEBSITE BÁN ĐỒ CŨ CHO SINH VIÊN UEH
                        </h3>
                        <ul class="d-flex">
                            <li class="mr-2">
                                <a href="#">
                                    <img src="{{ asset('assets/img/logoMYUEH3.png') }}" alt=""
                                        width="100%" height="45px">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- <div class="footer-mobile d-block d-md-none">
        <div class="footer-mobile-top px-2">
            <div class="d-flex align-items-center justify-content-between">

                <div>
                    <img src="/assets/img/logo-ct-primary.png" alt="" width="96px">
                </div>
                <div class="d-flex justify-content-end flex-column">
                    <div class="d-flex align-items-center justify-content-end"
                        style="gap: 8px; color: #FF8800; font-size: 12px;">
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                    </div>
                    <span style="font-size: 14px;  color: #777777;">109.000 Bình chọn</span>
                </div>
            </div>
            <div style="margin-top: 12px;">
                <h3 class="title-footer text-left"> Tải ngay ứng dụng - Mua bán cực sung</h3>
                <div class="d-flex justify-content-between">
                    <img src="/assets/img/ios.svg" alt="">
                    <img src="/assets/img/ios.svg" alt="">
                    <img src="/assets/img/ios.svg" alt="">
                </div>
            </div>
        </div>
        <div class="footer-mobile-bottom px-2">
            <ul class="d-flex justify-content-around" style="margin: 16px 0">
                <li>
                    <a href="#" style="font-size: 10px;color: #777777; text-transform: uppercase;">
                        Trợ giúp
                    </a>
                </li>

                <li>
                    <a href="#" style="font-size: 10px;color: #777777; text-transform: uppercase;">
                        Trợ giúp
                    </a>
                </li>
                <li>
                    <a href="#" style="font-size: 10px;color: #777777; text-transform: uppercase;">
                        Trợ giúp
                    </a>
                </li>
            </ul>
            <ul class="d-flex justify-content-around" style="margin: 16px 0">
                <li>
                    <a href="#" style="font-size: 10px;color: #777777; text-transform: uppercase;">
                        Trợ giúp
                    </a>
                </li>

                <li>
                    <a href="#" style="font-size: 10px;color: #777777; text-transform: uppercase;">
                        Trợ giúp
                    </a>
                </li>
            </ul>
            <div>
                <img src="/assets/img/certificate.webp" alt="">
            </div>
        </div>
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="{{ asset('theme_admin/js/popper.min.js') }}"></script>

    {{-- <script src="{{ asset('theme_admin/js/bootstrap.min.js') }}"></script> --}}

    <script src="{{ asset('assets/css/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('assets/css/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>

    {{-- Bootstrap cho nút thông báo --}}
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>

    {{-- Confirm delete --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Xử lý alert form delete, submit start --}}

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#delete_alert', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                // console.log(link);
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa không ?',
                    text: "Bạn không thể khôi phục lại dữ liệu sau khi xóa !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;

                    }
                })

            })
        });

        $('#alert_form_submit').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Bạn có muốn lưu dữ liệu không ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        // Gọi model xem chi tiết đơn hàng start
        $(".js_order_item").click(function(event) {

            // alert("Nhấn chi tiết")
            event.preventDefault();
            let $this = $(this);
            let url = $this.attr('href');

            $(".transaction_id").text('').text($this.attr('data-id'));

            $.ajax({
                url: url,
            }).done(function(result) {
                console.log(result);
                if (result) {
                    $("#md_content").html('').append(result);
                }
            });
        });
        // Gọi model xem chi tiết đơn hàng end

        $(".notification-icon").click(function(event) {
            // Thực hiện hành động bạn muốn khi biểu tượng được click
            console.log("Biểu tượng thông báo đã được click!");
            // event.preventDefault();
            $(".dropdown-container").toggleClass("show");
        });
    </script>

    {{-- Xử lý alert form delete, submit end --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var notificationsWrapper = $('.dropdown-notifications');
            var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
            var notificationsCountElem = notificationsToggle.find('i[data-count]');
            var notificationsCount = parseInt(notificationsCountElem.data('count'));
            var notifications = notificationsWrapper.find('ul.dropdown-menu');
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: 'ap1',
                encrypted: true
            });
            var channel = pusher.subscribe('Notify');
            // Gọi AJAX để lấy dữ liệu khi trang web được load
            $.ajax({
                method: 'GET',
                url: '{{ route('getData') }}',
                success: function(response) {
                    var messages = response.messages;
                    messages.forEach(function(message) {
                        var timestamp = moment(message.created_at).fromNow();
                        var newNotificationHtml = `
                            <li class="notification active">
                                <div class="media">
                                    <div class="media-left mt-2">
                                        <div class="media-object">
                                            <img src="${message.avatar}" class="img-circle" alt="50x50" style="width: 50px; height: 50px; ">
                                        </div>
                                    </div>
                                    <div class="media-body ml-3">
                                        <strong class="notification-title">${message.title}</strong>
                                        <p class="notification-desc">${message.content}</p>
                                        <div class="notification-meta">
                                            <small class="timestamp">${timestamp}</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                        notifications.prepend(newNotificationHtml);
                        notificationsCount += 1;
                        notificationsCountElem.attr('data-count', notificationsCount);
                        notificationsWrapper.find('.notif-count').text(notificationsCount);
                        notificationsWrapper.show();
                    });
                },
                error: function(error) {
                    console.error('Lỗi khi lấy dữ liệu:', error);
                }
            });

            var channel2 = pusher.subscribe('my-channel');
            channel2.bind('my-event', function(data) {
                notifications.empty();
                $.ajax({
                    method: 'GET',
                    url: '/getData',
                    data: {},
                    success: function(response) {
                        var messages = response.messages;
                        messages.forEach(function(message) {
                            var timestamp = moment(message.created_at).fromNow();
                            var newNotificationHtml = `
                            <li class="notification active">
                                <div class="media">
                                    <div class="media-left">
                                        <div class="media-object  mt-2">
                                            <img src="${message.avatar}" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                                        </div>
                                    </div>
                                    <div class="media-body ml-3">
                                        <strong class="notification-title">${message.title}</strong>
                                        <p class="notification-desc">${message.content}</p>
                                        <div class="notification-meta">
                                            <small class="timestamp">${timestamp}</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                            notifications.prepend(newNotificationHtml);
                            notificationsCount2 = notificationsCount + 1;
                            notificationsCountElem.attr('data-count',
                                notificationsCount2);
                            notificationsWrapper.find('.notif-count').text(
                                notificationsCount2);
                            notificationsWrapper.show();
                        });
                    },
                    error: function(error) {
                        console.error('Lỗi khi lấy dữ liệu:', error);
                    }
                });
            });
        });
    </script>
    {{-- Notifications end --}}

    {{-- Notifications chatify start --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('38c38539be23e63dee8d', {
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            // alert("Hí ae");
            $.ajax({
                type: 'GET',
                url: '/updateunseenmessage',
                data: {},
                success: function(data) {
                    // console.log("Hí ae " + data.unseenCounter);
                    $('.pending-notification').empty();
                    html = ``;
                    if (data.unseenCounter > 0) {
                        html += `<i data-count="${data.unseenCounter}"
                                    class="fa-brands fa-rocketchat notification-icon"></i>`;
                    } else {
                        html += `<i data-count="0"
                                    class="fa-brands fa-rocketchat notification-icon"></i>`;
                    }
                    $('.pending-notification').html(html);
                },
            });
        });
    </script>
    {{-- Notifications chatify end --}}
</body>

</html>
