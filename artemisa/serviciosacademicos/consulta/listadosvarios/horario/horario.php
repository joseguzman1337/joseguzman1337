<?php 
	require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php' );
	mysql_select_db($database_sala, $sala);
	session_start();
?>
<html>
	<head>
		<title> Horario </title>
		<script language="javascript">
			function recargar(dir)
			{
				window.location.href="horario.php"+dir;
			}
		</script>
	</head>
	<body>
		<?php
		$codigocarrera = $_SESSION['codigofacultad'];
		$codigoperiodo = $_SESSION['codigoperiodosesion'];
		$idplanestudio = $_GET['planestudio'];

		/*$idplanestudio = 18;
		$codigocarrera = 730;
		$codigoperiodo = '20052';
		$filtrado = 1;*/
		if(isset($_GET['filtro']))
		{
			$filtrado = $_GET['filtro'];
		}
			
		// Selecciona las materias de primer semestre
		$query_selsemestre = "select p.cantidadsemestresplanestudio from planestudio p where p.idplanestudio = '$idplanestudio'";
		$selsemestre = mysql_db_query($database_sala, $query_selsemestre) or die("$query_selsemestre".mysql_error());
		$totalRows_selsemestre = mysql_num_rows($selsemestre);
		$row_selsemestre = mysql_fetch_array($selsemestre);
		$ultimosemestre = $row_selsemestre['cantidadsemestresplanestudio'];
		
		// Seleccion de las materias del plan de estudio
		if($filtrado != 'materia')
		{
			if($filtrado == 'materiaunica')
			{
				$codmateria = $_GET['materiaelegida'];
				$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 AS semestredetalleplanestudio,  	t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.numerocreditos, m.numerohorassemanales FROM detalleplanestudio d, materia m, tipomateria t WHERE d.codigoestadodetalleplanestudio LIKE '1%' AND d.codigomateria = m.codigomateria AND d.codigotipomateria = t.codigotipomateria AND d.idplanestudio = '$idplanestudio' and d.codigomateria = '$codmateria' ORDER BY 3,2";
			}
			else if($filtrado != 'todos')
			{
				$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 AS semestredetalleplanestudio,  	t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.numerocreditos, m.numerohorassemanales FROM detalleplanestudio d, materia m, tipomateria t WHERE d.codigoestadodetalleplanestudio LIKE '1%' AND d.codigomateria = m.codigomateria AND d.codigotipomateria = t.codigotipomateria AND d.idplanestudio = '$idplanestudio' and d.semestredetalleplanestudio = '$filtrado' ORDER BY 3,2";
			}
			else
			{
				$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 		t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.numerocreditos, m.numerohorassemanales FROM detalleplanestudio d, materia m, tipomateria t WHERE d.codigoestadodetalleplanestudio LIKE '1%' AND d.codigomateria = m.codigomateria AND d.codigotipomateria = t.codigotipomateria AND d.idplanestudio = '$idplanestudio' ORDER BY 3,2";
			}
			$materiasplanestudio = mysql_db_query($database_sala,$query_materiasplanestudio) or die("$query_materiasplanestudio");
			$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
			while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))
			{
				// Para cada materia selecciono los grupos 
				$codigomateria = $row_materiasplanestudio['codigomateria'];
				// Para cada materia selecciono los grupos sin horario
				$query_grupoinicial = "SELECT g.nombregrupo, g.idgrupo,	g.codigoindicadorhorario, concat(d.apellidodocente,' ',d.nombredocente) as nombre, (select sum(matriculadosgrupo + matriculadosgrupoelectiva) as suma from  grupo where idgrupo = g.idgrupo) as 'matriculadosgrupo', g.maximogrupo, d.numerodocumento, d.emaildocente FROM grupo g, docente d  where g.codigoperiodo = '$codigoperiodo'  and g.codigomateria = '".$codigomateria."' and g.codigoestadogrupo like '1%' and d.numerodocumento = g.numerodocumento";	
				$grupoinicial=mysql_db_query($database_sala,$query_grupoinicial);
				$totalRows_grupoinicial = mysql_num_rows($grupoinicial);				
				$totalsalones = 0;
				if($totalRows_grupoinicial != "")
				{
					while($row_grupoinicial = mysql_fetch_array($grupoinicial))
					{
                    	$numerodocumento1 = $row_grupoinicial['numerodocumento'];
                        $query_elusuario = "SELECT usuario, numerodocumento FROM usuario where numerodocumento = '$numerodocumento1' and codigotipousuario = 500        group by 2";						
						$elusuario= mysql_db_query($database_sala,$query_elusuario);
						$totalRows_elusuario = mysql_num_rows($elusuario);
						$row_elusuario = mysql_fetch_array($elusuario);
						if($totalRows_elusuario != ""){
							$row_grupoinicial['usuario'] = $row_elusuario['usuario'];
						}
						
						// Para cada grupo selecciono los salones
						$idgrupo = $row_grupoinicial['idgrupo'];
						if($row_grupoinicial['codigoindicadorhorario'] == '100')
						{
							$query_saloninicial = "select count(*) as cuenta, h.codigosalon from horario h where h.idgrupo = '$idgrupo' group by 2";
							$saloninicial = mysql_db_query($database_sala,$query_saloninicial);
							$totalRows_saloninicial = mysql_num_rows($saloninicial);
							if($totalRows_saloninicial != "")
							{
								$row_grupoinicial['numerosalones'] = $totalRows_saloninicial;
								$totalsalones = $totalsalones + $totalRows_saloninicial;
								while($row_saloninicial = mysql_fetch_array($saloninicial))
								{
									// Para cada salon selecciono los horarios
									$codigosalon = $row_saloninicial['codigosalon'];
						
									$query_horarioinicial = "select h.horainicial, h.horafinal, h.codigotiposalon, h.codigosalon, s.nombresalon, d.nombredia, 		d.codigodia, h.idgrupo from horario h, dia d, salon s where h.idgrupo = '$idgrupo' and h.codigosalon = s.codigosalon 			and h.codigodia = d.codigodia and s.codigosalon = '$codigosalon'";							
									$horarioinicial=mysql_db_query($database_sala,$query_horarioinicial);
									$totalRows_horarioinicial = mysql_num_rows($horarioinicial);
									if($totalRows_horarioinicial != "")
									{
										while($row_horarioinicial = mysql_fetch_array($horarioinicial))
										{
											// Aca viene el numero de horarios que tiene cada salon
											$horario[] = $row_horarioinicial;
										}
										$horarios[$codigosalon][$idgrupo] = $horario;
										unset($horario); 
									}
									$salones[$idgrupo][] = $row_saloninicial;					
								}//while
							}
							else
							{
								$totalsalones = $totalRows_grupoinicial;								
							}
							$grupos[$codigomateria][] = $row_grupoinicial;
						}//if
						else
						{
							$grupos[$codigomateria][] = $row_grupoinicial;
							$totalsalones = $totalRows_grupoinicial;
						}
					}//while
				}
				$row_materiasplanestudio['numerosalones'] = $totalsalones;
				$materiasplan[] = $row_materiasplanestudio;
			}//while
		}// if materia		
		?>
		<div align="center">
			<?php 
			echo '<script language="javascript">
			function cambia_tipo()
			{ 
				//tomo el valor del select del tipo elegido 
				var tipo 
				tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
				//miro a ver si el tipo está definido 
				window.location.href="horario.php?planestudio='.$idplanestudio.'&filtro="+tipo; 
			} 
			</script>';
			?>
			<?php 
			$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio from planestudio p, carrera c, tipocantidadelectivalibre t where p.codigocarrera = c.codigocarrera and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre and p.idplanestudio = '$idplanestudio'"; 
			$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio");
			$row_planestudio = mysql_fetch_assoc($planestudio);
			$totalRows_planestudio = mysql_num_rows($planestudio);
			?>
			<form action="horario.php" name="f1" method="post">
				<table border="0" cellspacing="1" cellpadding="1" bordercolor="#003333" align="center"> 
					<tr>
						<td align="center"><font size="2" face="Tahoma"><strong>Seleccione una opción del menú desplegable.</strong></font> </td>
					</tr>
					<tr>
						<td align="center">
							<select name="tipo" onChange="cambia_tipo()">
								<option value="0">Seleccionar</option>
								<option value="todos">Todos</option>
								<?php
								for($i=1;$i<=$ultimosemestre;$i++)
								{
								?>
								<option value="<?php echo $i ?>">Semestre <?php echo $i ?></option>
								<?php
								}
								?>
								<option value="materia">Materia</option>
							</select>
						</td>
					</tr>	
				</table>
				<br>
				<table border="2" cellspacing="2" bordercolor="#003333" cellpadding="2" width="740">
					<tr id="trgris" >
						<td align="center" bgcolor="#C5D5D6"><strong>Nº Plan Estudio</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Fecha</strong></td>
					</tr>
					<tr id="trgris">
						<td align="center"><?php echo $idplanestudio; ?></td>
						<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
						<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechacreacionplanestudio']); ?></td>
					</tr>
					<tr id="trgris">
						<td align="center" colspan="2" bgcolor="#C5D5D6"><strong>Nombre Encargado</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Cargo</strong></td>
					</tr>
					<tr id="trgris">
						<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
						</td>
						<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
						</td>
					</tr>
					<tr id="trgris">
						<td align="center" bgcolor="#C5D5D6"><strong>Nº Semestres</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Carrera</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Autorización Nº</strong></td>
					</tr>
					<tr id="trgris">
						<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
						<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
						<td align="center" ><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
					</tr>
					<tr id="trgris">
						<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
						<td align="center"><strong>Cantidad</strong></td> -->
						<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
						<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
						<td rowspan="2">&nbsp;</td>
					</tr>
					<tr id="trgris">
						<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
						<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> -->
						<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechainioplanestudio']); ?></td>
						<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
					</tr>
				</table>
				<br>
					<?php
					if($filtrado == 'materia')
					{
						echo "<script language='javascript'>
						//alert('entro');
						window.open('buscarmateria.php?planestudio=$idplanestudio','ventana','width=500,height=400,left=150,top=100,scrollbars=yes')
						</script>";
						exit();
					}
					// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
					$semestre = 0;
					$cuentamateria = 1;
					?>
					<table border="2" cellspacing="2" bordercolor="#003333" cellpadding="2" width="740">
						<?php
						foreach($materiasplan as $llave1 => $vrow_materia)
						{							
							$semestrenuevo = $vrow_materia['semestredetalleplanestudio'];
							if($semestrenuevo != $semestre)
							{
								?>
								<tr>
									<td colspan="20" align="center"><font size="3" face="Tahoma"><strong>Semestre <?php echo $semestrenuevo; ?></strong></font></td>
								</tr>
								<tr>
									<td height="20" align="center" bgcolor="#C5D5D6"><font face="Arial" size="1"><strong>MATERIA</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>GRU</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>T.MATERIA</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>#CREDITOS</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>#H.SEMANA</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>CUPO</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>T.MATRICULADOS</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>%GRUPO</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>#DOCUMENTO</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>PROFESOR</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>C.PERSONAL</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>C.INSTITUCIONAL</strong></font></td>
									<td align="center" bgcolor="#C5D5D6"><font face="Arial" size="1"><strong>SALON</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>LUN</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>MAR</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>MIE</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>JUE</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>VIE</strong></font></td>
									<td bgcolor="#C5D5D6" align="center"><font face="Arial" size="1"><strong>SAB</strong></font></td>
								</tr>
								<?php
								$semestre = $semestrenuevo;								
							}//if
							if(fmod($cuentamateria, 2) == 0)
							{
								$bgcolor = 'bgcolor="#FEF7ED"';
							}
							else
							{
								$bgcolor = "";
							}
							$cuentamateria++;
							?>
							<tr <?php echo  $bgcolor; ?>>
								<td rowspan="<?php echo $vrow_materia['numerosalones']; ?>" bordercolor="#FF9900" align="center">
									<font face="Arial" size="1">
										<?php 
										echo $vrow_materia['codigomateria']."<br>"; 
										echo $vrow_materia['nombremateria']; 
										?> 
									</font>
								</td> <!-- MATERIA -->
								<?php													
								if(isset($grupos[$vrow_materia['codigomateria']]))
								{
									$entrogrupo = false;
									foreach($grupos[$vrow_materia['codigomateria']] as $llave2 => $vrow_grupo)
									{
										if($entrogrupo)
										{
										?>
											<tr <?php echo  $bgcolor; ?>>
										<?php		
										}
										else
										{
											$entrogrupo = true;
										}		
										?>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center">
											<font face="Arial" size="1">
										  		<?php echo $vrow_grupo['idgrupo']; //echo $vrow_grupo['numerosalones'];?>   
											</font>
										</td><!-- MATERIA -->
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
										  <?php echo $vrow_materia['nombretipomateria']; //echo $vrow_grupo['numerosalones'];?>   
											</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
										  <?php echo $vrow_materia['numerocreditos']; //echo $vrow_grupo['numerosalones'];?>   
											</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
										  <?php echo $vrow_materia['numerohorassemanales']; //echo $vrow_grupo['numerosalones'];?>   
											</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
										  <?php echo $vrow_grupo['maximogrupo']; ?>  
											</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
										  <?php echo $vrow_grupo['matriculadosgrupo']; ?>  
											</font></td>
										<?php
										if($vrow_grupo['maximogrupo']!=0)
										{
											$porcentajegrupo=($vrow_grupo['matriculadosgrupo']/$vrow_grupo['maximogrupo']*100); 
											$porcentajegrupo=number_format($porcentajegrupo,1);        
										}
										else
										{
										$porcentajegrupo=100;
										}
										?>
									<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center" bgcolor="<?php if($porcentajegrupo >90){ ?>Green<?php }
									else if($porcentajegrupo >50 && $porcentajegrupo <=90){ ?>Yellow<?php }
									else if($porcentajegrupo <=50){ ?>Red<?php }?>"><font face="Arial" size="1">
										<?php echo $porcentajegrupo."%" ; ?>  
										</font></td>
									<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
									  <?php echo $vrow_grupo['numerodocumento']; ?>  
										</font></td>    
									<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
									  <?php echo $vrow_grupo['nombre']; ?>  
										</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
									  <?php if($vrow_grupo['emaildocente']!=''){
										  echo $vrow_grupo['emaildocente']; }
										  else{
											  echo "&nbsp;";
										  } ?>
										</font></td>
										<td rowspan="<?php echo $vrow_grupo['numerosalones']; ?>" bordercolor="#FF9900" align="center"><font face="Arial" size="1">
									  <?php if($vrow_grupo['usuario']!=''){echo $vrow_grupo['usuario']."@unbosque.edu.co";}
									  else {
										  echo "&nbsp;";
									  } ?>
										</font></td>
										<?php
										if(isset($salones[$vrow_grupo['idgrupo']]))
										{
											$entrosalones = false;
											foreach($salones[$vrow_grupo['idgrupo']] as  $llave3 => $vrow_salon)
											{			
												if($entrosalones)
												{
												?>
												<tr <?php echo  $bgcolor; ?>>
												<?php		
												}
											else
											{
												$entrosalones = true;
											}		
													?>
    								<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
      							<?php echo  $vrow_salon['codigosalon'];?>
										</font></td>
								<?php


								?>
									<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
								<?php 
								$horario1 = $horarios[$vrow_salon['codigosalon']][$vrow_grupo['idgrupo']];
								$entrohorario = false; 
								foreach($horario1 as $llave4 => $vrow_horario)
								{
									if($vrow_horario['codigodia'] == 1) 
									{
										if($entrohorario)
										{
											echo "<br>Y<br>";
										}
										echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
										$entrohorario = true; 
									}
								}
							?>
								 &nbsp; 
								</font></td>
								<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
							<?php 
							$entrohorario = false; 
							foreach($horario1 as $llave4 => $vrow_horario)
							{
								if($vrow_horario['codigodia'] == 2)
								{
									if($entrohorario)
									{
										echo "<br>Y<br>";
									}
									echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
									$entrohorario = true; 
								}
							}
						?>
							 &nbsp; 
							 </font></td>
							<td align="center" bordercolor="#FF9900"><font face="Arial" size="1">
						<?php 
								$entrohorario = false; 
								foreach($horario1 as $llave4 => $vrow_horario)
								{
									if($vrow_horario['codigodia'] == 3)
									{
										if($entrohorario)
										{
											echo "<br>Y<br>";
										}
										echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
										$entrohorario = true; 
									}
					}
								?>
									 &nbsp; 
									 </font></td>
									<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
								<?php 
								$entrohorario = false; 
								foreach($horario1 as $llave4 => $vrow_horario)
								{
									if($vrow_horario['codigodia'] == 4)
									{
										if($entrohorario)
										{
											echo "<br>Y<br>";
										}
										echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
										$entrohorario = true; 
									}
								}
							?>
								 &nbsp; 
								 </font></td>
								<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
							<?php 
							$entrohorario = false; 
							foreach($horario1 as $llave4 => $vrow_horario)
							{
								if($vrow_horario['codigodia'] == 5)
								{
									if($entrohorario)
									{
										echo "<br>Y<br>";
									}
									echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
									$entrohorario = true; 
								}
							}
							?>
								 &nbsp; 
								 </font></td>
								<td bordercolor="#FF9900" align="center"><font face="Arial" size="1">
							<?php 
								$entrohorario = false; 
								foreach($horario1 as $llave4 => $vrow_horario)
								{
									if($vrow_horario['codigodia'] == 6)
									{
										if($entrohorario)
										{
											echo "<br>Y<br>";
										}
										echo $vrow_horario['horainicial']."<br>".$vrow_horario['horafinal'];
										$entrohorario = true; 
									}
								}
						?>
							 &nbsp; 
							 </font>
						  </td>
						  </tr>
						<?php
											unset($horario1);
											//exit();		
										}//foreach
									}//if
									else
									{
						?>
						 <td colspan="20" align="center"><font face="Arial" size="1">NO TIENE HORARIOS</font></td>
						<?php
									}
								}
							}//if
							else
							{
								?>
								 <td colspan="20" align="center"><font face="Arial" size="1">NO TIENE GRUPOS</font></td>
								<?php
									//	echo "NO entro";
							}
						}
						?>
					</table>
					<br>
					<?php 
					unset($materiasplan);
					require_once("lineaenfasis.php");
					?>				
			</form>
		</div>
	</body>
</html>