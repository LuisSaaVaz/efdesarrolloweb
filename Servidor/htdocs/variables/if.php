<?php
    $x = 7;

    // If
    if ($x > 10) {
        # code if true...
    echo "$x es mayor de 10"
    } else {
        # code if false...
        echo "$x no es mayor de 10"

        if ($x == 10) {
            # code...
            echo "$x es igual a 10"
        } else {
            # code...
            echo "$x es menor de 10"
        }
        
    }

    if ($x > 10) {
        echo "$x es mayor de 10"
    } else if ($x == 10) {
        echo "$x es igual a 10"
    } else {
        echo "$x es menor de 10"
    }
    
?>