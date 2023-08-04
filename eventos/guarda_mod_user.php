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

$password         = $_POST['password'];
$new_password     = $_POST['new_password'];
$new_password_rep = $_POST['new_password_rep'];

if ($password == '' || $new_password == '' || $new_password_rep == '' ) {
header("Location:acceso_participante_mod.php");
}
else {

    $sql = " SELECT idusuario, idnombre, usuario, password, fecha, condicion, perfil ";
	$sql.= " FROM usuarios WHERE password = '$password' AND condicion = 'ACTIVO' ";
	$result = mysqli_query($link,$sql);
	if ($row = mysqli_fetch_array($result))
        {
            if ($new_password == $new_password_rep) 
            {               
                $sql_u = " UPDATE usuarios SET password = '$new_password' ";
                $sql_u.= " WHERE idusuario = '$idusuario_ss' AND perfil = 'PARTICIPANTE' ";
                $result_u = mysqli_query($link,$sql_u);

                header("Location:mensaje_pass_user.php");
            } 
            else {
               header("Location:mensaje_pass_desigual.php");
            }            
        } else {
            header("Location:mensaje_pass_no_existe.php");
        }
}
?>
