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
                    <p class="card-text mt-auto">
                        <b>{{ $product->name }}</b>
                    <p class="card-text mt-auto">
                    <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    <small class="text-muted">
                        <span class="text-nowrap"><i class="far fa-comment"></i>
                            {{ $product->comments->count() }}
                        </span>
                    </small>
                    </p>
                    </p>
                </div>
            </div>
        </a>
    @endforeach
</div>
