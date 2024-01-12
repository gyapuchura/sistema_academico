<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram			= date("Ymd");
$fecha 			    = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

if($_SESSION['perfil_ss'] != "PARTICIPANTE"){ 		
	header("Location:../index.php");	
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>MINISTERIO DE SALUD Y DEPORTES</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />

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
	</header>
    <!-- end header -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">EVENTOS DEL PARTICIPANTE</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">

	<div class="container">
		<div class="row">
		<div class="tg-main-section tg-banner tg-haslayout parallax-window" data-parallax="scroll" data-bleed="100" data-speed="0.2" data-image-src="images/slider/img-03.jpg">
		</div>
   	<div class="about-logo">
      <h3>USUARIO:</h3>
      <h3 class="text-muted"><?php echo $rowus[0];?> <?php echo $rowus[1];?> <?php echo $rowus[2];?></h3>   
       <p>EN ESTA SECCIÓN SE REALIZA EL SEGUIMIENTO A LA EVALUACIÓN DE EVENTOS DEL PARTICIPANTE.</p>
    </div>
    </div>
    
<div class="container">
</div>
<!--- GESTION DE EMPRESAS ---->

<div class="table-responsive">
      <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nª</th>
                    <th>CÓDIGO EVENTO</th>
                    <th>EVENTO</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA FINALIZACIÓN</th>
                    <th>DOCENTE</th>
                    <th>CÓDIGO INSCRIPCIÓN</th>
                    <th>NOTA FINAL</th>
                    <th>OBSERVACIÓN</th>
                    <th>EMITIR CERTIFICADOS</th>
                </tr>
            </thead>
			<tbody>
            <?php
            $numero=1;
            $sql =" SELECT evento.idevento, evento.codigo, tematica.tematica, evento.fecha_inicio, evento.fecha_fin, evento.iddocente, evento.idestado_ejecucion, inscripcion.idinscripcion, ";
            $sql.=" inscripcion.nota_final, inscripcion.idcomentario_evaluacion, inscripcion.codigo, comentario_evaluacion.comentario_evaluacion FROM evento, microcurricula, tematica, inscripcion, comentario_evaluacion ";
            $sql.=" WHERE inscripcion.idevento=evento.idevento AND evento.idmicrocurricula=microcurricula.idmicrocurricula AND microcurricula.idtematica=tematica.idtematica AND ";
            $sql.=" inscripcion.idcomentario_evaluacion=comentario_evaluacion.idcomentario_evaluacion AND inscripcion.idusuario='$idusuario_ss' ORDER BY evento.idevento ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>
				<tr>
				<td><?php echo $numero;?></td>
                <td><?php echo $row[1];?></td>
				<td><?php echo $row[2];?></td>
                <td>
                    <?php 
                    $fecha_i = explode('-',$row[3]);
                    $f_inicio    = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
                    echo $f_inicio;
                    ?>            
                </td>
                <td>
                    <?php 
                    $fecha_f = explode('-',$row[4]);
                    $f_final = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];
                    echo $f_final;
                    ?>   
                </td>
                <td><?php 
                $sqld =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM evento, docente, nombre, usuarios WHERE evento.iddocente=docente.iddocente ";
                $sqld.=" AND docente.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre   ";
                $sqld.=" AND docente.iddocente='$row[5]' ";
                $resultd = mysqli_query($link,$sqld);
                $rowd = mysqli_fetch_array($resultd);
                ?>
                <?php echo $rowd[0];?> <?php echo $rowd[1];?> <?php echo $rowd[2];?>    
                </td>
                <td><?php echo $row[10];?></td>
                <td> <?php echo $row[8];?> </td>
                <td> 
                <?php  if ($row[8] >= '71') { echo '<p class="text-success">'; } else { echo '<p class="text-danger">'; } ?>     
                <?php echo $row[11];?></p>            
                </td>
                <td>     
                <?php  if ($row[9] == '4') { ?>
                <a href="imprime_certificado_aprob.php?idinscripcion=<?php echo $row[7];?>" target="_blank">IMPRIMIR CERTIFICADO</a>                    
                <?php } else { ?>
                       
                    <?php  } ?>  
                </td>
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

<!--- gestion de usuarios ---->

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