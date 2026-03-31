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
//if($_GET['tipocertificado'] == "reglamento")
//{
//echo $_GET["periodo".$i],"<BR>";
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
                            </a></strong></span><br>
                    En cumplimiento de lo dispuesto en el literal h) del art&iacute;culo 29 del Reglamento General de la Universidad
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
            <td colspan="7" class="Estilo1 Estilo5" align="center"><strong><font color="#990000">No válido como certificado de notas.</font></strong></td>
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
                        //echo $query_historico;
                        //exit();
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
					ORDER BY 1,2";		//			and n.notadefinitiva >= m.notaminimaaprobatoria
                        //echo $query_historico;
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
                        // echo $query_historico;					and n.notadefinitiva >= m.notaminimaaprobatoria
                        $res_materia = mysql_query($query_materia, $sala) or die("$query_materia".mysql_error());
                        $solicitud_materia = mysql_fetch_assoc($res_materia);
                        $totalRows = mysql_num_rows($res_materia);
                        $query_materiaelectiva = "SELECT *
					FROM materia
					WHERE codigoindicadoretiquetamateria LIKE '1%'
					and codigomateria = '".$solicitud_historico['codigomateriaelectiva']."'";
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
                                $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die(mysql_error());
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
            <td class="Estilo1 Estilo2"><?php if ($mostrarpapa <> "") echo "$mostrarpapa /  ";
                                    echo $solicitud_historico['nombremateria'].$lugaresderotacion;?>
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
                                            if($solicitud_historico['codigoindicadorcredito'] == 200) {
                                                if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                    echo "&nbsp;";
                                                }
                                                else {
                                                    echo $solicitud_historico['total'];
                                                }
                                                $sumaulas=$sumaulas+$solicitud_historico['total'];
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
                                        if ($solicitud_historico['notadefinitiva'] > 5) {
                                            //$nota = substr(($solicitud_historico['notadefinitiva'] / 100),0,3);
                                            $nota = number_format(($solicitud_historico['notadefinitiva'] / 100),1);
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
                                        ?></div></td>
                                <?php
                                if($_GET['tiponota'] == 2) {
                                    ?>
            <td valign="top"><div align="center" class="Estilo1 Estilo2">
                                            <?php
                                            if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])) {
                                                echo $solicitud_historico['nombretiponotahistorico'];
                                            }
                                            ?></div></td>
                                    <?php
                                }
                                ?>
            <td valign="top" class="Estilo1 Estilo2">
                                    <?php
                                    $total = substr($nota,0,3);
                                    $numero =  substr($total,0,1);
                                    $numero2 = substr($total,2,2);
                                    require('convertirnumeros.php');
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
                            //echo "$cuentacambioperiodo == $totalRows <br>";
                            if ($cuentacambioperiodo == $totalRows) {
                                $cuentacambioperiodo = 0;
                                $periodosemestral = $solicitud_historico['codigoperiodo'];
                                //require('calculopromediosemestralmacheteado.php');
                                $promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodosemestral,$cadenamateria,$_GET['tipocertificado'],$sala, 1);
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
                                                    $promediosemestralperiodo =  number_format(($promediosemestralperiodo / 100),1);
                                                }
                                                $promediosemestralperiodo = number_format($promediosemestralperiodo,1);
                                                echo number_format($promediosemestralperiodo,1);
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
                                            require('convertirnumeros.php');
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
                                                        //$promedioacumuladop = AcumuladoReglamentoPeriodos ($codigoestudiante,$_GET['tipocertificado'],$Anotas,$sala);
                                                        $promedioacumuladop = AcumuladoReglamento($codigoestudiante,$_GET['tipocertificado'],$sala,$solicitud_historico['codigoperiodo']);
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
                                }							$sumaulas

                                        ="&nbsp;";
                                $sumacreditos = "&nbsp;";
                            }
                            $periodo = $solicitud_historico['codigoperiodo'];
                        }
                    }
                    while($solicitud_historico = mysql_fetch_assoc($res_historico));
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
                        <?php
                        //echo $ultimoperiodo;
                        echo $nombreultimoperiodo;
                ?></strong></td>
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
                        //$total = substr($solicitud_historico['notadefinitiva'],0,3);
                        //require('funcionequivalenciapromedio.php');
//require('calculopromedioacumulado.php');
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
//$total = substr($solicitud_historico['notadefinitiva'],0,3);
                    $numero =  substr($promedioacumulado,0,1);
                    $numero2 = substr($promedioacumulado,2,2);
                    require('convertirnumeros.php');
                    echo $numu."&nbsp&nbsp;".$numu2."&nbsp;";
                    $fecha_exp=explode("/",$_REQUEST['fechaexpedicion']);
                    $ano = $fecha_exp[2];
                    $mes = $fecha_exp[1];
                    $dia = $fecha_exp[0];
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
                        <?
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
                        //echo $query_responsable;
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
