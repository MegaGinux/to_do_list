<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Añadir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .custom-navbar-bg {
      background-color: #151515;
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
        <a class="navbar-brand" href="index.php">
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
                    <a class="nav-link text-light" href="hoy.php">Hoy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="programados.php">Programados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="terminados.php">Terminados</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<form action="anadir_tarea.php" method="POST">
    <div class="container-sm mt-3 ">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Titulo</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Fecha:</label>
            <input type="date" id="start" name="fecha" class="form-control" min="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" required/>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Hora:</label>
            <input type="time" id="appt" name="hora" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Descripcion</label>
            <textarea class="form-control" name="contenido" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="exampleDataList" class="form-label">Prioridad</label>
            <input class="form-control" list="datalistOptions1" name="prioridad" required>
            <datalist id="datalistOptions1">
                <option value="Alta">
                <option value="Normal">
                <option value="Baja">
            </datalist>
        </div>
        
        <div class="mb-3">
            <label for="exampleDataList" class="form-label" >Categoria</label>
            <input class="form-control" list="datalistOptions2" name="categoria" required >
            <datalist id="datalistOptions2">
                <option value="Domesticas">
                <option value="Laborales">
                <option value="Personales">
            </datalist>
        </div>

        <div class="centrar-botones mt-3">
            <input type="submit" class="btn btn-dark" value="Añadir">
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php     
} else {
    header("Location: index.php");
  exit();
}
?>
</html>
