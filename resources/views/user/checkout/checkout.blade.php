@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
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
                    <div class="form-group border border-warning p-3">
                        <label><b>Chọn hình thức thanh toán</b></label>
                        @foreach (\App\Models\Order::PAYMENT_METHOD as $payment => $text)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    value={{ $payment }}>
                                <label class="form-check-label">
                                    {{ $text }}
                                    @if ($payment === 2)
                                        <i class="fab fa-cc-paypal"></i>
                                    @endif
                                </label>
                            </div>
                        @endforeach
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
    <script src="{{ asset('js/checkout.js') }}"></script>
@endpush
