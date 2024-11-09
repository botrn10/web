@extends('frontend.layouts.app_frontend')
@section('title_page', 'Trang chủ')
@section('content')
<div class="content1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="slider owl-carousel owl-theme">
                    {{-- Slide 1 --}}
                    <div class="slider-img mb-3">
                        <a href="#" target="_blank">
                            <img src="{{ asset('uploads/2023/08/27/ueh-1.jpg') }}" alt="Ảnh 1" width="100%">
                        </a>
                    </div>
                    {{-- Slide 2 --}}
                    <div class="slider-img mb-3">
                        <a href="#" target="_blank">
                            <img src="{{ asset('uploads/2023/08/27/ueh-2.jpg') }}" alt="Ảnh 2" width="100%">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="content2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="category">
                        <h3 class="title">Danh mục sản phẩm</h3>
                        <ul class="list-category owl-carousel position-relative">
                            @foreach ($categories->chunk(1) ?? [] as $category)
                                <li class="col-category d-flex flex-column align-items-center">
                                    @foreach ($category as $item)
                                        <a href="{{ route('get.category.by_slug', ['slug' => $item->slug]) }}"
                                            title="{{ $item->name }}"
                                            class="item-category d-flex flex-column align-items-center">
                                            <img src="{{ pare_url_file($item->avatar) }}" alt="{{ $item->name }}"
                                                width="84px" height="84px" class="category-img">
                                            <span>{{ $item->name }}</span>
                                        </a>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content3 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="title">
                        Có thể bạn thích
                    </h3>
                </div>
            </div>
            <div class="row no-gutters mt-2 mb-2">
                @foreach ($productNews ?? [] as $item)
                    <div class="col-lg-2dot4 col-6 col-md-4">
                        <div class="product-item ">
                            <div class="product-thumbnail position-relative">
                                <a href="{{ route('get.product.by_slug', ['slug' => $item->slug]) }}">
                                    <img src="{{ pare_url_file($item->avatar) }}" alt="{{ $item->name }}"
                                        width="100%">
                                </a>
                            </div>
                            <div class="product-caption">
                                <div class="product-title d-flex justify-content-between">
                                    <h3>
                                        <a href="{{ route('get.product.by_slug', ['slug' => $item->slug]) }}"
                                            title="{{ $item->name }}" class="product-link">{{ $item->name }}</a>
                                    </h3>
                                </div>
                                <span class="product-price ">
                                    {{ number_format($item->price, 0, ',', '.') }} đ
                                </span>
                            </div>
                            <div class="product-footer d-flex align-items-center">
                                <a href="#" class="d-flex align-items-center">
                                    <img src="{{ pare_url_file($item->user->avatar ?? '') }}"
                                        onerror="this.src='{{ asset('/assets/img/default_user.png') }}';" alt=""
                                        width="25px" height="25px" style="border-radius: 50%">
                                </a>
                                <div class="product-time mx-1 d-flex align-items-center">
                                    <span>{{ $item->created_at->diffForHumans() }} : </span>
                                </div>
                                <div class="product-address mx-1 d-flex align-items-center">
                                    <span>{{ $item->province->name ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $productNews->links() }}

            <div class="row">
                {{-- <div class="col-lg-12">
                    <h4 class="text-more">
                        <a href="#">Xem thêm</a>
                    </h4>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- Notifications chatify start --}}

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: 'ap1',
            encrypted: true
        });

        // console.log("");

        var channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function(data) {
            // alert("");
            $.ajax({
                type: 'GET',
                url: '/updateunseenmessage',
                data: {

                },
                success: function(data){
                    
                    console.log(data.unseenCounter);

                    $('.pending-div').empty();
                    html = ``;
                    if(data.unseenCounter > 0){
                        html += `<span style="right:68px;" class="pending-notification-chat">${data.unseenCounter}`
                    }
                    $('.pending-div').html(html);
                },
            });
        });
    </script> --}}

    {{-- Notifications chatify end --}}
@stop
