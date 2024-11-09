let $slider = $(".owl-carousel.slider");
if ($slider.length > 0 ) {
    $('.owl-carousel.slider').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3000,
    })
}

let $galleryProductSlide = $(".gallery-product-slide");
if ($galleryProductSlide.length > 0 ) {
    $('.owl-carousel.gallery-product-slide').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        items: 1,
        navText: ['<i class="fa-solid fa-angle-left"></i>','<i class="fa-solid fa-angle-right"></i>'],
        responsive: {
            768: {
                items: 5,
            }
        }
    })
}


$('.owl-carousel.product-related').owlCarousel({
    loop:true,
    nav:false,
    items: 2.2,
    autoplay: true,
    autoplayTimeout: 3000,
    navText: ['<i class="fa-solid fa-angle-left"></i>','<i class="fa-solid fa-angle-right"></i>'],
    responsive: {
        768:{
            items: 3.4,
        }
    }
})

$('.owl-carousel.detail-product-related-slider').owlCarousel({
    loop:true,
    nav:false,
    items: 2,
    margin: 1,
    autoplay: true,
    autoplayTimeout: 3000,
    navText: ['<i class="fa-solid fa-angle-left"></i>','<i class="fa-solid fa-angle-right"></i>'],
    responsive: {
        768:{
            items: 5,
        }
    }
})

$('.owl-carousel.sub-menu-slider').owlCarousel({
    loop:false,
    margin:10,
    nav:false,
    items: 4,
    autoplay: false,
    autoplayTimeout: 3000,
    responsive : {
        768 : {
            items: 9,
        }
    }
})


$('.owl-carousel.list-category').owlCarousel({
    loop:false,
    margin:10,
    nav:false,
    items: 3,
    autoplay: false,
    autoplayTimeout: 3000,
    navText: ['<i class="fa-solid fa-angle-left"></i>','<i class="fa-solid fa-angle-right"></i>'],
    responsive : {
        768 : {
            nav: true,
            items: 7,
        }
    }
})


let item_menu = document.querySelectorAll('.item-menu');
item_menu.forEach(function(item){
    item.onclick = function(e){
        e.stopPropagation();
        item.classList.toggle("active");
    }
})

let product_more = document.querySelectorAll('.product-more')

product_more.forEach(function(item){
    item.onclick = function (e){
        e.preventDefault()
        item.classList.toggle('active')
    }
})

let open_profile_user = document.querySelector('.open-profile-user')
let profile_user_mobile = document.querySelector('.profile-user-mobile')

// open_profile_user.onclick = function (e){
//     e.preventDefault()
//     this.classList.toggle('active')
//     profile_user_mobile.classList.toggle('active')
// }


// Lấy đối tượng nút mở Popup
var btn_item_filter = document.querySelectorAll('.item-filter');

// Lấy đối tượng Popup
var popup_filter = document.querySelector(".popup-filter");

// Lấy đối tượng nút đóng Popup
var span = document.getElementsByClassName("close")[0];
btn_item_filter.forEach(function(item){
    item.onclick = function(event){
        event.preventDefault();
        popup_filter.style.display = "block"
    }
})

// Khi người dùng nhấp vào nút đóng hoặc bất kỳ nơi nào bên ngoài Popup, đóng Popup
if (span)
{
    span.onclick = function() {
        popup_filter.style.display = "none";
    }
}

window.onclick = function(event) {
  if (event.target == popup_filter) {
    popup_filter.style.display = "none";
  }
}

function priceRange(){
    const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-filter-input input"),
    range = document.querySelector(".slider-range .progress");

    let field_value_min = document.querySelectorAll('.field-value-min')
    let field_value_max = document.querySelectorAll('.field-value-max');
    if (priceInput.length > 0) {
        field_value_min[0].textContent = priceInput[0].value
        field_value_max[0].textContent = priceInput[1].value
    }

    rangeInput.forEach(input =>{
        input.addEventListener("input", e =>{
            let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);


                priceInput[0].value = minVal;
                field_value_min[0].textContent = minVal;
                priceInput[1].value = maxVal;
                field_value_max[0].textContent = maxVal;
                range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

        });
    });
}

priceRange()


function yearRange(){
    const rangeInput = document.querySelectorAll(".year-range-input input"),
    priceInput = document.querySelectorAll(".year-price-filter-input input"),
    range = document.querySelector(".year-slider-range .year-progress");

    let field_value_min = document.querySelectorAll('.year-field-value-min')
    let field_value_max = document.querySelectorAll('.year-field-value-max')
    if (priceInput.length > 0) {
        field_value_min[0].textContent = priceInput[0].value
        field_value_max[0].textContent = priceInput[1].value
    }

    rangeInput.forEach(input =>{
        input.addEventListener("input", e =>{
            let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);


                priceInput[0].value = minVal;
                field_value_min[0].textContent = minVal;
                priceInput[1].value = maxVal;
                field_value_max[0].textContent = maxVal;
                range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                range.style.right =(maxVal / rangeInput[1].max) * 100 + "%";

        });
    });
}

yearRange()


