<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram			= date("Ymd");
$fecha 			    = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idevento_ss      = $_SESSION['idevento_ss'];
$codigo_evento_ss = $_SESSION['codigo_evento_ss'];

$sql0 =" SELECT tematica.tematica FROM evento, microcurricula, tematica WHERE evento.idmicrocurricula=microcurricula.idmicrocurricula  ";
$sql0.=" AND microcurricula.idtematica=tematica.idtematica AND evento.idevento='$idevento_ss' ";
$result0 = mysqli_query($link,$sql0);
$row0 = mysqli_fetch_array($result0);

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
<link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
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
$rowus = mysqli_fetch_array($resultus);?>
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
				<h2 class="pageTitle">CERTIFICACIÓN</h2>
			</div>
		</div>
	</div>
	</section>

	<section id="content">
	<div class="container">
		<div class="row">
		<div class="tg-main-section tg-banner tg-haslayout parallax-window" data-parallax="scroll" data-bleed="100" data-speed="0.2" data-image-src="images/slider/img-03.jpg">
        <h4 align="center"><a href="certificacion_eventos.php">VOLVER</a></h4>
        <h2 align="center"><?php echo $codigo_evento_ss;?></h2>
        <h2 align="center"><?php echo $row0[0];?></h2>
		</div>
    </div>

<div class="container">
        <div class="row">
        <div class="col-lg-12"><h2>PARTICIPANTES CON CERTIFICADO DE APROBACIÓN</h2></div>
        </div>
<!--- REGISTRO DE PRE-INSCRITOS ---->

<div class="table-responsive">
      <table class="table table-bordered" id="example" width="100%" cellspacing="0">
     
            <thead>
                <tr>
                    <th>Nª</th>
                    <th>CÓDIGO INSCRIPCIÓN</th>
                    <th>CEDULA DE IDENTIDAD</th>
                    <th>PATERNO</th>
                    <th>MATERNO</th>
                    <th>NOMBRES</th>
                    <th>VER CERTIFICADO</th>
                    <th>NOTA FINAL</th>
                    <th>IMPRIMIR PDF</th>
                    <th>OBSERVACIÓN</th>
                </tr>
            </thead>
			<tbody>
            <?php
            $numero=1;
            $sql =" SELECT inscripcion.idinscripcion, inscripcion.codigo, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, inscripcion.nota_final, inscripcion.nota_final, ";
            $sql.=" comentario_evaluacion.comentario_evaluacion, inscripcion.idcomentario_evaluacion FROM inscripcion, nombre, comentario_evaluacion WHERE inscripcion.idnombre=nombre.idnombre AND inscripcion.idestado_inscripcion='2' ";
            $sql.=" AND inscripcion.idcomentario_evaluacion=comentario_evaluacion.idcomentario_evaluacion AND inscripcion.idevento='$idevento_ss' ORDER BY inscripcion.idinscripcion ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>
				<tr>
				<td><?php echo $numero;?></td>
                <td><?php echo $row[1];?></td>
				<td><?php echo $row[2];?> <?php echo $row[3];?></td>
                <td><?php echo $row[4];?></td>
                <td><?php echo $row[5];?></td>
                <td><?php echo $row[6];?></td>
                <td>
                <a href="imprime_certificado.php?idinscripcion=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=920,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                <?php if ($row[10] == '4') { echo "CERTIFICADO"; } else { }?></a>
                </td>                
                <td>
                 <?php  if ($row[7] >= '71') { echo '<p class="text-success">'; } else { echo '<p class="text-danger">'; } ?>  
                <?php echo $row[7]?></p></td>
                <td> 
                <a href="imprime_certificado_aprob.php?idinscripcion=<?php echo $row[0];?>" target="_blank">
                <?php if ($row[10] == '4') { echo "IMPRIMIR EN PDF"; } else { }?></a>
                </td>
                <td>
                <?php  if ($row[7] >= '71') { echo '<p class="text-success">'; } else { echo '<p class="text-danger">'; } ?>     
                <?php echo $row[9];?></p></td>
               
                </tr>  
            <?php
            $numero=$numero+1;  
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>

        </tbody>
    </table>
</div>

    <div class="row">
        <div class="col-lg-3">
        </br>
            <a href="imprime_reporte_calificaciones.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=980,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                IMPRIME REPORTE DE CALIFICACIONES</a>
        </div>
        <div class="col-lg-3">

        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3">
        <form name="INSCRITOS" action="planilla_calificaciones.php" method="post">
        <h3><button type="submit" class="btn btn-link">REPORTE DE CALIFICACIONES EN EXCEL</button></h3>
        </form>
        </div> 
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
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
</body>
</html>