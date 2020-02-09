<?php 

  include 'links/session.php';
  include 'links/d_clientelinks.php';
  include 'back/conexion.php';

 ?>

<?php
    if (empty($_GET["id"])) {
      

    header("location:./productos.php");

    }
    $id = $_GET["id"]; 
    $cons = "SELECT p.descripcion,p.existencia,pv.nombreprov FROM producto p JOIN proveedor pv ON p.idproveedor = pv.idproveedor WHERE idprod = $id";
    $ejec = mysqli_query($con,$cons);
    $rs = mysqli_fetch_array($ejec);

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
    <h4 class="downr3">eliminar producto</h4>
    	<!--div form-->
    <div class="downp">
        <div class="conf">

          <h3 align="center">¿Seguro de que desea eliminar el producto?</h3><br><br>
          <h4 align="center">Descripcion: <?php echo $rs["descripcion"]; ?></h4><br>
          <h4 align="center">Existencia: <?php echo $rs["existencia"]; ?></h4><br>
          <h4 align="center">Proveedor: <?php echo $rs["nombreprov"]; ?></h4>

    
          <button class="bot bot2 btn btn-2" onclick="window.location.href = 'productos.php';" ><i class="fas fa-times"></i>  cancelar </button>


          <button class="bot bot2 btn btn-2" onclick="window.location.href = 'back/b_dprd.php?id=<?php echo $id ?>';" ><i class="fas fa-check"></i>  confirmar </button>

        </div>
    </div>
			





        </div>
    	</div>
</body>
</html>