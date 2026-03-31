<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');
*/
//require_once('../educacionContinuada/html2pdf/html2pdf.class.php');

//$test= explode(",",$_GET['checkid']);
session_start();
	if(!isset ($_SESSION['MM_Username'])){
		echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
		exit();
    }
require_once("../Grados/lib/pdf/dompdf/dompdf_config.inc.php");
//$rutaado = ("../funciones/adodb/");
//require_once('../Connections/salaado-pear.php');
require_once('../EspacioFisico/templates/template.php');
include('../mgi/datos/usuarioAdmin/classValida.php');
$valida= new Valida();




$db = getBD();
function nombremes($mes) {
    setlocale(LC_TIME, 'spanish');
    $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
    return $nombre;
}

ini_set('date.timezone', 'America/Bogota');
//$ano = date("Y");
$ano = $_GET['ano'];
$vice = $_GET['vice'];
$secretario = $_GET['secretario'];
$director = $_GET['director'];
$registro = $_GET['registro'];
$auditoria = $_GET['auditoria'];


$valida->validaVacio($vice);
$valida->validarString($vice);
$valida->validaVacio($secretario);
$valida->validarString($secretario);
$valida->validaVacio($director);
$valida->validarString($director);
$valida->validaVacio($registro);
$valida->validarString($registro);
$valida->validaVacio($auditoria);
$valida->validarString($auditoria);
$nombremes = nombremes(date("m"));
$diames = date("d");
//obtengo la hora actual
$hora_actual = date("g:i a");
$numeroLetraDia = numtoletras($diames);
$numeroLetraAno = numtoletras($ano);
$horaLetra = numtoletras(date("g"));
$minutoLetra = numtoletras(date(":i"));
$jornada = date("a");
if ($jornada == 'pm') {
    $jornadaactual = 'tarde';
} else {
    $jornadaactual = 'mañana';
}

//$checkId = implode(",",$arrayChe);
$checkId = $_GET['checkid'];
$valida->validaVacio($checkId);
//var_dump($checkId) ; exit();
 $query = "SELECT
                COUNT(vv.idplantillavotacion) AS votos,

                c.nombrecarrera,

                CONCAT(
                        cv.nombrescandidatovotacion,
                        ' ',
                        cv.apellidoscandidatovotacion
                ) AS nombrePrincipal,
                CONCAT(
                        cvs.nombrescandidatovotacion,
                        ' ',
                        cvs.apellidoscandidatovotacion
                ) AS nombreSuplente,
                tp.idtipoplantillavotacion,
                tpv.nombretipocandidatodetalleplantillavotacion
        FROM
                votosvotacion vv
        INNER JOIN plantillavotacion p ON p.idplantillavotacion = vv.idplantillavotacion
        INNER JOIN detalleplantillavotacion dp ON dp.idplantillavotacion = p.idplantillavotacion
        AND dp.idcargo != 3
        INNER JOIN candidatovotacion cv ON cv.idcandidatovotacion = dp.idcandidatovotacion
        INNER JOIN carrera c ON c.codigocarrera = p.codigocarrera
        LEFT JOIN detalleplantillavotacion dps ON dps.idplantillavotacion = dp.idplantillavotacion
        AND dps.idcargo = 3
        LEFT JOIN candidatovotacion cvs ON cvs.idcandidatovotacion = dps.idcandidatovotacion
        INNER JOIN votacion v ON v.idvotacion = p.idvotacion
        INNER JOIN tipoplantillavotacion tp on tp.idtipoplantillavotacion = p.idtipoplantillavotacion
        INNER JOIN tipocandidatodetalleplantillavotacion tpv on tpv.idtipocandidatodetalleplantillavotacion = v.idtipocandidatodetalleplantillavotacion
        WHERE
                vv.codigoestado = 100
			AND v.idvotacion IN(".$checkId.")
			AND tp.idtipoplantillavotacion < 3
        GROUP BY
                vv.idplantillavotacion
        ORDER BY
                 tp.idtipoplantillavotacion , tpv.nombretipocandidatodetalleplantillavotacion asc";

