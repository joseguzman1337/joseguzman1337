<style>
    .Borde_td{
	border:#000000 1px solid;
	}
	.Titulos{
		border:#000000 1px solid;
		background-color:#90A860;
	}
</style>
<?PHP 

global $userid,$db;
		
		
		include("../templates/mainjson.php");
		
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
		 
		 $Hora = date('Y-m-d');
		 
		 				header('Content-type: application/vnd.ms-excel');
						header("Content-Disposition: attachment; filename=".$Hora.".xls");
						header("Pragma: no-cache");
						header("Expires: 0");
						

		$id_Movilidad			= $_REQUEST['id_Movilidad'];
		$Periodo				= $_REQUEST['Periodo'];
		$TipoEstudiante			= $_REQUEST['TipoEstudiante'];
		$id_carrera				= $_REQUEST['id_carrera'];
		
		/************Modalidad*******************/		
	
	$SQL_Modalidad='SELECT 

					codigomodalidadacademica as id,
					nombremodalidadacademica as nombre
					
					
					FROM 
					
					modalidadacademica
					
					WHERE
					
					codigoestado=100
					AND
					codigomodalidadacademica="'.$id_Movilidad.'"';
					
				if($Modalidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Modalidad...<br>'.$SQL_Modalidad;
						die;
					}	
					
		/**************Carrera***************/			
		
		$SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id_Movilidad.'"
						AND
						codigocarrera="'.$id_carrera.'"';
						
					if($Carrera=&$db->Execute($SQL_Carrera)===false){
							echo 'Error en el SQL Carrera...<br>'.$SQL_Carrera;
							die;
						}
						
		/*************Tipo Estudiante********************/					
		
		$SQL_TipoEstudiante='SELECT 
									codigotipoestudiante as id, 
									nombretipoestudiante as nombre 
									
							 FROM 
							 
							 tipoestudiante
							 
							 WHERE
							 
							 codigotipoestudiante="'.$TipoEstudiante.'"';
							 
				if($D_Estudiante=&$db->Execute($SQL_TipoEstudiante)===false){
						echo 'Error en el SQL Tipo Estudiante....<br>'.$SQL_TipoEstudiante;
						die;
					}			 
		
	?>	
    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
    	<tr>
        	<th><strong>Modalidad Academica</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $Modalidad->fields['nombre']?></strong></th>
            <th>&nbsp;</th>
            <th><strong>Periodo</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $Periodo?></strong></th>
        </tr>
        <?PHP 
			if($id_carrera==0){
					$NomCarrera='Todas.';
				}else if($id_carrera!=0){
						$NomCarrera=$Carrera->fields['nombrecarrera'];
					}
		?>
        <tr>
        	<th><strong>Carrera</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $NomCarrera?></strong></th>
            <th>&nbsp;</th>
            <th><strong>Tipo Estudiante</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $D_Estudiante->fields['nombre']?></strong></th>
        </tr>
    </table>
    <br />	
	<?PHP			 
		
		if($id_carrera==0 && $TipoEstudiante!=0){
				##Buscar solo Por Todas las Carreras
				TodasCarreras($id_Movilidad,$Periodo,$TipoEstudiante);
			}
		if($id_carrera==0 && $TipoEstudiante==0){
				##Buscar Por Todas las Careras Y todos los tipos de estudiante
				TodosDeTodos($id_Movilidad,$Periodo);
			}	
		if($id_carrera!=0 && $TipoEstudiante==0){
				##Buscar Por todos Los tipo de Estudiante
				
				TodosTiposEstudiantes($Periodo,$id_carrera);
			}	
		if($id_carrera!=0 && $TipoEstudiante!=0){
				##Busqueda Detallada
				BuscarDetallada($id_Movilidad,$Periodo,$TipoEstudiante,$id_carrera);
			}
			
			
			
	function BuscarDetallada($id_Movilidad,$Periodo,$TipoEstudiante,$id_carrera){
			global $userid,$db;
			
			$SQL_Buscar='SELECT

						dvp.idvalorpecuniario as id
						
						FROM
						
						facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
												   INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario
						
						WHERE
						
						dvp.codigoestado=100
						AND
						dvp.codigotipoestudiante="'.$TipoEstudiante.'"
						AND
						fvp.codigocarrera="'.$id_carrera.'"
						AND
						fvp.codigoperiodo="'.$Periodo.'"
						AND
						vp.codigoestado=100';
						
				if($ResultadoDetallado=&$db->Execute($SQL_Buscar)===false){
						echo 'Error en el SQL Buscar Detallado...<br>'.$SQL_Buscar;
						die;
					}	
					
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                </tr>
                <?PHP 
					if(!$ResultadoDetallado->EOF){
							
							$i=1;
							
							while(!$ResultadoDetallado->EOF){
								
								$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$ResultadoDetallado->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}	
											
								?>
                                	<tr>
                                    	<td align="center" class="Borde_td"><?PHP echo $i?></td>
                                        <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                                        <td align="right" class="Borde_td"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                                    </tr>
                                <?PHP
								$i++;
								$ResultadoDetallado->MoveNext();
								}
							
						}else{
							?>
                            <tr>
                            	<td align="center" colspan="3"><span style="color:#999">No Hay Informacion</span></td>
                            </tr>
                            <?PHP
							}
				?>
            </table>
            <?PHP			
		}	
	 function TodasCarreras($id_Movilidad,$Periodo,$TipoEstudiante){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
									dvp.iddetallefacturavalorpecuniario,
									dvp.idvalorpecuniario AS id,
									fvp.codigocarrera
							
							FROM
							
								 facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
															INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario INNER JOIN carrera c ON c.codigocarrera=fvp.codigocarrera
							
							WHERE
							
									dvp.codigoestado=100
									AND
									dvp.codigotipoestudiante="'.$TipoEstudiante.'"
									AND
									fvp.codigoperiodo="'.$Periodo.'"
									AND
									vp.codigoestado=100
									AND 
									c.codigomodalidadacademica="'.$id_Movilidad.'"
									
									ORDER BY fvp.codigocarrera';#
									
							if($DetalleTodasCarreras=&$db->Execute($SQL_Buscar)===false){
									echo 'Error en el SQL Todas LAs Carreras....<br>'.$SQL_Buscar;
									die;
								}		
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Carrera</strong></th>	
                </tr>
            <?PHP
				if(!$DetalleTodasCarreras->EOF){
					
					$i=1;
					
					while(!$DetalleTodasCarreras->EOF){
						
								$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodasCarreras->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
											
								  $SQL_Carrera='SELECT 

												codigocarrera,
												nombrecarrera
												
												FROM 
												
												carrera
												
												WHERE
												
												codigocarrera="'.$DetalleTodasCarreras->fields['codigocarrera'].'"';			
												
												
										if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
												die;
											}	
						?>
                        <tr>
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td class="Borde_td" align="right"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                        </tr>
                        <?PHP
						$i++;
						$DetalleTodasCarreras->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="4"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
			
						}
		?>
        </table>
        <?PHP				
		}	
	 function TodosTiposEstudiantes($Periodo,$id_carrera){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
									dvp.iddetallefacturavalorpecuniario,
									dvp.idvalorpecuniario AS id,
									dvp.codigotipoestudiante,
									fvp.codigocarrera
							
							FROM
							
									facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
															   INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario
							
							WHERE
							
									dvp.codigoestado=100
									AND
									fvp.codigoperiodo="'.$Periodo.'"
									AND
									fvp.codigocarrera="'.$id_carrera.'"  
									AND
									vp.codigoestado=100';
									
						if($DetalleTodosTipos=&$db->Execute($SQL_Buscar)===false){
								echo 'Error en el SQL Buscar Todos los Tipos De estudiante...<br>'.$SQL_Buscar;
								die;
							}
							
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Tipo Estudiante</strong></th>	
                </tr>
            <?PHP												
				
				if(!$DetalleTodosTipos->EOF){
					
					$i=1;
					
					while(!$DetalleTodosTipos->EOF){
						
						$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodosTipos->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
									
											
						$SQL_Tipo='SELECT 
									
									codigotipoestudiante,
									nombretipoestudiante
									
									FROM 
									
									tipoestudiante
									
									WHERE
									
									codigotipoestudiante="'.$DetalleTodosTipos->fields['codigotipoestudiante'].'"';					
									
								if($D_Tipo=&$db->Execute($SQL_Tipo)===false){
										echo 'Error en la Buscar  tipos estudiante de Datos...<br>'.$SQL_Tipo;
										die;
									}
						?>
                        <tr>
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td class="Borde_td" align="right"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Tipo->fields['nombretipoestudiante']?></td>
                        </tr>
                        <?PHP
						$i++;
						$DetalleTodosTipos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="4"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP			
			}	
		 function TodosDeTodos($id_Movilidad,$Periodo){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
							dvp.iddetallefacturavalorpecuniario,
							dvp.idvalorpecuniario AS id,
							dvp.codigotipoestudiante,
							fvp.codigocarrera
							
							FROM
							
							facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
							INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario INNER JOIN carrera c ON c.codigocarrera=fvp.codigocarrera
							
							WHERE
							
							dvp.codigoestado=100
							AND
							fvp.codigoperiodo="'.$Periodo.'"
							AND
							vp.codigoestado=100
							AND
							c.codigomodalidadacademica="'.$id_Movilidad.'"
							
							ORDER BY fvp.codigocarrera, dvp.codigotipoestudiante';
							
					if($DetalleTodosdeTodos=&$db->Execute($SQL_Buscar)===false){
							echo 'Error en el SQL Buscar Todos De Todos...<br>'.$SQL_Buscar;  
							die;
						}		
						
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="Borde_td">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Tipo Estudiante</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>	
                </tr>
            <?PHP			
				if(!$DetalleTodosdeTodos->EOF){
					
					$i=1;
					
					while(!$DetalleTodosdeTodos->EOF){
						
						$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodosdeTodos->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
									
											
						$SQL_Tipo='SELECT 
									
									codigotipoestudiante,
									nombretipoestudiante
									
									FROM 
									
									tipoestudiante
									
									WHERE
									
									codigotipoestudiante="'.$DetalleTodosdeTodos->fields['codigotipoestudiante'].'"';					
									
								if($D_Tipo=&$db->Execute($SQL_Tipo)===false){
										echo 'Error en la Buscar  tipos estudiante de Datos...<br>'.$SQL_Tipo;
										die;
									}
									
							      $SQL_Carrera='SELECT 

												codigocarrera,
												nombrecarrera
												
												FROM 
												
												carrera
												
												WHERE
												
												codigocarrera="'.$DetalleTodosdeTodos->fields['codigocarrera'].'"';			
												
												
										if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
												die;
											}	
											
						?>
                        <tr>
                        	<td align="center" class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td align="right" class="Borde_td"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Tipo->fields['nombretipoestudiante']?></td>
                            <td class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                        </tr>
						<?PHP
						$i++;
						$DetalleTodosdeTodos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="5"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP			
			}		
		
		 
?>
