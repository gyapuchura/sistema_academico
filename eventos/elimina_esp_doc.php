<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$ideventoi_ss = $_SESSION['ideventoi_ss'];

$idespecialidad_docente = $_POST['idespecialidad_docente'];

/* BORRAMOS EL REGISTRO*/

$sql    = " DELETE FROM especialidad_docente WHERE idespecialidad_docente = '$idespecialidad_docente' ";
$result =  mysqli_query($link,$sql);

header("Location:mostrar_docente_mod.php");

?>
