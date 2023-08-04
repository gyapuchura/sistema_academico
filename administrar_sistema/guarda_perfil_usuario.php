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

$idnombre_user  = $_POST['idnombre_user'];
$idnombre_datos = $_POST['idnombre_datos'];
$iddato_laboral = $_POST['iddato_laboral'];
$idresidencia   = $_POST['idresidencia'];
$user           = $_POST['user'];
$perfil         = $_POST['perfil'];

    switch ($perfil) {
        case 'ADMINISTRADOR':
            $user_mod = $user.'-A';
            break;
            case 'DOCENTE':
                $user_mod = $user.'-D';
                break;
                case 'PARTICIPANTE':
                    $user_mod = $user.'-P';
                    break;
        }

$new_password     = $_POST['new_password'];
$new_password_rep = $_POST['new_password_rep'];

if ($new_password == '' || $new_password_rep == '') {
header("Location:nuevo_perfil.php");
}
else {

    $sql = " SELECT idusuario, idnombre, usuario, password, fecha, condicion, perfil ";
	$sql.= " FROM usuarios WHERE perfil ='$perfil' AND idnombre='$idnombre_user'";
	$result = mysqli_query($link,$sql);
	if ($row = mysqli_fetch_array($result))
     {
        header("Location:mensaje_perfil_existe.php");
    } else {
            if ($new_password == $new_password_rep) 
            {
              
                if ($perfil == 'DOCENTE') {
                    $sql = " INSERT INTO usuarios (idnombre, usuario, password, fecha, condicion, perfil) ";
                    $sql.= " VALUES ('$idnombre_user','$user_mod','$new_password','$fecha','ACTIVO','$perfil') ";
                    $result = mysqli_query($link,$sql);
                    $idusuario_doc = mysqli_insert_id($link);

                    /** para el perfil de DOCENTE creamos el registro docente correspondiente */

                    $sql_d = " INSERT INTO docente (idusuario, idnombre, idnombre_datos, iddato_laboral, idresidencia, idestado_docente, fecha_registro ) ";
                    $sql_d.= " VALUES ('$idusuario_doc','$idnombre_user','$idnombre_datos','$iddato_laboral','$idresidencia','1','$fecha' ) ";
                    $result_d = mysqli_query($link,$sql_d);
            
                    header("Location:mensaje_perfil_creado.php");

                } else {

                    $sql = " INSERT INTO usuarios (idnombre, usuario, password, fecha, condicion, perfil) ";
                    $sql.= " VALUES ('$idnombre_user','$user_mod','$new_password','$fecha','ACTIVO','$perfil') ";
                    $result = mysqli_query($link,$sql);
            
                    header("Location:mensaje_perfil_creado.php");

                }
            } else {

                    header("Location:mensaje_pass_noigual.php");
            }
   }
 }
?>
