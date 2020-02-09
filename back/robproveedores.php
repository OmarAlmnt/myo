<?php 
$busqueda = $_REQUEST["busqueda"];
if (isset($_REQUEST['buscar'])) {
	header("location:../proveedores.php?busqueda=$busqueda");

} else {

	header("location:../proveedores.php");

}


?>