
// const productMoreElements = document.querySelectorAll('.product-more');


// productMoreElements.forEach(function(item) {
//     item.onclick = function() {
//         // Kiểm tra xem phần tử có lớp 'active' không
//         const isActive = item.classList.contains('active');

//         // Ẩn tất cả các phần tử có class 'product-more'
//         productMoreElements.forEach(function(element) {
//             element.classList.remove('active');
//         });

//         // Nếu phần tử đã được mở (đã có 'active'), thì xóa lớp 'active' để đóng lại
//         // Nếu phần tử chưa có 'active', thì thêm lớp 'active' để mở
//         if (!isActive) {
//             item.classList.add('active');
//         }
//     }
// });


// const productMoreElements = document.querySelectorAll('.product-more');

// // Thêm sự kiện click lên toàn bộ tài liệu (document)
// document.addEventListener('click', function(event) {
//     // Kiểm tra xem phần tử có lớp 'active' không
//     const isActive = document.querySelector('.product-more.active');

//     // Nếu có phần tử 'active', tắt nó
//     if (isActive) {
//         isActive.classList.remove('active');
//     }
// });

// productMoreElements.forEach(function(item) {
//     item.onclick = function(event) {
//         // Ngăn sự kiện click từ việc lan truyền lên đến document
//         event.stopPropagation();

//         // Kiểm tra xem phần tử có lớp 'active' không
//         const isActive = item.classList.contains('active');

//         // Ẩn tất cả các phần tử có class 'product-more'
//         productMoreElements.forEach(function(element) {
//             element.classList.remove('active');
//         });

//         // Nếu phần tử đã được mở (đã có 'active'), thì xóa lớp 'active' để đóng lại
//         // Nếu phần tử chưa có 'active', thì thêm lớp 'active' để mở
//         if (!isActive) {
//             item.classList.add('active');
//         }
//     }
// });

const productMoreElements = document.querySelectorAll('.product-more');

productMoreElements.forEach(function(item) {
    item.onclick = function() {
        // Kiểm tra xem phần tử có lớp 'active' không
        const isActive = item.classList.contains('active');

        // Ẩn tất cả các phần tử có class 'product-more'
        productMoreElements.forEach(function(element) {
            element.classList.remove('active');
            // Loại bỏ lớp 'active' từ icon trong mọi phần tử
            const icon = element.querySelector('.icon');
            if (icon) {
                icon.classList.remove('active-icon');
            }
        });

        // Nếu phần tử đã được mở (đã có 'active'), thì xóa lớp 'active' để đóng lại
        // Nếu phần tử chưa có 'active', thì thêm lớp 'active' để mở
        if (!isActive) {
            item.classList.add('active');
            // Thêm lớp 'active-icon' vào icon
            const icon = item.querySelector('.icon');
            if (icon) {
                icon.classList.add('active-icon');
            }
        }
    }
});
