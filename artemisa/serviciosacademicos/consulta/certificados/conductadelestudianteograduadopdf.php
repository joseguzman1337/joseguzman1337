<?php

/* echo " <pre>";
  print_r($row_datosc);
  echo "</pre>"; */
require('../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require('../../funciones/clases/html2fpdf/fpdf.php');
require('../../funciones/clases/html2fpdf/html2fpdf.php');
require('../../funciones/sala_genericas/FuncionesCadena.php');

//require('../../funciones/sala_genericas/funcionesfechaphp.php');

class PDF extends HTML2FPDF {

    function celda($w, $h, $string, $x, $align='C', $linea=2, $marco=1, $fill=0) {
        $this->SetXY($this->x + $x, $this->y - ($linea * $h));
        $this->MultiCell($w, $h, $string, $marco, $align, $fill);
    }

      function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(267);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
}


}

$documento = $_REQUEST['documento'];
$codigocertificado = $_REQUEST['codigocarrera'];
$certificado = '10';

$_SERVER["REMOTE_ADDR"];

 $query_datos = "SELECT g.nombregenero,tr.nombretrato,e.codigoestudiante,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo, r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo,r.numerodiplomaregistrograduadoantiguo,d.tipodocumento,d.nombredocumento,rg.numeroacuerdoregistrograduado,
r.fechaactaregistrograduadoantiguo, f.folio, rg.idregistrograduado, d.nombrecortodocumento, eg.expedidodocumento,c.nombrecarrera,eg.apellidosestudiantegeneral
            FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r, documento d, carrera c,registrograduado rg, foliotemporal f,trato tr,genero g
            where eg.numerodocumento =	'$documento'  and  c.codigocarrera='$codigocertificado' and c.codigocarrera=e.codigocarrera
            and e.codigoestudiante=r.codigoestudiante and tr.idtrato=eg.idtrato and g.codigogenero=eg.codigogenero
            and eg.idestudiantegeneral=e.idestudiantegeneral
            and eg.tipodocumento= d.tipodocumento
            and e.codigoestudiante=rg.codigoestudiante
            and f.idregistrograduado=rg.idregistrograduado
            union
            SELECT  g.nombregenero,tr.nombretrato,e.codigoestudiante,eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado, r.fechagradoregistrograduado,
r.numerodiplomaregistrograduado,d.tipodocumento,d.nombredocumento, r.numeroacuerdoregistrograduado, r.fechaactaregistrograduado, f.folio, r.idregistrograduado,d.nombrecortodocumento, eg.expedidodocumento,c.nombrecarrera,eg.apellidosestudiantegeneral
            FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t, documento d,  foliotemporal f,trato tr,genero g
            where eg.numerodocumento ='$documento' and  c.codigocarrera='$codigocertificado' and c.codigocarrera=e.codigocarrera
            and eg.idestudiantegeneral=e.idestudiantegeneral
            and e.codigocarrera=c.codigocarrera and tr.idtrato=eg.idtrato and g.codigogenero=eg.codigogenero
            and e.codigoestudiante=r.codigoestudiante
            and c.codigotitulo=t.codigotitulo
            and eg.tipodocumento= d.tipodocumento
            and f.idregistrograduado=r.idregistrograduado";
$datos = $db->query($query_datos);

$totalRows_datos = $datos->RecordCount();






