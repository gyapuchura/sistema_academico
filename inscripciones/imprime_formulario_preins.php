<?php
require('../fpdf/fpdf.php');
class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $this->Image('logo.png',62,10,80);
   }

function Footer()
{

$this->SetY(-10);

$this->SetFont('Arial','I',8);

$this->Cell(0,10,'Pagina '.$this->PageNo().'',0,0,'C');

}
}
//---- CODIGO PHP PARA GENERAR DATOS DE INSCRIPCION -----//

include("../inc.config.php");

date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha   	= date("Y-m-d");

$idinscripcion = $_GET['idinscripcion'];

//---- CONECTAR CON $_GET['idinscripcion'] ----//
$gestion = date("Y");

$sql_i = " SELECT idinscripcion, idevento, idusuario, idnombre, idnombre_datos, iddato_laboral, idestado_inscripcion, ";
$sql_i.= " correlativo, codigo, fecha_preins, fecha_ins, gestion FROM inscripcion WHERE idinscripcion='$idinscripcion' ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, ";
$sql_l.= " idministerio, iddireccion, idarea, cargo_mds, iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row_i[5]' ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_n =" SELECT nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.complemento, nombre.exp, nombre.fecha_nac, nacionalidad.nacionalidad, ";
$sql_n.=" genero.genero, formacion_academica.formacion_academica, profesion.profesion, especialidad_medica.especialidad_medica, nombre_datos.correo, ";
$sql_n.=" nombre_datos.celular, nombre_datos.idprofesion, nombre_datos.idespecialidad_medica FROM nombre, nombre_datos, usuarios, nacionalidad, genero, formacion_academica, profesion, especialidad_medica ";
$sql_n.=" WHERE nombre_datos.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero AND ";
$sql_n.=" usuarios.idnombre=nombre.idnombre AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica AND ";
$sql_n.=" nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
$sql_n.=" AND usuarios.idusuario ='$row_i[2]' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);

$nombre_completo = mb_strtoupper($row_n[0].' '.$row_n[1].' '.$row_n[2]);

$fecha_nac    = explode('-',$row_n[6]);
$f_nacimiento = $fecha_nac[2].'/'.$fecha_nac[1].'/'.$fecha_nac[0];

$sql_ev =" SELECT nivel_curricular.nivel_curricular, evento.codigo, tematica.tematica, departamento.departamento, tipo_evento.tipo_evento, modalidad.modalidad, evento.fecha_inicio, evento.fecha_fin, microcurricula.idtipo_costo, microcurricula.costo ";
$sql_ev.=" FROM evento, microcurricula, nivel_curricular, tematica, departamento, tipo_evento, modalidad WHERE evento.idmicrocurricula=microcurricula.idmicrocurricula ";
$sql_ev.=" AND evento.iddepartamento=departamento.iddepartamento AND microcurricula.idtipo_evento=tipo_evento.idtipo_evento AND evento.idmodalidad=modalidad.idmodalidad ";
$sql_ev.=" AND microcurricula.idnivel_curricular=nivel_curricular.idnivel_curricular AND microcurricula.idtematica=tematica.idtematica AND evento.idevento='$row_i[1]' ";
$result_ev = mysqli_query($link,$sql_ev);
$row_ev = mysqli_fetch_array($result_ev);

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

    $_REQUEST['data'] = 'Código:'.$row_i[8].' Nombre:'.$row_n[0].' '.$row_n[1].' '.$row_n[2].' Evento:'.$row_ev[1].'-'.$row_ev[2];
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
//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

$pdf->Image($PNG_WEB_DIR.basename($filename),174,235,27);

$pdf->Cell(192,25,'',0,1,'C');

