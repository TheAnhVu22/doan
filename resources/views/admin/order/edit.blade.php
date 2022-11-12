@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Quản lý đơn hàng</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')
        <form action="{{ route('order.update', ['order' => $order]) }}" method="post">
            @csrf
            @method('PUT')
            @include('admin.order._form')
        </form>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/shipping.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\OrderUpdateRequest') !!}
@endpush
