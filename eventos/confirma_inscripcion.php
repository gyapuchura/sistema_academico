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

$idinscripcion = $_POST['idinscripcion'];
$idevento      = $_POST['idevento'];
$idusuario_solicitante = $_POST['idusuario_solicitante'];
$idnombre_solicitante  = $_POST['idnombre_solicitante'];

//---- verificamos que el numero de ci del solicitante ya este confirmado -----//

$sql_e = " SELECT inscripcion.idinscripcion, nombre.ci FROM inscripcion, nombre WHERE inscripcion.idnombre=nombre.idnombre ";
$sql_e.= " AND inscripcion.idestado_inscripcion='2' AND inscripcion.idnombre='$idnombre_solicitante' AND inscripcion.idevento='$idevento_ss' ";
$result_e = mysqli_query($link,$sql_e);
if ($row_e = mysqli_fetch_array($result_e)) {

    header("Location:mensaje_inscrito_existe.php");

} else {
    
//---- Consultamos el cupo en el evento programado -----//

$sql_c    = " SELECT idevento, cupo_max FROM evento WHERE idevento = '$idevento' ";
$result_c = mysqli_query($link,$sql_c);
$row_c    = mysqli_fetch_array($result_c);
$cupo_max = $row_c[1];

$sql_oc    = " SELECT COUNT(*) FROM inscripcion WHERE idestado_inscripcion='2' AND idevento='$idevento' ";
$result_oc = mysqli_query($link,$sql_oc);
$row_oc    = mysqli_fetch_array($result_oc);
$cupo_oc   = $row_oc[0];

    if ($cupo_oc == $cupo_max) {
 
        //------ si el cupo ocupado es igual al cupo maximo el evento ya no se ofertara ----//
        $sql9 = " UPDATE evento SET idestado_registro ='3'  ";
        $sql9.= " WHERE idevento = '$idevento' ";
        $result9 = mysqli_query($link,$sql9);
    
        header("Location:mensaje_sin_cupo.php");

    } else {

    $sql8 = " UPDATE inscripcion SET idestado_inscripcion ='2', fecha_ins='$fecha' ";
    $sql8.= " WHERE idinscripcion = '$idinscripcion' ";
    $result8 = mysqli_query($link,$sql8);

    header("Location:mensaje_confirmacion_ins.php");

        }
    }

?>