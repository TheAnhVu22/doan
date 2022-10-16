<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $user->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên khách hàng:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $user->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="email">Địa Chỉ Email:</label><label style="color: red">(*)</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}"
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

            @if ($user->id)
                <label for="roles">Trạng thái:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"
                        value='{{ config('consts.UNBLOCK') }}' @if ($user->status === config('consts.UNBLOCK')) checked @endif>
                    <label class="form-check-label">
                        Kích hoạt
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"
                        value='{{ config('consts.BLOCK') }}' @if ($user->status === config('consts.BLOCK')) checked @endif>
                    <label class="form-check-label">
                        Khóa
                    </label>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('user.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $user->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>
