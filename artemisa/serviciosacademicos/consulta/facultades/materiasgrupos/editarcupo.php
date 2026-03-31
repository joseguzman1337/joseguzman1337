<?php 
/*
 * @modified Ivan quintero <quinteroivan@unbosque.edu.co>
 * formateo del texto, adicion de realpath
 *
 * @since  November 22, 2016
*/

/* END */
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	require_once('../../../Connections/sala2.php');
	require_once('../../../funciones/validacion.php');
	require_once('../../../funciones/errores_horario.php'); 
	require_once('../../../funciones/calendario/calendario.php');
    require("../../../../sala/entidad/LogGrupo.php");
    require("../../../../sala/entidadDAO/LogGrupoDAO.php");
	mysql_select_db($database_sala, $sala);
	//session_start();
	require_once('seguridadmateriasgrupos.php');
	$codigocarrera = $_SESSION['codigofacultad'];
	$codigomateria = $_GET['codigomateria1'];
	$carrera = $_GET['carrera1'];
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

	$Usario_id = mysql_query($SQL_User, $sala) or die("$SQL_User");
	$Usario_idD = mysql_fetch_assoc($Usario_id);

	$userid=$Usario_idD['id'];

	$Padre = $_REQUEST['padre'];
	$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
	if(isset($_GET['grupo1']))
	{
		$idgrupo=$_GET['idgrupo1'];
		$grupo=$_GET['grupo1'];
		$maximogrupo=$_GET['maximogrupo1'];
		$nombregrupo=$_GET['nombregrupo1'];
		$nombreindicadorhorario=$_GET['nombreindicadorhorario1'];
		$codigoindicadorhorario=$_GET['codigoindicadorhorario1'];
		$maximogrupoelectiva = $_GET['maximogrupoelectiva1'];
		$fechaini=$_GET['fechaini'];
		$fechafin = $_GET['fechafin'];

		//echo "asas".$nombreindicadorhorario;
	}
	if(isset($_POST['grupo1']))
	{
		$idgrupo=$_POST['idgrupo1'];
		$grupo=$_POST['grupo1'];
		$maximogrupo=$_POST['maximogrupo1'];
		$nombregrupo=$_POST['nombregrupo1'];
		$nombreindicadorhorario=$_POST['nombreindicadorhorario1'];
		$codigoindicadorhorario=$_POST['codigoindicadorhorario1'];
		$maximogrupoelectiva = $_POST['maximogrupoelectiva1'];
		$fechaini=$_POST['fechaini'];
		$fechafin = $_POST['fechafin'];
	}
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
		<title>Editar cupo</title>
		<style type="text/css">
		<!--
		.Estilo1 {font-family: Tahoma; font-size: 12px}
		.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
		.Estilo3 {font-family: Tahoma; font-size: 14px; }
		-->
		</style>
	</head>
	<script language="JavaScript" src="../../../funciones/calendario/javascripts.js">
	</script>
	<script language="javascript">
		function contador(accion)
		{
			var cont;
			cont = document.f1.maximogrupo1.value;
			if(accion == 1)
				cont++;
			if(accion == 2)
			{
				if(cont == 0)
				{
					return;
				}
				cont--;
			}
			document.f1.maximogrupo1.value = cont;
		}//function contador
		function contador2(accion)
		{
			var cont;
			cont = document.f1.maximogrupoelectiva1.value;
			if(accion == 1)
				cont++;
			if(accion == 2)
			{
				if(cont == 0)
				{
					return;
				}
				cont--;
			}
			document.f1.maximogrupoelectiva1.value = cont;
		}//function contador2
		function ValidarAcceso(id){ 

			if(id){
				var text = 'Seguro desea Modificar...? \n Tenga encuenta que los cambios afectaran las \n Solicitudes de Espacios Fisicos y \n La Asignacion de Salones...';
			}else{
				var text = 'Seguro desea Modificar...?';
			}

			if(confirm(text)){
				return true;
			}else{
				return false;
			}
		}//function ValidarAcceso
	</script>
	<body>
		<form action="editarcupo.php<?php echo "$dirini";?>" method="post" name="f1" >
		<input type="hidden" value="<?php echo $grupo ?>" name="grupo1">
		<input type="hidden" value="<?php echo $idgrupo ?>" name="idgrupo1">
		<input type="hidden" value="<?php echo $nombreindicadorhorario ?>" name="nombreindicadorhorario1">
		<input type="hidden" value="<?php echo $codigoindicadorhorario ?>" name="codigoindicadorhorario1">
		<input type="hidden" value="<?PHP echo $Padre?>" name="padre" />
		<table width="450" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
			<tr bgcolor="#C5D5D6">
				<td align="center"><span class="Estilo2">Tamaño Máximo Grupo</span></td>
				<td align="center"><span class="Estilo2">Tamaño Máximo Electiva</span></td>
				<td align="center"><span class="Estilo2">Nombre  Grupo </span></td>
				<td align="center"><span class="Estilo2">Estado Horario</span></td>
				<td align="center"><span class="Estilo2">Inicio Grupo</span></td>
				<td align="center"><span class="Estilo2">Vencimiento Grupo</span></td>
			</tr>
			<tr class="Estilo1">
				<td align="center">
				<table align="center">
				<tr>
				<td align="center" rowspan="2">
				<input name="maximogrupo1" maxlength="3" type="text" size="3" value="<?php if(isset($_POST['maximogrupo1'])) echo $_POST['maximogrupo1']; else echo $maximogrupo;?>" style="width: 25px ">
				</td>
				</tr>
				<tr>
				<td align="center"><input type="button" value="+" onClick="contador(1)" style="width: 20px" name="b1"><br>
				<input type="button" value="-" onClick="contador(2)" style="width: 20px" name="b2"></td>
				</tr>
				</table>
				<span class="Estilo1"><font color="#FF0000" size="-2">
					<?php
					if(isset($_POST['maximogrupo1']))
					{
						$validargrupo = $_POST['maximogrupo1'];
						$imprimir = true;
						$gruponumero = validar($validargrupo,"numero",$error3,$imprimir);
						$gruporequerido = validar($validargrupo,"requerido",$error1,$imprimir);
						$formulariovalido = $formulariovalido*$gruporequerido*$gruponumero;
						if($validargrupo == 0)
						{
							$formulariovalido = 0;
							echo "Debe digitar un grupo diferente de cero";
						}
					}
					?>
					</font></span></td>
				<td align="center">
					<table align="center">
						<tr>
							<td align="center" rowspan="2">
								<input name="maximogrupoelectiva1" maxlength="3" type="text" size="3" value="<?php if(isset($_POST['maximogrupoelectiva1'])) echo $_POST['maximogrupoelectiva1']; else echo $maximogrupoelectiva;?>" style="width: 25px ">
							</td>
						</tr>
						<tr>
							<td align="center"><input type="button" value="+" onClick="contador2(1)" style="width: 20px" name="b3"><br>
								<input type="button" value="-" onClick="contador2(2)" style="width: 20px" name="b4"></td>
						</tr>
					</table>
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
				<td align="center"><input type="text" name="nombregrupo1" value="<?php if(isset($_POST['nombregrupo1'])) echo $_POST['nombregrupo1']; else echo $nombregrupo;?>">
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
				<td><font size="1" face="Tahoma">
					<span class="Estilo1">
						<?php
						if($_GET['matriculados']>0) 
							$deshabilitarcodigoindicadorhorario="disabled";
						else
							$deshabilitarcodigoindicadorhorario="";
						?>
						<select name="codigoindicadorhorario1" <?php echo $deshabilitarcodigoindicadorhorario ?>>
							<option value="<?php echo $codigoindicadorhorario?>" SELECTED><?php echo $nombreindicadorhorario ?></option>
							<?php
							do
							{
								if($codigoindicadorhorario != $row_estadohorario['codigoindicadorhorario'])
								{    
								?>
								<option value="<?php echo $row_estadohorario['codigoindicadorhorario']?>"<?php if (!(strcmp($row_estadohorario['codigoindicadorhorario'], $_POST['codigoindicadorhorario1']))) {echo "SELECTED";}?>><?php echo $row_estadohorario['nombreindicadorhorario']?></option>
								<?php
								}
							}
							while ($row_estadohorario = mysql_fetch_assoc($estadohorario));
								$totalRows_estadohorario = mysql_num_rows($estadohorario);
								if($totalRows_estadohorario > 0)
								{
									mysql_data_seek($estadohorario, 0);
									$row_estadohorario = mysql_fetch_assoc($estadohorario);
								}
								?>
						</select>
					</span>
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
					</font></font></td>
				<td align="center"><?php
					if(isset($_POST['fechaini']))
					{ 
						$fechaini = $_POST['fechaini'];
					}
					escribe_formulario_fecha_vacio("fechaini","f1","../../../funciones/",$fechaini);
					if(isset($_POST['fechaini']))
					{
						$fechaini = $_POST['fechaini'];
						$imprimir = true;
						$fecharequerido = validar($fechaini,"requerido",$error1,$imprimir);
						$formulariovalido = $formulariovalido*$fecharequerido;
					}
					?>
				</td>
				<td align="center"><?php 
				if(isset($_POST['fechafin']))
				{ 
					$fechafin = $_POST['fechafin'];
				}
					escribe_formulario_fecha_vacio("fechafin","f1","../../../funciones/",$fechafin);
					if(isset($_POST['fechafin']))
					{
						$fechafin = $_POST['fechafin'];
						$imprimir = true;
						$fecharequerido = validar($fechafin,"requerido",$error1,$imprimir);
						$formulariovalido = $formulariovalido*$fecharequerido;
					}
					?></td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<input type="submit" name="Aceptar" value="Aceptar" onclick="return ValidarAcceso('<?PHP echo $Padre;?>');" >
					<input type="button" value="Cancelar" onClick="window.close()"></td>
			</tr>
			</table>
		</form>
	</body>
