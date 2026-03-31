<?php
require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
require ('../../../funciones/sala_genericas/FuncionesCadena.php');
@session_start();
//require('funcionequivalenciapromedio.php');
mysql_select_db($database_sala, $sala);

if(isset($_GET['codigo'])) {
    $_SESSION['codigo'] = $_GET['codigo'];
}
$codigocarrera = $_SESSION['codigofacultad'];
$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
$codigoestudiante = $_SESSION['codigo'];
$periodo = 0;
$carreraestudiante = 0;
$usuario = $_SESSION['MM_Username'];

if($_GET['tipocertificado'] == "semestre") {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=certificados_semestre/certificadosformulario.php?tipocertificado=semestre&codigo=".$_GET['codigo']."&concredito=".$_GET['concredito']."&tiponota=".$_GET['tiponota']."&ppsa=".$_GET['ppsa']."'>";
    exit();
}

$query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";
//echo $query_tipousuario;
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

?>
<style type="text/css">
    <!--
    .Estilo1 {font-family: tahomo}
    .Estilo2 {font-family: tahoma}
    .Estilo3 {font-size: x-small}
    .Estilo4 {font-family: tahoma; font-size: x-small; }
    .Estilo6 {font-size: x-small; font-weight: bold; }
    .Estilo8 {font-family: tahoma; font-size: xx-small; }
    .Estilo10 {font-family: tahoma; font-size: 9px; }
    -->
</style>
<style type="text/css">
    <!--
    .Estilo1 {font-family: tahoma}
    .Estilo2 {font-size: xx-small}
    .Estilo3 {
        font-size: x-small;
        font-weight: bold;
    }
    .Estilo4 {font-size: x-small}
    -->
