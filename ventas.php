<?php

include 'links/session.php';
include 'links/clienteslinks.php';
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

    <div class="main_content">
    	<h1 class="down">Ventas </h1>
    	

	<div class="divtab">
	<section class="downp" id="container">
    	<table>
    		
			<tr>
				<th>No.</th>
				<th>Fecha / Hora</th>
				<th>Cliente</th>
				<th>Vendedor</th>
				<th>Estado</th>
				<th>Total_factura</th>
				<th>Acciones</th>
			</tr>
			<?php



			//paginas
			if (empty($_REQUEST["busqueda"])) {
			$q2 = "SELECT COUNT(*) as total_reg FROM factura";

			}else{
			$busqueda = $_REQUEST["busqueda"];


			$q2 = "SELECT COUNT(*) as total_reg FROM factura where nofactura = $busqueda";

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


				$q = "SELECT f.nofactura,f.fecha_hora,f.total_factura,f.idcliente,f.activo,u.fullname AS vendedor,cl.nombre AS cliente FROM factura f INNER JOIN usuario u ON f.idusuario = u.idusuario INNER JOIN cliente cl ON f.idcliente = cl.idcliente  ORDER BY f.fecha_hora DESC LIMIT $desde,$ppg";

			} else{
				
				$q = "SELECT f.nofactura,f.fecha_hora,f.total_factura,f.idcliente,f.activo,u.fullname AS vendedor,cl.nombre AS cliente FROM factura f INNER JOIN usuario u ON f.idusuario = u.idusuario INNER JOIN cliente cl ON f.idcliente = cl.idcliente where f.nofactura = '$busqueda' ORDER BY f.fecha_hora DESC LIMIT $desde,$ppg";




			}
			$e = mysqli_query($con,$q);
			$contador = mysqli_num_rows($e); 

			if ($contador > 0) {
				while ($datos = mysqli_fetch_array($e)) {

					if ($datos['activo'] == 'si') {
						$estado = "<span class='pagada btnsmall2 btngood'>Saldada</span>";
					}else{

						$estado = "<span class='anulada btncancel2 btnsmall2'>Anulada</span>";
					}
					
			?>

			<tr id="row_<?php echo $datos['nofactura']; ?>">
				<td><?php echo $datos['nofactura']; ?> </td>
				<td><?php echo $datos['fecha_hora']; ?> </td>
				<td><?php echo $datos['cliente']; ?> </td>
				<td><?php echo $datos['vendedor']; ?> </td>
				<td><?php echo $estado ?> </td>
				<td><?php echo $datos['total_factura']; ?> </td>
				<td><a href="#" class="btnop verpdf" cl="<?php echo $datos['idcliente'];?>" f="<?php echo $datos['nofactura']; ?>">&nbsp;<i class="fas fa-eye"></i>&nbsp;</a>
				 |   <a href="#" f="<?php echo $datos['nofactura']; ?>" class="btnnull anularfac" id="b_delete">&nbsp;<i class="fas fa-ban" disabled></i>&nbsp;</a>
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
	<form action="back/robventas.php" method="get" class="down">
    <input type="text" name="busqueda" value="<?php if(!empty($busqueda)){echo $busqueda;} ?>">
    <input type="submit" name = "buscar" value="buscar por no" class="botw btn btn-2 ">
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

    <button class="bot bot1 btn btn-2" onclick="window.location.href = 'chart_venta.php?year=2019';"><i class='fas fa-chart-bar'></i>  Ver estadisticas </button>

    <button class="bot bot2 btn btn-2" onclick="window.location.href = 'factura.php';" ><i class="fas fa-plus"></i>  Nueva venta </button>


    <button class="bot bot2 btn btn-2" onclick="window.location.href = 'back/exportventa.php';" ><i class="fas fa-file-excel"></i>  Exportar a Excel </button>


    </div><!--divbotones-->

    		
			





      </div>

   





    </div>
       
  
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/funciones2.js"></script>
</body>
</html>