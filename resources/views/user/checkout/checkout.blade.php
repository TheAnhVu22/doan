@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <style>
        #coupon {
            border-color: rgb(79, 166, 7);
        }

        .payment_method {
            border-color: red;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Thanh toán</h3>
        @include('admin.layouts.alert')
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shipping_name">Tên:</label><label style="color: red">(*)</label>
                        <input type="text" class="form-control"
                            value="{{ old('shipping_name', \Auth::guard('user')->user()->name) }}" name="shipping_name"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="shipping_phone">Số điện thoại:</label><label style="color: red">(*)</label>
                        <input type="text" class="form-control"
                            value="{{ old('shipping_phone', \Auth::guard('user')->user()->phone) }}" name="shipping_phone"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú (chi tiết giao hàng):</label>
                        <textarea class="form-control" name="note" rows="3" autocomplete="off" id="note">{{ old('note') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                        @if (!Session::get('paypal_success'))
                            <select name="payment_method" class="form-control input-sm m-bot15 payment_method">
                                @foreach (\App\Models\Order::PAYMENT_METHOD as $payment => $text)
                                    <option value={{ $payment }}>{{ $text }}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="payment_method" class="form-control input-sm m-bot15 payment_method">
                                <option value="2">Đã thanh toán bằng paypal</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <input type="hidden" id="url_fee_ship" value="{{ route('apply_feeship') }}">
                    <input type="hidden" id="url_coupon" value="{{ route('apply_coupon') }}">
                    @include('admin.layouts.select_city')

                    <div id="select_district">
                        @include('admin.layouts.select_district')
                    </div>

                    <div id="select_ward">
                        @include('admin.layouts.select_ward')
                    </div>
                    <div class="input-group mb-3 use_coupon">
                        <input id="coupon" type="text" class="form-control" placeholder="Mã giảm giá/khuyến mãi">
                        <div class="input-group-append">
                            <button id="btn_apply_coupon" class="btn btn-success" type="button">Áp dụng</button>
                        </div>
                    </div>
                    <div class="text-danger" id="error_coupon">
                        <ul></ul>
                    </div>
                </div>
            </div>
            <div id="table_checkout">
                @include('user.checkout.table_checkout')
            </div>
            <div class=" d-flex justify-content-end">
                <button type="submit" class="btn btn-lg btn-primary">Thanh toán</button>
            </div>
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\CheckoutStoreRequest') !!}
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('js/shipping.js') }}"></script>
    <script>
        $(function() {
            $('#btn_apply_coupon').click(function() {
                const code = $('#coupon').val();
                const total = $('#totalPrice').val();
                const feeShip = $('#feeShip').val();
                const url = $('#url_coupon').val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        code: code,
                        total: total,
                        feeShip: feeShip
                    },
                    success: function(data) {
                        if (data.error) {
                            $("#error_coupon").find("ul").html('');
                            $.each(data.error, function(key, value) {
                                $("#error_coupon").find("ul").append('<li>' + value +
                                    '</li>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                text: 'Áp dụng mã giảm giá thành công',
                            })
                            $("#error_coupon").find("ul").html('');
                            $('#table_checkout').html(data);
                        }
                    }
                });
            })

            $(document).on('change', '.ward_id', function() {
                const city = $('#city').val();
                const district = $('#district').val();
                const ward = $('#ward').val();
                const discount = $('#discount').val();
                const coupon_code = $('#couponCode').val();
                const url = $('#url_fee_ship').val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        city: city,
                        district: district,
                        ward: ward,
                        discount: discount,
                        coupon_code: coupon_code
                    },
                    success: function(data) {
                        if (data.error) {
                            console.log(data.error);
                        } else {
                            $('#table_checkout').html(data);
                        }
                    }
                });
            })
        })
    </script>
@endpush
