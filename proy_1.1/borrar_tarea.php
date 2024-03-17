<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link=conectarse();

if (isset($_POST['borrarTarea'])) {


    require_once "conexion.php";

 
    $idTarea = $_POST['idTarea'];

    
    $query = "DELETE FROM tarea WHERE id = '$idTarea'";
    $resultado = mysqli_query($link, $query);

 
    if ($resultado) {
        //echo "<script>alert('Tarea eliminada correctamente');</script>";
        header("Location: hoy.php");
    } else {
        echo "<script>alert('Error al eliminar la tarea');</script>";
    }

   
    mysqli_close($link);
}
?>