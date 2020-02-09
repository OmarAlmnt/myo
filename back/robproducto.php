<?php 
$busqueda = $_REQUEST["busqueda"];
if (isset($_REQUEST['buscar'])) {
	header("location:../productos.php?busqueda=$busqueda");

} else {

	header("location:../productos.php");

}


?>