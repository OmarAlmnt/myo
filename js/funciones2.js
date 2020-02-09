$(document).ready(function() {
	
	$('#anularventa').click(function(e) {
		e.preventDefault();
		var rows = $('#det_p tr').length;
	

		if (rows > 0) {

		  var action = 'anularventa';

		   $.ajax({
				url: './back/ajax2.php',
				type: 'POST',
				async: true,
				data: {action:action},
		

				success: function(response){
			      console.log(response);

			      if (response != 'error') {

			      	location.reload();
			      }

			      
				}, 

				error: function(error) {
	    		   console.log(error);

	     		  }

	   		 });






		} else{

			console.log("perro");
		}
	});

	$('#procesarventa').click(function(e) {
		e.preventDefault();
		var rows = $('#det_p tr').length;
	

		if (rows > 0) {

		  var action = 'procesarventa';
		  var codcliente = $('#idcliente').val();

		   $.ajax({
				url: './back/ajax2.php',
				type: 'POST',
				async: true,
				data: {action:action,codcliente:codcliente},
		

				success: function(response){
			      console.log(response);

			      if (response != 'error') {

			      	var info = JSON.parse(response);
			      	console.log(info); 
			      	//location.reload();
			      	generarPDF(info.idcliente,info.nofactura);
			      }

			      
				}, 

				error: function(error) {
	    		   console.log(error);

	     		  }

	   		 });






		} else{

			console.log("perro");
		}
	});

});

function generarPDF(cliente,factura){

	var ancho = 1000;
	var alto = 800;
	var x = parseInt((window.screen.width/2) - (ancho/2));
	var y = parseInt((window.screen.height/2) - (alto/2));

	$url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");




}

$('.verpdf').click(function(e) {
	e.preventDefault();
	var idcliente = $(this).attr('cl');
	var nofactura = $(this).attr('f');
	generarPDF(idcliente,nofactura);


});

$('.anularfac').click(function(e) {



 e.preventDefault();
 var nofactura = $(this).attr('f'); 
 var action = 'anularfactura'; 


  $.ajax({
				url: './back/ajax2.php',
				type: 'POST',
				async: true,
				data: {action:action,nofac:nofactura},
		

				success: function(response){
			      console.log(response);

			     if (response == 'si') {

			     	location.reload();
			     } else{

			     	console.log("error");
			     }
			     

			      
				}, 

				error: function(error) {
	    		   console.log(error);

	     		  }

	   		 });

   



});

