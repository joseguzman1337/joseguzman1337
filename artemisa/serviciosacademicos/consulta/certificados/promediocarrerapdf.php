<?php
require_once('../../Connections/sala2.php');
require('../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../funciones/notas/redondeo.php');
require('../../funciones/sala_genericas/FuncionesFecha.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require('../../funciones/clases/html2fpdf/fpdf.php');
require('../../funciones/clases/html2fpdf/html2fpdf.php');
require('../../funciones/sala_genericas/FuncionesCadena.php');
//@session_start();
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

mysql_select_db($database_sala, $sala);
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

$_GET['codigoestudiante'];
if(isset($_GET['codigoestudiante'])) {
    $_SESSION['codigoestudiante'] = $_GET['codigoestudiante'];
}
$codigocarrera = $_REQUEST['codigocarrera'];
 $codigoestudiante = $_SESSION['codigoestudiante'];
$periodo = 0;
$carreraestudiante = 0;
$usuario = 'auxsecgen';
$certificado = '15';
$fechahoy = date("Y-m-d");
$hora = date(" H:i:s");
$mes = date(n)-1;
$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$_SERVER["REMOTE_ADDR"];



// <editor-fold defaultstate="collapsed" desc="Querys">
 $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";
//echo $query_tipousuario;
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

$orientacion = "P";
    $unidad = "mm";
    $formato = "Letter";
    $pdf = new PDF($orientacion, $unidad, $formato);
    $pdf->AddPage();


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


       $query_duracioncarreramax = "SELECT max(nh.idnotahistorico),max(p.nombreperiodo) as ultimoperiodo,max(p.codigoperiodo) FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante";
        $duracioncarreramax = $db->Execute($query_duracioncarreramax);
        $totalRows_duracioncarreramax = $duracioncarreramax->RecordCount();
        $row_duracioncarreramax = $duracioncarreramax->FetchRow();


        $query_duracioncarreramin = "SELECT min(nh.idnotahistorico),min(p.nombreperiodo) as primerperiodo,min(p.codigoperiodo) FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante";
        $duracioncarreramin = $db->Execute($query_duracioncarreramin);
        $totalRows_duracioncarreramin = $duracioncarreramin->RecordCount();
        $row_duracioncarreramin = $duracioncarreramin->FetchRow();

        $query_responsable = "SELECT *
	FROM directivo d,directivocertificado di,certificado c
	WHERE d.codigocarrera = '$codigocarrera'
	AND d.iddirectivo = di.iddirectivo
	AND di.idcertificado = c.idcertificado
	AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
	AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
	AND c.idcertificado = '2'
    ORDER BY fechainiciodirectivo";
                                //echo $query_responsable;
                                $responsable = mysql_query($query_responsable, $sala) or die(mysql_error()." ".$query_responsable);
                                $row_responsable = mysql_fetch_assoc($responsable);
                                $totalRows_responsable = mysql_num_rows($responsable);
                                $contador = 0;

// </editor-fold>



// <editor-fold defaultstate="collapsed" desc="HTML">
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

// </editor-fold>

    $graduadoegresado = false;
   
    $query_historico = "SELECT g.nombregenero,tr.nombretrato,eg.idestudiantegeneral,concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,e.codigosituacioncarreraestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera,codigomodalidadacademica
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg ,trato tr,genero g
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '".$codigoestudiante."'
	AND eg.tipodocumento = doc.tipodocumento and tr.idtrato=eg.idtrato and g.codigogenero=eg.codigogenero
	AND e.codigocarrera = c.codigocarrera
	AND c.codigotitulo = ti.codigotitulo";
        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
        $solicitud_historico = mysql_fetch_assoc($res_historico);
        $carreraestudiante = $solicitud_historico['codigocarrera'];
        $moda = $solicitud_historico['codigomodalidadacademica'];

                if ($res_historico == 0) {
?>
    <script type="text/javascript">
        alert('La busqueda asociada a este programa no arroja resultados, por favor verifique la carrera y fecha de grado o comuniquese con Secretaría General');
        window.location.href='../certificados/entrada/certificadosprueba.php';
    </script>
<?php

}

 $query_insert = "INSERT  INTO logdocumentacioncertificado
    (iddocumentacion, idestudiantegeneral, fechalogdocumentacioncertificado,
    codigologdocumentacioncertificado, iplogdocumentacioncertificado,codigoestado,
    observacionlogdocumentacioncertificado) VALUES(87,
    '{$solicitud_historico['idestudiantegeneral']}','".$fechahoy.$hora."',' ',
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
               if ($solicitud_historico['nombregenero']=="Masculino") {

              $identificado="identificado";

              }
              else if ($solicitud_historico['nombregenero']=="Femenino") {

               $identificado="identificada";

              }
              /*INTERESADO*/
              if ($solicitud_historico['nombregenero']=="Masculino") {

              $interesado="del interesado";

              }
              else if ($solicitud_historico['nombregenero']=="Femenino") {

               $interesado="de la interesada";

              }

        // <editor-fold defaultstate="collapsed" desc="Arrays">
        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $solicitud_historico['nombre'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREDOCUMENTO>", $solicitud_historico['nombredocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NUMERODOCUMENTO>", $solicitud_historico['numerodocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<EXPDOC>",  ucwords(strtolower($solicitud_historico['expedidodocumento'])), $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<CARRERA>", $solicitud_historico['nombrecortocarrera'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<APELLIDO>", $solicitud_historico['apellidosestudiantegeneral'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <PRIMERPERIODO> ", $row_duracioncarreramin['primerperiodo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <ULTIMOPERIODO>", $row_duracioncarreramax['ultimoperiodo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <TITULO>", $solicitud_historico['nombretitulo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<TRATO>", $trato, $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<IDENTIFICADO>", $identificado, $array_interno['3']['textodetallecertificado']);


        $array_interno['4']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MES>", $meses[$mes], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIALETRA>", $dias[date('w')], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIA>", date("d"), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", convercionnumerotexto(date("d")), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANO>", date("Y"), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha(date("Y"))), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <INTERESADO>", $interesado, $array_interno['4']['textodetallecertificado']);

        $array_interno['5']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['5']['textodetallecertificado']);

        $array_interno['7']['textodetallecertificado'] = str_replace("<HORA>", $hora, $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIALETRA> ", $dias[date('w')], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", convercionnumerotexto(date("d")), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIA>", date("d"), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MESNUM>", date('m'), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha(date("Y"))), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANO>", date("Y"), $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $solicitud_historico['nombre'], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MES>", $meses[$mes], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<CONSECUTIVO>", $row_consecutivo['consecutivo'], $array_interno['7']['textodetallecertificado']);

        $array_interno['5']['textodetallecertificado'] = str_replace("<NOMBREDIRECTIVO>", $row_responsable['nombresdirectivo'], $array_interno['5']['textodetallecertificado']);
        $array_interno['5']['textodetallecertificado'] = str_replace("<APELLIDODIRECTIVO>", $row_responsable['apellidosdirectivo'], $array_interno['5']['textodetallecertificado']);
        $array_interno['5']['textodetallecertificado'] = str_replace("<CARGO>", $row_responsable['cargodirectivo'], $array_interno['5']['textodetallecertificado']);


     //date("Y")


        if($solicitud_historico <> "") {



            if($solicitud_historico['codigosituacioncarreraestudiante'] == 400) {
                $graduadoegresado = true;
            }

            if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100) {
                echo '<script language="JavaScript">alert("Este estudiante es egresado, por lo que el certificado se expide en Secretaria General")</script>';

            }

             $pdf->WriteHTML($texthtml);
        $pdf->SetLeftMargin("20");
        $texthtml = $textonicial;
        $texthtml .= "";
        $texthtml.="" . $array_interno['1']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['8']['textodetallecertificado'] . "";

        $texthtml .= "";
        $texthtml .= "" . $array_interno['2']['textodetallecertificado'] . "";

        $pdf->WriteHTML($texthtml);

        $pdf->SetFontSize(12);
        $pdf->SetY(60);
        $pdf->SetX(15);
        $pdf->Cell(180, 5, 'CPC Nº: ' . $consecutivo, 0, 2, 'R');
        

                $cuentacambioperiodo = 0;
                $sumaulas=" ";
                $sumacreditos = " ";
                $periodocalculo = "";
                $indicadorperiodo = 0;
                $ultimoperiodo = 0;

                if (! isset ($_GET['totalperiodos']) ) {
                   $query_historicoperiodos = "SELECT distinct n.codigoperiodo, p.nombreperiodo, e.codigosituacioncarreraestudiante
           from notahistorico n, periodo p, estudiante e, carreraperiodo cp
           where n.codigoestudiante = '$codigoestudiante'
  		   and e.codigoestudiante = n.codigoestudiante
   		   and e.codigocarrera = cp.codigocarrera
		   and cp.codigoperiodo = p.codigoperiodo
  		   and n.codigoperiodo = cp.codigoperiodo
		   and n.codigoestadonotahistorico like '1%'
    	   order by 1";

                    $res_historicoperiodos = mysql_query($query_historicoperiodos, $sala) or die("$query_historicoperiodos".mysql_error());
                    $solicitud_historicoperiodos = mysql_fetch_assoc($res_historicoperiodos);
                    $total_periodosperiodos = mysql_num_rows($res_historicoperiodos);



                    $_GET['totalperiodos'] = $total_periodosperiodos;
                    $j = 1;
                    do {

                        $_GET["periodo".$j] = $solicitud_historicoperiodos['codigoperiodo'];

                        $j ++;
                    }while ($solicitud_historicoperiodos = mysql_fetch_assoc($res_historicoperiodos));
                }

                for ($i=1;$i<=$_GET['totalperiodos'];$i++) {
                    if ($_GET["periodo".$i] == true) {
                        unset($ultimoperiodo);
                        $ultimoperiodo = $_GET["periodo".$i];
                        if ($indicadorperiodo == 0) {
                            $periodocalculo = "n.codigoperiodo = '".$_GET["periodo".$i]."'";
                            $indicadorperiodo = 1;
                        }
                        else {
                            $periodocalculo = "$periodocalculo or n.codigoperiodo = '".$_GET["periodo".$i]."'";
                        }
                        mysql_select_db($database_sala, $sala);

                        if ($_GET['tipocertificado'] == "todo") {
                            $query_historico = "SELECT 	n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
					t.nombretiponotahistorico,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,eg.numerodocumento,
					(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos,pe.nombreperiodo,doc.nombredocumento,e.codigotipoestudiante,n.codigotiponotahistorico, m.codigotipocalificacionmateria
					FROM notahistorico n,materia m,tiponotahistorico t,estudiante e,carrera c,titulo ti,periodo pe,documento doc,estudiantegeneral eg
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					and n.codigoestudiante = '".$codigoestudiante."'
					AND n.codigoestadonotahistorico LIKE '1%'
					and n.codigoestudiante = e.codigoestudiante
					and n.codigotiponotahistorico = t.codigotiponotahistorico
					and eg.tipodocumento = doc.tipodocumento
					and e.codigocarrera = c.codigocarrera
					and m.codigomateria = n.codigomateria
					and pe.codigoperiodo = n.codigoperiodo
					AND pe.codigoperiodo = '".$_GET["periodo".$i]."'
					and c.codigotitulo = ti.codigotitulo
					ORDER BY 1,2";

                            $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                            $solicitud_historico = mysql_fetch_assoc($res_historico);
                        }
                        else
                        if ($_GET['tipocertificado'] == "pasadas") {
                            $query_historico = "SELECT 	n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
					t.nombretiponotahistorico,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,eg.numerodocumento,
					(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos,pe.nombreperiodo,doc.nombredocumento,e.codigotipoestudiante,
					n.codigotiponotahistorico, m.codigotipocalificacionmateria,
					CASE n.notadefinitiva > '5'
					WHEN 0 THEN n.notadefinitiva
	                WHEN 1 THEN n.notadefinitiva / 100 * 1
	                END AS notadefinitiva,
	                CASE m.notaminimaaprobatoria > '5'
					WHEN 0 THEN m.notaminimaaprobatoria
	                WHEN 1 THEN m.notaminimaaprobatoria / 100 * 1
	                END AS notaminimaaprobatoria
					FROM notahistorico n,materia m,tiponotahistorico t,estudiante e,carrera c,titulo ti,periodo pe,documento doc,estudiantegeneral eg
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND n.codigoestudiante = '".$codigoestudiante."'
					AND n.codigoestadonotahistorico LIKE '1%'
					AND n.codigoestudiante = e.codigoestudiante
					AND n.codigotiponotahistorico = t.codigotiponotahistorico
					AND eg.tipodocumento = doc.tipodocumento
					AND e.codigocarrera = c.codigocarrera
					AND m.codigomateria = n.codigomateria
					AND pe.codigoperiodo = n.codigoperiodo
					AND pe.codigoperiodo = '".$_GET["periodo".$i]."'
					AND c.codigotitulo = ti.codigotitulo
					GROUP BY 1
					HAVING notadefinitiva >= notaminimaaprobatoria
					ORDER BY 1,2";

                            $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                            $solicitud_historico = mysql_fetch_assoc($res_historico);
                        }
                        do {

                            mysql_select_db($database_sala, $sala);
                            $mostrarpapa = "";

                            if ($_GET['tipocertificado'] == "todo") {
                                $query_materia = "SELECT *
				  	FROM notahistorico
					WHERE codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
					AND codigoestudiante = '".$codigoestudiante."'
					AND codigoestadonotahistorico LIKE '1%'";

                                $res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
                                $solicitud_materia = mysql_fetch_assoc($res_materia);
                                $totalRows = mysql_num_rows($res_materia);
                            }
                            else
                            if ($_GET['tipocertificado'] == "pasadas") {
                                $query_materia = "SELECT n.*,m.*,
					CASE n.notadefinitiva > '5'
					WHEN 0 THEN n.notadefinitiva
	                WHEN 1 THEN n.notadefinitiva / 100 * 1
	                END AS notadefinitiva,
	                CASE m.notaminimaaprobatoria > '5'
					WHEN 0 THEN m.notaminimaaprobatoria
	                WHEN 1 THEN m.notaminimaaprobatoria / 100 * 1
	                END AS notaminimaaprobatoria
					FROM notahistorico n, materia m
					WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
					AND n.codigoestudiante = '".$codigoestudiante."'
					AND n.codigomateria = m.codigomateria
					AND codigoestadonotahistorico LIKE '1%'
					GROUP BY 1
					HAVING notadefinitiva >= notaminimaaprobatoria ";

                                $res_materia = mysql_query($query_materia, $sala) or die("$query_materia".mysql_error());
                                $solicitud_materia = mysql_fetch_assoc($res_materia);
                                $totalRows = mysql_num_rows($res_materia);
                            }
                            if($solicitud_historico['codigomateriaelectiva'] == '')
                                continue;
                            $query_materiaelectiva = "SELECT *
				FROM materia
				WHERE codigoindicadoretiquetamateria LIKE '1%'
				AND codigomateria like '".$solicitud_historico['codigomateriaelectiva']."'";

                            $materiaelectiva = mysql_query($query_materiaelectiva, $sala) or die("$query_materiaelectiva".mysql_error());
                            $row_materiaelectiva = mysql_fetch_assoc($materiaelectiva);
                            $totalRows_materiaelectiva = mysql_num_rows($materiaelectiva);
                            if($totalRows_materiaelectiva != "") {
                                $solicitud_historico['codigomateria'] = $row_materiaelectiva['codigomateria'];
                                $solicitud_historico['nombremateria'] = $row_materiaelectiva['nombremateria'];

                            }
                            else {
                                if ($solicitud_historico['codigomateriaelectiva'] <> "" and $solicitud_historico['codigomateriaelectiva'] <> "1") {
                                    $mostrarpapa = "";
                                    $query_materiaelectiva1 = "SELECT nombremateria, numerocreditos, codigotipomateria
							FROM materia
							WHERE codigomateria = ".$solicitud_historico['codigomateriaelectiva']."";

                                    $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die("$query_materiaelectiva1".mysql_error());
                                    $row_materiaelectiva1 = mysql_fetch_assoc($materiaelectiva1);
                                    $totalRows_materiaelectiva1 = mysql_num_rows($materiaelectiva1);
                                    if ($totalRows_materiaelectiva1 <> 0) {
                                        $mostrarpapa = $row_materiaelectiva1['nombremateria'];

                                        if($row_materiaelectiva1['codigotipomateria'] == 5) {
                                            $solicitud_historico['numerocreditos'] = $row_materiaelectiva1['numerocreditos'];
                                        }
                                    }
                                }
                            }
                            if ($periodo <> $solicitud_historico['codigoperiodo']) {
                                $nombreultimoperiodo = $solicitud_historico['nombreperiodo'];

        $pdf->Ln(3);
        $pdf->SetLeftMargin("25");
        $texthtml = "";
        $texthtml .= "" . $solicitud_historico['nombreperiodo'] . "";
        $pdf->WriteHTML($texthtml);
        $pdf->Ln(5);

                            }

                            $query_sellugarrotacion = "select l.idlugarorigennota, l.nombrelugarorigennota
					from lugarorigennota l, rotacionnotahistorico r, notahistorico n
					where r.idnotahistorico = '".$solicitud_historico['idnotahistorico']."'
					and r.idlugarorigennota = l.idlugarorigennota
					and n.codigomateria = '".$solicitud_historico['codigomateria']."'
					and n.idnotahistorico = r.idnotahistorico
					order by 2, 1";
                            $sellugarrotacion = mysql_query($query_sellugarrotacion, $sala) or die(mysql_error());
                            $totalRows_sellugarrotacion = mysql_num_rows($sellugarrotacion);
                            $lugaresderotacion = "";

                            if($totalRows_sellugarrotacion != "") {
                                while($row_sellugarrotacion = mysql_fetch_assoc($sellugarrotacion)) {
                                    $nombrelugarorigennota = $row_sellugarrotacion['nombrelugarorigennota'];
                                    $lugaresderotacion = "$lugaresderotacion <br> &nbsp;&nbsp;&nbsp;&nbsp; $nombrelugarorigennota";
                                }
                                $lugaresderotacion = ":".$lugaresderotacion;
                            }



                            $query_detallemateria = "select descripciontemasdetalleplanestudio
	from  temasdetalleplanestudio
	where codigomateria = '".$solicitud_historico['codigomateria']."'
	and   codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
	and   codigoestado like '1%'";
                            $detallemateria = mysql_query($query_detallemateria, $sala) or die(mysql_error());
                            $totalRows_detallemateria = mysql_num_rows($detallemateria);
                            $row_detallemateria = mysql_fetch_assoc($detallemateria);


                             if ($mostrarpapa <> "")
                                echo "$mostrarpapa /  ";

                                     


                                        if ($row_detallemateria <> "") {

                                                do {


                                                }while($row_detallemateria = mysql_fetch_assoc($detallemateria));

                                        }

                                if($_GET['concredito'] == 1) { // if creditos

                                                if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                                    if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                        echo " ";
                                                    }
                                                    else {


                                                       
                                                    }
                                                    $sumaulas=$sumaulas+$solicitud_historico['total'];
                                                }

                                                if($solicitud_historico['codigoindicadorcredito'] == 100) {
                                                    if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                        echo "";
                                                    }
                                                    else {

                                                      
                                                    }
                                                    $sumacreditos=$sumacreditos+$solicitud_historico['numerocreditos'];
                                                }

                                }

                                            if ($solicitud_historico['notadefinitiva'] > 5) {

                                                $nota = number_format(($solicitud_historico['notadefinitiva'] / 100),1);
                                                $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['total']/100] = $solicitud_historico['notadefinitiva']/100;
                                            }
                                            else {
                                                $nota = number_format($solicitud_historico['notadefinitiva'],1);
                                                $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['numerocreditos']] = $solicitud_historico['notadefinitiva'];
                                            }
                                            if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                echo " ";
                                            }
                                            else {

                                                echo number_format($nota,1);
                                            }

                                if($_GET['tiponota'] == 2) {

                                                if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    $pdf->celda(25, 5, $solicitud_historico['nombretiponotahistorico'], 112, 'J', 1,1);

                                                }

                                }

                                        $total = substr($nota,0,3);
                                        $numero =  substr($total,0,1);
                                        $numero2 = substr($total,2,2);
                                        require('convertirnumeros.php');
                                        if($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                            echo "APROBADO";
                                        }
                                        else {

                                            echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                        }

                            $cuentacambioperiodo ++;
                            if ($cuentacambioperiodo == $totalRows) {
                                $cuentacambioperiodo = 0;
                                $periodosemestral = $solicitud_historico['codigoperiodo'];
                                //require('calculopromediosemestral.php');

                                $promediosemestralperiodo = PeriodoSemestralTodo($codigoestudiante,$periodosemestral,$_GET['tipocertificado'],$sala, 1);



                                    if($_GET['concredito'] == 1) {


                                    }

                                                    if ($promediosemestralperiodo > 5) {
                                                        $promediosemestralperiodo = number_format(($promediosemestralperiodo / 100),1);
                                                    }

                                                    echo $promediosemestralperiodo;

                                    if($_GET['tiponota'] == 2) {

                                    }

                                                $numero =  substr($promediosemestralperiodo,0,1);
                                                $numero2 = substr($promediosemestralperiodo,2,2);
                                                require('convertirnumeros.php');

                                                echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";

                                if($_GET['ppsa'] == 3) {



                                        if($_GET['concredito'] == 1) {

                                        }


                                                        $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);

                                                        if($promedioacumuladop > 5) {
                                                            $promedioacumuladop =  number_format(($promedioacumuladop / 100),1);
                                                        }

                                                        echo $promedioacumuladop;


                                        if($_GET['tiponota'] == 2) {

                                        }

                                                    $numero =  substr($promedioacumuladop,0,1);
                                                    $numero2 = substr($promedioacumuladop,2,2);
                                                    require('convertirnumeros.php');

                                                    echo $numu." ".$numu2." ";

                                }	$sumaulas=" ";
                                $sumacreditos = " ";
                            }
                            $periodo = $solicitud_historico['codigoperiodo'];
                        }
                        while($solicitud_historico = mysql_fetch_assoc($res_historico));
                    }
                }
            //}


                if($carreraestudiante == 10) {



                }
                else {



                }

                if($_GET['concredito'] == 1) {

                }


                                 $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado'],$sala);
                    
                    $promedioacumulado1 = round($promedioacumulado, 1);
                    //echo $promedioacumulado1."uno";
                                if($promedioacumulado1 > 5) {
                                    $promedioacumulado1 =  number_format(($promedioacumulado / 100),3);
                                }
                               // echo $promedioacumulado;
                                    
                               $array_interno['3']['textodetallecertificado'] = str_replace("<PROMEDIOGENERAL>", $promedioacumulado1, $array_interno['3']['textodetallecertificado']);
                              
                if($_GET['tiponota'] == 2) {

                }
                            $numero =  substr($promedioacumulado1,0,1);
                            $numero2 = substr($promedioacumulado1,2,2);
                            require('convertirnumeros.php');
                            $promedioacumuladoletra=$numu." ".$numu2;
                            $array_interno['3']['textodetallecertificado'] = str_replace("<PROMEDIOLETRA>", ucwords(strtolower($promedioacumuladoletra)), $array_interno['3']['textodetallecertificado']);
                            
       $array_interno['5']['textodetallecertificado'];
                                                         

       $pdf->SetLeftMargin("20");

        $texthtml = "";
        $texthtml .= "" . $array_interno['3']['textodetallecertificado'] . "";
        $pdf->WriteHTML($texthtml);

       $texthtml = "";
        $texthtml .= "" . $array_interno['4']['textodetallecertificado'] . "";
        $pdf->WriteHTML($texthtml);

        $pdf->Ln(10);
        $pdf->SetLeftMargin("20");
        $texthtml = "";
        $texthtml .= "" . $array_interno['5']['textodetallecertificado'] . "";
        $texthtml .= "";
        $texthtml .= "" . $array_interno['7']['textodetallecertificado'] . "";
        $texthtml;
        $texthtml.=$textofinal;
        $pdf->WriteHTML($texthtml);
        $pdf->Ln(5);
   }
/*
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header("Content-Disposition: attachment; filename=promediocarrera.pdf\r\n\r\n");
header('Pragma: no-cache');
header('Content-Type: application/pdf');*/	

    $pdf->Output();


?>
