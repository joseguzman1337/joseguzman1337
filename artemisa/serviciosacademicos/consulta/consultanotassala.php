<?php
require_once('../Connections/sala2.php');
require('../funciones/notas/funcionequivalenciapromedio.php');
require ('../funciones/notas/redondeo.php');
require ('../funciones/notas/funcionesMaterias.php');
$link = "../../imagenes/estudiantes/";
session_start();
mysql_select_db($database_sala, $sala);

//echo '<pre>';print_r($_SESSION);

$codigoestudiante = $_SESSION['codigo'];

$creditos=0;
$periodocon="";
//$_SESSION['codigo']= "05110002";
$query_periodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p, estudiante e, carreraperiodo cp
where cp.codigocarrera = e.codigocarrera
and p.codigoperiodo = cp.codigoperiodo
and e.codigoestudiante = '$codigoestudiante'
ORDER BY p.codigoperiodo DESC";
//echo "$query_periodo<br>";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if (!$_POST['periodo']) {
    $periodocon=$row_periodo['codigoperiodo'];
}
else {
    $periodocon=$_POST['periodo'];
}
if ($_POST['Submit']) {
    // echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/consultahistoricooperacion.php'>";
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/certificados/certificadosformulario.php?tipocertificado=todo&periodos=true'>";
    exit();
}
$query_Recordset1 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
FROM prematricula p,detalleprematricula d,materia m,grupo g
WHERE  p.codigoestudiante = '".$_SESSION['codigo']."'
AND p.idprematricula = d.idprematricula
AND d.codigomateria = m.codigomateria
AND d.idgrupo = g.idgrupo
AND m.codigoestadomateria = '01'
AND g.codigoperiodo = '".$periodocon."'
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula LIKE '3%'";
//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT *
FROM estudiante e,estudiantegeneral eg
WHERE e.idestudiantegeneral = eg.idestudiantegeneral
and e.codigoestudiante = '".$_SESSION['codigo']."'";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$facultad=$row_Recordset2['codigocarrera'];
$carreraestudiante = $facultad;
//require('facultades/boletines/calculopromedioacumulado.php');
mysql_select_db($database_sala, $sala);
$query_Recordset3 = sprintf("SELECT * FROM carrera WHERE codigocarrera = '%s'",$row_Recordset2['codigocarrera']);
$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

/* if($facultad == '130' or $facultad == '131' or $facultad == '132')   // se comenta por Orden Wilmar 05-12-2006 se volvio a colocar por orden de Wilmar 2007-03-22
 {

 $query_periodoevaluacion = "select *
 from periodo p
 where codigoestadoperiodo = '3'";
 //echo "$query_periodo<br>";
 $periodoevaluacion = mysql_query($query_periodoevaluacion, $sala) or die(mysql_error());
 $row_periodoevaluacion = mysql_fetch_assoc($periodoevaluacion);
 $totalRows_periodoevaluacion = mysql_num_rows($periodoevaluacion);

 if (!$row_periodoevaluacion)
 {
 $query_periodoevaluacion = "select *
 from periodo p
 where codigoestadoperiodo = '1'";
 //echo "$query_periodo<br>";
 $periodoevaluacion = mysql_query($query_periodoevaluacion, $sala) or die(mysql_error());
 $row_periodoevaluacion = mysql_fetch_assoc($periodoevaluacion);
 $totalRows_periodoevaluacion = mysql_num_rows($periodoevaluacion);
 }
 $periodoevaluar = $row_periodoevaluacion['codigoperiodo'];
 // Valida si tiene evaluación docente
 $query_selevaluacion = "SELECT codigoestudiante
 FROM evaluacion.materiaestudianteevaluada
 WHERE periodo = '$periodoevaluar'
 AND evaluada = 1
 AND codigoestudiante = '".$_SESSION['codigo']."'";
 //echo $query_selevaluacion;
 @$selevaluacion = mysql_query($query_selevaluacion, $sala);
 @$row_selevaluacion = mysql_fetch_assoc($selevaluacion);
 @$totalRows_selevaluacion = mysql_num_rows($selevaluacion);
 if($totalRows_selevaluacion == "")
 {
 ?>
 <script language="javascript">
 alert("Debe realizar la encuesta Docente de la Facultad");
 history.go(-1);
 </script>
 <?php
 }
 }
*/?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Documento sin t&iacute;tulo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script language="JavaScript" type="text/JavaScript">
            <!--
            function MM_jumpMenu(targ,selObj,restore){ //v3.0
                eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
                if (restore) selObj.selectedIndex=0;
            }
            function MM_findObj(n, d) { //v4.01
                var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                if(!x && d.getElementById) x=d.getElementById(n); return x;
            }
            function MM_jumpMenuGo(selName,targ,restore){ //v3.0
                var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
            }
            //-->
        </script>
    </head>
    <link rel="stylesheet" href="../estilos/sala.css" type="text/css">
    <body>
