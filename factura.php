<?php 

  include 'links/session.php';
  include 'links/facturalinks.php';
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
    	<h1 class="down">Facturaci&oacute;n</h1>
    	<!--div form-->

    	<div class="downp">
        <div class="frms_venta frm_cliente">
          <form name="clienteventa" class="datos" id="clienteventa">
            <label><b>Datos de cliente</b></label><br><br>
            <input type="hidden" name="idcliente" id="idcliente">
            <div>
                  <label>RNC</label>
                  <input class="inpidcli" id="RNC" type="text" name="RNC" maxlength="9">
              </div>
              <div class="rnc">
                  <label>Telefono</label>
                  <input class="inprnc" id="telefonoc" type="text" name="telefonoc" disabled required>
              </div>
              <div class="nmcli">
                  <label>Nombre cliente </label>
                  <input type="" class="inpnmcli" id="nombrec" name="nombrec" disabled required>
                    <br><br>
              </div>
              <div class="w100 dricli">
                  <label>Direccion</label>
                  <input type="text" name="direccionc" id="direccionc" disabled required>
                  <br><br>
              </div>
              <div>
                  <button class="btn_save">Guardar</button>
              </div>


          </form>
        </div>
          <div class="vendedordiv">
            
            <h4>Vendedor:</h4><h4 class="btnr">Acciones</h4>
            <p><br><br> <?php echo $fn;?></p><p class="btnr2"><a id="procesarventa"  class="btn btn-2 btnok btnsmall"><i class="fas fa-clipboard-check" href="#"></i> Procesar</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-2 btncancel btnsmall" id="anularventa" href="#"><i class="fas fa-ban"></i> Anular</a></p>
            



          </div>

      </div>
      <div class="tableproductsdiv">
      <table class="tbl_products" id="tbl_add">
      <thead>
          <tr>
              <th>idproducto</th>
              <th>descripcion</th>
              <th>Existencia</th>
              <th>cantidad</th>
              <th>precio</th>
              <th>total</th>
              <th>Accion</th>
          </tr>
           <tr>      
            <td><input id="idproductop" type="text" name="idproducto"></td>
            <td id="descripcionp">-</td>
            <td id="existenciap">0</td>
            <td><input id="cantidadp" type="text" name="cantidadprod" min="1" disabled></td>
            <td id="preciop">0.00</td>
            <td id="totalp">0.00</td>
            <td><a href="#"id="btn_addp" class="btn_ap bn">Agregar</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            
            <td class="h1d"><h1>Detalles de Factura</h1></td>


          </tr>


        </thead>
        <tbody id='det_p'>
          <!--CONTENIDO AJAX-->
         
        </tbody>
        <tfoot id='detalle_totales'>
         <!--CONTENIDO AJAX-->
          
        </tfoot>


      </table>      
    
    



      </div>

   





    </div>
       
  
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/funciones2.js"></script>

<script type="text/javascript">
  
  $(document).ready(function() {
    
      var usuarioid = <?php echo $_SESSION['idusuario'] ?>

      searchfordet(usuarioid);



  }); 
</script>

</body>
</html>