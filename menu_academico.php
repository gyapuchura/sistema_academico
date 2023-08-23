<div class="navbar-collapse collapse ">
    <ul class="nav navbar-nav">

	<?php
	
$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'ADMINISTRADOR' || $row[0] =='USUARIO' ){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	?> 

	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">PROGRAMACION<b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li><a href="../eventos/eventos.php">EVENTOS</a></li>		
<!--    <li><a href="../eventos/docentes.php">DOCENTES</a></li> --->
<!--	<li><a href="../eventos/oferta_eventos.php">OFERTA ACADÉMICA</a></li> --->
		<li><a href="../eventos/administrar_eventos.php">ADMINISTRAR EVENTOS</a></li>
		</ul>
	</li>
<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

<?php
/****** MENU GESTION DE DOCENTES ******/	

$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'ADMINISTRADOR' || $row[0] =='USUARIO'){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	
	?> 
	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">DOCENTES<b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li><a href="../eventos/docentes.php">REGISTRO DE DOCENTES</a></li>
	<!--	<li><a href="#">SEGUIMIENTO DE F-3009</a></li>  -->
		</ul>
	</li>
<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

<?php
/****** MENU DE GESTION DE INSCRIPCIONES ******/	

$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'ADMINISTRADOR' || $row[0] =='USUARIO'){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	
	?> 
	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">INSCRIPCIONES<b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li><a href="../eventos/administrar_inscripciones.php">ADMINISTRAR INSCRIPCIONES</a></li>
	<!--	<li><a href="#">SEGUIMIENTO DE F-3009</a></li>  -->
		</ul>
	</li>
<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

<?php
////////	/****** CONTROL EXTERNO PARA EL SUPERVISOR DE LA SCEP ******/		
$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'ADMINISTRADOR' || $row[0] =='GERENTE' || $row[0] =='USUARIO'){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	
	?>

	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">EVALUACIÓN<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="../evaluacion/para_evaluacion.php">EVENTOS PARA EVALUACIÓN</a></li>
			<li><a href="../evaluacion/certificacion_eventos.php">CERTIFICACION</a></li>


		</ul>
	</li>

	<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

<?php
$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'PARTICIPANTE'){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	
	?>

	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">OPCIONES PARTICIPANTE<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="../evaluacion/eventos_participante.php">EVENTOS DEL PARTICIPANTE</a></li>
			<li><a href="../inscripciones/datos_participante.php">DATOS PERSONALES</a></li>


		</ul>
	</li>

	<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

<?php
$sql = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
if ($row[0] == 'DOCENTE'){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {	
	?>

	<li class="dropdown">
	<a href="#" data-toggle="dropdown" class="dropdown-toggle">OPCIONES DOCENTE<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="../evaluacion/eventos_docente.php">EVENTOS DEL DOCENTE</a></li>
			<li><a href="#">DATOS DOCENTE</a></li>
		</ul>
	</li>

	<?php
} while ($row = mysqli_fetch_array($result));
} else {
}
?>

	<li class="active"><a href="../inicio.php">INICIO</a></li>
	</ul>
</div>