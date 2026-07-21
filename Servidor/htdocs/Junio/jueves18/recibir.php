<?php
    $innerhtml = "";
    if ($_POST) {
        /* for ($i=1; $i <= count($_POST); $i++) { 
            $dato = "dato_$i";
            $innerhtml.= "<p>$_POST[$dato]</p>";
        } */
       foreach ($_POST as $dato) {
           $innerhtml.= "<p>$dato</p>";
       }
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
    <?php
        if ($innerhtml) {
            echo $innerhtml;
        } else {
            echo "<p>No hay datos</p>";
            echo "<a href='./formulario.php'><button>Volver</button></a>";
        }
    ?>
</body>

</html>