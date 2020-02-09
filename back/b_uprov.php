<?php
include 'conexion.php';
$idu = $_GET["ic"];
$nombre = $_POST["nombreprov"];
$representante = $_POST["representante"];
$telefono = $_POST["telefono"];
$pais = $_POST["pais"];

$query = "UPDATE proveedor SET nombreprov = '$nombre', representante = '$representante', telefono = '$telefono', pais = '$pais' WHERE idproveedor = '$idu';";

$insert = mysqli_query($con, $query);

header("location:../proveedores.php");

?>