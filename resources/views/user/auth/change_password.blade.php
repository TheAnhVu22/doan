@if (!isset($_GET['token']))
@else
    @extends('user.commons.layout')

    @section('title', 'ATVSHOP')

    @push('css')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endpush

    @section('content')
        <div class="container">
            <div class="row d-flex justify-content-center align-middle">
                <div class="col-md-6">
                    <div class="card" style="margin-top: 10rem;">
                        <div class="card-header text-center">
                            <h6>Đổi mật khẩu</h6>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('change_password_handle') }}">
                                @csrf
                                @include('admin.layouts.alert')
                                <div class="form-group">
                                    <label>Mật khẩu mới:</label><label style="color: red">(*)</label>
                                    <input class="form-control" id="password" placeholder="password" name="password"
                                        autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label>Xác Nhận mật khẩu:</label><label style="color: red">(*)</label>
                                    <input class="form-control" id="password_confirm" placeholder="Password Confirmation"
                                        name="password_confirmation" autocomplete="off">
                                </div>

                                @php
                                    $token = $_GET['token'];
                                    $email = $_GET['email'];
                                @endphp
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Cập nhật
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
@endif
