<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Ventas.xls');
include 'conexion.php';
?>

    	    	<table>
    		
			<tr>
				<th>No.</th>
				<th>Fecha / Hora</th>
				<th>Cliente</th>
				<th>Vendedor</th>
				<th>Estado</th>
				<th>Total_factura</th>
			</tr>
			<?php



			//paginas
			
			
				$q = "SELECT f.nofactura,f.fecha_hora,f.total_factura,f.idcliente,f.activo,u.fullname AS vendedor,cl.nombre AS cliente FROM factura f INNER JOIN usuario u ON f.idusuario = u.idusuario INNER JOIN cliente cl ON f.idcliente = cl.idcliente ORDER BY f.fecha_hora DESC";




			
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


			</tr>
					







			<?php




		    	}
			}


			?>




    	</table>
    	
    	




