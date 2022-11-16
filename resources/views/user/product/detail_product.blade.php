@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('lightslider/css/lightslider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lightslider/css/prettify.css') }}">
    <link rel="stylesheet" href="{{ asset('lightslider/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
    <style>
        ul.lSGallery li,
        ul.lSGallery li img {
            height: 70px;
        }

        .img-hover-zoom img {
            width: inherit;
        }

        .rating {
            cursor: pointer;
            color: #ccc;
            font-size: 30px;
        }

        .send_evaluate {
            max-height: 38px;
        }

        .scroll {
            max-height: 600px;
            overflow: hidden;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: none;">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('category_product', ['slug' => $product->slug]) }}">{{ $product->category?->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row col-12">
            <div class="col-md-8 row">
                <div class="col-sm-6">
                    <ul id="imageGallery">
                        @foreach ($product->productImages as $key => $image)
                            <li data-thumb="{{ asset('uploads/product_images/' . $image->image) }}"
                                data-src="{{ asset('uploads/product_images/' . $image->image) }}">
                                <img height="300" width="100%"
                                    src="{{ asset('uploads/product_images/' . $image->image) }}" />
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 border-bottom pt-3">
                    <h4>{{ $product->name }}</h4>
                    <div class="ml-3" id="show_rating">
                        @include('user.product.rating')
                    </div>
                    <small>Thương hiệu: <b>{{ $product->brand?->name }}</b></small>
                    <p class="price">
                        @if ($product->discount)
                            <strike>{{ number_format($product->price, 0, ',', '.') }}</strike>
                            {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }} đ
                        @else
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        @endif
                    </p>
                    <p>Tình trạng:
                        @if ($product->quantity === 0)
                            <span class="text-danger">Hết hàng</span>
                        @else
                            <span class="text-success">Còn hàng</span>
                            <div class="quantity">
                                <span class="minus">-</span>
                                <input type="text" class="product_qty_{{ $product->id }}" id="getQuantity"
                                    name="quantity" value="1" onkeydown="return false;" />
                                <span class="plus" data-quantity="{{ $product->quantity }}">+</span>
                            </div>

                            <input type="hidden" value="{{ $product->id }}" class="product_id_{{ $product->id }}">
                            <input type="hidden" value="{{ $product->name }}" class="product_name_{{ $product->id }}">
                            <input type="hidden" value="{{ $product->quantity }}"
                                class="product_quantity_{{ $product->id }}">
                            <input type="hidden" value="{{ optional($product->productImages)[0]?->image }}"
                                class="product_image_{{ $product->id }}">
                            <input type="hidden" value="{{ $product->price }}"class="product_price_{{ $product->id }}">
                            <input type="hidden" name="add_product_to_cart" id="add_product_to_cart"
                                value="{{ route('add_product_to_cart') }}">

                            <button type="button" class="mt-1 btn btn-success add-to-cart"
                                data-product_id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i> Thêm giỏ hàng</button>
                        @endif
                    </p>
                    <div class="mb-2">
                        <p>Từ khóa:</p>
                        @foreach ($product->tags as $tag)
                            <a href="{{ route('search_product', ['keywords' => $tag->name]) }}"
                                class="badge badge-info p-2">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4 card">
                <b class="mb-1">Chính sách mua hàng</b>
                <p><i class="fas fa-check-circle"></i> Cam kết hàng chính hãng 100%</p>
                <p><i class="fas fa-sync"></i> Đổi trả trong vòng 15 ngày</p>
                <p><i class="fas fa-truck"></i> Miễn phí giao hàng cho đơn từ 1 triệu</p>
                <p><i class="fas fa-clipboard-check"></i> Bảo hành chính hãng 12 tháng</p>
                <p><i class="fas fa-check-circle"></i> Giá bán đã bao gồm thuế VAT</p>
                <p><i class="fas fa-check-circle"></i> Sản phẩm mới 100%</p>
            </div>
        </div>

        <div class="mt-5">
            <div class="card p-3">
                <h5>Thông tin sản phẩm</h5>
                <div class="description">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="card p-3">
                <input type="hidden" id="product_id" value="{{ $product->id }}">
                <input type="hidden" id="url_rating" value="{{ route('rating') }}">
                <input type="hidden" id="url_comment" value="{{ route('comment') }}">

                <h5 class="mt-3">Đánh giá:</h5>
                <div class="row mx-2">
                    <div class="col-sm-4">
                        <ul class="list-inline row">
                            @for ($count = 1; $count <= 5; $count++)
                                <li id="{{ $product->id }}-{{ $count }}" data-index="{{ $count }}"
                                    data-product_id="{{ $product->id }}" class="rating">
                                    &#9733;
                                </li>
                            @endfor
                        </ul>
                    </div>
                    <div class="col-sm-4 pl-0">
                        <input type="text" class="form-control mb-1" name="phone" id="phone"
                            placeholder="Nhập số điện thoại" />
                    </div>
                    <button type="button" class="btn btn-sm btn-primary send_evaluate col-sm mr-1">
                        Gửi đánh giá
                    </button>
                    <div class="text-danger" id="error">
                        <ul></ul>
                    </div>
                </div>

                <h5 class="mt-3">Bình luận:</h5>
                <div class="form-group">
                    <input type="text" class="form-control mb-1" name="name" id="name"
                        placeholder="Điền tên" />
                    <textarea rows="3" class="form-control mb-1" name="content" id="content" placeholder="Điền nội dung"></textarea>
                    <button type="button" class="btn btn-primary send_comment">
                        Gửi bình luận
                    </button>
                    <div class="text-danger" id="error_comment">
                        <ul></ul>
                    </div>
                </div>
            </div>
            <div class="mt-5 scroll">
                <div class="mx-5" id="comments">
                    @include('user.product.comment')
                </div>
            </div>
        </div>

        <div class="row mt-5" id="relate-product">
            <h4>Sản phẩm liên quan</h4>
            @include('user.product.slide')
        </div>
    </div>

@stop

@push('js')
    <script src="{{ asset('lightslider/js/lightslider.js') }}"></script>
    <script src="{{ asset('lightslider/js/prettify.js') }}"></script>
    <script src="{{ asset('lightslider/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/product.js') }}"></script>

    <script type="text/javascript">
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
    </script>
@endpush
