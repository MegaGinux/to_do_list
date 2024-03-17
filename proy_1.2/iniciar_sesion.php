<?php
session_start();
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link=conectarse();
$usuario = $_POST["usuario"];
$password = $_POST["contrasena"];
$r=mysqli_query($link,"Select * from usuario where usuario='$usuario' and contrasena='$password'");
if(mysqli_num_rows($r))
    {
        if($row=mysqli_fetch_array($r))
        {
            if($row["contrasena"] == $password)
            {
                $_SESSION["cc"]=$row["id"];
                header("Location: activadas.php");
            }
        }
    }else{
    	 echo "<script>alert('Los datos ingresados son incorrectos. Por favor, inténtalo nuevamente.');window.location='iniciar_sesion.html';</script>";
    }
?>