<?php include("../cabf_o.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$fecha_ram	  = date("Ymd");
$fecha 	      = date("Y-m-d");
$gestion      = date("Y");

$idtematica_ss  = $_SESSION['idtematica_ss'];

$idevento       = $_POST['idevento'];
$codigo_evento  = $_POST['codigo'];

$_SESSION['idevento_ss']      = $idevento;
$_SESSION['codigo_evento_ss'] = $codigo_evento;

header("Location:inicio_inscripcion_o.php");

?>