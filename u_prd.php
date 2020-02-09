<?php 

  include 'links/session.php';
  include 'links/u_clientelinks.php';
  include 'back/filluprd.php';
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
    <h1 class="black down"><a class="black" href="productos.php">Productos</a> ></h1>
    <h4 class="downr3">editar producto</h4>
    	<!--div form-->
    <div class="downp">
    	<div class="frm_registrar">
			<form method="post" action="back/b_uprd.php?ic=<?php echo $idc ?>">

				
				<label>Descripcion</label>
                <br>
    			<input name="descripcion" type="text" class="iwi" placeholder="Nombre de cliente" value = "<?php echo $descripcion?>" required>
                <br><br>
				

    			<label>Precio</label>
                <br>
    			<input name="precio"type="text" class="iwi" placeholder="RNC de cliente" value = "<?php echo $precio?>"  required>
				<br><br>
				
				<label>Existencia</label>
                <br>
    			<input name="existencia" type="text" class="iwi" placeholder="Direccion de cliente" value = "<?php echo $existencia?>"  required>
                <br><br>
    			<label>Proveedor</label>
                <br>
    			<select name="idproveedor"style="width: 200px;">

                <?php 

                        include_once 'back/conexion.php';
                        $query = mysqli_query($con,"select idproveedor,nombreprov from proveedor where activo = 'si';");
                        while ($row = mysqli_fetch_array($query)) {
                           $nombre = $row['nombreprov'];
                            $idprov = $row['idproveedor'];
                            if ($idprov == $proveedor) {

                                echo "<option value='$idprov' selected>$nombre</option>";
                            }else{
                            echo "<option value='$idprov'>$nombre</option>";
                            }

                        }



                ?>  
                </select>    
    			<br><br>

    			
				
				
					
    			<input type="submit" class="iwi btn btn-2" value="Editar">

		
		  	</form>






        </div>
    	</div>
</body>
</html>