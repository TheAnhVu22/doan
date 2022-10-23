$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        autoplay: true,
        responsiveClass:true,
        responsive:{
            600:{
                items:2,
                nav:false
            },
            800:{
                items:3,
                nav:false,
                loop:true
            },
            1100:{
                items:4,
                nav:false,
                loop:true
            }
        }
    });
});