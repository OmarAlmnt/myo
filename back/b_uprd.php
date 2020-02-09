<?php
include 'conexion.php';
$idu = $_GET["ic"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$existencia = $_POST["existencia"];
$idproveedor = $_POST["idproveedor"];

$query = "UPDATE producto SET descripcion = '$descripcion', precio = '$precio', existencia = '$existencia', idproveedor = '$idproveedor' WHERE idprod = '$idu';";

$insert = mysqli_query($con, $query);

header("location:../productos.php");

?>