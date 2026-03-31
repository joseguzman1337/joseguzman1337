<?php
setlocale(LC_ALL,'es_ES');
require_once("../../../../clases/fpdf/fpdf.php");
require_once('datos_basicos_graduados.php');
require_once("imprimir_array.php");
require_once("cabecerafolio.php");
define('FPDF_FONTPATH','../../../../clases/fpdf/font/');
$fechainicial=$_GET['fechainicial'];
$fechafinal=$_GET['fechafinal'];
$ano=substr($fechainicial,0,4);
$estudiante_graduado=new estudiante_graduado($sala);
$row_lista_estudiantes_graduados=$estudiante_graduado->obtener_listado_estudiantes_graduados($_GET['fechainicial'],$_GET['fechafinal']);
//print_r($row_lista_estudiantes_graduados);
$row_directivo=$estudiante_graduado->obtener_directivo_secgeneral();
//$arreglo_estudiantes_separados=$estudiante_graduado->separar_listado_estudiantes_graduados();
?>
<?php
$pdf=new PDF('P','mm','Letter',1);
$pdf->SetTopMargin(7);
$pdf->SetAutoPageBreak(true,25);
//$pdf->SetFont('Arial','B',8);
$pdf->cabecera_carrera($ano,$row_directivo);
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$codigocarrera_ini="";
$numeropromocion_ini="";
$numeroacta_ini="";
$numeroacuerdo_ini="";
$fechagrado_ini="";
$contador=-1;
$contador_limite=count($row_lista_estudiantes_graduados);
$contador_busca_incentivos=0;
$array_acumulativo=0;
//echo $contador_limite;
foreach ($row_lista_estudiantes_graduados as $clave => $valor)
{
	if(
	$valor['codigocarrera']!=$codigocarrera_ini or
	$valor['numeropromocion']!=$numeropromocion_ini or
	$valor['numeroacta']!=$numeroacta_ini or
	$valor['numeroacuerdo']!=$numeroacuerdo_ini
	)
	{
		$array_contador_cambios[$contador]=$contador;
		$codigocarrera_ini=$valor['codigocarrera'];
		$numeropromocion_ini=$valor['numeropromocion'];
		$numeroacta_ini=$valor['numeroacta'];
		$numeroacuerdo_ini=$valor['numeroacuerdo'];
		//echo "CONTADOR:",$contador,"   ",$array_contador_cambios[$contador],"  ",$valor['idregistrograduado'],"<br><br>";
	}
	$array_contador[]=$contador;
	$contador++;

}
reset($row_lista_estudiantes_graduados);
foreach ($row_lista_estudiantes_graduados as $clave => $valor)
{
	if(
	$valor['codigocarrera']!=$codigocarrera_ini or
	$valor['numeropromocion']!=$numeropromocion_ini or
	$valor['numeroacta']!=$numeroacta_ini or
	$valor['numeroacuerdo']!=$numeroacuerdo_ini)
	{
		$buscarincentivos=true;
		$promocion=strtoupper($valor['numeropromocion']);
		$row_carreras_grados=$estudiante_graduado->obtener_datos_carreras_grados($valor['codigocarrera']);
		$titulo=strtoupper($row_carreras_grados['nombretitulo']);
		$carrera=strtoupper($row_carreras_grados['nombrecarrera']);
		$pdf->Cell(7);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,7,"PROGRAMA: ".$carrera,1,1,'C');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(7);
		$pdf->Cell(190,7,"TITULO: ".$titulo,1,1,'L');
		$pdf->Cell(7);
		$pdf->Cell(45,7,"PROMOCION:".$promocion,1,0,'L');
		$pdf->Cell(50,7,"ACTA: ".$valor['numeroacta']."   FECHA: ".$valor['fechaacta'],1,0,'L');
		$pdf->Cell(55,7,"ACUERDO: ".$valor['numeroacuerdo']."  FECHA: ".$valor['fechaacuerdo'],1,0,'L');
		$pdf->Cell(40,7,"FECHA GRADO: ".$valor['fechagrado'],1,1,'L');
		$row_incentivoacademico_2=$estudiante_graduado->obtener_incentivos_academicos_2($valor['codigocarrera'],$valor['numeropromocion'],$valor['numeroacta'],$valor['numeroacuerdo']);
		$row_incentivoacademico_3=$estudiante_graduado->obtener_incentivos_academicos_3($valor['codigocarrera'],$valor['numeropromocion'],$valor['numeroacta'],$valor['numeroacuerdo']);
		//print_r($row_incentivoacademico_1);echo "<br><br>";print_r($row_incentivoacademico_2);
	}
	else
	{
		$buscarincentivos=false;
	}
	$pdf->Cell(7);
	$expedicion=strtoupper($valor['expedicion']);
	if($valor['codigoestado']==200)
	{
		$pdf->Cell(15,7,"ANULADO",1,0,'C');
		$pdf->Cell(90,7,"ANULADO",1,0,'L');
		$pdf->Cell(20,7,"ANULADO",1,0,'C');
		$pdf->Cell(45,7,"ANULADO",1,0,'C');
		$pdf->Cell(20,7,"ANULADO",1,1,'C');
	}
	else
	{
		$pdf->Cell(15,7,$valor['idregistrograduado'],1,0,'C');
		$pdf->Cell(90,7,$valor['nombre'],1,0,'L');
		$pdf->Cell(20,7,$valor['documento'],1,0,'C');
		$pdf->Cell(45,7,$expedicion,1,0,'C');
		$pdf->Cell(20,7,$valor['diploma'],1,1,'C');
	}
	if($array_contador_cambios[$contador_busca_incentivos]!="")//$array_contador_cambios[$contador_busca_incentivos]!=""
	{
		$row2=count($row_incentivoacademico_2);
		$row3=count($row_incentivoacademico_3);
		if($row2!=0 or $row3!=0)
		{
			error_reporting(0);
			$pdf->Ln(4);
			$pdf->SetFont('Arial','B',10);
			//$pdf->Ln(4);
			$pdf->Cell(7);
			$pdf->Cell(95,6,"Mención de Honor:",0,0,'C');
			$pdf->Cell(95,6,"Grado de Honor:",0,1,'C');
			$pdf->SetFont('Arial','',8);
			$y_ini=$pdf->GetY();
			/******************imprime incentivos*************************/
			foreach ($row_incentivoacademico_2 as $llave=> $valorllave)
			{
				$pdf->Cell(7);
				$pdf->Cell(95,6,$valorllave['nombre'],0,1,'C');
			}
			$y_fin=$pdf->GetY();
			$pdf->setY($y_ini);
			foreach ($row_incentivoacademico_3 as $llave=> $valorllave)
			{
				$pdf->Cell(102);
				$pdf->Cell(95,6,$valorllave['nombre'],0,1,'C');
			}
			$pdf->setY($y_fin);

			/******************imprime incentivos*************************/
		}

	}
	//unset ($row_incentivoacademico_rango);
	$codigocarrera_ini=$valor['codigocarrera'];
	$numeropromocion_ini=$valor['numeropromocion'];
	$numeroacta_ini=$valor['numeroacta'];
	$numeroacuerdo_ini=$valor['numeroacuerdo'];
	$contador_busca_incentivos++;
}
$pdf->Output();
?>