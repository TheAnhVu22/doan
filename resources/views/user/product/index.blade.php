@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/carousel_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/list_product_user.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h3 class="text-center">
            @if (isset($isCate))
                Danh mục: {{ $categorySelected->name }}
            @else
                Thương hiệu: {{ $brandSelected->name }}
            @endif
        </h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="left-sidebar">
                    <h5 class="text-center">Sắp xếp theo</h5>
                    <form method="get">
                        @if (isset($isCate))
                            <div class="form-group">
                                <label for="brand_slug">Thương hiệu:</label>
                                <select id="brand_slug" class="form-control select2" name="brand_slug[]"
                                    multiple="multiple">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->slug }}"
                                            {{ in_array($brand->slug, $brandArr) ? 'selected' : '' }}
                                            {{ $brand->slug == request()->get('brand_slug') ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="category_slug">Danh mục:</label>
                                <select id="category_slug" class="form-control select2" name="category_slug[]"
                                    multiple="multiple">
                                    @foreach ($categories_product as $category)
                                        <option value="{{ $category->slug }}"
                                            {{ in_array($category->slug, $categoryArr) ? 'selected' : '' }}
                                            {{ $category->slug == request()->get('category_slug') ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="sort_price">Mức giá:</label>
                            <select id="sort_price" class="form-control select2" name="sort_price[]" multiple="multiple">
                                @foreach (config('consts.SORT_BY_PRICE') as $key => $sort)
                                    <option value="{{ $key }}" {{ in_array($key, $priceArr) ? 'selected' : '' }}
                                        {{ $key == request()->get('sort_price') ? 'selected' : '' }}>
                                        {{ $sort }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type_sort">Kiểu:</label>
                            <select id="type_sort" class="form-control" name="type_sort">
                                @foreach (config('consts.PRODUCT_SORT_BY') as $key => $sort)
                                    <option value="{{ $key }}"
                                        {{ $key == request()->get('type_sort') ? 'selected' : '' }}>
                                        {{ $sort }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <button type="button" id="resetBtn" class="btn btn-secondary">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-9 pr-0 text-center d-flex flex-wrap ">
                @forelse ($products as $product)
                    <a class="col-6 col-sm-4 col-lg-3 mt-3 link_product"
                        href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                        <div class="card new_product">
                            <div class="img-hover-zoom">
                                <img class="img-product"
                                    src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                                    alt="image product">
                            </div>
                            <div class="d-flex flex-column text-left">
                                <b>{{ $product->name }}</b>
                                <div class="card-text mt-auto">
                                <p>
                                    {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }} đ
                                    @if ($product->discount)
                                        <small>({{ $product->discount }}%)</small>
                                    @endif
                                </p>
                                <div class="row ml-2">
                                    <small class="text-muted mr-1">
                                        <span class="text-nowrap"><i class="far fa-comment"></i>
                                            {{ $product->comments->count() }}
                                        </span>
                                    </small>
                                    <small class="text-muted ml-1">
                                        <span class="text-nowrap"><i class="far fa-star"></i>
                                            {{ round($product->ratings->avg('rating'), 1) }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <h5 class="text-center">Không có sản phẩm nào</h5>
                @endforelse

                <br>
                {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function() {
            $('#resetBtn').click(function() {
                $("select#sort_price").val("").change();
                $("select#brand_slug").val("").change();
                $("select#type_sort").val("1").change();
                $("#keyword").val("");
            });
        })
    </script>
@endpush
