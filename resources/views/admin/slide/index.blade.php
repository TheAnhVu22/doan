@extends('adminlte::page')

@section('title', 'Slide')

@section('content_header')
    <h1>Quản lý Slide</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('slide.create') }}" class="btn btn-primary mb-2">Thêm Slide</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($slides as $slide)
                        <tr>
                            <td>{{ $slide->id }}</td>
                            <td>{{ $slide->name }}</td>
                            <td>
                                <img id="previewimg" class="border border-dark rounded-circle"
                                src="{{ $slide->image ? asset('images/slides/' . $slide->image) : asset('images/No_avatar.png') }}"
                                alt="slide" height="160" width="160">
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('slide.edit', ['slide' => $slide]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('slide.destroy', ['slide' => $slide]) }}">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="4">Không có dữ liệu</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.layouts.modalDelete')
@stop

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
@endpush
