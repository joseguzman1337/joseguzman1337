<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<style type="text/css">
    <!--
    .Estilo1 {font-family: tahoma}
    .Estilo2 {font-size: xx-small}
    .Estilo3 {
        font-size: x-small;
        font-weight: bold;
    }
    .Estilo4 {font-size: x-small}
    .Estilo5 {font-size: 12px}
    .Estilo6 {font-family: tahoma; font-size: 12px; }
    .Estilo13 {font-family: "Courier New", Courier, mono; font-size: 9px; font-style: italic; }
    .Estilo16 {font-size: 9px; font-family: "Courier New", Courier, mono;}
    -->
</style>
<?
    
ksort  ($Array_materiasperiodo);
ksort  ($Array_materiassinsemestre);
mysql_select_db($database_sala, $sala);
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
if($solicitud_historico <> "") {// if 1
    if($solicitud_historico['codigosituacioncarreraestudiante'] == 400) {
        $graduadoegresado = true;
    }
    //if(!isset($_GET['periodos']))
    //{
    if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100 and !isset($_GET['consulta'])) {
        echo '<script language="JavaScript">alert("Este estudiante es Graduado, por lo que el certificado se expide en Secretaria General")</script>';
        echo '<script language="JavaScript">history.go(-1)</script>';
    }
    //}
    ?>
