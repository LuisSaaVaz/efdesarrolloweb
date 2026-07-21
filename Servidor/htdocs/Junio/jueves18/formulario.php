<?php
    // Necesito 32 inputs
    $inputs = 32;
    // Enviar a recibir.php
    $inputshtml ="";
    for ($i=1; $i <= $inputs; $i++) { 
        $inputshtml .= "<input name='dato_$i' placeholder='Dato $i' value='Este es el dato $i'><br>";
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
        <h1>Formulario</h1>
    </header>
    <form action="./recibir.php" method="POST">
        <?= $inputshtml ?>
        <br><br>
        <button>Enviar</button>
    </form>
    <i>hola</i>
</body>

</html>