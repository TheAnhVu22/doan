@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Giỏ hàng</h3>
        <div id="show_cart">
            @include('user.checkout.table_cart')
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/cart_user.js') }}"></script>
@endpush
