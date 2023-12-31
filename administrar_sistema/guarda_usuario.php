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

$nombre      = $link->real_escape_string(htmlentities($_POST['nombre']));
$paterno     = $link->real_escape_string(htmlentities($_POST['paterno']));
$materno     = $link->real_escape_string(htmlentities($_POST['materno']));
$ci          = $link->real_escape_string(htmlentities($_POST['ci']));
$complemento = $link->real_escape_string(htmlentities($_POST['complemento']));
$exp         = $link->real_escape_string(htmlentities($_POST['exp']));

$nacimiento  = $_POST['fecha_nac'];
$fecha_n     = explode('/',$nacimiento);
$fecha_nac   = $fecha_n[2].'-'.$fecha_n[1].'-'.$fecha_n[0];

$idnacionalidad        = $_POST['idnacionalidad'];
$idgenero              = $_POST['idgenero'];
$idformacion_academica = $_POST['idformacion_academica'];
$idprofesion           = $_POST['idprofesion'];

$perfil = $_POST['perfil'];

    if ($idprofesion == '1') {
    $idespecialidad_medica = $_POST['idespecialidad_medica'];    
    } else {
    $idespecialidad_medica = '45';
    }

$correo  = $link->real_escape_string(htmlentities($_POST['correo']));
$celular = $link->real_escape_string(htmlentities($_POST['celular']));

$direccion_dom = $link->real_escape_string(htmlentities($_POST['direccion_dom']));
$idresidencia  = $_POST['idresidencia'];

$iddependencia = $_POST['iddependencia'];
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

//----- Guardamos datos de usuario nuevo ------//

//verificamos existencia del número de cedula de identidad.
    $sql9 = " SELECT idnombre, paterno, materno, nombre, ci FROM nombre WHERE ci='$ci' ";
    $result9 = mysqli_query($link,$sql9);
      if ($row9 = mysqli_fetch_array($result9)) {
         
            $_SESSION['idnombre_usuario_ss'] = $row9[0]; 

            header("Location:usuario_existe.php");
      }  
      else {

  /* Primero Insertamos los datos en la tabla de nombres */
  $sql0 = " INSERT INTO nombre (paterno, materno, nombre, ci, exp, fecha_nac, complemento, idnacionalidad, idgenero) ";
  $sql0.= " VALUES ('$paterno','$materno','$nombre','$ci','$exp','$fecha_nac','$complemento','$idnacionalidad','$idgenero') ";
  $result0 = mysqli_query($link,$sql0);
  
  $idnombre = mysqli_insert_id($link);
  $_SESSION['idnombre_in_ss'] = $idnombre; 

 /* Primero Insertamos los datos en la tabla de usuarios */
  $sql7 = " INSERT INTO usuarios (idnombre, usuario, password, fecha, condicion, perfil) ";
  $sql7.= " VALUES ('$idnombre','$ci','$ci','$fecha','ACTIVO','$perfil')";
  $result7 = mysqli_query($link,$sql7);  

  $idusuario_in = mysqli_insert_id($link);
  $_SESSION['idusuario_in_ss'] = $idusuario_in; 

  $sql1 = " INSERT INTO nombre_datos (idnombre, idusuario, idformacion_academica, idprofesion, idespecialidad_medica, correo, celular, direccion_dom, iddepartamento ) ";
  $sql1.= " VALUES ('$idnombre','$idusuario_in','$idformacion_academica','$idprofesion','$idespecialidad_medica','$correo','$celular','$direccion_dom','$idresidencia' ) ";
  $result1 = mysqli_query($link,$sql1);

  $idnombre_datos = mysqli_insert_id($link);


//----- Realizamos la seleccion de tipo de dependencias ------//

if ($iddependencia == '1') {
//------ DEPENDE DE OTRA ENTIDAD -------------//

    $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
    $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
    $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','$entidad','$cargo_entidad',";
    $sql2.= " '0','0','0','','$idresidencia','0','0','') ";
    $result2 = mysqli_query($link,$sql2);

    $iddato_laboral = mysqli_insert_id($link);

    header("Location:mostrar_usuario_in.php");

} else {
    if ($iddependencia == '2') {

//------- DEPENDE DEL MINISTERIO DE SALUD Y DEPORTES -------//

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= " '$idministerio','$iddireccion','$idarea','$cargo_mds','$idresidencia','0','0','') ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        header("Location:mostrar_usuario_in.php");

    } else {
        if ($iddependencia == '3') {

// --------- DEPENDE DE UNA RED DE SALUD ------------ //

        $sql2 = " INSERT INTO dato_laboral (idnombre, idusuario, iddependencia, entidad, cargo_entidad, ";
        $sql2.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ) ";
        $sql2.= " VALUES ('$idnombre','$idusuario_in','$iddependencia','','',";
        $sql2.= "  '0','0','0','','$iddepartamento','$idred_salud','$idestablecimiento_salud','$cargo_red_salud' ) ";
        $result2 = mysqli_query($link,$sql2);

        $iddato_laboral = mysqli_insert_id($link);

        header("Location:mostrar_usuario_in.php");

        } else {
//------ En caso de existir otro tipo de dependencia laboral del interesado ------//           
            }
        }
    }
}

?>
