@extends('frontend.layouts.app_frontend')
@section('title_page', $productDetail->name)
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="/">Trang chủ</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Chi tiết sản phẩm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detail-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="detail-product-image">
                        <div class="gallery">
                            <div class="gallery-image-preview position-relative d-none d-md-block">
                                <img src="{{ pare_url_file($productDetail->avatar) }}" alt="Đang tải avatar" width="100%">
                                <span class="preview-image-number"></span>
                                <span class="time-post-image">Tin đăng vào {{ $productDetail->created_at }}</span>
                            </div>
                            {{-- Load album ảnh --}}
                            <div class="gallery-product-slide owl-carousel">
                                @foreach ($images ?? [] as $item)
                                    <div>
                                        <img src="{{ pare_url_file($item) }}" alt="" width="100%"
                                            data-image-number="1" onmouseover="previewImage(this)">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="detail-product-title">
                        <h1>
                            {{-- <div class="img-partner">
                            </div> --}}
                            {{ $productDetail->name }}
                        </h1>
                        <div class="price-wrapper d-flex justify-content-between">
                            <p class="product-detail-price">{{ number_format($productDetail->price, 0, ',', '.') }} đ</p>
                            <div class="btn">
                                @php
                                    $user = auth()->user() ?? null; 
                                    $productDetailOfUser = $productDetail->user->id ?? null;
                                    $products = \Cart::content();
                                    $check = 0;

                                    // Thêm điều kiện kiểm tra xem sản phẩm có thuộc về người dùng đang xem hay không
                                    $isOwner = $user && $user->id === $productDetailOfUser;

                                    if (!$isOwner) {
                                        foreach ($products as $key => $item) {
                                            if ($item->id == $productDetail->id) {
                                                $check = 1;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                @if (!$isOwner)
                                    @if ($check == 0)
                                        <a href="{{ route('get.addProduct', $productDetail->id) }}" style="color: #007bff">
                                        <i class="fa-solid fa-shopping-cart"></i>                                            <span style="font-size: 12px; background-color: #FFD700; padding: 8px 12px; border-radius: 5px; color: #333333; font-weight: bold;">Giỏ hàng</span>
                                            </a>
                                    @else
                                        <a href="{{ route('get.deleteFavourite', $key) }}" style="color: #007bff">
                                            <i class="fa-solid fa-shopping-cart"></i>
                                            <span style="font-size: 12px; background-color: red; padding: 5px; border-radius: 3px; color: white; font-weight: bold;">Hủy Giỏ hàng</span>
                                            </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="description">
                            <div>
                                <span><i class="fa-solid fa-location-crosshairs"></i></span>
                                <span> {{ $productDetail->province->name ?? '...' }} -
                                    {{ $productDetail->district->name ?? '...' }} -
                                    {{ $productDetail->ward->name ?? '...' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-product-description">
                        <h3 class="title">
                            Mô tả chi tiết
                        </h3>
                        {!! $productDetail->description !!}
                    </div>
                </div>
                <div class="col-lg-4 no-padding">
                    <div class="sidebar">

                        <div class="detail-product-info-user">
                            <a href="#" class="d-flex">
                                <div class="product-info-user_thumbnail">
                                    <img src="{{ pare_url_file($productDetail->user->avatar ?? '') }}" width="100%"
                                        style="border-radius: 50%">
                                </div>
                                <div class="product-info-user-main">
                                    <div class="d-flex">
                                        <h3 class="title">
                                            {{ $productDetail->user->name ?? '' }}
                                        </h3>
                                        <button>
                                            <span><a href="{{ route('get.viewProfile', $productDetail->user->id ?? '') }}">Xem
                                                    trang</a></span>
                                            <span><i class="fa-solid fa-angle-right"></i></span>
                                        </button>
                                    </div>

                                    <div>
                                        <span class="product-info-user-main-icon"><i class="fa-solid fa-shop"></i></span>
                                        <span>Đại học Kinh tế TP. HCM</span>
                                    </div>
                                    {{-- <div>
                                        <span class="product-info-user-main-icon" style="font-size: 8px;"><i
                                                class="fa-solid fa-circle"></i></span>
                                        <span>Hoạt động 12 giờ trước</span>
                                    </div> --}}
                                    <div class="detail-product-evalution ml-2 mt-1">
                                        <div class="d-flex align-items-center ">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                        </div>
                                        {{-- <span>4.3</span> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="detail-product-ispartner-wrapper">
                            <div class="detail-product-ispartner">
                                <div class="ispartner-main d-flex align-items-center">
                                    <div class="ispartner-icon">
                                    </div>
                                    <span class="ispartner-text font-weight-bold">
                                        Là Đối Tác Chợ Tốt
                                    </span>
                                    <span class="ispartner-open"><i class="fa-solid fa-angle-up"></i></span>
                                </div>
                                <div class="ispartner-list mt-3 d-flex flex-column">
                                    <div class="ispartner-item my-1 d-flex">
                                        <div class="ispartner-icon">

                                        </div>
                                        <span class="ispartner-text">
                                            Đối Tác cam kết tình trạng xe và giá đúng như mô tả
                                        </span>
                                    </div>
                                    <div class="ispartner-item my-1 d-flex">
                                        <div class="ispartner-icon">

                                        </div>
                                        <span class="ispartner-text">
                                            Đối Tác cam kết tình trạng xe và giá đúng như mô tả
                                        </span>
                                    </div>
                                </div>
                                <a href="#" class="ispartner-link">Tìm hiểu thêm</a>
                            </div>
                        </div> --}}
                        <div class="contact-with-saler">
                            <div class="chat">
                                <div class="chat-title">
                                    <span>Liên hệ với người bán</span>
                                </div>
                            </div>
                            @if (Auth::check())
                                @if (Auth::user()->id == $productDetail->user->id)
                                    <div class="lead-button">
                                        <a id="delete_alert"
                                            href="{{ route('get.user.product_sold', $productDetail->id ?? '') }}"
                                            class="button-call d-flex">
                                            <div>
                                                <span><i class="fa-sharp fa-regular fa-eye-slash"></i></span>
                                            </div>
                                            <span>Đã bán / Ẩn tin</span>
                                        </a>
                                        <a href="{{ route('get.user.product_update', $productDetail->id ?? '') }}"
                                            class="button-chat d-flex">
                                            <div>
                                                <span><i class="fa-regular fa-pen-to-square"></i></span>
                                            </div>
                                            <span>Sửa tin</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="lead-button">
                                        <a href="#" class="button-call d-flex">
                                            <div>
                                                <span><i class="fa-solid fa-phone-volume"></i></span>
                                                <span
                                                    class="ml-2 d-inline-block">{{ $productDetail->user->phone ?? '' }}</span>
                                            </div>
                                            <span>Số để gọi</span>
                                        </a>

                                    </div>
                                @endif
                            @else
                                <div class="lead-button">
                                    <a href="#" class="button-call d-flex">
                                        <div>
                                            <span><i class="fa-solid fa-phone-volume"></i></span>
                                            <span
                                                class="ml-2 d-inline-block">{{ $productDetail->user->phone ?? '' }}</span>
                                        </div>
                                        <span>Số để gọi</span>
                                    </a>
                               
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detail-product-related-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-right: 0px;">
                    <div class="detail-product-related">
                        <div class="detail-product-related-title">
                            <h3 class="title mb-0">
                                Đồ dùng khác
                            </h3>
                            {{-- <a href="#">Xem tất cả</a> --}}
                        </div>
                        <div class="detail-product-related-slider owl-carousel">
                            @foreach ($productNews ?? [] as $item)
                                <div class="product-item ">
                                    <div class="product-thumbnail position-relative">
                                        <a href="{{ route('get.product.by_slug', ['slug' => $item->slug]) }}">
                                            <img src="{{ pare_url_file($item->avatar) }}" alt="{{ $item->name }}"
                                                width="100%">
                                        </a>
                                        <div class="product-heart">
                                            {{-- <i class="fa-regular fa-heart"></i> --}}
                                        </div>
                                    </div>
                                    <div class="product-caption">
                                        <div class="product-title d-flex ">
                                            <h3>
                                                <a href="{{ route('get.product.by_slug', ['slug' => $item->slug]) }}"
                                                    title="{{ $item->name }}"
                                                    class="product-link">{{ $item->name }}</a>
                                            </h3>
                                        </div>
                                        <span class="product-price ">
                                            {{ number_format($item->price, 0, ',', '.') }} đ
                                        </span>
                                    </div>
                                    <div class="product-footer d-flex align-items-center">
                                        <a href="#" class="d-flex align-items-center">
                                            <img src="{{ pare_url_file($item->user->avatar ?? '') }}"
                                                onerror="this.src='{{ asset('/assets/img/default_user.png') }}';"
                                                alt="" width="25px" height="25px" style="border-radius: 50%">
                                        </a>
                                        {{-- <div class="dot-divider">
                                        </div> --}}
                                        <div class="product-time mx-1 d-flex align-items-center">
                                            {{-- <span>{{ $item->created_at->format('d-m-Y') }}</span>  --}}
                                            <span>{{ $item->created_at->diffForHumans() }}</span>
                                        </div>
                                        {{-- <div class="dot-divider">
                                        </div> --}}
                                        <div class="product-address mx-1 d-flex align-items-center">
                                            <span>{{ $item->province->name ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(img) {
            let totalImage = document.querySelectorAll('.gallery-product-slide img')
            let previewImg = document.querySelector('.gallery-image-preview img');
            previewImg.src = img.src;
            let imageNumber = img.getAttribute('data-image-number');
            let previewImageNumber = document.querySelector('.preview-image-number');
            previewImageNumber.innerHTML = imageNumber + "/" + totalImage.length;
        }
    </script>
@stop
