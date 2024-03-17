<?php
$dir = dirname(__FILE__);
require_once $dir."/conexion.php";
$link = conectarse();

$correo_electronico   = $_POST['email'];
$usuario  = $_POST['usuario'];
$password = $_POST['contrasena'];

$r=mysqli_query($link,"Select * from usuario where email='$correo_electronico'");

$u =mysqli_query($link,"Select * from usuario where usuario='$usuario'");

if(mysqli_num_rows($u)>0){
    echo "<script>alert('El usuario ya está registrado. Por favor, inicia sesión si ya tienes una cuenta o intenta con otro usuario.'); window.location='crear_cuenta.html';</script>";

}
else{
    if(mysqli_num_rows($r)>0){
    
    echo "<script>alert('El correo electrónico ya está registrado. Por favor, intenta con otro.'); window.location='crear_cuenta.html';</script>";

                        }
    else
    {
          if(isset($usuario) && !empty ($usuario))
          {
                mysqli_query($link, "INSERT INTO usuario (usuario, email,contrasena) VALUES('$usuario','$correo_electronico','$password')");
          
                echo "<script>alert('¡Registro exitoso! Te damos la bienvenida a nuestra plataforma.'); window.location='iniciar_sesion.html';</script>";
          }
    else
    {
       echo "<script>alert('Se produjo un error al actualizar los datos. Por favor, inténtalo de nuevo más tarde.'); window.location='iniciar_sesion.html';</script>";

    }

    } 
}
    

?> 
