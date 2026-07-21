<?php 
    // Recibir datos
    $ema = $_POST['email'];
    $emae = base64_encode($ema);
    $pass = $_POST['password'];

    // Conectar a la DDBB
    $con = new mysqli("localhost", "root", "", "lunes8");

    // SQL para consultar
    $sql = "SELECT * FROM clientes WHERE email_cli = '$emae'";

    // Ejecutar la Conexión con el SQL guardando el resultado
    $res = $con->query($sql);

    // Comprobar nº resultados
    if ($res->num_rows) {
        // El email esta en la DDBB
        foreach ($res as $cliente) {
            $idcli = $cliente["id_cli"]; // Plano
            $nomcli = $cliente["nom_cli"]; // Encriptado
            $passcli = $cliente["password_cli"]; // Encriptado

            // Comprobar si el password es correcto
            if (password_verify($pass, $passcli)) {
                // echo "Te has logeado correctamente";
                // Crear sesion
                session_start();
                $_SESSION["clientes"] = $nomcli;
                header("location:privado.php");
            } else {
                echo "Contraseña erronea";
            }
        }
    } else {
        // El email no esta en la DDBB
        echo "Email incorrecto";
    }
        
    echo "<br><a href = './login.html'><button>Volver</button></a>";
?>