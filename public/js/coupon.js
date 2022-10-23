$(function() {
    $('.typeDiscount').change(function() {
        let type = $(this).val();
        let value = $('#value').val();

        $('#value').val(1).focus();
        $('#value').val(value + 1).blur();
        $('#value').val(value).focus();
        $('#value').blur();

        if (type == 1) {
            $('#valueCoupon').html('Giá trị giảm (theo %):');
        } else {
            $('#valueCoupon').html('Giá trị giảm (theo VNĐ):');
        }
    });
})