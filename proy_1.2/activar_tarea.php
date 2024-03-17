<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();

if (isset($_POST['activar_tarea'])) {
    $idTarea = $_POST['idTarea'];
    echo "$idTarea";

    $query = "UPDATE tarea SET activa = 1, fecha_inicio = CURDATE(), hora_inicio = CURTIME() WHERE id='$idTarea'";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        //echo "<script>alert('Tarea activada correctamente');</script>";
        echo "<script>window.history.go(-1);</script>";
        exit();
    } else {
        echo "<script>alert('Error al activar la tarea');</script>";
    }
} else {
    echo "<script>alert('Error al activar la tarea');</script>";
}

mysqli_close($link);
?>
