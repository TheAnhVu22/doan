$(document).on('change', '.selectAddress', function() {
    const action = $(this).attr('id');
    const id = $(this).val();
    const url = $('#url').val();
    let elementId = '';

    $.ajax({
        url: url,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: {
            action: action,
            id: id
        },
        success: function(data) {
            if (action === 'city') {
                $('#select_district').html(data);
                $('#select_ward').html(`
                    <div class="form-group">
                        <label for="ward">Xã/phường:</label><label style="color: red">(*)</label>
                        <select class="form-control" id="ward" name="ward">
                            <option value="" selected>Chọn xã/phường</option>
                        </select>
                    </div>
                `);
            } else {
                $('#select_ward').html(data);
            }

        }
    });
})