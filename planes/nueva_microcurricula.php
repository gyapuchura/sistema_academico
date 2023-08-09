<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
/*
*
* SE REALIZA EL REGISTRO DE UNA NUEVA MICROCURRICULA.
* Desde esta pagina se puede regustrar una nueva microcurriculas.
*
* @idusuario_ss int //variable de sesion de usuario en formato numero entero
* @idnombre_ss int //variable de sesion de nombres y apellidos de usuario en formato numero entero
* @perfil_ss varchar //variable de sesion de perfil de usuario en formato numero entero
*
*/
date_default_timezone_set('America/La_Paz');
$fecha_ram	   = date("Ymd");
$fecha 		   = date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idplan_anual_ss     = $_SESSION['idplan_anual_ss'];
$idobjetivo_anual_ss = $_SESSION['idobjetivo_anual_ss'];
$idmacrocurricula_ss = $_SESSION['idmacrocurricula_ss'];

$sql0 =" SELECT macrocurricula.idmacrocurricula, macrocurricula.codigo, macrocurricula.macrocurricula,  ";
$sql0.=" ambito.ambito, modelo_educativo.modelo_educativo FROM macrocurricula, ambito, modelo_educativo WHERE macrocurricula.idambito=ambito.idambito  ";
$sql0.=" AND macrocurricula.idmodelo_educativo=modelo_educativo.idmodelo_educativo AND macrocurricula.idmacrocurricula='$idmacrocurricula_ss' ";
$result0 = mysqli_query($link,$sql0);
$row0 = mysqli_fetch_array($result0);
$anual = $row0[2];
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
                <?php include("../menu_planes.php");?>
            </div>
        </div>
	</header><!-- end header -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">NUEVA MICROCURRÍCULA </h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
		<div class="row">

    <h4 align="center"><a href="microcurriculas.php">VOLVER</a></h4>
  </div>
  </div>

  <div class="row">
  <div class="col-md-3"> </div>
    <div class="col-md-9"> 
        <h3 class="text-muted"><?php echo $row0[1]?> .- <?php echo $row0[2]?></h3>
    </div>
  </div>
  </div>

</div>

<div class="container">

<!-- javascript --->
<form name="FORM9" action="guarda_microcurricula.php" method="post">

<div class="box-area">

<div class="row">
<div class="col-md-3"><h4>CURSO DE LA ESTRUCTURA CURRICULAR (TEMÁTICA):</h4></div>
  <div class="col-md-5">
        <select name="idtematica"  id="idtematica" class="form-control" required>
        <option value="">ELEGIR</option>
        <?php
        $sql1 = " SELECT idtematica, tematica FROM tematica WHERE idtematica != '1'";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
    </div>  
    <div class="col-md-2"><h4>CARGA HORARIA:</h4></div>
  <div class="col-md-2"><input type="text" class="form-control" name="carga_horaria" required></div>  
  </div>  

  <div class="row">
  <div class="col-md-3"><h4>OBJETIVO DEL CURSO DE CAPACITACIÓN:</h4></div>
  <div class="col-md-9"><textarea class="form-control" rows="3" name="objetivo_curso" required></textarea></div> 
  </div>

  <div class="row">
  <div class="col-md-3"><h4>PREREQUISITO (TEMÁTICA):</h4></div>
  <div class="col-md-9">
  <select name="pre_requisito"  id="pre_requisito" class="form-control" required>
        <option value="">ELEGIR</option>
        <?php
        $sql1 = " SELECT idtematica, tematica FROM tematica ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
  </div> 
  </div>

  <div class="row">
  <div class="col-md-3"><h4>NIVEL CURRICULAR:</h4></div>
  <div class="col-md-3">
  <select name="idnivel_curricular"  id="idnivel_curricular" class="form-control" required>
        <option value="">ELEGIR</option>
        <?php
        $sql1 = " SELECT idnivel_curricular, nivel_curricular FROM nivel_curricular WHERE nivel_curricular != '1'";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
  </select>
  </div> 
  <div class="col-md-3"><h4>TIPO DE EVENTO:</h4></div>
  <div class="col-md-3">
  <select name="idtipo_evento"  id="idtipo_evento" class="form-control" required>
        <option value="">ELEGIR</option>
        <?php
        $sql1 = " SELECT idtipo_evento, tipo_evento FROM tipo_evento ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
  </div> 
  </div>

  <div class="row">
  <div class="col-md-3"><h4>TIPO DE COSTO:</h4></div>
  <div class="col-md-3">
  <select name="idtipo_costo"  id="idtipo_costo" class="form-control" required>
        <option value="">ELEGIR</option>
        <?php
        $sql1 = " SELECT idtipo_costo, tipo_costo FROM tipo_costo ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do {
        echo "<option value=".$row1[0].">".$row1[1]."</option>";
        } while ($row1 = mysqli_fetch_array($result1));
        } else {
        echo "No se encontraron resultados!";
        }
        ?>
        </select>
  </div> 
  <div class="col-md-3"><h4>COSTO DEL CURSO [Bs.]:</h4></div>
  <div class="col-md-3"><input type="text" class="form-control" name="costo" required></div>  
  </div> 
  </div> 
</br></br>

<div class="row">
  <div class="col-md-3"><h4></h4></div>
  <div class="col-md-9">    
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  GUARDAR DATOS DE LA MICRO
  </button>
  </div>
  </div>
</div>
</div>
<!---- --->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">REGISTRO NUEVA MICROCURRICULA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Esta seguro de Registrar la Nueva Microcurricula?
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>     
      </div>
    </div>
  </div>
</div>
</form>

</br>
<div class="row">
<div class="col-md-12">  
</div>
</div>

<!-- javascript --->
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