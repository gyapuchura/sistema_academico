<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 		  = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE PREINSCRIPCION ----- //

$iddocente_ss     = $_SESSION['iddocente_ss'];

  $idnombre       = $_POST['idnombre'];
  $idusuario_in   = $_POST['idusuario_in'];
  $idnombre_datos = $_POST['idnombre_datos'];
  $iddependencia  = $_POST['iddependencia'];
  $idresidencia   = $_POST['idresidencia'];

  //para el caso de participante de otra entidad.
  $entidad       = $link->real_escape_string(htmlentities($_POST['entidad']));
  $cargo_entidad = $link->real_escape_string(htmlentities($_POST['cargo_entidad']));
  
  //para el caso de participante del Ministerio de Salud y Deportes.
  $idministerio = $_POST['idministerio'];
  $iddireccion  = $_POST['iddireccion'];
  $idarea       = $_POST['idarea'];
  $cargo_mds    = $link->real_escape_string(htmlentities($_POST['cargo_mds']));
  
  //para el caso de participante de una Red de salud.
  $iddepartamento = $_POST['iddepartamento'];
  $idred_salud    = $_POST['idred_salud'];
  $idestablecimiento_salud = $_POST['idestablecimiento_salud'];
  $cargo_red_salud = $link->real_escape_string(htmlentities($_POST['cargo_red_salud']));

//----- Realizamos la seleccion de tipo de dependencias ------//

if ($iddependencia == '1') {
//------ DEPENDE DE OTRA ENTIDAD -------------//

    $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
    $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
    $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','$entidad','$cargo_entidad',";
    $sql2.= " '0','0','0','','$idresidencia','0','0','') ";
    $result2 = mysqli_query($link,$sql2);

    $iddato_laboral = mysqli_insert_id($link);

    $sql8 = " UPDATE docente SET iddato_laboral='$iddato_laboral' WHERE iddocente='$iddocente_ss'";
    $result8 = mysqli_query($link,$sql8); 

    header("Location:mensaje_laboral_docente.php");


} else {
    if ($iddependencia == '2') {

//------- DEPENDE DEL MINISTERIO DE SALUD Y DEPORTES -------//

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= " '$idministerio','$iddireccion','$idarea','$cargo_mds','$idresidencia','0','0','') ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql8 = " UPDATE docente SET iddato_laboral='$iddato_laboral' WHERE iddocente='$iddocente_ss'";
        $result8 = mysqli_query($link,$sql8); 

        header("Location:mensaje_laboral_docente.php");

    } else {
        if ($iddependencia == '3') {

// --------- DEPENDE DE UNA RED DE SALUD ------------ //

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= "  '0','0','0','','$iddepartamento','$idred_salud','$idestablecimiento_salud','$cargo_red_salud' ) ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        $sql8 = " UPDATE docente SET iddato_laboral='$iddato_laboral' WHERE iddocente='$iddocente_ss'";
        $result8 = mysqli_query($link,$sql8); 

        header("Location:mensaje_laboral_docente.php");

        } else {
//------ En caso de existir otro tipo de dependencia laboral del interesado ------//           
            }
        }
    }

?>
