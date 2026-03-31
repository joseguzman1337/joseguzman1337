<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" rel="stylesheet" href="../../../../sala/assets/css/bootstrap.css"> 
<link type="text/css" rel="stylesheet" href="../../../../sala/assets/css/btheme.css"> 
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Funcion de javascript que abre el contenido del reporte en una nueva ventana
 * Caso reportado por Angie Carolina Morales Páez - Secretaría General <seconsejoacademico@unbosque.edu.co> Fecha: 8 de Marzo de 2018
 * @since Marzo 9, 2018
*/
?>
<script type="text/javascript">
    function imprSelec(muestra){
        var ficha=document.getElementById(muestra);
        var ventimp=window.open(' ','popimpr');
        ventimp.document.write(ficha.innerHTML);
        //ventimp.document.close();ventimp.print();ventimp.close();
    }
</script>
<?php
/* Fin modificacion */
?>
</head>
<body>
<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Boton para abrir la vista de impresion en una nueva ventana
 * Caso reportado por Angie Carolina Morales Páez - Secretaría General <seconsejoacademico@unbosque.edu.co> Fecha: 8 de Marzo de 2018
 * @since Marzo 9, 2018
*/
?>
<a class="btn btn-primary btn-labeled fa fa-print" href="javascript:imprSelec('form1')">Imprimir</a>
<?php
mysql_select_db($database_sala, $sala);

require_once('nombrePromedio.php');

$query_historico = "SELECT 	c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera, e.codigosituacioncarreraestudiante,codigomodalidadacademica, nombrefacultad,eg.codigogenero,ti.nombreTituloGenero 
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg,
	facultad f
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '".$codigoestudiante."'
	AND eg.tipodocumento = doc.tipodocumento
	AND e.codigocarrera = c.codigocarrera
	AND c.codigotitulo = ti.codigotitulo
	AND f.codigofacultad = c.codigofacultad";
$res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
$solicitud_historico = mysql_fetch_assoc($res_historico);
$carreraestudiante = $solicitud_historico['codigocarrera'];
$moda = $solicitud_historico['codigomodalidadacademica'];
$carreracadena=substr($solicitud_historico['nombrecortocarrera'],0,10);
$carreracadenas=substr($solicitud_historico['nombrecortocarrera'],3,10);
      
$tituloObtener = "";

if ($solicitud_historico['codigogenero'] == 100) {
    $tituloObtener = $solicitud_historico['nombreTituloGenero'];
} else {
    $tituloObtener = $solicitud_historico['nombretitulo'];
}

if ($carreracadena == 'INGENIERIA') {
    $carrera = $carreracadena;
} elseif ($carreracadenas == 'INGENIERIA') {
    $carrera = $carreracadenas;
} else {
    $carrera = $solicitud_historico['nombrecortocarrera'];
}

if ($solicitud_historico <> "") {// if 1
    if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400) {
        $graduadoegresado = true;
    }
    if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100 and ! isset($_GET['consulta'])) {
        echo '<script language="JavaScript">alert("Este estudiante es Graduado, por lo que el certificado se expide en Secretaria General")</script>';
        echo '<script language="JavaScript">history.go(-1)</script>';
    }
