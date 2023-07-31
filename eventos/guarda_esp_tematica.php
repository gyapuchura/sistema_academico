<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha_ram	 = date("Ymd");
$fecha 	     = date("Y-m-d");
$gestion     = date("Y");

$idusuario_ss =  $_SESSION['idusuario_ss'];
$idnombre_ss  =  $_SESSION['idnombre_ss'];
$perfil_ss    =  $_SESSION['perfil_ss'];

$iddocente_ss = $_SESSION['iddocente_ss'];

$idtematica   = $_POST['idtematica'];

$sql0 = " INSERT INTO especialidad_docente ( iddocente, idtematica ) VALUES ( '$iddocente_ss','$idtematica' ) ";
$sql0.= "   ";
$result0 = mysqli_query($link,$sql0);

header("Location:mostrar_docente_mod.php");
?>


