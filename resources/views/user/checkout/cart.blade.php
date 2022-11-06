@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <style>
        .btn_remove_product {
            color: red;
            border: 1px solid red;
            border-radius: 10px;
            background: transparent;
            cursor: pointer;
        }

        .quantity span {
            cursor: pointer;
        }

        .minus,
        .plus {
            width: 20px;
            background: #f2f2f2;
            border-radius: 4px;
            border: 1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
            text-align: center;
        }

        input#getQuantity {
            max-height: 27px;
            max-width: 50px;
            text-align: center;
            font-size: 1.4rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Giỏ hàng</h3>
        <div id="show_cart">
            @include('user.checkout.table_cart')
        </div>
        <div class=" d-flex justify-content-end">
            <input type="hidden" id="update_quantity" value="{{ route('update_quantity') }}">
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Tiếp tục</a>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function() {
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
                                    $('#show_cart').html(data);
                                }
                            }
                        });
                    }
                })

            })

            function updateQuantity(product) {
                const quantity = $('.product_qty_' + product).val();
                const url = $('#update_quantity').val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        product: product, quantity: quantity
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
                if (count > 1) {
                    count = count - 1;
                    quantity.val(count);
                    updateQuantity(product);
                    return false;
                }
            });

            $(document).on('click', '.plus', function() {
                const product = $(this).data('id');
                const quantity = $('.product_qty_' + product);
                let count = parseInt(quantity.val());
                if (count < 5) {
                    count = count + 1;
                    quantity.val(count);
                    updateQuantity(product);
                }
            });
        })
    </script>
@endpush
