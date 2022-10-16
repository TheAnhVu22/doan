<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $admin->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="username">Tên Đăng Nhập:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('username', $admin->username) }}" name="username"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="email">Địa Chỉ Email:</label><label style="color: red">(*)</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label><label style="color: red">(*)</label>
                <input type="number" class="form-control" value="{{ old('phone', $admin->phone) }}" name="phone"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="birthday">Ngày sinh:</label><label style="color: red">(*)</label>
                <input type="date" class="form-control" value="{{ old('birthday', $admin->birthday) }}"
                    name="birthday" autocomplete="off" onkeypress="return false">
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

            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" class="form-control img_preview" value="{{ old('avatar', $admin->avatar) }}"
                    onchange="previewFile(this)" name="avatar">
                <div class="col-2 mt-1">
                    <img id="previewimg" class="border border-dark rounded-circle"
                        src="{{ $admin->avatar ? asset('images/admin/' . $admin->avatar) : asset('images/No_avatar.png') }}"
                        alt="avatar" height="160" width="160">
                </div>
            </div>

            <div class="form-group">
                <label for="roles">Chọn Quyền:</label><label style="color: red">(*)</label>
                <select class="form-control select2" id="roles" name="role_id">
                    <option value="" selected>Chọn quyền</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $admin->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($admin->id)
                <label for="roles">Trạng thái:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active"
                        value='{{ config('consts.UNBLOCK') }}' @if ($admin->is_active === config('consts.UNBLOCK')) checked @endif>
                    <label class="form-check-label">
                        Kích hoạt
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active"
                        value='{{ config('consts.BLOCK') }}' @if ($admin->is_active === config('consts.BLOCK')) checked @endif>
                    <label class="form-check-label">
                        Khóa
                    </label>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('admin.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $admin->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/preview_image.js') }}"></script>
@endpush
