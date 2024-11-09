@extends('frontend.layouts.app_frontend')
@section('title_page', 'Trang cá nhân')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb">
                    <a href="/">Trang chủ</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                    <span>Sinh viên</span>
                </div>
                <h3 class="title">
                    <span>Danh sách tin đang đăng</span>
                </h3>
            </div>
        </div>
    </div>
    <div class="content-cartegory">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <ul class="list-product mt-2">
                        @foreach ($productOfUser ?? [] as $item)
                            @include('frontend.components._inc_profile_user', ['item' => $item])
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 no-padding">
                    <div class="sidebar mt-4">
                        @foreach ($productOfUser ?? [] as $item)
                            <div class="contact-with-saler">
                                <div class="detail-product-info-user">
                                    <a href="#" class="d-flex">
                                        <div class="product-info-user_thumbnail">
                                            <img src="{{ pare_url_file($item->user->avatar ?? '') }}" width="100%"
                                                style="border-radius: 50%">
                                        </div>
                                        <div class="product-info-user-main">
                                            <div class="d-flex">
                                                <h3 class="title">
                                                    {{ $item->user->name ?? '' }}
                                                </h3>
                                            </div>
                                            <div>
                                                <span class="product-info-user-main-icon"><i
                                                        class="fa-solid fa-shop"></i></span>
                                                <span>Trường CNTT - CTU</span>
                                                <span><span style="font-size: 12px">{{ $item->province->name ?? '...' }} -
                                                        {{ $item->district->name ?? '...' }} -
                                                        {{ $item->ward->name ?? '...' }}</span></span>
                                            </div>
                                            <div class="detail-product-evalution ml-2 mt-1">
                                                <div class="d-flex align-items-center ">
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="lead-button">
                                    <a href="#" class="button-call d-flex">
                                        <div>
                                            <span><i class="fa-solid fa-phone-volume"></i></span>
                                            <span class="ml-2 d-inline-block">{{ $item->user->phone ?? '' }}</span>
                                        </div>
                                        <span>Số để gọi</span>
                                    </a>
                                  
                                </div>
                            </div>
                        @break
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
