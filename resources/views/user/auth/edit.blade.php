@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@section('content')
    <div class="container mt-5">
        @include('admin.layouts.alert')
        <form action="{{ route('update_account', ['user' => $user]) }}" method="post">
            @csrf
            @method("PUT")
            <div class="d-flex justify-content-center">
                <div class="card col-md-8">
                    <div class="card-header text-center">
                        <h3>Cập nhật thông tin tài khoản</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên:</label><label style="color: red">(*)</label>
                            <input type="text" class="form-control" value="{{ old('name', $user->name) }}" name="name"
                                autocomplete="off">
                        </div>
            
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại:</label><label style="color: red">(*)</label>
                            <input type="number" class="form-control" value="{{ old('phone', $user->phone) }}" name="phone"
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
            
                        <div class="box-footer text-center pb-2">
                            <a href="{{ route('manager_account', ['user' => $user]) }}" class="btn btn-primary">Quay Lại</a>
                            <button type="summit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
            
            </div>
        </form>
    </div>
@stop