<form name="form1" method="post" action="">
    <table width="80%"  border="0" align="center" cellpadding="0">
            <?php
            if(!isset($_GET['periodos'])) {
                ?>
        <tr>
            <td colspan="7"><div align="center" class="Estilo1 Estilo2">
                    <p>
                                <?php
                                if($row_tipousuario['codigotipousuariofacultad'] == 200) {
                                    ?>
                        <span class="Estilo3">EL SUSCRITO SECRETARIO GENERAL</span><br>
                        En cumplimiento de lo dispuesto en el literal d) del art&iacute;culo 21 del Reglamento General de la Universidad</p>
                                <?php
                            }
                            else {
                                ?>
                    <span class="Estilo4"><strong><a class="Estilo4"style="cursor: pointer" onClick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad'">
                                EL SUSCRITO<br>
                                            <?php
                                            if(preg_match("/ESPECIALIZAC|MAESTRIA|DOCTORADO/",$solicitud_historico['nombrecortocarrera'])) {
                                                ?>
                                DIRECTOR DE PROGRAMA<br>
                                                <?php
                                                if(preg_match("/DOCTORADO/",$solicitud_historico['nombrecortocarrera'])) {
                                                    ?>
                                DEL <?php echo $solicitud_historico['nombrecortocarrera']; ?>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                DE LA <?php echo $solicitud_historico['nombrecortocarrera']; ?>
                                                    <?php
                                                }
                                            }
                                            else {
                                                ?>
                                SECRETARIO ACADÉMICO<br>
                                DE LA FACULTAD DE <?php echo $solicitud_historico['nombrecortocarrera']; ?>
                                                <?php
                                            }
                                            ?>
                            </a></strong></span></span><br>
                    En cumplimiento de lo dispuesto en el literal h) del art&iacute;culo 29 del Reglamento General de la Universidad
                    </p>
                                <?php
                            }
                            ?>
                    <p class="Estilo3">HACE CONSTAR:</p>
                    <p align="justify">Que <strong><?php echo $solicitud_historico['nombresestudiantegeneral'],"&nbsp;",$solicitud_historico['apellidosestudiantegeneral']; ?></strong>, identificado(a) con <?php echo $solicitud_historico['nombredocumento']; ?> No. <?php echo $solicitud_historico['numerodocumento']; ?> de <?php echo $solicitud_historico['expedidodocumento']; ?><!-- , con c&oacute;digo estudiantil No. <?php //echo $solicitud_historico['codigoestudiante']; ?> -->, curs&oacute;
                                <?php
                                //echo "if ((".$solicitud_historico['codigosituacioncarreraestudiante']." == 104 or ".$solicitud_historico['codigosituacioncarreraestudiante']." == 400) and ".$_SESSION['MM_Username']." == 'dirsecgeneral')";
                                if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 200) {
                                    ?>
		    y aprob&oacute; las asignaturas correspondientes al programa de <?php echo $solicitud_historico['nombrecortocarrera']; ?>, y obtuvo el t&iacute;tulo de <strong><?php echo $solicitud_historico['nombretitulo']; ?></strong>.</p>
                                <?php
                            }
                            else if ($solicitud_historico['codigosituacioncarreraestudiante'] <> 400) {
                                ?>
		  las asignaturas abajo relacionadas correspondientes al programa de <?php echo $solicitud_historico['nombrecortocarrera']; ?>.
                                    <?php
                                }
                                ?>
                    <p align="justify">Que de conformidad con la información que reposa en los registros académicos de la Universidad, obtuvo las siguientes calificaciones:</p>
                </div>
            </td>
        </tr>
                <?php
            }
            else {
                ?>
        <tr>
            <td colspan="4" class="Estilo6"><strong>Estudiante : </strong><?php echo $solicitud_historico['nombresestudiantegeneral'],"&nbsp;",$solicitud_historico['apellidosestudiantegeneral']; ?></td>
        </tr>
        <tr>
            <td colspan="4" class="Estilo6"><strong>Documento No : </strong><?php echo $solicitud_historico['numerodocumento']; ?></td>
        </tr>
        <tr>
            <td colspan="7" class="Estilo1 Estilo5" align="center"><strong><font color="#990000">No válido como certificado de notas.</font></strong></span></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
                <?php
            }
            ?>	<tr>
            <td width="11%" class="Estilo2 Estilo1"><strong>C&oacute;digo</strong></td>
            <td width="32%" class="Estilo2 Estilo1"><strong>Materia</strong></td>
                <?php
                if($_GET['concredito'] == 1) {
                    ?>
            <td width="5%"><div align="center" class="Estilo2 Estilo1"><strong>Ulas</strong></div></td>
            <td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Cr&eacute;ditos</strong></div></td>
                    <?php
                }
                ?>
            <td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Nota</strong></div></td>
                <?php
                if($_GET['tiponota'] == 2) {
                    ?>
            <td width="15%"><div align="center" class="Estilo2 Estilo1"><strong>Tipo Nota </strong></div></td>
                    <?php
                }
                ?>
            <td width="23%" class="Estilo2 Estilo1"><strong>Letras</strong></td>
        </tr>
            <?php
            $cuentacambioperiodo = 0;
            $sumaulas="&nbsp;";
            $sumacreditos = "&nbsp;";
            $periodocalculo = "";
            $indicadorperiodo = 0;
            $ultimoperiodo = 0;
            $periodo = "";

            foreach($Array_materiasperiodo as $idsemestre => $Array_materia) {  // foreach 1
                $cuentaper="";
                $indicadorulas = 0;
                $creditos = 0;
                $notatotal = 0;

                foreach ($Array_materia as $num => $sem) {
                    if ($sem['semestre'] == $idsemestre) {
                        $cuentaper++;
                    }
                }
                if ($idsemestre <> "") { // if  $idsemestre
                    foreach($Array_materia as $key => $row_materiaperiodo) // do
                    { // foreach 2

                        if ($periodo <> $row_materiaperiodo['semestre']) { // if 1
                            $nombreultimoperiodo = $row_materiaperiodo['semestre'];
                            ?>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7" class="Estilo1 Estilo2"><strong>
                                        <?php
                                        if ($row_materiaperiodo['semestre'] < 20) {

                                            $arabigo  =  $row_materiaperiodo['semestre'];

                                            require('../convertirnumeros.php');
                                            echo "$sem SEMESTRE";
                                            //echo $row_materiaperiodo['semestre'];
                                        }
                                        else {
                                            $query_nombreperiodo = "select nombreperiodo
				  from periodo
				  where codigoperiodo = '".$row_materiaperiodo['semestre']."'";
                                            $res_nombreperiodo = mysql_query($query_nombreperiodo, $sala) or die(mysql_error());
                                            $solicitud_nombreperiodo = mysql_fetch_assoc($res_nombreperiodo);

                                            //echo "PERIODO ";
                                            echo $solicitud_nombreperiodo['nombreperiodo'];
                                        }
                                        ?></strong></td>
        </tr>
                            <?php
                        } // if 1

                        $query_historico = "SELECT m.nombremateria,m.codigomateria,(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos, m.codigotipocalificacionmateria,t.nombretiponotahistorico,n.codigomateriaelectiva
		FROM materia m,tiponotahistorico t,notahistorico n
		WHERE n.codigotiponotahistorico = t.codigotiponotahistorico
		and   n.codigomateria = m.codigomateria
		and   n.codigoestudiante = '".$codigoestudiante."'
		AND   m.codigomateria = '".$row_materiaperiodo['codigomateria']."'
		and   n.codigoestadonotahistorico like '1%'";
                        //echo $query_historico,"<br><br>";
                        //exit();
                        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                        $solicitud_historico = mysql_fetch_assoc($res_historico);
                        $mostrarpapa = "";
                        if ($solicitud_historico['codigomateriaelectiva'] <> 1) {
                            $query_electiva = "select nombremateria
			from  materia
			where codigomateria = '".$solicitud_historico['codigomateriaelectiva']."'
			";
                            $electiva = mysql_query($query_electiva, $sala) or die(mysql_error());
                            $totalRows_electiva = mysql_num_rows($electiva);
                            $row_electiva = mysql_fetch_assoc($electiva);
                            if ($row_electiva <> "") {
                                $mostrarpapa = $row_electiva['nombremateria'];
                            }
                        }
                        // echo $solicitud_historico['total'];
                        $query_detallemateria = "select descripciontemasdetalleplanestudio
		from  temasdetalleplanestudio
		where codigomateria = '".$solicitud_historico['codigomateria']."'
		and   codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
		and   codigoestado like '1%'";
                        $detallemateria = mysql_query($query_detallemateria, $sala) or die(mysql_error());
                        $totalRows_detallemateria = mysql_num_rows($detallemateria);
                        $row_detallemateria = mysql_fetch_assoc($detallemateria);
                        ?>
        <tr>
            <td valign="top" class="Estilo1 Estilo2"><?php echo  $row_materiaperiodo['codigomateria'];?></td>
            <td class="Estilo1 Estilo2"><?php if ($mostrarpapa <> "") echo "$mostrarpapa /  ";
                                echo $row_materiaperiodo['nombremateria'].$lugaresderotacion;?>
                                <?php
                                if ($row_detallemateria <> "") {
                                    ?>
                <table width="100%"  border="0" align="left" cellpadding="0">
                                        <?php
                                        do {

                                            ?>
                    <tr>
                        <td class="Estilo1 Estilo2">- <?php echo $row_detallemateria['descripciontemasdetalleplanestudio'];?></td>
                    </tr>
                                            <?php
                                        }while($row_detallemateria = mysql_fetch_assoc($detallemateria));
                                        ?>
                </table>
                                    <?php
                                }
                                ?>
            </td>
                            <?php

                            if($_GET['concredito'] == 1) { // if creditos
                                ?>
            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                        <?php
                                        // echo $solicitud_historico['codigoindicadorcredito'];
                                        //echo $indicadorulas;
                                        if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                            if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                echo "&nbsp;";
                                            }
                                            else {
                                                echo $solicitud_historico['total'];
                                            }
                                            $sumaulas=$sumaulas+$solicitud_historico['total'];
                                            $indicadorulas = 1;
                                        }
                                        ?></div></td>
            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                        <?php
                                        if($solicitud_historico['codigoindicadorcredito'] == 100) {
                                            if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                echo "&nbsp;";
                                            }
                                            else {
                                                echo $solicitud_historico['numerocreditos'];
                                            }
                                            $sumacreditos=$sumacreditos+$solicitud_historico['numerocreditos'];
                                        }
                                        ?></div></td>
                                <?php
                            } // if creditos
                            ?>
            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                    <?php
                                    $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['numerocreditos']] = $row_materiaperiodo['nota'];
                                    $nota = round($row_materiaperiodo['nota'],2);

                                    if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                        echo "&nbsp;";
                                    }
                                    else {
                                        echo round($nota,2);
                                    }
                                    //print_r($_GET);
                                    ?></div></td>
                            <?php
                            if($_GET['tiponota'] == 2) { // if nota
                                ?>
            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                        <?php
                                        if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                            echo $solicitud_historico['nombretiponotahistorico'];
                                        }
                                        ?></div></td>
                                <?php
                            }// if nota
                            ?>
            <td valign="top" class="Estilo1 Estilo2">
                                <?php
                                $total   = substr($nota,0,3);
                                $numero  = substr($total,0,1);
                                $numero2 = substr($total,2,2);
                                require('../convertirnumeros.php');
                                if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                    echo "APROBADO";
                                }
                                else {
                                    echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                }
                                ?>
                &nbsp;</td>
        </tr>
                        <?php
                        $cuentacambioperiodo ++;
                        require('calculopromediosemestralmacheteado.php');
                        if ($cuentaper == $cuentacambioperiodo ) {
                            $cuentacambioperiodo = 0;
                            /*  $periodosemestral = $solicitud_historico['codigoperiodo']; */
                            ?>
        <tr>
            <td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Semestral</strong></td>
                                <?php
                                if($_GET['concredito'] == 1) {
                                    ?>
            <td><div align="center" class="Estilo2 Estilo1"><strong><?php echo $sumaulas;?></strong></div></td>
            <td><div align="center" class="Estilo2 Estilo1"><strong><?php echo $sumacreditos;?></strong></div></td>
                                    <?php
                                }
                                ?>
            <td><div align="center" class="Estilo2 Estilo1"><strong>
                                            <?php
                                            if ($promediosemestralperiodo > 5) {
                                                $promediosemestralperiodo =  round(($promediosemestralperiodo / 100),2);
                                            }
                                            $promediosemestralperiodo = round($promediosemestralperiodo,2);
                                            echo round($promediosemestralperiodo,2);
                                            ?>&nbsp;</strong></div></td>
                                <?php
                                if($_GET['tiponota'] == 2) {
                                    ?>
            <td><div align="center"></div></td>
                                    <?php
                                }
                                ?>
            <td class="Estilo2 Estilo1"><strong>
                                        <?php 				//$total = substr($solicitud_historico['notadefinitiva'],0,3);
                                        $numero =  substr($promediosemestralperiodo,0,1);
                                        $numero2 = substr($promediosemestralperiodo,2,2);
                                        require('../convertirnumeros.php');
                                        echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                        ?>
                    &nbsp;</strong></td>
        </tr>
                            <?php
                            if($_GET['ppsa'] == 3) {
                                ?>
        <tr>
            <td colspan="2"><span class="Estilo2 Estilo1"><strong>Promedio Ponderado Semestral Acumulado</strong></span></td>
                                    <?php
                                    if($_GET['concredito'] == 1) {
                                        ?>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong>&nbsp;</strong></span></div></td>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong>&nbsp;</strong></span></div></td>
                                        <?php
                                    }
                                    ?>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong>
                                                    <?php
                                                    //$periodos[] .= $solicitud_historico['codigoperiodo'];
                                                    $promedioacumuladop = AcumuladoReglamentoPeriodos ($codigoestudiante,$_GET['tipocertificado'],$Anotas,$sala);
                                                    if($promedioacumuladop > 5) {
                                                        $promedioacumuladop =  round(($promedioacumuladop / 100),2);
                                                    }
                                                    echo $promedioacumuladop;
                                                    //print_r($Anotas);
                                                    ?>&nbsp;</strong></span></div></td>
                                    <?php
                                    if($_GET['tiponota'] == 2) {
                                        ?>
            <td><div align="center"></div></td>
                                        <?php
                                    }
                                    ?>
            <td><span class="Estilo2 Estilo1"><strong>
                                                <?php               //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                                                $numero =  substr($promedioacumuladop,0,1);
                                                $numero2 = substr($promedioacumuladop,2,2);
                                                require('../convertirnumeros.php');
                                                echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                                ?>
                        &nbsp;</strong></span></td>
        </tr>
                                <?php
                            }
                            $sumaulas="&nbsp;";
                            $sumacreditos = "&nbsp;";


                        } // semestre
                        $periodo = $row_materiaperiodo['semestre'];
                    }//foreach 2
                } // if  $idsemestre
            } //foreach 1
        }
        ?>

        <tr>
            <td colspan="2" class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
        </tr>

        <tr>
            <?php
            /* if($carreraestudiante == 100)
	{
?>
      <td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado a <?php
	  //echo $ultimoperiodo;
	  echo $nombreultimoperiodo;
	  ?></strong></td>
<?php
	}
	else
	{ */
            ?>
            <td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado </strong></td>
            <?php
