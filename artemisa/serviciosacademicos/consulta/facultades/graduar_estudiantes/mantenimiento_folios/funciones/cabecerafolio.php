<?php 
class PDF extends FPDF
{
	//Cabecera de página
	function cabecera_carrera($ano,$array_directivo)
	{
		//echo "<h1>",$ano,"</h1>";
		$this->ano=$ano;
		$this->array_directivo=$array_directivo;
	}
	function Header()
	{
		$nombrecarrera=strtoupper($this->row_carrera['nombrecarrera']);
		$this->SetFont('Arial','B',10);
		$this->Cell(7);
		$this->Cell(190,5,'FOLIO No. '.$this->PageNo(),0,1,'R');
		$this->Cell(7);
		$this->Ln(6);
		$this->Cell(7);
		$this->Cell(190,6,"REGISTRO DE TITULOS AÑO ".$this->ano,0,0,'C');
		$this->Ln(8);
		$this->Cell(7);
		$this->SetFont('Arial','B',8);
		$this->Cell(15,10,'REG. No',1,0,'C');
		$this->Cell(90,10,'NOMBRE DEL GRADUADO',1,0,'C');
		$this->Cell(65,5,'DOCUMENTO DE IDENTIDAD',1,1,'C');
		$this->Cell(112);
		$this->Cell(20,5,'NUMERO',1,0,'C');
		$this->Cell(45,5,'LUGAR DE EXPEDICION',1,0,'C');
		$this->SetXY(187, 26);
		$this->Cell(20,10,'No. DIPLOMA',1,1,'C');
		$this->Ln(4);
	}

	//Pie de página
	function Footer()
	{
	$this->SetY(255);
	$this->SetFont('Arial','B',8);
	$nombre=strtoupper($this->array_directivo['nombre']);
	$cargodirectivo=strtoupper($this->array_directivo['cargodirectivo']);
	$this->Cell(7);
	$this->Cell(190,5,$nombre,0,1,'R');
	$this->Cell(7);
	$this->Cell(190,5,$cargodirectivo,0,0,'R');
	}
}
?>