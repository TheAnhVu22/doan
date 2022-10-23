@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <style>

    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Giỏ hàng</h3>
        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Thanh toán</a>
    </div>
@stop

@push('js')
    <script></script>
@endpush
