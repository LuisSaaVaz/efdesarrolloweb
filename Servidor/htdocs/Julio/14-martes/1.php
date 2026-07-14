<?php
    $con = new mysqli("10.10.10.160", "clase", "1234", "examenfinal");

    $sqlCon = "SELECT * FROM personal";

    $res = $con ->query($sqlCon);

    // Esto da error
    // echo $res;

    // Mostrar lo que hay en $res
    var_dump($res);
    echo "<hr>";
    echo "<br>";

    // Acceder a la propiedad num_rows
    echo $res->num_rows;
    echo "<hr>";
    echo "<br>";
    
    $personas_array = $res -> fetch_array(); // Da una unica fila con el doble de columnas que hay en la tabla. Acceso por key "MYSQLI_ASSOC" o  por posición "MYSQLI_NUM".
    var_dump($personas_array);
    echo "<hr>";
    echo "<br>";

    $personas_assoc = $res -> fetch_assoc(); // Da una unica fila. Acceso por key. 
    var_dump($personas_assoc);
    echo "<hr>";
    echo "<br>";
    
    $personas_all = $res -> fetch_all(); // Da todas las filas. Acceso por key "MYSQLI_ASSOC" o  por posición "MYSQLI_NUM". 
    var_dump($personas_all);
    echo "<hr>";
    echo "<br>";

    $lista = "";

    foreach($personas_all as $persona){
        
        $propiedades = "";
        foreach ($persona as $key) {
            $propiedades .= "<td>$key</td>";
        }
            
            
        $lista .= "<tr>$propiedades</tr>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Consultas</h1>
    </header>
    <main>
        <table border="1">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>NOMBRE</td>
                    <td>APELLIDOS</td>
                    <td>EDAD</td>
                    <td>EMAIL</td>
                    <td>CONTRASEÑA</td>
                    <td>CUMPLEAÑOS</td>
                    <td>SEXO</td>
                </tr>
            </thead>
            <tbody>
                <?= $lista ?>
            </tbody>
        </table>
    </main>
</body>

</html>