if($votos=&$db->Execute($query)===false){
				die;
			}
$arrayVotos = array();
$arrayVotos  = $votos->GetArray();

//$row = $votos->GetRow();
/*do {
    $arrayVotos[] = $row;
} while ($row = $votos->fetchRow());*/
$temp1=null;
$temp2=null;
$temp3=null;
$temp4=null;
$temp5=null;
$temp6=null;

foreach ($arrayVotos as $dataActa) {
	
    if (($dataActa['idtipoplantillavotacion'] == '1') || ($dataActa['idtipoplantillavotacion'] == '2')) {
        if ($dataActa['nombrePrincipal'] !== 'En Blanco Voto') {
			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Docente'){		
				if(($dataActa['votos'] > $temp1)&&($dataActa['idtipoplantillavotacion'] == '1')){
						$temp1=$dataActa['votos'];
					
						$trPrincipalConsejo='<tr><td style="font-size:65%">Consejo Académico</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejo.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejo.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejo.='							
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejo.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejo.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td></tr>';
										
						}
				}
			}
			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Estudiante'){
				if(($dataActa['votos'] > $temp2)&&($dataActa['idtipoplantillavotacion'] == '1')){
					$temp2=$dataActa['votos'];
						$trPrincipalConsejo.='<tr><td   style="font-size:65%">Consejo Académico</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejo.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejo.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejo.='
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejo.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejo.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td></tr>';
										
						}
				
				}
			}
			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Egresado'){
				if(($dataActa['votos'] > $temp3)&&($dataActa['idtipoplantillavotacion'] == '1')){
					$temp3=$dataActa['votos'];
					
						$trPrincipalConsejo.='<tr><td   style="font-size:65%">Consejo Académico</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejo.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejo.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejo.='
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejo.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejo.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td></tr>';
										
						}
				}
			}

			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Docente'){		
				if(($dataActa['votos'] > $temp4)&&($dataActa['idtipoplantillavotacion'] == '2')){
						$temp4=$dataActa['votos'];
					
						$trPrincipalConsejoD='<tr><td   style="font-size:65%">Consejo Directivo</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejoD.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejoD.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejoD.='
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejoD.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejoD.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td></tr>';
										
						}
				}
			}
			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Estudiante'){
				if(($dataActa['votos'] > $temp5)&&($dataActa['idtipoplantillavotacion'] == '2')){
					$temp5=$dataActa['votos'];
						$trPrincipalConsejoDE='<tr><td   style="font-size:65%">Consejo Directivo</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejoDE.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejoDE.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejoDE.='
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejoDE.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejoDE.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td></tr>';
										
						}
				
				}
			}
			if ($dataActa['nombretipocandidatodetalleplantillavotacion'] == 'Egresado'){
				if(($dataActa['votos'] > $temp6)&&($dataActa['idtipoplantillavotacion'] == '2')){
					$temp6=$dataActa['votos'];
					
						$trPrincipalConsejoD.='<tr><td   style="font-size:65%">Consejo Directivo</td>';
						if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
							$trPrincipalConsejoD.='
											<td style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>';
											
						}
						$trPrincipalConsejoD.='<td  style="font-size:65%">' . $dataActa['nombrePrincipal'] . '</td>';
						
						if ($dataActa['nombreSuplente']) {
							$trPrincipalConsejoD.='
											<td  style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>';
											
						}else{
							$trPrincipalConsejoD.='<td  style="font-size:65%"></td>';
						}
						
						if ($dataActa['votos']) {
							$trPrincipalConsejoD.='
											<td  style="font-size:65%;text-align:center;">' . $dataActa['votos'] . '</td>
											</tr>';
										
						}
				}
			}			
			
		
        }
    }
    
  /*  if ($dataActa['idtipoplantillavotacion'] == '2') {
        if ($dataActa['nombrePrincipal'] !== 'En Blanco Voto') {
			
            
            if ($dataActa['nombrePrincipal']) {
                $trPrincipalConsejo.='<tr><td style="border: hidden" style="font-size:65%>Consejo Academico</td>
							<td style="border: hidden" style="font-size:65%" >' . $dataActa['nombrePrincipal'] . '</td>';
            }
            if ($dataActa['nombreSuplente']) {
                $trPrincipalConsejo.='
								<td style="border: hidden" hidden" style="font-size:65%">' . $dataActa['nombreSuplente'] . '</td>
								';
            }
            if ($dataActa['nombretipocandidatodetalleplantillavotacion']) {
                $trPrincipalConsejo.='
								<td style="border: hidden" hidden" style="font-size:65%">' . $dataActa['nombretipocandidatodetalleplantillavotacion'] . '</td>
								';
            }
            if ($dataActa['votos']) {
                $trPrincipalConsejo.='
								<td style="border: hidden" hidden" style="font-size:65%">' . $dataActa['votos'] . '</td>
								</tr>';
            }
        }
    }*/
}
//echo $temp1."<br>".$plantilla; exit();
$queryFa = "SELECT MAX(votos) as votos, nombrecarrera,nombrePrincipal,nombreSuplente,nombretipocandidatodetalleplantillavotacion,idtipoplantillavotacion
			FROM (
			SELECT
			COUNT(vv.idplantillavotacion) AS votos,
			c.nombrecarrera,
			CONCAT(
			cv.nombrescandidatovotacion,
			' ',
			cv.apellidoscandidatovotacion
			) AS nombrePrincipal,
			CONCAT(
			cvs.nombrescandidatovotacion,
			' ',
			cvs.apellidoscandidatovotacion
			) AS nombreSuplente,
			tp.idtipoplantillavotacion,
			tpv.nombretipocandidatodetalleplantillavotacion, c.codigocarrera, tpv.idtipocandidatodetalleplantillavotacion
			FROM
			votosvotacion vv
			INNER JOIN plantillavotacion p ON p.idplantillavotacion = vv.idplantillavotacion
			INNER JOIN detalleplantillavotacion dp ON dp.idplantillavotacion = p.idplantillavotacion
			AND dp.idcargo != 3
			INNER JOIN candidatovotacion cv ON cv.idcandidatovotacion = dp.idcandidatovotacion
			INNER JOIN carrera c ON c.codigocarrera = p.codigocarrera
			LEFT JOIN detalleplantillavotacion dps ON dps.idplantillavotacion = dp.idplantillavotacion
			AND dps.idcargo = 3
			LEFT JOIN candidatovotacion cvs ON cvs.idcandidatovotacion = dps.idcandidatovotacion
			INNER JOIN votacion v ON v.idvotacion = p.idvotacion
			INNER JOIN tipoplantillavotacion tp ON tp.idtipoplantillavotacion = p.idtipoplantillavotacion
			INNER JOIN tipocandidatodetalleplantillavotacion tpv ON tpv.idtipocandidatodetalleplantillavotacion = v.idtipocandidatodetalleplantillavotacion
			WHERE
			vv.codigoestado = 100
			AND v.idvotacion IN(".$checkId.")
			GROUP BY
			vv.idplantillavotacion
			ORDER BY
			tp.nombretipoplantillavotacion ASC ) B
			WHERE idtipoplantillavotacion <> 1 and idtipoplantillavotacion <> 2
			GROUP BY nombretipocandidatodetalleplantillavotacion, codigocarrera , idtipoplantillavotacion
			ORDER BY idtipoplantillavotacion, nombrecarrera ASC";

