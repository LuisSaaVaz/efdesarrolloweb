<?php
    $arc = $_FILES["archivo"]["name"];
    echo "$arc<br>";
    
    $arctemp = $_FILES["archivo"]["tmp_name"];
    echo "$arctemp<br>";

    move_uploaded_file($arctemp, "./ficheros/$arc");
?>