<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();
$var = $_SESSION["cc"];

/*
if (isset($_SESSION["cc"])) {
    echo "La variable de sesión 'cc' está configurada correctamente. Valor: " . $_SESSION["cc"];
} else {

    echo "La variable de sesión 'cc' no está configurada.";
}
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-navbar-bg {
            background-color: #2C3848;
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
<body class="">

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
                    <a class="nav-link text-light active" href="programados.php">Programados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light " href="terminados.php">Terminados</a>
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
        
        $consulta = "select tarea.id,tarea.titulo,tarea.contenido,tarea.fecha,tarea.hora_inicio,tarea.hora_terminada,categoria.catgoria
from tarea,categoria,usuario
WHERE tarea.usuario_id=usuario.id
and tarea.categoria_id=categoria.id
and tarea.terminado = 0
and tarea.fecha >= CURDATE()
and usuario_id= ? ORDER by fecha";
        
        $stmt = $link->prepare($consulta);
        
        $stmt->bind_param("s", $var); 
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                echo '<li class="list-group-item">';
                echo '<div class="d-flex flex-column">';
                echo '<h5>' . $fila['titulo'] . '</h5>';
                echo '<p>' . $fila['fecha'] .'</p>';
                echo '<p>' . $fila['hora_inicio'] . '</p>';
                echo '<p>' . $fila['catgoria'] . '</p>';
                echo '<p>' . $fila['contenido'] . '</p>';
                echo '</div>';

                echo '<div class="text-center mt-2">';

                echo '<div class="d-inline-block mx-1">';
                echo '<form  action="terminar_tarea.php" method="POST">';
                echo '<input type="hidden" name="idTarea" value="' . $fila['id'] . '">';
                echo '<button type="submit" class="btn btn-dark" name="terminar_tarea">Terminar</button>';
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
                echo '<button type="submit" class="btn btn-dark" name="borrarTarea">Borrar</button>';
                echo '</form>';
                echo '</div>';

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

<div class="mt-3"></div>

<div class="d-flex justify-content-end align-items-center fixed-bottom m-3">
    <a type="button" class="btn btn-dark  rounded-circle" href="agregar.html">+</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filtrar').addEventListener('click', function() {
        var filtro = document.getElementById('exampleDataList').value;
        console.log('Filtro seleccionado:', filtro);
        
        var tareas = document.querySelectorAll('.list-group-item');
        tareas.forEach(function(tarea) {
            var categoria = tarea.querySelector('p:nth-of-type(3)').textContent.trim(); 
            var titulo = tarea.querySelector('h5').textContent.trim(); 
            var fecha = tarea.querySelector('p:nth-of-type(1)').textContent.trim();
            console.log('Categoría de tarea:', categoria);
            console.log('Título de tarea:', titulo);
            console.log('Fecha de tarea:', fecha);
            
            if (filtro === '' || categoria === filtro || titulo === filtro || fecha === filtro) {
                tarea.style.display = 'block';
            } else {
                tarea.style.display = 'none';
            }
        });
    });
});
</script>

