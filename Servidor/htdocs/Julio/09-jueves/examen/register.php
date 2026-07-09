<?php 
    include ('conexion.php');
    if ($_POST) {
        // Recibir datos
        $nomper = $_POST['nombre'];
        $apellper = $_POST['apellidos'];
        $emailper = $_POST['email'];
        $passper = $_POST['password'];
        $encripassper = password_hash($passper, PASSWORD_DEFAULT);
        $edadper = $_POST['edad'];
        $fechanacper = $_POST['fecha_nacimiento'];
        $sexoper = $_POST['sexo'];

        // SQL para grabar
        $sqlIns = "INSERT INTO personal (nombre_per, apellidos_per, email_per, contrasena_per, edad_per, fechanacimiento_per, sexo_per) VALUES ('$nomper', '$apellper', '$emailper', '$encripassper', '$edadper', '$fechanacper', '$sexoper')";
        // Insertar
        $con->query($sqlIns);

        header("location:index.php");
    }
?>