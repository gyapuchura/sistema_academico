<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	= date("Y-m-d");
 
$idevento = $_GET['idevento'];

$gestion       = date("Y");

$sql_ev =" SELECT nivel_curricular.nivel_curricular, evento.codigo, tematica.tematica, departamento.departamento, tipo_evento.tipo_evento, modalidad.modalidad,  ";
$sql_ev.=" evento.fecha_inicio, evento.fecha_fin, microcurricula.idtipo_costo, microcurricula.costo, microcurricula.carga_horaria, evento.iddocente ";
$sql_ev.=" FROM evento, microcurricula, nivel_curricular, tematica, departamento, tipo_evento, modalidad WHERE evento.idmicrocurricula=microcurricula.idmicrocurricula ";
$sql_ev.=" AND evento.iddepartamento=departamento.iddepartamento AND microcurricula.idtipo_evento=tipo_evento.idtipo_evento AND evento.idmodalidad=modalidad.idmodalidad ";
$sql_ev.=" AND microcurricula.idnivel_curricular=nivel_curricular.idnivel_curricular AND microcurricula.idtematica=tematica.idtematica AND evento.idevento='$idevento' ";
$result_ev = mysqli_query($link,$sql_ev);
$row_ev = mysqli_fetch_array($result_ev);            

$sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp  ";
$sql_n.=" FROM docente, usuarios, nombre WHERE docente.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre  ";
$sql_n.=" AND docente.iddocente='$row_ev[11]' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);
?>

<!DOCTYPE html>
<head>
<meta content="charset=utf-8">
<title>CERTIFICADO_DE_APROBACION_MSYD</title>
</head>
<body>
<table align="center" width="794"800"" cellspacing="1" cellpadding="1" border="0">
    <tbody background="fondo_certificado_imprimible_docw.png">
        <tr>
            <td>
				<table width="792" border="0">
				  <tbody>
				    <tr>
				      <td><p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p>
			          <p>&nbsp;</p></td>
			        </tr>
				    <tr>
				      <td><table width="790" border="0">
				        <tbody>
				          <tr>
				            <td width="390" style="text-align: right; font-size: 18px; font-family: Arial;">APELLIDO PATERNO:</td>
				            <td width="384" style="font-size: 18px; font-family: Arial;"><strong><?php $paterno = strtoupper($row_n[1]); echo $paterno;?></strong></td>
			              </tr>
				          <tr>
				            <td width="390" style="text-align: right; font-size: 18px; font-family: Arial;">APELLIDO MATERNO:</td>
				            <td style="font-size: 18px; font-family: Arial;"><strong><?php $materno = strtoupper($row_n[2]); echo $materno;?>
				            </strong></td>
			              </tr>
				          <tr>
			                <td width="390" style="text-align: right; font-size: 18px; font-family: Arial;">NOMBRES:</td>
				            <td style="font-family: Arial; font-size: 18px;"><strong><?php $nombres = strtoupper($row_n[0]); echo $nombres;?></strong></td>
			              </tr>
				          <tr>
			                <td width="390" style="text-align: right; font-size: 18px; font-family: Arial;">CÉDULA DE IDENTIDAD:</td>
				            <td style="font-family: Arial; font-size: 18px;"><strong><?php echo $row_n[3];?> <?php echo $row_n[4];?> <?php echo $row_n[5];?></strong></td>
			              </tr>
				          <tr>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
			              </tr>
				          <tr>
				            <td colspan="2" style="font-family: Arial; font-size: 16px;"><div>
				              <div>Por haber impartido el Curso de Formación en la tematica:</div>
			                </div></td>
			              </tr>
				          <tr>
				            <td colspan="2">&nbsp;</td>
			              </tr>
				          <tr>
				            <td colspan="2" style="text-align: center; font-size: 24px; font-family: Arial;"><?php echo $row_ev[2];?></td>
			              </tr>
				          <tr>
				            <td colspan="2">&nbsp;</td>
			              </tr>
				          <tr>
				            <td colspan="2" style="font-size: 16px; font-family: Arial;">Dirigido al nivel <?php echo $row_ev[0];?> y realizado en el Departamento de <?php echo $row_ev[3];?>, en fechas  
							<?php 
								$fecha_i = explode('-',$row_ev[6]);
								$f_inicio    = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
								echo $f_inicio;
								?>
							al 
							<?php 
								$fecha_f = explode('-',$row_ev[7]);
								$f_final = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];
								echo $f_final;
								?>
						 con una carga horaria de <?php echo $row_ev[10];?> Hrs.</td>
			              </tr>
				          <tr>
				            <td colspan="2">&nbsp;</td>
			              </tr>
				          <tr>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
			              </tr>
			            </tbody>
			          </table></td>
			        </tr>
				    <tr>
				      <td><table width="790" border="0">
				        <tbody>
				          <tr>
				            <td width="252">&nbsp;</td>
				            <td width="257">&nbsp;</td>
				            <td width="267">&nbsp;</td>
			              </tr>
				          <tr>
				            <td><p style="text-align: center"><?php
