<div class="owl-carousel">
    @foreach ($products as $product)
        <a class="card_product ml-2" href="{{ route('product_detail', ['slug' => $product->slug]) }}">
            <div class="card">
                <div class="img-hover-zoom">
                    <img class="img-product" width="100%" height="100%"
                    src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                    alt="image product">
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text mt-auto">{{ $product->name }}</p>
                    <p class="card-text mt-auto">
                    <p class="price">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    </p>
                    
                </div>
            </div>
        </a>
    @endforeach
</div>