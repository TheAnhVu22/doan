<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr class="header-table">
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Số lượng</th>
            <th>Giá</th>
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
                        {{ $cart['product_qty'] }}
                    </td>
                    <td>{{ number_format($cart['product_price'], 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalPrice += $cart['product_price'] * $cart['product_qty'];
                @endphp
            @endforeach
            <tr>
                @php
                    $finalTotalPrice = $totalPrice + $feeShip - $discount;
                @endphp
                <td><a href="{{ route('cart.index') }}" class="btn btn-sm btn-secondary">Chỉnh sửa</a></td>
                <td colspan="4" class="text-right">
                    <p>Tạm tính: {{ number_format($totalPrice, 0, ',', '.') }} đ</p>
                    <p>Phí vận chuyển: {{ number_format($feeShip, 0, ',', '.') }} đ</p>
                    @if ($discount)
                        <p>Số tiền giảm (mã giảm giá): {{ number_format($discount, 0, ',', '.') }} đ</p>
                    @endif
                    <p>
                        <b>
                            Tổng tiền: {{ number_format($finalTotalPrice, 0, ',', '.') }}</span> đ
                        </b>
                    </p>
                </td>
            </tr>
            <input type="hidden" name="discount" id="discount" value={{ $discount }}>
            <input type="hidden" name="feeShip" id="feeShip" value={{ $feeShip }}>
            <input type="hidden" id="totalPrice" value={{ $totalPrice }}>
            <input type="hidden" id="couponCode" name="coupon_code" value={{ $couponCode }}>
            @php
                $vnd_to_usd = round($finalTotalPrice / config('consts.DOLLAR_TO_VND'), 2);
                Session::put('totalusd', $vnd_to_usd);
            @endphp
        @else
            <tr>
                <td colspan="5" class="text-center">Chưa có sản phẩm nào trong giỏ hàng</td>
            </tr>
        @endif
    </tbody>
</table>
