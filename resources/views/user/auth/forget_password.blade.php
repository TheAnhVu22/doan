@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center align-middle">
            <div class="col-md-8">
                <div class="card" style="margin-top: 10rem;">
                    <div class="card-header text-center">
                        <h5>Nhập email đăng ký tài khoản!</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('forget_password_handle') }}">
                            @csrf
                            @include('admin.layouts.alert')
                            <div class="row mb-1">
                                <label for="email" class="col-md-2 col-form-label text-md-center">Email:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                </div>
                            </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Lấy mật khẩu
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
