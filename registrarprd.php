<?php 

  include 'links/session.php';
  include 'links/registrarclientelinks.php';
  if (!empty($_POST)) {
      
  

        include 'back/conexion.php';
        $desc = $_POST["descripcion"];
        $precio = $_POST["precio"];
        $existencia = $_POST["existencia"];
        $prov = $_POST["proveedor"];

        $query = "INSERT INTO producto (`idprod`, `descripcion`, `precio`, `existencia`, `idproveedor`) VALUES (NULL, '$desc', '$precio', '$existencia', '$prov');";

             $insert = mysqli_query($con, $query);
             $aviso = "<p class='av_good'>Producto registrado correctamente</p>";

       

      
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
    <h1 class="black down"><a class="black" href="productos.php">Productos</a> ></h1>
    <h4 class="downr2">nuevo producto</h4>
    	<!--div form-->
    <div class="downp">
        <div class="mensaje" align="center"><?php if (!empty($_POST)) {echo $aviso;}?></div>
    	<div class="frm_registrar">
			<form method="post" action="registrarprd.php">

				
				<label>Descripcion</label>
                <br>
    			<input name="descripcion" type="text" class="iwi" placeholder="Descripcion de producto" required>
                <br><br>
				

    			<label>Precio</label>
                <br>
    			<input name="precio"type="text" class="iwi" placeholder="Precio de producto" required>
				<br><br>
				
				<label>Existencia</label>
                <br>
    			<input name="existencia" type="text" class="iwi" placeholder="Existencia de producto" required>
                <br><br>
    			<label>Proveedor</label>
                <br>
    			  <select name="proveedor"style="width: 200px;">

                <?php 

                        include_once 'back/conexion.php';
                        $query = mysqli_query($con,"select idproveedor,nombreprov from proveedor where activo = 'si';");
                        while ($row = mysqli_fetch_array($query)) {
                           $nombre = $row['nombreprov'];
                            $idprov = $row['idproveedor'];
                            echo "<option value='$idprov'>$nombre</option>";
                        }



                ?>  
                </select>       
    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" >

		
		  	</form>






        </div>
    	</div>
</body>
</html>