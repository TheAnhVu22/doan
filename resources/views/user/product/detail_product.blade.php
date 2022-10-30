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
        .lSSlideOuter, .lSSlideWrapper, .lightSlider, .lightSlider li, .img-hover-zoom{
            height: auto !important;
            width: 100%;
        }
        .img-hover-zoom img{
            width: inherit;
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
            <div class="col-sm-4">
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
            <div class="col-sm-4 border-bottom pt-3">
                <h4>{{ $product->name }}</h4>
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
            <div class="col-sm-4 card">
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
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <div id="comments"></div>
                <h5 class="mt-3">Bình luận:</h5>
                <form>
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control mb-1" name="author_name" placeholder="Điền tên" />
                        <textarea rows="3" class="form-control mb-1" name="content" placeholder="Điền nội dung"></textarea>
                        <button type="button" class="btn btn-primary send_comment">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
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
@endpush
