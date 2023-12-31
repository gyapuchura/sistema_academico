<?php include("../cabf_o.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 		  = date("Y-m-d");
$gestion      = date("Y");

$idtematica_ss    =  $_SESSION['idtematica_ss'];
$idevento_ss      =  $_SESSION['idevento_ss'];
$codigo_evento_ss =  $_SESSION['codigo_evento_ss'];

$idnombre_inscrito_ss =  $_SESSION['idnombre_inscrito_ss'];
$nombre_inscrito_ss   =  $_SESSION['nombre_inscrito_ss'];
$paterno_inscrito_ss  =  $_SESSION['paterno_inscrito_ss'];
$materno_inscrito_ss  =  $_SESSION['materno_inscrito_ss'];
$ci_inscrito_ss       =  $_SESSION['ci_inscrito_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- //

$idusuario_inscrito = $_POST['idusuario_inscrito'];
$idnombre_datos     = $_POST['idnombre_datos'];
$iddato_laboral     = $_POST['iddato_laboral'];

//------ DEFINIMOS LA INSCRIPCION DIRECTA O INDIRECTA (begin)--------//

$sql_in    = " SELECT idevento, idtipo_inscripcion FROM evento WHERE idevento='$idevento_ss' ";
$result_in = mysqli_query($link,$sql_in);
$row_in    = mysqli_fetch_array($result_in);

if ($row_in[1] == '1') {
    $idestado_inscripcion = '1';  //inscripcion con confirmacion   
    } else {
    $idestado_inscripcion = '2';  //inscripcion directa
    }


//------ DEFINIMOS LA INSCRIPCION DIRECTA E INDIRECTA (end)--------//

//----- Obtenemos el codigo y correlativo de inscripcion ------//

$sqlm="SELECT MAX(correlativo) FROM inscripcion WHERE gestion='$gestion' ";
$resultm=mysqli_query($link,$sqlm);
$rowm=mysqli_fetch_array($resultm);

$correlativo=$rowm[0]+1;

$codigo="INS/MSYD-".$correlativo."/".$gestion;

//----- Realizamos la verificacion para no duplicar inscripciojn directa ------//

$sql_rep = " SELECT inscripcion.idinscripcion,inscripcion.idusuario, inscripcion.idnombre FROM inscripcion, nombre ";
$sql_rep.= " WHERE inscripcion.idnombre=nombre.idnombre AND nombre.ci='$ci_inscrito_ss' AND inscripcion.idestado_inscripcion='2' AND inscripcion.idevento='$idevento_ss'";
$result_rep = mysqli_query($link,$sql_rep);
if ($row_rep = mysqli_fetch_array($result_rep)) {

    header("Location:mensaje_inscrito_existe_o.php");

} else {

    $sql8 = " INSERT INTO inscripcion (idevento, idusuario, idnombre, idnombre_datos, iddato_laboral, ";
    $sql8.= " idestado_inscripcion, idestado_evaluacion, correlativo, codigo, fecha_preins, fecha_ins, gestion, idcomentario_evaluacion, nota_final )";
    $sql8.= " VALUES ('$idevento_ss','$idusuario_inscrito','$idnombre_inscrito_ss','$idnombre_datos','$iddato_laboral',";
    $sql8.= " '$idestado_inscripcion','1','$correlativo','$codigo','$fecha','$fecha','$gestion','1','0')";
    $result8 = mysqli_query($link,$sql8);  

    $idinscripcion = mysqli_insert_id($link);
    $_SESSION['idinscripcion_ss'] = $idinscripcion; 

    header("Location:mostrar_inscripcion_dp_o.php");    
}

?>