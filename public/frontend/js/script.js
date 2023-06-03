
// Loader
/* window.onload = () => {
    setTimeout(function(){
        document.querySelector(".loader-container").classList.add("active");
    }, 4000);
}; */

$(window).on("load", function () {
    $('.loader-container').fadeOut("slow");
});


// Home Book Stand Slider
var swiper = new Swiper(".stand-books-slider", {
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});

// Popular Book Section Slider
var swiper = new Swiper(".books-slider", {
    spaceBetween: 10,
    // centeredSlides: true,
    autoplay: {
        delay: 9500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        450: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});

// Fetch Api Data
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const fetchData = (elementContainer, loaderHTML, url, data = {}) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                // Show the Loading Spinner
                elementContainer.html(loaderHTML)
            },
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};