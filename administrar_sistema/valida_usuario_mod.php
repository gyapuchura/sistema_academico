<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$fecha_ram	  = date("Ymd");
$fecha 	      = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idusuario_mod  = $_POST['idusuario_mod'];
$idnombre_mod  = $_POST['idnombre_mod'];

$_SESSION['idusuario_mod_ss'] = $idusuario_mod;
$_SESSION['idnombre_mod_ss'] = $idnombre_mod;

header("Location:mostrar_usuario.php");

?>