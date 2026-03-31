<?php
    session_start();
    /*para que se va a repetir?
	include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
    
require_once('../../Connections/sala2.php');
//session_start();

include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'NotaHistorico-NuevaMateria');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}


require_once('../../funciones/funcionip.php' );
require_once('../../utilidades/notas/funcionesModificarNotas.php' );

$ip = (tomarip())?tomarip():"SIN DEFINIR";

if (!$_SESSION['MM_Username'] or !$_SESSION['codigoperiodosesion']) {
	header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
}

$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];

mysql_select_db($database_sala, $sala);
$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

if (isset($_GET['periodo'])) {
	$periodo = $_GET['periodo'];
	$periodoactual = $periodo;
}

if (isset($_GET['codigoestudiante'])) {
	$codigoestudiante = $_GET['codigoestudiante'];
}

if ($_GET['Submit2']) {
	echo '<script language="JavaScript">window.location.href="modificahistoricoformulario.php?codigoestudiante='.$codigoestudiante.'&periodo='.$periodo.'";</script>';
}
//mysql_select_db($database_sala, $sala);

$query_Recordset2 = "  SELECT * FROM estudiante e,estudiantegeneral eg
            WHERE e.idestudiantegeneral = eg.idestudiantegeneral
                and e.codigoestudiante = '$codigoestudiante'";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<style type="text/css">
	<!--
	.style1 {
		font-family: Tahoma;
		font-size: small;
	}
	.style3 {
		font-size: x-small;
		font-weight: bold;
	}
	.style4 {font-size: x-small}
	.style5 {
		color: #FF0000;
		font-weight: bold;
	}
	body {
		margin-top: 0px;
	}
	.style41 {
		font-size: x-small;
		font-family: Tahoma;
	}
	.style51 {
		font-family: Tahoma;
		font-size: x-small;
	}
	.style31 {
		font-size: x-small;
		font-weight: bold;
		font-family: Tahoma;
	}
	.Estilo28 {
		font-family: Tahoma;
		font-weight: bold;
	}
	-->
</style>
<?php
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
	// For security, start by assuming the visitor is NOT authorized.
	$isValid = False;
	// When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
	// Therefore, we know that a user is NOT logged in if that Session variable is blank.
	if (!empty($UserName)) {
		// Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
		// Parse the strings into arrays.
		$arrUsers = Explode(",", $strUsers);
		$arrGroups = Explode(",", $strGroups);
		if (in_array($UserName, $arrUsers)) {
			$isValid = true;
		}
		// Or, you may restrict access to only certain users based on their username.
		if (in_array($UserGroup, $arrGroups)) {
			$isValid = true;
		}
		if (($strUsers == "") && true) {
			$isValid = true;
		}
	}
	return $isValid;
}

//mysql_select_db($database_sala, $sala);
//SELECT * FROM tiponotahistorico
//WHERE codigotiponotahistorico <> '100'
$query_tiponota = "SELECT * FROM tiponotahistorico order by 2";
$tiponota = mysql_query($query_tiponota, $sala) or die(mysql_error());
$row_tiponota = mysql_fetch_assoc($tiponota);
$totalRows_tiponota = mysql_num_rows($tiponota);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Documento sin t&iacute;tulo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script language="JavaScript" >
			function cancelar(id) {
				if(confirm('Esta seguro de cancelar la solictud "'+id+'"?')){
					document.form1.IdSolicitud.value=id;
					document.form1.accion.value="cancelar";
					document.form1.submit();
				}
			}
		</script>
	</head>
	<body>
		<form name="form1" method="get" action="modificahistoriconuevamateria.php">
			<input type="hidden" name="accion">
			<input type="hidden" name="IdSolicitud">
<?php
			$tipomateria = "";
			$plan = "";
			$banderaelectiva = 0;
			//mysql_select_db($database_sala, $sala);

			if ($row_tipousuario['codigotipousuariofacultad'] == 200) { // if
            $query_cursos ="SELECT DISTINCT
							m.codigomateria
							,m.nombremateria
							,pe.idplanestudio
							,d.codigotipomateria
						FROM materia m
						,planestudio p
						,detalleplanestudio d
						,planestudioestudiante pe
						,estudiante e
						WHERE  m.codigoestadomateria = '01'
							AND p.codigocarrera = e.codigocarrera
							AND pe.codigoestudiante = '".$codigoestudiante."'
							AND p.idplanestudio = d.idplanestudio
							AND d.codigomateria = m.codigomateria
							AND pe.idplanestudio = p.idplanestudio
							AND m.codigocarrera = '".$row_tipousuario['codigofacultad']."'
							AND p.codigoestadoplanestudio LIKE '1%'
							AND d.codigomateria not in (	select codigomateria
											from solicitudaprobacionmodificacionnotas
											join (select max(id) id from solicitudaprobacionmodificacionnotas group by codigomateria) sub using(id)
											where idtiposolicitudaprobacionmodificacionnotas=30
												and codigoestadosolicitud in (10,11)
												and codigoestudiante=".$_REQUEST["codigoestudiante"]."
												AND notamodificada>=m.notaminimaaprobatoria 
											)";
							//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
				//echo "1 ".$query_cursos;
				$cursos = mysql_query($query_cursos,$sala) or die(mysql_error());
				$row_cursos = mysql_fetch_assoc($cursos);
				$totalRows_cursos = mysql_num_rows($cursos);
				$plan = $row_cursos['idplanestudio'];
			} else {
				$query_cursos ="SELECT	m.nombremateria
							,m.codigomateria
							,pe.idplanestudio
						FROM materia m
						,planestudio p
						,detalleplanestudio d
						,planestudioestudiante pe
						WHERE  m.codigoestadomateria = '01'
							AND  p.codigocarrera = '".$_SESSION['codigofacultad']."'
							and pe.codigoestudiante = '".$codigoestudiante."'
							AND p.idplanestudio = d.idplanestudio
							AND d.codigomateria = m.codigomateria
							and pe.idplanestudio = p.idplanestudio
							AND pe.codigoestadoplanestudioestudiante LIKE '1%'
							AND d.codigomateria not in (	select codigomateria
											from solicitudaprobacionmodificacionnotas
											join (select max(id) id from solicitudaprobacionmodificacionnotas group by codigomateria) sub using(id)
											where idtiposolicitudaprobacionmodificacionnotas=30
												and codigoestadosolicitud in (10,11)
												and codigoestudiante=".$_REQUEST["codigoestudiante"]."
												AND notamodificada>=m.notaminimaaprobatoria 
											)
						ORDER BY 1";
						//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
				//echo "2 ".$query_cursos;
				$cursos = mysql_query($query_cursos,$sala) or die(mysql_error());
				$row_cursos = mysql_fetch_assoc($cursos);
				$totalRows_cursos = mysql_num_rows($cursos);
				$plan = $row_cursos['idplanestudio'];
			}
			if ($plan == "") {
				$query_study ="	SELECT idplanestudio
						FROM planestudioestudiante
						WHERE codigoestudiante = '".$codigoestudiante."'
							AND codigoestadoplanestudioestudiante LIKE '1%'";
							//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
				//echo $query_cursos;
				$study = mysql_query($query_study,$sala) or die(mysql_error());
				$row_study = mysql_fetch_assoc($study);
				$totalRows_study = mysql_num_rows($study);
				$plan = $row_study['idplanestudio'];
			}
			if ($_GET['materia'] <> 0) {				
				//$plan = 550;
				mysql_select_db($database_sala, $sala);
				$query_car = "	SELECT m.codigoindicadorgrupomateria,d.codigotipomateria
						FROM detalleplanestudio d,materia m
						where d.codigomateria = m.codigomateria
							and d.codigomateria = '".$_GET['materia']."'
							and idplanestudio = '$plan'
						order by 1";
						
				if($_GET['materia'] == '1290' || $_GET['materia'] == '1291' || $_GET['materia'] == '1292'){
					$query_car = "SELECT
									*,
									m.codigomateria codigomateriamateria,
									dgm2.idgrupomateria idgrupomaterialibre
								FROM
									materia m,
									grupomateria gm,
									detallegrupomateria dgm
								LEFT JOIN detallegrupomateria dgm2 ON dgm2.codigomateria = dgm.codigomateria
								AND dgm2.idgrupomateria = 366
								WHERE
									gm.codigoperiodo = '".$periodoactual."'
								AND gm.idgrupomateria = dgm.idgrupomateria
								AND m.codigomateria = dgm.codigomateria
								AND gm.codigotipogrupomateria = '100'
								GROUP BY
									m.codigomateria
								ORDER BY
									m.nombremateria";
				}
				$car = mysql_query($query_car, $sala) or die(mysql_error());
				$row_car = mysql_fetch_assoc($car);
				$totalRows_car = mysql_num_rows($car);

				$tipomateria = $row_car['codigotipomateria'];

				if ($row_car['codigoindicadorgrupomateria'] == 100) {
					mysql_select_db($database_sala, $sala);
					$query_grupomateria = "SELECT * FROM (	select m.codigomateria,m.nombremateria,gml.codigomateria as materiaGrupo
								from grupomaterialinea gml
								,materia m
								,grupomateria gm
								,detallegrupomateria d
								where  gm.codigoperiodo = '$periodoactual'
									and d.idgrupomateria = gm.idgrupomateria
									and m.codigomateria = d.codigomateria
									and gml.codigomateria = '".$_GET['materia']."'
									and gml.idgrupomateria = d.idgrupomateria
									and gml.codigoperiodo = '$periodoactual'
									and gm.codigoperiodo = gml.codigoperiodo
								UNION 
									SELECT
											m.codigomateria,m.nombremateria,gml.codigomateria as materiaGrupo
									FROM
										grupomaterialinea gml,
										materia m,
										grupomateria gm,
										detallegrupomateria d
									WHERE
										gm.codigoperiodo = '$periodoactual'
									AND d.idgrupomateria = gm.idgrupomateria
									AND m.codigomateria = d.codigomateria
									AND gml.idgrupomateria = d.idgrupomateria
									AND gm.codigoperiodo = gml.codigoperiodo
									AND (gm.nombregrupomateria like '%ELECTIVAS APOYO INGRESO A LA UNIVERSIDAD%' 
									OR gm.nombregrupomateria like '%ELECTIVAS APOYO VIDA UNIVERSITARIA%' 
									OR gm.nombregrupomateria like '%ELECTIVAS APOYO VIDA LABORAL%')
									) x
									GROUP BY x.codigomateria
									ORDER BY
										x.nombremateria";
					//echo $query_grupomateria;
					$grupomateria = mysql_query($query_grupomateria, $sala) or die(mysql_error());
					$row_grupomateria = mysql_fetch_assoc($grupomateria);
					$totalRows_grupomateria = mysql_num_rows($grupomateria);
					//echo "<br/><pre>"; print_r($row_grupomateria);
					$tipomateria = 4;
				} else {
					if ($row_car['codigotipomateria'] == 5) {
						mysql_select_db($database_sala, $sala);
						$query_electiva = "	SELECT distinct d.codigomateriadetallelineaenfasisplanestudio
										,m.nombremateria
									FROM detallelineaenfasisplanestudio d,materia m
									where d.codigomateria = '".$_GET['materia']."'
										and d.idplanestudio = '$plan'
										and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
									order by m.nombremateria";
						//echo $query_electiva." 1";
						$electiva = mysql_query($query_electiva, $sala) or die(mysql_error());
						$row_electiva = mysql_fetch_assoc($electiva);
						$totalRows_electiva = mysql_num_rows($electiva);
					} else if ($row_car['codigotipomateria'] == 4) {
						mysql_select_db($database_sala, $sala);
						$query_electiva = "	select m.codigomateria as codigomateriadetallelineaenfasisplanestudio
										,m.nombremateria
									from materia m, grupomateria gm, detallegrupomateria d
									where gm.codigotipogrupomateria = '100'
										and gm.codigoperiodo = '$periodoactual'
										and d.idgrupomateria = gm.idgrupomateria
										and m.codigomateria = d.codigomateria
									order by m.nombremateria";
						//echo $query_electiva." 2";
						$electiva = mysql_query($query_electiva, $sala) or die(mysql_error());
						$row_electiva = mysql_fetch_assoc($electiva);
						$totalRows_electiva = mysql_num_rows($electiva);
					}
				}
			}
?>
			<script language="javascript">
				function enviar() {
					document.form1.submit();
				}
			</script>
			<p align="center"><span class="Estilo3 Estilo28">Modificaci&oacute;n Historico de Notas </span></p>
			<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
				<tr>
					<td colspan="5" class="style51" bgcolor="#C5D5D6">  <div align="center"><strong><?php echo "".$_SESSION['codigofacultad']." ".$_SESSION['nombrefacultad'];?></strong></div></td>
				</tr>
<?php
				$querySolicitud="select id
							,m.nombremateria
                            ,m.codigomateria
							,nombretiponotahistorico
							,codigoestadosolicitud
							,nombreestadosolicitudcredito
							,fechaaprobacion
							,notamodificada
							,observaciones, 
							CodigoMateriaElectiva,
						m2.nombremateria as materiaelectiva
						from (	select max(id) id
							from solicitudaprobacionmodificacionnotas
							where codigoestadosolicitud in (10,20)
								and idtiposolicitudaprobacionmodificacionnotas=30
								and codigoestudiante=".$_REQUEST["codigoestudiante"]."
							group by codigomateria
						) sub join solicitudaprobacionmodificacionnotas using(id)
						left join tiponotahistorico using(codigotiponotahistorico)
						left join materia m using(codigomateria)
						inner join materia m2 on m2.codigomateria=CodigoMateriaElectiva
						join estadosolicitudcredito on codigoestadosolicitud=codigoestadosolicitudcredito";

				$regSolicitud = mysql_query($querySolicitud,$sala) or die(mysql_error());
				if(mysql_num_rows($regSolicitud)) {
?>
					<tr>
						<td colspan="5">
							<table border="1" align="center" cellpadding="2" cellspacing="3" width="100%">
								<tr bgcolor="#F5D483">
									<td class="style51" width="10%" colspan="8"><div align="center"><span class="style31">Solicitudes de ingreso de notas</span></div></td>
								</tr>
								<tr bgcolor="#F5D483">
									<td class="style51" width="10%"><div align="center"><span class="style31">Id solicitud</span></div></td>
									<td class="style51" width="20%"><div align="center"><span class="style31">Nombre</span></div></td>
									<td class="style51" width="10%"><div align="center"><span class="style31">Tipo nota</span></div></td>
									<td class="style51" width="10%"><div align="center"><span class="style31">Nota</span></div></td>
									<td class="style51" width="20%"><div align="center"><span class="style31">Observación</span></div></td>
									<td class="style51" width="10%"><div align="center"><span class="style31">Fecha aprobación / rechazo</span></div></td>
									<td class="style51" width="10%"><div align="center"><span class="style31">Estado</span></div></td>
									<td class="style51" width="10%"><div align="center"><span class="style31">&nbsp;</span></div></td>
								</tr>
<?php
								while ($rowSolicitud = mysql_fetch_assoc($regSolicitud)) {
									$nombremateria = "";
									$font=($rowSolicitud['codigoestadosolicitud']=="10")?"000000":"D20D00";
                                    
                                    //validacion del nombre del enfasis y padre de la materia
                                    /*$sqlelectiva = "SELECT DISTINCT m.codigomateria, m.nombremateria FROM detallelineaenfasisplanestudio d, materia m WHERE d.idplanestudio = '".$plan."'
AND d.codigomateriadetallelineaenfasisplanestudio = '".$rowSolicitud["codigomateria"]."' and m.codigomateria = d.codigomateria";
                                    //echo $sqlelectiva.'<br>';
                                  	$electivamateria = mysql_query($sqlelectiva,$sala) or die(mysql_error());
								    $row_electivamateria = mysql_fetch_assoc($electivamateria);
                                    if($row_electivamateria['codigomateria']){
                                        $nombremateria = $row_electivamateria['nombremateria'].'/';
                                    }*/
									if($rowSolicitud['CodigoMateriaElectiva']!=1){
                                        $nombremateria = $rowSolicitud['materiaelectiva'].'/';
                                    }
