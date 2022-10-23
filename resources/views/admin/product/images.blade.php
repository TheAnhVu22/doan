@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Quản lý sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <div class="d-flex justify-content-center">
            <div class="card col-md-10">
                <div class="card-header text-center">
                    <h4>Quản lý ảnh sản phẩm <b>{{ $product->name }}</b></h4>
                </div>
                <div id="message"></div>
                <div class="card-body">
                    <form action="{{ route('insert_gallery', $product->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <input type="file" id="file" name="file[]" class="form-control" accept="image/*"
                                    multiple>
                            </div>
                            <div class="col-4 d-flex justify-content-end pr-1">
                                <input type="submit" name="upload" value="Tải ảnh" class="btn btn-success">
                                <a href="{{ route('product.index') }}" class="btn btn-primary ml-1">Quay lại</a>
                            </div>
                        </div>
                    </form>

                    <input type="hidden" name="product_id" class="product_id" value="{{ $product->id }}">
                    <div id="show_image"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script type="text/javascript">
        $(function() {
            loadImages();

            function loadImages() {
                let product_id = $('.product_id').val();
                $.ajax({
                    url: "{{ route('select_gallery') }}",
                    method: "POST",
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        $('#show_image').html(data);
                    }
                });
            }

            $('#file').change(function() {
                let error = "";
                let files = $('#file')[0].files;
                if (files.length > 5) {
                    error += '<p>Chỉ được chọn tối đa 5 ảnh</p>';

                } else if (files.length == "") {
                    error += '<p>Không được để trống</p>';
                } else if (files.size > 2000000) {
                    error += '<p>Ảnh không được lớn hơn 2MB</p>';
                }
                if (error == "") {

                } else {
                    $('#file').val('');
                    $('#message').html('<p class="alert alert-danger" role="alert">' + error + '</p>');
                    return false;
                }
            });

            $(document).on('blur', '.edit_image_name', function() {
                let image_id = $(this).data('image_id');
                let image_name = $(this).text();
                $.ajax({
                    url: "{{ route('update_name') }}",
                    method: "POST",
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        image_id: image_id,
                        image_name: image_name
                    },
                    success: function(data) {
                        $('#message').html(
                            '<p class="alert alert-success" role="alert">Cập nhật tên thành công</p>'
                        );
                    }
                });
            });

            $(document).on('click', '.delete-image', function() {
                let image_id = $(this).data('image_id');
                if (confirm('Xác nhận xóa')) {
                    $.ajax({
                        url: "{{ route('delete_image') }}",
                        method: "POST",
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            image_id: image_id

                        },
                        success: function() {
                            loadImages();
                            $('#message').html(
                                '<p class="alert alert-success" role="alert">Xóa hình ảnh thành công</p>'
                            );

                        }
                    });
                }
            });

            $(document).on('change', '.file_image', function() {
                let image_id = $(this).data('image_id');
                let product_id = $(this).data('product_id');
                let image = document.getElementById('file-' + image_id).files[0];
                let form_data = new FormData();
                form_data.append("file", image);
                form_data.append("image_id", image_id);
                form_data.append("product_id", product_id);

                $.ajax({
                    url: "{{ route('update_gallery') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function() {
                        loadImages();
                        $('#message').html(
                            '<p class="alert alert-success" role="alert">Cập nhật hình ảnh thành công</p>'
                        );
                    }
                });

            });

        });
    </script>
@endpush
