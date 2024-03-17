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
$prioridad = $_POST['prioridad'];
$categoria = $_POST['categoria'];
$idTarea = $_POST['idTarea'];

$r = mysqli_query($link, "SELECT * FROM categoria WHERE catgoria='$categoria'");
$f = mysqli_query($link, "SELECT * FROM prioridad WHERE prioridad='$prioridad'");

    if (mysqli_num_rows($r) > 0) {
        $fila_c = mysqli_fetch_assoc($r); 
        $id_cat = $fila_c['id'];
        if(mysqli_num_rows($f) > 0){
            $fila_p = mysqli_fetch_assoc($f);
            $id_pri = $fila_p['id'];  
        
        $titulo = mysqli_real_escape_string($link, $titulo);
        $contenido = mysqli_real_escape_string($link, $contenido);
        $fecha = mysqli_real_escape_string($link, $fecha);
        $hora = mysqli_real_escape_string($link, $hora);
        $var = mysqli_real_escape_string($link, $var);
        $id_cat = mysqli_real_escape_string($link, $id_cat);
        $id_pri = mysqli_real_escape_string($link, $id_pri);

        mysqli_query($link,"UPDATE tarea
                            SET titulo='$titulo', contenido= '$contenido', fecha_inicio = '$fecha', hora_inicio='$hora',categoria_id='$id_cat', prioridad_id ='$id_pri' WHERE id= '$idTarea'");
        echo "<script>window.history.go(-2);</script>";
        }else{
        echo "<script>alert('No se encontró la prioridad');</script>";
        }
    } else {
        echo "<script>alert('No se encontró la categoría');</script>";
         echo "<script>window.history.go(-2);</script>";
    }

?>