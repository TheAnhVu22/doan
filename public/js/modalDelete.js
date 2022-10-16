$(function() {
    $('.btnDelete').click(function() {
        $('#formDelete').attr('action', $(this).data('action'));
    });

    $('#modalDelete').on('hidden.bs.modal', function() {
        $('#formDelete').attr('action', '#');
    })
})