?>
<form name="form1" id="form1" method="post" action="">
    <style>
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
    <table width="80%"  border="0" align="center" cellpadding="0">
        <?php
        if(!isset($_GET['periodos'])) {
            ?>
            <tr>
                <td colspan="7">
                    <div align="center" class="Estilo1 Estilo2">
                        <p>
                            <?php
                            if ($row_tipousuario['codigotipousuariofacultad'] == 200) {
                                $row_tipousuario['codigotipousuariofacultad'];
                            ?>
                            <span class="Estilo3">
                            <?php
                            echo $suscrito_secretario . " " . $cargodirectivosecretario ?></span><br>
                            En cumplimiento de lo dispuesto en el literal d) del art&iacute;culo 21 del Reglamento General
                            de la Universidad</p>
                        <?php
                        }
                        else {
                            ?>
                            <span class="Estilo4"><strong><a class="Estilo4" style="cursor: pointer"
                             onClick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad'">
                            EL SUSCRITO<br>
                            <?php

                            if ($solicitud_historico['codigocarrera'] == 1107 || $solicitud_historico['codigocarrera'] == 1148){
                                 ?>SECRETARIO ACADÉMICO<br>DE LA <?php echo $solicitud_historico['nombrefacultad'];
                            }
                            else if (preg_match("/ESPECIALIZAC|MAESTRIA|DOCTORADO/", $solicitud_historico['nombrecortocarrera'])) {
                                ?>DIRECTOR DE PROGRAMA<br><?php
                                if (preg_match("/DOCTORADO/", $solicitud_historico['nombrecortocarrera'])) {
                                    ?>DEL <?php echo $solicitud_historico['nombrecortocarrera'];
                                } else {
                                    ?>DE LA <?php echo $solicitud_historico['nombrecortocarrera'];
                                }
                            } else {
                                ?>SECRETARIO ACADÉMICO<br>DE LA <?php echo $solicitud_historico['nombrefacultad'];
                            }
                            ?>
                            </a></strong></span><br>
                            En cumplimiento de lo dispuesto en el literal h) del art&iacute;culo 29 del Reglamento General de la Universidad
                            <br>
                            Vigilada Mineducación
                            <?php
                        }
                        ?>
                        <p class="Estilo3">HACE CONSTAR:</p>
                        <p align="justify">Que
                            <strong><?php echo $solicitud_historico['nombresestudiantegeneral'], "&nbsp;",
                                $solicitud_historico['apellidosestudiantegeneral']; ?></strong>, identificado(a) con <?php
                            echo $solicitud_historico['nombredocumento']; ?> No. <?php echo $solicitud_historico['numerodocumento'];
                            ?> de <?php echo $solicitud_historico['expedidodocumento']; ?><!-- , con c&oacute;digo estudiantil No.
                            <?php //echo $solicitud_historico['codigoestudiante']; ?> -->, curs&oacute;
                            <?php
                            if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 200) {
                                ?>
                                y aprob&oacute; las asignaturas correspondientes al programa de <?php
                                echo $solicitud_historico['nombrecortocarrera']; ?>, y obtuvo el t&iacute;tulo de <strong><?php
                                echo $tituloObtener; ?></strong>.</p>
                                <?php
                            }
                            else if ($solicitud_historico['codigosituacioncarreraestudiante'] <> 400) {
                                ?>
                                las asignaturas abajo relacionadas correspondientes al programa de <?php
                                echo $solicitud_historico['nombrecortocarrera']; ?>.
                                <?php
                            }
                            ?>
                            <p align="justify">Que de conformidad con la información que reposa en los registros académicos
                            de la Universidad, obtuvo las siguientes calificaciones:</p>
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
                <td colspan="7" class="Estilo1 Estilo5" align="center"><strong><font color="#990000">No válido como certificado de notas.</font></strong></td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <?php
        }
        ?>
        <tr>
            <td width="11%" class="Estilo2 Estilo1"><strong>C&oacute;digo</strong></td>
            <td width="32%" class="Estilo2 Estilo1"><strong>Materia</strong></td>
                <?php
                if($_GET['concredito']) {
                    ?>
                    <td width="5%"><div align="center" class="Estilo2 Estilo1"><strong>Ulas</strong></div></td>
                    <td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Cr&eacute;ditos</strong></div></td>
                    <?php
                }
                ?>
                <td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Nota</strong></div></td>
                <?php
                if($_GET['tiponota']) {
                    ?>
                    <td width="15%"><div align="center" class="Estilo2 Estilo1"><strong>Tipo Nota </strong></div></td>
                    <?php
                }
                ?>
            <td width="23%" class="Estilo2 Estilo1"><strong>Letras</strong></td>
        </tr>
        <?php
        $cuentacambioperiodo = 0;
        $sumaulas            = "&nbsp;";
        $sumacreditos        = "&nbsp;";
        $periodocalculo      = "";
        $indicadorperiodo    = 0;
        $ultimoperiodo       = 0;
        if(!isset($cadenamateria) || empty($cadenamateria)){
            $cadenamateria = "";
        }
        if(!isset($cadenamateria2) || empty($cadenamateria2)){
            $cadenamateria2 = "";
        }

        //ciclo de semestres
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
                    if($_GET['tipocertificado'] == "equivalencias"){
                        $query_historico = "SELECT n.idnotahistorico, n.codigoperiodo,
                        IF(rpe.codigomateria IS NULL, m.nombremateria,m2.nombremateria) as nombremateria,
                        IF(rpe.codigomateria IS NULL, m.codigomateria,rpe.codigomateria) as codigomateria,						
                        n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
                        t.nombretiponotahistorico,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,eg.numerodocumento,
                        (m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,							
                        IF(rpe.codigomateria IS NULL, m.numerocreditos,m2.numerocreditos) as numerocreditos,
                        pe.nombreperiodo,doc.nombredocumento,e.codigotipoestudiante,n.codigotiponotahistorico, m.codigotipocalificacionmateria,
                        n.idlineaenfasisplanestudio
                        FROM notahistorico n
                        INNER JOIN materia m on m.codigomateria = n.codigomateria
                            INNER JOIN tiponotahistorico t on n.codigotiponotahistorico = t.codigotiponotahistorico
                            INNER JOIN estudiante e on n.codigoestudiante = e.codigoestudiante
                            INNER JOIN carrera c on e.codigocarrera = c.codigocarrera
                            INNER JOIN titulo ti on c.codigotitulo = ti.codigotitulo
                            INNER JOIN periodo pe on pe.codigoperiodo = n.codigoperiodo
                            INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral
                            INNER JOIN documento doc on eg.tipodocumento = doc.tipodocumento
                                INNER JOIN planestudioestudiante pes on pes.codigoestudiante = n.codigoestudiante AND pes.codigoestadoplanestudioestudiante <> 200 
                                LEFT JOIN referenciaplanestudio rpe on rpe.codigomateriareferenciaplanestudio=m.codigomateria 
                                        AND rpe.codigoestadoreferenciaplanestudio like '1%' AND rpe.idplanestudio=pes.idplanestudio
                                LEFT JOIN materia m2 on m2.codigomateria=rpe.codigomateria 
                        WHERE  n.codigoestudiante = '".$codigoestudiante."'
                        AND n.codigoestadonotahistorico LIKE '1%' 
                        AND pe.codigoperiodo = '".$_GET["periodo".$i]."' 
                        and ($cadenamateria2)
                        ORDER BY 1,2";
                    }
                    $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                }

                do {
                    mysql_select_db($database_sala, $sala);
                    $mostrarpapa = "";
                    if(!$graduadoegresado) {
                        $query_materia = "SELECT * FROM notahistorico n
                        WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."' 
                        and n.codigoestudiante = '".$codigoestudiante."' AND n.codigoestadonotahistorico LIKE '1%'
                        and ($cadenamateria)";
                    }
                    else {
                        $query_materia = "SELECT * FROM notahistorico n, materia m
                        WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
                        and n.codigoestudiante = '".$codigoestudiante."'
                        AND n.codigoestadonotahistorico LIKE '1%' and n.codigomateria = m.codigomateria
                        and ($cadenamateria)";
						
                        if($_GET['tipocertificado'] == "equivalencias"){
                            $query_materia = "SELECT *
                            FROM notahistorico n
                            INNER JOIN materia m on n.codigomateria = m.codigomateria 
                            INNER JOIN planestudioestudiante pe on pe.codigoestudiante = n.codigoestudiante
                                AND pe.codigoestadoplanestudioestudiante <> 200
                            LEFT JOIN referenciaplanestudio rpe on rpe.codigomateriareferenciaplanestudio=m.codigomateria 
                                    AND rpe.codigoestadoreferenciaplanestudio like '1%' AND rpe.idplanestudio=pe.idplanestudio
                                LEFT JOIN materia m2 on m2.codigomateria=rpe.codigomateria 
                            WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
                            and n.codigoestudiante = '".$codigoestudiante."'
                            AND n.codigoestadonotahistorico LIKE '1%'
                            and n.codigomateria = m.codigomateria
                            and ($cadenamateria2)";
                        }
                    }

                    $res_materia = mysql_query($query_materia, $sala) or die("$query_materia".mysql_error());
                    $solicitud_materia = mysql_fetch_assoc($res_materia);
                    $totalRows = mysql_num_rows($res_materia);

                   //valida si la materia electiva existe y es diferente a vacio
                    if(isset($solicitud_historico['codigomateriaelectiva']) && !empty($solicitud_historico['codigomateriaelectiva'])) {
                        //consulta si la materia tiene la etiqueta de materia en 100
                        $query_materiaelectiva = "SELECT * FROM materia WHERE codigoindicadoretiquetamateria = '100'
                        and codigomateria = '" . $solicitud_historico['codigomateriaelectiva'] . "'";
                        $materiaelectiva = mysql_query($query_materiaelectiva, $sala) or die("$query_materiaelectiva" . mysql_error());
                        $row_materiaelectiva = mysql_fetch_assoc($materiaelectiva);
                        $totalRows_materiaelectiva = mysql_num_rows($materiaelectiva);
                    }

                    //valida si la consulta de electivas obtuvo resultado
                    if($totalRows_materiaelectiva = "") {
                        $solicitud_historico['codigomateria'] = $row_materiaelectiva['codigomateria'];
                        $solicitud_historico['nombremateria'] = $row_materiaelectiva['nombremateria'];
                    }else{
                        if (isset($solicitud_historico['codigomateriaelectiva'])
                            && !empty($solicitud_historico['codigomateriaelectiva'])
                            && $solicitud_historico['codigomateriaelectiva'] <> "1") {
                            $mostrarpapa = "";
                            $query_materiaelectiva1 = "SELECT nombremateria, numerocreditos, codigotipomateria 
							FROM materia WHERE codigomateria = ".$solicitud_historico['codigomateriaelectiva']."";
                            $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die(mysql_error());
                            $row_materiaelectiva1 = mysql_fetch_assoc($materiaelectiva1);
                            $totalRows_materiaelectiva1 = mysql_num_rows($materiaelectiva1);
                            if ($totalRows_materiaelectiva1 <> 0) {
                                //asigna la materia electiva del plan de estudio como la materia padre
                                $mostrarpapa = $row_materiaelectiva1['nombremateria'];
                                // Si la materia es de tipo electiva obligatoria muestra los creditos de la papá
                                if($row_materiaelectiva1['codigotipomateria'] == 5
                                    && $solicitud_historico['idlineaenfasisplanestudio']==1) {
                                    $solicitud_historico['numerocreditos'] = $row_materiaelectiva1['numerocreditos'];
                                }
                            }
                        }
                    }

                    if($solicitud_historico['codigoperiodo'] != "") {
                        if ($periodo <> $solicitud_historico['codigoperiodo']) {
                            $nombreultimoperiodo = $solicitud_historico['nombreperiodo'];
                            ?>
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="Estilo1 Estilo2"><strong><?php echo $solicitud_historico['nombreperiodo'];?></strong></td>
                            </tr>
                            <?php
                        }

                        // Selecciona los datos de los sitios de rotación
                        $query_sellugarrotacion = "select l.idlugarorigennota, l.nombrelugarorigennota
    					from lugarorigennota l, rotacionnotahistorico r, notahistorico n
    					where r.idnotahistorico = '".$solicitud_historico['idnotahistorico']."'
    					and r.idlugarorigennota = l.idlugarorigennota
    					and n.codigomateria = '".$solicitud_historico['codigomateria']."'
    					and n.idnotahistorico = r.idnotahistorico order by 2, 1";
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
                        ?>
                        <tr>
                            <td valign="top" class="Estilo1 Estilo2"><?php echo $solicitud_historico['codigomateria'];?></td>
                            <td class="Estilo1 Estilo2"> <?php if ($mostrarpapa <> "") echo "$mostrarpapa /  ";
                                echo $solicitud_historico['nombremateria'].$lugaresderotacion;
                                if ($row_detallemateria <> "") {
                                    ?>
                                    <table width="100%"  border="0" align="left" cellpadding="0">
                                    <?php
                                    do {
                                        ?>
                                        <tr>
                                            <td class="Estilo1 Estilo2">- <?php
                                                echo $row_detallemateria['descripciontemasdetalleplanestudio'];?>
                                            </td>
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
                                    if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                        if (preg_match("/^2/",$solicitud_historico['codigotipocalificacionmateria'])) {
                                            echo "&nbsp;";
                                        }
                                        else {
                                            echo $solicitud_historico['total'];
                                        }
                                        $sumaulas=$sumaulas+$solicitud_historico['total'];
                                    }
                                    ?></div>
                                </td>
                                <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                    <?php
                                    if($solicitud_historico['codigoindicadorcredito'] == 100) {
                                        if (preg_match("/^2/",$solicitud_historico['codigotipocalificacionmateria'])) {
                                            echo "&nbsp;";
                                        }
                                        else {
                                        echo $solicitud_historico['numerocreditos'];
                                        }
                                        $sumacreditos=$sumacreditos+$solicitud_historico['numerocreditos'];
                                    }
                                    ?></div>
                                </td>
                                <?php
                            } // if creditos
                            ?>
                            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                <?php
                                if ($solicitud_historico['notadefinitiva'] > 5) {
                                    $nota = number_format(($solicitud_historico['notadefinitiva'] / 100),1);
                                }
                                else {
                                    $nota = number_format($solicitud_historico['notadefinitiva'],1);
                                    $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['numerocreditos']] = $solicitud_historico['notadefinitiva'];
                                }
                                if ($solicitud_historico['codigotiponotahistorico'] == 110 || preg_match("/^2/",$solicitud_historico['codigotipocalificacionmateria'])) {
                                    echo "&nbsp;";
                                }
                                else {
                                    echo number_format($nota,1);
                                }
                                ?></div>
                            </td>
                            <?php
                            if($_GET['tiponota'] == 2) {
                                ?>
                                <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                    <?php
                                    if($solicitud_historico['codigotiponotahistorico'] != 110 && !preg_match("/^2/",$solicitud_historico['codigotipocalificacionmateria'])) {
                                        echo $solicitud_historico['nombretiponotahistorico'];
                                    }
                                    ?></div>
                                </td>
                                <?php
                            }
                            ?>
                            <td valign="top" class="Estilo1 Estilo2">
                                <?php
                                $total = substr($nota,0,3);
                                $numero =  substr($total,0,1);
                                $numero2 = substr($total,2,2);
                                require('convertirnumeros.php');
                                if ($solicitud_historico['codigotiponotahistorico'] == 110 || preg_match("/^2/",$solicitud_historico['codigotipocalificacionmateria'])) {
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
                        if ($cuentacambioperiodo == $totalRows) {
                            $cuentacambioperiodo = 0;
                            $periodosemestral = $solicitud_historico['codigoperiodo'];
                            $promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodosemestral,$cadenamateria,$_GET['tipocertificado'],$sala, 1);
                            ?>
                            <tr>
                                <td colspan="2" class="Estilo2 Estilo1"><strong><?php echo $nombrePromPonderado; ?></strong></td>
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
                                        $promediosemestralperiodo =  number_format(($promediosemestralperiodo / 100),1);
                                    }
                                    $promediosemestralperiodo = number_format($promediosemestralperiodo,1);
                                    echo number_format($promediosemestralperiodo,1);
                                    ?>&nbsp;</strong></div>
                                </td>
                                <?php
                                if($_GET['tiponota'] == 2) {
                                    ?>
                                    <td><div align="center"></div></td>
                                    <?php
                                }
                                ?>
                                <td class="Estilo2 Estilo1"><strong>
                                    <?php
                                    $numero =  substr($promediosemestralperiodo,0,1);
                                    $numero2 = substr($promediosemestralperiodo,2,2);
                                    require('convertirnumeros.php');
                                    echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                    ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php
                            if($_GET['ppsa'] == 3) {
                                ?>
                                <tr>
                                <td colspan="2">
                                    <span class="Estilo2 Estilo1"><strong><?php echo $nombrePromPonderadoAcumulado; ?></strong>
                                    </span>
                                </td>
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
                                    $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);
                                    if($promedioacumuladop > 5) {
                                        $promedioacumuladop =  number_format(($promedioacumuladop / 100),1);
                                    }
                                    echo $promedioacumuladop;
                                    ?>&nbsp;</strong></span></div></td>
                                    <?php
                                    if($_GET['tiponota'] == 2) {
                                        ?>
                                        <td><div align="center"></div></td>
                                        <?php
                                    }
                                    ?>
                                    <td><span class="Estilo2 Estilo1"><strong>
                                    <?php
                                    $numero =  substr($promedioacumuladop,0,1);
                                    $numero2 = substr($promedioacumuladop,2,2);
                                    require('convertirnumeros.php');
                                    echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                    ?>
                                    &nbsp;</strong></span></td>
                                </tr>
                                <?php
                            }
                            $sumaulas ="&nbsp;";
                            $sumacreditos = "&nbsp;";
                        }
                        $periodo = $solicitud_historico['codigoperiodo'];
                    }
                }while($solicitud_historico = mysql_fetch_assoc($res_historico));
            } // if 1
        } // if
    } //for
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
    if($carreraestudiante == 100) {
        ?>
        <td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado a
        <?php echo $nombreultimoperiodo; ?></strong></td>
        <?php
    }
    else {
        ?>
        <td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado </strong></td>
        <?php
    }
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
        $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado'],$sala);
        if($promedioacumulado > 5) {
            $promedioacumulado =  number_format(($promedioacumulado / 100),1);
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
        $numero =  substr($promedioacumulado,0,1);
        $numero2 = substr($promedioacumulado,2,2);
        require('convertirnumeros.php');
        echo $numu."&nbsp&nbsp;".$numu2."&nbsp;";
        $fecha_exp=explode("/",$_REQUEST['fechaexpedicion']);
        $ano = $fecha_exp[2];
        $mes = $fecha_exp[1];
        $dia = $fecha_exp[0];
        ?>
        </strong></td>
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
            $query_detallemateria = "select *
	from  carrerarangonota cr,estudiante e
	where e.codigoestudiante='".$codigoestudiante."'
	and e.codigocarrera=cr.codigocarrera
	and   cr.codigoestado like '1%'";
             $detallerangonota = mysql_query($query_detallemateria, $sala) or die(mysql_error());
              $totalRows_detallerangonota = mysql_num_rows($detallerangonota);
              if($totalRows_detallerangonota>0){
             $row_detallerangonota = mysql_fetch_assoc($detallerangonota);
                $articulo = $row_detallerangonota["articulocarrerarangonota"];
                $notanumero = $row_detallerangonota["notaminimaaprobatoriacarrerarangonota"];
                $notanumeroarray=explode(".", $notanumero);
                $notaletra = convercionnumerotexto($notanumeroarray[0])." punto ".convercionnumerotexto($notanumeroarray[1]);
              }
              else{
            $articulo = 'en el articulo 51 del reglamento estudiantil de la Universidad';
            $notanumero = '3.0';
            $notaletra = 'tres punto cero';
            if ($moda == '300' ) {
                $articulo = ' en el articulo  46 del reglamento estudiantil de la Universidad';
                $notanumero = '3.0';
                $notaletra = 'tres punto cero';
            }
              }
    ?>
        <tr>
            <td colspan="7"><p align="justify" class="Estilo1 Estilo2"><br>
                    De conformidad con lo dispuesto <?php echo $articulo; ?> , la escala de calificaciones que aplica la Institución est&aacute; dentro de un rango de cero punto cero (0.0) a cinco punto cero (5.0) y la calificación m&iacute;nima aprobatoria es de <?php echo "$notaletra ($notanumero)"; ?> sobre cinco punto cero (5.0).</p>
                <p align="justify" class="Estilo1 Estilo2">La presente certificaci&oacute;n se expide a solicitud del interesado(a), en Bogot&aacute; D.C., a los
                        <?php 
                        $day = $dia;
                        $mesesano = $mes;
                        require('convertirnumeros.php');
                        echo $dias;
                        ?> (<?php echo $dia;?>) d&iacute;as del mes de <?php echo $meses;?> (<?php echo $mes;?>) del a&ntilde;o dos mil <?php $day = substr($ano,2,4);
                        require('convertirnumeros.php');
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
                        $responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
                        $row_responsable = mysql_fetch_assoc($responsable);
                        $totalRows_responsable = mysql_num_rows($responsable);
    ?>
                </span>
                <p class="Estilo1 Estilo2"><strong><a class="Estilo4"style='cursor: pointer' onClick='window.print()' ><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?></a><br>
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
            <td align="center" colspan="3"><input type="button" onClick="history.back()" name="regresar" value="Regresar">&nbsp;&nbsp;<input type="button" onClick="print()" name="imprimir" value="Imprimir"></td>
        </tr>
            <?php
        }
?>
    </table>
</form>
</body>
</html>
