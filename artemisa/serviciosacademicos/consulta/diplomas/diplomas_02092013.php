<?php
//session_start();
require_once('../../funciones/clases/fpdf/fpdf.php');
require_once('../../funciones/clases/fpdf/cellfit.php');

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../Connections/salaado.php');

//$db->debug = true;
$filtro1 = "";
$filtro2 = "";
$filtro3 = "";
$filtro4 = "";
$filtro5 = "";
$filtro6 = "";
$filtro7 = "";
if(isset($_REQUEST['idregistrograduado']) && $_REQUEST['idregistrograduado'] != '')
    $filtro1 = "and rg.idregistrograduado = '".$_REQUEST['idregistrograduado']."'";

if(isset($_REQUEST['tipogeneracion']) && $_REQUEST['tipogeneracion']=="generacionmasiva"){
    if(isset($_REQUEST['desde']) && $_REQUEST['desde'] != '' && isset($_REQUEST['hasta']) && $_REQUEST['hasta'] != ''){
        $filtro2 = "AND f.folio>='".$_REQUEST['desde']."'
                    AND f.folio<='".$_REQUEST['hasta']."'";
    }
    if(isset($_REQUEST['registro']) && $_REQUEST['registro'] != '')
        $filtro3 = "and rg.idregistrograduado like '%".$_REQUEST['registro']."%'";
    if(isset($_REQUEST['codigo']) && $_REQUEST['codigo'] != '')
        $filtro4 = "and e.codigoestudiante like '%".$_REQUEST['codigo']."%'";
    if(isset($_REQUEST['nombreestudiante']) && $_REQUEST['nombreestudiante'] != '')
        $filtro5 = "and concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) like '%".$_REQUEST['nombreestudiante']."%'";
    if(isset($_REQUEST['doc']) && $_REQUEST['doc'] != '')
        $filtro6 = "and eg.numerodocumento like '%".$_REQUEST['doc']."%'";
    if(isset($_REQUEST['titulo']) && $_REQUEST['titulo'] != '')
        $filtro7 = "and t.nombretitulo like '%".$_REQUEST['titulo']."%'";
}   
$query_datos = "SELECT e.codigoestudiante, e.codigocarrera, rg.idregistrograduado, rg.codigoestado,
                concat(eg.nombresestudiantegeneral,' ', eg.apellidosestudiantegeneral) AS 'nombre',
                d.nombredocumento, eg.numerodocumento AS 'documento',
                eg.expedidodocumento as  'expedicion', c.nombrecarrera AS 'programa', t.nombretitulo AS 'titulo',
                rg.numerodiplomaregistrograduado AS 'diploma', rg.numeropromocion as 'numeropromocion',
                rg.numeroactaregistrograduado AS 'numeroacta', fechaactaregistrograduado as 'fechaacta',
                rg.numeroacuerdoregistrograduado as 'numeroacuerdo', rg.fechaacuerdoregistrograduado as 'fechaacuerdo',
                concat(date_format(rg.fechagradoregistrograduado, '%d'), ' DE ',
                (case date_format(rg.fechagradoregistrograduado, '%c') when 1 then 'ENERO'
                when 2 then 'FEBRERO'
                when 3 then 'MARZO'
                when 4 then 'ABRIL'
                when 5 then 'MAYO'
                when 6 then 'JUNIO'
                when 7 then 'JULIO'
                when 8 then 'AGOSTO'
                when 9 then 'SEPTIEMBRE'
                when 10 then 'OCTUBRE'
                when 11 then 'NOVIEMBRE'
                when 12 then 'DICIEMBRE'
                end), ' DE ',
                date_format(rg.fechagradoregistrograduado, '%Y')) as fechagrado,
                rg.codigoestado, rg.codigoautorizacionregistrograduado, f.folio, c.codigomodalidadacademica, d.nombrecortodocumento,
                eg.codigogenero
                FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t,documento d, foliotemporal f
                WHERE
                rg.codigoestudiante=e.codigoestudiante
                AND e.idestudiantegeneral=eg.idestudiantegeneral
                AND e.codigocarrera=c.codigocarrera
                AND c.codigotitulo=t.codigotitulo
                and d.tipodocumento=eg.tipodocumento
                $filtro1
                $filtro2
                $filtro3
                $filtro4
                $filtro5
                $filtro6
                $filtro7
                and f.idregistrograduado=rg.idregistrograduado
                ORDER BY rg.idregistrograduado";
