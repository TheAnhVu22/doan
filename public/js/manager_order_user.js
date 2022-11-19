$(function() {
    $('.btnCancelOrder').click(function() {
        const order_code = $(this).data('id');
        const user_id = $('#user_id').val();
        const url = $(this).data('url');
        Swal.fire({
            title: 'Bạn có chắc muốn hủy đơn hàng? Nhập lý do muốn hủy',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            cancelButtonText: 'Quay lại',
            confirmButtonText: 'Hủy đơn',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: {
                            order_code: order_code,
                            reason: result.value,
                            user_id: user_id
                        },
                        success: function(data) {
                            if (data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    text: data.error,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    text: data,
                                })
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            }
                        }
                    });
                } else {
                    Swal.fire('Hủy đơn thất bại! vui lòng nhập lý do muốn hủy đơn.')
                }
            }
        })
    });
});