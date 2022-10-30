$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        items: 5,
        margin: 2,
        autoplay: true,
        responsiveClass:true,
        responsive:{
            200: {
                items:1,
                nav:false
            },
            400:{
                items:2,
                nav:true
            },
            600:{
                items:4,
                nav:false,
                loop:true
            },
            800:{
                items:5,
                nav:false,
                loop:true
            },
            1200:{
                items:6,
                nav:false,
                loop:true
            }
        }
    });
});