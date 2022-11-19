$(function() {
    $('#btn_apply_coupon').click(function() {
        const code = $('#coupon').val();
        const total = $('#totalPrice').val();
        const feeShip = $('#feeShip').val();
        const url = $('#url_coupon').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                code: code,
                total: total,
                feeShip: feeShip
            },
            success: function(data) {
                if (data.error) {
                    $("#error_coupon").find("ul").html('');
                    $.each(data.error, function(key, value) {
                        $("#error_coupon").find("ul").append('<li>' + value +
                            '</li>');
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        text: 'Áp dụng mã giảm giá thành công',
                    })
                    $("#error_coupon").find("ul").html('');
                    $('#table_checkout').html(data);
                }
            }
        });
    })

    $(document).on('change', '.ward_id', function() {
        const city = $('#city').val();
        const district = $('#district').val();
        const ward = $('#ward').val();
        const discount = $('#discount').val();
        const coupon_code = $('#couponCode').val();
        const url = $('#url_fee_ship').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                city: city,
                district: district,
                ward: ward,
                discount: discount,
                coupon_code: coupon_code
            },
            success: function(data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    $('#table_checkout').html(data);
                }
            }
        });
    })
})