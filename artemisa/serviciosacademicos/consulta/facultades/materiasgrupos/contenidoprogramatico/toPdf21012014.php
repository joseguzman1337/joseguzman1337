<?php
session_start();

error_reporting();
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Andres sotelo');
$pdf->SetTitle('Syllabus');
$pdf->SetSubject('Syllabus');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data


if ($_REQUEST['type']==1){
    $imagen = 'tcpdf_logo.jpg';
}else{
    $imagen = 'formato_asignatura.jpg';
}
//echo PDF_HEADER_LOGO;
$pdf->SetHeaderData($imagen, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 9);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print

            $html = '<table width="100%"  border="1"  cellpadding="0" cellspacing="0">';
                    if(isset($_REQUEST['codigomateria'])&& $_REQUEST['codigomateria']!=""){
			$query_pertenecemateria="SELECT m.codigomateria,m.nombremateria, m.numerohorassemanales, m.numerosemana
			, c.nombrecarrera, f.nombrefacultad, t.nombretipomateria, t.codigotipomateria, p.nombreplanestudio, p.idplanestudio
			, coalesce(d.numerocreditosdetalleplanestudio,m.numerocreditos) as numerocreditosdetalleplanestudio
                        , d.semestredetalleplanestudio, m.porcentajeteoricamateria, m.porcentajepracticamateria
			FROM materia m
			left join detalleplanestudio d on m.codigomateria=d.codigomateria
			left join planestudio p on d.idplanestudio = p.idplanestudio and p.codigoestadoplanestudio = '100' and p.codigocarrera = (select codigocarrera from materia where codigomateria='".$_REQUEST['codigomateria']."')
			, carrera c , facultad f , tipomateria t
			where m.codigomateria='".$_REQUEST['codigomateria']."'
			and m.codigocarrera=c.codigocarrera
			and c.codigofacultad=f.codigofacultad
			and m.codigotipomateria=t.codigotipomateria
			group by semestredetalleplanestudio";
                        $pertenecemateria = $db->Execute ($query_pertenecemateria) or die("$query_pertenecemateria".mysql_error());
                        $total_Rows_pertenecemateria = $pertenecemateria->RecordCount();
                        $row_pertenecemateria=$pertenecemateria->FetchRow();
                        $horaspresencialessemestre=$row_pertenecemateria['numerohorassemanales']*$row_pertenecemateria['numerosemana'];
                        $horastotales= 48 * $row_pertenecemateria['numerocreditosdetalleplanestudio'];
                        $horastrabajoindependiente=$row_pertenecemateria['numerohorassemanales']*2;

                   $html .= '<tr><td colspan="2" width="25%">Facultad</td><td colspan="7" width="75%">'.$row_pertenecemateria['nombrefacultad'].'</td></tr>';
                   $html .= '<tr><td colspan="2" width="25%">Programa</td><td colspan="7" width="75%">'.$row_pertenecemateria['nombrecarrera'].'</td></tr>';
                   $html .= '<tr><td colspan="2" width="25%">Nombre de la Asignatura</td><td colspan="7" width="75%">'.$row_pertenecemateria['nombremateria'].'</td></tr>';
                   $z=0;
                    if($z==0)
                    { $sem.=$row_pertenecemateria['semestredetalleplanestudio'];}
                    else{
                    $sem.="; ".$row_pertenecemateria['semestredetalleplanestudio'];}
                    $z++;
                   $html .= '<tr><td colspan="2" width="25%">Codigo de la Asignatura</td><td colspan="2" width="10%">'.$row_pertenecemateria['codigomateria'].'</td><td colspan="2" width="25%">Semestre</td><td width="5%">'.$sem.'</td><td width="25%">Periodo Academico</td><td width="10%">'.$_REQUEST['periodosesion'].'</td></tr>';
                   if($row_pertenecemateria['codigotipomateria']<=3){ $xxx =  " X " ;}else{$xxx =  " " ;};
                   if($row_pertenecemateria['codigotipomateria']>3){ $elex =  " X " ;}else{$elex =  " " ;};
                   $html .= '<tr><td colspan="2" width="25%">Tipo Asignatura</td><td colspan="2" width="10%">Obligatoria</td><td colspan="3" width="30%">'.$xxx.'</td><td width="25%">Electiva</td><td width="10%">'.$elex.'</td></tr>';
                   $html .= '<tr><td colspan="2" width="25%">Modalidad %</td><td colspan="2" width="10%">Teorica</td><td width="15%">'.$row_pertenecemateria['porcentajeteoricamateria'].'</td><td width="10%">Practica</td><td width="5%">'.$row_pertenecemateria['porcentajepracticamateria'].'</td><td width="25%">Teorica-Practica</td><td width="10%">0</td></tr>';
                   $html .= '<tr>';
                   $html .= '<td colspan="2" width="25%">Pre-requisitos:</TD>';
                   $html .= '<td colspan="7" width="75%">';
                        /*
                         * Este query selecciona las materias que son prerequisito, trae las materias prerequisito
                         * en el  plan de estudio vigente para la materia.
                         */
                       $query_prerequisitos = "select distinct codigomateriareferenciaplanestudio,nombremateria 
                            from referenciaplanestudio r inner join materia m on r.codigomateriareferenciaplanestudio = m.codigomateria
                            where codigotiporeferenciaplanestudio = 100 
                            and r.codigomateria = '".$_REQUEST['codigomateria']."';"; 
                        
                        $prerequisitos = $db->Execute ($query_prerequisitos) or die("$query_prerequisitos".mysql_error());
                        $total_Rows_prerequisitos= $prerequisitos->RecordCount();

                        if($total_Rows_prerequisitos == 0){
                            $html .= "&nbsp;";
                        }else{
                            $j=0;
                            while ($row_prerequisitos= $prerequisitos->FetchRow()){
                            if($j==0){
                                $nombrepre.=$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];
                            }else{
                                $nombrepre.=", ".$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];}
                                $j++;
                            }
                            $html .= $nombrepre;
                        }
                       $html .= '</td></tr>';
                       $html .= '<tr><td colspan="2" width="25%">Co-requisitos:</td><td colspan="7" width="75%">';
                          $query_corequisitos="select distinct codigomateriareferenciaplanestudio,nombremateria 
                            from referenciaplanestudio r inner join materia m on r.codigomateriareferenciaplanestudio = m.codigomateria
                            where codigotiporeferenciaplanestudio in(200,201) 
                            and r.codigomateria = '".$_REQUEST['codigomateria']."';";
                        $corequisitos = $db->Execute ($query_corequisitos) or die("$query_corequisitos".mysql_error());
                        $total_Rows_corequisitos= $corequisitos->RecordCount();
                        if($total_Rows_corequisitos == 0){
                            //$html .= "&nbsptraerdatos;";
                            $html .= "&nbsp;";
                        }else{
                            $k=0;
                            while ($row_corequisitos= $corequisitos->FetchRow()){
                            if($k==0){ 
                                $nombreco.=$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];
                            }else{
                                $nombreco.=", ".$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];}
                            $k++;
                            }
                            $html .= $nombreco;
                        }
                        $html .= '</td></tr>';
                        $html .= '<tr><td colspan="2" width="25%">Numero de Creditos:</td><td width="10%">'.$row_pertenecemateria['numerocreditosdetalleplanestudio'].'</td><td colspan="3" width="25%">Horas Presenciales/Semana:</td><td width="5%">'.$row_pertenecemateria['numerohorassemanales'].'</td><td width="25%">Horas presenciales/semestre:</td><td width="10%">'.$horaspresencialessemestre.'</td></tr>';
                        
                        
                        $query_registros="SELECT c.idcontenidoprogramatico, c.codigoperiodo,c.horastrabajoindependiente
                        FROM contenidoprogramatico  c
                        where c.codigomateria = '".$_REQUEST['codigomateria']."'
                        and c.codigoperiodo = '".$_REQUEST["periodosesion"]."'
                        and c.codigoestado like '1%'
                        order by fechainiciocontenidoprogramatico desc
                        limit 1";
                        $registros = $db->Execute ($query_registros) or die("$query_registros".mysql_error());
                        //print_r($registros);
                        $total_Rows_registros= $registros->RecordCount();
                        $row_registros = $registros->FetchRow();
                        $idcontenidoprogramatico=$row_registros['idcontenidoprogramatico'];
                        
                        $html .= '<tr><td colspan="5"></td><td align=left colspan="3">horas Trabajo Indenpendiente /semana:</td><td>'.$row_registros['horastrabajoindependiente'].'</td></tr>';
                        
                   }
                  $html .= '</table>';
                  $html .= '<p></p>';
