@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <style>

    </style>
@endpush

@section('content')
    Từ khóa: {{ request()->get('keywords') }}
    <ul>
        @foreach ($products as $product)
            <li><a href="{{ route('product_detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a></li>
        @endforeach
    </ul>
@stop

@push('js')
    <script></script>
@endpush
