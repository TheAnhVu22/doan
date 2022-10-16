<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đăng ký khách hàng</title>

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
                        <h6>Đăng ký khách hàng</h6>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user_register_handle') }}">
                            @csrf
                            @include('admin.layouts.alert')
                            <div class="form-group">
                                <label for="name">Tên:</label><label style="color: red">(*)</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    autocomplete="off">
                            </div>
                
                            <div class="form-group">
                                <label for="email">Địa Chỉ Email:</label><label style="color: red">(*)</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    autocomplete="off">
                            </div>
                
                            <div class="form-group">
                                <label for="phone">Số Điện Thoại:</label><label style="color: red">(*)</label>
                                <input type="number" class="form-control" value="{{ old('phone') }}" name="phone"
                                    autocomplete="off">
                            </div>
                
                            <div class="form-group">
                                <label>Password:</label><label style="color: red">(*)</label>
                                <input class="form-control" id="password" placeholder="password" name="password" autocomplete="off">
                            </div>
                
                            <div class="form-group">
                                <label>Xác Nhận Password:</label><label style="color: red">(*)</label>
                                <input class="form-control" id="password_confirm" placeholder="Password Confirmation"
                                    name="password_confirmation" autocomplete="off">
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Đăng ký
                                    </button>
                                    <a href="{{ route('user_login') }}" class="btn btn-primary">
                                        Đăng nhập
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
