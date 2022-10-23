@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center align-middle mb-5">
            <div class="col-md-6">
                <div class="card" style="margin-top: 10rem;">
                    <div class="card-header text-center">
                        <h6>Đăng nhập khách hàng</h6>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user_login_handle') }}">
                            @csrf
                            @include('admin.layouts.alert')
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-center">Email:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-center">Mật khẩu:</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-4">
                                    <a href="{{ route('forget_password') }}" class="px-0 forgetPass text-wrap">
                                        Quên mật khẩu?
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary mb-lg-0 mb-md-1">
                                        Đăng nhập
                                    </button>
                                    <a href="{{ route('user_register') }}" class="btn btn-primary">
                                        Đăng ký
                                    </a>
                                    <a href="{{ route('login.google') }}" class="btn btn-danger btn-block mt-3">
                                        <i class="fab fa-google"></i> Tiếp tục với Google
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
