<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đăng nhập khách hàng</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-middle">
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
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
