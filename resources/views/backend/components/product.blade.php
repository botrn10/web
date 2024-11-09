@if ($products)
    <style>
        .gallery-wrap .img-big-wrap img {
            height: 450px;
            width: auto;
            display: inline-block;
            cursor: zoom-in;
        }

        .gallery-wrap .img-small-wrap .item-gallery {
            width: 60px;
            height: 60px;
            border: 1px solid #ddd;
            margin: 7px 2px;
            display: inline-block;
            overflow: hidden;
        }

        .gallery-wrap .img-small-wrap {
            text-align: center;
        }

        .gallery-wrap .img-small-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 4px;
            cursor: zoom-in;
        }

        .gallery-wrap .img-big-wrap img {
            max-height: 450px;
            max-width: 100%;
            display: inline-block;
            cursor: zoom-in;
        }

        .gallery-wrap .img-small-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 4px;
            cursor: zoom-in;
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="row">
                @foreach ($products as $key => $product)
                    <aside class="col-sm-4 border-right">
                        <article class="gallery-wrap">
                            <div class="img-big-wrap">
                                <div> <a href="#"><img
                                            src="{{ isset($product->avatar) ? pare_url_file($product->avatar) : '' }}"
                                            style="padding-left: 12px; padding-top: 10px"></a>
                                </div>
                            </div> <!-- slider-product.// -->
                        </article> <!-- gallery-wrap .end// -->
                    </aside>
                    <aside class="col-sm-7">
                        <article class="card-body p-5">
                            <h3 class="title mb-3">{{ $product->name ?? 'NA' }}</h3>

                            <p class="price-detail-wrap">
                                <span class="price h3 text-danger">
                                    <span class="currency">{{ $product->price ?? 'NA' }} VNĐ</span>
                                </span>
                            </p> <!-- price-detail-wrap .// -->
                            <dl class="item-property">
                                <dt>Mô tả</dt>
                                <dd>
                                    <p>{{ $product->description ?? 'NA' }}</p>
                                </dd>
                            </dl>
                            <dl class="param param-feature">
                                <dt>Danh mục</dt>
                                <dd>{{ $product->category->name ?? 'NA' }}</dd>
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>Người đăng</dt>
                                <dd>{{ $product->user->name ?? '[N\A]' }}</dd>
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>Địa chỉ</dt>
                                <dd><span> {{ $product->province->name ?? '...' }} -
                                        {{ $product->district->name ?? '...' }} -
                                        {{ $product->ward->name ?? '...' }}</span></dd>
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>Số điện thoại</dt>
                                <dd>{{ $product->user->phone ?? '[N\A]' }}</dd>
                            </dl> <!-- item-property-hor .// -->
                        </article> <!-- card-body.// -->
                    </aside> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->
        </div> <!-- card.// -->
    </div>
    <!--container.//-->
@endif
