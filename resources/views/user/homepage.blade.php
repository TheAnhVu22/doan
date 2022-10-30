@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel_custom.css') }}">
    <style>
        .image-brand {
            max-height: 90px;
        }

        .img-brand {
            max-width: 100%;
            max-height: 100%;
            height: auto;
        }

        .link-brand {
            box-shadow: rgba(92, 91, 91, 0.16) 1px 1px 1px;
        }

        .link-brand:hover {
            background-color: white;
        }

        .new_product{
            padding: 10px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        }

        .link_new_product:hover {
            background-color: white;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        @include('user.commons.banner')

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6><b>Điện thoại</b></h6>
                <small><a href="{{ route('category_product', ['slug' => 'dien-thoai']) }}">Xem tất cả <i
                            class="fas fa-chevron-right fa-sm"></i></a></small>
            </div>
            <div class="card-body">
                @include('user.homepage.slide', ['products' => $phones])
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6><b>Máy tính</b></h6>
                <small><a href="{{ route('category_product', ['slug' => 'may-tinh']) }}">Xem tất cả <i
                            class="fas fa-chevron-right fa-sm"></i></a></small>
            </div>
            <div class="card-body">
                @include('user.homepage.slide', ['products' => $laptops])
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6><b>Ti vi</b></h6>
                <small><a href="{{ route('category_product', ['slug' => 'tivi']) }}">Xem tất cả <i
                            class="fas fa-chevron-right fa-sm"></i></a></small>
            </div>
            <div class="card-body">
                @include('user.homepage.slide', ['products' => $tivis])
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6><b>Tai nghe</b></h6>
                <small><a href="{{ route('category_product', ['slug' => 'tai-nghe']) }}">Xem tất cả <i
                            class="fas fa-chevron-right fa-sm"></i></a></small>
            </div>
            <div class="card-body">
                @include('user.homepage.slide', ['products' => $headphones])
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h6><b>Đồng hồ</b></h6>
                <small><a href="{{ route('category_product', ['slug' => 'dong-ho']) }}">Xem tất cả <i
                            class="fas fa-chevron-right fa-sm"></i></a></small>
            </div>
            <div class="card-body">
                @include('user.homepage.slide', ['products' => $watchs])
            </div>
        </div>

        <div class="mt-5">
            <div>
                <h6><b>Thương hiệu nổi bật</b></h6>
            </div>
            <div class="row">
                @foreach ($brands as $brand)
                    <a class="col-3 link-brand" href="{{ route('brand', ['slug' => $brand->slug]) }}">
                        <div class="p-1">
                            <div class="img-hover-zoom image-brand">
                                <img class="img-brand" width="100%" height="100%"
                                    src="{{ asset('images/brands/' . $brand->image) }}" alt="brand">
                            </div>
                            <p class="card-text text-center">{{ $brand->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-5">
            <div>
                <h6><b>Danh mục sản phẩm</b></h6>
            </div>
            <div class="d-flex flex-wrap">
                @foreach ($categories_product as $category)
                    <a class="col-2 link-brand" href="{{ route('category_product', ['slug' => $category->slug]) }}">
                        <div class="p-1">
                            <p class="card-text text-center">{{ $category->name }}</p>
                            <div class="img-hover-zoom image-brand">
                                <img class="img-brand" width="100%" height="100%"
                                    src="{{ asset('images/categories_product/' . $category->image) }}" alt="brand">
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-3">
            <div class="d-flex justify-content-between">
                <h6><b>Sản phẩm mới</b></h6>
            </div>
            <div class="d-flex flex-wrap mb-3">
                @foreach ($newest_products as $product)
                    <a class="col-6 col-sm-4 col-md-3 col-lg-2 mt-3 link_new_product" href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                        <div class="card new_product">
                            <div class="img-hover-zoom">
                                <img class="img-product" width="100%" height="100%"
                                    src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                                    alt="image product">
                            </div>
                            <div class="d-flex flex-column">
                                <p class="card-text mt-auto">{{ $product->name }}</p>
                                <p class="card-text mt-auto">
                                <p class="price">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                                </p>

                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $newest_products->withQueryString()->links('pagination::bootstrap-4') }}
        </div>

        <div class="mt-3">
            <h5>Tin khuyến mãi</h5>
            <div class="d-flex flex-wrap justify-content-center">
                @foreach ($news_discount as $news)
                    <a class="col-sm-5 link_new_product" href="{{ route('news_detail', ['slug' => $news->slug]) }}">
                        <div class="card new_product">
                            <div class="img-hover-zoom">
                                <img class="img-product" width="100%" height="100%"
                                    src="{{ asset('images/authors/' . $news->image) }}"
                                    alt="image news">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $news->name }}</h5>
                                <p class="card-text mt-auto">
                                    <i class="fas fa-user-circle"></i> {{ $news->author_name }}
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $news->created_at }}
                                        - <span class="text-nowrap"><i class="fas fa-eye"></i>
                                            {{ $news->views }}</span>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
@endpush