<?php
require('../funciones/datosestudiante.php');
datosestudiante($codigoestudiante,$sala,$database_sala,$link);
        ?>
        <form name="form1" method="post" action="consultanotassala.php">
            <p>REGISTRO DE CALIFICACIONES</p>
            <table width="750" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr>
                    <td id="tdtitulogris">Periodo</td>
                    <td><select name="periodo"
                                onChange="MM_jumpMenu('consultanotassala.php',this,0)">
<?php
do {
    ?>
                            <option value="<?php echo $row_periodo['codigoperiodo']?>"
                                        <?php if (!(strcmp($row_periodo['codigoperiodo'], $_POST['periodo']))) {
                                            echo "SELECTED";
    } ?>><?php echo $row_periodo['nombreperiodo']?></option>
                                        <?php
                                    } while ($row_periodo = mysql_fetch_assoc($periodo));
                                    $rows = mysql_num_rows($periodo);
                                    if($rows > 0) {
                                        mysql_data_seek($periodo, 0);
                                        $row_periodo = mysql_fetch_assoc($periodo);
                                    }
                                    ?>
                        </select> <input type="submit" name="Button1" value="Actualizar"
                                         onClick="MM_jumpMenuGo('menu1','parent',0)"></td>
                    <td id="tdtitulogris">Fecha</td>
                    <td><?php echo date("j/m/Y",time());?>&nbsp;</td>
                </tr>
            </table>
