@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Quản lý đơn hàng</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('css/create_order_admin.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            @include('admin.order._form')
        </form>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/shipping.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\OrderStoreRequest') !!}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/create_order_admin.js') }}"></script>
@endpush
