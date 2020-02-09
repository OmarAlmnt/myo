<?php

include 'conexion.php'; 
  if (empty($_GET["id"])) {
      

    header("location:./clientes.php");

   }

  $idc = $_GET["id"]; 



  $q = "SELECT nombre,RNC,direccion,telefono,fecha_entrada FROM cliente WHERE idcliente = $idc;";
  $e = mysqli_query($con,$q);
  
  $contador = mysqli_num_rows($e); 

  if ($contador > 0) {
        while ($datos = mysqli_fetch_array($e)) {
            $nombre = $datos['nombre'];
            $RNC = $datos['RNC'];
            $dir = $datos['direccion'];
            $telefono = $datos['telefono'];
            $fecha_e = $datos['fecha_entrada'];

        }
   }


?>