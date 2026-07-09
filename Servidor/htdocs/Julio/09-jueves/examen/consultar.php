<?php 
    include ('conexion.php');

    $sqlCon = "SELECT * FROM personal";
    $res = $con->query($sqlCon);

    $filas = "";
    foreach ($res as $user) {
        $filas .= "<tr>
            <td>" . $user['id_per'] . "</td>
            <td>" . $user['nombre_per'] . "</td>
            <td>" . $user['apellidos_per'] . "</td>
            <td>" . $user['email_per'] . "</td>
            <td>
                <button class='btn btn-sm btn-warning edit-btn' 
                    data-id='{$user['id_per']}' 
                    data-nombre='{$user['nombre_per']}' 
                    data-apellidos='{$user['apellidos_per']}' 
                    data-email='{$user['email_per']}' 
                    data-bs-toggle='modal' data-bs-target='#modalEditar'>
                    Editar
                </button>
                <button class='btn btn-sm btn-danger delete-btn' 
                    data-id='{$user['id_per']}' 
                    data-bs-toggle='modal' data-bs-target='#modalBorrar'>
                    Borrar
                </button>
            </td>
        </tr>";
    }

    $table = '
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            ' . $filas . '
        </tbody>
    ';

    $script = "<script>
        $(document).ready(function() {
            $('main').html(`$table`);
        });
    </script>";
    
    echo $script;

?>