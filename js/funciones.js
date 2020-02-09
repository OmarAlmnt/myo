//MODAL PRODUCTOS
	$('.addp').click(function(e) {


		e.preventDefault();
		var producto = $(this).attr('producto');

		var action = 'infprod';
		

		$.ajax({
			url: './back/ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,producto:producto},
		

			success: function(response){
			  console.log(response);
			  if (response != 'error') {
			  	var info = JSON.parse(response);
			  	console.log(info);
			  	$('#idproducto').val(info.idprod);
			  	$('.namep').html(info.descripcion);
			  }


			}, 

			error: function(error) {
	        console.log(error);

	        }

	        });




		

		$('.modal').fadeIn() 




	});


function closemodal(){

	$('.cnt').val('');
	$('.modal').fadeOut();

}

function sendproduct(){


		$.ajax({
			url: './back/ajax.php',
			type: 'POST',
			async: true,
			data: $('#aumentarp').serialize(),
		

			success: function(response){
			
			var info = JSON.parse(response);

			$('.row'+info.idprod+' .celex').html(info.new_cantidad);

			 

			}, 

			error: function(error) {
	        console.log(error);

	        }

	        });

			$('.cnt').val('');




}

function delproductdet(iddet){

	var action = 'delproductodetalle';
	var id_detalle = iddet;
	$.ajax({
				  url: './back/ajax2.php',
				  type: 'POST',
				  async: true,
				  data: {action:action,id_detalle:id_detalle},
		

				  success: function(response){
			        console.log(response);
			        if (response != 'error') {
			        	
			        	var info3 = JSON.parse(response);
			        	console.log(info3);
			        	$('.h1d').fadeIn();
			        	$('#det_p').html(info3.detalle);
			        	$('#detalle_totales').html(info3.totales);
			        
			        	
					}
			       
				  }, 

				  error: function(error) {
	    		     console.log(error);


	     		    }

	   		   });
}

function searchfordet(id){

		var action = 'searchfordet';
		var user = id;

		$.ajax({
				  url: './back/ajax2.php',
				  type: 'POST',
				  async: true,
				  data: {action:action,user:user},
		

				  success: function(response){
			        console.log(response);
			         if (response != 'error') {
			        	var info3 = JSON.parse(response);
			        	console.log(info3);
			        
			        	$('.h1d').fadeIn();
			        	$('#det_p').html(info3.detalle);
			        	$('#detalle_totales').html(info3.totales);

			        }
			       
				  }, 

				  error: function(error) {
	    		     console.log(error);


	     		    }

	   		   });



}
//BUSCAR CLIENTE
$(document).ready(function() {
	

		$('#RNC').keyup(function(e) {
			e.preventDefault();

			var cl = $(this).val();
			var action = 'searchcli';
		if (cl != '') {


			$.ajax({
				url: './back/ajax.php',
				type: 'POST',
				async: true,
				data: {action:action,cliente:cl},
		

				success: function(response){
			      console.log(response);

			      if (response != 0) {
			      	var datos = JSON.parse(response);
			      	$('#idcliente').val(datos.idcliente);
			      	$('#nombrec').val(datos.nombre);
			        $('#direccionc').val(datos.direccion);
			        $('#telefonoc').val(datos.telefono);







			      }else{

			      	$('#idcliente').val('');
			      	$('#nombrec').val('');
			        $('#direccionc').val('');
			        $('#telefonoc').val('');
			      }
		

				}, 

				error: function(error) {
	    		   console.log(error);

	     		  }

	   		 });
		}
	

		});

		$('#idproductop').keyup(function(e) {
			e.preventDefault();

			var producto = $(this).val();
			var action = 'searchprod';
			if (producto != '') {

				 $.ajax({
				  url: './back/ajax.php',
				  type: 'POST',
				  async: true,
				  data: {action:action,producto:producto},
		

				  success: function(response){
			        console.log(response);

			        if (response != 'error') {
			      	  var datosp = JSON.parse(response);
			      	  $('#descripcionp').html(datosp.descripcion);
			      	  $('#cantidadp').val('0');
			      	  $('#existenciap').html(datosp.existencia);
			      	  $('#preciop').html(datosp.precio);
			      	  //enable cantidad
			      	  $('#cantidadp').removeAttr('disabled')

			      	  $('#btn_addp').slideDown();

			        }else{

			          $('#descripcionp').html("-");
			      	  $('#cantidadp').val('0');
			      	  $('#existenciap').html('0');
			      	  $('#preciop').html('0.00');
			      	  //enable cantidad
			      	  $('#cantidadp').attr('disabled','disabled');
			      	  $('.btn_ap').slideUp();

			        }
		

				  }, 

				  error: function(error) {
	    		     console.log(error);

	     		    }

	   		   });
			}else{

			          $('#descripcionp').html("-");
			      	  $('#cantidadp').val('0');
			      	  $('#existenciap').html('0');
			      	  $('#preciop').html('0.00');
			      	  //enable cantidad
			      	  $('#cantidadp').attr('disabled','disabled');
			      	  $('.btn_ap').slideUp();
			      	}

			 

		});

		$('#cantidadp').keyup(function(e) {
			e.preventDefault();
			var ptotal = $(this).val() * $('#preciop').html();
			var existencia = parseInt($('#existenciap').html());
			$('#totalp').html(ptotal);
			if ($(this).val() < 1 || isNaN($(this).val()) || ($(this).val() > existencia)) {

		      $('.btn_ap').slideUp();

		    } else{

		      $('.btn_ap').slideDown();

		}

		});

		$('#btn_addp').click(function(e) {
			e.preventDefault();

			if ($('#cantidadp' > 0)) {

				var codproducto = $('#idproductop').val();
				var cantidad = $('#cantidadp').val();
				var action = 'addproductodetalle';


				 $.ajax({
				  url: './back/ajax2.php',
				  type: 'POST',
				  async: true,
				  data: {action:action,producto:codproducto,cantidad:cantidad},
		

				  success: function(response){
			        console.log(response);
			        if (response != 'error') {
			        	var info3 = JSON.parse(response);
			        	console.log(info3);
			        	$('#idproductop').val(0);
			        	$('.h1d').fadeIn();
			        	$('#det_p').html(info3.detalle);
			        	$('#detalle_totales').html(info3.totales);
			        	$('#descripcionp').html("-");
			      	    $('#cantidadp').val('0');
			      	    $('#existenciap').html('0');
			      	    $('#preciop').html('0.00');
			      	  //disable cantidad
			      	    $('#cantidadp').attr('disabled','disabled');
			      	    $('.btn_ap').slideUp();


			        }else{

			        	console.log('no data');
			        }

			       
				  }, 

				  error: function(error) {
	    		     console.log(error);

	     		    }

	   		   });
			}
		});

});
