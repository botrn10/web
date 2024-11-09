<div class="filter">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="list-filter d-flex">
                    <div class="item-filter  selected">
                        <span><i class="fa-solid fa-filter"></i></span>
                        <span class="ml-2">Lọc</span>

                    </div>
                    <div class="item-filter ml-2 selected">
                        <span><i class="fa-solid fa-filter"></i></span>
                        <span class="ml-2">Lọc</span>
                        <span  class="ml-2"><i class="fa-solid fa-caret-down"></i></span>
                    </div>
                    <div class="item-filter ml-2 selected">
                        <span >Lọc</span>
                        <span  class="ml-2"><i class="fa-solid fa-caret-down"></i></span>
                    </div>
                    <div class="item-filter ml-2">
                        <span>Lọc</span>
                        <span class="ml-2">+</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup-filter">
    <div class="popup-content">
        <div class="popup-filter-header d-flex justify-content-between align-items-center">
            <span class="close">&times;</span>
            <p class="mb-0 ">Lọc kết Quả</p>
            <a href="#">Bỏ lọc</a>
        </div>
        <div class="popup-filter-body">
            <div class="popup-option-field">
                <div class="d-flex flex-column">
                    <span>Danh mục</span>
                    <a href="#">Xe máy</a>
                </div>
                <span><i class="fa-solid fa-angle-right"></i></span>
            </div>
            <div class="popup-option-range">
                <div class="price-filter-input">
                    <div class="field">
                      <span>Giá từ</span>
                      <span class="field-value-min mx-1 font-weight-bold">

                      </span>
                      <span class="mr-1">đ</span>
                      <input type="number" class="input-min d-none" value="0">
                    </div>
                    <div class="field">
                      <span>Đến</span>
                      <span class="field-value-max mx-1 font-weight-bold">

                      </span>
                      <span>+ đ</span>
                      <input type="number" class="input-max d-none" value="100000">
                    </div>
                  </div>
                  <div class="slider-range">
                    <div class="progress"></div>
                  </div>
                  <div class="range-input">
                    <input type="range" class="range-min" min="0" max="10000" value="0" step="100">
                    <input type="range" class="range-max" min="0" max="10000" value="100000" step="100">
                  </div>
            </div>
            
            <div class="popup-option-field mt-4">
                <div class="d-flex flex-column">
                    <span>Danh mục</span>
                    <a href="#">Xe máy</a>
                </div>
                <span><i class="fa-solid fa-angle-right"></i></span>
            </div>
            <div class="popup-option-range">
                <div class="year-price-filter-input">
                    <div class="year-field">
                      <span>Năm đăng ký từ <strong>trước năm </strong></span>
                      <span class="year-field-value-min mx-1 font-weight-bold">

                      </span>
                      <input type="number" class="year-input-min d-none" value="1980">
                    </div>
                    <div class="year-field">
                      <span>đến</span>
                      <span class="year-field-value-max mx-1 font-weight-bold">

                      </span>
                      <input type="number" class="year-input-max d-none" value="2023">
                    </div>
                  </div>
                  <div class="year-slider-range">
                    <div class="year-progress"></div>
                  </div>
                  <div class="year-range-input">
                    <input type="range" class="year-range-min" min="1980" max="2023" value="1980" step="1">
                    <input type="range" class="year-range-max" min="1980" max="2023" value="2023" step="1">
                  </div>
            </div>

            <div class="popup-option-check mt-4">
                <h3 class="title">Sắp xếp theo</h3>
                <ul class="popup-option-check-list">
                    <li class="d-flex align-items-center justify-content-between">
                        <label class="mb-0" for="tinmoitruoc">
                            <span><i class="fa-regular fa-clock"></i></span>
                            <span>Tới mới trước</span>
                        </label>
                        <input id="tinmoitruoc" type="radio" name="news">
                    </li>
                    <li class="d-flex align-items-center justify-content-between">
                        <label class="mb-0" for="giathaptruoc">
                            <span><i class="fa-regular fa-clock"></i></span>
                            <span>Giá thấp trước</span>
                        </label>
                        <input id="giathaptruoc" type="radio" name="news">
                    </li>
                </ul>
            </div>
            
            <div class="popup-option-check mt-4">
                <h3 class="title">Sắp xếp theo</h3>
                <ul class="popup-option-check-list">
                    <li class="d-flex align-items-center justify-content-between">
                        <label class="mb-0" for="dangdoi1">
                            <span><i class="fa-regular fa-clock"></i></span>
                            <span>Tới mới trước</span>
                        </label>
                        <input id="dangdoi1" type="checkbox" name="dangboi">
                    </li>
                    <li class="d-flex align-items-center justify-content-between">
                        <label class="mb-0" for="dangboi2">
                            <span><i class="fa-regular fa-clock"></i></span>
                            <span>Giá thấp trước</span>
                        </label>
                        <input id="dangboi2" type="checkbox" name="dangboi">
                    </li>
                </ul>
            </div>
        </div>
        <div class="popup-filter-footer">
            <button>ÁP DỤNG</button>
        </div>
    </div>
</div>