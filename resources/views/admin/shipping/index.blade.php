@extends('adminlte::page')

@section('title', 'Fee ship')

@section('content_header')
    <h1>Phí vận chuyển</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')
        <div id="alert_edit"></div>

        <input type="hidden" id="url" value="{{ route('shipping.update_fee') }}">
        <a href="{{ route('shipping.create') }}" class="btn btn-primary mb-2">Thêm phí vận chuyển</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tỉnh/Thành phố</th>
                        <th>Quận/Huyện</th>
                        <th>Xã/Phường</th>
                        <th>Phí vận chuyển</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feeShips as $feeShip)
                        <tr>
                            <td>{{ $feeShip->id }}</td>
                            <td>{{ $feeShip->city?->city_name }}</td>
                            <td>{{ $feeShip->district?->district_name }}</td>
                            <td>{{ $feeShip->ward?->ward_name }}</td>
                            <td class="fee_ship" data-fee_id="{{ $feeShip->id }}" contenteditable>{{ $feeShip->fee_ship }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal"
                                        data-target="#modalDelete"
                                        data-action="{{ route('shipping.destroy', ['shipping' => $feeShip]) }}">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="6">Không có dữ liệu</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.layouts.modalDelete')
@stop

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script>
        $(document).on('blur', '.fee_ship', function() {
            const feeId = $(this).data('fee_id');
            const text = $(this).text();
            const url = $('#url').val();
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    feeId: feeId,
                    text: text
                },
                success: function(data) {
                    $('#alert_edit').html(
                        '<p class="alert alert-success" role="alert">Cập nhập phí vận chuyển thành công</p>'
                        );
                }
            });
        });
    </script>
@endpush
