<?php
    // POST
    $num1 = $_POST["numero1"];
    $num2 = $_POST["numero2"];
    $result1 = $num1 + $num2;
    echo "He recibido los datos $num1 y $num2 y la suma es $result1";
    
    // GET
    $n1 = $_GET["numero1"];
    $n2 = $_GET["numero2"];
    $result2 = $n1 + $n2;
    echo "He recibido los datos $n1 y $n2 y la suma es $result2<br>";

    echo "<a href='./formulario.html'><button>Volver</button></a>";
?>