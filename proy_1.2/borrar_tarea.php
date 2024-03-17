<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link=conectarse();

if (isset($_POST['borrar_tarea'])) {

    $idTarea = $_POST['idTarea'];

    $query = "UPDATE tarea SET eliminada = 1 WHERE id = '$idTarea'";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        echo "<script>window.history.go(-1);</script>";
    } else {
        echo "<script>alert('Error al eliminar la tarea');</script>";
    }
    mysqli_close($link);
}
?>