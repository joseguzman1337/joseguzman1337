<?php
require_once('../../Connections/sala2.php');
require('../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../funciones/notas/redondeo.php');
require('../../funciones/sala_genericas/FuncionesFecha.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require('../../funciones/clases/html2fpdf/fpdf.php');
require('../../funciones/clases/fpdf/doublesided.php');
require('../../funciones/clases/html2fpdf/html2fpdf.php');
require('../../funciones/sala_genericas/FuncionesCadena.php');
//@session_start();
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

mysql_select_db($database_sala, $sala);

if(isset($_GET['codigo'])) {
    $_SESSION['codigo'] = $_GET['codigo'];
}

 $codigocarrera = $_GET['codigocarrera'];

$codigoestudiante = $_SESSION['codigo'];

$periodo = 0;
$carreraestudiante = 0;
$usuario = 'auxsecgen';
$certificado = '14';
$fechahoy = date("Y-m-d");
$hora = date(" H:i:s");
$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$_SERVER["REMOTE_ADDR"];
//$mes1 = substr(date("Y-m-d"),5,2);
 $_REQUEST['fechaexpedicion'];
$fecha_exp=explode("/",$_REQUEST['fechaexpedicion']);
                            $ano = $fecha_exp[2];
                            $mes = $fecha_exp[1];
                            $dia = $fecha_exp[0];

 

class PDF extends HTML2FPDF {

    function celda($w, $h, $string, $x, $align='C', $linea=2, $marco=1, $fill=0) {
        $this->SetXY($this->x + $x, $this->y - ($linea * $h));
        $this->MultiCell($w, $h, $string, $marco, $align, $fill);
    }

function DoubleSided_PDF($orientation='P', $unit='mm', $format='A4')
    {
        $this->FPDF($orientation,$unit,$format);
        $this->doubleSided=false;
        $this->xDelta=0;
        $this->innerMargin=10;
        $this->outerMargin=10;
    }

      function SetDoubleSided($inner=7, $outer=13)
    {
        if($outer != $inner) {
            $this->doubleSided=true;
            $this->outerMargin=$outer;
            $this->innerMargin=$inner;
        }
    }
      function Footer()
{
  
    $this->SetY(267);
    
    $this->SetFont('Arial','I',8);
   
    $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
}


    function Header()
    {
        if ( $this->PageNo() % 2 == 0 ) {
           // $this->Cell(30,0,$this->PageNo(),0,0,'L');
            $this->Cell(0,0,'',0,0,'R');
        }
        else {
            $this->Cell(160,0,' ',0,0,'L');
            //$this->Cell(0,0,$this->PageNo(),0,2,'R');
        }
        //Line break
        $this->SetY(20);
      //  $this->SetLineWidth(0.01);
       // $this->Line($this->lMargin, 18, 210 - $this->rMargin, 18);
        $this->Ln(20);
    }
}






 $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";

$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

$orientacion = "P";
    $unidad = "mm";
    $formato = "Letter";
    $pdf = new PDF($orientacion, $unidad, $formato);
    
    $pdf->AddPage();
    $pdf->SetDoubleSided(20,10);
  



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


     
        $query_duracioncarreramax = "SELECT nh.idnotahistorico,p.nombreperiodo as ultimoperiodo,p.codigoperiodo FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante and
nh.idnotahistorico =(
SELECT max(nh.idnotahistorico) FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante)";
        $duracioncarreramax = $db->Execute($query_duracioncarreramax);
        $totalRows_duracioncarreramax = $duracioncarreramax->RecordCount();
        $row_duracioncarreramax = $duracioncarreramax->FetchRow();


        $query_duracioncarreramin = "SELECT nh.idnotahistorico,p.nombreperiodo as primerperiodo,p.codigoperiodo FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante and
nh.idnotahistorico =(
SELECT min(nh.idnotahistorico) FROM periodo p, estudiante e, estudiantegeneral eg, notahistorico nh
where p.codigoperiodo=nh.codigoperiodo and e.codigoestudiante=nh.codigoestudiante and eg.idestudiantegeneral=e.idestudiantegeneral
and e.codigoestudiante =$codigoestudiante)";
        $duracioncarreramin = $db->Execute($query_duracioncarreramin);
        $totalRows_duracioncarreramin = $duracioncarreramin->RecordCount();
        $row_duracioncarreramin = $duracioncarreramin->FetchRow();

        


         $query_historico = "SELECT c.codigocarrera, g.nombregenero,tr.nombretrato,eg.idestudiantegeneral,concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,e.codigosituacioncarreraestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera,codigomodalidadacademica
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg,trato tr,genero g
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '$codigoestudiante'
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


     /*$ano = substr(date("Y-m-d"),0,4);
     $mes = substr(date("Y-m-d"),5,2);
     $dia = substr(date("Y-m-d"),8,2);*/

        $query_responsable = "SELECT *
	FROM directivo d,directivocertificado di,certificado c
	WHERE d.codigocarrera = ".$solicitud_historico['codigocarrera']."
	AND d.iddirectivo = di.iddirectivo
	AND di.idcertificado = c.idcertificado
	AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
	AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
	AND c.idcertificado = '2'
    ORDER BY fechainiciodirectivo";

   $responsable = mysql_query($query_responsable, $sala) or die(mysql_error()." ".$query_responsable);
  $row_responsable = mysql_fetch_assoc($responsable);
  $totalRows_responsable = mysql_num_rows($responsable);
                                
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

              /*DIAS EXPEDICION*/

                if (convercionnumerotexto($dia)=="primer") {

              $diasletra="el ".convercionnumerotexto($dia);

              }
              else if (convercionnumerotexto($dia)!="primer") {

             $diasletra="a los ".convercionnumerotexto($dia);

              }

        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $solicitud_historico['nombre'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NOMBREDOCUMENTO>", $solicitud_historico['nombredocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<NUMERODOCUMENTO>", $solicitud_historico['numerodocumento'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<EXPDOC>", ucwords(strtolower($solicitud_historico['expedidodocumento'])), $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<CARRERA>", $solicitud_historico['nombrecortocarrera'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<APELLIDO>", $solicitud_historico['apellidosestudiantegeneral'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <PRIMERPERIODO> ", $row_duracioncarreramin['primerperiodo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <ULTIMOPERIODO>", $row_duracioncarreramax['ultimoperiodo'], $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<TRATO>", $trato, $array_interno['3']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace("<IDENTIFICADO>", $identificado, $array_interno['3']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <INTERESADO>", $interesado, $array_interno['4']['textodetallecertificado']);
        $array_interno['3']['textodetallecertificado'] = str_replace(" <TITULO>", $solicitud_historico['nombretitulo'], $array_interno['3']['textodetallecertificado']);


        $array_interno['4']['textodetallecertificado'] = str_replace(" <MESNUM>", $mes, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MES>", $meses[substr($mes, 0)-1], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIALETRA>", $dias[date('w')], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIA>",  $dia,/*date("d")*/ $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", $diasletra, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANO>", $ano/*date("Y")*/, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha($ano)), $array_interno['4']['textodetallecertificado']);

        $array_interno['5']['textodetallecertificado'] = str_replace("<br>", "\n", $array_interno['5']['textodetallecertificado']);

        $array_interno['7']['textodetallecertificado'] = str_replace("<HORA>", $hora, $array_interno['7']['textodetallecertificado']);


        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", $diasletra, $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <DIA>", $dia,/*date("d")*/ $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MESNUM>", $mes, $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANO>",$ano /*date("Y")*/, $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<NOMBREESTUDIANTE>", $solicitud_historico['nombre'], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <MES>", $meses[substr($mes, 0)-1], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace("<CONSECUTIVO>", $row_consecutivo['consecutivo'], $array_interno['7']['textodetallecertificado']);
        $array_interno['7']['textodetallecertificado'] = str_replace(" <ANOLETRA>", strtolower(convercionnumerotextofecha($ano)), $array_interno['7']['textodetallecertificado']);

        $array_interno['5']['textodetallecertificado'] = str_replace("<NOMBREDIRECTIVO>", $row_responsable['nombresdirectivo'], $array_interno['5']['textodetallecertificado']);
        $array_interno['5']['textodetallecertificado'] = str_replace("<APELLIDODIRECTIVO>", $row_responsable['apellidosdirectivo'], $array_interno['5']['textodetallecertificado']);
        $array_interno['5']['textodetallecertificado'] = str_replace("<CARGO>", $row_responsable['cargodirectivo'], $array_interno['5']['textodetallecertificado']);

  /*echo " <pre>";
  print_r($dia);
  echo "</pre>";*/
        //EXIT();
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
font-size: 9pt;'
}
</style>
</head>
<body>

";

    $textofinal = "</body>
</html>";




    $graduadoegresado = false;
    if($_GET['tipocertificado'] == "todo" or $_GET['tipocertificado'] == "pasadas") {
      
        

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
        $texthtml = "";
        $texthtml .= "" . $array_interno['3']['textodetallecertificado'] . "";

        $pdf->WriteHTML($texthtml);
        $pdf->SetFontSize(12);
        $pdf->SetY(60);
        $pdf->SetX(15);
        $pdf->Cell(180, 5, 'CNP Nº: ' . $consecutivo, 0, 2, 'R');

        $pdf->SetY(145);
         $pdf->SetFont('', 'B',7);
        $pdf->celda(13, 5, 'CODIGO'.$_get['fechaexpedicion'], 5, 'J', 1, 0);
        $pdf->celda(65, 5, 'MATERIA ', 18, 'J', 1, 0);


                    if($_GET['concredito']) {
                        /*Credito Ulas*/
        $pdf->celda(9, 5., 'ULAS', 83, 'J', 1,0);
        $pdf->celda(15, 5, 'CRÉDITOS',92, 'J', 1, 0);

                      
                    }
                     $pdf->celda(10, 5, 'NOTA', 107, 'J', 1, 0);
                    
                    if($_GET['tiponota']) {

                         $pdf->celda(25, 5, 'TIPO NOTA', 117, 'J', 1, 0);
                       
                    }
                     $pdf->celda(26, 5, 'LETRAS', 142, 'J', 1, 0);
                   
                $cuentacambioperiodo = 0;
                $sumaulas=" ";
                $sumacreditos = " ";
                $periodocalculo = "";
                $indicadorperiodo = 0;
                $ultimoperiodo = 0;

                if (! isset ($_GET['totalperiodos']) ) {
                   $query_historicoperiodos = "SELECT distinct n.codigoperiodo, p.nombreperiodo, e.codigosituacioncarreraestudiante
           from notahistorico n, periodo p, estudiante e, carreraperiodo cp
           where n.codigoestudiante = $codigoestudiante
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

       $pdf->Ln(5);
        $pdf->SetLeftMargin("25");
         $pdf->celda(150, 5,$solicitud_historico['nombreperiodo'], 0, 'J', 1,0);
      
           
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
                                    $lugaresderotacion = "$lugaresderotacion "."  ". " $nombrelugarorigennota";
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

                            $pdf->SetFont('','',7);
                            $pdf->Ln(5);
                            $pdf->celda(13, 5, $solicitud_historico['codigomateria'], 0, 'J', 1, 0);



                             if ($mostrarpapa <> "")
                               $mostrarpapa;
                             $pdf->celda(65, 5, $mostrarpapa.$solicitud_historico['nombremateria'].$lugaresderotacion, 13, 'J', 1, 0);
                                   
                                    

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
                                                        $pdf->celda(9, 5, $solicitud_historico['total'], 78, 'J', 1,0);

                                                      //  echo $solicitud_historico['total'];
                                                    }
                                                    $sumaulas=$sumaulas+$solicitud_historico['total'];
                                                }
                                               
                                                if($solicitud_historico['codigoindicadorcredito'] == 100) {
                                                    if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                        echo "";
                                                    }
                                                    else {
                                                       $pdf->celda(15, 5, $solicitud_historico['numerocreditos'], 87, 'J', 1,0);
                                                        //echo $solicitud_historico['numerocreditos'];
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
                                                 $pdf->celda(10, 5, number_format($nota,1), 102, 'J', 1,0);
                                                //echo number_format($nota,1);
                                            }
                                            
                                if($_GET['tiponota'] == 2) {
                                    
                                                if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    $pdf->celda(25, 5, $solicitud_historico['nombretiponotahistorico'], 112, 'J', 1,0);
                                                     
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
                                         
                                            $pdf->celda(26, 5, $numu." ".$numu2." ", 137, 'J', 1,0);
                                            //echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                        }
                                        
                            $cuentacambioperiodo ++;
                            if ($cuentacambioperiodo == $totalRows) {
                                $cuentacambioperiodo = 0;
                                $periodosemestral = $solicitud_historico['codigoperiodo'];
                                //require('calculopromediosemestral.php');

                                $promediosemestralperiodo = PeriodoSemestralTodo($codigoestudiante,$periodosemestral,$_GET['tipocertificado'],$sala, 1);
                                $pdf->SetFont('', 'B');
                                $pdf->Ln(7);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO SEMESTRAL', 0, 'J', 1,0);

                                
                                    if($_GET['concredito'] == 1) {
                                $pdf->celda(9, 5, $sumaulas, 78, 'J', 1,0);
                                $pdf->celda(15, 5, $sumacreditos, 87, 'J', 1,0);
                                        
                                    }
                                  
                                                    if ($promediosemestralperiodo > 5) {
                                                        $promediosemestralperiodo = number_format(($promediosemestralperiodo / 100),1);
                                                    }
                                                    $pdf->celda(10, 5, $promediosemestralperiodo, 102, 'J', 1,0);
                                                    /*$promediosemestralperiodo = number_format($promediosemestralperiodo,1);*/
                                                  //  echo $promediosemestralperiodo;
                                                
                                    if($_GET['tiponota'] == 2) {
                                        
                                    }
                                   				
                                                $numero =  substr($promediosemestralperiodo,0,1);
                                                $numero2 = substr($promediosemestralperiodo,2,2);
                                               
                                                require('convertirnumeros.php');
                                                $pdf->celda(26, 5, $numu." ".$numu2, 137, 'J', 1,0);
                                               // echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                                
                                if($_GET['ppsa'] == 3) {
                                $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO SEMESTRAL ACUMULADO', 0, 'J', 1,0);

                                   
                                        if($_GET['concredito'] == 1) {
                                           
                                        }
                                       
                                                        
                                                        $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);
                                                       
                                                        if($promedioacumuladop > 5) {
                                                            $promedioacumuladop =  number_format(($promedioacumuladop / 100),0);
                                                        }

                                                          $pdf->celda(10, 5, $promedioacumuladop, 102, 'J', 1,0);
                                                        //echo $promedioacumuladop;
                                                        
                                                       
                                        if($_GET['tiponota'] == 2) {
                                            
                                        }
                                                   
                                                    $numero =  substr($promedioacumuladop,0,1);
                                                    $numero2 = substr($promedioacumuladop,2,2);
                                                    require('convertirnumeros.php');

                                                    //echo $numu." ".$numu2." ";
                                                    
                                }	$sumaulas=" ";
                                $sumacreditos = " ";
                            }
                            $periodo = $solicitud_historico['codigoperiodo'];
                        }
                        while($solicitud_historico = mysql_fetch_assoc($res_historico));
                    } 
                } 
            }
           
   
                if($carreraestudiante == 10) {
                                $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO ACUMULADO A: ', 0, 'J', 1,0);

                                $pdf->Ln(5);
                                $pdf->celda(78, 5, $nombreultimoperiodo, 0, 'J', 1,0);

                   
                }
                else {
                                $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO ACUMULADO : ', 0, 'J', 1,0);
                                $pdf->Ln(5);
                                $pdf->celda(78, 5, $nombreultimoperiodo, 0, 'J', 1,0);


                    
                }
                
                if($_GET['concredito'] == 1) {
       
                }
    
                              
                                $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado'],$sala);
                                 $promedioacumulado =  number_format($promedioacumulado,1);
                                if($promedioacumulado > 5) {
                                   
                                    $promedioacumulado =  number_format($promedioacumulado,1);
                                }
                                 $pdf->celda(10, 5, $promedioacumulado, 102, 'J', 1,0);
                               echo  $prueba;
    
                if($_GET['tiponota'] == 2) {
        
                }
   
                //echo $promedioacumulado;
                //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                            $numero =substr($promedioacumulado,0,1);
                            $numero2 =substr($promedioacumulado,2,1);
                            require('convertirnumeros.php');
                            $pdf->celda(26, 5, $numu." ".$numu2, 137, 'J', 1,0);
 //echo $numu.$numu1;

                         // exit();


        $array_interno['4']['textodetallecertificado'] = str_replace(" <MESNUM>", $mes, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <MES>", $meses[substr($mes, -1)-1], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIALETRA>", $dias[date('w')], $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIA>",  $dia,/*date("d")*/ $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <DIANOMBRE>", convercionnumerotexto($dia), $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANO>", $ano/*date("Y")*/, $array_interno['4']['textodetallecertificado']);
        $array_interno['4']['textodetallecertificado'] = str_replace(" <ANOLETRA>", ucwords(strtolower(convercionnumerotextofecha($ano))), $array_interno['4']['textodetallecertificado']);


        $pdf->Ln(10);
        
        $pdf->SetLeftMargin("20");
        $texthtml = "";
        $texthtml .= "" . $array_interno['4']['textodetallecertificado'] . "";
        $pdf->WriteHTML($texthtml);
        $texthtml = "";
        $texthtml .= "" . $array_interno['5']['textodetallecertificado'] . "";
        $texthtml .= "";
     
        $texthtml .= "" . $array_interno['7']['textodetallecertificado'] . "";
        $texthtml;
        $texthtml.=$textofinal;
        $pdf->WriteHTML($texthtml);
      
   
}
if($_GET['tipocertificado'] == "reglamento") {
    if(isset($_GET['periodos'])) {
        $query_selperiodos = "SELECT distinct codigoperiodo
	    from notahistorico
	    where codigoestudiante = '$codigoestudiante'
		order by 1";
        $selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
        $total_selperiodos = mysql_num_rows($selperiodos);
        $_GET['totalperiodos'] = $total_selperiodos;
        $estei = 1;
        while($row_selperiodos = mysql_fetch_assoc($selperiodos)) {
            $_GET["periodo".$estei] = $row_selperiodos['codigoperiodo'];
            $estei++;
        }
    }
   

    $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
	when 0 then n.notadefinitiva
	when 1 then n.notadefinitiva / 100
	end as nota, n.codigoperiodo, m.nombremateria
	from notahistorico n, materia m
	where n.codigoestudiante = '$codigoestudiante'
	and n.codigomateria = m.codigomateria
	AND codigoestadonotahistorico LIKE '1%'
	order by 5, 3 ";
   
    $materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error()." Query=".$query_materiashistorico);
    $totalRows_materiashistorico = mysql_num_rows($materiashistorico);
    $cadenamateria = "";

    while($row_materiashistorico = mysql_fetch_assoc($materiashistorico)) {
       
        if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala)) {
            
            $formato = " n.codigomateria = ";
           
            $row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
            $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
            
        }
        else {
            $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
        }
    }
  
    $Array_materiashistoricoinicial = $Array_materiashistorico;
    
    foreach($Array_materiashistorico as $codigomateria => $row_materia) {
       $otranota = $row_materia['nota']*100;
       $cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
        $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
    }
    
    $cadenamateria = $cadenamateria."fin";
    $cadenamateria = ereg_replace("orfin","",$cadenamateria);
    
    require("certificadoconreglamentonota.php");
    
}
/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header("Content-Disposition: attachment; filename=notaperiodo.pdf\r\n\r\n");
header('Pragma: no-cache');
header('Content-Type: application/pdf');*/

    $pdf->Output();
?>
