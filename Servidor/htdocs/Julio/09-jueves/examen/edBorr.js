$(document).ready(function() {
    // Cuando se abre el modal de edición, rellenamos los campos
    $(document).on('click', '.edit-btn', function() {
        $('#edit-id').val($(this).data('id'));
        $('#edit-nombre').val($(this).data('nombre'));
        $('#edit-apellidos').val($(this).data('apellidos'));
    });

    // Cuando se abre el modal de borrado, preparamos la URL
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        $('#btnConfirmarBorrar').attr('href', 'delete.php?id=' + id);
    });
});