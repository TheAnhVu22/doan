<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $comment->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên nhân viên:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $comment->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="content">Nội dung phản hồi:</label><label style="color: red">(*)</label>
                <textarea class="form-control" name="content" rows="3" autocomplete="off">{{ old('content', $comment->content) }}</textarea>
            </div>

            <div class="box-footer text-center pb-2">
                <a href="{{ route('comment.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $comment->id ? 'Cập Nhật' : 'Phản hồi' }}</button>
            </div>
        </div>
    </div>

</div>
