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
	require_once("funcioneshora.php");
	mysql_select_db($database_sala, $sala); 
	//session_start();
	require_once('seguridadmateriasgrupos.php');

	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

	$Usario_id = mysql_query($SQL_User, $sala) or die("$SQL_User");
	$Usario_idD = mysql_fetch_assoc($Usario_id);

	$userid=$Usario_idD['id'];

	$formulariovalido=1;
	$codigocarrera = $_SESSION['codigofacultad'];
	$codigomateria = $_GET['codigomateria1'];
	$carrera = $_GET['carrera1'];
	$Padre = $_REQUEST['Padre'];
	$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera&Padre=$Padre";

	if(isset($_GET['grupo1']))
	{
		$grupo=$_GET['grupo1'];
		$idgrupo=$_GET['idgrupo1'];
		$numerohorassemanales=$_GET['numerohorassemanales1'];
	}
	if(isset($_POST['grupo1']))
	{
		$grupo=$_POST['grupo1'];
		$idgrupo=$_POST['idgrupo1'];
		$numerohorassemanales=$_POST['numerohorassemanales1'];
	}
	if(isset($_POST['cancelar']))
	{
		echo "<script language='javascript'>
				window.opener.recargar('".$dirini."#".$grupo."');
				window.opener.focus();
				window.close();
		  </script>";
	}
	/********* COMBO DIA **************/
	$query_dia = "SELECT * FROM dia";
	$dia = mysql_query($query_dia, $sala) or die("query_dia");
	$row_dia = mysql_fetch_assoc($dia);
	$totalRows_dia = mysql_num_rows($dia);
	/********* COMBO TIPO SALON **************/
	$query_tiposalon = "SELECT * FROM tiposalon";
	$tiposalon = mysql_query($query_tiposalon, $sala) or die("query_tiposalon");
	$row_tiposalon = mysql_fetch_assoc($tiposalon);
	$totalRows_tiposalon = mysql_num_rows($tiposalon);

	$query_group = "SELECT fechainiciogrupo,fechafinalgrupo FROM grupo where idgrupo = $idgrupo";
	$group = mysql_query($query_group, $sala) or die("query_group");
	$row_group = mysql_fetch_assoc($group);
	$totalRows_group = mysql_num_rows($group);

	$fechaini = $row_group['fechainiciogrupo'];
	$fechafin = $row_group['fechafinalgrupo'];
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Editar Horario</title>
		<style type="text/css">
			<!--
			.Estilo1 {font-family: Tahoma; font-size: 12px}
			.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
			.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
			-->
			/*@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);*/
		</style>
		<link rel="stylesheet" type="text/css" href="../../../funciones/calendario_nuevo/calendar-win2k-1.css">
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
		<script type="text/javascript">
			function ValidarAcceso(id)
			{
				if(id){
					var text = 'Seguro desea Modificar...? \n Tenga encuenta que los cambios afectaran las \n Solicitudes de Espacios Fisicos y \n La Asignacion de Salones...';
				}else{
					var text = 'Seguro desea Modificar...?';
				}
				
				if(confirm(text))
				{
					return true;
				}else{
					return false;
				}
			}//function ValidarAcceso
		</script>
	</head>
	<body>
		<p align="center" class="Estilo3">EDITAR HORARIO</p>
		<div align="center">
			<form name="f1" action="editarhorario.php<?php echo $dirini;?>" method="post">
				<font size="2" face="Tahoma">
					<input type="hidden" name="grupo1" value="<?php echo $grupo ?>">
					<input type="hidden" name="idgrupo1" value="<?php echo $idgrupo ?>">
					<input type="hidden" name="numerohorassemanales1" value="<?php echo $numerohorassemanales ?>">
					<input type="hidden" value="<?PHP echo $Padre?>" name="Padre" />
				</font> 
				<table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
					<tr>
						<td width="150" align="center" bgcolor="#C5D5D6"><span class="Estilo2">Horas Semanales</span></td>
						<td align="center"><span class="Estilo1">
							<?php 
							if($numerohorassemanales < 10) 
								$horassemanales = "0".$numerohorassemanales.":00";
						   else
							   $horassemanales = $numerohorassemanales.":00";
						   echo $horassemanales;
							?>
							</span>
						</td>
						<td width="100" align="center" bgcolor="#C5D5D6"><span class="Estilo2">Asignadas</span><span class="Estilo1"> </span></td>
						<td align="center"><span class="Estilo1">
							<?php 
							$query_asignadas = "SELECT h.horainicial, h.horafinal FROM grupo g, horario h WHERE g.idgrupo = h.idgrupo AND g.idgrupo = '$idgrupo'";
							//echo $query_asignadas;
							$asignadas = mysql_query($query_asignadas, $sala) or die(mysql_error());
							$totalRows_asignadas = mysql_num_rows($asignadas);
							$tienehorario = false;
							$cuentahoras = 0;
							while($row_asignadas = mysql_fetch_assoc($asignadas))
							{
								$horainicial=ereg_replace(":00$","",$row_asignadas['horainicial']);
								$horafinal=ereg_replace(":00$","",$row_asignadas['horafinal']);
								$horas[] = restarhoras($horafinal, $horainicial);
								$tienehorario = true;
								$cuentahoras++;
							}
							$horasasignadas = "00:00";
							if($cuentahoras != 0)
							{
								$contador = 0;
								while($contador <= $cuentahoras)
								{
									$horasasignadas =  sumarhoras($horasasignadas,$horas[$contador]);
									$contador++;
								}
							}
							echo $horasasignadas;
							?>
  	    					</span>  	    						
						</td>
						<td width="100" align="center" bgcolor="#C5D5D6"><span class="Estilo2">Faltantes</span><span class="Estilo1">          </span></td>
						<td align="center"><span class="Estilo1">
							<?php 
							$horasfaltantes = restarhoras($horassemanales,$horasasignadas);
							//echo $horasfaltantes;
							if($horasfaltantes == "Función mal usada")
							{
								echo "Sobrepaso las Horas Semanales";
							}
							else
							{
								echo $horasfaltantes;
							}
							?>
							</span>								
						</td>
					</tr>
				</table>
				<table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
					<?php
					if($tienehorario)
					{
					?>
					<tr bgcolor="#C5D5D6" class="Estilo2">
						<td align="center">Día</td>
						<td align="center" bgcolor="#C5D5D6">Hora Inicial</td>
						<td align="center">Hora Final</td>
						<td align="center">Tipo Salón</td>
						<td align="center">Fecha Inicial</td>
						<td align="center">Fecha Final</td>
						<td align="center">
							<?php if(!isset($_POST['adicionarhorario'])) echo "Edición"; else echo "Adición";?>
						</td>
					</tr>
					<?php
					 $query_horarios = "SELECT h.codigodia, h.codigodia, h.horainicial, h.horafinal, d.nombredia, se.nombresede, s.nombresalon, s.codigosalon, t.nombretiposalon, t.codigotiposalon, h.idhorario,fechadesdehorariodetallefecha,fechahastahorariodetallefecha ,idhorariodetallefecha,hd.idhorario FROM horario h, dia d, salon s, tiposalon t, sede se,horariodetallefecha hd WHERE h.codigodia = d.codigodia AND h.codigosalon = s.codigosalon AND h.codigotiposalon = t.codigotiposalon AND s.codigosede = se.codigosede AND h.idgrupo = '$idgrupo' and hd.idhorario = h.idhorario and h.codigoestado like '1%' and hd.codigoestado like '1%' order by 1,2,3,4";
					 //echo $query_horarios;
					 $horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
					 $totalRows_horarios = mysql_num_rows($horarios);		
					 $numerohorario = 1;
					 if(isset($_POST['editarhorario']) || isset($_POST['aceptaredicion']))
					 {
						 $idhorario = $_POST['numerohorario1'];
						 $editar = true;
					 }
					 else
					 {
						 $idhorario = 0;
					 }
					 while($row_horarios = mysql_fetch_assoc($horarios))
					 {
						$codigodia=$row_horarios['codigodia'];
						$nombredia=$row_horarios['nombredia'];
						$codigosalon=$row_horarios['codigosalon'];
						$horainicial=ereg_replace(":00$","",$row_horarios['horainicial']);
						$horafinal=ereg_replace(":00$","",$row_horarios['horafinal']);
						$codigotiposalon=$row_horarios['codigotiposalon'];
						$nombretiposalon=$row_horarios['nombretiposalon'];
						$idhorarioreal = $row_horarios['idhorario'];
						if($idhorario != $numerohorario)
						{
						?>
						<tr class="Estilo1" align="center">
							<td>
								<?php echo "$nombredia";?>
								<!-- <a onClick="//echo "window.open('horariodetallefecha.php?idhorario=".$idhorarioreal."','miventana2','width=400,height=400,left=100,top=200,scrollbars=yes')";
								?>" style="border-bottom:1px solid blue; cursor:pointer; font-weight: bold; color:#000099"> //echo "$nombredia";?></a> -->
							</td>
							<td><?php echo " $horainicial "; ?></td>
							<td><?php echo " $horafinal "; ?></td>
							<td align="center"><div align="center"><font face="Tahoma"><?php echo $row_horarios['nombretiposalon'];?></font></div></td>
							<td align="center"><?php echo $row_horarios['fechadesdehorariodetallefecha'];?></td>
							<td align="center"><?php echo $row_horarios['fechahastahorariodetallefecha'];?></td>	
							<td align="center">
								<div align="center"><font face="Tahoma">
									<?php
								if(!isset($_POST['adicionarhorario']) && !isset($_POST['editarhorario']))
								{
									?>
									<input type="radio" name="numerohorario1" value="<?php echo $numerohorario; ?>" <?php if($numerohorario == 1) echo "checked";?>>
									<?php
								}
								?>&nbsp;</font></div>
							</td>
						</tr>
						<?php
						}
						else
						{  
							$SQL_h='SELECT s.SolicitudAsignacionEspacioId AS id FROM AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON  s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId WHERE a.SolicitudPadreId = "'.$Padre.'" AND s.codigodia = "'.$codigodia.'" AND s.codigoestado = 100';
							$R_Hijos = mysql_query($SQL_h, $sala) or die(mysql_error());  
							$row_hijos = mysql_fetch_assoc($R_Hijos);      
          
							$updhoras = restarhoras($horafinal, $horainicial);
							$horasfaltantes = sumarhoras($horasfaltantes,$updhoras);
							//echo "<br>$horasfaltantes"; 
						?>
					<tr class="Estilo1">
						<td> 
							<select name="codigodia1">
							<?php
							do
							{
								//if($numerohorario != $_POST['numerohorario1'] || isset($_GET['aceptaredicion']) || isset($_GET['editarhorario']))
								if($codigodia != $row_dia['codigodia'])
								{    
								?>
								<option value="<?php echo $row_dia['codigodia']?>"<?php if (!(strcmp($row_dia['codigodia'], $_POST['codigodia1']))) {echo "SELECTED";} ?>><?php echo $row_dia['nombredia']?></option>
								<?php
								}
								else
								{
								?>
								<option value="<?php echo $codigodia ?>"<?php echo "SELECTED"; ?>><?php echo $nombredia;?></option>
								<?php			
								}
							}//do
							while ($row_dia = mysql_fetch_assoc($dia));
							$totalRows_dia = mysql_num_rows($dia);
							if($totalRows_dia > 0)
							{
								mysql_data_seek($dia, 0);
								$row_dia = mysql_fetch_assoc($dia);
							}
							?>
							</select>
							<?php
							if(isset($_POST['codigodia1']))
							{
								$codigodia = $_POST['codigodia1'];
								$imprimir = true;
								$diarequerido = validar($codigodia,"combo",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$diarequerido;
							}
							?>
						</td>
						<td>
							<font size="2" face="Tahoma"> 
								<input type="text" name="hinicial1" value="<?php if(isset($_POST['hinicial1'])) echo $_POST['hinicial1']; else echo $horainicial;?>" size="8">
							</font>								
							<font size="1" face="Tahoma"><font color="#FF0000">
								<?php
							if(isset($_POST['hinicial1']))
							{
								$hinicial = $_POST['hinicial1'];
								$imprimir = true;
								$hinihora = validar($hinicial,"hora",$error2,$imprimir);
								$formulariovalido = $formulariovalido*$hinihora;
							}
							?>
								</font>
							</font>
						</td>
						<td>
							<font size="2" face="Tahoma"> 
								<input type="text" name="hfinal1" value="<?php if(isset($_POST['hfinal1'])) echo $_POST['hfinal1']; else echo $horafinal;?>" size="8">
							</font>								
							<font size="1" face="Tahoma">
								<font color="#FF0000">
									<?php
									if(isset($_POST['hfinal1']))
									{
										$hfinal = $_POST['hfinal1'];
										$imprimir = true;
										$hfinhora = validar($hfinal,"hora",$error2,$imprimir);
										$formulariovalido = $formulariovalido*$hfinhora;
									}
									?>
								</font>									
							</font>  
						</td>
						<td>
							<font size="2" face="Tahoma"> 
								<select name="codigotiposalon1">
									<?php
									do
									{
										//if($numerohorario != $_POST['numerohorario1'] || isset($_GET['aceptaredicion']) || isset($_GET['editarhorario']))
										if($codigotiposalon != $row_tiposalon['codigotiposalon'])
										{    
										?>
											<option value="<?php echo $row_tiposalon['codigotiposalon']?>"<?php if (!(strcmp($row_tiposalon['codigotiposalon'], $_POST['codigotiposalon1']))) {echo "SELECTED";} ?>><?php echo $row_tiposalon['nombretiposalon']?></option>
											<?php
										}
										else
										{
										?>
											<option value="<?php echo $codigotiposalon ?>"<?php echo "SELECTED"; ?>><?php echo $nombretiposalon;?></option>
										<?php			
										}
									}//do
									while ($row_tiposalon = mysql_fetch_assoc($tiposalon));
									$totalRows_tiposalon = mysql_num_rows($tiposalon);
									if($totalRows_tiposalon > 0)
									{
										mysql_data_seek($tiposalon, 0);
										$row_tiposalon = mysql_fetch_assoc($tiposalon);
									}
									?>
								</select>
							</font><font size="1" face="Tahoma"><font color="#FF0000">
							<?php
							if(isset($_POST['codigotiposalon1']))
							{
								$codigotiposalon = $_POST['codigotiposalon1'];
								//echo $codigotiposalon;
								$imprimir = true;
								$tiposalonrequerido = validar($codigotiposalon,"combo",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$tiposalonrequerido;
							}
							?>
							</font></font>  
						</td>
						<td>
							<input type="text" name="fechainicial" id="fechainicial" onclick="mostrar()" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $row_horarios['fechadesdehorariodetallefecha']; ?>" >
						</td>
						<td>
							<input type="text" name="fechafinal"  id="fechafinal" onclick="mostrar()" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $row_horarios['fechahastahorariodetallefecha']; ?>" >
							<input type="hidden" name="idhorariodetallefecha" value=" <?php echo $row_horarios['idhorariodetallefecha']; ?>">
							<input type="hidden" name="idhorario" value=" <?php echo $row_horarios['idhorario']; ?>">
							<script type="text/javascript">
							function mostrar(){
								alert("hola");
							}
							</script>
							 <script type="text/javascript">
								Calendar.setup(
								{ inputField : "fechainicial", // ID of the input field
									ifFormat : "%Y-%m-%d", // the date format
									range : [1900,9999]

								});
							</script>
							<script type="text/javascript">
								Calendar.setup(
								{ inputField : "fechafinal", // ID of the input field
									ifFormat : "%Y-%m-%d", // the date format
									range : [1900,9999]
								});
							</script>
						</td>
						<td align="center"><font size="2" face="Tahoma">
							<input type="hidden" name="numerohorario1" value="<?php echo $numerohorario;?>">
							<input type="hidden" name="codigosalon1" value="<?php echo $codigosalon;?>">
							<input type="hidden" value="<?PHP echo $Padre?>" name="Padre" />
							<input type="hidden" value="<?PHP echo $row_hijos['id']?>" name="Hijo" />
							<input type="submit" name="aceptaredicion" value="OK" onclick="return ValidarAcceso('<?PHP echo $Padre?>');">
							</font>
						</td>
					</tr>
					<?php			
						}//else
						$numerohorario++;
					 }//while
					}//if tiene horario
					if(isset($_POST['adicionarhorario']) || isset($_POST['aceptaradicion']))
					{
					?>
					<tr class="Estilo1">
						<td> 
							<select name="codigodia1">
								<option value="0" <?php if (!(strcmp(0, $_POST['codigodia1']))) {echo "SELECTED";} ?>>Seleccionar</option>
								<?php
					 			do
								{    
								?>
									<option value="<?php echo $row_dia['codigodia']?>"<?php if (!(strcmp($row_dia['codigodia'], $_POST['codigodia1']))) {echo "SELECTED";} ?>><?php echo $row_dia['nombredia']?></option>
								<?php
								}
								while ($row_dia = mysql_fetch_assoc($dia));
								$totalRows_dia = mysql_num_rows($dia);
								if($totalRows_dia > 0)
								{
									mysql_data_seek($dia, 0);
									$row_dia = mysql_fetch_assoc($dia);
								}
								?>
							</select>
							<?php
							if(isset($_POST['codigodia1']))
							{
								$codigodia = $_POST['codigodia1'];
								$imprimir = true;
								$diarequerido = validar($codigodia,"combo",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$diarequerido;
							}
						?>
						</td>
						<td><font size="2" face="Tahoma"> 
							<input type="text" name="hinicial1" value="<?php if(isset($_POST['hinicial1'])) echo $_POST['hinicial1'];?>" size="8">
							</font><font size="1" face="Tahoma"><font color="#FF0000">
							<?php
							if(isset($_POST['hinicial1']))
							{
								$hinicial = $_POST['hinicial1'];
								$imprimir = true;
								$hinihora = validar($hinicial,"hora",$error2,$imprimir);
								$formulariovalido = $formulariovalido*$hinihora;
							}
							?>
							</font></font>  
						</td>
						<td><font size="2" face="Tahoma"> 
							<input type="text" name="hfinal1" value="<?php if(isset($_POST['hfinal1'])) echo $_POST['hfinal1'];?>" size="8">
							</font><font size="1" face="Tahoma"><font color="#FF0000">
							<?php
							if(isset($_POST['hfinal1']))
							{
								$hfinal = $_POST['hfinal1'];
								$imprimir = true;
								$hfinhora = validar($hfinal,"hora",$error2,$imprimir);
								$formulariovalido = $formulariovalido*$hfinhora;
							}
							?>
							</font></font>  
						</td>
						<td><font size="2" face="Tahoma"> 
							<select name="codigotiposalon1">
								<option value="0" <?php if (!(strcmp(0, $_POST['codigotiposalon1']))) {echo "SELECTED";} ?>>Seleccionar</option>
								<?php
								do
								{    
								?>
									<option value="<?php echo $row_tiposalon['codigotiposalon']?>"<?php if (!(strcmp($row_tiposalon['codigotiposalon'], $_POST['codigotiposalon1']))) {echo "SELECTED";} ?>><?php echo $row_tiposalon['nombretiposalon']?></option>
								<?php
								}
								while ($row_tiposalon = mysql_fetch_assoc($tiposalon));
								$totalRows_tiposalon = mysql_num_rows($tiposalon);
								if($totalRows_tiposalon > 0)
								{
									mysql_data_seek($tiposalon, 0);
									$row_tiposalon = mysql_fetch_assoc($tiposalon);
								}
								?>
							</select>
							</font><font size="1" face="Tahoma"><font color="#FF0000">
							<?php
							if(isset($_POST['codigotiposalon1']))
							{
								$codigotiposalon = $_POST['codigotiposalon1'];
								//echo $codigotiposalon;
								$imprimir = true;
								$tiposalonrequerido = validar($codigotiposalon,"combo",$error1,$imprimir);
								$formulariovalido = $formulariovalido*$tiposalonrequerido;
							}
							?>
							</font></font>  
						</td>
						<td>
							<input type="text" name="fechainicial" id="fechainicial" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php if ($_POST['fechainicial'] <> "") echo $_POST['fechainicial']; else echo $fechaini; ?>" ></td>
						<td>
							<input type="text" name="fechafinal" id = "fechafinal" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php if ($_POST['fechafinal'] <> "") echo $_POST['fechafinal']; else echo $fechafin; ?>" >
							<input type="hidden" name="idhorariodetallefecha2" value=" <?php echo $row_horarios['idhorariodetallefecha']; ?>">		 
							<input type="hidden" name="idhorario" value=" <?php echo $row_horarios['idhorario']; ?>">
							<script type="text/javascript">
								Calendar.setup(
								{ inputField : "fechainicial", // ID of the input field
									ifFormat : "%Y-%m-%d", // the date format
									range : [1900,9999]

								});
							</script>
							<script type="text/javascript">
								Calendar.setup(
								{ inputField : "fechafinal", // ID of the input field
									ifFormat : "%Y-%m-%d", // the date format
									range : [1900,9999]
								});
							</script>								
						</td>
						<td align="center"><font size="2" face="Tahoma"> 
							<input type="submit" name="aceptaradicion" value="OK">
							</font>
						</td>
					</tr>
					<?php
					}//if adicionar horario
					?>
					<tr class="Estilo2">
						<td colspan="7" align="center">
							<?php	
							if(isset($_POST['hinicial1']) && isset($_POST['hfinal1']))
							{
							$hora = 1;
							$res_hora = restarhoras($_POST['hfinal1'],$_POST['hinicial1']);
							if($res_hora == "00:00" || $res_hora == "Función mal usada")
							{
								echo '<font size="1" face="Tahoma" color="#FF0000">La hora que digito no es correcta, la hora final debe ser mayor a la hora inicial</font>';die;
								$hora = 0;
							}
							else
							{
								if(horamayor($res_hora,$horasfaltantes))
								{
									echo '<font size="1" face="Tahoma" color="#FF0000">La hora que digito no es correcta, sobrepasa las horas faltantes por asignar</font>';die;
									//$hora = 0;
									$sobrepashorasfaltantes = true;
								}
							}
							//echo "<br>F1 ".$_POST['hfinal1']." <br> #horario ".$_POST['numerohorario1']."<br>";
							//echo "I1 ".$_POST['hinicial1']." <br>I2 <br>"; 
								if(tienecruces($idgrupo,$sala,$_POST['hinicial1'],$_POST['hfinal1'],$_POST['codigodia1'],$_POST['numerohorario1']))
							{
								echo '<font size="1" face="Tahoma" color="#FF0000">El horario que digito se cruza con los ya creados, debe modificar.</font>';die;
								$hora = 0;
							}

							if ($_POST['fechainicial'] > $_POST['fechafinal'])
							{
							  echo '<tr><td colspan="7" align="center"><font size="1" face="Tahoma" color="#FF0000">Fecha Inicial Mayor a la Fecha Final</font></td></tr>';die;
							  $hora = 0;
							}	 
							if ($_POST['fechainicial'] == "" or $_POST['fechafinal'] == "")
							{
							  echo '<tr><td colspan="7" align="center"><font size="1" face="Tahoma" color="#FF0000">Debe digitar las fechas de la duración de cada horario</font></td></tr>';die;
							  $hora = 0;
							}	     

							$formulariovalido = $formulariovalido*$hora;
							}
							?>  
						</td>
					</tr>	
					<?php
					if(!isset($_POST['adicionarhorario']) && !isset($_POST['editarhorario']) && !isset($_POST['aceptaradicion']) && !isset($_POST['aceptaredicion']))
					{
					?>
					<tr>
						<td align="center" colspan="7"> <font size="2" face="Tahoma"> 
						<?php
						//if($horassemanales != $horasasignadas)
						//{
						?>
						<input type="submit" name="adicionarhorario" value="Adicionar Horario">
						<?php
						//}
						?>
						&nbsp; 
						<?php
						if($horassemanales != $horasfaltantes)
						{
							?>
							<input type="submit" name="editarhorario" value="Editar Horario">
							</font>
						  	<font face="Tahoma">
						  	<?php
						}
						?>
							</font>
						</td> 
					</tr>
					<?php
					}
					if(isset($_POST['adicionarhorario']) || isset($_POST['aceptaradicion']))
					{
					?>
						<tr>
							<td align="center" colspan="7" valign="middle"> <font size="2" face="Tahoma"> 
								<input type="button" name="cancelar" value="Cancelar Adición" onClick="cancelarhorario()">
								</font>
							</td> 
						</tr>
					<?php
					}
					if(isset($_POST['editarhorario']) || isset($_POST['aceptaredicion']))
					{
					?>  
						<tr>
							<td align="center" colspan="7" valign="middle"> <font size="2" face="Tahoma"> 
								<input type="button" name="cancelar" value="Cancelar Edición" onClick="cancelarhorario()">
								</font>
							</td> 
					  	</tr>
					<?php
					}
					?>
						<tr>
							<td colspan="7" align="center"><font size="2" face="Tahoma">
								<input type="submit" name="cancelar" value="Cerrar">
								</font>
							</td>
					  	</tr>
				</table>
			</form>
			<font face="Tahoma">
				<?php
				if(isset($_POST['aceptaradicion']) || isset($_POST['aceptaredicion']))
				{
    				include_once(realpath(dirname(__FILE__)).'/../../../EspacioFisico/Interfas/FuncionesSolicitudEspacios_Class.php');   $C_FuncionesSolicitudEspacios = new FuncionesSolicitudEspacios();
					if ($formulariovalido == 1)
					{
						$codigodia=$_POST['codigodia1'];
						$horainicial = $_POST['hinicial1'];
						$horafinal = $_POST['hfinal1'];
						if(isset($_POST['aceptaradicion']))
						{
							$codigosalon = 1;
							$query_addhorario = "INSERT INTO horario(idhorario, idgrupo, codigodia, horainicial, horafinal, codigotiposalon, codigosalon, codigoestado) VALUES(0, '$idgrupo', '$codigodia', '$horainicial', '$horafinal', '".$_POST['codigotiposalon1']."', '$codigosalon', '100')";
							//echo "<br>INSERT HORARIO: $query_addhorario<br>";
							$addhorario = mysql_query($query_addhorario, $sala) or die(mysql_error());
							$idhorario = mysql_insert_id();

							$query_inshorariodetallefecha = "INSERT INTO horariodetallefecha(idhorariodetallefecha, idhorario, fechadesdehorariodetallefecha, fechahastahorariodetallefecha, codigoestado)  VALUES(0, '$idhorario', '".$_REQUEST['fechainicial']."', '".$_REQUEST['fechafinal']."', '100')";
							//echo "<h3>$query_inshorariodetallefecha</h3>";
							$inshorariodetallefecha = mysql_query($query_inshorariodetallefecha, $sala) or die("$query_inshorariodetallefecha");
							///*********Inserta dia o Horario 
							if($Padre){
								$C_FuncionesSolicitudEspacios->DiaAdd($userid,$Padre,$horainicial,$horafinal,$codigodia,$codigosalon,'../../../EspacioFisico/');
							}    
						}//if				
						if(isset($_POST['aceptaredicion']))
						{
							$idhorario = $_POST['idhorario'];
							$codigosalon = $_POST['codigosalon1'];
							$numerohorario = $_POST['numerohorario1'];
                            /*
                             * Caso  90519
                             * @modified Luis Dario Gualteros 
                             * <castroluisd@unbosque.edu.co>
                             * Se modifica la consulta $query_horarios para que permita la edición de horarios.
                             * @since Junio 1 de 2017
                            */
							$query_horarios = "SELECT * FROM horario h, dia d WHERE h.codigodia = d.codigodia AND h.idgrupo = '$idgrupo' order by 1,2,3,4";
                            //End Caso 90519
							$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
							$totalRows_horarios = mysql_num_rows($horarios);		
							if($totalRows_horarios != 0)
							{
								$cuentahorario = 1;
								while($row_horarios = mysql_fetch_assoc($horarios))
								{
									$codigodia2=$row_horarios['codigodia'];
									$nombredia2=$row_horarios['nombredia'];
									$codigosalon2=$row_horarios['codigosalon'];
									$horainicial2=$row_horarios['horainicial'];
									$horafinal2=$row_horarios['horafinal'];
									if($cuentahorario == $numerohorario)
									{
										$query_updhorario = "UPDATE horario SET codigodia = '$codigodia',  horainicial = '$horainicial',  horafinal = '$horafinal',  codigotiposalon = '".$_POST['codigotiposalon1']."',  codigosalon = '$codigosalon' WHERE idhorario = $idhorario";
										//echo "<br>INSERT HORARIO: $query_updhorario<br>";
										//exit();
										$updhorario = mysql_query($query_updhorario, $sala) or die(mysql_error());

										$query_updhorariodet = "UPDATE horariodetallefecha  SET fechadesdehorariodetallefecha = '".$_REQUEST['fechainicial']."',			fechahastahorariodetallefecha = '".$_REQUEST['fechafinal']."' where idhorariodetallefecha = '".$_REQUEST['idhorariodetallefecha']."'";
										//echo "<br>INSERT HORARIO: $query_updhorario<br>";
										//exit();
										$updhorariodet = mysql_query($query_updhorariodet, $sala) or die(mysql_error());						
										//Edita Horario
										//Falta el Hijo
										$Hijo = $_REQUEST['Hijo'];
										if($Hijo)
										{
											$C_FuncionesSolicitudEspacios->EditarHorario($userid,$Hijo,$horainicial,$horafinal,$codigodia,$_POST['codigotiposalon1'],'../../../EspacioFisico/');
										}  
										break;
									}
									$cuentahorario++;
								}//while
							}//if
						}//if
						//exit();				
						echo '<script language="JavaScript">
						window.location.href = "editarhorario.php'.$dirini.'&grupo1='.$grupo.'&numerohorassemanales1='.$numerohorassemanales.'&idgrupo1='.$idgrupo.'";
						</script>';
					}//if formulario 1
				}//if
				?>
			</font>				
		</div>
	</body>
	<?php
	echo '
	<script language="JavaScript">
	function cancelarhorario()
	{
		window.location.href = "editarhorario.php'.$dirini.'&grupo1='.$grupo.'&numerohorassemanales1='.$numerohorassemanales.'&idgrupo1='.$idgrupo.'";
	}
	</script>';
	?>
</html>