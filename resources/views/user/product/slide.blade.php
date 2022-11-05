<div class="owl-carousel">
    @foreach ($relate_products as $product)
        <a href="{{ route('product_detail', ['slug' => $product->slug]) }}">
            <div class="card p-0">
                <div class="img-hover-zoom">
                    <img class="img-product"
                        src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                        alt="image product">
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="card-text mt-auto">
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
            </div>
        </a>
    @endforeach
</div>
