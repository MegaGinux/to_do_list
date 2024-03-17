<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .custom-navbar-bg {
      background-color: #151515 ;
    }
    .centrar-botones {
      text-align: center;
    }
    .no-seleccionable {
      -webkit-user-select: none; /* Chrome y Safari */
      -moz-user-select: none; /* Firefox */
      -ms-user-select: none; /* IE 10+ */
      user-select: none;
    }
  </style>
</head>
<?php
if(isset($_SESSION['cc'])) {
?>
<body class="no-seleccionable">
  
  <nav class="navbar navbar-expand-lg nav-underline navbar-light custom-navbar-bg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">
        <img src="icono_tareas.png" class="img-fluid" alt="Icono Tareas" style="max-width: 50px;">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-light " href="activadas.php">Activas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light " href="hoy.php">Para hoy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="programados.php">Programadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light " href="terminados.php">Terminadas</a>
                </li>
            </ul>
        </div>
    </div>
  </nav>

  <div class="rounded p-4 position-absolute top-50 start-50 translate-middle text-center">
    <p class="lead">No te vayas :c</p>
    <div class="centrar-botones mt-4">
      <a class="btn btn-dark" href="cerrar_sesion.php">Cerrar la sesión</a>
    </div>
  </div>

</body>

<?php     
} else {
?>
<body class="no-seleccionable">
  <nav class="navbar navbar-expand-lg nav-underline navbar-light custom-navbar-bg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">
        <img src="icono_tareas.png" class="img-fluid" alt="Icono Tareas" style="max-width: 50px;">
      </a>
    </div>
  </nav>
  <div class="rounded p-4 position-absolute top-50 start-50 translate-middle text-center">
    <h1 class="display-4">¡Bienvenido a nuestra Plataforma de Gestión de Tareas!</h1>
    <p class="lead">Optimiza tu productividad y organiza tus tareas de manera efectiva.</p>
    <div class="centrar-botones mt-4">
      <a class="btn btn-dark" href="crear_cuenta.html">Crear Cuenta</a>
      <a class="btn btn-dark" href="iniciar_sesion.html">Iniciar Sesión</a>
    </div>
  </div>
</body>
<?php
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