</style>
<form name="form1" method="post" action="">

    <?php
    $graduadoegresado = false;
    if($_GET['tipocertificado'] == "todo" or $_GET['tipocertificado'] == "pasadas") {
        //echo $_GET["periodo".$i],"<BR>";
        $query_historico = "SELECT 	c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,e.codigosituacioncarreraestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera,codigomodalidadacademica
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '".$codigoestudiante."'
	AND eg.tipodocumento = doc.tipodocumento
	AND e.codigocarrera = c.codigocarrera
	AND c.codigotitulo = ti.codigotitulo";
        //echo $query_historico;
        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
        $solicitud_historico = mysql_fetch_assoc($res_historico);
        $carreraestudiante = $solicitud_historico['codigocarrera'];
        $moda = $solicitud_historico['codigomodalidadacademica'];
        if($solicitud_historico <> "") {// if 1
            // echo $_SESSION['rol'];
            if ($_SESSION['rol'] == 1 or isset($_GET['periodos'])) { // rol
                //echo $_GET['periodos'];
                ?>
    <p class="Estilo4"><strong>Estudiante:</strong> <?php echo $solicitud_historico['nombresestudiantegeneral'],"&nbsp;",$solicitud_historico['apellidosestudiantegeneral']; ?><br>
        <strong>Documento:</strong> <?php echo $solicitud_historico['numerodocumento']; ?></p>
    <p class="Estilo2" align="center"><span class="Estilo6"><font color="#990000">No válido como certificado de notas.</font><font color="#990000"></font></span></p>
                <?php
            } // rol

            if($solicitud_historico['codigosituacioncarreraestudiante'] == 400) {
                $graduadoegresado = true;
            }
            //if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $_SESSION['MM_Username'] <> 'dirsecgeneral')
            // echo $row_tipousuario['codigotipousuariofacultad'];
            if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100) {
                echo '<script language="JavaScript">alert("Este estudiante es egresado, por lo que el certificado se expide en Secretaria General")</script>';
                /*echo '<script language="JavaScript">history.go(-1)</script>';	*/
            }

            ?>

    <table width="80%"  border="0" align="center" cellpadding="0">
                <?php  // if ($_SESSION['rol'] <> 1)
                // { // rol	 2
                ?>
        <tr>
            <td colspan="7"><div align="center" class="Estilo1 Estilo2">
                    <p>
                                <?php
                                //if($_SESSION['MM_Username'] == 'dirsecgeneral')

                                if($row_tipousuario['codigotipousuariofacultad'] == 200 and !isset($_GET['periodos'])) {
                                    ?>
                        <span class="Estilo3">EL SUSCRITO SECRETARIO GENERAL</span><br>
                        En cumplimiento de lo dispuesto en el literal d) del art&iacute;culo 21 del Reglamento General de la Universidad</p>
                                <?php
                            }
                            else
                            if($row_tipousuario['codigotipousuariofacultad'] == 100 and !isset($_GET['periodos'])) {
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
                            </a></strong></span><br>
                    En cumplimiento de lo dispuesto en el literal h) del art&iacute;culo 29 del Reglamento General de la Universidad

                                <?php
                            }
                            if ($_SESSION['rol'] <> 1 and !isset($_GET['periodos'])) {
                                ?>
                    <p class="Estilo3">HACE CONSTAR:</p>
                    <p align="justify">Que <strong><?php echo $solicitud_historico['nombresestudiantegeneral'],"&nbsp;",$solicitud_historico['apellidosestudiantegeneral']; ?></strong>, identificado(a) con <?php echo $solicitud_historico['nombredocumento']; ?> No. <?php echo $solicitud_historico['numerodocumento']; ?> de <?php echo $solicitud_historico['expedidodocumento']; ?><!-- , con c&oacute;digo estudiantil No. <?php //echo $solicitud_historico['codigoestudiante']; ?> -->, curs&oacute;
                                    <?php
                                }
                                //if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $_SESSION['MM_Username'] == 'dirsecgeneral')
                                if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 200 and !isset($_GET['periodos'])) {
                                    ?>
		    y aprob&oacute; las asignaturas correspondientes al programa de <?php echo $solicitud_historico['nombrecortocarrera']; ?>, y obtuvo el t&iacute;tulo de <strong><?php echo $solicitud_historico['nombretitulo']; ?></strong>.</p>
                                <?php
                            }
                            else
                            if ($solicitud_historico['codigosituacioncarreraestudiante'] <> 400 and $_SESSION['rol'] <> 1 and !isset($_GET['periodos'])) {
                                ?>
		 las asignaturas abajo relacionadas correspondientes al programa de <?php echo $solicitud_historico['nombrecortocarrera']; ?>.
                                    <?php
                                }
                                if ($_SESSION['rol'] <> 1 and !isset($_GET['periodos'])) {
                                    ?>
                    <p align="justify">Que de conformidad con la información que reposa en los registros académicos de la Universidad, obtuvo las siguientes calificaciones:</p>
                </div>

                            <?php
                        }
                        ?>
            </td>
        </tr>
                <?php
                //   } // rol 2
                ?>


        <tr>
            <td width="11%"><span class="Estilo2 Estilo1"><strong>C&oacute;digo</strong></span></td>
            <td width="32%"><span class="Estilo2 Estilo1"><strong>Materia</strong></span></td>
                    <?php
                    if($_GET['concredito']) {
                        ?>
            <td width="5%"><div align="center"><span class="Estilo2 Estilo1"><strong>Ulas</strong></span></div></td>
            <td width="7%"><div align="center"><span class="Estilo2 Estilo1"><strong>Cr&eacute;ditos</strong></span></div></td>
                        <?php
                    }
                    ?>
            <td width="7%"><div align="center"><span class="Estilo2 Estilo1"><strong>Nota</strong></span></div></td>
                    <?php
                    if($_GET['tiponota']) {
                        ?>
            <td width="15%"><div align="center"><span class="Estilo2 Estilo1"><strong>Tipo Nota </strong></span></div></td>
                        <?php
                    }
                    ?>
            <td width="23%"><span class="Estilo2 Estilo1"><strong>Letras</strong></span></td>
        </tr>
                <?php
                $cuentacambioperiodo = 0;
                $sumaulas="&nbsp;";
                $sumacreditos = "&nbsp;";
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
                    //echo $query_historicoperiodos;
                    $res_historicoperiodos = mysql_query($query_historicoperiodos, $sala) or die("$query_historicoperiodos".mysql_error());
                    $solicitud_historicoperiodos = mysql_fetch_assoc($res_historicoperiodos);
                    $total_periodosperiodos = mysql_num_rows($res_historicoperiodos);

                    $_GET['totalperiodos'] = $total_periodosperiodos;
                    $j = 1;
                    do {
                        //echo $solicitud_historicoperiodos['codigoperiodo'], "<br>";
                        $_GET["periodo".$j] = $solicitud_historicoperiodos['codigoperiodo'];
                        //echo $_GET["periodo".$j],"<br>";
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
                            //echo $query_historico,"<br><br>";
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
                            //echo $query_historico,"<br><br><br>";
                            $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                            $solicitud_historico = mysql_fetch_assoc($res_historico);
                        }
                        do {

                            mysql_select_db($database_sala, $sala);
                            $mostrarpapa = "";
                            //////////////////////////////////////////////////////////////////
                            if ($_GET['tipocertificado'] == "todo") {
                                $query_materia = "SELECT *
				  	FROM notahistorico
					WHERE codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
					AND codigoestudiante = '".$codigoestudiante."'
					AND codigoestadonotahistorico LIKE '1%'";
                                //echo $query_materia,"<br>";
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
                                //echo $query_materia,"<br>";
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
                            //echo $query_materiaelectiva;
                            $materiaelectiva = mysql_query($query_materiaelectiva, $sala) or die("$query_materiaelectiva".mysql_error());
                            $row_materiaelectiva = mysql_fetch_assoc($materiaelectiva);
                            $totalRows_materiaelectiva = mysql_num_rows($materiaelectiva);
                            if($totalRows_materiaelectiva != "") {
                                $solicitud_historico['codigomateria'] = $row_materiaelectiva['codigomateria'];
                                $solicitud_historico['nombremateria'] = $row_materiaelectiva['nombremateria'];
                                // Toca definir como hacer con el calculo de creditos (Se hace con el papa o con el hijo)
                                //$solicitud_historico['codigoindicadorcredito'] = $row_materiaelectiva['codigoindicadorcredito'];
                            }
                            else {
                                if ($solicitud_historico['codigomateriaelectiva'] <> "" and $solicitud_historico['codigomateriaelectiva'] <> "1") {
                                    $mostrarpapa = "";
                                    $query_materiaelectiva1 = "SELECT nombremateria, numerocreditos, codigotipomateria
							FROM materia
							WHERE codigomateria = ".$solicitud_historico['codigomateriaelectiva']."";
                                    //echo $query_materiaelectiva1;
                                    //echo $row_Recordset1['codigomateria']." as ".$query_materiaelectiva;
                                    $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die("$query_materiaelectiva1".mysql_error());
                                    $row_materiaelectiva1 = mysql_fetch_assoc($materiaelectiva1);
                                    $totalRows_materiaelectiva1 = mysql_num_rows($materiaelectiva1);
                                    if ($totalRows_materiaelectiva1 <> 0) {
                                        $mostrarpapa = $row_materiaelectiva1['nombremateria'];
                                        // Si la materia es de tipo electiva obligatoria muestra los creditos de la papá
                                        if($row_materiaelectiva1['codigotipomateria'] == 5) {
                                            $solicitud_historico['numerocreditos'] = $row_materiaelectiva1['numerocreditos'];
                                        }
                                    }
                                }
                            }
                            if ($periodo <> $solicitud_historico['codigoperiodo']) {
                                $nombreultimoperiodo = $solicitud_historico['nombreperiodo'];
                                ?>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"><span class="Estilo1 Estilo2"><strong><?php echo $solicitud_historico['nombreperiodo'];?></strong></span></td>
        </tr>
                                <?php
                            }
                            // Selecciona los datos de los sitios de rotación
                            /*$query_sellugarrotacion = "select l.idlugarorigennota, l.nombrelugarorigennota
					from lugarorigennota l, rotacionnotahistorico r, notahistorico n
					where l.fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
					and l.fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
					and r.idnotahistorico = '".$solicitud_historico['idnotahistorico']."'
					and r.idlugarorigennota = l.idlugarorigennota
					and n.codigomateria = '".$solicitud_historico['codigomateria']."'
					and n.idnotahistorico = r.idnotahistorico
					order by 2, 1";*/
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
                            //echo "$query_sellugarrotacion";
                            if($totalRows_sellugarrotacion != "") {
                                while($row_sellugarrotacion = mysql_fetch_assoc($sellugarrotacion)) {
                                    $nombrelugarorigennota = $row_sellugarrotacion['nombrelugarorigennota'];
                                    $lugaresderotacion = "$lugaresderotacion <br> &nbsp;&nbsp;&nbsp;&nbsp; $nombrelugarorigennota";
                                }
                                $lugaresderotacion = ":".$lugaresderotacion;
                            }
                            //echo "$lugaresderotacion";


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
            <td valign="top"><span class="Estilo1 Estilo2"><?php echo $solicitud_historico['codigomateria'];?></span></td>
            <td><span class="Estilo1 Estilo2"><?php if ($mostrarpapa <> "") echo "$mostrarpapa /  ";
                                        echo $solicitud_historico['nombremateria'].$lugaresderotacion;?>
                                        <?php
                                        if ($row_detallemateria <> "") {
                                            ?>
                    <table width="100%" border="0" align="left" cellpadding="0">
                                                <?php
                                                do {

                                                    ?>
                        <tr>
                            <td class="Estilo10">- <?php echo $row_detallemateria['descripciontemasdetalleplanestudio'];?></td>
                        </tr>
                                                    <?php
                                                }while($row_detallemateria = mysql_fetch_assoc($detallemateria));
                                                ?>
                    </table>

                                            <?php
                                        }
                                        ?>

                </span></td>
                                <?php
                                if($_GET['concredito'] == 1) { // if creditos
                                    ?>
            <td valign="top"><div align="center"><span class="Estilo1 Estilo2">
                                                <?php
                                                if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                                    if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                        echo "&nbsp;";
                                                    }
                                                    else {
                                                        echo $solicitud_historico['total'];
                                                    }
                                                    $sumaulas=$sumaulas+$solicitud_historico['total'];
                                                }
                                                ?></span></div></td>
            <td valign="top"><div align="center"><span class="Estilo1 Estilo2">
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
                                                ?></span></div></td>
                                    <?php
                                } // if creditos
                                ?>
            <td valign="top"><div align="center"><span class="Estilo1 Estilo2">
                                            <?php
                                            if ($solicitud_historico['notadefinitiva'] > 5) {
                                                //$nota = substr(($solicitud_historico['notadefinitiva'] / 100),0,3);
                                                $nota = number_format(($solicitud_historico['notadefinitiva'] / 100),1);
                                                $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['total']/100] = $solicitud_historico['notadefinitiva']/100;
                                            }
                                            else {
                                                $nota = number_format($solicitud_historico['notadefinitiva'],1);
                                                $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['numerocreditos']] = $solicitud_historico['notadefinitiva'];
                                            }
                                            if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                echo "&nbsp;";
                                            }
                                            else {
                                                echo number_format($nota,1);
                                            }
                                            ?></span></div></td>
                                <?php
                                if($_GET['tiponota'] == 2) {
                                    ?>
            <td valign="top"><div align="center"><span class="Estilo1 Estilo2">
                                                <?php
                                                if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    echo $solicitud_historico['nombretiponotahistorico'];
                                                }
                                                ?></span></div></td>
                                    <?php
                                }
                                ?>
            <td valign="top"><span class="Estilo1 Estilo2">
                                        <?php
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
                                        ?>
                    &nbsp;</span></td>
        </tr>
                            <?php
                            $cuentacambioperiodo ++;
                            if ($cuentacambioperiodo == $totalRows) {
                                $cuentacambioperiodo = 0;
                                $periodosemestral = $solicitud_historico['codigoperiodo'];
                                //require('calculopromediosemestral.php');

                                $promediosemestralperiodo = PeriodoSemestralTodo($codigoestudiante,$periodosemestral,$_GET['tipocertificado'],$sala, 1);
                                ?>
        <tr>
            <td colspan="2"><span class="Estilo2 Estilo1"><strong>Promedio Ponderado Semestral </strong></span></td>
                                    <?php
                                    if($_GET['concredito'] == 1) {
                                        ?>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong><?php echo $sumaulas;?></strong></span></div></td>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong><?php echo $sumacreditos;?></strong></span></div></td>
                                        <?php
                                    }
                                    ?>
            <td><div align="center"><span class="Estilo2 Estilo1"><strong>
                                                    <?php
                                                    if ($promediosemestralperiodo > 5) {
                                                        $promediosemestralperiodo = number_format(($promediosemestralperiodo / 100),1);
                                                    }
                                                    /*$promediosemestralperiodo = number_format($promediosemestralperiodo,1);*/
                                                    echo $promediosemestralperiodo;
                                                    ?>&nbsp;</strong></span></div></td>
                                    <?php
                                    if($_GET['tiponota'] == 2) {
                                        ?>
            <td><div align="center"></div></td>
                                        <?php
                                    }
                                    ?>
            <td><span class="Estilo2 Estilo1"><strong>
                                                <?php 				//$total = substr($solicitud_historico['notadefinitiva'],0,3);
                                                $numero =  substr($promediosemestralperiodo,0,1);
                                                $numero2 = substr($promediosemestralperiodo,2,2);
                                                require('convertirnumeros.php');
                                                echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                                ?>
                        &nbsp;</strong></span></td>
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
                                                        $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);
                                                        //$promedioacumuladop = AcumuladoReglamentoPeriodos ($codigoestudiante,$_GET['tipocertificado'],$Anotas,$sala);
                                                        if($promedioacumuladop > 5) {
                                                            $promedioacumuladop =  number_format(($promedioacumuladop / 100),1);
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
                                                    require('convertirnumeros.php');
                                                    echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                                    ?>
                        &nbsp;</strong></span></td>
        </tr>
                                    <?php
                                }						$sumaulas



                                        ="&nbsp;";
                                $sumacreditos = "&nbsp;";
                            }
                            $periodo = $solicitud_historico['codigoperiodo'];
                        }
                        while($solicitud_historico = mysql_fetch_assoc($res_historico));
                    } // if 1
                } // if
            }
            //for
    ?>
        <tr>
            <td colspan="2"><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
        </tr>
        <tr>
                <?php
                if($carreraestudiante == 10) {
        ?>
            <td colspan="2"><span class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado a <?php
                                //echo $ultimoperiodo;
                                echo $nombreultimoperiodo;
                    ?></strong></span></td>
                    <?php
                }
                else {
        ?>
            <td colspan="2"><br><span class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado </strong></span></td>
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
            <td><div align="center"><span class="Estilo2 Estilo1"><strong>
                                <?php
                                //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                                //require('funcionequivalenciapromedio.php');

                                //require('calculopromedioacumulado.php');
                                $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado'],$sala);
                                if($promedioacumulado > 5) {
                                    $promedioacumulado =  number_format(($promedioacumulado / 100),1);
                                }
                                echo $promedioacumulado;
    ?>
                        </strong></span></div></td>
                <?php
                if($_GET['tiponota'] == 2) {
        ?>
            <td>&nbsp;</td>
                    <?php
                }
    ?>
            <td><span class="Estilo2 Estilo1"><strong>
                            <?php
                            //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                            $numero =  substr($promedioacumulado,0,1);
                            $numero2 = substr($promedioacumulado,2,2);
                            require('convertirnumeros.php');
                            echo $numu."&nbsp&nbsp;".$numu2."&nbsp;";
                            $ano = substr(date("Y-m-d"),0,4);
                            $mes = substr(date("Y-m-d"),5,2);
                            $dia = substr(date("Y-m-d"),8,2);
    ?>
                        &nbsp;</strong></span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
            <td><span class="Estilo2"></span></td>
        </tr>

            <?php
            if ($_SESSION['rol'] <> 1 and !isset($_GET['periodos'])) {

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
                //$notaletra = 'tres punto cero';
              }
              else{
            // rol 1
             /*   $articulo = '51';
                $notanumero = '3.0';
                $notaletra = 'tres punto cero';
                if ($moda == '300' ) {
                    $articulo = '46';
                    $notanumero = '3.0';
                    $notaletra = 'tres punto cero';
                }*/


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
            <td colspan="7">
                <p align="justify" class="Estilo1 Estilo2"><br>
  	De conformidad con lo dispuesto   <?php echo $articulo; ?> , la escala de calificaciones que aplica la Institución est&aacute; dentro de un rango de cero punto cero (0.0) a cinco punto cero (5.0) y la calificación m&iacute;nima aprobatoria es de <?php echo "$notaletra ($notanumero)"; ?> sobre cinco punto cero (5.0).</p>
                <p align="justify" class="Estilo1 Estilo2">La presente certificaci&oacute;n se expide a solicitud del interesado(a), en Bogot&aacute; D.C., a los
                            <?
                            $day = $dia;
                            $mesesano = $mes;
                            require('convertirnumeros.php');
                            echo $dias;
                            ?> (<?php echo $dia;?>) d&iacute;as del mes de <?php echo $meses;?> (<?php echo $mes;?>) del a&ntilde;o dos mil <?php $day = substr($ano,2,4);
                            require('convertirnumeros.php');
        echo $dias; ?> (<?php echo $ano;?>).</p>
                <p class="Estilo1 Estilo2">&nbsp;</p>
                <table>
                    <tr>
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
                                $responsable = mysql_query($query_responsable, $sala) or die(mysql_error()." ".$query_responsable);
                                $row_responsable = mysql_fetch_assoc($responsable);
                                $totalRows_responsable = mysql_num_rows($responsable);
                                $contador = 0;
                                do {
            ?>
                        <td>
                            <p class="Estilo1 Estilo2"><strong><a class="Estilo4"style='cursor: pointer' onClick='JavaScript:window.print()' ><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?></a><br>
                                                <?php
                                                echo $row_responsable['cargodirectivo'];
            ?>
                                </strong></td>
                                    <?php
                                    if ($totalRows_responsable > 1 and $contador == 0) {
                ?>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <?php
                                        $contador = 1;
                                    }
                                }while($row_responsable = mysql_fetch_assoc($responsable));
        ?>
                    </tr>
                </table>
            </td>
        </tr>

                <?php
            } // rol 1
            else {
        ?>
        <tr>
            <td align="center" colspan="3"><input type="button" onClick="history.go(-1)" name="regresar" value="Regresar">&nbsp;&nbsp;<input type="button" onClick="print()" name="imprimir" value="Imprimir"></td>
        </tr>
                <?php
            }
    ?>

    </table>
</form>
    <?php
}
if($_GET['tipocertificado'] == "reglamento") {
    if(isset($_GET['periodos'])) {
        $query_selperiodos = "SELECT distinct codigoperiodo
	    from notahistorico
	    where codigoestudiante = '$codigoestudiante'
		order by 1";
        //echo $query_selperiodos;
        //exit();
        $selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
        $total_selperiodos = mysql_num_rows($selperiodos);
        $_GET['totalperiodos'] = $total_selperiodos;
        $estei = 1;
        while($row_selperiodos = mysql_fetch_assoc($selperiodos)) {
            $_GET["periodo".$estei] = $row_selperiodos['codigoperiodo'];
            $estei++;
        }
    }
    // Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo

    $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
	when 0 then n.notadefinitiva
	when 1 then n.notadefinitiva / 100
	end as nota, n.codigoperiodo, m.nombremateria
	from notahistorico n, materia m
	where n.codigoestudiante = '$codigoestudiante'
	and n.codigomateria = m.codigomateria
	AND codigoestadonotahistorico LIKE '1%'
	order by 5, 3 ";
    //echo $query_materiashistorico,"jaja";
    //exit();
    $materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error()." Query=".$query_materiashistorico);
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
            // echo "($cadequivalencias";
            // exit();
            $row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
            $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
            //echo "materiaequivalente= ".$row_materiashistorico['codigomateria']."materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
        }
        else {
            $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
        }
    }
    //exit();
    $Array_materiashistoricoinicial = $Array_materiashistorico;
    //echo "<pre>".print_r($Array_materiashistorico)."</pre>";
    // Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
    // Para esto primero creo un arreglo con las equivalencias de cada materia
    foreach($Array_materiashistorico as $codigomateria => $row_materia) {
        //echo "nombre => ".$row_materia['nombremateria']." $codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
        $otranota = $row_materia['nota']*100;
        // Arreglo bidimensional con las materias en cada periodo
        $cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
        $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
    }
    //exit();
    $cadenamateria = $cadenamateria."fin";
    $cadenamateria = ereg_replace("orfin","",$cadenamateria);
    //echo "<h1>$cadenamateria</h1>";
    //exit();
    /*foreach($Array_materiasperiodo as $codigoperiodo => $Array_materia)
	{
		//echo "<br><strong>$codigoperiodo</strong> <br>";
		// Arreglo bidimensional con las materias en cada periodo
		foreach($Array_materia as $key => $row_materiaperiodo)
		{
			echo "".$row_materiaperiodo['codigomateria']." => ".$row_materiaperiodo['nombremateria']."<br>";
		}
	}*/
    //exit();
    require("certificadoconreglamento.php");
}
?>
