<?PHP 
class ViewInvestigacion{
	public function Principal(){
		global $userid,$db;
		?>
        <script type="text/javascript">
			$(function() {
				$( "#tabs" ).tabs({
				beforeLoad: function( event, ui ) {
					ui.jqXHR.error(function() {
						ui.panel.html(
						"Ocurrio un problema cargando el contenido." );
						});
					}
				});
						$("#tabs").tabs({ cache:true });
						//$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
						//$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
						
						$("#tabs").plusTabs({
					className: "plusTabs", //classname for css scoping
					seeMore: true,  //initiate "see more" behavior
					seeMoreText: "Ver más formularios", //set see more text
					showCount: true, //show drop down count
					expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
					dropWidth: "auto", //width of dropdown
					sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
				});
			});
		</script>
		<style>
			.td_Class{border:#FFF 1px solid;}
		</style>
		<div id="tabs" class="dontCalculate">
            <ul>
                <li><a href="#tabs-1">Grupos de investigación </a></li>
                <li><a href="#tabs-2">Proyectos de Investigación <br/>(convocatorias internas) </a></li>
                <li><a href="#tabs-3">Financiación de proyectos a través de entidades externas</a></li>
                <li><a href="#tabs-4">Proyectos presentados y aprobados en Colciencias</a></li>
                <li><a href="#tabs-5">Publicaciones periódicas de la Universidad </a></li>
                <li><a href="#tabs-6">Número de Semilleros </a></li>
            </ul>
         <!--Div Contenedores-->   
            <div id="tabs-1">
				<form id="From_1">
				<?PHP $this->ViewGruposInvestigacion('From_1');?>
                </form>
            </div>
            <div id="tabs-2">
            	<form id="From_2">
                <?PHP $this->ViewProyectosInvestigacion('From_2');?>
                </form>
            </div>
            <div id="tabs-3">
            	<form id="From_3">
                <?PHP $this->ViewFinanciacion('From_3');?>	
                </form>
            </div>
            <div id="tabs-4">
            	<form id="From_4">
                <?PHP $this->ViewProyectosPresentados('From_4')?>	
                </form>
            </div>
            <div id="tabs-5">
            	<form id="From_5">
                <?PHP $this->ViewPublicaciones('From_5')?>
                </form>
            </div>
            <div id="tabs-6">
            	<form id="From_6">
                <?php $this->ViewSemilleros('From_6');?>
                </form>
            </div>
          <!--Div Contenedores-->   
        </div>
        <?PHP
		}//public function Principal
	public function ViewGruposInvestigacion($From,$Fecha){
		global $userid,$db;
		
		  $SQL='SELECT 

						periosidaanual AS Year
				
				FROM 
				
						clasificacioncolciencias
				
				WHERE
				
						codigoestado=100
						
				GROUP BY periosidaanual';
						
			if($Year=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}			
		
		?>
        <div id="Cargar">
        <fieldset>   
            <legend>Grupos de investigación</legend>
            <?PHP 
				$this->SelectBox($Year,$From,$Fecha,'ViewGruposInvestigacion');   
				$this->DatosUno($Fecha);
				$this->DatosDos($Fecha);
				$this->DatosTres($Fecha);
			?>
        </fieldset>
        </div>
        <?PHP
		}//public function ViewGruposInvestigacion
	public function SelectBox($Consulta,$From,$Fecha='',$Case){
		global $db,$userid;
		
		?>
        <table border="0" width="92%" align="center" class="formData" >
			<thead>   
				<tr class="dataColumns">
					<th class="column">Seleccione A&ntilde;o</th>
                    <th class="column">
                    	<select id="Year" name="Year" onchange="Buscar('<?PHP echo $From?>','<?PHP echo $Case?>')">
                        	<option value="-1"><?PHP echo $Fecha?></option>
                            <?PHP 
							while(!$Consulta->EOF){
								if($Fecha!=$Consulta->fields['Year']){
								?>
                                <option value="<?PHP echo $Consulta->fields['Year']?>"><?PHP echo $Consulta->fields['Year']?></option>
                                <?PHP
								}
								$Consulta->MoveNext();
								}	
							?>
                        </select>
                    </th>
                </tr>
            </thead>
         </table>           
        <?PHP
		}		
	public function DatosUno($Fecha){
		global $db,$userid;
		
			  $SQL='SELECT 

							id,
							sin_clasificacion,
							clasificacion_ueb
					
					FROM 
					
							clasificacioncolciencias
					
					WHERE
					
							periosidaanual="'.$Fecha.'"
							AND
							codigoestado=100';
							
				if($Datos=&$db->Execute($SQL)===false){
						echo 'Error en el SQl ....<br><br>'.$SQL;
						die;
					}			
		
			$Titulos		= array();
			
			$Titulos['Titulo']			= 'Grupos de investigación';
			$Titulos['Sub_Titulo']		= 'Clasificación Colciencias año 2010';
			$Titulos['Sub_Titulo_Dos']	= 'N&deg; de Grupos';
			
			$Labes			= array();
			
			$Labes[0]		= 'Grupos Reconocidos COLCIENCIAS';
			$Labes[1]		= 'Grupos avalados por la UEB sin reconocimiento';
			
			$Data			= array();
			
			$Data[0]		= $Datos->fields['sin_clasificacion'];
			$Data[1]		= $Datos->fields['clasificacion_ueb'];
			
			$this->Tabla($Titulos,$Labes,$Data);
		}//public function DatosUno	
	public function DatosDos($Fecha){
		global $db,$userid;
		
			  $SQL='SELECT 

					id,
					clasificacion,
					clasificacion_nacional
					
					FROM 
					
					relaciongrupos
					
					WHERE
					
					periosidaanual="'.$Fecha.'"
					AND
					codigoestado=100';  
					
			if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}		
		
			$Titulos		= array();
			
			$Titulos['Titulo']			= 'Grupos de investigación';
			$Titulos['Sub_Titulo']		= 'Grupos Investigación UEB a nivel Nacional';
			$Titulos['Sub_Titulo_Dos']	= 'N&deg; de Grupos';
			
			$Labes			= array();
			
			$Labes[0]		= 'Grupos de Investigación de la Universidad reconocidos por Colciencias';
			$Labes[1]		= 'Número total de grupos reconocidos por Colciencias';
			
			$Data			= array();
			
			$Data[0]			= $Datos->fields['clasificacion'];
			$Data[1]			= $Datos->fields['clasificacion_nacional'];
			
			$this->Tabla($Titulos,$Labes,$Data);
		}//public function DatosDos	
	public function DatosTres($Fecha){
		global $db,$userid;
		
			$SQL='SELECT 

							id,
							CienciasSalud,
							CienciasSociales,
							Ingenierias,
							letrasArtes
					
					FROM 
					
							areasconocimientocolciencias
					
					WHERE
					
							codigoestado=100
							AND
							periosidaanual="'.$Fecha.'"';
			
			if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>';
					die;
				}				
							
