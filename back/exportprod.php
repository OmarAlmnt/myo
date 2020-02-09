<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Productos.xls');
include 'conexion.php';
?>
	<table>
    		
			<tr>
				<th>ID</th>
				<th>Descripcion</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Proveedor</th>
			</tr>
			<?php



				$q = "SELECT p.idprod,p.descripcion,p.precio,p.existencia,pv.nombreprov FROM producto p join proveedor pv on p.idproveedor = pv.idproveedor where p.activo = 'si'";

				

			$e = mysqli_query($con,$q);
			$contador = mysqli_num_rows($e); 

			if ($contador > 0) {
				while ($datos = mysqli_fetch_array($e)) {
					
			?>

			<tr>
				<td><?php echo $datos['idprod']; ?> </td>
				<td><?php echo $datos['descripcion']; ?> </td>
				<td><?php echo $datos['precio']; ?> </td>
				<td><?php echo $datos['existencia']; ?> </td>
				<td><?php echo $datos['nombreprov']; ?> </td>

			</tr>
					







			<?php




		    	}
			}


			?>




    	</table>
    	
    	