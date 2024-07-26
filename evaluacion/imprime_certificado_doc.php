<?php include("../cabf.php");?>
<?php
define('FPDF_FONTPATH','font/');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function hoja1()
{	
$this->Image('fondo_certificado_imprimible_doc.png','0','0','210','298','PNG');								
			//IMAGEN (RUTA,X,Y,ANCHO,ALTO,EXTEN)

            include("../inc.config.php");
            date_default_timezone_set('America/La_Paz');
            $fecha_ram	= date("Ymd");
            $fecha 	= date("Y-m-d");
             
            $idevento = $_GET['idevento'];
            
            // ---- cambiar a: $_GET['idinscripcion']; -----//
            
            $gestion = date("Y");

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
        
            
            $paterno = mb_convert_encoding(mb_strtoupper($row_n[1]),'iso-8859-1','utf-8');
            $materno = mb_convert_encoding(mb_strtoupper($row_n[2]),'ISO-8859-1','UTF-8');
            $nombre  = mb_convert_encoding(mb_strtoupper($row_n[0]),'ISO-8859-1','UTF-8');

            $fecha_i = explode('-',$row_ev[6]);
            $f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
            
            $fecha_f = explode('-',$row_ev[7]);
            $f_final = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

            $lugar = strtolower($row_ev[3]);
            $lugar_cap = ucwords($lugar);

            $fecha_i = explode('-',$fecha);
            $fecha_form = $fecha_i[2].'-'.$fecha_i[1].'-'.$fecha_i[0];

            switch ($fecha_i[1]) {
                case 1:
                    $mes = 'Enero';
                    break;
                case 2:
                    $mes = 'Febrero';
                    break;
                case 3:
                    $mes = 'Marzo';
                    break;
                case 4:
                  $mes = 'Abril';
                  break;
                case 5:
                  $mes = 'Mayo';
                  break;
                case 6:
                  $mes = 'Junio';
                  break;
                case 7:
                  $mes = 'Julio';
                  break;
                case 8:
                  $mes = 'Agosto';
                  break;
                case 9:
                  $mes = 'Septiembre';
                  break;
                case 10:
                  $mes = 'Octubre';
                  break;
                case 11:
                  $mes = 'Noviembre';
                  break;
                case 12:
                  $mes = 'Diciembre';
                  break;
            } 

$this->Ln(76);
$this->SetFont('Arial','','14');
$this->Cell('95','10','APELLIDO PATERNO:','0','0','R','');
$this->SetFont('Arial','B','14');
$this->Cell(95,10,$paterno,0,1,'L','');
$this->SetFont('Arial','','14');
$this->Cell(95,10,'APELLIDO MATERNO:',0,0,'R','');
$this->SetFont('Arial','B','14'); 
$this->Cell('95','10',$materno,'0','1','L','');
$this->SetFont('Arial','','14');
$this->Cell('95','10','NOMBRE:','0','0','R','');
$this->SetFont('Arial','B','14');
$this->Cell('95','10',$nombre,'0','1','L','');
$this->SetFont('Arial','','14');
$this->Cell('95','10', mb_convert_encoding('CÉDULA DE IDENTIDAD','iso-8859-1','utf-8'),'0','0','R','');
$this->SetFont('Arial','B','14');
$this->Cell('95','10',$row_n[3].' '.$row_n[4].' '.$row_n[5],'0','1','L','');

$this->Ln(5);
$this->SetFont('Arial','','14');
$this->Cell('190','10',mb_convert_encoding(' Por haber impartido el Curso de Formación en la tematica: ','iso-8859-1','utf-8'),'0','1','C','');

// ------ Begin Convertir numeros a literal ------- //



// ------ End Convertir numeros a literal ------- //


$this->Ln(5);
$this->SetFont('Arial','B','18');
$this->Cell('190','10',mb_convert_encoding($row_ev[2],'iso-8859-1','utf-8'),'0','1','C','');

$this->Ln(5);
$this->SetFont('Arial','','14');
$this->Cell('190','10',mb_convert_encoding('Dirigido al nivel '.$row_ev[0],'iso-8859-1','utf-8'),'0','1','C','');
$this->Cell('190','10',mb_convert_encoding('Realizado en el Departamento de '.$row_ev[3],'iso-8859-1','utf-8'),'0','1','C','');
$this->Cell('190','10',mb_convert_encoding('Del '.$f_inicio.' al '.$f_final.' con una carga horaria de '.$row_ev[10].' Hrs.','iso-8859-1','utf-8'),'0','1','C','');

$this->Cell('95','38','','0','0','C','');
$this->Cell('95','38','','0','1','C','');

$this->SetFont('Arial','','8');
$this->Cell('95','5',mb_convert_encoding('CÓDIGO DE VERIFICACIÓN','iso-8859-1','utf-8'),'0','0','C','');
$this->SetFont('Arial','','8');
$this->Cell('95','5',mb_convert_encoding('Dr. Daniel Castañon Espinoza','iso-8859-1','utf-8'),'0','1','C','');
$this->Cell('95','5','EVENTO: '.$row_ev[1],'0','0','C','');
$this->Cell('95','5',mb_convert_encoding('RESPONSABLE DE FORMACIÓN-SAFCI','iso-8859-1','utf-8'),'0','1','C','');
$this->Cell('95','5',$row_i[8],'0','0','C','');
$this->Cell('95','5','MINISTERIO DE SALUD Y DEPORTES','0','1','C','');

$this->SetFont('Arial','','12');
$this->Cell('190','12',$lugar_cap.', '.$fecha_i[2].' de '.$mes.' de '.$fecha_i[0],'0','0','C','');

// ----- generamos el codigo QR desde BAse de datos ---- //
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

    $_REQUEST['data'] = 'http://'.$_SERVER['HTTP_HOST'].'/evaluacion/imprime_certificado_docw.php?idevento='.$idevento;
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


//--- incrustamos el codigo QR ------//

$this->Image($PNG_WEB_DIR.basename($filename),40,194,34);

			
}
}
// fin clase
$pdf=new PDF(); //constructor pdf
$pdf->SetFont('Arial','','10');
$pdf->AddPage();
$pdf->hoja1();
$pdf->Output();
?>