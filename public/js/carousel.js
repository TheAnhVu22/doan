$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        items: 5,
        margin: 2,
        autoplay: true,
        responsiveClass:true,
        responsive:{
            400:{
                items:2,
                nav:false
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
            }
        }
    });
});