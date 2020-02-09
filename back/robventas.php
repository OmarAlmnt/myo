<?php 
$busqueda = $_REQUEST["busqueda"];
if (isset($_REQUEST['buscar'])) {
	header("location:../ventas.php?busqueda=$busqueda");

} else {

	header("location:../ventas.php");

}


?>