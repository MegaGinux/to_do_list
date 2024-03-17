<?php
session_start();
$var = $_SESSION["cc"];

$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();

$titulo = $_POST['titulo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$contenido = $_POST['contenido'];
$filtro = $_POST['categoria'];

$r = mysqli_query($link, "SELECT * FROM categoria WHERE catgoria='$filtro'");

if ($r) {
    if (mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r); 
        $id_cat = $fila['id']; 
        
        $titulo = mysqli_real_escape_string($link, $titulo);
        $contenido = mysqli_real_escape_string($link, $contenido);
        $fecha = mysqli_real_escape_string($link, $fecha);
        $hora = mysqli_real_escape_string($link, $hora);
        $var = mysqli_real_escape_string($link, $var);
        $id_cat = mysqli_real_escape_string($link, $id_cat);

        mysqli_query($link, "INSERT INTO tarea(titulo, contenido, fecha, hora_inicio, usuario_id, categoria_id, terminado) VALUES ('$titulo', '$contenido', '$fecha', '$hora', '$var', '$id_cat', 0)");

        //echo "<script>alert('Tarea añadida con éxito'); window.location='hoy.php';</script>";
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('No se encontró la categoría');</script>";
        header("Location: agregar.php");
    }
} else {
    // Si hubo un error en la consulta
    echo "Error al ejecutar la consulta: " . mysqli_error($link);
}
?>


