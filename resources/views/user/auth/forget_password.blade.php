<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
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
</body>

</html>
