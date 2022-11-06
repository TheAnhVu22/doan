<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr class="header-table">
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($carts))
            @php
                $totalPrice = 0;
            @endphp
            @foreach ($carts as $cart)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <a href="{{ route('product_detail', ['slug' => \Str::slug($cart['product_name'])]) }}">
                            {{ $cart['product_name'] }}
                        </a>
                    </td>
                    <td>
                        <img class="border border-dark rounded-circle"
                            src="{{ asset('uploads/product_images/' . $cart['product_image']) }}" alt="product image"
                            height="100" width="100">
                    </td>
                    <td>
                        <div class="quantity d-flex align-item-center justify-content-center">
                            <span class="minus" data-id={{ $cart['session_id'] }}>-</span>
                            <input type="text" class="product_qty_{{ $cart['session_id'] }}" id="getQuantity"
                                name="quantity" value={{ $cart['product_qty'] }} onkeydown="return false;" />
                            <span class="plus" data-id={{ $cart['session_id'] }}>+</span>
                        </div>
                    </td>
                    <td>{{ number_format($cart['product_price'], 0, ',', '.') }}</td>
                    <td>
                        <button class="btn_remove_product" data-url="{{ route('delete_product_in_cart') }}"
                            data-product={{ $cart['session_id'] }}>
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                @php
                    $totalPrice += $cart['product_price'] * $cart['product_qty'];
                @endphp
            @endforeach
            <tr>
                <td colspan="6" class="text-right">Tạm tính: {{ number_format($totalPrice, 0, ',', '.') }} đ
                </td>
            </tr>
        @else
            <tr>
                <td colspan="6" class="text-center">Chưa có sản phẩm nào trong giỏ hàng</td>
            </tr>
        @endif
    </tbody>
</table>