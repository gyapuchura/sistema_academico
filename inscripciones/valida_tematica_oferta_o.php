<?php include("../cabf_o.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$fecha_ram	  = date("Ymd");
$fecha 	      = date("Y-m-d");
$gestion      = date("Y");

$idtematica       = $_POST['idtematica'];

$_SESSION['idtematica_ss'] = $idtematica;

header("Location:eventos_tema_o.php");
?>