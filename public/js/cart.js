$(function() {
    function count_cart() {
        const url = $('#url_count_cart').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {},
            success: function(data) {
                if (data == 0) {
                    $('#count_cart').html('');
                } else {
                    $('#count_cart').html(data);
                }
            }
        });
    }

    count_cart();
})