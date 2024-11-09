<header class="wrapper_header" style="background-color: #fd7e14">
    <div class="menu-header">

        <div class="container" >
            <div class="row">
                <div class="col-lg-2 d-flex align-items-center justify-content-center justify-content-md-start">
                    <div class="header-logo">
                        <a href="/">
                            <img src="{{ asset('assets\img\logoMYUEH.png') }}" alt="" width="100%"
                                height="45px">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 d-none d-md-block" >
                    <nav class="nav-header h-100">
                        <ul class="list-menu d-flex justify-content-end h-100 align-items-center">
                            {{-- Nofitications start --}}
                            <ul class="nav navbar-nav">
                                <li class="dropdown dropdown-notifications">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                        id="notification-icon">
                                        <i data-count="0" class="fa-solid fa-bell notification-icon text-white"></i>
                                    </a>
                                    <div class="dropdown-container ">
                                        <div class="dropdown-toolbar">
                                            <div class="dropdown-toolbar-actions">
                                                <a href="#">Đánh dấu đã đọc</a>
                                            </div>
                                            <h3 class="dropdown-toolbar-title">Thông báo (<span
                                                    class="notif-count">0</span>)</h3>
                                        </div>

                                        <ul class="dropdown-menu show">
                                        </ul>

                                        <div class="dropdown-footer text-center">
                                            <a href="#">Tất cả</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            {{-- Nofitications end --}}
                            <li class="item-menu d-flex align-items-center pl-3">
                                <a href="#" class="link-menu d-flex align-items-center">
                                    <img src="{{ pare_url_file(\Auth::user()->avatar ?? '') }}"
                                        onerror="this.src='{{ asset('/assets/img/default_user.png') }}';" alt=""
                                        width="34px" height="34px">
                                    <span class="ml-2">{{ Auth::user()->name ?? 'Chưa đăng nhập' }}</span>
                                    <span class="ml-2">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </span>
                                </a>
                                <div class="profile-user">
                                    <div class="profile-top">
                                        <div class="info d-flex align-items-start">
                                            <div class="user-avt position-relative">
                                                <a href="#" class="user-avt-main">
                                                    <img src="{{ pare_url_file(\Auth::user()->avatar ?? '') }}"
                                                        onerror="this.src='{{ asset('/assets/img/default_user.png') }}';"
                                                        alt="" width="100%" height="100%">
                                                </a>
                                            </div>
                                            <div class="user-info">
                                                <h3 class="user-name">
                                                    <a href="#">Website</a>
                                                </h3>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class="profile-bottom d-flex flex-column">
                                        <ul class="list-manage">
                                            @if (Auth::check())
                                                <h3 class="title-manage">
                                                    Tin đăng
                                                </h3>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.user.product_index') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/escrow_buy_orders.svg') }}"
                                                            alt="" class="img-manage" width="24px"
                                                            height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Danh sách tin đăng</span>
                                                    </a>
                                                </li>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.user.product_create') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/add-new.svg') }}" alt="Thêm mới"
                                                            class="img-manage" width="24px" height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Thêm mới tin đăng</span>
                                                    </a>
                                                </li>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.user.transaction.index') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/menu-saved-search.svg') }}"
                                                            alt="Thêm mới" class="img-manage" width="24px"
                                                            height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Đơn mua</span>
                                                    </a>
                                                </li>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.user.transaction.index_sale') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/circle-list.svg') }}" alt="Thêm mới"
                                                            class="img-manage" width="24px" height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Đơn bán</span>
                                                    </a>
                                                </li>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.listaddProduct') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/menu-saved-ad.svg') }}"
                                                            alt="Thêm mới" class="img-manage" width="24px"
                                                            height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Danh sách Giỏ hàng</span>
                                                    </a>
                                                </li>
                                           
                                              
                                                <h3 class="title-manage">
                                                    Thông tin cá nhân
                                                </h3>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.user.update_profile') }}"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/setting.svg') }}" alt=""
                                                            class="img-manage" width="24px" height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Cập nhật thông tin</span>
                                                    </a>
                                                </li>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.logout') }}" title="Đăng xuất"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/logout.svg') }}" alt=""
                                                            class="img-manage" width="24px" height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Đăng xuất</span>
                                                    </a>
                                                </li>
                                            @else
                                                <h3 class="title-manage">
                                                    Thực hiện
                                                </h3>
                                                <li class="item-manage">
                                                    <a href="{{ route('get.login') }}" title="Đăng nhập"
                                                        class="link-manage d-flex align-items-center">
                                                        <img src="{{ asset('images/login-svgrepo-com.svg') }}"
                                                            alt="" class="img-manage" width="24px"
                                                            height="24px"
                                                            style="object-fit: contain; margin-right: 12px;">
                                                        <span>Đăng nhập</span>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="search-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="search-item position-relative d-flex">
                        <form style="width: 100%" action="{{ route('get.search') }}">
                            <input type="text" name="k" value="{{ Request::get('k') }}"
                                placeholder="Tìm kiếm trên Website" style="width: 100%">
                            <button class="position-absolute btn-search btn-user">
                                <span><i class="fa-solid fa-magnifying-glass"></i></span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-md-block" >
                    <div class="create-news d-flex h-100">
                        @if (Auth::check())
                            <a target="_blank" href="{{ route('view_chat', Auth::user()->id) }}"
                                class="btn-create w-100 d-flex align-items-center justify-content-center">
                                <span class="btn-create-icon pending-notification"><i data-count="0"
                                        class="fa-brands fa-rocketchat notification-icon"></i></span>
                                <span class="btn-create-text ml-2">Chat</span>
                            </a>
                            <a href="{{ route('get.user.product_create') }}"
                                class="btn-create w-100 d-flex align-items-center justify-content-center">
                                <span class="btn-create-icon"><i class="fa-regular fa-pen-to-square"></i></span>
                                <span class="btn-create-text ml-2">Đăng tin</span>
                            </a>
                        @else
                            <a href="{{ route('get.login') }}"
                                class="btn-create w-100 d-flex align-items-center justify-content-center">
                                <span class="btn-create-icon"><i class="fa-regular fa-pen-to-square"></i></span>
                                <span class="btn-create-text ml-2">Đăng tin</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 d-none d-md-block">
                    <div class="create-news d-flex h-100">
                        <a href="{{ route('get.listaddProduct') }}"
                            class="btn-create w-100 d-flex align-items-center justify-content-center">
                            <span
                                class="btn-create-icon btn-create w-100 d-flex align-items-center justify-content-center"><span
                                    class="btn-create-text ml-2">Giỏ hàng </span> <span
                                    class="btn-create-text ml-2"><i data-count="{{ \Cart::count() }}"
                                        class=" notification-icon fa-solid "></i>
                                </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
{{-- <div class="header-mobile">
    <ul class="header-mobile-list d-flex mb-0 py-1 position-relative">
        <li class="header-mobile-item">
            <a href="#" class="header-mobile-link active d-flex flex-column align-items-center">
                <span class="header-mobile-icon"><i class="fa-solid fa-house"></i></span>
                <span class="header-mobile-text">Trang chủ</span>
            </a>
        </li>
        <li class="header-mobile-item">
            <a href="#" class="header-mobile-link  d-flex flex-column align-items-center">
                <span class="header-mobile-icon"><i class="fa-solid fa-house"></i></span>
                <span class="header-mobile-text">Trang chủ</span>
            </a>
        </li>
        <li class="header-mobile-item">
            <a href="#" class="header-mobile-link create-post d-flex flex-column align-items-center">
                <span class="header-mobile-icon"><i class="fa-regular fa-pen-to-square"></i></span>
                <span class="header-mobile-text">Đăng tin</span>
            </a>
        </li>
        <li class="header-mobile-item">
            <a href="#" class="header-mobile-link  d-flex flex-column align-items-center">
                <span class="header-mobile-icon"><i class="fa-solid fa-house"></i></span>
                <span class="header-mobile-text">Trang chủ</span>
            </a>
        </li>
        <li class="header-mobile-item">
            <a href="#" class="header-mobile-link open-profile-user d-flex flex-column align-items-center">
                <span class="header-mobile-icon"><i class="fa-solid fa-house"></i></span>
                <span class="header-mobile-text">Trang chủ</span>
            </a>
        </li>
    </ul>
</div> --}}
