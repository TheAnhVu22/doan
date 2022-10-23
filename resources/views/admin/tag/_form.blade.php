<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $tag->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên tag:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $tag->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="box-footer text-center pb-2">
                <a href="{{ route('tag.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $tag->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>
