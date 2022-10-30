@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <style>
        .col-sm-3half {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .img-product {
            max-width: 100%;
            height: 200px;
            object-fit: fill;
        }

        @media (max-width: 527px) {
            .col-sm-3half {
                width: 47% !important;
            }
        }

        @media only screen and (min-width: 527px) {
            .col-sm-3half {
                float: left;
            }

            .col-sm-3half {
                width: 31%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h3 class="text-center">SẢN PHẨM: {{ $categorySelected->name }}</h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="left-sidebar">
                    <h5 class="text-center">Sắp xếp theo</h5>
                    <form method="get">
                        {{-- <div class="form-group">
                            <label for="category_slug">Danh mục:</label>
                            <select id="category_slug" class="form-control select2" name="category_slug[]" multiple="multiple">
                                @foreach ($categories_product as $category)
                                    <option value="{{ $category->slug }}" {{ in_array($category->slug, $categoryArr) ? 'selected' : '' }}
                                        {{ $category->slug == request()->get('category_slug') ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="brand_slug">Thương hiệu:</label>
                            <select id="brand_slug" class="form-control select2" name="brand_slug[]" multiple="multiple">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->slug }}" {{ in_array($brand->slug, $brandArr) ? 'selected' : '' }}
                                        {{ $brand->slug == request()->get('brand_slug') ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
            <div class="col-md-9 pr-0 text-center">
                <div class="row">
                    @forelse ($products as $product)
                        <a class="card col-sm-3half p-0 m-lg-2 m-md-1 mr-sm-2 m-1"
                            href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                            <div>
                                <img class="img-product card-img-top"
                                    src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                                    alt="image product">
                                <div class="card-body d-flex flex-column text-left p-2">
                                    <b>{{ $product->name }}</b>
                                    <p class="card-text mt-auto">
                                    <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
                                    <small class="text-muted">
                                        <span class="text-nowrap"><i class="far fa-comment"></i>
                                            {{ $product->comments->count() }}
                                        </span>
                                    </small>
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                    <h5 class="text-center">Không có sản phẩm nào</h5>
                    @endforelse
                </div>

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
