<input type="hidden" name="feeShip" id="feeShip" value={{ $feeShip }}>
<input type="hidden" id="url_add" value="{{ route('add_product_order') }}">
<table class="table table-bordered table-hover mb-3">
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
        @php
            $totalPrice = 0;
        @endphp
        @if ($carts)
            @foreach ($carts as $cart)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        {{ $cart['product_name'] }}
                    </td>
                    <td>
                        <img class="border border-dark rounded-circle"
                            src="{{ asset('uploads/product_images/' . $cart['product_image']) }}"
                            alt="product image" height="100" width="100">
                    </td>
                    <td>
                        <input type="hidden" id="update_quantity" value="{{ route('update_quantity_order') }}">
                        <div class="quantity d-flex align-item-center justify-content-center">
                            <span class="minus" data-id={{ $cart['session_id'] }} data-quantity={{ $cart['product_quantity'] }}>-</span>
                            <input type="text" class="product_qty_{{ $cart['session_id'] }}" id="getQuantity"
                                name="quantity" value={{ $cart['product_qty'] }} onkeydown="return false;" />
                            <span class="plus" data-id={{ $cart['session_id'] }} data-quantity={{ $cart['product_quantity'] }}>+</span>
                        </div>
                    </td>
                    <td>{{ number_format($cart['product_price'], 0, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn_remove_product" data-url="{{ route('remove_product_admin_cart') }}"
                            data-product={{ $cart['session_id'] }}>
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                @php
                    $totalPrice += $cart['product_price'] * $cart['product_qty'];
                @endphp
            @endforeach
        @endif
        <tr>
            @php
                $finalTotalPrice = $totalPrice + $feeShip;
            @endphp
            <td colspan="6" class="text-right">
                <p>Tạm tính: {{ number_format($totalPrice, 0, ',', '.') }} đ</p>
                <p>Phí vận chuyển: {{ number_format($feeShip, 0, ',', '.') }} đ</p>
                <p>
                    <b>
                        Tổng tiền: {{ number_format($finalTotalPrice, 0, ',', '.') }}</span> đ
                    </b>
                </p>
            </td>
        </tr>
    </tbody>
</table>
