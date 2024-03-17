<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link=conectarse();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Añadir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
  </head>
 <body class="no-seleccionable">
      
    <nav class="navbar navbar-expand-lg nav-underline navbar-light custom-navbar-bg">
      <div class="container-fluid">
        <a class="navbar-brand" href="index_log.php">
          <img src="icono_tareas.png" class="img-fluid" alt="Icono Tareas"  style="max-width: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
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

    <div class="container-sm mt-3 ">
      <?php
      if (isset($_POST['editarTarea'])) {
        $idTarea = $_POST['idTarea'];
        $query = "SELECT tarea.id, tarea.titulo, tarea.fecha, tarea.hora_inicio, tarea.contenido, categoria.catgoria FROM tarea, categoria WHERE tarea.categoria_id = categoria.id AND tarea.id = '$idTarea'";
        $resultado = mysqli_query($link, $query);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
          $fila = mysqli_fetch_assoc($resultado);
      ?>
          <form method="POST" action="actualizar.php">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Titulo</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" name="titulo" value="<?php echo $fila['titulo']; ?>">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Fecha:</label>
              <input type="date" id="start" name="fecha" class="form-control" value="<?php echo $fila['fecha']; ?>">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Hora:</label>
              <input type="time" id="appt" name="hora" class="form-control" required value="<?php echo $fila['hora_inicio']; ?>">
            </div> 
            
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Descripcion</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="contenido"><?php echo $fila['contenido']; ?></textarea>
            </div>

            <div class="mb-3">
              <label for="exampleDataList" class="form-label">Filtro</label>
              <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="" name="categoria" value="<?php echo $fila['catgoria']; ?>" >
  
              <datalist id="datalistOptions">
                <option value="Domesticas">
                <option value="Laborales">
                <option value="Personales">
              </datalist>
            </div>

            <input type="hidden" name="idTarea" value="<?php echo $fila['id']; ?>">

            <div class="centrar-botones mt-3">
              <button type="submit" class="btn btn-dark" name="guardarCambios">Guardar Cambios</button>
            </div>
          </form>
      <?php
        }
        mysqli_close($link);
      }else{
        echo"nada";
      }
      ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<style>
  .custom-navbar-bg {
    background-color: #2C3848;
  }

  .centrar-botones {
    text-align: center;
  }

  .no-seleccionable {
    -webkit-user-select: none; /* Chrome  y Safari */ 
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE 10+ */ 
    user-select: none;
  }
</style>
