$(function() {
    $(document).on('change', '.ward_id', function() {
        const city = $('#city').val();
        const district = $('#district').val();
        const ward = $('#ward').val();
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
            },
            success: function(data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    $('#list_product').html(data);
                }
            }
        });
    })

    $('#btn_search').click(function() {
        let keyword = $('#keyword').val();
        const url = $('#url_search').val();
        keywords = keyword ?? 'all';
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                keywords: keywords
            },
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        text: data.error,
                    })
                } else {
                    $('#all_product').html(data);
                }
            }
        });
    })

    $(document).on('click', '#btn_add_product', function() {
        const product_id = $(this).data('product_id');
        const feeShip = $('#feeShip').val();
        const url = $('#url_add').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                product_id: product_id,
                feeShip: feeShip
            },
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        text: data.error,
                    })
                } else {
                    $('#list_product').html(data);
                }
            }
        });
    })

    $(document).on('click', '.btn_remove_product', function() {
        const url = $(this).data('url');
        const product = $(this).data('product');
        const feeShip = $('#feeShip').val();
        Swal.fire({
            title: 'Bạn có chắc muốn xóa sản phẩm khỏi đơn hàng không?',
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
                        product: product,
                        feeShip: feeShip
                    },
                    success: function(data) {
                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                text: data.error,
                            })
                        } else {
                            $('#list_product').html(data);
                        }
                    }
                });
            }
        })
    })

    function updateQuantity(product, product_quantity) {
        const quantity = $('.product_qty_' + product).val();
        const url = $('#update_quantity').val();
        const feeShip = $('#feeShip').val();
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                product: product,
                quantity: quantity,
                feeShip: feeShip,
                product_quantity: product_quantity
            },
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        text: data.error,
                    })
                } else {
                    $('#list_product').html(data);
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