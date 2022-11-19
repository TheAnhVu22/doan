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
    <link rel="stylesheet" href="{{ asset('css/detail_product_user.css') }}">
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
                                <img height="300" width="100%" class=" border border-dark"
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
                                class="badge badge-info mt-1 p-2">{{ $tag->name }}</a>
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
                <div class="description text-left">
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

    <script src="{{ asset('js/detail_product.js') }}"></script>
@endpush
