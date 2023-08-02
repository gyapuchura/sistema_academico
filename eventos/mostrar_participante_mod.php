<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 		  = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, nombre.fecha_nac, nombre.idnacionalidad, ";
$sql_n.=" nombre.idgenero, nombre_datos.idformacion_academica, nombre_datos.idprofesion, nombre_datos.idespecialidad_medica, nombre_datos.correo, ";
$sql_n.=" nombre_datos.celular, nombre.idnombre, nombre_datos.direccion_dom, nombre_datos.idnombre_datos, nombre_datos.iddepartamento FROM nombre, nombre_datos, usuarios  ";
$sql_n.=" WHERE nombre_datos.idnombre=nombre.idnombre AND usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario_ss' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, ";
$sql_l.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ";
$sql_l.= " FROM dato_laboral WHERE idusuario='$idusuario_ss' ORDER BY iddato_laboral DESC LIMIT 1";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>MINISTERIO DE SALUD Y DEPORTES</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />

<!-- c+ss -->
<link href="../css/bootstrap.min.css" rel="stylesheet" />
<link href="../css/fancybox/jquery.fancybox.css" rel="stylesheet">
<link href="../css/flexslider.css" rel="stylesheet" />
<link href="../css/style.css" rel="stylesheet" />

<link rel="stylesheet" href="../css/jquery-ui.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
<div id="wrapper">
<div class="topbar">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <p class="pull-left hidden-xs">MINISTERIO DE SALUD Y DEPORTES</p>
         <a href="../index.php"><p class="pull-right hidden-xs">INGRESAR A SISTEMA</p></a>
      </div>
    </div>
  </div>
</div>
	<!-- start header -->
	<header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                  <a class="navbar-brand" href="../intranet.php"><img src="../img/logo_saes.png" alt="logo"/></a>
                </div>
                <?php include("../menu_academico.php");?>
            </div>
        </div>
	</header><!-- end header -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">ACTUALIZAR DATOS PARTICIPANTE</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
  <h4 align="center"><a href="../inscripciones/datos_participante.php">VOLVER</a></h4>
</br>
<!-- MUESTRA LA PREINSCRIPCION REALIZADA --->

<div class="row">
    <div class="col-md-6"><h3>1.- ACTUALIZAR DATOS PERSONALES:</h3></div>
    <div class="col-md-6"></div>
</div>

<form name="PERSONALES" action="guarda_datospersonales_participante.php" method="post">

<input type="hidden" name="idnombre" value="<?php echo $row_n[14];?>">

<div class="box-area">
<div class="form-group row">
    <div class="col-sm-3 mb-3 mb-sm-0">
    <h4>NOMBRES:</h4>
    <input type="text" class="form-control" name="nombre" placeholder="Nombres" 
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El nombre con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[0];?>" />
    </div>
    <div class="col-sm-3">
    <h4>PRIMER APELLIDO:</h4>
    <input type="text" class="form-control" name="paterno" placeholder="Paterno" 
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El apellido paterno con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[1];?>"  />
    </div>
    <div class="col-sm-3">
    <h4>SEGUNDO APELLIDO:</h4>
    <input type="text" class="form-control" name="materno" placeholder="Materno"
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El apellido materno con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[2];?>" />
    </div>
    <div class="col-sm-3">
    <h4>FECHA DE NACIMIENTO:</h4>
    <input type="text" id="fecha1" class="form-control" name="fecha_nac" value="<?php 
        $fecha_n = explode('-',$row_n[6]);
        $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
        echo $fecha_nac;
        ?>" > 
    </div>
    </div>

    <div class="form-group row">

    <div class="col-sm-2 mb-3 mb-sm-0">
    <h4>CÉDULA DE ID:</h4>
    <input type="text" class="form-control" name="ci" placeholder="N° de CI"
    required pattern="[A-Z0-9_-]{5,12}$" 
    title="El numero de CI solo puede contener DIGITOS numéricos." value="<?php echo $row_n[3];?>"  >
    </div>
    <div class="col-sm-2 mb-3 mb-sm-0">
    <h4>COMPLEMENTO:</h4>
    <input type="text" class="form-control" name="complemento" placeholder="COMPLEMENTO" value="<?php echo $row_n[4];?>" >
    </div>
    <div class="col-sm-2">
    <h4>EXPEDICIÓN:</h4>
          <select name="exp"  id="exp" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = "SELECT iddepartamento, departamento, sigla FROM departamento ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[2];?>" <?php if ($rowv[2]==$row_n[5]) echo "selected";?> ><?php echo $rowv[2];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
          </select>
    </div>
    <div class="col-sm-3">
    <h4>NACIONALIDAD:</h4>
          <select name="idnacionalidad"  id="idnacionalidad" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
          </select>
    </div>
    <div class="col-sm-3">
    <h4>GÉNERO:</h4>
    <select name="idgenero"  id="idgenero" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idgenero, genero FROM genero ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
          </select>
    </div>