$datos = $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();
if($totalRows_datos <= 0)
{
?>
<script type="text/javascript">
    alert('El documento digitado no tiene certificado asignado, por favor comuníquese con educación continuada');
    window.loaction.href='autenticacion.php';
</script>
<?php

    exit();
}

$orientacion = "L";
$unidad = "mm";
$formato = "Pregrado";
//$imagen = "duplicado.jpg";
//$firma1 = "mariadelrosario.png";
//$firma2 = "ritacecilia.png";
//$firma3 = "elsamarino.png";
//$arrayDocumentos['CC'] = "C.C.";

$pdf=new FPDF_CellFit($orientacion, $unidad, $formato);
$pdf->SetMargins(0,0,0);
$pdf->SetAutoPageBreak(true,9);
//$pdf->Cabecera($imagen);

$pdf->AddFont('TrajanPro','','TrajanPro.php');
$pdf->AddFont('Humanst521BTRoman','','Humanst521BTRoman.php');
$pdf->AddFont('UniversityRomanBoldBT','','UniversityRomanBoldBT.php');
$pdf->AddFont('Dauphin','','Dauphin.php');
//$pdf->AddFont('Hum521bi','','Hum521bi.php');
while($row_datos = $datos->FetchRow()){
    if($row_datos['codigocarrera']!=10){
        $pdf->AddPage();        
        
        if(isset($_REQUEST['tipogeneracion']) && $_REQUEST['tipogeneracion']=="generacionduplicado"){
        $pdf->SetFont('Dauphin','',25);
        $pdf->SetTextColor(0,0,0);
        $pdf->Rotate(40,35,60);
        $pdf->Text(35,60,"DUPLICADO");
        $pdf->Rotate(0);
        }
        $pdf->SetFont('TrajanPro','',50);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetY(115);
        $pdf->SetX(45);
        $pdf->CellFit(330,0,utf8_decode($row_datos['nombre']),0,0,'C','','',true,false);

        $pdf->SetFont('Humanst521BTRoman','',12);
        $pdf->SetY(127);
        //$pdf->SetFontSize(14);
        $search  = array('á', 'é', 'í', 'ó', 'ú');
        $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');

	if(ctype_digit($row_datos['documento']))
        {
            $documento=str_replace(',', '.', number_format($row_datos['documento']));
        }
        else{
            $documento=$row_datos['documento'];
        }

setlocale(LC_CTYPE,"es_ES");

        $pdf->Cell(0,0, str_replace($search, $replace, strtoupper(utf8_decode($row_datos['nombredocumento']))).' No. '.$documento.' EXPEDIDA EN '.str_replace($search, $replace, strtoupper(utf8_decode($row_datos['expedicion']))),0,2,'C');

        $pdf->SetFont('TrajanPro','',50);
        $pdf->SetY(177);
        $pdf->SetX(30);

        if($row_datos['codigocarrera']==8 && $row_datos['codigogenero']==200){
            $pdf->CellFit(360,0, 'ENFERMERO',0,0,'C','','',true,false);
        }
        else if($row_datos['codigocarrera']==8 && $row_datos['codigogenero']==100){
            $pdf->CellFit(360,0, 'ENFERMERA',0,0,'C','','',true,false);
        }
        else if($row_datos['codigocarrera']==125 && $row_datos['codigogenero']==200){
            $pdf->CellFit(360,0, 'INGENIERO AMBIENTAL',0,0,'C','','',true,false);
        }
        else if($row_datos['codigocarrera']==125 && $row_datos['codigogenero']==100){
            $pdf->CellFit(360,0, 'INGENIERA AMBIENTAL',0,0,'C','','',true,false);
        }
        else{
        $pdf->CellFit(360,0, str_replace($search, $replace, strtoupper(utf8_decode($row_datos['titulo']))),0,0,'C','','',true,false);
        }

        $pdf->SetFont('Humanst521BTRoman','',12);
        $pdf->SetY(197);
	if(isset($_REQUEST['tipogeneracion']) && $_REQUEST['tipogeneracion']!="generacionduplicado"){
        $pdf->Cell(0,0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA '))).$row_datos['fechagrado'],0,2,'C');
	}
	else{
	$mesesanio = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$pdf->Cell(0,0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA '))).$row_datos['fechagrado'].'   ELABORACION DUPLICADO '.strtoupper($mesesanio[date('n')-1]).' '.date('d').' DE '.date('Y'),0,2,'C');
	}

        $pdf->SetFont('TrajanPro','',12);
        $pdf->SetY(227);
        $pdf->SetX(45);
        $pdf->Cell(0,0,'RECTOR',0,0,'L');

        $pdf->SetFont('TrajanPro','',12);
        $pdf->SetY(227);
        $pdf->SetX(157);
        if($row_datos['codigomodalidadacademica']==200){
        $pdf->Cell(0,0,'PRESIDENTE DE EL CLAUSTRO',0,0,'L');
        }
        else if($row_datos['codigomodalidadacademica']==300 || $row_datos['codigomodalidadacademica']==600){
        $pdf->Cell(0,0,'DIRECTOR DE POSTGRADOS',0,0,'L');
        }

        $pdf->SetFont('TrajanPro','',12);
        $pdf->SetY(227);
        $pdf->SetX(294);
        $pdf->Cell(0,0,'PRESIDENTE DE El CONSEJO DIRECTIVO',0,0,'L');

        $pdf->SetFont('TrajanPro','',12);
        $pdf->SetY(254);
        //$pdf->SetX(107);
        if($row_datos['codigomodalidadacademica']==200){
        $pdf->SetX(107);
        $pdf->Cell(0,0,'DECANO',0,0,'L');
        }
        else if($row_datos['codigomodalidadacademica']==300 || $row_datos['codigomodalidadacademica']==600){
        $pdf->SetX(82);
        $pdf->Cell(0,0,'DIRECTOR DEL PROGRAMA',0,0,'L');
        }
        $pdf->SetFont('TrajanPro','',12);
        $pdf->SetY(254);
        $pdf->SetX(231);
        $pdf->Cell(0,0,'SECRETARIO GENERAL',0,0,'L');

        $pdf->SetFont('Humanst521BTRoman','',10);
        $pdf->SetY(285);
        $pdf->SetX(364);
        $pdf->Cell(0,0,'Registro  '.$row_datos['idregistrograduado'],0,0,'L');

        $pdf->SetFont('Humanst521BTRoman','',10);
        $pdf->SetY(285);
        $pdf->SetX(394);
        $pdf->Cell(0,0,'Folio  '.$row_datos['folio'],0,0,'L');
    }
    /*else {
        $pdf->AddPage();
        $pdf->SetFont('UniversityRomanBoldBT','',40);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetY(99);
        $pdf->SetX(55);
        $pdf->CellFit(300,0,$row_datos['nombre'],0,0,'C','','',true,false);

        $pdf->SetFont('UniversityRomanBoldBT','',12);
        $pdf->SetY(120);
        $search1  = array('CC', 'TI', 'CE', 'RC', 'PA', 'NI', 'CM', 'CB', 'DU', 'CI', 'DN');
        $replace1 = array('C.C.', 'T.I.', 'C.E.', 'R.C.', 'P.A.', 'N.I.', 'C.M', 'C.B.', 'D.U.', 'C.I.', 'D.N.');
        $pdf->Cell(0,0, str_replace($search1, $replace1, strtoupper($row_datos['nombrecortodocumento'])).' No. '.$row_datos['documento'].' Expedida en '.$row_datos['expedicion'],0,2,'C');    }*/
}
$pdf->Output();

?>
