<?php
include 'conexion.php';
$idu = $_GET["ic"];
$nombre = $_POST["nombre"];
$RNC = $_POST["RNC"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$fecha_e = $_POST["fecha_entrada"];

$query = "UPDATE cliente SET nombre = '$nombre', RNC = '$RNC', direccion = '$direccion', fecha_entrada = '$fecha_e', telefono = '$telefono' WHERE idcliente = '$idu';";

$insert = mysqli_query($con, $query);

header("location:../clientes.php");

?>