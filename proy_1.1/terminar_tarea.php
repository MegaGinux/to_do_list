<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();

// Verificar si se ha enviado el formulario para borrar la tarea
if (isset($_POST['terminar_tarea'])) {
    require_once "conexion.php";

    $idTarea = $_POST['idTarea'];
    echo "$idTarea";

    $query = "UPDATE tarea SET terminado = 1, hora_terminada = CURTIME() WHERE id='$idTarea'";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        echo "<script>alert('Tarea terminada correctamente');</script>";
        header("Location: hoy.php");
    } else {
        echo "<script>alert('Error al terminar la tarea');</script>";
    }

    mysqli_close($link);
}else{
    echo "<script>alert('Error al terminar la tarea');</script>";
}
?>
