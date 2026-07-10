<?php 
    session_start();

    $isLogged = isset($_SESSION['logged']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top row">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-person-badge"></i> Gestion</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

                <?php if ($isLogged): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Gestión</a>
                    <ul class="dropdown-menu border-0 shadow">
                        <li><a class="dropdown-item" href="add_user.php">Añadir Usuario</a></li>
                        <li><a class="dropdown-item" href="search.php">Buscar</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex">
                <?php if ($isLogged): ?>
                <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
                <?php else: ?>
                <a class="btn btn-nav btn-light me-2" id="show-login">Login</a>
                <a class="btn btn-nav btn-outline-light" id="show-register">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>