<?php
define('FPDF_FONTPATH','font/');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function hoja1()
{	
$this->Image('fondo_certificado_imprimible.png','0','0','210','298','PNG');								
			//IMAGEN (RUTA,X,Y,ANCHO,ALTO,EXTEN)

            include("../inc.config.php");
            date_default_timezone_set('America/La_Paz');
            $fecha_ram	= date("Ymd");
            $fecha 	= date("Y-m-d");
             
            $idinscripcion = $_GET['idinscripcion'];
            
            // ---- cambiar a: $_GET['idinscripcion']; -----//
            
            $gestion = date("Y");
            
            $sql_i = " SELECT idinscripcion, idevento, idusuario, idnombre, idnombre_datos, iddato_laboral, idestado_inscripcion, ";
            $sql_i.= " correlativo, codigo, fecha_preins, fecha_ins, gestion, nota_final FROM inscripcion WHERE idinscripcion='$idinscripcion' ";
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
            
            $sql_ev =" SELECT nivel_curricular.nivel_curricular, evento.codigo, tematica.tematica, departamento.departamento, tipo_evento.tipo_evento, modalidad.modalidad, evento.fecha_inicio, evento.fecha_fin, microcurricula.idtipo_costo, microcurricula.costo, microcurricula.carga_horaria ";
            $sql_ev.=" FROM evento, microcurricula, nivel_curricular, tematica, departamento, tipo_evento, modalidad WHERE evento.idmicrocurricula=microcurricula.idmicrocurricula ";
            $sql_ev.=" AND evento.iddepartamento=departamento.iddepartamento AND microcurricula.idtipo_evento=tipo_evento.idtipo_evento AND evento.idmodalidad=modalidad.idmodalidad ";
            $sql_ev.=" AND microcurricula.idnivel_curricular=nivel_curricular.idnivel_curricular AND microcurricula.idtematica=tematica.idtematica AND evento.idevento='$row_i[1]' ";
            $result_ev = mysqli_query($link,$sql_ev);
            $row_ev = mysqli_fetch_array($result_ev);
            
            $paterno = mb_convert_encoding(mb_strtoupper($row_n[1]),'iso-8859-1','utf-8');
            $materno = mb_convert_encoding(mb_strtoupper($row_n[2]),'ISO-8859-1','UTF-8');
            $nombre  = mb_convert_encoding(mb_strtoupper($row_n[0]),'ISO-8859-1','UTF-8');

            $fecha_i = explode('-',$row_ev[6]);
            $f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];
            
            $fecha_f = explode('-',$row_ev[7]);
            $f_final = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

            $lugar = strtolower($row_ev[3]);
            $lugar_cap = ucwords($lugar);

            $fecha_i = explode('-',$row_i[10]);
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
$this->Cell('190','10',mb_convert_encoding(' Por haber obtenido la calificación correspondiente a: ','iso-8859-1','utf-8'),'0','1','C','');

// ------ Begin Convertir numeros a literal ------- //
$nota_final_literal = number_format($row_i[12], 2, '.', '.');
$cantidad = $row_i[12];

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el l�mite a 6 d�gitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya lleg� al l�mite m�ximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres d�gitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres d�gitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es n�mero redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Mill�n, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aqu� si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma l�gica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta l�nea la puedes cambiar de acuerdo a tus necesidades o a tu pa�s -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO $xdecimales/100 ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN  $xdecimales/100  ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " $xdecimales/100  "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para M�xico se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta funci�n regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

// END FUNCTION


// ------ End Convertir numeros a literal ------- //

$this->Cell('190','10',$nota_final_literal.' - '.numtoletras($cantidad).' puntos.','0','1','C','');
$this->SetFont('Arial','','14');
$this->Cell('190','10', mb_convert_encoding('En el curso de capacitación:','iso-8859-1','utf-8'),'0','1','C','');
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
$this->Cell('95','5',mb_convert_encoding('Dr. Daniel Castañon Clavijo','iso-8859-1','utf-8'),'0','1','C','');
$this->Cell('95','5','EVENTO: '.$row_ev[1],'0','0','C','');
$this->Cell('95','5',mb_convert_encoding('RESPONSABLE DE CAPACITACIÓN PERMANENTE','iso-8859-1','utf-8'),'0','1','C','');
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

    $_REQUEST['data'] = 'http://192.168.250.134:8888/sistema_academico/evaluacion/imprime_certificado.php?idinscripcion='.$row_i[0];
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

$this->Image($PNG_WEB_DIR.basename($filename),40,215,34);

			
}
}
// fin clase
$pdf=new PDF(); //constructor pdf
$pdf->SetFont('Arial','','10');
$pdf->AddPage();
$pdf->hoja1();
$pdf->Output();
?>