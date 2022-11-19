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

    var rating = 0;
    $('.add-to-cart').click(function() {
        const id = $(this).data('product_id');
        const product_id = $('.product_id_' + id).val();
        const product_name = $('.product_name_' + id).val();
        const product_image = $('.product_image_' + id).val();
        const product_quantity = $('.product_quantity_' + id).val();
        const product_price = $('.product_price_' + id).val();
        const product_qty = $('.product_qty_' + id).val();
        const url = $('#add_product_to_cart').val();
        if (parseInt(product_qty) > parseInt(product_quantity)) {
            Swal.fire({
                icon: 'error',
                text: 'Làm ơn đặt nhỏ hơn ' + product_quantity,
            })
        } else if (parseInt(product_qty) > 5) {
            Swal.fire({
                icon: 'error',
                text: 'Làm ơn đặt nhỏ hơn 5',
            })
        } else {
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    product_id: product_id,
                    product_name: product_name,
                    product_image: product_image,
                    product_price: product_price,
                    product_quantity: product_quantity,
                    product_qty: product_qty,
                },
                success: function(data) {
                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            text: data.error,
                        })
                    } else {
                        Swal.fire({
                            title: 'Thêm sản phẩm vào giỏ hàng thành công!',
                            showCancelButton: true,
                            confirmButtonText: 'Đi đến giỏ hàng',
                            confirmButtonClass: "btn-success",
                            cancelButtonText: "Xem tiếp",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('/carts') }}";
                            }
                        })
                        count_cart();
                    }
                }
            });
        }
    });

    function remove_background(product_id) {
        for (let count = 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc');
        }
    }

    $('.rating').click(function() {
        const index = $(this).data('index');
        rating = index;
        const product_id = $(this).data('product_id');
        remove_background(product_id);
        for (let count = 1; count <= index; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }
    });

    $('.send_evaluate').click(function() {
        const product_id = $('#product_id').val();
        const phone = $('#phone').val();
        const url = $('#url_rating').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                rating: rating,
                phone: phone,
                product_id: product_id
            },
            success: function(data) {
                if (data.error) {
                    $("#error").find("ul").html('');
                    $.each(data.error, function(key, value) {
                        $("#error").find("ul").append('<li>' + value + '</li>');
                    });
                } else {
                    $("#error").find("ul").html('');
                    $('#phone').val('');
                    remove_background(product_id);
                    $('#show_rating').html(data)
                    Swal.fire(
                        'Gửi đánh giá sản phẩm thành công'
                    )
                }
            }
        });
    })

    $('.send_comment').click(function() {
        const product_id = $('#product_id').val();
        const name = $('#name').val();
        const content = $('#content').val();
        const url = $('#url_comment').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                name: name,
                content: content,
                product_id: product_id
            },
            success: function(data) {
                if (data.error) {
                    $("#error_comment").find("ul").html('');
                    $.each(data.error, function(key, value) {
                        $("#error_comment").find("ul").append('<li>' + value +
                            '</li>');
                    });
                } else {
                    $('#comments').html(data);
                    $("#error_comment").find("ul").html('');
                    $('#name').val('');
                    $('#content').val('');
                    Swal.fire(
                        "Bình luận thành công"
                    )
                }
            }
        });
    })
})