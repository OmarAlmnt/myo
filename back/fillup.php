<?php

include 'conexion.php'; 
  if (empty($_GET["id"])) {
      

    header("location:./proveedores.php");

   }

  $idc = $_GET["id"]; 



  $q = "SELECT nombreprov,representante,telefono,pais FROM proveedor WHERE idproveedor = $idc;";
  $e = mysqli_query($con,$q);
  
  $contador = mysqli_num_rows($e); 

  if ($contador > 0) {
        while ($datos = mysqli_fetch_array($e)) {
            
            $nombreprov = $datos['nombreprov'];
            $representante = $datos['representante'];
            $telefono = $datos['telefono'];
            $pais = $datos['pais'];

        }
   }


?>