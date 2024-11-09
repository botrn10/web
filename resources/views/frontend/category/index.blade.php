@extends('frontend.layouts.app_frontend')
@section('title_page', $category->name)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcumb">
                    <a href="#">{{ $category->name }}</a>
                    <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>   
                    {{-- <span>Xe máy</span> --}}
                </div>
                <h3 class="title">
                    Danh mục sản phẩm: {{ $category->name }}
                </h3>
            </div>
        </div>
    </div>

    <div class="content-cartegory">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-product mt-4">
                        @foreach ($products ?? [] as $item)
                            @include('frontend.components._inc_product_item', ["item" => $item])
                        @endforeach
                    </ul>

                    {{-- <div class="filterSuggestionWrapper">
                        <div class="filterSuggestionWrapper-title">
                            <div class="motorbikeIconTitle">

                            </div>
                            <div class="titleText">
                                Loại hộp số bạn cần tìm?
                            </div>
                            <div class="carIconTitle">

                            </div>
                        </div>
                        <div>
                            <div class="list-option">
                                <div class="option-item">
                                    <a href="#">Xe tay ga</a>
                                </div>
                                <div class="option-item">
                                    <a href="#">Xe tay ga</a>
                                </div>
                                <div class="option-item">
                                    <a href="#">Xe tay ga</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="panigation">
                        <div class="panigation-item">
                            <span ><i class="fa-solid fa-angle-left"></i></span>
                        </div>
                        <div class="panigation-item">
                            <span class="active">1</span>
                        </div>
                        <div class="panigation-item">
                            <span >2</span>
                        </div>
                        <div class="panigation-item">
                            <span ><i class="fa-solid fa-angle-right"></i></span>
                        </div>
                    </div> --}}
                    
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