<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <input type="text" name="nombre" placeholder="Nombre">
        <br>
        <input type="text" name="apellidos" placeholder="Apellidos">
        <br>
        <label>Localidad</label>
        <select name="" id="">
            <?php 
                // Conexión a la DDBB
                $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

                // SQL para consultar
                $sql = "SELECT DISTINCT(localidad) FROM clientes ORDER BY localidad ASC";
                $sql = "SELECT localidad FROM clientes GROUP BY localidad ORDER BY localidad ASC";

                // Ejecutar la Conexión con el SQL guardando el resultado
                $response = $con->query($sql);

                foreach ($response as $localidad ) {
                    $loc = $localidad["localidad"]
                    ?>

            <option ><?=$loc?></option>
            <?php
                }
            ?>
        </select>
    </form>
    
</body>
</html>