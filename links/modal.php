<link rel="stylesheet" type="text/css" href="css/modal.css">
<link rel="stylesheet" type="text/css" href="css/form.css">
<div class="modal">
	<div class="bodymodal">
	 <div class="frm_modal">
		<form method="post" id="aumentarp" onsubmit="event.preventDefault(); sendproduct();">
			<h3 align="center">Agregar productos</h1><br>
			<h4 align="center" class="namep"></h2><br>
			<center>
			<input type="number" min="1" class="cnt" placeholder="cantidad para agregar" name="cantidad" required><br>
			<input type="hidden" id="idproducto" name="idproducto">
			<input type="hidden" id="addprodut" value="agp" name="action">
		    </center>
			<button type="submit" class=" bot4 btn btn-2"><i class="fas fa-check"></i>  confirmar </button>


          <a onclick="closemodal();" class="bot4 btn btn-2" onclick="" ><i class="fas fa-times"></i>  cancelar </a>

		</form>
	 </div>
	</div>
</div>