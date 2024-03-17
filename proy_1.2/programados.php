<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();
$var = $_SESSION["cc"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Programadas</title>
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
            <img src="icono_tareas.png" class="img-fluid" alt="Icono Tareas"  style="max-width: 50px;">
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
                    <a class="nav-link text-light" href="hoy.php">Para hoy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light active" href="programados.php">Programadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light " href="terminados.php">Terminadas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-sm mt-3">

    <div class="container-sm mb-3">
        <div class="row align-items-center">
            <div class="col">
                <div class="input-group">
                    <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Filtrar">
                    <datalist id="datalistOptions">
                        <option value="Domesticas">
                        <option value="Laborales">
                        <option value="Personales">
                    </datalist>
                    <button class="btn btn-dark" id="filtrar" type="button">Filtrar</button>
                </div>
            </div>
        </div>
    </div>

    <ul class="list-group mt-3">
        <?php
        if (isset($_SESSION["cc"])) {
            $var = $_SESSION["cc"];

            $consulta = "select tarea.id,tarea.titulo,tarea.contenido,tarea.hora_inicio,categoria.catgoria,prioridad.prioridad,tarea.fecha_inicio,tarea.activa
            from tarea,categoria,usuario,prioridad
            WHERE tarea.usuario_id=usuario.id
            and tarea.categoria_id=categoria.id
            and tarea.prioridad_id=prioridad.id
            and tarea.terminada = 0
            and tarea.eliminada = 0
            and DATE(tarea.fecha_inicio)>=CURDATE()
            and usuario_id= ? 
            order by prioridad.id,tarea.fecha_inicio,tarea.hora_inicio";

            $stmt = $link->prepare($consulta);

            $stmt->bind_param("s", $var);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($fila = $result->fetch_assoc()) {
                    echo '<li class="list-group-item">';
                    echo '<div class="d-flex flex-column">';
                    echo '<h5>                                ' . $fila['titulo'] . '         </h5>';
                    echo '<p class="text-body-secondary mb-0">' . $fila['prioridad'] . '      </p>';
                    echo '<p class="text-body-secondary">     ' . $fila['catgoria'] . '       </p>';
                    echo '<p class="text-body-secondary mb-0">' . $fila['fecha_inicio'] . '   </p>';
                    echo '<p class="text-body-secondary mb-0">' . $fila['hora_inicio'] . '    </p>';
                    echo '<p class="fs-5">                    ' . $fila['contenido'] . '      </p>';
                    echo '</div>';

                    echo '<div class="text-center mt-2">';

                    if ($fila['activa'] == 1) {
               
                    echo '<div class="d-inline-block mx-1">';
                    echo '<form  action="editar_tarea.php" method="POST">';
                    echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                    echo '<button type="submit" class="btn btn-dark" name="editarTarea">Editar</button>';
                    echo '</form>';
                    echo '</div>';

                    echo '<div class="d-inline-block mx-1">';
                    echo '<form method="POST" action="borrar_tarea.php">';
                    echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                    echo '<button type="submit" class="btn btn-dark" name="borrar_tarea">Borrar</button>';
                    echo '</form>';
                    echo '</div>';

            } else {

                    echo '<div class="d-inline-block mx-1">';
                    echo '<form  action="activar_tarea.php" method="POST">';
                    echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                    echo '<button type="submit" class="btn btn-dark" name="activar_tarea">Activar</button>';
                    echo '</form>';
                    echo '</div>';

                    echo '<div class="d-inline-block mx-1">';
                    echo '<form  action="editar_tarea.php" method="POST">';
                    echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                    echo '<button type="submit" class="btn btn-dark" name="editarTarea">Editar</button>';
                    echo '</form>';
                    echo '</div>';

                    echo '<div class="d-inline-block mx-1">';
                    echo '<form method="POST" action="borrar_tarea.php">';
                    echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                    echo '<button type="submit" class="btn btn-dark" name="borrar_tarea">Borrar</button>';
                    echo '</form>';
                    echo '</div>';
            }

            echo '</div>';
            echo '</li>';
        }
    } else {
        echo '<li class="list-group-item">No hay tareas</li>';
    }

    $stmt->close();
} else {
    echo '<li class="list-group-item">No se ha iniciado sesión</li>';
}
?>
    </ul>

</div>

<div class="mt-5"></div>

<div class="d-flex justify-content-end align-items-center fixed-bottom m-3">
    <a type="button" class="btn btn-dark  rounded-circle" href="anadir_tarea_.php">+</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php     
} else {
    header("Location: index.php");
  exit();
}
?>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('filtrar').addEventListener('click', function() {
            var filtro = document.getElementById('exampleDataList').value;
            console.log('Filtro seleccionado:', filtro);

            var tareas = document.querySelectorAll('.list-group-item');
            tareas.forEach(function(tarea) {

                var titulo = tarea.querySelector('h5').textContent.trim();
                var prioridad = tarea.querySelector('p:nth-of-type(1)').textContent.trim();
                var categoria = tarea.querySelector('p:nth-of-type(2)').textContent.trim();
                var fecha = tarea.querySelector('p:nth-of-type(3)').textContent.trim();

                if (filtro === '' || filtro === titulo || filtro === prioridad || filtro === categoria || filtro === fecha) {
                    tarea.style.display = 'block';
                } else {
                    tarea.style.display = 'none';
                }
            });
        });
    });
</script>