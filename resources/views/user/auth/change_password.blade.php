@if (!isset($_GET['token']))
  
@else

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đổi mật khẩu</title>

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
</body>

</html>
@endif