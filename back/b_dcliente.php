<?php 

include 'conexion.php';
 if (empty($_GET["id"])) {
      

    header("location:./clientes.php");

   } else{

   	$id = $_GET["id"];
   }

$q = "UPDATE cliente SET activo = 'no' WHERE idcliente = $id";

$ejecutar = mysqli_query($con,$q);

header("location:../clientes.php");
?>