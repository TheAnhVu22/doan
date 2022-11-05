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
        .lSSlideOuter,
        .lSSlideWrapper,
        .lightSlider,
        .lightSlider li,
        .img-hover-zoom {
            height: auto !important;
            width: 100%;
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
                                <div class="img-hover-zoom">
                                    <img height="100%" src="{{ asset('uploads/product_images/' . $image->image) }}" />
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 border-bottom pt-3">
                    <h4>{{ $product->name }}</h4>
                    <div class="d-flex justify-content-center" id="show_rating">
                        @include('user.product.rating')
                    </div>
                    <small>Thương hiệu: <b>{{ $product->brand?->name }}</b></small>
                    <p class="price">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    <p>Tình trạng:
                        @if ($product->quantity === 0)
                            <span class="text-danger">Hết hàng</span>
                        @else
                            <span class="text-success">Còn hàng</span>
                            <div class="quantity">
                                <span class="minus">-</span>
                                <input type="text" id="getQuantity" name="quantity" value="1"
                                    onkeydown="return false" />
                                <span class="plus">+</span>
                            </div>
                            <button type="button" class="mt-1 btn btn-success add-to-cart"
                                data-id_product="{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i> Thêm giỏ hàng</button>
                        @endif
                    </p>
                    <div class="mb-2">
                        <p>Từ khóa:</p>
                        @foreach ($product->tags as $tag)
                            <a href="#" class="badge badge-info p-2">{{ $tag->name }}</a>
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
            <div class="mt-5" id="comments">
                @include('user.product.comment')
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
            var rating = 0;

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