$pdf->Cell(192,10,mb_convert_encoding('FORMULARIO DE PREINSCRIPCIÓN','iso-8859-1','utf-8'),0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(192,10,$row_i[8],0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('I. DATOS PERSONALES','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);
$pdf->Cell(86,5,mb_convert_encoding('NÚMERO DE DOCUMENTO DE IDENTIDAD C.I.','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[3].' '.$row_n[4].' '.$row_n[5],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('NOMBRE COMPLETO DEL SOLICITANTE:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($nombre_completo,'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('FECHA DE NACIMIENTO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($f_nacimiento ,'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('TIPO DE NACIONALIDAD:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[7],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('GÉNERO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[8],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('FORMACIÓN ACADÉMICA:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[9],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('PROFESIÓN / OCUPACIÓN:','iso-8859-1','utf-8'),1,0,'L');
$profesion_user = mb_strtoupper($row_n[10]);
$pdf->Cell(106,5,mb_convert_encoding($profesion_user,'iso-8859-1','utf-8'),1,1,'L');

if ($row_n[14] == '1') {
    $sql_e =" SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica = '$row_n[15]' ";
    $result_e = mysqli_query($link,$sql_e);
    $row_e = mysqli_fetch_array($result_e);

    $pdf->Cell(86,5,mb_convert_encoding('ESPECIALIDAD MÉDICA:','iso-8859-1','utf-8'),1,0,'L');
    $pdf->Cell(106,5,mb_convert_encoding($row_e[1],'iso-8859-1','utf-8'),1,1,'L');
} else {  }

$pdf->Cell(86,5,mb_convert_encoding('CORREO ELECTRÓNICO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[12],'iso-8859-1','utf-8'),1,1,'L');
$pdf->Cell(86,5,mb_convert_encoding('Nº DE CELULAR:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(106,5,mb_convert_encoding($row_n[13],'iso-8859-1','utf-8'),1,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('II. DATOS LABORALES','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);

$sql_dep =" SELECT iddependencia, dependencia FROM dependencia WHERE iddependencia = '$row_l[3]' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);
$pdf->Cell(64,5,mb_convert_encoding('TIPO DE DEPENDENCIA:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(128,5,mb_convert_encoding($row_dep[1],'iso-8859-1','utf-8'),1,1,'L');

if ($row_l[3] == '1') {
    $pdf->Cell(64,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');

    $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
    $result_d = mysqli_query($link,$sql_d);
    $row_d = mysqli_fetch_array($result_d);
    $pdf->Cell(128,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

    $pdf->Cell(64,5,mb_convert_encoding('ENTIDAD A LA QUE PERTENECE:','iso-8859-1','utf-8'),1,0,'L');
    $entidad_publica = mb_strtoupper($row_l[4]); 
    $pdf->MultiCell(128,5,mb_convert_encoding($entidad_publica,'iso-8859-1','utf-8'),'LTRB','L',false);
    $pdf->Cell(64,5,mb_convert_encoding('CARGO QUE OCUPA:','iso-8859-1','utf-8'),1,0,'L');
    $cargo_entidad = mb_strtoupper($row_l[5]);
    $pdf->MultiCell(128,5,mb_convert_encoding($cargo_entidad,'iso-8859-1','utf-8'),'LTRB','L',false);

//  cargo_entidad

} else {
    if ($row_l[3] == '2') {
        $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
        $result_d = mysqli_query($link,$sql_d);
        $row_d = mysqli_fetch_array($result_d);
        
        $pdf->Cell(64,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->Cell(128,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

        $sql_r =" SELECT idministerio, ministerio FROM ministerio WHERE idministerio = '$row_l[6]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);

        $pdf->Cell(64,5,mb_convert_encoding('INSTANCIA:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($row_r[1],'iso-8859-1','utf-8'),'LTRB','L',false);

        $sql_r =" SELECT iddireccion, direccion FROM direccion WHERE iddireccion = '$row_l[7]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);
        $direccion_general = mb_strtoupper($row_r[1]);

        $pdf->Cell(64,5,mb_convert_encoding('DIRECCIÓN GENERAL:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($direccion_general,'iso-8859-1','utf-8'),'LTRB','L',false);

        $sql_r =" SELECT idarea, area FROM area WHERE idarea = '$row_l[8]' ";
        $result_r = mysqli_query($link,$sql_r);
        $row_r = mysqli_fetch_array($result_r);
        $unidad_area = mb_strtoupper($row_r[1]);
   
        $pdf->Cell(64,5,mb_convert_encoding('UNIDAD ORGANIZACIONAL:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($unidad_area,'iso-8859-1','utf-8'),'LTRB','L',false);
        $cargo_salud = mb_strtoupper($row_l[9]);

        $pdf->Cell(64,5,mb_convert_encoding('CARGO:','iso-8859-1','utf-8'),1,0,'L');
        $pdf->MultiCell(128,5,mb_convert_encoding($cargo_salud,'iso-8859-1','utf-8'),'LTRB','L',false);
        
// variable $cargo_salud

    } else {
        if ($row_l[3] == '3') {

            $sql_d =" SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento = '$row_l[10]' ";
            $result_d = mysqli_query($link,$sql_d);
            $row_d = mysqli_fetch_array($result_d);
            $pdf->Cell(64,5,mb_convert_encoding('DEPARTAMENTO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->Cell(128,5,mb_convert_encoding($row_d[1],'iso-8859-1','utf-8'),1,1,'L');

            $sql_r =" SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud = '$row_l[11]' ";
            $result_r = mysqli_query($link,$sql_r);
            $row_r = mysqli_fetch_array($result_r);    
            $pdf->Cell(64,5,mb_convert_encoding('RED DE SALUD:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(128,5,mb_convert_encoding($row_r[1],'iso-8859-1','utf-8'),'LTRB','L',false);

            $sql_s =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud = '$row_l[12]' ";
            $result_s = mysqli_query($link,$sql_s);
            $row_s = mysqli_fetch_array($result_s);
            $pdf->Cell(64,5,mb_convert_encoding('ESTABLECIMIENTO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(128,5,mb_convert_encoding($row_s[1],'iso-8859-1','utf-8'),'LTRB','L',false);

            $cargo_red = mb_strtoupper($row_l[13]);
            $pdf->Cell(64,5,mb_convert_encoding('CARGO:','iso-8859-1','utf-8'),1,0,'L');
            $pdf->MultiCell(128,5,mb_convert_encoding($cargo_red,'iso-8859-1','utf-8'),'LTRB','L',false);
        } else {        
        }       
    }   
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(192,8,mb_convert_encoding('III. DATOS DEL EVENTO DE CAPACITACIÓN','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',9);
$pdf->Cell(96,5,mb_convert_encoding('NIVEL:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(96,5,mb_convert_encoding($row_ev[0],'iso-8859-1','utf-8'),1,1,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(96,5,mb_convert_encoding('CÓDIGO DEL EVENTO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(96,5,mb_convert_encoding($row_ev[1],'iso-8859-1','utf-8'),1,1,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(96,5,mb_convert_encoding('CURSO (TEMÁTICA):','iso-8859-1','utf-8'),1,0,'L');
$pdf->MultiCell(96,5,mb_convert_encoding($row_ev[2],'iso-8859-1','utf-8'),'LTRB','L',false);
$pdf->Cell(96,5,mb_convert_encoding('LUGAR:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(96,5,mb_convert_encoding($row_ev[3],'iso-8859-1','utf-8'),1,1,'L');

$pdf->Cell(48,5,mb_convert_encoding('TIPO DE CURSO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(48,5,mb_convert_encoding($row_ev[4],'iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(48,5,mb_convert_encoding('MODALIDAD:','iso-8859-1','utf-8'),1,0,'L');
$pdf->Cell(48,5,mb_convert_encoding($row_ev[5],'iso-8859-1','utf-8'),1,1,'L');

$fecha_i = explode('-',$row_ev[6]);
$f_inicio    = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
$pdf->SetFont('Arial','B',9);
$pdf->Cell(48,5,mb_convert_encoding('FECHA DE INICIO:','iso-8859-1','utf-8'),1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(48,5,mb_convert_encoding($f_inicio,'iso-8859-1','utf-8'),1,0,'L');
$fecha_f = explode('-',$row_ev[7]);
$f_final = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];
$pdf->SetFont('Arial','B',9);
$pdf->Cell(48,5,mb_convert_encoding('FECHA DE FINALIZACIÓN:','iso-8859-1','utf-8'),1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(48,5,mb_convert_encoding($f_final,'iso-8859-1','utf-8'),1,1,'L');

if ($row_ev[8] != '1') {
    $pdf->Cell(96,5,mb_convert_encoding('MONTO TOTAL A CANCELAR:','iso-8859-1','utf-8'),1,0,'C');
    $pdf->Cell(96,5,mb_convert_encoding($row_ev[9].' Bs.','iso-8859-1','utf-8'),1,1,'C');
} else {
}
$pdf->SetFont('Arial','B',9);
$pdf->Cell(96,5,mb_convert_encoding('FECHAS:','iso-8859-1','utf-8'),1,0,'C');
$pdf->Cell(96,5,mb_convert_encoding('HORARIOS:','iso-8859-1','utf-8'),1,1,'C');

$sqlf =" SELECT horario.inicio, horario.fin, horario.hora_i, horario.hora_f FROM horario, aula";
$sqlf.=" WHERE horario.idaula=aula.idaula AND horario.idevento='$row_i[1]' ";
$resultf = mysqli_query($link,$sqlf);
if ($rowf = mysqli_fetch_array($resultf)){
mysqli_field_seek($resultf,0);
while ($fieldf = mysqli_fetch_field($resultf)){
} do {

    $fecha_del = explode('-',$rowf[0]);
    $f_del    = $fecha_del[2].'/'.$fecha_del[1].'/'.$fecha_del[0];

    $fecha_al = explode('-',$rowf[1]);
    $f_al    = $fecha_al[2].'/'.$fecha_al[1].'/'.$fecha_al[0];

    $pdf->SetFont('Arial','',9);
$pdf->Cell(96,5,mb_convert_encoding($f_del.' al '.$f_al,'iso-8859-1','utf-8'),1,0,'C');
$pdf->Cell(96,5,mb_convert_encoding($rowf[2].' a '.$rowf[3],'iso-8859-1','utf-8'),1,1,'C');
}
while ($rowf = mysqli_fetch_array($resultf));
} else {
}

$fecha_i = explode('-',$row_i[10]);
$fecha_form = $fecha_i[2].'-'.$fecha_i[1].'-'.$fecha_i[0];
$lugar = strtolower($row_ev[3]);
$lugar_cap = ucwords($lugar);

switch ($fecha_i[1]) {
    case 1:
        $mes_preins = "Enero";
        break;
    case 2:
        $mes_preins = "Febrero";
        break;
    case 3:
        $mes_preins = "Marzo";
        break;
    case 4:
      $mes_preins = "Abril";
      break;
    case 5:
      $mes_preins = "Mayo";
      break;
    case 6:
      $mes_preins = "Junio";
      break;
    case 7:
      $mes_preins = "Julio";
      break;
    case 8:
      $mes_preins = "Agosto";
      break;
    case 9:
      $mes_preins = "Septiembre";
      break;
    case 10:
      $mes_preins = "Octubre";
      break;
    case 11:
      $mes_preins = "Noviembre";
      break;
    case 12:
      $mes_preins = "Diciembre";
      break;
}              

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,8,mb_convert_encoding('Nota:','iso-8859-1','utf-8'),0,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(86,8,mb_convert_encoding('El contenido de la Información registrada en el presente formulario es de entera responsabilidad del solicitante.','iso-8859-1','utf-8'),0,1,'L');

$pdf->SetFont('Arial','',8);
$pdf->Cell(48,6,mb_convert_encoding('Lugar y Fecha de Preinscripción:','iso-8859-1','utf-8'),0,0,'L');
$pdf->Cell(48,6,mb_convert_encoding($lugar_cap.' '.$fecha_i[2].' de '.$mes_preins.' de '.$fecha_i[0],'iso-8859-1','utf-8'),0,0,'L');
$pdf->Cell(96,6,mb_convert_encoding('','iso-8859-1','utf-8'),0,1,'C');

$pdf->Cell(96,6,mb_convert_encoding('','iso-8859-1','utf-8'),0,1,'C');

$pdf->Output();
?>

