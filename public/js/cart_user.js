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

    $(document).on('click', '.btn_remove_product', function() {
        const url = $(this).data('url');
        const product = $(this).data('product');
        Swal.fire({
            title: 'Bạn có chắc muốn xóa sản phẩm khỏi giỏ hàng không?',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            confirmButtonClass: "btn-success",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'),
                    },
                    data: {
                        product: product
                    },
                    success: function(data) {
                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                text: data.error,
                            })
                        } else {
                            count_cart();
                            $('#show_cart').html(data);
                        }
                    }
                });
            }
        })

    })

    function updateQuantity(product, product_quantity) {
        const sales_quantity = $('.product_qty_' + product).val();
        const quantity = product_quantity
        const url = $('#update_quantity').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                product: product,
                quantity: quantity,
                sales_quantity: sales_quantity
            },
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        text: data.error,
                    })
                } else {
                    $('#show_cart').html(data);
                }
            }
        });
    };

    $(document).on('click', '.minus', function() {
        const product = $(this).data('id');
        const quantity = $('.product_qty_' + product);
        let count = parseInt(quantity.val());
        const product_quantity = $(this).data('quantity');
        if (count > 1) {
            count = count - 1;
            quantity.val(count);
            updateQuantity(product, product_quantity);
            return false;
        }
    });

    $(document).on('click', '.plus', function() {
        const product = $(this).data('id');
        const quantity = $('.product_qty_' + product);
        let count = parseInt(quantity.val());
        const product_quantity = $(this).data('quantity');
        if (count < product_quantity && count < 5) {
            count = count + 1;
            quantity.val(count);
            updateQuantity(product, product_quantity);
        }
    });
})