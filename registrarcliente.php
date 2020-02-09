<?php 

  include 'links/session.php';
  include 'links/registrarclientelinks.php';
  if (!empty($_POST)) {
      
  

        include 'back/conexion.php';
        $nombre = $_POST["nombre"];
        $RNC = $_POST["RNC"];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];
        $fecha_e = $_POST["fecha_entrada"];

        $query = "INSERT INTO cliente (`idcliente`, `nombre`, `RNC`, `direccion`, `telefono` , `fecha_entrada`) VALUES (NULL, '$nombre', '$RNC', '$direccion', '$telefono' , '$fecha_e');";

             $insert = mysqli_query($con, $query);
             $aviso = "<p class='av_good'>cliente registrado correctamente</p>";

       

      
    }


?>
 
<!DOCTYPE html>
<html>
<head>
	



	<script src="js/jsidebar.js"></script>
	<title>MYO</title>
</head>
<body>


	
	<div class="wrapper">
    
    <?php
    include 'links/sidebar.php'; 
    ?>

    <div class="main_content">
    <h1 class="black down"><a class="black" href="clientes.php">Clientes</a> ></h1>
    <h4 class="downr">nuevo cliente</h4>
    	<!--div form-->
    <div class="downp">
        <div class="mensaje" align="center"><?php if (!empty($_POST)) {echo $aviso;}?></div>
    	<div class="frm_registrar">
			<form method="post" action="registrarcliente.php">

				
				<label>Nombre</label>
                <br>
    			<input name="nombre" type="text" class="iwi" placeholder="Nombre de cliente" required>
                <br><br>
				

    			<label>RNC</label>
                <br>
    			<input name="RNC"type="text" class="iwi" placeholder="RNC de cliente" required>
				<br><br>
				<label>Direccion</label>
                <br>
    			<input name="direccion" type="option" class="iwi" placeholder="Direccion de cliente" required>
                <br><br>
                <label>Telefono</label>
                <br>
                <input name="telefono" type="option" class="iwi" placeholder="Telefono de cliente" required>
                <br><br>
    			<label>fecha de entrada</label>
                <br>
    			<input name="fecha_entrada" placeholdet="" type="date" class="iwi" required>

    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" >

		
		  	</form>






        </div>
    	</div>
</body>
</html>