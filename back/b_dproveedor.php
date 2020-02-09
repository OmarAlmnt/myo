
<?php 

include 'conexion.php';
 if (empty($_GET["id"])) {
      

    header("location:./proveedores.php");

   } else{

   	$id = $_GET["id"];
   }

$q = "UPDATE proveedor SET activo = 'no' WHERE idproveedor = $id";

$ejecutar = mysqli_query($con,$q);

header("location:../proveedores.php");
?>