<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");

$idusuario_ss = $_SESSION['idusuario_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];

$idnombre_docente_ss = $_SESSION['idnombre_docente_ss'];


$sql_d = " SELECT iddocente, idusuario, idnombre, idnombre_datos, iddato_laboral, ";
$sql_d.= " idresidencia, idestado_docente, fecha_registro FROM docente WHERE idnombre='$idnombre_docente_ss' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);


$sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, nombre.fecha_nac, nombre.idnacionalidad, ";
$sql_n.=" nombre.idgenero, nombre_datos.idformacion_academica, nombre_datos.idprofesion, nombre_datos.idespecialidad_medica, nombre_datos.correo, ";
$sql_n.=" nombre_datos.celular FROM nombre, nombre_datos, usuarios WHERE nombre_datos.idnombre=nombre.idnombre AND  ";
$sql_n.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_d[1]' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);

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
$sqlus =" SELECT nombre, paterno, materno FROM nombre WHERE idnombre='$idnombre_ss'";
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
                <?php include("../menu_academico.php");?>
            </div>
        </div>
	</header><!-- end header -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">REGISTRO DOCENTE</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
        <div class="row">
        <div class="col-md-8"><h2 class="text-danger">NO ES POSIBLE PROCESAR EL REGISTRO:</h2></div>
        <div class="col-md-4"><h2 class="text-danger"></h2></div>
        </div>

        <div class="row">
    <div class="col-md-12"><h4 class="text-danger">EL DOCENTE CON LOS DATOS PERSONALES:</h4></div>
   </div>

<!-- MUESTRA LA PREINSCRIPCION REALIZADA --->
<div class="box-area">

<div class="form-group row">
    <div class="col-sm-4">
    <h4 class="text-danger">PRIMER APELLIDO:</h4>
    <h4 class="text-muted"><?php echo $row_n[1];?></h4>
    </div>
    <div class="col-sm-4">
    <h4 class="text-danger">SEGUNDO APELLIDO:</h4>
    <h4 class="text-muted"><?php echo $row_n[2];?></h4>
    </div>
    <div class="col-sm-4">
    <h4 class="text-danger">NOMBRES:</h4>
    <h4 class="text-muted"><?php echo $row_n[0];?></h4>
    </div>
</div>

    <div class="form-group row">
    <div class="col-sm-4">
    <h4 class="text-danger">CÉDULA DE IDENTIDAD:</h4>
    <h4 class="text-muted"><?php echo $row_n[3];?></h4>
    </div>
    <div class="col-sm-4">
    <h4 class="text-danger">COMPLEMENTO:</h4>
    <h4 class="text-muted"><?php echo $row_n[4];?></h4>
    </div>
    <div class="col-sm-4">
    <h4 class="text-danger">EXPEDICIÓN:</h4>
    <h4 class="text-muted"><?php echo $row_n[5];?></h4>
    </div>
</div>

   <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-10"><h2 class="text-danger">YA SE ENCONTRABA REGISTRADO EN SISTEMA</h2></div>
   </div>

   <form name="FORM9" action="nuevo_docente.php" method="post">
    <div class="row">
      <div class="col-md-4"></div>
       <div class="col-md-8"> 
        <button type="submit" class="btn btn-primary" >
        VOLVER A REGISTRO DOCENTE
        </button>
       </div>
      </div>
    </div>
    </form>

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