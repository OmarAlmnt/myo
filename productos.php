<?php

include 'links/session.php';
include 'links/prdlinks.php';
include 'back/conexion.php';



?>
<!DOCTYPE html>
<html>
<head>

	<title>MYO</title>
</head>
<body>



	
	<div class="wrapper">
    
    <?php
    include 'links/sidebar.php'; 
    ?>
    <?php
    	include 'links/modal.php';
    ?>


    <div class="main_content">

    	<div class="down"><h1>Productos </h1></div>
    	

	<div class="divtab">
	<section class="downp" id="container">
    	<table>
    		
			<tr>
				<th>ID</th>
				<th>Descripcion</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Proveedor</th>
				<th>Acciones</th>
			</tr>
			<?php



			//paginas
			if (empty($_REQUEST["busqueda"])) {
			$q2 = "SELECT COUNT(*) as total_reg FROM producto where activo = 'si'";

			}else{
			$busqueda = $_REQUEST["busqueda"];


			$q2 = "SELECT COUNT(*) as total_reg FROM producto p join proveedor pv on p.idproveedor = pv.idproveedor  where p.idprod LIKE '%$busqueda%' OR p.descripcion LIKE '%$busqueda%' OR p.precio LIKE '%$busqueda%' OR p.existencia LIKE '%$busqueda%' OR pv.nombreprov LIKE '%%busqueda%' AND p.activo = 'si'";

			}
			$sq_reg = mysqli_query($con,$q2);
			$r_reg = mysqli_fetch_array($sq_reg);
			$total_reg = $r_reg['total_reg'];
			$ppg = 9;
			if (empty($_GET['npg'])) {
				$npg = 1;
			} else {

				$npg = $_GET['npg'];

			}

			$desde = ($npg - 1) *  $ppg;

			$ttp = ceil($total_reg / $ppg);










			if (empty($_REQUEST["busqueda"])) {


				$q = "SELECT p.idprod,p.descripcion,p.precio,p.existencia,pv.nombreprov FROM producto p join proveedor pv on p.idproveedor = pv.idproveedor where p.activo = 'si' LIMIT $desde,$ppg";

			} else{
				
				$q = "SELECT p.idprod,p.descripcion,p.precio,p.existencia,pv.nombreprov FROM producto p join proveedor pv on p.idproveedor = pv.idproveedor where p.idprod LIKE '%$busqueda%' OR p.descripcion LIKE '%$busqueda%' OR p.precio LIKE '%$busqueda%' OR p.existencia LIKE '%$busqueda%' OR pv.nombreprov LIKE '%%busqueda%' AND p.activo = 'si'";





			}
			$e = mysqli_query($con,$q);
			$contador = mysqli_num_rows($e); 

			if ($contador > 0) {
				while ($datos = mysqli_fetch_array($e)) {
					
			?>

			<tr class="row<?php echo $datos['idprod']; ?>">
				<td><?php echo $datos['idprod']; ?> </td>
				<td><?php echo $datos['descripcion']; ?> </td>
				<td><?php echo $datos['precio']; ?> </td>
				<td class="celex"><?php echo $datos['existencia']; ?> </td>
				<td><?php echo $datos['nombreprov']; ?> </td>
				<td>
					<a href="#" class="addp" producto="<?php echo $datos['idprod']; ?>" id="b_add"><i class="fas fa-plus"></i>Agregar</a>

					| <a href="u_prd.php?id=<?php echo $datos['idprod']; ?>" id="b_edit"><i class="fas fa-edit"></i>Editar</a>

					 | <a href="d_prd.php?id=<?php echo $datos['idprod']; ?>" id="b_delete"><i class="fas fa-trash"></i>Borrar</a>
				</td>


			</tr>
					







			<?php




		    	}
			}


			?>




    	</table>
    	
    	
    </section><!--downpdiv-->

	</div><!--Divsec-->
	<div class="paginas">
	<div class="wd">
	<form action="back/robproducto.php" method="get" class="down">
    <input type="text" name="busqueda" value="<?php if(!empty($busqueda)){echo $busqueda;} ?>">
    <input type="submit" name = "buscar" value="buscar" class="botw btn btn-2 ">
    <input type="submit" name="reiniciar" value="reiniciar" class="botw btn btn-2">
    </form>
	</div>


	 	
		<ul>
			<?php
			if ($npg != 1) {
				if (!empty($busqueda)) {
				
				
				

			?>	
			<li><a href="?npg=<?php  echo $npg - 1?>&busqueda=<?php echo $busqueda ?>"> < </a></li>

			<?php
			    }else{

			 
			 ?>
			 <li><a href="?npg=<?php  echo $npg - 1?>"> < </a></li>



			<?php 
			}
			}

			for ($i=1; $i <= $ttp ; $i++) { 

				if ($i == $npg) {
				 echo '<li class="seleccion">'.$i.'</li>';
				}else{
				if (empty($busqueda)) {
					echo '<li><a href="?npg='.$i.'">'.$i.'</a></li>';
				} else{
					echo '<li><a href="?npg='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';

				}
				
			}
			}


			?>
			
	
			<?php 
			if ($npg != $ttp) {
				if (!empty($busqueda)) {
				
				
				

			?>	
			<li><a href="?npg=<?php  echo $npg + 1?>&busqueda=<?php echo $busqueda ?>"> > </a></li>

			<?php
			    }else{

			 
			 ?>
			 <li><a href="?npg=<?php  echo $npg + 1?>"> > </a></li>



			<?php 
			}
			}
			 ?>

		</ul>


	</div>





	<div class="bar_btn">

 

    <button class="bot3 btn btn-2" onclick="window.location.href = 'registrarprd.php';" ><i class="fas fa-plus"></i>  Nuevo Producto </button>


    <button class="bot3 btn btn-2" onclick="window.location.href = 'back/exportprod.php';" ><i class="fas fa-file-excel"></i>  Exportar a Excel </button>


    </div><!--divbotones-->

    		
			















      </div>

   





    </div>
       
  
</div>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</body>
</html>