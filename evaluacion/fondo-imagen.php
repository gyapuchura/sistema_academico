<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
define('FPDF_FONTPATH','font/');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function hoja1()
{	
$this->Image('fondo_certificado_imprimible.png','0','0','210','298','PNG');								
			//IMAGEN (RUTA,X,Y,ANCHO,ALTO,EXTEN)
$this->Ln(35);
$this->SetFont('Arial','B','10');
$this->Cell('150','4','','','','R','');
$this->Ln('25');
$this->Cell('50','4','','','','C','');
$this->SetFont('Arial','B','10');
$this->Cell('120','4',' ','','','C','');
$this->Ln(15);
$this->Cell('170','4','','','','R','');
			
}
}
// fin clase
$pdf=new PDF(); //constructor pdf
$pdf->SetFont('Arial','','10');
$pdf->AddPage();
$pdf->hoja1();
$pdf->Output();
?>