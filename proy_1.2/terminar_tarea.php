<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();

if (isset($_POST['terminar_tarea'])) {
    $idTarea = $_POST['idTarea'];

    $query = "UPDATE tarea 
              SET terminada = 1, fecha_fin = CURDATE(), hora_terminada = CURTIME()         
              WHERE id='$idTarea'";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        $mysqli_query = "UPDATE tarea
                        SET tiempo = SEC_TO_TIME(
                                    TIMESTAMPDIFF(SECOND, TIMESTAMP(fecha_inicio, hora_inicio), TIMESTAMP(fecha_fin, hora_terminada))
                                )
                        WHERE id='$idTarea';";
        mysqli_query($link, $mysqli_query);
        echo "<script>window.history.go(-1);</script>";
        exit();
    } else {
        echo "<script>alert('Error al terminar la tarea');</script>";
    }
} else {
    echo "<script>alert('Error al terminar la tarea');</script>";
}

mysqli_close($link);
?>