//}
            ?>
            <?php
            if($_GET['concredito'] == 1) {
                ?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
                <?php
            }
            ?>
            <td><div align="center" class="Estilo2 Estilo1"><strong>
                        <?php
                        //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                        //require('funcionequivalenciapromedio.php');
                        //require('../calculopromedioacumulado.php');
                        require ('../../../../funciones/notas/calculopromedioacumulado.php');
                        if($promedioacumulado > 5) {
                            $promedioacumulado =  round(($promedioacumulado / 100),2);
                        }
                        echo $promedioacumulado;
                        ?></strong></div></td>
            <?php
            if($_GET['tiponota'] == 2) {
                ?>
            <td>&nbsp;</td>
                <?php
            }
            ?>
            <td class="Estilo2 Estilo1"><strong>
                    <?php
                    //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                    $numero =  substr($promedioacumulado,0,1);
                    $numero2 = substr($promedioacumulado,2,2);
                    require('../convertirnumeros.php');
                    echo $numu."&nbsp&nbsp;".$numu2."&nbsp;";
                    $ano = substr(date("Y-m-d"),0,4);
                    $mes = substr(date("Y-m-d"),5,2);
                    $dia = substr(date("Y-m-d"),8,2);
                    ?>
                    &nbsp;</strong></td>
        </tr>
        <tr>
            <td colspan="2" class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
            <td class="Estilo2">&nbsp;</td>
        </tr>
        <?php
        if(!isset($_GET['periodos'])) {
            $articulo = '51';
            $notanumero = '3.0';
            $notaletra = 'tres punto cero';
            if ($moda == '300' ) {
                $articulo = '46';
                $notanumero = '3.0';
                $notaletra = 'tres punto cero';
            }
            ?>
        <tr>
            <td colspan="7"><p align="justify" class="Estilo1 Estilo2"><br>
                    De conformidad con lo dispuesto en el art&iacute;culo <?php echo $articulo; ?> del reglamento estudiantil de la Universidad, la escala de calificaciones que aplica la Institución est&aacute; dentro de un rango de cero punto cero (0.0) a cinco punto cero (5.0) y la calificación m&iacute;nima aprobatoria es de <?php echo "$notaletra ($notanumero)"; ?> sobre cinco punto cero (5.0).</p>
                <p align="justify" class="Estilo1 Estilo2">La presente certificaci&oacute;n se expide a solicitud del interesado(a), en Bogot&aacute; D.C., a los
                        <?
                        $day = $dia;
                        $mesesano = $mes;
                        require('../convertirnumeros.php');
                        echo $dias;
                        ?> (<?php echo $dia;?>) d&iacute;as del mes de <?php echo $meses;?> (<?php echo $mes;?>) del a&ntilde;o dos mil <?php $day = substr($ano,2,4);
                        require('../convertirnumeros.php');
                        echo $dias; ?> (<?php echo $ano;?>).</p>
                <p class="Estilo1 Estilo2">&nbsp;</p>
                <span class="Estilo1 Estilo2">
                        <?php
                        $query_responsable = "SELECT *
	FROM directivo d,directivocertificado di,certificado c
	WHERE d.codigocarrera = '".$codigocarrera."'
	AND d.iddirectivo = di.iddirectivo
	AND di.idcertificado = c.idcertificado
	AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
	AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
	AND c.idcertificado = '2'
    ORDER BY fechainiciodirectivo";
                        //echo $query_responsable;
                        $responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
                        $row_responsable = mysql_fetch_assoc($responsable);
                        $totalRows_responsable = mysql_num_rows($responsable);
                        ?>
                </span>
                <p class="Estilo1 Estilo2"><strong><a class="Estilo4"style='cursor: pointer' onClick='JavaScript:window.print()' ><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?></a><br>
                            <?php
                            echo $row_responsable['cargodirectivo'];
                            ?></strong>&nbsp;</p>
            </td>
        </tr>
            <?php
        }
        else {
            ?>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td align="center" colspan="3"><input type="button" onClick="history.go(-1)" name="regresar" value="Regresar">&nbsp;&nbsp;<input type="button" onClick="print()" name="imprimir" value="Imprimir"></td>
        </tr>
            <?php
        }
        ?>
    </table>
</form>
