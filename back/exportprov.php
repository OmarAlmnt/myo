<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Proveedores.xls');
include 'conexion.php';
?>
<table>
    		
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Representante</th>
				<th>Telefono</th>
				<th>Pais</th>
				<th>Acciones</th>
			</tr>
			<?php


		


				$q = "SELECT idproveedor,nombreprov,representante,telefono,pais FROM proveedor where activo = 'si'";

		
			$e = mysqli_query($con,$q);
			$contador = mysqli_num_rows($e); 

			if ($contador > 0) {
				while ($datos = mysqli_fetch_array($e)) {
					
			?>

			<tr>
				<td><?php echo $datos['idproveedor']; ?> </td>
				<td><?php echo $datos['nombreprov']; ?> </td>
				<td><?php echo $datos['representante']; ?> </td>
				<td><?php echo $datos['telefono']; ?> </td>
				<td><?php echo $datos['pais']; ?> </td>


			</tr>
					







			<?php




		    	}
			}


			?>




    	</table>
    	

