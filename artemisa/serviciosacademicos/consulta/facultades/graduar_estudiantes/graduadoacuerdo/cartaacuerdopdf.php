<?php 
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");

require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/DatosGenerales.php");
require_once("../../../../funciones/sala_genericas/DatosGenerales.php");

define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require_once('../../../../funciones/clases/fpdf/fpdf.php');
require_once("../../../../funciones/sala_genericas/extensionfpdf.php");

$objetobase=new BaseDeDatosGeneral($sala);


//$fila["textotipoacuerdograduado"]="<table><tr><td><estilopie>
//<B>ACUERDO No <numeroacuerdograduado> de <anio></B>
//<br>Por el cual se otorga el titulode <tituloacuerdograduado>
// a <cantidadnombreestudiante> estudiantes de postgrado</estilopie>
//<br><br><br><b><h3> ACUERDO No <numeroacuerdograduado> de <anio> </h3></b><br>Por el cual se otorga el titulode <tituloacuerdograduado> a <cantidadnombreestudiante> estudiantes de postgrado<br><br><br>...<b><h3> CONSIDERANDO</h3></b> <br><br>Que la división de postgrados y Formación Avanzada recomendó otorgar el título de <tituloacuerdograduado> a los siguientes doctores.<br><br>...<b><h3> ACUERDA </h3></b><br><br>Otorgar los siguientes titulos.... el dia <fechaacuerdograduado></td></tr></table>";
//$fila["pietextotipoacuerdograduado"]="<B>ACUERDO No <numeroacuerdograduado> de <anio></B><br><br>Por el cual se otorga el titulo de <tituloacuerdograduado> a <cantidadnombreestudiante> estudiantes de postgrado";
//$objetobase->actualizar_fila_bd("tipoacuerdograduado",$fila,"idtipoacuerdograduado",1,"",1);

$datosacuerdograduado=$objetobase->recuperar_datos_tabla("acuerdograduado","codigoacuerdograduado",$_GET["codigoacuerdograduado"]);
$condicion=" and e.codigoestudiante=da.codigoestudiante and
			 e.idestudiantegeneral=eg.idestudiantegeneral and
			 c.codigocarrera=e.codigocarrera and da.codigoestado=100 
			 order by c.nombrecarrera,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";
$tabla="detalleacuerdograduado da, estudiante e, estudiantegeneral eg, carrera c";

$operaciondetalleacuerdo=$objetobase->recuperar_resultado_tabla($tabla,"da.codigoacuerdograduado",$datosacuerdograduado["codigoacuerdograduado"],$condicion,"",0);
$i=0;$j=0;
$tmpcarrera="";
while($row=$operaciondetalleacuerdo->fetchRow()){
if($tmpcarrera!=$row["nombrecarrera"]){
	$i=0;
	$tmpcarrera=$row["nombrecarrera"];
}

$matrizdatos[$row["nombrecarrera"]][$i][]=strtoupper($row["apellidosestudiantegeneral"]." ".$row["nombresestudiantegeneral"]);
$longitudes[]=25;		$titulos[]="NOMBRE";
$matrizdatos[$row["nombrecarrera"]][$i][]=strtoupper($row["numerodocumento"]." ".$row["expedidodocumento"]);
$longitudes[]=20;		$titulos[]="CEDULA";
$i++;
$j++;
}
$cantidadestudiantes=convercionnumerotexto("$j")." ($j)";

$datostipoacuerdograduado=$objetobase->recuperar_datos_tabla("tipoacuerdograduado","idtipoacuerdograduado",$datosacuerdograduado["idtipoacuerdograduado"]);
$anio=substr($datosacuerdograduado["fechaacuerdograduado"],0,4);

//echo $datostipoacuerdograduado["textotipoacuerdograduado"];
$fechaacuerdograduado=fechaatextofecha(formato_fecha_defecto($datosacuerdograduado["fechaacuerdograduado"]));
$fechaactaacuerdograduado=fechaatextofecha(formato_fecha_defecto($datosacuerdograduado["fechaactaacuerdograduado"]));

$html=$datostipoacuerdograduado["textotipoacuerdograduado"];
$html=str_replace("<anio>",$anio,$html);
$html=str_replace("<numeroacuerdograduado>",$datosacuerdograduado["numeroacuerdograduado"],$html);
$html=str_replace("<tituloacuerdograduado>",$datostipoacuerdograduado["tituloacuerdograduado"],$html);
$html=str_replace("<fechaacuerdograduado>",$fechaacuerdograduado,$html);
$html=str_replace("<fechaactaacuerdograduado>",$fechaactaacuerdograduado,$html);
$html=str_replace("<numeroactaacuerdograduado>",$datosacuerdograduado["numeroactaacuerdograduado"],$html);
$html=str_replace("<cantidadnombreestudiante>",$cantidadestudiantes,$html);

