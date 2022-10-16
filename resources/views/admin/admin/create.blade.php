@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    <h1>Quản lý nhân viên</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('admin.store') }}" method="post" id="AddAdmin" enctype='multipart/form-data'>
            @csrf
            @include('admin.admin._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\AdminStoreRequest') !!}
@endpush
