@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>Quản lý khách hàng</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('user.update', ['user' => $user]) }}" id="UpdateUser" method="post">
            @csrf
            @method("PUT")
            @include('admin.user._form')
        </form> 
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\UserUpdateRequest') !!}
@endpush