
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
						
		$id_carrera		= $_REQUEST['id_carrera'];
		$Periodo		= $_REQUEST['Periodo'];		
		
	if($id_carrera==0){
				$Condicion = '';
			}else{
				$Condicion = ' AND  c.usuario ="'.$id_carrera.'"';
			}
		
		 $SQL_Datos='SELECT 
					
					c.idcorte,
					c.codigoperiodo,
					m.codigomateria,
					m.nombremateria,
					p.codigocarrera,
					p.nombrecortocarrera,
					c.fechainicialcorte,
					c.fechafinalcorte,
					c.porcentajecorte
					
					
					FROM 
					
					corte c INNER JOIN materia m ON c.codigomateria=m.codigomateria
							INNER JOIN carrera p ON p.codigocarrera=c.usuario
					
					WHERE 
					
					c.codigoperiodo ="'.$Periodo.'"'.$Condicion;
					
				if($C_Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL de los Datos ...<br>'.$SQL_Datos;
						die;
					}
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Codigo Materia</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Fecha Inicial</strong></th>
                    <th class="Titulos"><strong>Fecha Final</strong></th>
                    <th class="Titulos"><strong>Porcentaje</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
               </tr>     		
			<?PHP
				if(!$C_Datos->EOF){
					$i=1;
					while(!$C_Datos->EOF){
						/***************************************************************************/
						
						?>
                        <tr>
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $C_Datos->fields['nombrecortocarrera']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigomateria']?></td>
                            <td class="Borde_td"><?PHP echo $C_Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP FormatFecha($C_Datos->fields['fechainicialcorte'])?></td>
                            <td class="Borde_td" align="center"><?PHP FormatFecha($C_Datos->fields['fechafinalcorte'])?></td>
                            <td class="Borde_td" align="right"><?PHP echo $C_Datos->fields['porcentajecorte']?>&nbsp;%</td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigoperiodo']?></td>
                        </tr>
                        <?PHP
						/***************************************/
						/***************************************************************************/
						$i++;
						$C_Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="9" align="center"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP
	function FormatFecha($fecha){
		
		global $userid,$db;
		
		
			$D_Fecha = explode('-',$fecha);
			
			
			$D_Fecha[0];#Año
			$D_Fecha[1];#Mes
			$D_Fecha[2];#Dia
			
			$New_Fecha = $D_Fecha[2].'/'.$D_Fecha[1].'/'.$D_Fecha[0];
			
			echo $New_Fecha;
			
		}						
?>