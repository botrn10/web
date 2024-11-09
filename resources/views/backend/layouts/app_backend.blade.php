<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico" /> --}}

    <title>Stu2hand - Admin</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/" />

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('theme_admin/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
        crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="{{ asset('theme_admin/css/dashboard.css') }}" rel="stylesheet" />
    <style>
        .nav-tab-profile .nav-item.active {
            border-bottom: 1px solid #dedede;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-free-6.4.0-web/css/all.min.css') }}">

    {{-- Hiển thị ngày trong input CSS --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    {{-- Biểu đồ morris CSS --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    {{-- Chi tiết đơn hàng --}}

</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Hi - {{ Auth::user()->name ?? '[N/A]' }}</a>
        {{-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" /> --}}
        <div class="dropdown" style="margin-right: 10px;">
            <button class="btn dropdown-toggle" style="background: none;color: white" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ pare_url_file(Auth::user()->avatar) }}"
                    onerror="this.src='https://123code.net/images/preloader.png';"
                    style="width: 40px;height: 40px;border-radius: 50%" alt="">
            </button>
            <div class="dropdown-menu" style="left: unset;right: 10px" aria-labelledby="dropdownMenu2">
                <a href="{{ route('get_admin.profile.index') }}" class="dropdown-item" title="Cập nhật thông tin">Cập
                    nhật thông tin</a>
                <a href="{{ route('get_admin.logout') }}" title="Đăng xuất" class="dropdown-item">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        {{-- @foreach (config('nav') as $item)
                            <li class="nav-item">
                                <a class="nav-link {{ Request::route()->getName() === $item['route'] ? 'active' : '' }} "
                                    href="{{ route($item['route']) }}" title=" {{ $item['name'] }}">
                                    <span data-feather="{{ $item['icon'] }}"></span>
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach
                        <span>------ Khác -------</span> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == '' ? 'active' : '' }} "
                                href="{{ route('get_admin.home') }}">
                                <span data-feather="home"></span>
                                Tổng quan <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == 'category' ? 'active' : '' }} "
                                href="{{ route('get_admin.category.index') }}">
                                <span data-feather="layers"></span>
                                Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == 'product' ? 'active' : '' }}"
                                href="{{ route('get_admin.product.index') }}">
                                <span data-feather="shopping-cart"></span>
                                Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == 'user' ? 'active' : '' }} "
                                href="{{ route('get_admin.user.index') }}">
                                <span data-feather="users"></span>
                                Thành viên
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == 'slide' ? 'active' : '' }}"
                                href="{{ route('get_admin.slide.index') }}">
                                <span data-feather="server"></span>
                                Slide
                            </a>
                        </li>
                      
                    
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2) == 'transaction' ? 'active' : '' }}"
                                href="{{ route('get_admin.transaction.index') }}">
                                <span data-feather="file-text"></span>
                                Đơn hàng
                            </a>
                        </li>
                      
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Share</button>
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar"></span>
                                This week
                            </button>
                        </div>
                    </div> --}}

                {{-- <canvas class="my-4" id="myChart" width="900" height="380"></canvas> --}}

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}



    {{-- Jquery dùng cho location --}}
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="{{ asset('theme_admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme_admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme_admin/js/main.js') }}"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

    {{-- Chức năng Location --}}
    <script>
        feather.replace();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Load thành phố
        $(function() {
            $("#loadDistrict").change(function() {
                console.log("------LOAD----------");
                let province_id = $(this).find(":selected").val();
                console.log("------province_id: ", province_id);
                $.ajax({
                        url: "/admin/location/district",
                        data: {
                            province_id: province_id
                        },
                        beforeSend: function(xhr) {}
                    })
                    .done(function(data) {
                        // console.log("------Data: ", data);
                        let dataOptions = `<option value="">---Chọn quận huyện---</option>`;
                        data.map(function(index, key) {
                            dataOptions += `<option value=${index.id}>${index.name}</option>`
                        });
                        $("#districtsData").html(dataOptions);
                    });
            });
            // Load quận huyện
            $("#districtsData").change(function() {
                let district_id = $(this).find(":selected").val();

                $.ajax({
                        url: "/admin/location/ward",
                        data: {
                            district_id: district_id
                        },
                        beforeSend: function(xhr) {}
                    })
                    .done(function(data) {
                        // console.log("------Data: ", data);
                        let dataOptions = `<option value="">---Chọn phường xã---</option>`;
                        data.map(function(index, key) {
                            dataOptions += `<option value=${index.id}>${index.name}</option>`
                        });
                        $("#wardData").html(dataOptions);
                    });
            });
        })


        //  Gủi mail
        $(".js-send-otp").click(function(event) {
            event.preventDefault();
            let email = $(this).attr('data-email');
            // console.log('------Email: ', email);
            $.ajax({
                url: "/admin/profile/send-otp-email",
                method: "POST",
                data: {
                    email: email
                },
            }).done(function(response) {
                if (response.status === "success") {
                    alert("Gủi OTP thành công, xin vui lòng kiểm tra email: " + email);
                    return;
                }
                alert("Gủi OTP thất bại, xin vui lòng kiểm tra lại!")
                // console.log('---- data: ', data);
            });
        });

        // Gọi model xem chi tiết đơn hàng start
        $(".js_order_item").click(function(event) {
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

        // Gọi model xem chi tiết sản phẩm
        $(".js_detail_product_item").click(function(event) {
            event.preventDefault();
            let $this = $(this);
            let url = $this.attr('href');

            $(".transaction_id").text('').text($this.attr('data-id'));

            $.ajax({
                url: url,
            }).done(function(result) {
                console.log(result);
                if (result) {
                    $("#md_content_detail_product").html('').append(result);
                }
            });
        });
    </script>




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
    </script>
    {{-- Xử lý alert form delete, submit end --}}



    {{-- Biểu đồ Morris Script --}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>



    {{-- Xử lý chart, filter start --}}
    <script type="text/javascript">
        $(document).ready(function() {

            chart30daysoder();

            var chart = new Morris.Bar({

                element: 'chart',

                barColors: ['#f7ed31', '#1168f5', '#11f528', '#f53711'],

                parseTime: false,

                hideHover: 'auto',

                xkey: 'date_create',

                ykeys: ['total_product', 'success', 'finish', 'cancel'],
                labels: ['Tổng tin đăng', 'Được duyệt', 'Đã bán / Ẩn tin', 'Không được duyệt'],


            });

            // Xử lý hiển thị ban đầu 60 Ngày
            function chart30daysoder() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "/admin/filter-by-30days",
                    method: "POST",
                    dateType: "JSON",
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        // console.log("==> Data: ", data);
                        var dataParse = JSON.parse(data);
                        chart.setData(dataParse);
                    }
                });
            }

            // Xử lý lọc option
            $('.dashboard-filter').change(function() {

                var dashboard_value = $(this).val();
                var _token = $('input[name="_token"]').val();

                //    alert(dashboard_value);

                $.ajax({
                    url: "/admin/filter-by-option",
                    method: "POST",
                    dateType: "JSON",
                    data: {
                        dashboard_value: dashboard_value,
                        _token: _token,
                    },
                    success: function(data) {
                        // console.log("==> Data: ", data);
                        var dataParse = JSON.parse(data);
                        chart.setData(dataParse);
                    }
                });
            });

            // Xử lý khi nhấn nút lọc dữ liệu
            $("#btn-dashboard-filter").click(function() {

                var _token = $('input[name="_token"]').val();
                var from_date = $('#datepicker').val();
                var to_date = $('#datepicker2').val();

                $.ajax({
                    url: "/admin/filter-by-date",
                    method: "POST",
                    dateType: "JSON",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        _token: _token,
                    },
                    success: function(data) {
                        // console.log("==> Data: ", data);
                        var dataParse = JSON.parse(data);
                        chart.setData(dataParse);
                    }
                });
            });
        });
    </script>
    {{-- Xử lý chart, filter end --}}

    {{-- Hiển thị ngày trong input start --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">
        // Xử lý lọc từ ngày đến ngày
        $(function() {
            $("#datepicker").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dateNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7",
                    "Chủ nhật"
                ],
                duration: "slow"
            });

            $("#datepicker2").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dateNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7",
                    "Chủ nhật"
                ],
                duration: "slow"
            });
        });
    </script>
</body>

</html>