?>
									<tr>
										<td width="10%" class="style51" align="center"><b><?php echo$rowSolicitud["id"]?></b></td>
										<td width="20%" class="style51"><b><?php echo $nombremateria.$rowSolicitud["nombremateria"]?></b></td>
										<td width="10%" class="style51" align="center"><b><?php echo$rowSolicitud["nombretiponotahistorico"]?></b></td>
										<td width="10%" class="style51" align="center" bgcolor='#CFFFEC'><b><?php echo$rowSolicitud["notamodificada"]?></b></td>
										<td width="20%" class="style51"><b><?php echo$rowSolicitud["observaciones"]?></b></td>
										<td width="10%" class="style51" align="center"><b><?php echo$rowSolicitud["fechaaprobacion"]?></b></td>
										<td width="10%" class="style51" align="center"><b><font color='#<?php echo$font?>'><?php echo$rowSolicitud["nombreestadosolicitudcredito"]?></font></b></td>
										<td width="10%" class="style51" align="center">
<?php
											if ($rowSolicitud['codigoestadosolicitud']=="10") {
?>	
												<input type='button' value='Cancelar solicitud' style='font-size:10px' onclick='cancelar(<?php echo$rowSolicitud['id']?>)'>
<?php
											}
?>
										</td>
									</tr>