</div>


<div class="row">
        <div class="col-md-4"><h4></h4></div>
        <div class="col-md-8">    
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#datosPersonales">
              GUARDAR CAMBIOS
            </button>
        </div>
        </div>
</div>

<!-- modal de confirmacion de envio de datos-->

<div class="modal fade" id="datosPersonales" tabindex="-1" role="dialog" aria-labelledby="datosPersonalesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="datosPersonalesLabel">ACTUALIZAR DATOS PERSONALES DEL PARTICIPANTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        Esta seguro de actualizar los datos personales del usuario participante?
        posteriormenete no se podran realizar cambios.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR</button>    
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal -->

  <div class="row">
    <div class="col-md-6"><h3>2.- DATOS COMPLEMENTARIOS:</h3></div>
    <div class="col-md-6"></div>
  </div>

<form name="COMPLEMENTARIOS" action="guarda_complementarios_participante.php" method="post">

<input type="hidden" name="idnombre_datos" value="<?php echo $row_n[16];?>">
<div class="box-area">
<div class="row">
<div class="col-md-3"><h4>FORMACIÓN ACADÉMICA:</h4></div>
<div class="col-md-3">
      <select name="idformacion_academica"  id="idformacion_academica" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = "SELECT idformacion_academica, formacion_academica FROM formacion_academica ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[9]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
</div>
<div class="col-md-3"><h4>PROFESIÓN/OCUPACIÓN:</h4></div>
<div class="col-md-3">
        <select name="idprofesion"  id="idprofesion" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idprofesion, profesion FROM profesion ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
        </select>
</div>
</div>

<?php if ($row_n[10] == '1') { ?>
<!----- mostramos la especialidad si es medico ------->
  <div class="row">
  <div class="col-md-3"><h4>ESPECIALIDAD MÉDICA:</h4></div>
  <div class="col-md-9">

        <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
        </select>
  </div>
</div>

<?php } else { ?>
   
    <input type="hidden" name="idespecialidad_medica" value="45">

 <?php } ?>

<div class="row">
<div class="col-md-3"><h4>CORREO ELECTRÓNICO:</h4></div>
<div class="col-md-3"><input type="mail" class="form-control" name="correo" value="<?php echo $row_n[12];?>"  required></div>
<div class="col-md-3"><h4>TELÉFONO CELULAR/WHATSAPP:</h4></div>
<div class="col-md-3"><input type="text" class="form-control" name="celular" value="<?php echo $row_n[13];?>"  required></div>
</div>

<div class="row">
<div class="col-md-3"><h4>DEPARTAMENTO DE RESIDENCIA:</h4></div>
<div class="col-md-3">
<select name="idresidencia"  id="idresidencia" class="form-control" required >
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[17]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
        </select>
</div>
<div class="col-md-2"><h4>DOMICILIO:</h4></div>
<div class="col-md-4"><textarea class="form-control" rows="3" name="direccion_dom" required><?php echo $row_n[15];?></textarea></div>
</div>

<div class="row">
        <div class="col-md-4"><h4></h4></div>
        <div class="col-md-8">    
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#datosComplementarios">
              GUARDAR CAMBIOS
            </button>
        </div>
        </div>
</div>

<!-- modal de confirmacion de envio de datos-->

<div class="modal fade" id="datosComplementarios" tabindex="-1" role="dialog" aria-labelledby="datosComplementariosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="datosComplementariosLabel">ACTUALIZAR DATOS COMPLEMENTARIOS DEL DOCENTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        Esta seguro de registrar los datos complementarios del docente?
        posteriormenete no se podran realizar cambios.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
      </div>
    </div>
  </div>
</div>
</form>
<!-- Modal -->


<div class="row">
<div class="col-md-6"><h3>3.- DATOS LABORALES: <?php echo $row_d[4];?></h3></div>
<div class="col-md-6"></div>
</div>


<div class="box-area">

<div class="row">
<div class="col-md-3"><h4>DEPENDENCIA:</h4></div>
<div class="col-md-3">

        <select name="iddependencia"  id="iddependencia" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddependencia, dependencia FROM dependencia ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
        </select>

</div>
</div>