if($votosV=&$db->Execute($queryFa)===false){
				die;
			}
$arrayVotosF = array();
$arrayVotosF  = $votosV->GetArray();
foreach ($arrayVotosF as $dataActaF) {
    if ($dataActaF['nombrePrincipal'] !== 'En Blanco Voto') {

        if ($dataActaF['nombrecarrera']) {

            $trnombrecarrera3.='<tr>
							<td width="15%"style="font-size:65%">' . $dataActaF['nombrecarrera'] . '</td>
							';
        }
		if ($dataActaF['nombretipocandidatodetalleplantillavotacion']) {
            $trnombrecarrera3.='
								<td style="font-size:65%">' . $dataActaF['nombretipocandidatodetalleplantillavotacion'] . '</td>
								';
        }
		if ($dataActaF['nombrePrincipal']) {
            $trnombrecarrera3.='
							<td style="font-size:65%">' . $dataActaF['nombrePrincipal'] . '</td>
							';
        }
        
        
        if ($dataActaF['nombreSuplente']) {
            $trnombrecarrera3.='
								<td style="font-size:65%">' . $dataActaF['nombreSuplente'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								';
        }else{
							$trnombrecarrera3.='<td  style="font-size:65%"></td>';
						}

        if ($dataActaF['votos']) {
            $trnombrecarrera3.='
								<td style="font-size:65%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $dataActaF['votos'] . '</td>
								</tr>';
        }
    }
}

