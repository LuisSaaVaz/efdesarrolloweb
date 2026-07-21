<?php 
    $palabra = "Alfonso";

    // Cifrar en una via
    $palabramd5 = md5($palabra);
    echo "$palabramd5<br>";
    
    $palabrahash = password_hash($palabra, PASSWORD_DEFAULT);
    echo "$palabrahash<br>";
    
    // Cifrar en 2 vias

        $palabrab64 = base64_encode($palabra);
        echo "$palabrab64<br>";
        $palabrasinb64 = base64_decode($palabrab64); // No añade caracteres que puedan romper la URL
        echo "$palabrasinb64<br>";
?>