<?php if ($row_l[3] == '1') { ?>
<!------ DEPENDIENTE DE OTRA ENTIDAD ----->

  <div class="row">
    <div class="col-md-3"><h4>DEPARTAMENTO:</h4></div>
    <div class="col-md-9">
      <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
    </div>
  </div>

<div class="row">
    <div class="col-md-3"><h4>ENTIDAD A LA QUE PERTENECE:</h4></div>
    <div class="col-md-9"><textarea class="form-control" rows="3" name="entidad" disabled ><?php echo $row_l[4];?></textarea></div>
</div>
<div class="row">
    <div class="col-md-3"><h4>CARGO EN LA ENTIDAD:</h4></div>
    <div class="col-md-9"><textarea class="form-control" rows="2" name="cargo_entidad" disabled ><?php echo $row_l[5];?></textarea></div>
</div>

<?php } else { if ($row_l[3] == '2') { ?>
<!------ DEPENDIENTE DEL MINISTERIO DE SALUD ----->
 
<div class="row">
    <div class="col-md-3"><h4>DEPARTAMENTO:</h4></div>
    <div class="col-md-9">
      <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
    </div>
    </div>


<div class="row">
    <div class="col-md-3"><h4>DEPENDIENTE DEL:</h4></div>
    <div class="col-md-9">

      <select name="idministerio"  id="idministerio" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idministerio, ministerio, sigla FROM ministerio ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
    </div>
    </div>

    <div class="row">
    <div class="col-md-3"><h4>DIRECCIÓN/PROGRAMA/</br>INSTITUCIÓN:</h4></div>
    <div class="col-md-9">

    <select name="iddireccion"  id="iddireccion" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddireccion, direccion FROM direccion ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
    </div>

    

    </div>

    <div class="row">
    <div class="col-md-3"><h4>UNIDAD ORGANIZACIONAL:</h4></div>
    <div class="col-md-9">

    <select name="idarea"  id="idarea" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idarea, area FROM area ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>

    </div>
    </div>

    <div class="row">
    <div class="col-md-3"><h4>CARGO QUE EJERCE:</h4></div>
    <div class="col-md-9"><textarea class="form-control" rows="2" name="cargo_mds" required disabled><?php echo $row_l[9];?></textarea></div>
    </div>

<?php } else { ?>
 <!------ DEPENDIENTE DE OTRA RED DE SALUD -----> 
  
 <div class="row">
    <div class="col-md-3"><h4>DEPARTAMENTO:</h4></div>
    <div class="col-md-9">
      <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
      </select>
    </div>
    </div>

    <div class="row">
    <div class="col-md-3"><h4>RED DE SALUD:</h4></div>
    <div class="col-md-9">

    <select name="idred_salud"  id="idred_salud" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idred_salud, red_salud FROM red_salud  ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
    </select>

    </div>
    </div>

    <div class="row">
    <div class="col-md-3"><h4>ESTABLECIMIENTO DE SALUD:</h4></div>
    <div class="col-md-9">

    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" required disabled>
          <option selected>Seleccione</option>
          <?php
          $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud  ";
          $resultv = mysqli_query($link,$sqlv);
          if ($rowv = mysqli_fetch_array($resultv)){
          mysqli_field_seek($resultv,0);
          while ($fieldv = mysqli_fetch_field($resultv)){
          } do {
          ?>
          <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[12]) echo "selected";?> ><?php echo $rowv[1];?></option>
          <?php
          } while ($rowv = mysqli_fetch_array($resultv));
          } else {
          }
          ?>
    </select>
    </div>
    </div>

    <div class="row">
    <div class="col-md-3"><h4>CARGO:</h4></div>
    <div class="col-md-9"><textarea class="form-control" rows="2" name="cargo_red_salud" required disabled><?php echo $row_l[13];?></textarea></div>
    </div>

<?php } } ?>

<form name="LABORALES" action="mostrar_participante_modlab.php" method="post">

<input type="hidden" name="iddato_laboral" value="<?php echo $row_l[0];?>">
      <div class="row">
        <div class="col-md-4"><h4></h4></div>
        <div class="col-md-8">   
            <button type="submit" class="btn btn-primary">
            ACTUALIZAR DATOS LABORAES
            </button>
        </div>
      </div>
  </form>


<!-- modal de confirmacion de envio de datos-->
</div>


<div class="row">
  <div class="col-md-4"> </div>
  <div class="col-md-4"> </div>
<div class="col-md-4"> </div> 
</div>

</br>
<!-- PIE DE PAGINA --->
</div>
</br>
  </section>
	<footer>
	<?php include("../footer.php");?>
	</footer>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery.js"></script>
<script src="../js/jquery.easing.1.3.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.fancybox.pack.js"></script>
<script src="../js/jquery.fancybox-media.js"></script>
<script src="../js/jquery.flexslider.js"></script>
<script src="../js/animate.js"></script>
<!-- Vendor Scripts -->
<script src="../js/modernizr.custom.js"></script>
<script src="../js/jquery.isotope.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/animate.js"></script>
<script src="../js/custom.js"></script>
<script src="../contact/jqBootstrapValidation.js"></script>
<script src="../contact/contact_me.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/datepicker-es.js"></script>
<script>
    $("#fecha1").datepicker($.datepicker.regional[ "es" ]);
    $("#fecha2").datepicker($.datepicker.regional[ "es" ]);
    $("#fecha3").datepicker($.datepicker.regional[ "es" ]);
</script>
</body>
</html>