$table = '
 <table width="100%" class="tableConsejos" style=" border: 1px solid black;" 	>
 
	<tr>
		<th style="font-size:65%">Consejo</th>
		<th style="font-size:65%">Representante</th>
		<th style="font-size:65%">Principal</th>
		<th style="font-size:65%">Suplente</th>
		<th style="font-size:65%">Votos</th>
	</tr>
	'.$trPrincipalConsejo.'
	'.$trPrincipalConsejoD.'
	'.$trPrincipalConsejoDE.'
	
 </table><br/>

';
$tableFacultad = '
<br/>
<b>Representantes Consejo Facultad</b>
<br/>
<br/>
<br/>

 <table width="100%" style=" border: 1px solid black;" class="tableConsejos">
	
	<tr>
		<th style="font-size:65%">Facultad</th>
		<th style="font-size:65%">Representante</th>
		<th style="font-size:65%">Principal</th>
		<th style="font-size:65%">Suplente</th>
		<th style="font-size:65%">Votos</th>
	</tr>
	' . $trnombrecarrera3 . '
 </table>

';
$ano1 = $ano + 1;

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body{
	font-size: 12pt;
	font-family: Arial, Helvetica, sans-serif;
}

@page { margin: 180px 50px; }

.tableConsejos{
	border-collapse: collapse;
    border: 1px solid black;
}
.tableConsejos tr, .tableConsejos td, .tableConsejos th{
border: 1px solid #000;
}
 
</style>
</head>

<body>

<div>
	<br/>
  	<p align="center"><strong>ACTA DE ESCRUTINIO</strong></p>
    <br/>
  <p align="justify"><strong>PROCESO DE ELECCIÓN DE REPRESENTANTES  DEL PERSONAL DOCENTE Y ESTUDIANTIL </strong><strong>ANTE&nbsp; LOS CONSEJOS DIRECTIVO, ACADÉMICO,  DE&nbsp; FACULTAD Y DE EGRESADOS ANTE EL CONSEJO DE FACULTAD. PERIODO ' . $ano . ' – ' . $ano1 . '.</strong></p>
  <p align="justify" style="margin:0;">En  Bogotá, D. C., Siendo las ' . $hora_actual . ' del día ' . $numeroLetraDia . ' (' . $diames . ') del mes de  ' . $nombremes . ' de  ' . $numeroLetraAno . ' (' . $ano . '), 
  nos reunimos en la Secretaría General, las personas que  suscribimos la presente ACTA, para llevar a cabo el escrutinio de las  votaciones realizadas por la comunidad Estudiantil, Docente y de Egresados, dentro  del proceso de elección de representantes 
  ante el CONSEJO DIRECTIVO, CONSEJO  ACADEMICO y CONSEJOS DE FACULTAD; para el periodo ' . $ano . ' - ' . $ano1 . '.</p>
  <p align="justify">El  procedimiento consiste en extraer del sistema Académico SALA del módulo  votaciones, los registros que componen el informe final de  resultados, siendo elegidas las siguientes personas:</p>
	
	' . $table . '
	' . $tableFacultad . '
	
  <br/>	
  <p align="justify">Se adjunta a la presente acta, el informe detallado de los resultados del proceso de votación, generado por el sistema de Información Académico SALA.</p>
