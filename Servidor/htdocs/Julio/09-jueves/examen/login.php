<?php 
	session_start();
	include ('conexion.php');
	
    $msg = "";
	if($_POST){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$stmt = $con->prepare("SELECT * FROM personal WHERE email_per = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows === 1){
			$user = $result->fetch_assoc();
            if (password_verify($password, $user['contrasena_per'])) {                   
                $_SESSION['logged'] = [
                    'id'        => $user['id_per'],
                    'nombre'    => $user['nombre_per'],
                    'apellidos' => $user['apellidos_per'],
                    'email'    => $user['email_per']
                ];

                $msg="Inicio de sesión exitoso";
            } else {
                $msg="Usuario o contraseña incorrectos";
            }
		} else {
			$msg="Usuario o contraseña incorrectos";
		}
	} else {
        $msg="No se recibieron datos del formulario";
    }

    header("Location: index.php?msg=" . urlencode($msg));
?>