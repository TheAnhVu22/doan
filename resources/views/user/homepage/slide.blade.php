<div id="article-carousel" class="owl-carousel owl-theme">
    @foreach ($products as $product)
        <div class="item article-items">
            <a class="card_product" href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                <div class="aticle-box">
                    <div class="img-hover-zoom">
                        <img class="img-product" width="100%" height="100%"
                            src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                            alt="image product">
                    </div>
                    <div class="box-content d-flex flex-column">
                        <p class="card-text mt-auto">{{ $product->name }}</p>
                        <div class="card-text mt-auto">
                            <p class="price">
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
        </div>
    @endforeach
</div>
