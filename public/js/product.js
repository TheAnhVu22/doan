$(function() {
    $('.minus').click(function() {
        let input = $(this).parent().find('input');
        let count = parseInt(input.val()) - 1;
        count = count < 1 ? 1 : count;
        input.val(count);
        return false;
    });

    $('.plus').click(function() {
        let input = $(this).parent().find('input');
        let count = parseInt(input.val());
        const quantity = $(this).data('quantity');
        if(count < quantity && count < 5){
            count = count + 1;
            input.val(count);
        }
    });

    $('#imageGallery').lightSlider({
        gallery: true,
        auto: true,
        item: 1,
        loop: true,
        thumbItem: 3,
        slideMargin: 0,
        enableDrag: true,
        currentPagerPosition: 'left',
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }
    });
})