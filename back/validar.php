<?php
include 'conexion.php';

session_start();

$usn = $_POST["username"];
$pw = $_POST["password"];
$query = "SELECT * FROM usuario WHERE username = '$usn' AND password = '$pw';";
$ejecutar = mysqli_query($con,$query);
$contar= mysqli_num_rows($ejecutar);
if ($contar > 0 ) {
$informacion = mysqli_fetch_array($ejecutar);
$_SESSION['fullname'] = $informacion['fullname'];
$_SESSION['idusuario'] = $informacion['idusuario'];
$_SESSION['rol'] = $informacion['rol'];

if ($informacion['rol'] == 'administrador') {
	header("location:../principal.php");
} else{

	header("location:../principal2.php");	
}


} else{

	header("location:../index.php?error=1");

}





?>