<?php
    include("./conexion.php");

    // Leer la sesión
    session_start();

    if (!isset($_SESSION["viernes12"])) {
        header("location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="./home.php">Home</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
        <hr>
        <h1>Home</h1>
    </header>
    <main>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="avatar">

            <button>Actualizar</button>
        </form>
    </main>
</body>
</html>