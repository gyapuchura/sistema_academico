<?php
include("../inc.config.php");

$idmodalidad  = $_POST['modalidad'];

if ($idmodalidad == '2') {
  ?>

<input type="hidden" name="iddepartamento" value="4" >
<input type="hidden" name="idprovincia" value="52" >
<input type="hidden" name="idmunicipio" value="137" >

<?php 
} else {
    ?> 

    <div class="row">
    <div class="col-md-3"><h4>MUNICIPIO:</h4></div>
    <div class="col-md-3"><input type="text" class="form-control" placeholder="NOMBRE DEL MUNICIPIO" id="busqueda" required/></div>
    <div class="col-md-6" id="resultado"></div>
    </div>

        <?php    
        }
        ?>
        <script>
			$(document).ready(function(){
				  var consulta;

				  $("#busqueda").keyup(function(e){
						//obtenemos el texto introducido en el campo de b�squeda
						consulta = $("#busqueda").val();
						 //hace la b�squeda
							 $.ajax({
								   type: "POST",
								   url: "buscar_municipio.php",
								   data: "b="+consulta,
								   dataType: "html",
								   beforeSend: function(){
											  //imagen de carga
										   $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
								   },
								   error: function(){
										   alert("error petici�n ajax");
									 },
								  success: function(data){
										$("#resultado").empty();
										$("#resultado").append(data);
										//$("#busqueda").val(consulta);
									}
							});
				  });
			});
	    </script>
</body>
</html>
