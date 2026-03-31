<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

session_start();

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit();*/

require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
require_once("funciones/ObtenerDatos.php");
require_once('../../materiasgrupos/contenidoprogramatico/tcpdf/tcpdf.php');

$codigocarrera = $_SESSION['codigocarrera'];
$codigoperiodo = $_SESSION['codigoperiodo_seleccionado'];
$codigomodalidad=$_SESSION['codigomodalidadacademica'];

if($codigomodalidad==200){
$nombremodalidad='PREGRADO';
}
elseif($codigomodalidad==300)
{
$nombremodalidad='POSGRADO';
}

$query_namecarrera = "select nombrecarrera from carrera where codigocarrera ='$codigocarrera'";
$namecarrera= $db->Execute($query_namecarrera);
$totalRows_namecarrera = $namecarrera->RecordCount();
$row_namecarrera= $namecarrera->FetchRow();
$nombrecarrera=$row_namecarrera['nombrecarrera'];

$query_nameperiodo = "select nombreperiodo from periodo where codigoperiodo ='$codigoperiodo'";
$nameperiodo= $db->Execute($query_nameperiodo);
$totalRows_nameperiodo= $nameperiodo->RecordCount();
$row_nameperiodo= $nameperiodo->FetchRow();
$nombreperiodo=$row_nameperiodo['nombreperiodo'];

$objetotablaadmisiones=new TablasAdmisiones($db);

$array_subperiodo = $objetotablaadmisiones->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera, $codigoperiodo);
$idsubperiodo = $array_subperiodo['idsubperiodo'];

$array_salones=$objetotablaadmisiones->ObtenerSalonesdelaAdmision($codigocarrera, $idsubperiodo);
$listadoestudiantes=$objetotablaadmisiones->GenerarListadoPruebasAdmision($codigocarrera, $idsubperiodo);

 
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad El Bosque');
$pdf->SetTitle('Listado Asiganacion Salon');
$pdf->SetSubject('Listado Asiganacion Salon');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->setPrintHeader(false);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// set some language-dependent strings (optional)
if (file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page


foreach ($array_salones as $clave=>$valor) {
    $pdf->AddPage();
    $nombresalon=$valor;    
    $vigilada = "Vigilada Mineducación";
    $html='<table   border="0" align="center"  bgcolor="#F8F8F8" >
    <tr><td style="color:#40482D;font-size:1em;"><b>UNIVERSIDAD EL BOSQUE</b></td></tr>
    <tr><td style="color:#40482D;font-size:1em;">PROCESO DE ADMISIONES '.$nombremodalidad.' DE '.$nombrecarrera.'</td></tr>
    <tr><td style="color:#40482D;font-size:1em;">'.$nombreperiodo.'</td></tr>
    <tr><td style="color:#40482D;font-size:1em;"><B>SALON '.$nombresalon[codigosalon].'</B></td></tr>
    <tr><td style="color:#40482D;font-size:1em;">'.$vigilada.'</td></tr></table><br><br>	';
    
    $html.='<table   border="1" CellPadding="2">
    <tr><td style="font-size:1em;" align="center" width="5%"><b>No.</b></td>
    <td style="font-size:1em;" align="center" width="17%"><b>DOCUMENTO</b></td>
    <td style="font-size:1em;" align="center" width="65%"><b>NOMBRE</b></td>
    <td style="font-size:1em;" align="center" width="13%"><b>SALON</b></td>
    </tr>';
        
        $numeracion=1;
    foreach($listadoestudiantes as $campo=>$valorcampo) {
      $salonestudiante=$valorcampo;
      
      if($salonestudiante[codigosalon]==$nombresalon[codigosalon]){
      
	$html.='<tr>
	<td style="font-size:1em;" align="center">'.$numeracion.'</td>
	<td style="font-size:1em;">'.$salonestudiante[numerodocumento].'</td>
	<td style="font-size:1em;">'.$salonestudiante[nombre].'</td>
	<td style="font-size:1em;">'.$salonestudiante[codigosalon].'</td>
	</tr>';
	
	$numeracion ++;
      }   
    
    }

    $html.='</table>';

$pdf->writeHTML($html, true, false, true, false, '');
}



//Close and output PDF document
$pdf->Output('Listado_Asiganacion_Salon.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
