<?php 
 include 'conexion.php';
 //print_r($_POST);exit;

 if (!empty($_POST)) {
 	//fill
 	if ($_POST['action'] == 'infprod') {
 		$idprod = $_POST['producto'];
 		$qp = "select idprod,descripcion from producto where idprod = $idprod";
 		$exqp = mysqli_query($con,$qp);
 		mysqli_close($con);

 		$conta2r = mysqli_num_rows($exqp);

 		if ($conta2r > 0) {
 			$data = mysqli_fetch_assoc($exqp);
 			echo json_encode($data,JSON_UNESCAPED_UNICODE);
 			exit;
 
 		}
 		echo "error";
 	}
 	if ($_POST['action'] == 'agp') {
 		
 		if (!empty($_POST["cantidad"])) {

 			$cantidad = $_POST["cantidad"];
 			$idp = $_POST["idproducto"];

 			$upt = "UPDATE producto SET existencia = existencia + $cantidad WHERE idprod = $idp";
 			$exeupt = mysqli_query($con,$upt);
 			$supt = "SELECT idprod,existencia as new_cantidad from producto where idprod = $idp;";
 			$exsupt = mysqli_query($con,$supt);
 			$countupt = mysqli_num_rows($exsupt);
 			if ($countupt > 0) {
 				$data = mysqli_fetch_assoc($exsupt);
 				echo json_encode($data,JSON_UNESCAPED_UNICODE);
 			}
 			

 		} else{

 			echo "error";
 		}
 		exit;

 	}
 

	if ($_POST['action'] == 'searchcli'){

 if (!empty($_POST['cliente'])) {
 	$RNC = $_POST['cliente'];
 	$scli = "SELECT * FROM cliente WHERE RNC LIKE '$RNC' and activo = 'si'";
 	$escli = mysqli_query($con,$scli);
 	$result = mysqli_num_rows($escli);
 	$data = '';
 	if ($result > 0) {
 		$data = mysqli_fetch_assoc($escli);
 	} else{

 		$data = 0;
 	}

 }else{

 	echo "error";
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE);
} 

	if ($_POST['action'] == 'searchprod'){

 	$idproducto = $_POST['producto'];
 	$sprod = "SELECT * FROM producto WHERE idprod = $idproducto and activo = 'si'";
 	$esprod = mysqli_query($con,$sprod);
 	$result = mysqli_num_rows($esprod);
 	if ($result > 0) {
 		$data = mysqli_fetch_assoc($esprod);
 		echo json_encode($data,JSON_UNESCAPED_UNICODE);
 		exit;
 	}
 	echo "error";
 		exit;
 	}

 	


}


 ?>