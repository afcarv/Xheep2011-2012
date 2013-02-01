<?php

// funções locais	

/**
* IHC - Marcação de consultas online
* André Fernandes de Carvalho - 2006130976
* Nuno Costa
*/
												
function cartapdf($texto) {
define('FPDF_FONTPATH','../../fpdf/font/');
require('../../fpdf/fpdf.php');
$pdf=new FPDF('P','mm','A4'); 

class PDF extends FPDF 
{ 
//Cabeçalho
function Header() 
{ 
//Logo 
// $this->Image('../../anmp/div2007/xviic/image/logo02.jpg',25,25); 
//Arial bold 15 
// $this->SetFont('Arial','BU',15); 
//Mover para a direita 
// $this->Cell(80); 
//Titulo
// $this->Cell(34,10,'Certificado',0,0,'C'); 
//espessura da linha
// $this->SetLineWidth(0.5);
//cor da linha
// $this->SetDrawColor(0,200,100);
//traçado da linha
// $this->Line(10,25,200,25);
//Line break 
// $this->Ln(20); 
} 

//Rodapé
function Footer() 
{ 
//Posição - 1.5 cm a partir do fundo  
// $this->SetY(-40); 
//Arial italic 8 
// $this->SetFont('times','IU',8); 
//Numero  de página
// $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C'); 
} 
} 

//Instanciação da classe

$pdf->Open(); 
$pdf->AddPage(); 
$pdf->SetMargins(25,25,25);
$pdf->SetTitle ("documento PHP/PDF");
$pdf->SetAuthor("Consultorium");
$pdf->SetSubject('Criação de um documento PDF');

// printf("<IMG SRC=\"/anmp/age/cong/18/images/logos/logo300.png\" ALT=\"ANMP\"  border=0 >");									

// ***** $pdf->Image('/var/www/webp2/anmp/age/cong/18/images/logos/logo300.png',10,10,30,30);
//  $pdf->Image('../../anmp/div2007/xviic/image/logo01.jpg',10,10,245,261);
// $pdf->SetLineWidth(0.5);
// $pdf->SetDrawColor(0,200,200);
// $pdf->Line(10,17,135,17);
// $pdf->Ln(20); 
// $pdf->Image('../../anmp/div2007/xviic/image/logo02.jpg',10,8); 

// $pdf->SetFont('times','BI',25);
// ******$pdf->Image('../../../images/anmp/tema/certif01.png',40,50,120,20); 
// $pdf->Image('../../../images/anmp/tema/certif03.png',50,50,105,56); 
// ******  $pdf->Image('../../../images/anmp/logo/ANMPL1.png',10,235,48,37); 

// a caixa com o título está a ser impressa a partir da imagem 
// $pdf->Cell(40);
// $pdf->SetXY(50,60);
// $pdf->SetFillColor(10,200,250);
// $pdf->SetDrawColor(10,10,10);
// $pdf->Cell(100,20,'Certificado de Presença',5,1,'C',1); 

$pdf->SetXY(50,100); // início do texto
$pdf->ln();
$pdf->SetFont('helvetica','BI',18);
// $texto="Para os devidos efeitos, certifica-se que José Pós-de-Mina, Presidente da Câmara Municipal, Moura, participou no XVII Congresso da Associação Nacional de Municípios Portugueses, nos dias 15 e 16 de Junho de 2007, em Ponta Delgada.";
$pdf->MultiCell(160,10,$texto,0,'J');

// ***** $pdf->Image('../../../images/anmp/logo/ass_AT1.png',80,209,100,45);

$pdf->SetFont('helvetica','I',14);
$texto1="O sistem de consultas on-line";
$pdf->SetXY(97,205);
$pdf->Write(1,$texto1);
$pdf->SetXY(100,223);
$texto2="Curso DEI";
$pdf->Write(1,$texto2);

// $pdf->SetFont('helvetica','',14);
// $texto3="3º texto de teste";
//$pdf->SetY(12);
// $pdf->Write(0.5,$texto3);

$pdf->Output(); 

// $pdf->open();
// $pdf->AliasNbPages(); 
// $pdf->AddPage(); 
// $pdf->SetFont('Times','',12); 
// for($i=1;$i<=15;$i++) 
//	$pdf->Cell(0,5,'A imprimir a linha nº '.$i,0,1); 
//	$pdf->Image('../../anmp/div2007/xviic/image/logo.png',95,50,25,20);
//	$pdf->Output(); 
}

// 														############### 
// 															MAIN


$hoje=date('Y-m-d',time());											
$agora=date('H:i',time());	

$id=  $_REQUEST["id"];
$ut =  $_REQUEST["ut"];
$med =  $_REQUEST["med"];
$esp =  $_REQUEST["esp"];
$dat =  $_REQUEST["dat"];
$sta =  $_REQUEST["sta"];

//$ =  $_REQUEST[""];


		if ( $sta == "UPD") $xr = sprintf("Comprovaivo de Alteração de consulta nº: %s pelo utente %s", $id,$ut);
			else $xr = sprintf("Comprovaivo de marcação de consulta nº: %s pelo utente %s", $id,$ut);
			$xr .= "\n\n Especialidade " . $esp;
			$xr .= "\n\n Médico " . $med;
			$xr .= "\n\n Data da consulta " . $dat;

			cartapdf($xr);

			// cartapdf("Ho ai ó linda");

			// printf("%s",$xr);
	
?>
