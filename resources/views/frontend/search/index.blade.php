@extends('frontend.layouts.app_frontend')
@section('title_page', 'Tìm kiếm')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb">
                    <a href="/">Trang chủ</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>   
                    <span>Tìm kiếm</span>
                </div>
                <h3 class="title">
                    Tìm kiếm từ khóa: <b>{{ Request::get('k') }}</b>
                </h3>
            </div>
        </div>
    </div>

    <div class="content-cartegory">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <ul class="list-product mt-4">
                        @foreach ($products ?? [] as $item)
                            @include('frontend.components._inc_product_item', ["item" => $item])
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="col-lg-3 no-padding">
                    <div class="sidebar mt-4">
                        <div class="sidebar-item">
                            <a href="#">
                                <img src="/assets/img/Banner-blog-topcv-Sidebar-Right.webp" alt="" width="100%">
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@stop