<?php
            if ($row_Recordset1 <> "") {// if1
                ?>
            <table width="750" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr id="trtitulogris">
    <?php
    $promedio=0;
                        $guardaidgrupo[]=0;
                        $g = 0;
                        $banderaimprime = 0;
                        $numerocreditos = 0;
                        $query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
    FROM prematricula p,detalleprematricula d,materia m,grupo g
    WHERE  p.codigoestudiante = '".$_SESSION['codigo']."'
    AND p.idprematricula = d.idprematricula
    AND d.codigomateria = m.codigomateria
    AND d.idgrupo = g.idgrupo
    AND m.codigoestadomateria = '01'
    AND g.codigoperiodo = '".$periodocon."'
    AND p.codigoestadoprematricula LIKE '4%'
    AND d.codigoestadodetalleprematricula LIKE '3%'";
                        //AND g.codigomaterianovasoft = m.codigomaterianovasoft
                        //echo $query_Recordset1;
                        $Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
                        $row_Recordset9 = mysql_fetch_assoc($Recordset9);
                        $totalRows_Recordset9 = mysql_num_rows($Recordset9);
                        $ultimocorte = 0;
                        do {
                            $query_fecha ="SELECT distinct c.numerocorte
    	FROM corte c
    	WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."'
    	AND c.codigoperiodo = '".$periodocon."'";
                            //and c.codigomaterianovasoft = '".$row_Recordset9['codigomaterianovasoft']."'
                            //echo $query_fecha,"</br>";
                            $fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
                            $row_fecha = mysql_fetch_assoc($fecha);
                            $totalRows_fecha = mysql_num_rows($fecha);
                            $i= 1;
                            $contadorcortes = 0;
                            if ($totalRows_fecha <> 0) {
                                do {
                                    $contadorcortes +=1;
                                }
                                while ($row_fecha = mysql_fetch_assoc($fecha));
                            }
                            elseif ($totalRows_fecha==0) {
                                mysql_select_db($database_sala, $sala);
                                $query_fecha = "SELECT distinct numerocorte
            FROM corte
        	WHERE codigocarrera = '".$facultad."'
        	and codigoperiodo = '".$periodocon."'
            order by numerocorte";
                                //echo $query_fecha;
                                $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                                $row_fecha = mysql_fetch_assoc($fecha);
                                $totalRows_fecha = mysql_num_rows($fecha);
                                do {
                                    $contadorcortes +=1;
                                }
                                while ($row_fecha = mysql_fetch_assoc($fecha));
                            }

                            if ($totalRows_fecha==0) {
                                $query_fecha = "SELECT distinct numerocorte
            FROM detallenota,materia,corte
            WHERE  materia.codigoestadomateria = '01'
            AND detallenota.codigomateria=materia.codigomateria
            AND detallenota.idcorte=corte.idcorte
            AND detallenota.codigoestudiante = '".$_SESSION['codigo']."'
            AND detallenota.codigomateria = '".$row_Recordset9['codigomateria']."'
            AND corte.codigoperiodo = '".$periodocon."'";
                                $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                                $row_fecha = mysql_fetch_assoc($fecha);
                                $totalRows_fecha = mysql_num_rows($fecha);
                                do {
                                    $contadorcortes +=1;
                                }
                                while ($row_fecha = mysql_fetch_assoc($fecha));
                            }
                            //echo $ultimocorte,"&nbsp;",$contadorcortes,"<br>";
                            if ($ultimocorte < $contadorcortes) {
                                $ultimocorte = $contadorcortes;
                            }
                        }
                        while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));
                        do {
                            /////////////
                            if ($banderaimprime == 0) {
                                echo "<td width='10%'>C&oacute;digo</td>";
                                echo "<td width='28%'>Nombre Asignatura</td>";
                                echo "<td width='3%'>Cr</td>";
                                for ($i=1;$i<=$ultimocorte;$i++) {
                                    echo "<td width='3%'>C".$i."</td>";
                                    echo "<td width='3%'>%</td>";
                                }
                                echo "<td width='3%'>PPA</td>";
                                echo "<td width='3%'>NPA</td>";
                                echo "<td width='3%'>F%</td>";
                                echo "<td width='3%'>R</td>";
                                echo "<td width='3%'>FT</td>";
                                echo "<td width='3%'>FP</td>";
                                echo "</tr>";
                                $banderaimprime = 1;
                            }
                            ////////////////////////
                            $contador= 1;
                            $query_Recordset8 ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,
    grupo.codigomateria,corte.porcentajecorte
	FROM detallenota,materia,grupo,corte
	WHERE  materia.codigomateria=grupo.codigomateria
    AND materia.codigoestadomateria = '01'
	AND detallenota.idgrupo=grupo.idgrupo
	AND detallenota.idcorte=corte.idcorte
	AND detallenota.codigoestudiante = '".$_SESSION['codigo']."'
	AND detallenota.codigomateria = '".$row_Recordset1['codigomateria']."'
	AND grupo.codigoperiodo = '".$periodocon."' and detallenota.codigoestado=100
    ORDER BY corte.numerocorte";
                            //AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft
                            // echo $query_Recordset8,"</br>";
                            //exit;
                            $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
                            $row_Recordset8 = mysql_fetch_assoc($Recordset8);
                            $totalRows_Recordset8 = mysql_num_rows($Recordset8);
                            $query_data = "select notadefinitiva
	  from notahistorico
	  where codigoestudiante = '".$codigoestudiante."'
	  and codigomateria = '".$row_Recordset1['codigomateria']."'
	  and codigoperiodo = '".$periodocon."'
 	  and codigotiponotahistorico not like '100%'
	  and codigoestadonotahistorico like '1%'";
                            // echo $query_data;
                            $data = mysql_query($query_data, $sala) or die(mysql_error());
                            $row_data = mysql_fetch_assoc($data);
                            $totalRows_data = mysql_num_rows($data);
		
	$row_historico2 = verificarHistoricoMateria($sala,$codigoestudiante,$periodocon,$row_Recordset1['codigomateria']);	
	if(!$row_historico2){
                            ?>


                <tr>
                    <td><?php echo $row_Recordset1['codigomateria']; ?></td>
                    <td>
                        <?php echo $row_Recordset1['nombremateria']; ?>

                    </td>
                    <td><?php echo $row_Recordset1['numerocreditos'];
                            $numerocreditos = $numerocreditos + $row_Recordset1['numerocreditos'];?>&nbsp;</td>
                            <?php
                            $habilitacion = "";
                            $notafinal = 0;
        $porcentajefinal = 0;
        $notadividida = 0;
        $ft = 0;
        $fp = 0;
        do {
            if ($row_Recordset8['codigotiponota'] == 10) {
                if ($row_data <> "") {
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                                        }
                                    else {
                                        echo "<td>".$row_Recordset8['nota']."&nbsp;</td>";
                                        echo "<td>".$row_Recordset8['porcentajecorte']."%&nbsp;</td>";
                                    }
                                    $notafinal = $notafinal + ($row_Recordset8['nota'] * $row_Recordset8['porcentajecorte'])/100;
                                    $notadividida = $notadividida + $row_Recordset8['nota'];
                                    $porcentajefinal = $porcentajefinal + $row_Recordset8['porcentajecorte'];
                                    $contador++;
                                    $ft += $row_Recordset8['numerofallasteoria'];
                                    $fp += $row_Recordset8['numerofallaspractica'];
                                }
                            }
                            while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));
                            /*Se redondea aca ahora para que la nota sea siempre la misma tanto para notas parciales como para cuando muestra la definitiva.*/
                            $notafinal=redondeo($notafinal);
			    $creditosnota = $notafinal * $row_Recordset1['numerocreditos'];
                            $promedio =  $promedio + $creditosnota;
                            $suma = $ultimocorte - $contador;
                            for ($i=0;$i<=$suma;$i++) {
                                echo "<td>&nbsp;</td>";
                                echo "<td>&nbsp;</td>";
                            }
                            /* $notafinal = number_format($notafinal,1);
	  $notafinal = round($notafinal * 10)/10;   */
                            //$notafinal = redondeo($notafinal);
                            //$notafinal = round($notafinal,2);
                            if ($row_data <> "") {
                                $habilitacion = $row_data['notadefinitiva'];
                            }
                            $query_notagrabada = "select notadefinitiva
	    from notahistorico
		where codigoestudiante = '".$codigoestudiante."'
		and codigomateria = '".$row_Recordset1['codigomateria']."'
    	and codigoperiodo = '".$periodocon."'
    	and codigotiponotahistorico = '100'
    	and codigoestadonotahistorico like '1%'";
                            $notagrabada = mysql_query($query_notagrabada, $sala) or die(mysql_error());
                            $row_notagrabada= mysql_fetch_assoc($notagrabada);
                            $totalRows_notagrabada= mysql_num_rows($notagrabada);

                            if( ! $row_notagrabada) {
                                echo "<td width='3%'>".$notafinal."&nbsp;</td>";
                            }
                            else {
                                echo "<td width='3%'>".number_format($row_notagrabada['notadefinitiva'],1)."&nbsp;</td>";
                            }
                            if ($porcentajefinal <> 0) {
                                if( ! $row_notagrabada) {
                                    echo "<td width='3%'>".number_format(number_format($notafinal,2)/($porcentajefinal/100),1)."&nbsp;</td>";
                                }
                                else {
                                    echo "<td width='3%'>".number_format($row_notagrabada['notadefinitiva'],1)."&nbsp;</td>";
                                }
                            }
                            echo "<td width='3%'>".$porcentajefinal."%&nbsp;</td>";
                            echo "<td width='3%'>".substr($habilitacion,0,3)."&nbsp;</td>";
                            echo "<td width='3%'>".$ft."&nbsp;</td>";
                            echo "<td width='3%'>".$fp."&nbsp;</td>";
                            echo "</tr>";
	} //if row_historico2
                            $g++;
                        }
                        while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>


                <tr>
                    <td colspan="2"><strong>Promedio Ponderado Semestral:&nbsp; <?php
                        $query_procesoperiodo = "SELECT	*
    	FROM procesoperiodo
    	WHERE codigoperiodo = '$periodocon'
        and codigocarrera = '$facultad'
    	and idproceso = '1'
    	and codigoestadoprocesoperiodo = '200'";
                        //echo $query_procesoperiodo;
                        $procesoperiodo = mysql_query($query_procesoperiodo, $sala) or die(mysql_error());
                        $row_procesoperiodo = mysql_fetch_assoc($procesoperiodo);
                        $totalRows_procesoperiodo = mysql_num_rows($procesoperiodo);
                        if ($row_procesoperiodo <> "") {
                            /////////////////////////////////////////// calculo semestre ponderado //////////////////////////////////////
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
                                    // Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo
                                    $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
    	 when 0 then n.notadefinitiva
    	 when 1 then n.notadefinitiva / 100
     	 end as nota, n.codigoperiodo, m.nombremateria
    	 from notahistorico n, materia m
    	 where n.codigoestudiante = '$codigoestudiante'
    	 and n.codigomateria = m.codigomateria
    	 and codigoestadonotahistorico like '1%'
    	 order by 5, 3 ";
                                    //echo $query_materiashistorico;
                                    //exit();
                                    $materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error());
                                    $totalRows_materiashistorico = mysql_num_rows($materiashistorico);
                                    $cadenamateria = "";
                                    while($row_materiashistorico = mysql_fetch_assoc($materiashistorico)) {
                                        // Coloco las materias equivalentes del estudiante en un arreglo y selecciono
                                        // la mayor de esas notas, con el codigo de la materia mayor.
                                        // Arreglo de las materias con las mejores notas del estudiante
                                        if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala)) {
                                            //echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
                                            $formato = " n.codigomateria = ";
                                            // Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
                                            // $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
                                            // $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                                            //echo "$Cad_equivalencias<br>";
                                            // exit();
                                            $row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            //echo "<br><br>".seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            //echo "<br>materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
                                        }
                                        else {
                                            $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                                        }
                                    }
                                    //exit();
                                    $Array_materiashistoricoinicial = $Array_materiashistorico;
                                    // Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
                                    // Para esto primero creo un arreglo con las equivalencias de cada materia
									//var_dump($Array_materiashistorico);
                                    foreach($Array_materiashistorico as $codigomateria => $row_materia) {
                                        //echo "$codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
                                        $otranota = $row_materia['nota']*100;
                                        // Arreglo bidimensional con las materias en cada periodo
                                        $cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
                                        $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
                                    }
									//var_dump($Array_materiasperiodo);
                                    //exit();
                                    $cadenamateria = $cadenamateria."fin";
                                    $cadenamateria = ereg_replace("orfin","",$cadenamateria);
                                    // $periodosemestral = $periodocon;
                                    // require('facultades/boletines/calculopromediosemestralmacheteado.php');
                                    //$promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodocon,$cadenamateria,$_GET['tipocertificado']="",$sala,1);
                                    $promediosemestralperiodo =PeriodoSemestralTodo($codigoestudiante,$periodocon,$_GET['tipocertificado']="",$sala, 1);
									echo $promediosemestralperiodo;
                                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                }
                                else {
                                    //$promediototal = number_format($promedio/$numerocreditos,2);
                                    //$float_redondeado=round($promediototal * 10)/10;
                                    $float_redondeado = $promedio/$numerocreditos;
                                    $float_redondeado = redondeo($float_redondeado);
                                    echo $float_redondeado,"<br>" ;
                                }
                                ?> </strong></td>
                    <td colspan="20"><strong>Promedio Ponderado Acumulado:&nbsp; <?php
                                $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);
                                echo $promedioacumulado;
                                ?> </strong> &nbsp;</td>
                </tr>
            </table>
            <table width="750" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr>
                    <td><label id="labelresaltado">C = Corte</label></td>
                    <td><label id="labelresaltado">R = Recuperaci&oacute;n</label></td>
                    <td><label id="labelresaltado">Cr = Cr&eacute;ditos</label></td>
                    <td><label id="labelresaltado">PPA = Puntos Promedio Acumulado</label></td>
                    <td><label id="labelresaltado">NPA = Nota Promedio Acumulada</label></td>
                    <td><label id="labelresaltado">F%= Porcentaje Final</label></td>
                    <td><label id="labelresaltado">% = Porcentaje del corte</label></td>
                    <td><label id="labelresaltado">FT = Fallas Teóricas</label></td>
                    <td><label id="labelresaltado">FP = Fallas Práctica</label></td>
                </tr>
                <tr>
                    <td height="44" colspan="9">					
					<span style="display:inline-block;margin-top:5px;font-size:0.9em;">
					* El promedio ponderado semestral es calculado con las calificaciones obtenidas en el 
					<?php echo substr($periodocon, 0, -1)."-".substr($periodocon,strlen($periodocon)-1); ?>.</span>
					<br/><br/>
                        <label id="labelresaltado">NO V&Aacute;LIDO COMO CERTIFICADO DE NOTAS
                            <br>
		Cualquier inconsistencia favor comunicarla a su Facultad.</label>
                        <p><input type="submit" name="Submit" value="Historial Académico"></p>
                    </td>
                </tr>
            </table>
                                <?php
                            }//if 1
