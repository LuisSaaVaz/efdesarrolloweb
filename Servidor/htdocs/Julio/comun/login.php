<?php
    function login() {       
        include("./conexion.php"); 
        $email = $_POST['email'];
        $password_input = $_POST['password'];

        // Consulta segura con statements para evitar inyección SQL
        $sqlCon = "SELECT * FROM users WHERE email = ? AND role = 'teacher'";
        $stmt = $con->prepare($sqlCon);
        $stmt->bind_param("s", $email); //s de string, i de integer
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $user = $res->fetch_assoc();
            
            // Verificamos el hash de la contraseña
            if (password_verify($password_input, $user['password'])) {
                $_SESSION['logged'] = [
                    'id'        => $user['id'],
                    'nombre'    => $user['nombre'],
                    'apellidos' => $user['apellidos'],
                    'dni'       => $user['dni']
                ];
                
                header("location:fichar.php");
                exit();
            }
        }
        
        // Si llega aquí, algo falló (email no existe o pass incorrecta)
        return "Credenciales incorrectas.";
    }
?>