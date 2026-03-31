<?php 
require_once("../../../../clases/fpdf/fpdf.php");
class PDF extends FPDF
{
	//Cabecera de página
	function cabecera_carrera($arreglo_carrera,$fechagrado,$folio_ini)
	{
		$this->row_carrera=$arreglo_carrera;
		$this->fechagrado=$fechagrado;
		$this->folio_ini=$fechagrado;
	}
	function Header()
	{
		$this->PageNo("10");
		$nombrecarrera=strtoupper($this->row_carrera['nombrecarrera']);
		$this->SetFont('Arial','B',10);
		$this->Cell(7);
		$this->Cell(190,6,'FOLIO No. '.$this->contador_paginas(),0,1,'R');
		$this->Cell(7);
		$this->Cell(190,6,'UNIVERSIDAD EL BOSQUE',0,1,'C');
		$this->Cell(7);
		$this->Cell(190,6,'SECRETARIA GENERAL',0,0,'C');
		$this->Ln(10);
		$this->Cell(7);
		$this->Cell(190,6,'REGISTRO DE TITULOS AÑO 2006',0,0,'C');
		$this->Ln(10);
		$this->Cell(7);
		$this->SetFont('Arial','B',8);
		$this->Cell(190,7,"FECHA GRADO: ".$this->fechagrado,1,1,'L');
		$this->Cell(7);
		$this->Cell(190,7,"PROGRAMA: ".$nombrecarrera,1,1,'L');
		$this->Cell(7);
		$this->Cell(190,7,"TITULO: ".$this->row_carrera['nombretitulo'],1,0,'L');
		//Salto de línea
		$this->Ln(12);
	}

	/* //Pie de página
	function Footer()
	{
	//Posición: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Número de página
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	} */
}
?>