</html>
<?php
if(isset($_POST['Aceptar']))
{ 
	if($formulariovalido)
	{
		$query_updmaximogrupo = "UPDATE grupo SET maximogrupo = '$maximogrupo', nombregrupo = '$nombregrupo', codigoindicadorhorario = '$codigoindicadorhorario', maximogrupoelectiva = '$maximogrupoelectiva', fechainiciogrupo = '$fechaini', fechafinalgrupo = '$fechafin' WHERE idgrupo = '$idgrupo'";
		//echo "<br>UPDATE MAXIMO GRUPO:".$query_updmaximogrupo;
        #Instancia de objecto de LOgGrupo para insercion del log
        $logGroupObject = new LogGrupo($idgrupo);
        $logGroupDAO = new \Sala\entidadDAO\LogGrupoDAO($logGroupObject);
        $logGroupDAO->save();


        $updmaximogrupo = mysql_query($query_updmaximogrupo, $sala) or die("$query_updmaximogrupo");
		//Toca inactivar cualquier horario que haya quedado pendiente 
		if($codigoindicadorhorario==200){
			$query_updmaximogrupo = "UPDATE horario  
			SET codigoestado = 200 
			WHERE idgrupo = '$idgrupo'";
			//echo "<br>UPDATE MAXIMO GRUPO:".$query_updmaximogrupo;
			$upd = mysql_query($query_updmaximogrupo, $sala) or die("$query_updmaximogrupo");
		} else {
			$query_updmaximogrupo = "UPDATE horario  
			SET codigoestado = 100 
			WHERE idgrupo = '$idgrupo'";
			//echo "<br>UPDATE MAXIMO GRUPO:".$query_updmaximogrupo;
			$upd = mysql_query($query_updmaximogrupo, $sala) or die("$query_updmaximogrupo");
		}       
		include_once('../../../EspacioFisico/Interfas/FuncionesSolicitudEspacios_Class.php');   $C_FuncionesSolicitudEspacios = new FuncionesSolicitudEspacios();
           
		if($Padre){
			///Validar si cambian las fechas
		   $Validacion = $C_FuncionesSolicitudEspacios->ValidarFechasCambio($fechaini,$fechafin,$Padre,'../../../EspacioFisico/');
		   if($Validacion){
				$C_FuncionesSolicitudEspacios->EditFechas($userid,$Padre,$codigoindicadorhorario,$fechaini,$fechafin,'../../../EspacioFisico/');
		   }
		}    
		//exit();			
		echo "<script language='javascript'>
				window.opener.recargar('".$dirini."#".$grupo."');
				window.opener.focus();
				window.close();
			  </script>";
	}
} 
?>
