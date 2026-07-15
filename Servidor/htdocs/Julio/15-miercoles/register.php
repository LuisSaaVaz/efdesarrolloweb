<?php
    include ("conexion.php");

    try{
        if (isset($_POST)) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $tipo = $_POST['tipo'];
            
            $sqlIns = "INSERT INTO $tipo (nombre, descripcion, precio) VALUES (?, ?, ?)";
            echo $sqlIns;
    
            $stmt = $con->prepare($sqlIns);
            
            $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
            
            $stmt->execute();
            $result = $stmt->get_result();
    
            echo $result;
        }
    } catch(error){
        
    }
?>