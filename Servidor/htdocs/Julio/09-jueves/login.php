<?php 
	session_start();
	include 'conexion.php';
	
	if($_POST){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$stmt = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows === 1){
			$user = $result->fetch_assoc();
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['role'] = $user['role'];
			header("Location: index.php");
			exit();
		} else {
			echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='index.php';</script>";
		}
	}
?>