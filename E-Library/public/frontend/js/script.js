
// Loader
window.onload = () => {
    setTimeout(function(){
        document.querySelector(".loader-container").classList.add("active");
    }, 4000);
};

/* $(window).on("load", function(){
    $('.loader-container').fadeOut("slow");
}); */





let nCount = selector => {
    $(selector).each(function () {
        $(this)
            .animate({
                Counter: $(this).text()
            }, {
            // A string or number determining how long the animation will run.
            duration: 4000,
            // A string indicating which easing function to use for the transition.
            easing: "swing",
            /**
             * A function to be called for each animated property of each animated element.
             * This function provides an opportunity to
             *  modify the Tween object to change the value of the property before it is set.
             */
            step: function (value) {
                $(this).text(Math.ceil(value));
            }
        });
    });
};

let a = 0;
$(window).scroll(function () {
    // The .offset() method allows us to retrieve the current position of an element  relative to the document
    let oTop = $(".numbers").offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() >= oTop) {
        a++;
        nCount(".rect > h1");
    }
});



var swiper = new Swiper(".stand-books-slider", {
    centeredSlides: true,
    autoplay: {
        delay: 5500,
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

var swiper = new Swiper(".books-slider", {
    spaceBetween: 10,
    centeredSlides: true,
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
