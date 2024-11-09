<li>
    <a href="{{ route('get.product.by_slug', ['slug' => $item->slug]) }}" title="{{ $item->name }}" class="product-detail-link d-flex position-relative">
        <div class="product-detail-thumbnail">
            <img src="{{ pare_url_file($item->avatar) }}" alt="{{ $item->name }}" width="100%" height="100%">
        </div>
        <div class="d-flex flex-column">
            <h3 class="product-detail-title">{{ $item->name }}</h3>   
            <p class="product-detail-price">{{ number_format($item->price, 0, ',', '.') }} đ</p> 
            <div style="flex: 1;"></div>
            <div class="product-footer d-flex align-items-center" style="font-size: 10px;">
                

                <img src="{{ pare_url_file($item->user->avatar ?? "") }}" alt="" width="16px" height="16px">
                <span class="d-none d-md-block">{{ $item->user->name ?? "[N/A]" }}</span>
                
               
                <div class="dot-divider">

                </div>
                <div class="product-time mx-1 d-flex align-items-center">
                    <span class="mr-1"><i class="fa-solid fa-medal"></i></span>
                    <span>Tin ưu tiên</span>
                </div>
                <div class="dot-divider">
                    
                </div>
                <div class="product-address mx-1 d-flex align-items-center">
                    <span>{{ $item->province->name ?? "[N/A]" }}</span>
                </div>
            </div>
        </div>
        <div class="product-detail-heart position-absolute">
            {{-- <span><i class="fa-regular fa-heart"></i></span> --}}
        </div>
    </a>
</li>