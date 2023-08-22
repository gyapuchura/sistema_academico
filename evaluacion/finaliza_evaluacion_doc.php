<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$fecha_ram	  = date("Ymd");
$fecha 	      = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss     = $_SESSION['idusuario_ss'];
$idnombre_ss      = $_SESSION['idnombre_ss'];
$perfil_ss        = $_SESSION['perfil_ss'];

$idtematica_ss    = $_SESSION['idtematica_ss'];
$idevento_ss      = $_SESSION['idevento_ss'];
$codigo_evento_ss = $_SESSION['codigo_evento_ss'];

$idevento = $_POST['idevento'];

//---- verificamos que se haya evaluado a todos los participantes inscritos -----//
$sql = " SELECT idinscripcion, nota_final, idcomentario_evaluacion FROM inscripcion  ";
$sql.= " WHERE idevento='$idevento' AND idestado_inscripcion='2' AND idcomentario_evaluacion = '1'  ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result))
{
    header("Location:mensaje_evaluacion_incompleta.php"); 
    
    } else {
       
    $sql8 = " UPDATE evento SET idestado_ejecucion ='4'  WHERE idevento = '$idevento' ";
    $result8 = mysqli_query($link,$sql8);

    header("Location:mensaje_finaliza_evaluacion_doc.php");

    }
    
?>