<?php
    function menuLogin(){
        echo "
        <menu>
            <a href='./index.php'>Inicio</a>
            <a href='./contacto.php'>Contacto</a>
            <a href='./entrar.php'>Entrar</a>
            <a href='./registro.php'>Registrarse</a>
        </menu>
        ";
    };
    function menuLogout(){
        echo "
        <menu>
            <a href='./index.php'>Inicio</a>
            <a href='./contacto.php'>Contacto</a>
            <a href='./perfil.php'>Perfil</a>
            <a href='./direcciones.php'>Direcciones</a>
            <a href='./salir.php'>Salir</a>
        </menu>
        ";
    };
?>