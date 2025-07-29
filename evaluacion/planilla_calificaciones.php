<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=LISTA DE INSCRITOS.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = date("Y");

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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>REPORTE DE CALIFICACIONES MDSYD</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">REPORTE DE CALIFICACIONES</h3>
  <h2 style="font-family: Arial; text-align: center; font-size: 18px;">EVENTO : <?php echo $codigo_evento_ss;?></h2>
  <h2 style="font-family: Arial; text-align: center; font-size: 18px;"><?php echo $row0[0];?></h2>
  <table width="900" border="1" cellspacing="0" align="center">
	  <tbody>
          <tr>
            <td width="26" style="font-size: 10px; text-align: center;"><strong>N°</strong></td>
            <td width="93" style="font-size: 10px; text-align: center;"><strong>CÓDIGO DE INSCRIPCIÓN</strong></td>
            <td width="86" style="font-size: 11px; text-align: center;"><strong>CÉDULA DE IDENTIDAD</strong></td>
            <td width="77" style="font-size: 11px; text-align: center;"><strong>NOMBRES</strong></td>
            <td width="99" style="font-size: 11px; text-align: center;"><strong>AP. PATERNO</strong></td>
            <td width="85" style="font-size: 11px; text-align: center;"><strong>AP. MATERNO</strong></td>
            <td width="300" style="font-size: 11px" align="center"><strong>CARGO</strong></td>
            <td width="120" style="font-size: 11px" align="center"><strong>DEPARTAMENTO</strong></td>
            <td width="69" style="font-size: 11px; text-align: center;"><strong>NOTA FINAL</strong></td>
            <td width="69" style="font-size: 11px; text-align: center;"><strong>OBSERVACIÓN</strong></td>

          </tr>
    <?php
$numero=1;
$sql =" SELECT inscripcion.codigo, nombre.ci, nombre.complemento, nombre.exp, nombre.paterno, nombre.materno, nombre.nombre, nombre_datos.correo,  ";
$sql.=" nombre_datos.celular, departamento.departamento, dato_laboral.iddependencia, inscripcion.nota_final, comentario_evaluacion.comentario_evaluacion, dato_laboral.iddato_laboral ";
$sql.=" FROM inscripcion, nombre, nombre_datos, dato_laboral, departamento, comentario_evaluacion WHERE inscripcion.idnombre=nombre.idnombre ";
$sql.=" AND inscripcion.idnombre_datos=nombre_datos.idnombre_datos AND  inscripcion.iddato_laboral=dato_laboral.iddato_laboral AND inscripcion.idcomentario_evaluacion=comentario_evaluacion.idcomentario_evaluacion ";
$sql.=" AND dato_laboral.iddepartamento=departamento.iddepartamento AND inscripcion.idevento='$idevento_ss' AND inscripcion.idestado_inscripcion='2' ORDER BY inscripcion.codigo ";
$result = mysqli_query($link,$sql);
if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
    ?>
        <tr>
        <td style="font-size: 11px; text-align: center;"><?php echo $numero;?></td>
        <td style="font-size: 10px; text-align: center;"><?php echo $row[0];?></td>
        <td style="font-size: 10px"><?php echo $row[1];?> <?php echo $row[2];?><span style="text-align: center"></span></td>
        <td style="font-size: 10px; text-align: center;"><?php echo mb_strtoupper($row[6]);?></td>
        <td style="text-align: center; font-size: 10px;"><?php echo mb_strtoupper($row[4]);?></td>
        <td style="text-align: center; font-size: 10px;"><?php echo mb_strtoupper($row[5]);?></td>
        <td style="font-size: 10px; text-align: center;"><?php 
        $sql_c =" SELECT cargo_entidad, cargo_mds, cargo_red_salud FROM dato_laboral WHERE iddato_laboral='$row[13]' ";
        $result_c = mysqli_query($link,$sql_c);
        $row_c = mysqli_fetch_array($result_c);
                if ($row[10] == '1') {
                    echo mb_strtoupper($row_c[0]);
                } else {
                    if ($row[10] == '2') {
                        echo mb_strtoupper($row_c[1]);
                    } else {
                        if ($row[10] == '3') {
                            echo mb_strtoupper($row_c[2]);
                        } else { } } } ?></td>
        <td style="font-size: 10px; text-align: center;"><?php echo $row[9];?></td>
        <td style="font-size: 10px; text-align: center;"><?php echo $row[11];?></td>
        <td style="font-size: 10px; text-align: center;"><?php echo $row[12];?></td>
        </tr>
		<?php
$numero = $numero+1; 
}
  while ($row = mysqli_fetch_array($result));
} else {
  echo " ";
}
?>
      </tbody>
    </table>
 <p>&nbsp;</p>
  <table width="282" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="184" style="font-family: Arial; font-style: 10px;">APROBADOS</td>
      <td width="88" style="font-family: Arial; font-style: 10px; text-align: center;">
      <?php
        $sql_ap =" SELECT idinscripcion FROM inscripcion WHERE idevento='$idevento_ss' AND idcomentario_evaluacion='4' AND idestado_inscripcion ='2'  ";
        $result_ap = mysqli_query($link,$sql_ap);
        $row_ap = mysqli_num_rows($result_ap);    
        echo $row_ap;
      ?>
      </td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-style: 10px;">REPROBADOS</td>
      <td style="font-family: Arial; font-style: 10px; text-align: center;">
        <?php
        $sql_rep =" SELECT idinscripcion FROM inscripcion WHERE idevento='$idevento_ss' AND idcomentario_evaluacion='3' AND idestado_inscripcion ='2' ";
        $result_rep = mysqli_query($link,$sql_rep);
        $row_rep = mysqli_num_rows($result_rep);    
        echo $row_rep;
        ?>
      </td>
    </tr>
    <tr>
      <td style="font-family: Arial; font-style: 10px;">NO SE PRESENTARON</td>
      <td style="font-family: Arial; font-style: 10px; text-align: center;">
        <?php
        $sql_np =" SELECT idinscripcion FROM inscripcion WHERE idevento='$idevento_ss' AND idcomentario_evaluacion='2' AND idestado_inscripcion ='2'";
        $result_np = mysqli_query($link,$sql_np);
        $row_np = mysqli_num_rows($result_np);    
        echo $row_np;
        ?>
      </td>
    </tr>
        <tr>
      <td style="font-family: Arial; font-style: 10px;">TOTAL</td>
      <td style="font-family: Arial; font-style: 10px; text-align: center;">
        <?php
        $sql_t =" SELECT idinscripcion FROM inscripcion WHERE idevento='$idevento_ss' AND idestado_inscripcion ='2' ";
        $result_t = mysqli_query($link,$sql_t);
        $row_t = mysqli_num_rows($result_t);    
        echo $row_t;
        ?>
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</body>
</html>
