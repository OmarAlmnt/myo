<?php 

  include 'links/session.php';
  include 'links/u_clientelinks.php';
  include 'back/fillup.php';
  $idc = $_GET["id"];
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
    <h4 class="downr2">editar proveedor</h4>
    	<!--div form-->
    <div class="downp">
    	<div class="frm_registrar">
			<form method="post" action="back/b_uprov.php?ic=<?php echo $idc ?>">

				
				<label>Nombre</label>
                <br>
    			<input name="nombreprov" type="text" class="iwi" placeholder="Nombre de cliente" value = "<?php echo $nombreprov?>" required>
                <br><br>
				

    			<label>Representante</label>
                <br>
    			<input name="representante"type="text" class="iwi" placeholder="RNC de cliente" value = "<?php echo $representante?>"  required>
				<br><br>
				
				<label>Telefono</label>
                <br>
    			<input name="telefono" type="text" class="iwi" placeholder="Direccion de cliente" value = "<?php echo $telefono?>"  required>
                <br><br>
    			<label>Pais</label>
                <br>
    			<input name="pais" type="text" class="iwi" value = "<?php echo $pais?>"  required>

    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" value="Editar">

		
		  	</form>






        </div>
    	</div>
</body>
</html>