<?
mysql_select_db($database_sala, $sala);
//$certificado = '14';
$fechahoy = date("Y-m-d");
$hora = date(" H:i:s");
$mes = date(n)-1;
$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$_SERVER["REMOTE_ADDR"];

$orientacion = "P";
    $unidad = "mm";
    $formato = "Letter";
    $pdf = new PDF($orientacion, $unidad, $formato);
    $pdf->AddPage();
     $pdf->SetDoubleSided(20,10);
    $query_historico = "SELECT 	c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera, e.codigosituacioncarreraestudiante,codigomodalidadacademica
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '".$codigoestudiante."'
	AND eg.tipodocumento = doc.tipodocumento
	AND e.codigocarrera = c.codigocarrera
	AND c.codigotitulo = ti.codigotitulo";
//echo $query_historico;
$res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
$solicitud_historico = mysql_fetch_assoc($res_historico);
$carreraestudiante = $solicitud_historico['codigocarrera'];
$moda = $solicitud_historico['codigomodalidadacademica'];
  
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
font-size: 7pt;'


}
</style>
</head>
<body>

";

    $textofinal = "</body>
</html>";

 
if($solicitud_historico <> "")
    {
    if($solicitud_historico['codigosituacioncarreraestudiante'] == 400)
        {
        $graduadoegresado = true;
    }

    if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400
            and $row_tipousuario['codigotipousuariofacultad'] == 100 and !isset($_GET['consulta'])) {
        echo '<script language="JavaScript">alert("Este estudiante es Graduado, por lo que el certificado se expide en Secretaria General")</script>';
        echo '<script language="JavaScript">history.go(-1)</script>';
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
        $pdf->SetLeftMargin("20");

        $texthtml = "";
        $texthtml .= "" . $array_interno['3']['textodetallecertificado'] . "";
        
       $pdf->WriteHTML($texthtml);
       


        $pdf->SetFontSize(12);
        $pdf->SetY(60);
        $pdf->SetX(15);
        $pdf->Cell(180, 5, 'CNP Nº: ' . $consecutivo, 0, 2, 'R');

        $pdf->SetY(145);
         $pdf->SetFont('', 'B',7);
        $pdf->celda(13, 5, 'CODIGO', 5, 'J', 1, 0);
        $pdf->celda(65, 5, 'MATERIA ', 18, 'J', 1, 0);




        
                if($_GET['concredito']) {
                     $pdf->celda(9, 5., 'ULAS', 83, 'J', 1,0);
        $pdf->celda(15, 5, 'CRÉDITOS',92, 'J', 1, 0);
                   
                }
                  $pdf->celda(10, 5, 'NOTA', 107, 'J', 1, 0);
                
                if($_GET['tiponota']) {
                     $pdf->celda(25, 5, 'TIPO NOTA', 117, 'J', 1, 0);
                   
                }
                $pdf->celda(26, 5, 'LETRAS', 142, 'J', 1, 0);
               
            $cuentacambioperiodo = 0;
            $sumaulas            = " ";
            $sumacreditos        = " ";
            $periodocalculo      = "";
            $indicadorperiodo    = 0;
            $ultimoperiodo       = 0;
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
                    if(!$graduadoegresado) {
                        $query_historico = "SELECT n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
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
					and ($cadenamateria)
					ORDER BY 1,2";

                        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                        $solicitud_historico = mysql_fetch_assoc($res_historico);
                    }
                    else {
                        $query_historico = "SELECT n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
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
					and ($cadenamateria)
					ORDER BY 1,2";
                        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                        $solicitud_historico = mysql_fetch_assoc($res_historico);
                    }
                    do {
                        mysql_select_db($database_sala, $sala);
                        $mostrarpapa = "";
                        if(!$graduadoegresado) {
                            $query_materia = "SELECT *
						FROM notahistorico n
						WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
						and n.codigoestudiante = '".$codigoestudiante."'
						AND n.codigoestadonotahistorico LIKE '1%'
						and ($cadenamateria)";
                        }
                        else {
                            $query_materia = "SELECT *
						FROM notahistorico n, materia m
						WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
						and n.codigoestudiante = '".$codigoestudiante."'
						AND n.codigoestadonotahistorico LIKE '1%'
						and n.codigomateria = m.codigomateria
						and ($cadenamateria)";
                        }

                        $res_materia = mysql_query($query_materia, $sala) or die("$query_materia".mysql_error());
                        $solicitud_materia = mysql_fetch_assoc($res_materia);
                        $totalRows = mysql_num_rows($res_materia);
                        $query_materiaelectiva = "SELECT *
					FROM materia
					WHERE codigoindicadoretiquetamateria LIKE '1%'
					and codigomateria = '".$solicitud_historico['codigomateriaelectiva']."'";

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
                               $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die(mysql_error());
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

                        if($solicitud_historico['codigoperiodo'] != "") {
                            if ($periodo <> $solicitud_historico['codigoperiodo']) {
                                $nombreultimoperiodo = $solicitud_historico['nombreperiodo'];

                          $pdf->Ln(5);
        $pdf->SetLeftMargin("25");
      //  $texthtml = "";
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
                                    $lugaresderotacion = "$lugaresderotacion $nombrelugarorigennota";
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
                                   //    echo $solicitud_historico['nombremateria'].$lugaresderotacion;


                                        if ($row_detallemateria <> "") {

                                                do {


                                                }while($row_detallemateria = mysql_fetch_assoc($detallemateria));

                                        }
                                   
                                if($_GET['concredito'] == 1) {
                                    
                                            if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                                if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    echo " ";
                                                }
                                                else {
                                                     $pdf->celda(9, 5, $solicitud_historico['total'], 78, 'J', 1,0);
                                                    //echo $solicitud_historico['total'];
                                                }
                                                $sumaulas=$sumaulas+$solicitud_historico['total'];
                                            }
                                           
                                            if($solicitud_historico['codigoindicadorcredito'] == 100) {
                                                if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    echo " ";
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
                                              // echo $solicitud_historico['nombretiponotahistorico'];
                                            }
                                            
                                }
                              
                                    $total = substr($nota,0,3);
                                    $numero =  substr($total,0,1);
                                    $numero2 = substr($total,2,2);
                                    require('convertirnumeros.php');
                                    if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                        echo "APROBADO";
                                    }
                                    else {
                                       $pdf->celda(26, 5, $numu." ".$numu2." ", 137, 'J', 1,0);
                                        //echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                    }
                                   

                                     $cuentacambioperiodo ++;
                            //echo "$cuentacambioperiodo == $totalRows <br>";
                            if ($cuentacambioperiodo == $totalRows) {
                                $cuentacambioperiodo = 0;
                                $periodosemestral = $solicitud_historico['codigoperiodo'];
                                //require('calculopromediosemestralmacheteado.php');
                                $promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodosemestral,$cadenamateria,$_GET['tipocertificado'],$sala, 1);
                               


                                  
                               $pdf->SetFont('', 'B');
                                $pdf->Ln(7);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO SEMESTRAL', 0, 'J', 1,0);
                              
                                    if($_GET['concredito'] == 1) {
                                        $pdf->celda(9, 5, $sumaulas, 78, 'J', 1,0);
                                        $pdf->celda(15, 5, $sumacreditos, 87, 'J', 1,0);
                                       
                                    }
                                  
                                                 if ($promediosemestralperiodo > 5) {
                                                    $promediosemestralperiodo =  number_format(($promediosemestralperiodo / 100),1);
                                                }
                                                $promediosemestralperiodo = number_format($promediosemestralperiodo,1);
                                                //echo number_format($promediosemestralperiodo,1);

                                                 $pdf->celda(10, 5, $promediosemestralperiodo, 102, 'J', 1,0);
                                                //echo number_format($promediosemestralperiodo,1);
                                                
                                    if($_GET['tiponota'] == 2) {
                                        
                                    }
                                     				//$total = substr($solicitud_historico['notadefinitiva'],0,3);
                                            $numero =  substr($promediosemestralperiodo,0,1);
                                            $numero2 = substr($promediosemestralperiodo,2,2);
                                            require('convertirnumeros.php');
                                           $pdf->celda(26, 5, $numu." ".$numu2, 137, 'J', 1,0);
                                            //echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                           
                                if($_GET['ppsa'] == 3) {
                                    $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO SEMESTRAL ACUMULADO', 0, 'J', 1,0);
                                    
                                        if($_GET['concredito'] == 1) {

                                            
                                        }
                                       
                                                        $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);
                                                        if($promedioacumuladop > 5) {
                                                            $promedioacumuladop =  number_format(($promedioacumuladop / 100),1);
                                                        }
                                                        //echo $promedioacumuladop;
                                                      
                                        if($_GET['tiponota'] == 2) {
                                           
                                        }
                                      
                                                    $numero =  substr($promedioacumuladop,0,1);
                                                    $numero2 = substr($promedioacumuladop,2,2);
                                                    require('convertirnumeros.php');
                                                    //echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                                   
                                }	$sumaulas =" ";
                                $sumacreditos = " ";
                            }
                            $periodo = $solicitud_historico['codigoperiodo'];
                        }
                    }
                    while($solicitud_historico = mysql_fetch_assoc($res_historico));
                }
            }
        }

            if($carreraestudiante == 100) {

                $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO ACUMULADO A: ', 0, 'J', 1,0);
                                $pdf->Ln(5);
                                $pdf->celda(78, 5, $nombreultimoperiodo, 0, 'J', 1,0);
               
                        //echo $nombreultimoperiodo;
                
            }
            else {
                $pdf->Ln(5);
                                $pdf->celda(78, 5, 'PROMEDIO PONDERADO ACUMULADO : ', 0, 'J', 1,0);
                                $pdf->Ln(2);
                                $pdf->celda(78, 5, $nombreultimoperiodo, 0, 'J', 1,0);
   
            }
           
            if($_GET['concredito'] == 1) {
   
            }

                        $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado'],$sala);
                        $promedioacumulado =  number_format($promedioacumulado,1);
                        if($promedioacumulado > 5) {
                            $promedioacumulado =  number_format(($promedioacumulado / 100),1);
                        }
                        $pdf->celda(10, 5, $promedioacumulado, 102, 'J', 1,0);
                        //echo $promedioacumulado;
            
            if($_GET['tiponota'] == 2) {
    
            }
 $numero =substr($promedioacumulado,0,1);
                            $numero2 =substr($promedioacumulado,2,1);
                            require('convertirnumeros.php');
                            $pdf->celda(26, 5, $numu." ".$numu2, 137, 'J', 1,0);
       
            
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
         $pdf->Output();
   
?>
 
