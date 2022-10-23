@extends('adminlte::page')

@section('title', 'Fee Ship')

@section('content_header')
    <h1>Quản lý phí vận chuyển</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <div class="d-flex justify-content-center">
            <div class="card col-md-10">
                <div class="card-body">
                    <form action="{{ route('shipping.store') }}" method="post" id="formFeeShip">
                        @csrf

                        @include('admin.layouts.select_city')

                        <div id="select_district">
                            @include('admin.layouts.select_district')
                        </div>

                        <div id="select_ward">
                            @include('admin.layouts.select_ward')
                        </div>

                        <div class="form-group">
                            <label for="fee_ship">Phí vận chuyển:</label><label style="color: red">(*)</label>
                            <input type="number" class="form-control" value="{{ old('fee_ship') }}" name="fee_ship"
                                autocomplete="off">
                        </div>
                        <input type="hidden" id="url" value="{{ route('shipping.create') }}">
                        <div class="box-footer text-center pb-2">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('shipping.index') }}" class="btn btn-primary">Quay Lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/shipping.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\FeeShipStoreRequest') !!}
@endpush