if($_REQUEST['type']==1) {
    //$html='';
    $Query = "select distinct codigotipodetallecontenidoprogramatico,observaciondetallecontenidoprogramatico from detallecontenidoprogramatico c where idcontenidoprogramatico ='$idcontenidoprogramatico' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(100);";
    $Query = $db->Execute ($Query) or die("$Query".mysql_error());
    while ($row_registros = $Query->FetchRow()) {
        if($row_registros['codigotipodetallecontenidoprogramatico'] ==100){
            $html .=  $row_registros['observaciondetallecontenidoprogramatico'];
        }
    }
}

if($_REQUEST['type']==2 or !$_REQUEST['type']) {
    $Query = "select distinct codigotipodetallecontenidoprogramatico,observaciondetallecontenidoprogramatico from detallecontenidoprogramatico c where idcontenidoprogramatico ='$idcontenidoprogramatico' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(200);";
    $Query = $db->Execute ($Query) or die("$Query".mysql_error());
    //print_r($Query);
    while ($row_registros = $Query->FetchRow()) {       
            $html .=  $row_registros['observaciondetallecontenidoprogramatico'];
    }
    $Query = "select codigotipodetallecontenidoprogramatico,observaciondetallecontenidoprogramatico from detallecontenidoprogramatico c where idcontenidoprogramatico ='$idcontenidoprogramatico' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(100);";
    $Query = $db->Execute ($Query) or die("$Query".mysql_error());
    while ($row_registros = $Query->FetchRow()) {
            $html .=  $row_registros['observaciondetallecontenidoprogramatico'];
    }
    $Query = "select codigotipodetallecontenidoprogramatico,observaciondetallecontenidoprogramatico from detallecontenidoprogramatico c where idcontenidoprogramatico ='$idcontenidoprogramatico' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(400);";
    $Query = $db->Execute ($Query) or die("$Query".mysql_error());
    while ($row_registros = $Query->FetchRow()) {
            $html .= $row_registros['observaciondetallecontenidoprogramatico'];
    }
 }
//echo $html;


//exit();
$html = <<<EOD
   $html
EOD;
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
