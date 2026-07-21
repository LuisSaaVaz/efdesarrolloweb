<?php
    // POST
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    
    if ($num1 > $num2) {
        echo "$num1 es mayor que $num2";
    } else if ($num1 == $num2) {
        echo "$num1 es igual a $num2";
    } else {
        echo "$num1 es menor que $num2";
    }

    echo "<br><a href='./formif.html'><button>Volver</button></a>";
?>