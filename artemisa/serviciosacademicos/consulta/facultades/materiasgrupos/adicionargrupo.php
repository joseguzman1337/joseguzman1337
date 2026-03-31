<?php
/*
 * @modified Ivan quintero <quinteroivan@unbosque.edu.co>
 * formateo del texto, adicion de realpath
 *
 * @since  November 22, 2016
*/

require("../../../../sala/entidad/LogGrupo.php");
require("../../../../sala/entidadDAO/LogGrupoDAO.php");
/* END */
require(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	require_once('../../../Connections/sala2.php'); 
	require_once('../../../funciones/validacion.php');
	require_once('../../../funciones/errores_horario.php'); 
	require_once('../../../funciones/calendario/calendario.php'); 
	mysql_select_db($database_sala, $sala);
	//session_start();
	$codigocarrera = $_SESSION['codigofacultad'];
	$codigomateria = $_GET['codigomateria1'];
	$carrera = $_GET['carrera1'];
	$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
	if(isset($_GET['nuevogrupo1']))
	{
		$idgrupo=$_GET['idgrupo1'];
	}
	if(isset($_POST['nuevogrupo1']))
	{
		$idgrupo=$_POST['idgrupo1'];
	}
	$codigocarrera = $_SESSION['codigofacultad'];
	/********* COMBO ESTADO HORARIO **************/
	$query_estadohorario = "SELECT * FROM indicadorhorario";
	$estadohorario = mysql_query($query_estadohorario, $sala) or die("$query_estadohorario");
	$row_estadohorario = mysql_fetch_assoc($estadohorario);
	$totalRows_estadohorario = mysql_num_rows($estadohorario);
	$formulariovalido = 1;
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Adicionar grupo</title>
		<script language="javascript">
			function recargar(dir)
			{
				window.location.reload("adicionargrupo.php"+dir);
			}
		</script>
		<script language="JavaScript" src="../../../funciones/calendario/javascripts.js">
		</script>
		<style type="text/css">
			<!--
			.Estilo1 {
				font-family: Tahoma;
				font-size: x-small;
			}
			.Estilo2 {
				font-size: xx-small;
				font-weight: bold;
			}
			-->
		</style>
	</head>
	<body>
		<div align="center">
			<style type="text/css">
				<!--
				.Estilo3 {
					color: #FF0000;
					font-size: 8pt;
				}
				-->
			</style>
		</div>
		<form action="adicionargrupo.php<?php echo $dirini; ?>" method="post" name="f1">
			<div align="center"></div>
			<p align="center" class="Estilo1"><strong>ADICIONAR NUEVO GRUPO </strong></p>
			<div align="center" class="Estilo1">
				<input type="hidden" name="nuevogrupo1" value="<?php echo $idgrupo; ?>">
				<table width="450" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
					<tr bgcolor="#C5D5D6">
						<td align="center"><span class="Estilo2">Tamaño Máximo Grupo</span></td>
						<td align="center"><span class="Estilo2">Tamaño Máximo Electiva</span></td>
						<td align="center"><span class="Estilo2">Nombre  Grupo </span></td>
						<td align="center"><span class="Estilo2">Estado Horario</span></td>
						<td align="center"><span class="Estilo2">Inicico Grupo</span></td>
						<td align="center"><span class="Estilo2">Vencimiento Grupo</span></td>
					</tr>
					<tr>
						<td align="center">
							<input type="text" name="maximogrupo1" size="3" value="<?php if(isset($_POST['maximogrupo1'])) echo $_POST['maximogrupo1']; else echo $maximogrupo;?>">
							<?php
							echo "<span class='Estilo3'>";
							if(isset($_POST['maximogrupo1']))
							{
								$maximogrupo = $_POST['maximogrupo1'];
								$imprimir = true;
								$mgrrequerido = validar($maximogrupo,"requerido",$error1,$imprimir);
								$mgrnumero = validar($maximogrupo,"numero",$error2,$imprimir);
								$formulariovalido = $formulariovalido*$mgrrequerido*$mgrnumero;
							}
							echo "</span>";
							?></td>
						<td align="center">
							<input name="maximogrupoelectiva1" type="text" size="3" value="<?php if(isset($_POST['maximogrupoelectiva1'])) echo $_POST['maximogrupoelectiva1']; else echo $maximogrupoelectiva;?>">
							<span class="Estilo1"><font color="#FF0000" size="-2">
								<?php
								if(isset($_POST['maximogrupoelectiva1']))
								{
									$validargrupoelec = $_POST['maximogrupoelectiva1'];
									$imprimir = true;
									$gruponumero = validar($validargrupoelec,"numero",$error3,$imprimir);
									$gruporequerido = validar($validargrupoelec,"requerido",$error1,$imprimir);
									$formulariovalido = $formulariovalido*$gruporequerido*$gruponumero;
								}
								?>
							</font></span>
						</td>
						<td align="center">
						<input type="text" name="nombregrupo1" value="<?php if(isset($_POST['nombregrupo1'])) echo $_POST['nombregrupo1']; else echo $nombregrupo;?>">
							<?php
							echo "<span class='Estilo3'>";
							if(isset($_POST['nombregrupo1']))
							{
								$nombregrupo = $_POST['nombregrupo1'];
								$ngrexiste = 1;
								$imprimir = true;
								$ngrrequerido = validar($nombregrupo,"requerido",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$ngrrequerido*$ngrexiste;
							}
							echo "</span>";
							?>
						</td>
						<td>
							<font size="1" face="Tahoma">
								<select name="codigoindicadorhorario1">
									<option value="0" <?php if (!(strcmp(0, $_POST['codigoindicadorhorario1']))) {echo "SELECTED";} ?>>Seleccionar</option>
									<?php
									do
									{    
										?>
										<option value="<?php echo $row_estadohorario['codigoindicadorhorario']?>"<?php if (!(strcmp($row_estadohorario['codigoindicadorhorario'], $_POST['codigoindicadorhorario1']))) {echo "SELECTED";} ?>><?php echo $row_estadohorario['nombreindicadorhorario']?></option>
										<?php
									}
									while($row_estadohorario = mysql_fetch_assoc($estadohorario));
									$totalRows_estadohorario = mysql_num_rows($estadohorario);
									if($totalRows_estadohorario > 0)
									{
										mysql_data_seek($estadohorario, 0);
										$row_estadohorario = mysql_fetch_assoc($estadohorario);
									}
									?>
								</select>
								<font color="#FF0000">
									<?php
									if(isset($_POST['codigoindicadorhorario1']))
									{
										$codigoindicadorhorario = $_POST['codigoindicadorhorario1'];
										$imprimir = true;
										$codigoindicadorhorariorequerido = validar($codigoindicadorhorario,"combo",$error1,$imprimir);
										$formulariovalido = $formulariovalido*$codigoindicadorhorariorequerido;
									}
									?>
								</font>
							</font>
						</td>
						<td align="center">
							<?php escribe_formulario_fecha_vacio("fechaini","f1","../../../funciones/",$_POST['fechaini']);
							if(isset($_POST['fechaini']))
							{
								$fechaini = $_POST['fechaini'];
								$imprimir = true;
								$fecharequerido = validar($fechaini,"requerido",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$fecharequerido;
							}
							?>								
						</td>
						<td align="center">
							<?php escribe_formulario_fecha_vacio("fechafin","f1","../../../funciones/",$_POST['fechafin']);
							if(isset($_POST['fechafin']))
							{
								$fechafin = $_POST['fechafin'];
								$imprimir = true;
								$fecharequerido = validar($fechafin,"requerido",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$fecharequerido;
							}
							?>
						</td>
					</tr>
					<tr>
						<td colspan="6" align="center">
							<input type="submit" name="Aceptar" value="Aceptar">
							<input type="button" value="Cancelar" onClick="window.close()"></td>
					</tr>
				</table>
			</div>
		</form>
		<div align="center">
			<?php 
			if(isset($_POST['Aceptar']))
			{
				if($formulariovalido)
				{
					$maximogrupo = $_POST['maximogrupo1'];
					$maximogrupoelectiva = $_POST['maximogrupoelectiva1'];
					$nombregrupo = $_POST['nombregrupo1'];
					$codigoindicadorhorario = $_POST['codigoindicadorhorario1'];
					$fechafin = $_POST['fechafin'];
					$fechaini = $_POST['fechaini'];
					$codigoperiodo=$_SESSION['codigoperiodosesion'];
					$query_maxgrupo = "select max(g.codigogrupo*1) as maximogrupo from grupo g where g.codigomateria = '$codigomateria' and g.codigogrupo not like '00%'";
					$maxgrupo = mysql_query($query_maxgrupo, $sala) or die("$query_maxgrupo");
					$row_maxgrupo = mysql_fetch_assoc($maxgrupo);
					$totalRows_maxgrupo = mysql_num_rows($maxgrupo);
					$nuevogrupo = $row_maxgrupo['maximogrupo'] + 1;
					$query_mat = "SELECT * FROM materia mat WHERE mat.codigomateria = '$codigomateria'";
					$mat = mysql_query($query_mat, $sala) or die("$query_mat");
					$row_mat = mysql_fetch_assoc($mat);
					$totalRows_mat = mysql_num_rows($mat);
					$numerohorassemanales=$row_mat['numerohorassemanales'];
					$numerodocumento = 1;
					$matriculadosgrupo = 0;
					$matriculadosgrupoelectiva = 0;
					$numerodiasconservagrupo = "999";
					$query_addgrupo = "INSERT INTO grupo(idgrupo, codigogrupo, nombregrupo, codigomateria, codigoperiodo, numerodocumento, maximogrupo, matriculadosgrupo, maximogrupoelectiva, matriculadosgrupoelectiva, codigoestadogrupo, codigoindicadorhorario, fechainiciogrupo, fechafinalgrupo, numerodiasconservagrupo) 	VALUES('$idgrupo','$nuevogrupo','$nombregrupo','$codigomateria','$codigoperiodo','$numerodocumento','$maximogrupo','$matriculadosgrupo','$maximogrupoelectiva','$matriculadosgrupoelectiva',10,'$codigoindicadorhorario','$fechaini', '$fechafin', '$numerodiasconservagrupo')";
					//echo $query_addgrupo;
					//exit();
					$addgrupo = mysql_query($query_addgrupo, $sala) or die("$query_addgrupo");
					$idGrupoInsertado = mysql_insert_id();

					#Instancia de objecto de LOgGrupo para insercion del log
					$logGroupObject = new LogGrupo($idGrupoInsertado);
					$logGroupDAO = new \Sala\entidadDAO\LogGrupoDAO($logGroupObject);
					$logGroupDAO->save();

                    echo "<script language='javascript'>
					window.opener.recargar('".$dirini."#".$nuevogrupo."');
					window.opener.focus();
					window.close();
					</script>";
				}
			}
			?>
		</div>	
	</body>
</html>