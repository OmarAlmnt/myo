<?php 

  include 'links/session.php';
  include 'links/u_clientelinks.php';
  include 'back/filluc.php';
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
    <h1 class="black down"><a class="black" href="clientes.php">Clientes</a> ></h1>
    <h4 class="downr">editar cliente</h4>
    	<!--div form-->
    <div class="downp">
    	<div class="frm_registrar">
			<form method="post" action="back/b_ucliente.php?ic=<?php echo $idc ?>">

				
				<label>Nombre</label>
                <br>
    			<input name="nombre" type="text" class="iwi" placeholder="Nombre de cliente" value = "<?php echo $nombre?>" required>
                <br><br>
				

    			<label>RNC</label>
                <br>
    			<input name="RNC"type="text" class="iwi" placeholder="RNC de cliente" value = "<?php echo $RNC?>"  required>
				<br><br>
				
				<label>Direccion</label>
                <br>
    			<input name="direccion" type="option" class="iwi" placeholder="Direccion de cliente" value = "<?php echo $dir?>"  required>
                <br><br>
                
                <label>Telefono</label>
                <br>
                <input name="telefono" type="option" class="iwi" placeholder="Telefono de cliente" value = "<?php echo $telefono?>"  required>
                <br><br>

    			<label>fecha de entrada</label>
                <br>
    			<input name="fecha_entrada" placeholdet="" type="date" class="iwi" value = "<?php echo $fecha_e?>"  required>

    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" value="Editar">

		
		  	</form>






        </div>
    	</div>
</body>
</html>