/*
 * Algoritmo para codificacion QR
 *
 * SE emplea el include con el scripti phpqrcode.php
 *
 */
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "../eventos/phpqrcode.php";

    //capturamos el valor de "data"

    $separador='|';
    $tamano='M';

    $_REQUEST['data'] = 'http://192.168.250.253:8888/sistema_academico/evaluacion/imprime_certificado.php?idinscripcion='.$row_i[0];
    $_REQUEST['size'] = 2 ;
    $_REQUEST['level'] = $tamano ;

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);


    $filename = $PNG_TEMP_DIR.'test.png';

    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) {

        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');

        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    } else {

        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>
        <div align="right">';
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    }

echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';

?></p>
            <p style="text-align: center; font-size: 10px; font-family: Arial;">CÓDIGO DE VERIFICACIÓN</p>
			<p style="text-align: center; font-size: 12px; font-family: Arial;"><span style="font-size: 12px">EVENTO :</span><?php echo $row_ev[1];?></p>
            <p style="text-align: center; font-size: 12px; font-family: Arial;">INSCRIPCIÓN : <span style="font-family: Arial"><?php echo $row_i[8];?></span></p>
			                
                        
                        </td>
				            <td>&nbsp;</td>
				            <td><p>&nbsp;</p>
			                <p style="text-align: center; font-size: 16px; font-family: Arial;">RESPONSABLE DE FORMACION MINISTERIO DE SALUD Y DEPORTES</p></td>
			              </tr>
				          <tr>
				            <td>&nbsp;</td>
				            <td style="font-family: Arial; text-align: center; font-size: 14px;"><?php
              $fecha_i = explode('-',$fecha);
              $fecha_form = $fecha_i[2].'-'.$fecha_i[1].'-'.$fecha_i[0];
              ?>

            <?php
              $lugar = strtolower($row_ev[3]);
              $lugar_cap = ucwords($lugar);
              
              echo $lugar_cap;?>, <?php echo $fecha_i[2];?> de <?php 
              
              switch ($fecha_i[1]) {
                case 1:
                    echo "Enero";
                    break;
                case 2:
                    echo "Febrero";
                    break;
                case 3:
                    echo "Marzo";
                    break;
                case 4:
                  echo "Abril";
                  break;
                case 5:
                  echo "Mayo";
                  break;
                case 6:
                  echo "Junio";
                  break;
                case 7:
                  echo "Julio";
                  break;
                case 8:
                  echo "Agosto";
                  break;
                case 9:
                  echo "Septiembre";
                  break;
                case 10:
                  echo "Octubre";
                  break;
                case 11:
                  echo "Noviembre";
                  break;
                case 12:
                  echo "Diciembre";
                  break;
            }              
              ?> de <?php echo $fecha_i[0];?></td>
				            <td>&nbsp;</td>
			              </tr>
				          <tr>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
			              </tr>
				          <tr>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
				            <td>&nbsp;</td>
			              </tr>
			            </tbody>
				        </table></td>
			        </tr>
			      </tbody>
			  </table>
				<p>&nbsp;</p>

            </td>
        </tr>
    </tbody>
</table>
</body>
</html>