<p>En constancia de lo anterior, se firma la presente acta, en Bogotá, D. C., siendo las ' . $horaLetra . ' y ' . $minutoLetra . ' de la ' . $jornadaactual . ' (' . $hora_actual . '), a los ' . $numeroLetraDia . ' (' . $diames . ') días del mes de ' . $nombremes . ' (' . $diames . ') de ' . $numeroLetraAno . '(' . $ano . ').</p>

  <table width="100%">
  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				
				<td width="50%"><div align="justify">'.$vice.'</div></td>
				<td width="18%">&nbsp;</td>
				
				<td width="43%"><div align="justify">'.$secretario.'</div></td>
			</tr>
			
			<tr>
			<td width="39%"><div align="justify">Vicerrectora Académica</div></td>
				<td width="18%">&nbsp;</td>
				<td width="43%"><div align="justify">Secretario General	</div></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="39%">'.$director.'</td>
				<td width="18%">&nbsp;</td>
				<td width="43%">'.$registro.'</td>
			</tr>
			<tr>
			<td width="39%">Director de Tecnología</td>
				<td width="18%">&nbsp;</td>
				<td width="43%">Registro y Control Académico</td>
			</tr>
  </table>
	<table width="100%">
	<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
        <tr>
        	<td width="31%">&nbsp;</td>
            <td width="41%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>'.$auditoria.'</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td >&nbsp;</td>
            <td >Jefe Auditoría Interna</td>
            <td >&nbsp;</td>
        </tr>
</table></div><p style="page-break-before: always;"></p></body></html>';
//echo $html;exit();

$dompdf = new DOMPDF();
$dompdf->set_paper("letter", "portrait");
$dompdf->load_html(($html));
$dompdf->render();
$dompdf->stream("sample.pdf");
/*$html2pdf = new HTML2PDF('P','A4','es');
$html2pdf->WriteHTML($html);
$html2pdf->Output('exemple.pdf');*/

function numtoletras($xcifra) {

    $xarray = array(0 => "Cero",
        1 => "prmiero", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve",
        "diez", "once", "doce", "trece", "catorce", "quince", "dieciseis", "diecisiete", "dieciocho", "diecinueve",
        "veinte", 30 => "treinta", 31 => "treinta y uno", 40 => "cuarenta", 50 => "cincuenta", 60 => "sesenta", 70 => "setenta", 80 => "ochenta", 90 => "noventa",
        100 => "ciento", 200 => "doscientos", 300 => "trescientos", 400 => "CUATROCIENTOS", 500 => "quinientos", 600 => "seiscientos", 700 => "setecientos", 800 => "ochocientos", 900 => "novecientos"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        /*   if (trim($xaux) != "") {
          switch ($xz) {
          case 0:
          if (trim(substr($XAUX, $xz * 6, 6)) == "1")
          $xcadena.= "UN BILLON ";
          else
          $xcadena.= " BILLONES ";
          break;
          case 1:
          if (trim(substr($XAUX, $xz * 6, 6)) == "1")
          $xcadena.= "UN MILLON ";
          else
          $xcadena.= " MILLONES ";
          break;
          case 2:
          if ($xcifra < 1) {
          $xcadena = "CERO PESOS $xdecimales/100 M.N.";
          }
          if ($xcifra >= 1 && $xcifra < 2) {
          $xcadena = "UN PESO $xdecimales/100 M.N. ";
          }
          if ($xcifra >= 2) {
          $xcadena.= " PESOS $xdecimales/100 M.N. "; //
          }
          break;
          } // endswitch ($xz)
          } */// ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

function subfijo($xx) { // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "mil";
    //
    return $xsub;
}
