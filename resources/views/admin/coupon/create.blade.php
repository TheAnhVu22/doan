@extends('adminlte::page')

@section('title', 'Coupon')

@section('content_header')
    <h1>Quản lý mã giảm giá</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('coupon.store') }}" method="post">
            @csrf
            @include('admin.coupon._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\CouponStoreRequest') !!}
@endpush