<?php
								}
?>
							</table>
						</td>
					</tr>
<?php
				}
?>
				<tr>
					<td class="style51" bgcolor="#C5D5D6"><div align="center"><span class="style31">Nombre</span></div></td>
					<td colspan="2" class="style51"><?php  echo $row_Recordset2['apellidosestudiantegeneral']."&nbsp;".$row_Recordset2['nombresestudiantegeneral'];?></td>
					<td class="style51" bgcolor="#C5D5D6"><div align="center"><span class="style31">Documento</span></div></td>
					<td class="style51"><?php echo $row_Recordset2['numerodocumento']; ?></td>
				</tr>
				<tr>
					<td class="style51" bgcolor="#C5D5D6"><div align="center"><strong><strong>Materia</strong></strong></div></td>
					<td class="style51">
<?php
						if ($row_tipousuario['codigotipousuariofacultad'] == 100) { // if materia
?>
							<select name="materia" id="materia" onChange="enviar()">
								<option value="0" <?php if (!(strcmp(0, $_GET['materia']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
								$quitarmaterias = "";
								$query_enfasis ="SELECT distinct codigomateriadetallelineaenfasisplanestudio
										FROM detallelineaenfasisplanestudio
										where idplanestudio = '$plan'";
											//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
								// echo $query_cursos;
								$enfasis = mysql_query($query_enfasis,$sala) or die(mysql_error());
								$row_enfasis = mysql_fetch_assoc($enfasis);
								$totalRows_enfasis = mysql_num_rows($enfasis);
								do {
									$quitarmaterias = "$quitarmaterias and codigomateria <> '".$row_enfasis['codigomateriadetallelineaenfasisplanestudio']."'";
								} while($row_enfasis = mysql_fetch_assoc($enfasis));
								do {
									$quitarmaterias = "$quitarmaterias and m.codigomateria <> '".$row_cursos['codigomateria']."'";
?>
									<option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigomateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
<?php
								} while ($row_cursos = mysql_fetch_assoc($cursos));
								$rows = mysql_num_rows($cursos);
								if($rows > 0) {
									mysql_data_seek($cursos, 0);
									$row_cursos = mysql_fetch_assoc($cursos);
								}
								$query_cursos ="SELECT m.nombremateria,m.codigomateria
										FROM materia m
										WHERE  m.codigoestadomateria = '01'
											AND m.codigocarrera = '".$_SESSION['codigofacultad']."'
											$quitarmaterias
											AND m.codigomateria not in (	select codigomateria
															from solicitudaprobacionmodificacionnotas
															join (select max(id) id from solicitudaprobacionmodificacionnotas group by codigomateria) sub using(id)
															where idtiposolicitudaprobacionmodificacionnotas=30
																and codigoestadosolicitud in (10,11)
																and codigoestudiante=".$_REQUEST["codigoestudiante"].")
										ORDER BY 1";
										//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
								//echo "3 ".$query_cursos;
								$cursos = mysql_query($query_cursos,$sala) or die(mysql_error());
								$row_cursos = mysql_fetch_assoc($cursos);
								$totalRows_cursos = mysql_num_rows($cursos);
								do {
?>
									<option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigomateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
<?php
								} while ($row_cursos = mysql_fetch_assoc($cursos));
								$rows = mysql_num_rows($cursos);
								if($rows > 0) {
									mysql_data_seek($cursos, 0);
									$row_cursos = mysql_fetch_assoc($cursos);
								}
?>
							</select>
<?php
						} else { // else 1 ?>
							<select name="materia" id="materia" onChange="enviar()">
								<option value="0" <?php if (!(strcmp(0, $_GET['materia']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
								do {
?>
									<option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigoestudiantemateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
<?php
								} while ($row_cursos = mysql_fetch_assoc($cursos));
								$rows = mysql_num_rows($cursos);
								if($rows > 0) {
									mysql_data_seek($cursos, 0);
									$row_cursos = mysql_fetch_assoc($cursos);
								}
						} // else 1
?>
					</td>
					<td class="style51">
						<select name="tiponota" id="tiponota">
							<option value="0" <?php if (!(strcmp(0, $_GET['tiponota']))) {echo "SELECTED";} ?>>Tipo Nota</option>
<?php
							do {
?>
								<option value="<?php echo $row_tiponota['codigotiponotahistorico']?>"<?php if (!(strcmp($row_tiponota['codigotiponotahistorico'], $_GET['tiponota']))) {echo "SELECTED";} ?>><?php echo $row_tiponota['nombretiponotahistorico']?></option>
<?php
							} while ($row_tiponota = mysql_fetch_assoc($tiponota));

							$rows = mysql_num_rows($tiponota);
							if($rows > 0) {
								mysql_data_seek($tiponota, 0);
								$row_tiponota = mysql_fetch_assoc($tiponota);
							}
?>
						</select>
					</td>
					<td class="style51" bgcolor="#C5D5D6"><div align="center"><strong>Nota</strong></div></td>
					<td class="style51"><input name="notas" type="text" id="notas" value="<?php echo $_GET['notas'];?>" size="1" maxlength="3">&nbsp;</td>
				</tr>
				<tr>
<?php
					//if ($row_grupomateria <> "")
					//{ // if materia electiva
					if ($row_electiva <> "") {
						$banderaelectiva = 1;
?>
						<td colspan="5" class="style51" bgcolor="#C5D5D6"><div align="left"><strong><strong> Seleccione la electiva</strong>: </strong>
							<select name="materiaelectiva" id="materiaelectiva">
								<option value="0" <?php if (!(strcmp("0", $_GET['materiaelectiva']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
								do {
?>
									<option value="<?php echo $row_electiva['codigomateriadetallelineaenfasisplanestudio']?>"<?php if (!(strcmp($row_electiva['codigomateriadetallelineaenfasisplanestudio'], $_GET['materiaelectiva']))) {echo "SELECTED";} ?>><?php echo $row_electiva['codigomateriadetallelineaenfasisplanestudio']?>&nbsp;&nbsp;<?php echo $row_electiva['nombremateria']?></option>
<?php
								} while ($row_electiva = mysql_fetch_assoc($electiva));
								$rows = mysql_num_rows($electiva);
								if($rows > 0) {
									mysql_data_seek($electiva, 0);
									$row_car = mysql_fetch_assoc($electiva); 
								}
?>
							</select>
						</div></td>
<?php
					} else if ($row_grupomateria <> "") {
						$banderaelectiva = 1;
?>
						<td colspan="5" class="style51" bgcolor="#C5D5D6"><div align="left"><strong><strong> Seleccione la electiva</strong>: </strong>
							<select name="materiaelectiva" id="materiaelectiva">
								<option value="0" <?php if (!(strcmp("0", $_GET['materiaelectiva']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
								do {
?>
									<option value="<?php echo $row_grupomateria['codigomateria']?>"<?php if (!(strcmp($row_grupomateria ['codigomateria'], $_GET['materiaelectiva']))) {echo "SELECTED";} ?>><?php echo $row_grupomateria['codigomateria']?>&nbsp;&nbsp;<?php echo $row_grupomateria ['nombremateria']?></option>
<?php
								} while ($row_grupomateria  = mysql_fetch_assoc($grupomateria ));
								$rows = mysql_num_rows($grupomateria );
								if($rows > 0) {
									mysql_data_seek($grupomateria , 0);
									$row_grupomateria  = mysql_fetch_assoc($grupomateria );
								}
?>
							</select>
						</div></td>
<?php
					}
?>
				</tr>
				<tr>
					<td colspan="5" class="style51"><div align="center"><strong><strong>Observaci&oacute;n</strong>:
						<input name="observacion" type="text" value="<?php echo $_GET['observacion'];?>" size="50">
					</strong></div></td>
				</tr>
				<tr>
					<td colspan="5" class="style51"><div align="center"><strong>
<?php
						$codigomateria = $_GET['materia'];
						$query_corte = "SELECT distinct numerocorte
								FROM detallenota,materia,corte
								WHERE  materia.codigoestadomateria = '01'
									AND detallenota.codigomateria=materia.codigomateria
									AND detallenota.idcorte=corte.idcorte
									AND detallenota.codigoestudiante = '$codigoestudiante'
									AND detallenota.codigomateria = '".$_GET['materia']."'
                                    AND detallenota.codigoestado like '1%'
									AND corte.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
									union 
								select dp.idgrupo as numerocorte
								from prematricula p, detalleprematricula dp
								where p.idprematricula = dp.idprematricula
									and dp.codigomateria = '".$row_materias['codigomateria']."'
									and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')
									and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
									and p.codigoestudiante = '$codigoestudiante'";
						$corte = mysql_query($query_corte, $sala) or die(mysql_error());
						$row_corte = mysql_fetch_assoc($corte);
						$totalRows_corte = mysql_num_rows($corte);
						//echo "$query_corte <br>";
                        
						if ($row_corte <> "") {
?>
                    <input type="button" name="Submit" value="Guardar" onclick="alert('El estudiante tiene cortes con notas  para el periodo seleccionado, por lo tanto debe eliminar la materia de la matricula para poder insertar en el histórico o esperar hasta el cierre')">
<?php
						} else {
?>
							<input type="submit" name="Submit" value="Guardar">
<?php
						}
?>
						&nbsp;&nbsp;
						<input type="submit" name="Submit2" value="Regresar">
					</strong></div></td>
				</tr>
			</table>
			<br>
			<input name="periodo" type="hidden" id="periodo" value="<?php echo $periodo; ?>">
			<input name="codigoestudiante" type="hidden" id="codigoestudiante" value="<?php echo $codigoestudiante; ?>">
			<input name="nombre" type="hidden" id="nombre" value="<?php echo $nombre; ?>">
			<input type="hidden" name="tipomateria" value="<?php echo $tipomateria;?>">
			<input type="hidden" name="planestudiante" value="<?php echo $plan;?>">
<?php
			$banderagrabar= 0;
			if ($_GET['Submit']) {
				$query="select *
					from ipsvalidasmodificacionnotas
					where (ip='".$ip."') 
						and '".date("Y-m-d")."' between fechadesde and fechahasta and codigoestado=100";

				$regIP = mysql_query($query,$sala);
			
				$query=queryAprobadorMateria($_REQUEST['materia']);
				$regAprobador = mysql_query($query,$sala);
				if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_GET['notas'])) or ($_GET['notas'] > 5)) {
					echo '<script language="JavaScript">alert("Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
					$banderagrabar= 1;
				} else if($_GET['tiponota'] == 0) {
					echo '<script language="JavaScript">alert("Debe elegir el tipo de nota")</script>';
					$banderagrabar= 1;
				} else if($_GET['materia'] == 0) {
					echo '<script language="JavaScript">alert("Debe elegir la  materia")</script>';
					$banderagrabar= 1;
				} else if($_GET['materiaelectiva'] == 0 and $banderaelectiva == 1) {
					echo '<script language="JavaScript">alert("Debe elegir una Electiva")</script>';
					$banderagrabar= 1;
				} else if($_GET['observacion'] == "") {
					echo '<script language="JavaScript">alert("Debe digitar una observación de la modificación realizada")</script>';
					$banderagrabar= 1;
				} else if (mysql_num_rows($regIP)==0) {
					echo '<script language="JavaScript">alert("Esta dirección IP no es válida para realizar modificaciones: '.$ip.'. Por favor comuniquese con la mesa de ayuda")</script>';
					$banderagrabar = 1;
				} else if (mysql_num_rows($regAprobador)==0) {
					echo '<script language="JavaScript">alert("No se encontro aprobador de notas definido para la carrera asociada a esta matería. Por favor comuniquese con el área de registro y control")</script>';
					$banderagrabar = 1;
				} else if($banderagrabar == 0) {

					$rowAprobador = mysql_fetch_assoc($regAprobador);

					$query="select idusuario from usuario where usuario='".$_SESSION['MM_Username']."'";
					$regSolicitante = mysql_query($query,$sala) OR die(mysql_error());
					$rowSolicitante = mysql_fetch_assoc($regSolicitante);

					$query="select	 numerodocumento,apellidosestudiantegeneral,nombresestudiantegeneral from estudiante join estudiantegeneral using(idestudiantegeneral)
						where codigoestudiante='".$_SESSION["codigo"]."'";
					$regEstudiante = mysql_query($query,$sala) OR die(mysql_error());
					$rowEstudiante = mysql_fetch_assoc($regEstudiante);
					
					$fechahoy=date("Y-m-d H:i:s");
     
					$tipomat=($_REQUEST["tipomateria"])?$_REQUEST["tipomateria"]:'NULL';
                    if($tipomat == "" || $tipomat == 'NULL')
                    {
                        $sqltipomateria = "SELECT m.codigotipomateria FROM materia m where m.codigomateria= '".$_REQUEST['materia']."'";
                        $regTipomateria = mysql_query($sqltipomateria,$sala) OR die(mysql_error());
					    $rowTipomateria = mysql_fetch_assoc($regTipomateria);
                        $tipomat = $rowTipomateria['codigotipomateria'];
                    }
                   
                    if($_GET['materiaelectiva'] != ''){
						$materiaelectiva = $_REQUEST["materia"];
                        $materia = $_GET['materiaelectiva'];
                    }else
                    {
                        $materiaelectiva = 1;
                        $materia = $_REQUEST["materia"];
                    }
                    
                    //consulta si la materia tiene alguna nota existente en la tabla de detallenota. //ivan quintero
                    
                    $sqlexistente = "SELECT idnotahistorico FROM notahistorico WHERE codigoperiodo = '".$_REQUEST["periodo"]."' AND codigoestudiante ='".$_REQUEST["codigoestudiante"]."'
                     AND codigomateria = '".$materia."'"; // AND codigoestadonotahistorico = '100'
                   	$datosexiste = mysql_query($sqlexistente,$sala) OR die(mysql_error());
					$rowExiste = mysql_fetch_assoc($datosexiste);
                   
                    if($rowExiste['idnotahistorico'] <> "")
                    {
                        //ingreso de la materia a las solicitudes para aprobancion. //ivan quintero	
    					$query="insert into solicitudaprobacionmodificacionnotas
    							(codigotiponotahistorico
    							,codigoestudiante
    							,codigoperiodo
    							,codigomateria
    							,notamodificada
    							,idplanestudio
    							,observaciones
    							,codigotipomateria
    							,idsolicitante
    							,fechasolicitud
    							,ipsolicitante
    							,idaprobador
    							,insdelupd
    							,idtiposolicitudaprobacionmodificacionnotas
    							,codigoestadosolicitud,
    							CodigoMateriaElectiva)
    						values ( '".$_REQUEST["tiponota"]."'
    							,".$_REQUEST["codigoestudiante"]."
    							,'".$_REQUEST["periodo"]."'
    							,".$materia."
    							,".$_REQUEST["notas"]."
    							,".$_REQUEST["planestudiante"]."
    							,'".$_REQUEST["observacion"]."'
    							,".$tipomat."
    							,'".$rowSolicitante["idusuario"]."'
    							,'".$fechahoy."'
    							,'".$ip."'
    							,'".$rowAprobador["idaprobador"]."'
    							,'I'
    							,30
    							,10
    							,'".$materiaelectiva."')";
    					mysql_query($query,$sala);
                                           
    					$idSol=mysql_insert_id();
    
    					$tabla="<table border='1' align='center' bordercolor='#003333'>
    							<tr>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Usuario solicitante</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Fecha solicitud</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Carrera</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
    								<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Observaciones</strong></font></td>
    							</tr>
    							<tr>
    								<td align='center'><font face='Tahoma' size='2'>".$idSol."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$fechahoy."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante['numerodocumento']."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante["apellidosestudiantegeneral"]." ".$rowEstudiante["nombresestudiantegeneral"]."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$_SESSION["nombrefacultad"]."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$rowAprobador["nombremateria"]."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["notas"]."</font></td>
    								<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["observacion"]."</font></td>
    							</tr>
    						</table>";
    
    					require_once("../../funciones/phpmailer/class.phpmailer.php");
    					$mail = new PHPMailer();
    					$mail->From = "no-reply@unbosque.edu.co";
    					$mail->FromName = "Sistema SALA";
    					$mail->ContentType = "text/html";
    					$mail->Subject = "Tiene una nueva solicitud de ingreso de nota en el histórico de notas";
    					$mail->Body = "<b>La siguiente solicitud está pendientes de aprobación o rechazo:</b><br><br>".$tabla;
    					//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
    					//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
    					//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
    					//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
    					$mail->AddAddress($rowAprobador["emailaprobador"],$rowAprobador["nombreaprobador"]);
    					$mail->Send();
    					echo "	<script language='JavaScript'>
    							alert('El ingreso de esta nota queda pendiente de aprobación o rechazo');
    							location.href='modificahistoricoformulario.php?periodo=".$_REQUEST["periodo"]."&codigoestudiante=".$_REQUEST["codigoestudiante"]."';
    						</script>";
    
    					//require_once('modificahistoricooperacion.php');
                    }else
                    {
                       $query="insert into solicitudaprobacionmodificacionnotas
    							(codigotiponotahistorico
    							,codigoestudiante
    							,codigoperiodo
    							,codigomateria
    							,notamodificada
    							,idplanestudio
    							,observaciones
    							,codigotipomateria
    							,idsolicitante
    							,fechasolicitud
    							,ipsolicitante
    							,idaprobador
                                ,fechaaprobacion
    							,insdelupd
    							,idtiposolicitudaprobacionmodificacionnotas
    							,codigoestadosolicitud,
    							CodigoMateriaElectiva)
    						values ( '".$_REQUEST["tiponota"]."'
    							,".$_REQUEST["codigoestudiante"]."
    							,'".$_REQUEST["periodo"]."'
    							,".$materia."
    							,".$_REQUEST["notas"]."
    							,".$_REQUEST["planestudiante"]."
    							,'".$_REQUEST["observacion"]."'
    							,".$tipomat."
    							,'".$rowSolicitante["idusuario"]."'
    							,'".$fechahoy."'
    							,'".$ip."'
    							,'".$rowAprobador["idaprobador"]."'
                                ,'".$fechahoy."'
    							,'I'
    							,30
    							,11
    							,'".$materiaelectiva."')";
    					mysql_query($query,$sala);
                         //echo $query;
                         //echo '<br>';
                                           
    					$idSol=mysql_insert_id();
                        $grupo = 1;
                        $estadonotahistorico = 100;
                        $fecha = date("Y-m-j G:i:s",time());
                        
                        $query_Recordset ="select idlineaenfasisplanestudio from detallelineaenfasisplanestudio where codigomateriadetallelineaenfasisplanestudio = '".$codigomateria."'
                         and idplanestudio = '".$planestudio."' and codigoestadodetallelineaenfasisplanestudio LIKE '1%'";

                        //echo $query_Recordset,"</br>";
                        $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
                        $row_Recordset = mysql_fetch_assoc($Recordset);
                        $totalRows_Recordset = mysql_num_rows($Recordset);
                        
                        if ($row_Recordset <> "")
                        {
                            $idlinea = $row_Recordset['idlineaenfasisplanestudio'];
                        }
                        else
                        {
                            $idlinea = 1;
                        }                           
                        $sqlnotainsert = "insert into notahistorico (idnotahistorico,codigoperiodo,codigomateria,codigomateriaelectiva,codigoestudiante,
                        notadefinitiva,codigotiponotahistorico,origennotahistorico,fechaprocesonotahistorico,idgrupo,idplanestudio,
                        idlineaenfasisplanestudio,observacionnotahistorico,codigoestadonotahistorico,codigotipomateria)
                        VALUES('0','".$_REQUEST["periodo"]."','".$materia."','".$materiaelectiva."','".$_REQUEST["codigoestudiante"]."',
                        '".$_REQUEST["notas"]."','".$_REQUEST["tiponota"]."','10','".$fecha."','".$grupo."','".$_REQUEST["planestudiante"]."',
                        '".$idlinea."','".$_REQUEST["observacion"]."','".$estadonotahistorico."','".$tipomat."')";
                        mysql_query($sqlnotainsert,$sala);
                        
                        //echo $sqlnotainsert;
                        
                    	echo "	<script language='JavaScript'>
                            alert('Nueva nota ingresada aprobada.');
                        	location.href='modificahistoricoformulario.php?periodo=".$_REQUEST["periodo"]."&codigoestudiante=".$_REQUEST["codigoestudiante"]."';
	                    </script>";
                    } 
					exit();
                    
				}
			}// fin if de boton
			if ($_REQUEST['accion'] == "cancelar") {
				$query = "update solicitudaprobacionmodificacionnotas set codigoestadosolicitud='21' where id=".$_REQUEST["IdSolicitud"];
				mysql_query($query,$sala);
				$query=queryAprobadorSolicitud($_REQUEST["IdSolicitud"]);
				$reg = mysql_query($query,$sala);
				$row = mysql_fetch_assoc($reg);
				$tabla="<table border='1' align='center' bordercolor='#003333'>
						<tr>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Usuario solicitante</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Fecha solicitud</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Carrera</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
							<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Observaciones</strong></font></td>
						</tr>
						<tr>
							<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["IdSolicitud"]."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row['fechasolicitud']."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row['numerodocumento']."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row["apellidosestudiantegeneral"]." ".$row["nombresestudiantegeneral"]."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row['nombrecarrera']."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row["nombremateria"]."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row["notamodificada"]."</font></td>
							<td align='center'><font face='Tahoma' size='2'>".$row["observaciones"]."</font></td>
						</tr>
					</table>";
				require_once("../../funciones/phpmailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->From = "no-reply@unbosque.edu.co";
				$mail->FromName = "Sistema SALA";
				$mail->ContentType = "text/html";
				$mail->Subject = "Solicitud de ingreso de nota en el histórico de nota cancelada";
				$mail->Body = "<b>La siguiente solicitud ha sido cancelada por el usuario que la creó:</b><br><br>".$tabla;
				//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
				//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
				//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
				//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
				$mail->AddAddress($row["emailaprobador"],$row["nombreaprobador"]);
				$mail->Send();
				echo "	<script language='JavaScript'>
						location.href='modificahistoricoformulario.php?periodo=".$_REQUEST["periodo"]."&codigoestudiante=".$_REQUEST["codigoestudiante"]."';
					</script>";
			}
?>
		</form>
	</body>
</html>
<?php
mysql_free_result($cursos);
mysql_free_result($tiponota);
?>