			$Titulos		= array();
			
			$Titulos['Titulo']			= 'Grupos de Investigación de la Universidad El Bosque por Áreas del Conocimiento';
			$Titulos['Sub_Titulo']		= 'Área del Conocimiento';
			$Titulos['Sub_Titulo_Dos']	= 'N&deg; de Grupos';
			
			$Labes			= array();
			
			$Labes[0]		= 'Ciencias Naturales y de la Salud';
			$Labes[1]		= 'Ciencias Sociales y Humanidades';
			$Labes[2]		= 'Ingeniería y Administración';
			$Labes[3]		= 'Arte y Diseño';
			
			$Data			= array();
			
			$Data[0]			= $Datos->fields['CienciasSalud'];
			$Data[1]			= $Datos->fields['CienciasSociales'];
			$Data[2]			= $Datos->fields['Ingenierias'];
			$Data[3]			= $Datos->fields['letrasArtes'];
			
			$this->Tabla($Titulos,$Labes,$Data);
		}//public function DatosTres			
	public function Tabla($Titulo,$Label,$Data){
		?>
		<table border="0" width="92%" align="center" class="formData" >
			<thead>   
				<tr class="dataColumns">
					<th class="column" colspan="2"><span><?PHP echo $Titulo['Titulo']?></span></th>                                    
				</tr>
				<tr class="dataColumns category">
					<th class="column" ><span><?PHP echo $Titulo['Sub_Titulo']?></span></th>
					<th class="column center" ><span><?PHP echo $Titulo['Sub_Titulo_Dos']?></span></th>
				</tr>
			</thead>
			<tbody>
			<?PHP 
                for($i=0;$i<count($Label);$i++){
                    /******************************/
                    $this->Campo($Data[$i],$Label[$i],$Op=1);
                    /******************************/
                    }
            ?>
			</tbody>
		</table>
		<?PHP
		}//public function Tabla
	public function Campo($Valor,$Label_1,$Op=''){
		
		?>
		<tr class="dataColumns">
        	<?PHP 
			if($Op==0){
			?>
			<th class="column" >&nbsp;&nbsp;<strong>*</strong> <?PHP echo $Label_1?>&nbsp;&nbsp;</th>
            <?PHP 
			}else{
			?>
			<td class="column" >&nbsp;&nbsp;<strong>*</strong> <?PHP echo $Label_1?>&nbsp;&nbsp;</td>
            <?php	
			}?>
			<td class="column center" ><?PHP echo $Valor?></td>
		</tr>	
		<?PHP
		}//public function Campo
	public function ViewProyectosInvestigacion($From,$Fecha){
		global $userid,$db;
		
		  $SQL='SELECT 

				periodoanual AS Year
				
				FROM 
				
				convocatoriasinternas
				
				WHERE
				
				codigoestado=100
				
				GROUP BY periodoanual';
						
			if($Year=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}	
				
		?>
        <div id="Cargar">
        <fieldset>   
            <legend>Proyectos de Investigación aprobados en las convocatorias internas</legend>
            <?PHP 
			$Label		= array();
			
			$Label[0]					='Año (Vr. Aprobado por la UEB)';
			$Label[1]					='Número de proyectos';
			$Label[2]					='Presentados';
			$Label[3]					='Aprobados';
			$Label[4]					='Finalizados';
			$Label[5]					='Valor ($)';
			
				$this->SelectBox($Year,$From,$Fecha,'ViewProyectosInvestigacion'); 
				$this->DatosCuatro($Fecha,$Label,'convocatoriasinternas');  
			?>
        </fieldset>
        </div>
        <?PHP
		}//public function ViewProyectosInvestigacion
	public function DatosCuatro($Fecha,$Label,$Tabla){
		global $userid,$db;
		?>
        <table brder="0" width="90%" align="center" class="formData last" >
            <thead>   
                <tr>
                    <th><?PHP echo $Label[0]?></th>
                    <th>
                        <table border="1" align="center" width="100%">
                            <tr>
                                <th colspan="6" style="border:#90A860 1px solid"><?PHP echo $Label[1]?></th>
                            </tr>
                            <tr>
                                <th style="border:#90A860 1px solid" colspan="6">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <th align="center" style="border:#90A860 1px solid"><strong><?PHP echo $Label[2]?></strong></th>
                                            <th align="center" style="border:#90A860 1px solid"><strong><?PHP echo $Label[3]?></strong></th>
                                            <th align="center" style="border:#90A860 1px solid"><strong><?PHP echo $Label[4]?></strong></th>
                                            <th align="center" style="border:#90A860 1px solid"><strong><?PHP echo $Label[5]?></strong></th>
                                        </tr>
                                    </table>	
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
            </thead>   
            <tbody>
              <?PHP $this->TablaAnual('Nacional',1,$Fecha,$Tabla);?> 
              <?PHP $this->TablaAnual('Internacional',2,$Fecha,$Tabla);?>  
          </tbody>	
        </table>
        <?PHP
		}//public function DatosCuatro
	public function Dinamico($Data){
		global $db,$userid;
		
		while(!$Data->EOF){
			if($Data->fields['Dato_1']){ $Dato_1	= $Data->fields['Dato_1'];}else{$Dato_1	= 0;}
			if($Data->fields['Dato_2']){ $Dato_2	= $Data->fields['Dato_2'];}else{$Dato_2	= 0;}
			if($Data->fields['Dato_3']){ $Dato_3	= $Data->fields['Dato_3'];}else{$Dato_3	= 0;}
			if($Data->fields['Dato_4']){ $Dato_4	= $Data->fields['Dato_4'];}else{$Dato_4	= 0;}
			?>
            <tr>
                <th>&nbsp;<strong><?PHP echo $Data->fields['Dato_5']?></strong>&nbsp;</th>
                <td class="column center">
                    <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                        <tr>
                            <td style="border:#FFF solid 1px" align="center">
                                <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                                    <tr>
                                        <td  class="column center" style="border:#FFF solid 1px" align="center"><?PHP echo $Dato_1?></td>
                                        <td class="column center" style="border:#FFF solid 1px" align="center"><?PHP echo $Dato_2?></td>
                                        <td class="column center" style="border:#FFF solid 1px" align="center"><?PHP echo $Dato_3?></td>
                                        <td class="column center" style="border:#FFF solid 1px" align="center"><?PHP echo $Dato_4?></td>
                                    </tr>
                                </table>	
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?PHP
			$Data->MoveNext();
			}
	}//public function Dinamico	
	public function TablaAnual($Name,$tipo,$Fecha,$Tabla){
		global $db,$userid;
		?>
         <tr>
            <th><?PHP echo $Name?></th>
            <th colspan="4">&nbsp;</th>
         </tr>
        <?PHP 
            
         $SQL='SELECT 

						presentados AS Dato_1,
						aprobados   AS Dato_2,
						finalizados AS Dato_3,
						valor       AS Dato_4,
						year        AS Dato_5
				
				FROM 
				
						'.$Tabla.'
				
				WHERE
				
						tipo="'.$tipo.'"
						AND
						codigoestado=100
						AND
						periodoanual="'.$Fecha.'"';
						
			if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQL...<br><br>'.$SQL;
					die;
				}	
						
       		$this->Dinamico($Datos);
		}	
	public function ViewFinanciacion($From,$Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

				periodoanual AS Year
				
				FROM 
				
				convocatoriasexternas
				
				WHERE
				
				codigoestado=100
				
				GROUP BY periodoanual';
				
			if($Year=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}		
		
		?>
        <div id="Cargar">
        <fieldset>   
            <legend>Proyectos de Investigación aprobados en las convocatorias internas</legend>
            <?PHP 
			$Label		= array();
			
			$Label[0]					='';
			$Label[1]					='Número de proyectos';
			$Label[2]					='Presentados';
			$Label[3]					='Aprobados';
			$Label[4]					='Finalizados';
			$Label[5]					='Valor ($)';
			
				$this->SelectBox($Year,$From,$Fecha,'ViewFinanciacion'); 
				$this->DatosCuatro($Fecha,$Label,'convocatoriasexternas');  
			?>
        </fieldset>
        </div>
        <?PHP
		}//public function ViewFinanciacion	
	public function ViewProyectosPresentados($From,$Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

				periosidaanual AS Year
				
				FROM 
				
				proyectospresentadosaprobados
				
				WHERE
				
				codigoestado=100
				
				GROUP BY periosidaanual';
				
			if($Year=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}			
		?>
         <div id="Cargar">
         <fieldset>   
            <legend>Proyectos presentados y aprobados en Colciencias</legend>
            <?PHP 
			$this->SelectBox($Year,$From,$Fecha,'ViewProyectosPresentados'); 
			$this->DatoCinco($From,$Fecha);
			?>
         </fieldset>
         </div>   
        <?PHP
		}//public function ViewProyectosPresentados	
	public function DatoCinco($From,$Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

						presentados,
						presentadonivelnacional,
						aprobados,
						aprobadosnivelnacional
				
				FROM 
				
						proyectospresentadosaprobados
				
				WHERE
				
						codigoestado=100
						AND
						periosidaanual="'.$Fecha.'"';
						
			if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}		
					
		
		$Labes			= array();
		
		$Labes[0]		= 'Número de proyectos presentados por la Institución a COLCIENCIAS';
		$Labes[1]		= 'Número de proyectos presentados COLCIENCIAS a nivel Nacional';
		$Labes[2]		= 'Índice presentados Institución/ presentados Nacional';
		$Labes[3]		= 'Número de proyectos Aprobados  por la Institución a COLCIENCIAS';
		$Labes[4]		= 'Número de proyectos Aprobados COLCIENCIAS a nivel Nacional';
		$Labes[5]		= 'Índice Aprobados Institución/ aprobados Nacional';
		
		$Data			= array();
		
		$Data[0]			= $Datos->fields['presentados'];
		$Data[1]			= $Datos->fields['presentadonivelnacional'];
		$Data[2]			= number_format($Datos->fields['presentados']/$Datos->fields['presentadonivelnacional'],'2','.',',');
		$Data[3]			= $Datos->fields['aprobados'];
		$Data[4]			= $Datos->fields['aprobadosnivelnacional'];
		$Data[5]			= number_format($Datos->fields['aprobados']/$Datos->fields['aprobadosnivelnacional'],'2','.',',');
		
		?>
         <table border="0" width="92%" align="center" class="formData" >
            <thead>
                <tr>
                    <th>Proyectos presentados</th>
                    <th>N&deg; de Grupos</th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
                for($i=0;$i<count($Labes);$i++){
                    /******************************/
					$Op='';
					if($i==2 || $i==5){$Op=0;}else{$Op=1;}
                    $this->Campo($Data[$i],$Labes[$i],$Op);
                    /******************************/
                    }
            ?>
            </tbody>
         </table>
        <?PHP
		}		
	public function ViewPublicaciones($From,$Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

				periosidaanual AS Year
				
				FROM 
				
				publicacionesperiodicas
				
				WHERE
				
				codigoestado=100
				
				GROUP BY periosidaanual';
				
			if($Year=&$db->Execute($SQL)===false){
				echo 'Error en el SQl ...<br><br>'.$SQL;
				die;
			}		
		
		?>
        <div id="Cargar">
        <fieldset>   
            <legend>Publicaciones periódicas de la Universidad</legend>
            <?PHP 
			$this->SelectBox($Year,$From,$Fecha,'ViewPublicaciones');  
			$this->InfoPublicaciones($Fecha);
			?>
        </fieldset>
        </div>    
        <?PHP
		}//public function ViewPublicaciones
	public function InfoPublicaciones($Fecha){
		global $db,$userid;
		
		$SQL='SELECT 

						publicacionesperiodicas_id,
						indexadas, 
						no_indexada
				
				FROM 
				
						publicacionesperiodicas
				
				WHERE
				
						codigoestado=100
						AND
						periosidaanual="'.$Fecha.'"';
						
				if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}				
		
		$Labes			= array();
		
		/*$Labes[0]		= 'Indexada Categoría A1 de Colciencias';
		$Labes[1]		= 'Indexada Categoría A2 de Colciencias';
		$Labes[2]		= 'Indexada Categoría B de Colciencias';
		$Labes[3]		= 'Indexada Categoría C de Colciencias (vigentes)';
		$Labes[4]		= 'En proceso de Indexación';*/
                $Labes[0]		= 'Indexada';
		$Labes[1]		= 'No indexada';
		
		$Data			= array();
		
		/*$Data[0]		= $Datos->fields['categoria_a1'];
		$Data[1]		= $Datos->fields['categoria_a2'];
		$Data[2]		= $Datos->fields['categoria_b'];
		$Data[3]		= $Datos->fields['categoria_c'];
		$Data[4]		= $Datos->fields['indexacion'];*/
		$Data[0]		= $Datos->fields['indexadas'];
		$Data[1]		= $Datos->fields['no_indexada'];
		
		$Nombre			= array();
		
		$Nombre[0]		= 'Clasificación de publicaciones Colciencias';
		$Nombre[1]		= 'Número de Revistas';
		
		$this->DatosSeis($Labes,$Data,$Nombre);
		
		}//public function InfoPublicaciones		
	public function DatosSeis($Labes,$Data,$Nombre){
		global $db,$userid;
		  
		?>
        <table border="0" width="92%" align="center" class="formData" >
            <thead>
                <tr>
                <?PHP 
					for($j=0;$j<count($Nombre);$j++){
						?>
                        <th><?PHP echo $Nombre[$j]?></th>
                        <?PHP
						}
				?>
                </tr>
            </thead>
            <tbody>
             <?PHP 
                for($i=0;$i<count($Labes);$i++){
                    /******************************/
                    $this->Campo($Data[$i],$Labes[$i],$Op=1);
                    /******************************/
                    }
            ?>
            </tbody>
         </table>   
        <?PHP
		}//public function DatosSeis	
	public function ViewSemilleros($From,$Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

				periosidaanual AS Year
				
				FROM 
				
				semillerosinvestigacion
				
				WHERE
				
				codigoestado=100
				
				GROUP BY periosidaanual';
				
			if($Year=&$db->Execute($SQL)===false){
				echo 'Error en el SQl ...<br><br>'.$SQL;
				die;
			}	
		?>
        <div id="Cargar">
        <fieldset>   
            <legend>Número de Semilleros</legend>
            <?PHP 
			$this->SelectBox($Year,$From,$Fecha,'ViewSemilleros');  
			$this->InfoSemilleros($Fecha);
			?>
        </fieldset>
        </div>    
        <?PHP		
		}//public function ViewSemilleros	
	public function InfoSemilleros($Fecha){
		global $db,$userid;
		
		  $SQL='SELECT 

				s.semillerosinvestigacion_id,
				s.carrera_id,
				s.num_semillero,
				c.codigocarrera,
				c.nombrecarrera
				
				FROM 
				
				semillerosinvestigacion s INNER JOIN carrera c ON c.codigocarrera=s.carrera_id
				
				WHERE
				
				s.codigoestado=100
				AND
				s.periosidaanual="'.$Fecha.'"';
						
				if($Datos=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ...<br><br>'.$SQL;
					die;
				}	
				
		$Labes			= array();	
		$Data			= array();	
							
		$i=0;
		while(!$Datos->EOF){
			/*****************************************/
			$Labes[$i]		= $Datos->fields['nombrecarrera'];
		
		    $Data[$i]		= $Datos->fields['num_semillero'];
			/*****************************************/
			$Datos->MoveNext();
			$i++;
			}
		
		$Nombre			= array();
		
		$Nombre[0]		= 'Programas';
		$Nombre[1]		= 'Número de Semilleros';
		
		$this->DatosSeis($Labes,$Data,$Nombre);
		}//public function InfoSemilleros	
	}//Class
?>