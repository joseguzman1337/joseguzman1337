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
            <th colspan="4">&nbsp;</th>
        </tr>
    </table>
    <br />	
	<?PHP		 
		
		if($id_carrera==0){
				##Buscar solo Por Todas las Carreras
				TodasCarreras($id_Movilidad,$Periodo);
			}
		if($id_carrera!=0){
				##Busqueda Detallada
				BuscarDetallada($id_Movilidad,$Periodo,$id_carrera);
			}	
			
	
  function BuscarDetallada($id_Movilidad,$Periodo,$id_carrera){
		
		global $userid,$db;
		
		$SQL_Datos='SELECT 

					fechacortenotas  AS CorteNotas,
					fechacargaacademica  AS CargaAcademica,
					fechainicialprematricula  AS IniPrematricula,
					fechafinalprematricula  AS FinPrematricula,
					fechainicialpostmatriculafechaacademica  AS iniPos,
					fechafinalpostmatriculafechaacademica  AS finPos,
					fechainicialprematriculacarrera AS iniPre,
					fechafinalprematriculacarrera AS finPre,
					fechainicialretiroasignaturafechaacademica AS iniRetiros,
					fechafinallretiroasignaturafechaacademica AS finRetiros,
					fechainicialentregaordenpago AS iniEntrega,
					fechafinalentregaordenpago AS finEntrega,
					fechafinalordenpagomatriculacarrera As finOrden,
					codigocarrera
					
					FROM 
					
					fechaacademica 
					
					WHERE 
					
					codigoperiodo ="'.$Periodo.'" 
					AND 
					codigocarrera ="'.$id_carrera.'"';
					
				if($Detalle=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL De los Datos del Detalle...<br>'.$SQL_Datos;
						die;
					}		
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Fecha Corte Notas</strong></th>	
                    <th class="Titulos"><strong>Fecha Carga Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Finall Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Orden de Pago Matricula Carrera</strong></th>	
                </tr>
             <?PHP 
			 	if(!$Detalle->EOF){
					
					$i=1;
					
					while(!$Detalle->EOF){
						
						 $SQL_Carrera='SELECT 

										codigocarrera,
										nombrecarrera
										
										FROM 
										
										carrera
										
										WHERE
										
										codigocarrera="'.$Detalle->fields['codigocarrera'].'"';			
										
										
								if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
										echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
										die;
									}	
						
						?>
                        <tr>
                           <td align="center" class="Borde_td"><?PHP echo $i?></td>
                           <td align="center" class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['CorteNotas'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['CargaAcademica'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['IniPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['FinPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['iniPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['finPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['iniPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['finPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['iniRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['finRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['iniEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['finEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Detalle->fields['finOrden'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Detalle->MoveNext();
						}
					
					}			 
			 ?>   
            </table>    	
			<?PHP
		}	
	 function FormatFecha($fecha){
		
		global $userid,$db;
		
		
			$D_Fecha = explode('-',$fecha);
			
			
			$D_Fecha[0];#Año
			$D_Fecha[1];#Mes
			$D_Fecha[2];#Dia
			
			$New_Fecha = $D_Fecha[2].'/'.$D_Fecha[1].'/'.$D_Fecha[0];
			
			echo $New_Fecha;
			
		}
	function TodasCarreras($id_Movilidad,$Periodo){
		
			global $userid,$db;
			
			 $SQL_Datos='SELECT 

						f.fechacortenotas  AS CorteNotas,
						f.fechacargaacademica  AS CargaAcademica,
						f.fechainicialprematricula  AS IniPrematricula,
						f.fechafinalprematricula  AS FinPrematricula,
						f.fechainicialpostmatriculafechaacademica  AS iniPos,
						f.fechafinalpostmatriculafechaacademica  AS finPos,
						f.fechainicialprematriculacarrera AS iniPre,
						f.fechafinalprematriculacarrera AS finPre,
						f.fechainicialretiroasignaturafechaacademica AS iniRetiros,
						f.fechafinallretiroasignaturafechaacademica AS finRetiros,
						f.fechainicialentregaordenpago AS iniEntrega,
						f.fechafinalentregaordenpago AS finEntrega,
						f.fechafinalordenpagomatriculacarrera As finOrden,
						f.codigocarrera
						
						FROM    
						
						fechaacademica f INNER JOIN carrera c ON f.codigocarrera=c.codigocarrera 
						
						WHERE 
						
						f.codigoperiodo ="'.$Periodo.'" 
						AND
						c.codigomodalidadacademica="'.$id_Movilidad.'"';
						
					if($Todas=&$db->Execute($SQL_Datos)===false){
							echo 'Error en el SQl de Todas LAs Fecha Pra Todas LAs Carreras...<br>'.$SQL_Datos;
							die;
						}	
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Fecha Corte Notas</strong></th>	
                    <th class="Titulos"><strong>Fecha Carga Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Finall Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Orden de Pago Matricula Carrera</strong></th>	
                </tr>
             <?PHP 
			 	if(!$Todas->EOF){
					
					$i=1;
					
					while(!$Todas->EOF){
						
						 $SQL_Carrera='SELECT 

										codigocarrera,
										nombrecarrera
										
										FROM 
										
										carrera
										   
										WHERE
										
										codigocarrera="'.$Todas->fields['codigocarrera'].'"';			
										
										
								if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
										echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
										die;
									}	
						
						
						?>
                        <tr>
                           <td align="center" class="Borde_td"><?PHP echo $i?></td>
                           <td align="center" class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['CorteNotas'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['CargaAcademica'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['IniPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['FinPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['iniPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['finPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['iniPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['finPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['iniRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['finRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['iniEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['finEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP FormatFecha($Todas->fields['finOrden'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Todas->MoveNext();  
						}
					
					}			 
			 ?>   
            </table>    	
			<?PHP
		}				
		       
			
?>
