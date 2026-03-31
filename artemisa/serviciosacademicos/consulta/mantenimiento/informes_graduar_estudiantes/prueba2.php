<?php
ini_set("include_path", ".:/usr/share/pear_");
require_once('../clases/fpdf/fpdf.php');
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
$query_registrograduado="SELECT idregistrograduado, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS nombre,
eg.numerodocumento, c.nombrecarrera, rg.numeroactaregistrograduado, rg.numerodiplomaregistrograduado
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
$contador=0;
while($row_registrograduado=$registrograduado->fetchRow())
{
	$data[$contador]=array($row_registrograduado['idregistrograduado'],$row_registrograduado['nombre'],'3','4');
	$contador=$contador+1;
}

class PDF extends FPDF
{
//Tabla coloreada
function FancyTable($header,$data)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
    $w=array(8,80,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();
//Títulos de las columnas
$header=array('No.','Nombre Estudiante','Superficie (km2)','Pobl. (en miles)');
//Carga de datos
//$data=$pdf->LoadData('paises.txt');

$pdf->SetFont('Arial','',8);
/* $pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
 */$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();

?> 
