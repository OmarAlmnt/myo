<?php 

include 'conexion.php';
 if (empty($_GET["id"])) {
      

    header("location:./productos.php");

   } else{

   	$id = $_GET["id"];
   }

$q = "UPDATE producto SET activo = 'no' WHERE idprod = $id";

$ejecutar = mysqli_query($con,$q);

header("location:../productos.php");
?>