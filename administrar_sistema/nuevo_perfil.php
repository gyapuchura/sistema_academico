<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 		  = date("Y-m-d");
$gestion      = date("Y");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idusuario_mod_ss = $_SESSION['idusuario_mod_ss'];
$idnombre_mod_ss  = $_SESSION['idnombre_mod_ss'];

$sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, ";
$sql_n.=" nombre.fecha_nac, nombre.idnacionalidad, nombre.idgenero, nombre.idnombre, usuarios.usuario FROM nombre, usuarios ";
$sql_n.=" WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario_mod_ss' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);


$sql_c =" SELECT  nombre_datos.idnombre_datos, nombre_datos.idformacion_academica, nombre_datos.idprofesion,  ";
$sql_c.=" nombre_datos.idespecialidad_medica, nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, ";
$sql_c.=" nombre_datos.iddepartamento FROM nombre, nombre_datos, usuarios WHERE nombre_datos.idnombre=nombre.idnombre  ";
$sql_c.=" AND usuarios.idusuario=nombre_datos.idusuario AND nombre.idnombre='$idnombre_mod_ss' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, ";
$sql_l.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ";
$sql_l.= " FROM dato_laboral WHERE idnombre='$idnombre_mod_ss' ORDER BY iddato_laboral DESC LIMIT 1";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

if($_SESSION['perfil_ss'] != "ADMINISTRADOR"){ 		
	header("Location:../salir.php");	
}

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
            <p class="pull-right"><i class="fa fa-user"></i>
                <?php
                    $sqlus = "SELECT nombre, paterno, materno FROM nombre WHERE idnombre='$idnombre_ss'";
                    $resultus = mysqli_query($link,$sqlus);
                    $rowus = mysqli_fetch_array($resultus);
                ?>
            <?php echo $rowus[0];?> <?php echo $rowus[1];?> <?php echo $rowus[2];?></p>
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
                <?php include("../menu_planes.php");?>
            </div>
        </div>
	</header><!-- end header -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">NUEVO PERFIL DE USUARIO</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
	  <div class="row">
		<div class="tg-main-section tg-banner tg-haslayout parallax-window" data-parallax="scroll" data-bleed="100" data-speed="0.2" data-image-src="images/slider/img-03.jpg">
          <h4 align="center"><a href="mostrar_usuario.php">VOLVER</a></h4>
        </div>
      </div>

    <div class="row">
    <div class="col-md-8"><h3>CREAR UN NUEVO PERFIL DE USUARIO:</h3></div>
    <div class="col-md-4"></div>
    </div>
<!-- javascript --->
<div class="box-area">

<div class="form-group row">
    <div class="col-sm-3 mb-3 mb-sm-0">
    <h4>NOMBRES:</h4>
    <input type="text" class="form-control" name="nombre" placeholder="Nombres" 
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El nombre con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[0];?>" disabled/>
    </div>
    <div class="col-sm-3">
    <h4>PRIMER APELLIDO:</h4>
    <input type="text" class="form-control" name="paterno" placeholder="Paterno" 
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El apellido paterno con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[1];?>"  disabled/>
    </div>
    <div class="col-sm-3">
    <h4>SEGUNDO APELLIDO:</h4>
    <input type="text" class="form-control" name="materno" placeholder="Materno"
    required pattern="^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$" 
    title="El apellido materno con Mayúscula al inicio y minúsculas despues." value="<?php echo $row_n[2];?>" disabled/>
    </div>
    <div class="col-sm-3">
    <h4>FECHA DE NACIMIENTO:</h4>
    <input type="text" id="fecha1" class="form-control" name="fecha_nac" value="<?php 
        $fecha_n = explode('-',$row_n[6]);
        $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
        echo $fecha_nac;
        ?>" disabled> 
    </div>
    </div>

    <div class="form-group row">

    <div class="col-sm-2 mb-3 mb-sm-0">
    <h4>CÉDULA DE ID:</h4>
    <input type="text" class="form-control" name="ci" placeholder="N° de CI"
    required pattern="[A-Z0-9_-]{5,12}$" 
    title="El numero de CI solo puede contener DIGITOS numéricos." value="<?php echo $row_n[3];?>"  disabled>
    </div>
    <div class="col-sm-2 mb-3 mb-sm-0">
    <h4>COMPLEMENTO:</h4>
    <input type="text" class="form-control" name="complemento" placeholder="COMPLEMENTO" value="<?php echo $row_n[4];?>" disabled>
    </div>
    <div class="col-sm-2">
    <h4>EXPEDICIÓN:</h4>
          <select name="exp"  id="exp" class="form-control" disabled >
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
          <select name="idnacionalidad"  id="idnacionalidad" class="form-control" disabled >
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
    <select name="idgenero"  id="idgenero" class="form-control" disabled >
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
  

