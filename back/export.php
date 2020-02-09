<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Clientes.xls');
include 'conexion.php';
?>

    	<table>
    		
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>RNC</th>
				<th>Direccion</th>
				<th>Fecha ingreso</th>
			</tr>
			<?php





			$q = "SELECT idcliente,nombre,RNC,direccion,fecha_entrada FROM cliente where activo = 'si'";
			$e = mysqli_query($con,$q);
			$contador = mysqli_num_rows($e); 

			if ($contador > 0) {
				while ($datos = mysqli_fetch_array($e)) {
					
			?>

			<tr>
				<td><?php echo $datos['idcliente']; ?> </td>
				<td><?php echo $datos['nombre']; ?> </td>
				<td><?php echo $datos['RNC']; ?> </td>
				<td><?php echo $datos['direccion']; ?> </td>
				<td><?php echo $datos['fecha_entrada']; ?> </td>
				

			</tr>
					







			<?php




		    	}
			}


			?>




    	</table>
    	




