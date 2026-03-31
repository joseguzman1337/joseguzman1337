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
						

		$id_modalidad			= $_GET['id_modalidad'];
		$Periodoini				= $_GET['Periodoini'];
		$Periodofin				= $_GET['Periodofin'];
		$id_carrera				= $_GET['id_carrera'];      
		$Tipo_Nota				= $_GET['Tipo_Nota'];
		$id_Materia				= $_GET['id_Materia'];
		$Nom_Materia			= $_GET['Nom_Materia'];
		
		/************Modalidad*******************/		
	
	$SQL_Modalidad='SELECT 

					codigomodalidadacademica as id,
					nombremodalidadacademica as nombre
					
					
					FROM 
					
					modalidadacademica
					
					WHERE
					
					codigoestado=100
					AND
					codigomodalidadacademica="'.$id_modalidad.'"';
					
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
						
						codigomodalidadacademica="'.$id_modalidad.'"
						AND
						codigocarrera="'.$id_carrera.'"';
						
					if($Carrera=&$db->Execute($SQL_Carrera)===false){
							echo 'Error en el SQL Carrera...<br>'.$SQL_Carrera;
							die;
						}
						
		/*************Tipo Nota******************/	 
		
		 $SQL_TipoNota='SELECT 

							codigotiponotahistorico,   
							nombretiponotahistorico
							
							FROM tiponotahistorico
							
							WHERE
							
							codigotiponotahistorico="'.$Tipo_Nota.'"';
		
		if($D_TipoNota=&$db->Execute($SQL_TipoNota)===false){
				echo 'Error en el SQL Tipo Nota...<br>'.$SQL_TipoNota;
				die;
			}
			
		/*****************Materia************************/	
		
		 $SQL_Materia='SELECT 
    
						codigomateria,
						nombremateria
						
						FROM 
						
						materia
						
						WHERE
						
						codigomateria="'.$id_Materia.'"';
						
				if($Materia=&$db->Execute($SQL_Materia)===false){
						echo 'Error en el SQL MAteria....<br>'.$SQL_Materia;
						die;
					}		
		
	?>	
    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
    	<tr>
        	<th><strong>Modalidad Academica</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $Modalidad->fields['nombre']?></strong></th>
            <th>&nbsp;</th>
            <th><strong>Periodo Inicial</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $Periodoini?></strong></th>
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
            <th><strong><?PHP echo utf8_decode($NomCarrera);?></strong></th>
            <th>&nbsp;</th>
            <th><strong>Periodo Final</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo $Periodofin?></strong></th>
        </tr>
        <?PHP 
			if($id_Materia==0){
					$MateriaNom = 'Todas.';
				}else if($id_Materia!=0){
						$MateriaNom = $Materia->fields['nombremateria'];
					}
					
			if($Tipo_Nota==0){
					$NomNota='Todas.';
				}else if($Tipo_Nota!=0){
						$NomNota=$D_TipoNota->fields['nombretiponotahistorico'];
					}		
		?>
         <tr>
        	<th><strong>Materia</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo utf8_decode($MateriaNom);?></strong></th>
            <th>&nbsp;</th>
            <th><strong>Tipo Nota</strong></th>
            <th>&nbsp;</th>
            <th><strong><?PHP echo utf8_decode($NomNota);?></strong></th>
        </tr>
    </table>
    <br />	
	<?PHP	
	
			if($id_carrera==0 && $Tipo_Nota!=0 && $id_Materia!=0){
					/*Todas las Carreras*/
					DetalleTodasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota,$id_Materia,$Nom_Materia);
				}
				
			if($Tipo_Nota==0 && $id_carrera!=0 && $id_Materia!=0){
					/*Todas las Notas*/
					DetalleTodasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$id_Materia);
				}	
			
			if($id_carrera!=0 && $Tipo_Nota!=0 && $id_Materia!=0){
					/*Una Carrera especifica y una Nota Especifica*/
					DetalleGenral($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia);
				}
			
			if($id_Materia==0 && $id_carrera!=0 && $Tipo_Nota!=0){
					/*Todas las Materias*/
					
					DeatlleTodasMaterias($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota);
				}
			
			if($id_Materia==0 && $id_carrera==0 && $Tipo_Nota!=0){
					/*Todas las Materias y Todas las Carreras*/
					
					TodasMateriasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota);
				}
							
			if($id_Materia==0 && $id_carrera!=0 && $Tipo_Nota==0){
					/*Todas las Materias Y todas las Notas*/
					
					TodasMateriasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera);
				}
				
			if($id_Materia!=0 && $id_carrera==0 && $Tipo_Nota==0){
					/*Todas la Carreras Y todas Las Notas*/
					
					TodasCarrerasNotas($id_modalidad,$Periodoini,$Periodofin,$id_Materia);
				}	
			
			if($id_Materia==0 && $id_carrera==0 && $Tipo_Nota==0){
					/*Todos de Todos*/
					TodasTodos($id_modalidad,$Periodoini,$Periodofin);
				}		 
				
	/***********************************************************************************************************/			
	
	function DetalleTodasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota,$id_Materia,$Nom_Materia){
			
			global $userid,$db;
			
			/*
			
			//->Busca Datos De todas las Carreras con Un Tipo de nota Unico y  una materia especifica
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
                        trf.nombretipoestudianterecursofinanciero
						FROM
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                        INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.nombremateria="'.$Nom_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}		
			
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="9" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP
			
		}				
	function DetalleTodasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De todas las Notas Con Carrera y Materia Unica
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
                        trf.nombretipoestudianterecursofinanciero					
						FROM 
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="9" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
		
		}
	function DetalleGenral($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todos los datos con datos Especificos
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
                        trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}
	function DeatlleTodasMaterias($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota){
			
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias Con Carrera Unica Y un Tipo de Nota UNico
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		} 
	function TodasMateriasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias con todas las Carreras Y un Tipo de Nota UNico
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			 $SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral'; 
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financieros</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
			
		}
	function TodasMateriasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias con todas las Notas y unica Carrera
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo @$Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
	
		}	
	function TodasCarrerasNotas($id_modalidad,$Periodoini,$Periodofin,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Carreras y Todas las Notas con Una Materia Definidad
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();   
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}
		function TodasTodos($id_modalidad,$Periodoini,$Periodofin){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Carreras y Todas las Notas con Una Materia Definidad
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						
						?>
                        <tr>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombresestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['apellidosestudiantegeneral'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombrecarrera'])?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombremateria'])?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['nombretiponotahistorico'])?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo @$Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo utf8_decode($Datos->fields['observacionnotahistorico'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();   
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}	
?>
