// Hiển thị bộ chọn emoji
$(document).ready(function() {
    $("textarea").emojioneArea({
        pickerPosition: "bottom"
    });

    // Khi người dùng nhấn vào nút hình ảnh
    $(".image-btn").on("click", function() {
        $(".image-upload").click();
    });

    // Hiển thị ảnh đã chọn
    $(".image-upload").on("change", function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(".image-preview").html('<img src="' + e.target.result + '" width="150px" height="100%" alt="Image Preview" class="rounded">');
            };
            reader.readAsDataURL(file);
        }
    });


    //Hiển thị hộp thoại toast trong 3s
    var toastEl = $('.toast');
    var toast = new bootstrap.Toast(toastEl, {
        delay: 3000 // thời gian hiển thị (3000ms = 3 giây)
    });
    toast.show(); // Hiển thị toast
});

//Đánh giá sao cho phim 
document.addEventListener('DOMContentLoaded', (event) => {
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingForm = document.getElementById('rating-form');
    const ratingInput = document.getElementById('rating-input');

    ratingStars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const ratingValue = star.getAttribute('data-value');
            highlightStars(ratingValue);
        });

        star.addEventListener('mouseout', () => {
            const currentRating = ratingInput.value || 0; // If no value, default to 0
            highlightStars(currentRating); 
        });

        star.addEventListener('click', () => {
            const ratingValue = star.getAttribute('data-value');
            ratingInput.value = ratingValue;
            highlightStars(ratingValue);

            // Automatically submit the form
            ratingForm.submit();
        });
    });

    function highlightStars(rating) {
        let currentStarIndex = 0; 
        ratingStars.forEach(s => {
            s.classList.toggle('text-warning', currentStarIndex < rating);
            s.classList.toggle('text-secondary', currentStarIndex >= rating);
            currentStarIndex++; 
        });
    }
});


//Chọn server phim 
document.addEventListener('DOMContentLoaded', (event) => {
    const server1Btn = document.getElementById('server1-btn');
    const server2Btn = document.getElementById('server2-btn');
    const movieIframe = document.getElementById('movie-iframe');

    server1Btn.addEventListener('click', () => {
        movieIframe.src = server1Btn.getAttribute('data-server');
        server1Btn.classList.add('btn-primary');
        server1Btn.classList.remove('btn-secondary');
        server2Btn.classList.add('btn-secondary');
        server2Btn.classList.remove('btn-primary');
    });

    server2Btn.addEventListener('click', () => {
        movieIframe.src = server2Btn.getAttribute('data-server');
        server2Btn.classList.add('btn-primary');
        server2Btn.classList.remove('btn-secondary');
        server1Btn.classList.add('btn-secondary');
        server1Btn.classList.remove('btn-primary');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const filterButton = document.querySelector('.movies-filter');
    const filterForm = document.querySelector('.filter-form');

    filterButton.addEventListener('click', function() {
        if (filterForm.classList.contains('active')) {
            filterForm.classList.remove('active');
        } else {
            filterForm.classList.add('active');
        }
    });
});

/*
function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        const avatarThumbnail = document.createElement('img');
        avatarThumbnail.src = e.target.result;
        avatarThumbnail.className = 'rounded-circle mt-3';
        avatarThumbnail.style.width = '100px';
        avatarThumbnail.style.height = '100px';
        avatarThumbnail.style.objectFit = 'cover';

        const previewContainer = document.getElementById('avatar-thumbnail-preview');
        previewContainer.innerHTML = ''; // Clear the container
        previewContainer.appendChild(avatarThumbnail); // Add the new preview
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}
*/

//dark mode, light mode
// Kiểm tra chế độ đã lưu trong localStorage
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const themeToggle = document.getElementById('theme-toggle');
    
    // Kiểm tra localStorage có giá trị không, nếu không thì mặc định là 'dark'
    const currentTheme = localStorage.getItem('theme') || 'dark';
    body.classList.add(currentTheme);
    
    // Cập nhật nút toggle khi tải trang
    if (currentTheme === 'dark') {
        themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i> Sáng';
    } else {
        themeToggle.innerHTML = '<i class="fa-regular fa-moon"></i> Tối';
    }
    
    // Khi bấm nút toggle
    themeToggle.addEventListener('click', function() {
        body.classList.toggle('light');
        body.classList.toggle('dark');
        
        // Lưu trạng thái mới vào localStorage
        const newTheme = body.classList.contains('dark') ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        
        // Cập nhật văn bản cho nút toggle
        if (newTheme === 'dark') {
            themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i> Sáng';
        } else {
            themeToggle.innerHTML = '<i class="fa-regular fa-moon"></i> Tối';
        }
    });
});

// Swiper cho các phim liên quan
var swiper = new Swiper('.related-movies .swiper', {
    slidesPerView: 5,  
    spaceBetween: 10,  
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    loop: true,  
    autoplay: {
        delay: 3000,  
        disableOnInteraction: false,  
    },
    breakpoints: {
        // Kích thước màn hình >= 320px (thiết bị di động nhỏ)
        320: {
            slidesPerView: 3,  // Hiển thị 3 slide trên thiết bị di động
            spaceBetween: 20,   // Khoảng cách nhỏ hơn giữa các slide
        },
        // Kích thước màn hình >= 768px (tablet)
        768: {
            slidesPerView: 4,  // Hiển thị 4 slide trên tablet
            spaceBetween: 20,
        },
        // Kích thước màn hình >= 1024px (desktop)
        1024: {
            slidesPerView: 5,  // Hiển thị 5 slide trên màn hình lớn
            spaceBetween: 20,
        }
    }
});

var swiper = new Swiper('#swiper-newUpdate .swiper', {
    slidesPerView: 5,  
    spaceBetween: 10,  
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    loop: true,  
    breakpoints: {
        // Kích thước màn hình >= 320px (thiết bị di động nhỏ)
        320: {
            slidesPerView: 3,  // Hiển thị 3 slide trên thiết bị di động
            spaceBetween: 20,   // Khoảng cách nhỏ hơn giữa các slide
        },
        // Kích thước màn hình >= 768px (tablet)
        768: {
            slidesPerView: 6,  // Hiển thị 4 slide trên tablet
            spaceBetween: 20,
        },
        // Kích thước màn hình >= 1024px (desktop)
        1024: {
            slidesPerView: 9,  // Hiển thị 5 slide trên màn hình lớn
            spaceBetween: 20,
        }
    }
});