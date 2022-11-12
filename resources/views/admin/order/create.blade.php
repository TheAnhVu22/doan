@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Quản lý đơn hàng</h1>
@stop

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
    <div class="container-fluid">
        @include('admin.layouts.alert')
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            @include('admin.order._form')
        </form>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/shipping.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\OrderStoreRequest') !!}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>s
    <script>
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
    </script>
@endpush