$pie=$datostipoacuerdograduado["pietextotipoacuerdograduado"];
$pie=str_replace("<anio>",$anio,$pie);
$pie=str_replace("<numeroacuerdograduado>",$datosacuerdograduado["numeroacuerdograduado"],$pie);
$pie=str_replace("<tituloacuerdograduado>",$datostipoacuerdograduado["tituloacuerdograduado"],$pie);
$pie=str_replace("<fechaacuerdograduado>",$fechaacuerdograduado,$pie);
$pie=str_replace("<fechaactaacuerdograduado>",$fechaactaacuerdograduado,$pie);
$pie=str_replace("<numeroactaacuerdograduado>",$datosacuerdograduado["numeroactaacuerdograduado"],$pie);
$pie=str_replace("<cantidadnombreestudiante>",$cantidadestudiantes,$pie);


$hoja="Letter";
$pdf=new PDF('P','mm',$hoja);
$pdf->AddPage();
$pdf->SetTopMargin('55');

$pdf->SetLeftMargin('20');
$pdf->SetRightMargin('20');

$pdf->SetFont('Arial','',10);
$pdf->Ln(40);
$pdf->WriteHTML($html,5);
foreach($matrizdatos as $carrera => $matriz){
//$pdf->Ln(5);
//$pdf->SetFont('','U');
$pdf->SetFont('','BU');
//$pdf->celda(170,5,$carrera,0,'L',1,0);
$tituloprincipaltabla[0]=170;
$tituloprincipaltabla[1]=5;
$tituloprincipaltabla[2]=$carrera.":";
$tituloprincipaltabla[3]=0;
$tituloprincipaltabla[4]='L';
$tituloprincipaltabla[5]=1;
$tituloprincipaltabla[6]=0;
$tituloprincipaltabla[7]='BU';
$tituloprincipaltabla[8]='';
$tituloprincipaltabla[9]='';
$tituloprincipaltabla[10]=10;

$pdf->SetFont('','');
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->cargarmatrizcampos($matriz,$longitudes,$titulos,$tituloprincipaltabla,$pie,5,10);
$pdf->crearlineas();
}
//$pdf->celda(170,4,$pdf->w.",".$pdf->h,0,'C',1,0);
$condicion=" and (NOW() between fechainiciodirectivo and fechavencimientodirectivo)
			 and cargodirectivo like  '%presidente%'
			  and cargodirectivo like  '%consejo%'
			  and cargodirectivo like  '%directivo%'";
$tabla="directivo d";

$datospresidentefirma=$objetobase->recuperar_datos_tabla($tabla,"d.codigotipodirectivo",100,$condicion,"",0);
$condicion=" and (NOW() between fechainiciodirectivo and fechavencimientodirectivo)
			  and cargodirectivo like  '%secretario%'
			  and cargodirectivo like  '%consejo%'
			  and cargodirectivo like  '%directivo%'";
$tabla="directivo d";
$datossecretariofirma=$objetobase->recuperar_datos_tabla($tabla,"d.codigotipodirectivo",100,$condicion,"",0);

$nombrepresidente=$datospresidentefirma["nombresdirectivo"]." ".$datospresidentefirma["apellidosdirectivo"];
$nombresecretario=$datossecretariofirma["nombresdirectivo"]." ".$datossecretariofirma["apellidosdirectivo"];


$anchomedio= ($pdf->w - $pdf->lMargin - $pdf->rMargin)/2;
$condicion=" and c.idciudad=u.idciudad";
$datosuniversidad=$objetobase->recuperar_datos_tabla("ciudad c,universidad u","iduniversidad",1,$condicion,"",0);

$fechatexto=fechaatextofechadias(date("d/m/Y"));

$umbraldebajo=$pdf->obtenerumbraldebajo(5);
$Y_ini=$pdf->GetY();
if(50>($umbraldebajo-$Y_ini)){
$pdf->AddPage();
$pdf->Pie(2,50,23,$pie);
$pdf->SetFont('Arial','',10);
}
$pdf->Ln(5);
$pdf->Ln(5);
$textofirmafecha="Dado en ".$datosuniversidad["nombreciudad"]." a los ".$fechatexto;
$pdf->celda($anchomedio*2,5,$textofirmafecha,0,'L',1,0);
$pdf->Ln(5);
$pdf->Ln(5);
$textofirmafecha="NOTIFÍQUESE,COMUNIQUESE Y CUMPLASE";
$pdf->celda($anchomedio*2,5,$textofirmafecha,0,'L',1,0);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->celda($anchomedio,5,$nombrepresidente,0,'L',1,0);
$pdf->celda($anchomedio,5,$nombresecretario,$anchomedio,'L',1,0);
$pdf->Ln(5);
$pdf->celda($anchomedio,5,$datospresidentefirma["cargodirectivo"],0,'L',1,0);
$pdf->celda($anchomedio,5,$datossecretariofirma["cargodirectivo"],$anchomedio,'L',1,0);
$pdf->Output();

?>