if ($totalRows_datos == 0) {
?>
    <script type="text/javascript">
        alert('La busqueda asociada a este programa no arroja resultados, por favor verifique la carrera y fecha de grado o comuniquese con Secretaría General');
        window.location.href='../certificados/entrada/certificadosprueba.php';
    </script>
<?php

} else {

    $textonicial = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>

<html>
<head>
<title>HTML 2 (F)PDF Project</title>

<meta name=keywords content=1,2,3 />

<style>
#justificado
{
position:absolute;
font-size: 12pt;
text-align: justify;
width:90%;


}
#centrado
{
font-size: 14pt;
text-align: center;



}
#centradomenos
{

text-align: center;
font-size: 10pt;'


}
</style>
</head>
<body>

";

    $textofinal = "</body>
</html>";

    $orientacion = "P";
    $unidad = "mm";
    $formato = "Letter";
    $pdf = new PDF($orientacion, $unidad, $formato);
    $pdf->AddPage();



    while ($row_datos = $datos->fetchRow()) {
        unset($array_interno);

        $query_datoscertificado = "SELECT  *
            FROM detallecertificado dc, certificado c,tipodetallecertificado t, estado e
            where c.idcertificado ='$certificado'
            and e.codigoestado=t.codigoestado
            and t.idtipodetallecertificado=dc.idtipodetallecertificado
            and c.idcertificado=dc.idcertificado ";
        $datoscertificado = $db->Execute($query_datoscertificado);
        $totalRows_datoscertificado = $datoscertificado->RecordCount();

        while ($row_datosc = $datoscertificado->FetchRow()) {

            $array_interno[$row_datosc['idtipodetallecertificado']] = $row_datosc;
        }

        $fechaformato = formato_fecha_defecto($row_datos['fechaactaregistrograduadoantiguo']);
        $fecha = $row_datos['fechaactaregistrograduadoantiguo'];
        $nombremes = fechaatextomes($fechaformato);
        $vectorfecha = vector_fecha($fechaformato);
        $dia = $fecha[8] . $fecha[9];
        $mes = $fecha[5] . $fecha[6];
        $anio = $fecha[0] . $fecha[1] . $fecha[2] . $fecha[3];
        $fechafinal = $dia . " de " . $nombremes . " de " . $anio;

        $fechaformatog = formato_fecha_defecto($row_datos['fechagradoregistrograduadoantiguo']);
        $fechag = $row_datos['fechagradoregistrograduadoantiguo'];
        $nombremesg = fechaatextomes($fechaformatog);
        $diag = $fechag[8] . $fechag[9];
        $mesg = $fechag[5] . $fechag[6];
        $aniog = $fechag[0] . $fechag[1] . $fechag[2] . $fechag[3];
        $fechafinalgrado = $diag . " de " . $nombremesg . " de " . $aniog;

        $fechahoy = date("Y-m-d");
$hora = date(" H:i:s");
$mes = date(n)-1;
$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");


        /* Query para insertar */
       $query_insert = "INSERT  INTO logdocumentacioncertificado
    (iddocumentacion, idestudiantegeneral, fechalogdocumentacioncertificado,
    codigologdocumentacioncertificado, iplogdocumentacioncertificado,codigoestado,
    observacionlogdocumentacioncertificado) VALUES(86,
    '{$row_datos['idestudiantegeneral']}','" . $fechahoy . $hora . "',' ',
    '{$_SERVER["REMOTE_ADDR"]}','100',' ')";
        $insert = $db->Execute($query_insert);

        /* Query para buscar el maximo */
          $query_consecutivo = "SELECT max(idlogdocumentacioncertificado) as consecutivo FROM logdocumentacioncertificado";
        $consecutivo = $db->Execute($query_consecutivo);
        $totalRows_consecutivo = $consecutivo->RecordCount();
        $row_consecutivo = $consecutivo->FetchRow();
        $consecutivo = $row_consecutivo['consecutivo'];

      /*TRATO*/
         if ($row_datos['nombregenero']=="Masculino") {

               $trato=explode('(', $row_datos['nombretrato'], 2);
               $trato="el señor";
              }
              else if ($row_datos['nombregenero']=="Femenino") {
                $trato="la señora";
              }
/*IDENTIFICADO*/
               if ($row_datos['nombregenero']=="Masculino") {

              $identificado="identificado";

              }
              else if ($row_datos['nombregenero']=="Femenino") {

               $identificado="identificada";

              }

                /*INTERESADO*/
              if ($row_datos['nombregenero']=="Masculino") {

              $interesado="del interesado";

              }
              else if ($row_datos['nombregenero']=="Femenino") {

               $interesado="de la interesada";

              }


        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $row_datos['nombre'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREDOCUMENTO>", $row_datos['nombredocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NUMERODOCUMENTO>", $row_datos['numerodocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<EXPDOC>", $row_datos['expedidodocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<TRATO>", $trato, $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<IDENTIFICADO>", $identificado, $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<CARRERA>", $row_datos['nombrecarrera'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<APELLIDO>", $row_datos['apellidosestudiantegeneral'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <TITULO>", $row_datos['tituloregistrograduadoantiguo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['3']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIALETRA>", $dias[date('w')], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIA>", date("d"), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MES>", $meses[$mes], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANO>", date("Y"), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <INTERESADO>", $interesado, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha(date("Y"))), $array_interno['4']['textodetallecertificado']);

        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", convercionnumerotexto(date("d")), $array_interno['4']['textodetallecertificado']);
        $array_interno['5']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['5']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<HORA>", $hora, $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIALETRA> ", $dias[date('w')], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIA>", date("d"), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MES>", $meses[$mes], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANO>", date("Y"), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha(date("Y"))), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", convercionnumerotexto(date("d")), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $row_datos['nombre'], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<CONSECUTIVO>", $row_consecutivo['consecutivo'], $array_interno['7']['textodetallecertificado']);
        $array_interno['6']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['6']['textodetallecertificado']);


        $texthtml = $textonicial;
        $texthtml .= "";
        $texthtml.="" . $array_interno['1']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['8']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['2']['textodetallecertificado'] . "";

        $pdf->WriteHTML($texthtml);
        $pdf->SetLeftMargin("20");


        $texthtml = "";
        $texthtml .= "" . $array_interno['3']['textodetallecertificado'] . "";


        $texthtml .= "";
        $texthtml .= "" . $array_interno['4']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['5']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['7']['textodetallecertificado'] . "";

        $texthtml;
        $texthtml.=$textofinal;
        $pdf->WriteHTML($texthtml);


        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(60);
        $pdf->SetX(15);
        $pdf->Cell(180, 5, 'CCD Nº: ' . $consecutivo, 0, 2, 'R');
    }
  /*  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header("Content-Disposition: attachment; filename=certificadotramitediploma.pdf\r\n\r\n");
header('Pragma: no-cache');
header('Content-Type: application/pdf');*/

    $pdf->Output();

}
?>