else {
                                $query_Recordset1 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,n.codigoestudiante
    FROM notahistorico n,materia m
    WHERE  n.codigoestudiante = '".$_SESSION['codigo']."'
    AND n.codigomateria = m.codigomateria
    AND m.codigoestadomateria = '01'
    AND n.codigoperiodo = '".$periodocon."'
    AND n.codigoestadonotahistorico LIKE '1%'";
    //AND g.codigomaterianovasoft = m.codigomaterianovasoft
    //echo $query_Recordset1;
    $Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
    $totalRows_Recordset1 = mysql_num_rows($Recordset1);
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    if($totalRows_Recordset1 <> 0) {
        ?>
            <table width="750" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr id="trtitulogris">
        <?php
        $promedio=0;
        $guardaidgrupo[]=0;
        $g = 0;
        $banderaimprime = 0;
                                    $numerocreditos = 0;
        $query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,n.codigoestudiante
    FROM notahistorico n,materia m
    WHERE  n.codigoestudiante = '".$_SESSION['codigo']."'
    AND n.codigomateria = m.codigomateria
    AND m.codigoestadomateria = '01'
    AND n.codigoperiodo = '".$periodocon."'
    AND n.codigoestadonotahistorico LIKE '1%'";
                    //AND g.codigomaterianovasoft = m.codigomaterianovasoft
                    //echo $query_Recordset9;
                    $Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
                    $row_Recordset9 = mysql_fetch_assoc($Recordset9);
                    $totalRows_Recordset9 = mysql_num_rows($Recordset9);
                    $ultimocorte = 0;
                    do {
                        $query_fecha ="SELECT distinct c.numerocorte
    	FROM corte c
    	WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."'
    	AND c.codigoperiodo = '".$periodocon."'";
                        //and c.codigomaterianovasoft = '".$row_Recordset9['codigomaterianovasoft']."'
                        //echo $query_fecha,"</br>";
                        $fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
                        $row_fecha = mysql_fetch_assoc($fecha);
                        $totalRows_fecha = mysql_num_rows($fecha);
            $i= 1;
            $contadorcortes = 0;
            if ($totalRows_fecha <> 0) {
                                    do {
                                        $contadorcortes +=1;
                                    }
                                    while ($row_fecha = mysql_fetch_assoc($fecha));
                                }
                                elseif ($totalRows_fecha==0) {
                                    mysql_select_db($database_sala, $sala);
                                    $query_fecha = "SELECT distinct numerocorte
            FROM corte
        	WHERE codigocarrera = '".$facultad."'
        	and codigoperiodo = '".$periodocon."'
            order by numerocorte";
                                    //echo $query_fecha;
                                    $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                                    $row_fecha = mysql_fetch_assoc($fecha);
                                    $totalRows_fecha = mysql_num_rows($fecha);
                                    do {
                                        $contadorcortes +=1;
                                    }
                                    while ($row_fecha = mysql_fetch_assoc($fecha));
                                }

                                if ($totalRows_fecha==0) {
                                    $query_fecha = "SELECT distinct numerocorte
            FROM detallenota,materia,corte
            WHERE  materia.codigoestadomateria = '01'
            AND detallenota.codigomateria=materia.codigomateria
            AND detallenota.idcorte=corte.idcorte
            AND detallenota.codigoestudiante = '".$_SESSION['codigo']."'
            AND detallenota.codigomateria = '".$row_Recordset9['codigomateria']."'
            AND corte.codigoperiodo = '".$periodocon."'";
                                    $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                                    $row_fecha = mysql_fetch_assoc($fecha);
                                    $totalRows_fecha = mysql_num_rows($fecha);
                                    do {
                                        $contadorcortes +=1;
                                    }
                                    while ($row_fecha = mysql_fetch_assoc($fecha));
                                }
                                //echo $ultimocorte,"&nbsp;",$contadorcortes,"<br>";
                                if ($ultimocorte < $contadorcortes) {
                                    $ultimocorte = $contadorcortes;
                                }
                            }
                            while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));
                            do {
                                /////////////
                                if ($banderaimprime == 0) {
                                    echo "<td width='10%'>C&oacute;digo</td>";
                                    echo "<td width='28%'>Nombre Asignatura</td>";
                                    echo "<td width='3%'>Cr</td>";
                                    for ($i=1;$i<=$ultimocorte;$i++) {
                                        //echo "<td width='3%'>C".$i."</td>";
                                        //echo "<td width='3%'>%</td>";
                                    }
                                    echo "<td width='3%'>PPA</td>";
                                    echo "<td width='3%'>NPA</td>";
                                    echo "<td width='3%'>F%</td>";
                                    echo "<td width='3%'>R</td>";
                                    echo "</tr>";
                                    $banderaimprime = 1;
                                }
                                ////////////////////////
                                $contador= 1;
                                $query_Recordset8 ="SELECT n.notadefinitiva as nota, 10 as codigotiponota,m.nombremateria,m.numerocreditos, '100' as porcentajecorte
    	FROM notahistorico n,materia m
    	WHERE  m.codigomateria=n.codigomateria
        AND m.codigoestadomateria = '01'
    	AND n.codigoestudiante = '".$_SESSION['codigo']."'
    	AND n.codigomateria = '".$row_Recordset1['codigomateria']."'
    	AND n.codigoperiodo = '".$periodocon."'
        ORDER BY 2";
                                //AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft
                                // echo $query_Recordset8,"</br>";
                                //exit;
                                $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
                                $row_Recordset8 = mysql_fetch_assoc($Recordset8);
                                $totalRows_Recordset8 = mysql_num_rows($Recordset8);
                                $query_data = "select notadefinitiva
	  from notahistorico
	  where codigoestudiante = '".$codigoestudiante."'
	  and codigomateria = '".$row_Recordset1['codigomateria']."'
	  and codigoperiodo = '".$periodocon."'
 	  and codigotiponotahistorico not like '100%'
	  and codigoestadonotahistorico like '1%'";
                                // echo $query_data;
                                $data = mysql_query($query_data, $sala) or die(mysql_error());
                                $row_data = mysql_fetch_assoc($data);
                                $totalRows_data = mysql_num_rows($data);
                                ?>


                <tr>
                    <td><?php echo $row_Recordset1['codigomateria']; ?></td>
                    <td>
                       <?php echo $row_Recordset1['nombremateria']; ?>

                    </td>
                    <td><?php echo $row_Recordset1['numerocreditos'];
                                $numerocreditos = $numerocreditos + $row_Recordset1['numerocreditos'];?>&nbsp;</td>
                                <?php
                                $habilitacion = "";
                                $notafinal = 0;
                                $porcentajefinal = 0;
                                $notadividida = 0;
                                do {
                                    if ($row_Recordset8['codigotiponota'] == 10) {
                                        if ($row_data <> "") {
                                            //echo "<td>&nbsp;</td>";
                                            //echo "<td>&nbsp;</td>";
                                        }
                                        else {
                                            echo "<td>".$row_Recordset8['nota']."&nbsp;</td>";
                                            echo "<td>".$row_Recordset8['porcentajecorte']."%&nbsp;</td>";
                                        }
                                        $notafinal = $notafinal + ($row_Recordset8['nota'] * $row_Recordset8['porcentajecorte'])/100;
                                        $notadividida = $notadividida + $row_Recordset8['nota'];
                                        $porcentajefinal = $porcentajefinal + $row_Recordset8['porcentajecorte'];
                                        $contador++;
                                    }
                                }
                                while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));
				/*Se redondea aca ahora para que la nota sea siempre la misma tanto para notas parciales como para cuando muestra la definitiva.*/
                                $notafinal=redondeo($notafinal);
                                $creditosnota = $notafinal * $row_Recordset1['numerocreditos'];
                                $promedio =  $promedio + $creditosnota;
                                $suma = $ultimocorte - $contador;
                                for ($i=0;$i<=$suma;$i++) {
                                    //echo "<td>&nbsp;</td>";
                                    //echo "<td>&nbsp;</td>";
                                }
                                /* $notafinal = number_format($notafinal,1);
	  $notafinal = round($notafinal * 10)/10;   */
                                //$notafinal = redondeo($notafinal);
                                if ($row_data <> "") {
                $habilitacion = $row_data['notadefinitiva'];
            }
            $query_notagrabada = "select notadefinitiva
	    from notahistorico
		where codigoestudiante = '".$codigoestudiante."'
		and codigomateria = '".$row_Recordset1['codigomateria']."'
    	and codigoperiodo = '".$periodocon."'
    	and codigotiponotahistorico = '100'
    	and codigoestadonotahistorico like '1%'";
                                    $notagrabada = mysql_query($query_notagrabada, $sala) or die(mysql_error());
                                $row_notagrabada= mysql_fetch_assoc($notagrabada);
                                $totalRows_notagrabada= mysql_num_rows($notagrabada);

                                if( ! $row_notagrabada) {
                                    echo "<td width='3%'>".$notafinal."&nbsp;</td>";
                                }
                                else {
                                    echo "<td width='3%'>".number_format($row_notagrabada['notadefinitiva'],1)."&nbsp;</td>";
                                }
                                if ($porcentajefinal <> 0) {
                                    if( ! $row_notagrabada) {
                                        echo "<td width='3%'>".number_format(number_format($notafinal,2)/($porcentajefinal/100),1)."&nbsp;</td>";
                                    }
                                    else {
                                        echo "<td width='3%'>".number_format($row_notagrabada['notadefinitiva'],1)."&nbsp;</td>";
                                    }
                                }
                                echo "<td width='3%'>".$porcentajefinal."%&nbsp;</td>";
                                echo "<td width='3%'>".substr($habilitacion,0,3)."&nbsp;</td>";
                                echo "</tr>";
                                $g++;
                            }
                            while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>


                <tr>
                    <td colspan="2"><strong>Promedio Ponderado Semestral:&nbsp; <?php
                            $query_procesoperiodo = "SELECT	*
    	FROM procesoperiodo
    	WHERE codigoperiodo = '$periodocon'
        and codigocarrera = '$facultad'
    	and idproceso = '1'
    	and codigoestadoprocesoperiodo = '200'";
                            //echo $query_procesoperiodo;
                            $procesoperiodo = mysql_query($query_procesoperiodo, $sala) or die(mysql_error());
                            $row_procesoperiodo = mysql_fetch_assoc($procesoperiodo);
                            $totalRows_procesoperiodo = mysql_num_rows($procesoperiodo);
                            if ($row_procesoperiodo <> "") {
                                /////////////////////////////////////////// calculo semestre ponderado //////////////////////////////////////
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
                                // Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo
                                $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
    	 when 0 then n.notadefinitiva
    	 when 1 then n.notadefinitiva / 100
     	 end as nota, n.codigoperiodo, m.nombremateria
    	 from notahistorico n, materia m
    	 where n.codigoestudiante = '$codigoestudiante'
    	 and n.codigomateria = m.codigomateria
    	 and codigoestadonotahistorico like '1%'
    	 order by 5, 3 ";
                                //echo $query_materiashistorico;
                                //exit();
                                $materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error());
                                $totalRows_materiashistorico = mysql_num_rows($materiashistorico);
                                $cadenamateria = "";
                                while($row_materiashistorico = mysql_fetch_assoc($materiashistorico)) {
                                    // Coloco las materias equivalentes del estudiante en un arreglo y selecciono
                                    // la mayor de esas notas, con el codigo de la materia mayor.
                                    // Arreglo de las materias con las mejores notas del estudiante
                                    if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala)) {
                                        //echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
                                        $formato = " n.codigomateria = ";
                                        // Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
                                        // $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
                                        // $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                    //echo "$Cad_equivalencias<br>";
                    // exit();
                    $row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                    //echo "<br><br>".seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                                $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                                //echo "<br>materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
                                            }
                                            else {
                                                $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                                            }
                                        }
                                        //exit();
                                        $Array_materiashistoricoinicial = $Array_materiashistorico;
                                        // Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
                                        // Para esto primero creo un arreglo con las equivalencias de cada materia
                                        foreach($Array_materiashistorico as $codigomateria => $row_materia) {
                                            //echo "$codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
                                            $otranota = $row_materia['nota']*100;
                                            // Arreglo bidimensional con las materias en cada periodo
                                            $cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
                                            $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
                                        }
                                        //exit();
                                        $cadenamateria = $cadenamateria."fin";
                                        $cadenamateria = ereg_replace("orfin","",$cadenamateria);
                                        // $periodosemestral = $periodocon;
                                        // require('facultades/boletines/calculopromediosemestralmacheteado.php');
                                        //$promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodocon,$cadenamateria,$_GET['tipocertificado']="",$sala, 1);
										$promediosemestralperiodo =PeriodoSemestralTodo($codigoestudiante,$periodocon,$_GET['tipocertificado']="",$sala, 1);
                                        echo $promediosemestralperiodo;
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    }
                                    else {
                                        //$promediototal = number_format($promedio/$numerocreditos,2);
                                        //$float_redondeado=round($promediototal * 10)/10;
                                        $float_redondeado = $promedio/$numerocreditos;
                                        $float_redondeado = redondeo($float_redondeado);
                                        echo $float_redondeado,"<br>" ;
                                    }
                                    ?> </strong></td>
                    <td colspan="20"><strong>Promedio Ponderado Acumulado:&nbsp; <?php
                                    $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);
                                    echo $promedioacumulado;
                                    ?> </strong> &nbsp;</td>
                </tr>
            </table>
            <table width="750" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr>
                    <td><label id="labelresaltado">C = Corte</label></td>
                    <td><label id="labelresaltado">R = Recuperaci&oacute;n</label></td>
                    <td><label id="labelresaltado">Cr = Cr&eacute;ditos</label></td>
                    <td><label id="labelresaltado">PPA = Puntos Promedio Acumulado</label></td>
                    <td><label id="labelresaltado">NPA = Nota Promedio Acumulada</label></td>
                    <td><label id="labelresaltado">F%= Porcentaje Final</label></td>
                    <td><label id="labelresaltado">% = Porcentaje del corte</label></td>
                </tr>
                <tr>
                    <td height="44" colspan="7">
					<span style="display:inline-block;margin-top:5px;font-size:0.9em;">
					* El promedio ponderado semestral es calculado con las calificaciones obtenidas en el 
					<?php echo substr($periodocon, 0, -1)."-".substr($periodocon,strlen($periodocon)-1); ?>.</span>
					<br>
                        <label id="labelresaltado">NO V&Aacute;LIDO COMO CERTIFICADO DE NOTAS
                            <br/><br/>
		Cualquier inconsistencia favor comunicarla a su Facultad.</label>
                        <p><input type="submit" name="Submit" value="Historial Académico"></p>
                    </td>
                </tr>
            </table>
                                    <?php
                                }
                            }
                            mysql_free_result($periodo);
                            mysql_free_result($Recordset2);
                            mysql_free_result($Recordset3);
                            ?>
        </form>

        <br>
        <input type="button" name="Regresar" value="Regresar"
               onClick="history.go(-1)">
    </body>
</html>
<script language="javascript">
    var browser = navigator.appName;
    function hRefCentral(url){
        if(browser == 'Microsoft Internet Explorer'){
            parent.contenidocentral.location.href(url);
        }
        else{
            parent.contenidocentral.location.href=url;
        }
        return true;
    }

    function hRefIzq(url){
        if(browser == 'Microsoft Internet Explorer'){
            parent.leftFrame.location.href(url);
        }
        else{
            parent.leftFrame.location.href=url;
        }
        return true;
    }

    function destruirFrames(url){
        parent.document.location.href=url;
    }
</script>

<script language="javascript">
    function regresar()
    {
        //hRefIzq('facultades/facultadeslv2.php');
        hRefCentral('prematricula/matriculaautomaticaordenmatricula.php');
    }
</script>
