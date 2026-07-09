<?php 
    session_start();
    if(isset($_GET['id'])) {
        include ('conexion.php');
        $id = $_GET['id'];
        $sqlDel = "DELETE FROM personal WHERE id_per = ?";
        $stmt = $con->prepare($sqlDel);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($id == $_SESSION['logged']['id']) {
            session_destroy();
        }
        
        if($_SESSION['logged']) {
            header("Location: index.php?msg=" . urlencode("Usuario eliminado exitosamente"));
        } else {
            header("Location: index.php?msg=");
        }
    }
?>