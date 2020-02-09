<?php 

  include 'links/session.php';
  include 'links/registrarclientelinks.php';
  if (!empty($_POST)) {
      
  

        include 'back/conexion.php';
        $nombre = $_POST["nombre"];
        $representante = $_POST["representante"];
        $telefono = $_POST["telefono"];
        $pais = $_POST["pais"];

        $query = "INSERT INTO proveedor (`idproveedor`, `nombreprov`, `representante`, `telefono`, `pais`) VALUES (NULL, '$nombre', '$representante', '$telefono', '$pais');";

             $insert = mysqli_query($con, $query);
             $aviso = "<p class='av_good'>proveedor registrado correctamente</p>";

       

      
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
    <h1 class="black down"><a class="black" href="proveedores.php">Proveedores</a> ></h1>
    <h4 class="downr2">nuevo proveedor</h4>
    	<!--div form-->
    <div class="downp">
        <div class="mensaje" align="center"><?php if (!empty($_POST)) {echo $aviso;}?></div>
    	<div class="frm_registrar">
			<form method="post" action="registrarprov.php">

				
				<label>Nombre</label>
                <br>
    			<input name="nombre" type="text" class="iwi" placeholder="Nombre de proveedor" required>
                <br><br>
				

    			<label>Representante</label>
                <br>
    			<input name="representante"type="text" class="iwi" placeholder="Representante de proveedor" required>
				<br><br>
				
				<label>Telefono</label>
                <br>
    			<input name="telefono" type="text" class="iwi" placeholder="Telefono de cliente" required>
                <br><br>
    			<label>Pais</label>
                <br>
    			<input name="pais" placeholder="pais de proveedor" type="text" class="iwi" required>

    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" >

		
		  	</form>






        </div>
    	</div>
</body>
</html>