@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@section('content')
    <div class="container mt-5 d-flex justify-content-center" style="max-height: 300px">
        <div class="card col-md-6">
            <div class="card-header">
                <h3>Thông tin tài khoản</h3>
            </div>
            <div class="card-body">
                <div>
                    <label class="font-weight-bold">Họ và tên:</label> {{ $user->name }}
                </div>
                <div>
                    <label class="font-weight-bold">Email:</label> {{ $user->email }}
                </div>
                <div>
                    <label class="font-weight-bold">Số điện thoại:</label> {{ $user->phone }}
                </div>
                <div>
                    <label class="font-weight-bold">Ngày đăng ký:</label> {{ $user->created_at }}
                </div>
                <a href="{{ route('update_info_account', ['user' => $user]) }}" class="btn btn-primary mb-1">Sửa thông tin</a>
                <a href="{{ route('manager_order', ['user' => $user]) }}" class="btn btn-primary mb-1">Quản lý đơn hàng</a>
            </div>
        </div>

    </div>
@stop

@push('js')
    <script></script>
@endpush
