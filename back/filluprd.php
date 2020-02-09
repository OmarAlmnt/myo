<?php

include 'conexion.php'; 
  if (empty($_GET["id"])) {
      

    header("location:./productos.php");

   }

  $idc = $_GET["id"]; 



  $q = "SELECT descripcion,precio,existencia,idproveedor FROM producto WHERE idprod = $idc;";
  $e = mysqli_query($con,$q);
  
  $contador = mysqli_num_rows($e); 

  if ($contador > 0) {
        while ($datos = mysqli_fetch_array($e)) {
            
            $descripcion = $datos['descripcion'];
            $precio = $datos['precio'];
            $existencia = $datos['existencia'];
            $proveedor = $datos['idproveedor'];

        }
   }


?>