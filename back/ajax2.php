<?php 
include 'conexion.php';

if (!empty($_POST)) {
if ($_POST['action'] == 'anularfactura') {
 		session_start();
		
		$numerof = $_POST['nofac'];
		if (!empty($numerof)) {
		 $qnull = "CALL anular_factura($numerof);";

		 $eqnull = mysqli_query($con,$qnull);
		 echo "si";
		}else{

			echo "error";
		}

		

}
		



if ($_POST['action'] == 'anularventa') {
 		session_start();
		$token = md5($_SESSION['idusuario']);

		$qdel = "DELETE FROM detalle_venta_temp WHERE token_user = '$token'";

		$eqdel = mysqli_query($con,$qdel);

		if ($eqdel) {
			echo "OK";
		}else{
			echo "error";
		}

 		
 	}

if ($_POST['action'] == 'procesarventa') {
 		session_start();
		if (empty($_POST['codcliente'])) {
			$codcliente = 53;
		} else{


			$codcliente = $_POST['codcliente'];
		}

		$token = md5($_SESSION['idusuario']);
		$idusuario = $_SESSION['idusuario'];

		$query = mysqli_query($con,"SELECT * FROM detalle_venta_temp WHERE token_user = '$token'");
		$result = mysqli_num_rows($query);

		if ($result > 0) {
			$queryprocesar = mysqli_query($con,"CALL procesar_venta($idusuario,$codcliente,'$token');");
			$result_proc = mysqli_num_rows($queryprocesar);
			if ($result_proc > 0) {
				$data = mysqli_fetch_assoc($queryprocesar);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
		}



 		
 	}

 if ($_POST['action'] == 'addproductodetalle') {
 	
	if (empty($_POST['producto']) || empty($_POST['cantidad'])) {
		echo "error";
    }else{

		session_start();

		$idprod = $_POST['producto'];
		$cantidad = $_POST['cantidad'];
		$token = md5($_SESSION['idusuario']);
		
		$qitbis = "SELECT itbis FROM configuracion";
		$exqitbis = mysqli_query($con,$qitbis);
		$citbis = mysqli_num_rows($exqitbis);

		$qsp = "CALL add_detalle_venta_temp($idprod,$cantidad,'$token');";
		$eqpc = mysqli_query($con,$qsp);
		$cqsp = mysqli_num_rows($eqpc);

		$detalletabla = '';
		$sub_total = 0;
		$itbis = 0;
		$total = 0;

		if ($cqsp > 0) {
			
			if ($citbis > 0) {
				$info_itbis = mysqli_fetch_assoc($exqitbis);
				$itbis = $info_itbis['itbis'];


			}
			while ($data = mysqli_fetch_assoc($eqpc)) {
				$preciototal = round($data['cantidad_venta'] * $data['precio_venta'],2);
				$sub_total = round($sub_total + $preciototal,2);


				$detalletabla .=' 
								
								<tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					           <tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					          <tr>
                      			<td>idproducto</td>
                      			<td>Descripcion</td>
                      			<td>Cantidad</td>
                      			<td>Precio</td>
                      			<td>Total</td>
                      			<td>Accion</td>
          						</tr>
					          <tr>
					            <td>'.$data["idprod"].'</td>
					            <td>'.$data["descripcion"].'</td>
					            <td>'.$data["cantidad_venta"].'</td>
					            <td>'.$data["precio_venta"].'</td>
					            <td>'.$preciototal.'</td>
					            <td><a class="deletep" href="#" onclick="event.preventDefault(); delproductdet('.$data["iddet"].')"><i class="fas fa-trash-alt"></i></a></td>
					          </tr>
					          ';

			}
			$impuesto = round($sub_total * ($itbis / 100),2);
			$ttsi  = round($sub_total,2);
			$totall = round($sub_total + $impuesto,2);

			$detalletotales = ' 
		 						<tr>
            						<td colspan="5" class="textright">&nbsp;</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright" class="textright">subtotal</td>
            						<td class="textright">'.$ttsi.'</td>
         						 </tr>
          						<tr>
            						<td colspan="5" class="textright">itbis</td>
            						<td class="textright">'.$impuesto.'</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright">total</td>
            						<td class="textright">'.$totall.'</td>
          						</tr>';



				$arrayData = array();
				$arrayData['detalle'] = $detalletabla;
				$arrayData['totales'] = $detalletotales;
				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

			}else{

				echo "error";
			}
			mysqli_close($con);

        }

 	}
 	if ($_POST['action'] == 'delproductodetalle') {
 	
	if (empty($_POST['id_detalle'])) {
		echo "error";
    }else{
		session_start();

		$iddetalle = $_POST['id_detalle'];
		$token = md5($_SESSION['idusuario']);
		
		$qitbis = "SELECT itbis FROM configuracion";
		$exqitbis = mysqli_query($con,$qitbis);
		$citbis = mysqli_num_rows($exqitbis);

		$qsp = "CALL del_detalle_temp($iddetalle,'$token');";
		$eqsp = mysqli_query($con,$qsp);
		$cqsp = mysqli_num_rows($eqsp);

		$detalletabla = '';
		$sub_total = 0;
		$itbis = 0;
		$total = 0;

			
			if ($citbis > 0) {
				$info_itbis = mysqli_fetch_assoc($exqitbis);
				$itbis = $info_itbis['itbis'];


			}
			while ($data = mysqli_fetch_assoc($eqsp)) {
				$preciototal = round($data['cantidad_venta'] * $data['precio_venta'],2);
				$sub_total = round($sub_total + $preciototal,2);


				$detalletabla .=' 
								
								<tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					           <tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					          <tr>
                      			<td>idproducto</td>
                      			<td>Descripcion</td>
                      			<td>Cantidad</td>
                      			<td>Precio</td>
                      			<td>Total</td>
                      			<td>Accion</td>
          						</tr>
					          <tr>
					            <td>'.$data["idprod"].'</td>
					            <td>'.$data["descripcion"].'</td>
					            <td>'.$data["cantidad_venta"].'</td>
					            <td>'.$data["precio_venta"].'</td>
					            <td>'.$preciototal.'</td>
					            <td><a class="deletep" href="#" onclick="event.preventDefault(); delproductdet('.$data["iddet"].')"><i class="fas fa-trash-alt"></i></a></td>
					          </tr>
					          ';

			}
			$impuesto = round($sub_total * ($itbis / 100),2);
			$ttsi  = round($sub_total,2);
			$totall = round($sub_total + $impuesto,2);

			$detalletotales = ' 
		 						<tr>
            						<td colspan="5" class="textright">&nbsp;</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright" class="textright">subtotal</td>
            						<td class="textright">'.$ttsi.'</td>
         						 </tr>
          						<tr>
            						<td colspan="5" class="textright">itbis</td>
            						<td class="textright">'.$impuesto.'</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright">total</td>
            						<td class="textright">'.$totall.'</td>
          						</tr>';



				$arrayData = array();
				$arrayData['detalle'] = $detalletabla;
				$arrayData['totales'] = $detalletotales;
				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

			
			mysqli_close($con);

        }

 	}

 	if ($_POST['action'] == 'searchfordet') {
 	
	if (empty($_POST['user'])) {
		echo "error";
    }else{

		session_start();

	
		$token = md5($_SESSION['idusuario']);

		$queryf = "SELECT tmp.iddet, tmp.token_user,tmp.cantidad_venta,tmp.precio_venta,p.idprod,p.descripcion FROM detalle_venta_temp tmp INNER JOIN producto p ON tmp.idprod = p.idprod WHERE token_user = '$token'";

		$equeryf = mysqli_query($con,$queryf);
		$cqsp = mysqli_num_rows($equeryf);
		$qitbis = "SELECT itbis FROM configuracion";
		$exqitbis = mysqli_query($con,$qitbis);
		$citbis = mysqli_num_rows($exqitbis);

		
		$detalletabla = '';
		$sub_total = 0;
		$itbis = 0;
		$total = 0;

		if ($cqsp > 0) {
			
			if ($citbis > 0) {
				$info_itbis = mysqli_fetch_assoc($exqitbis);
				$itbis = $info_itbis['itbis'];


			}
			while ($data = mysqli_fetch_assoc($equeryf)) {
				$preciototal = round($data['cantidad_venta'] * $data['precio_venta'],2);
				$sub_total = round($sub_total + $preciototal,2);


				$detalletabla .=' 
								
								<tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					           <tr>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					            <td>&nbsp;</td>
					          </tr>
					          <tr>
                      			<td>idproducto</td>
                      			<td>Descripcion</td>
                      			<td>Cantidad</td>
                      			<td>Precio</td>
                      			<td>Total</td>
                      			<td>Accion</td>
          						</tr>
					          <tr>
					            <td>'.$data["idprod"].'</td>
					            <td>'.$data["descripcion"].'</td>
					            <td>'.$data["cantidad_venta"].'</td>
					            <td>'.$data["precio_venta"].'</td>
					            <td>'.$preciototal.'</td>
					            <td><a class="deletep" href="#" onclick="event.preventDefault(); delproductdet('.$data["iddet"].')"><i class="fas fa-trash-alt"></i></a></td>
					          </tr>
					          ';

			}
			$impuesto = round($sub_total * ($itbis / 100),2);
			$ttsi  = round($sub_total,2);
			$totall = round($sub_total + $impuesto,2);

			$detalletotales = ' 
		 						<tr>
            						<td colspan="5" class="textright">&nbsp;</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright" class="textright">subtotal</td>
            						<td class="textright">'.$ttsi.'</td>
         						 </tr>
          						<tr>
            						<td colspan="5" class="textright">itbis</td>
            						<td class="textright">'.$impuesto.'</td>
          						</tr>
          						<tr>
            						<td colspan="5" class="textright">total</td>
            						<td class="textright">'.$totall.'</td>
          						</tr>';



				$arrayData = array();
				$arrayData['detalle'] = $detalletabla;
				$arrayData['totales'] = $detalletotales;
				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

			}else{

				echo "error";
			}
			mysqli_close($con);

        }

 	}



}

?>