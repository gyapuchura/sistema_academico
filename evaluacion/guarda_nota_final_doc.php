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

$idevento_ss      = $_SESSION['idevento_ss'];
$codigo_evento_ss = $_SESSION['codigo_evento_ss'];

$nota_final    = $_POST['nota_final'];
$idinscripcion = $_POST['idinscripcion'];

if ($nota_final == '') {

header("Location:mostrar_inscritos_eval_doc.php");

}
else {

if ($nota_final == '') {
        $idcomentario_evaluacion = '1';
} else {
   if ($nota_final == '0') {
        $idcomentario_evaluacion = '2';
   } else {
    if ( $nota_final < '71' ) {
        $idcomentario_evaluacion = '3';
    } else {
      if ($nota_final >= '71') {
        $idcomentario_evaluacion = '4';
      } else {

      }
      
    }
    
   }
   
}


$sql0 = " UPDATE inscripcion SET nota_final='$nota_final', idcomentario_evaluacion='$idcomentario_evaluacion' ";
$sql0.= " WHERE idinscripcion='$idinscripcion' ";
$result0 = mysqli_query($link,$sql0);

header("Location:mostrar_inscritos_eval_doc.php");
}
?>
