<?php 

  function crear(){
    include("./conexion.php");

    $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
      id INT(3) AUTO_INCREMENT PRIMARY KEY,
      nombre VARCHAR(50) NOT NULL,
      apellidos VARCHAR(50) NOT NULL,
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      dni CHAR(9) NOT NULL,
      role ENUM('teacher', 'student'),
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
    );";

    $sqlInOuts = "CREATE TABLE IF NOT EXISTS in_outs (
      id INT(3) AUTO_INCREMENT PRIMARY KEY,
      dia DATE NOT NULL,
      hora TIME NOT NULL,
      tipo ENUM('in', 'out') NOT NULL,
      user_id INT NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,
      FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );";

    $con->query($sqlUsers);
    $con->query($sqlInOuts);

    $nombre = "Alfonso";
    $apellidos = "Carro Moris";
    $dni = "12345678A";
    $email = "alfonso@email.com";
    $password = password_hash("password", PASSWORD_DEFAULT);

    $sqlCon = "SELECT * FROM users WHERE email = '$email'";
    $res = $con->query($sqlCon);

    if ($res->num_rows == 0) {
      $sqlInsert = "INSERT INTO users (nombre, apellidos, email, password, dni, role) VALUES ('$nombre', '$apellidos', '$email', '$password', '$dni', 'teacher')";
      $con->query($sqlInsert);
    }
  }

  function eliminar(){
    include("./conexion.php");

    $sqlDropTables = "DROP TABLE IF EXISTS in_outs, users;";

    $con->query($sqlDropTables);
  }

?>