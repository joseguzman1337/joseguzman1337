<?php
ini_set("include_path", ".:/usr/share/pear_");
require_once('../clases/fpdf/fpdf.php');
require_once('../clases/fpdf/tablas.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$fecha=$_GET['fecha'];
$query_registrograduado="SELECT idregistrograduado, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
eg.numerodocumento, c.nombrecarrera AS Programa, rg.numeroactaregistrograduado AS 'No. Acta', rg.numerodiplomaregistrograduado AS 'No. Diploma'
FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c
WHERE 
rg.codigoestado = '100' AND
rg.codigoautorizacionregistrograduado='100' AND
rg.fechaautorizacionregistrograduado LIKE '$fecha%' AND
rg.codigoestudiante=e.codigoestudiante AND
e.idestudiantegeneral=eg.idestudiantegeneral AND
e.codigocarrera=c.codigocarrera
";
//echo $query_registrograduado;
$registrograduado=$sala->query($query_registrograduado);
$pdf=new FPDF('P','mm','letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(12,3,'Reg No.',1,0,C);
$pdf->Cell(60,3,'Nombre del graduado',1,0,C);
$pdf->Cell(14,3,'Documento Identidad',1,1,C);
while($row_registrograduado=$registrograduado->fetchRow())
{
	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]]) 
	$id=$row_registrograduado['idregistrograduado'];
	$nombre=$row_registrograduado['nombre'];
	$numerodocumento=$row_registrograduado['numerodocumento'];
	$pdf->Cell(12,3,$id,1,0,C);
	$pdf->Cell(60,3,$nombre,1,0,C);
	$pdf->Cell(14,3,$numerodocumento,1,0,C);
	$pdf->Cell(14,3,'',1,1,C);
}
$pdf->Output();
?> 