</div>

<div class="row">
<div class="col-md-6"><h3>NUEVO PERFIL:</h3></div>
<div class="col-md-6"></div>
</div>

<div class="box-area">

<form name="PERFIL" action="guarda_perfil_usuario.php" method="post">

<input type="hidden" name="idnombre_user" value="<?php echo $row_n[9];?>">
<input type="hidden" name="user" value="<?php echo $row_n[10];?>">
<input type="hidden" name="idnombre_datos" value="<?php echo $row_c[0];?>">
<input type="hidden" name="iddato_laboral" value="<?php echo $row_l[0];?>">
<input type="hidden" name="idresidencia" value="<?php echo $row_l[10];?>">


<div class="row">
<div class="col-md-12"><h4>IMPORTANTEL:</h4><h4 class="text-muted">EL NOMBRE DE USUARIO SE CREARA CON EL SUFIJO "-A", "-P" o "-D" SEGUN LO SIGUIENTE:</h4></div> 
</div>

<div class="row">
<div class="col-md-4"><h4 class="text-muted">  -A = ADMINISTRADOR</h4></div>
<div class="col-md-4"><h4 class="text-muted">  -D = DOCENTE</h4></div>
<div class="col-md-4"><h4 class="text-muted">  -P = PARTICIPANTE</h4></div> 
</div>
</div>
        </br>  </br>
<div class="box-area">
<div class="row">
<div class="col-md-3"><h4></h4></div>
<div class="col-md-3"><h4>NUEVO PERFIL:</h4></div>
<div class="col-md-3">
<select size="1" name="perfil" id="perfil" class="form-control" required>
        <option value="">Seleccione</option>
        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
        <option value="DOCENTE">DOCENTE</option>
        <option value="PARTICIPANTE">PARTICIPANTE</option>
    </select>    
</div>
<div class="col-md-3"><h4></h4></div>
</div>

<div class="row">
<div class="col-md-3"><h4></h4></div>
<div class="col-md-3"><h4>PASSWORD:</h4></div>
<div class="col-md-3"><input type="password" class="form-control" name="new_password" required> </div>
<div class="col-md-3"><h4></h4></div>
</div>
<div class="row">
<div class="col-md-3"><h4></h4></div>
<div class="col-md-3"><h4>REPETIR PASSWORD:</h4></div>
<div class="col-md-3"><input type="password" class="form-control" name="new_password_rep" required> </div>
<div class="col-md-3"><h4></h4></div>
</div> 

</div>
    </br>
    <div class="row">
        <div class="col-md-4"><h4></h4></div>
        <div class="col-md-8">    
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            CREAR NUEVO PERFIL
            </button>
        </div>
        </div>
    </div>

<!-- modal de confirmacion de envio de datos-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">REGISTRO NUEVO PERFIL DE USUARIO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta seguro de registrar al nuevo perfil de usuario?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
      </div>
    </div>
  </div>
</div>
</div>

</div>
</form>
<!-- Modal -->

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
</script>

</body>
</html>