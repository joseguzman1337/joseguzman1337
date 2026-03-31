<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   include('instrumento_publico_class.php');     
   $C_Insturmneto = new Insturmneto();
   global $db;
   
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
  
  
   
   if (!empty($_REQUEST['id_instrumento'])){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $id_instrumento=str_replace('row_','',$_REQUEST['id_instrumento']);
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion = ".$id_instrumento."";
   //  $entity->debug = true;
    $data = $entity->getData();
	//echo '<pre>';print_r($data);
    $data =$data[0];
    
    $Fecha_ini = explode(' ',$data['fecha_inicio']);
    $Fecha_fin = explode(' ',$data['fecha_fin']);
    
    if($Fecha_ini[0]<=date('Y-m-d')){
        $D_Fecha    = 'disabled="disabled"';
    }else{
        $D_Fecha    = '';
    }
    //echo '<pre>';print_r($F);
    /*$entity1 = new ManagerEntity("Apublicoobjetivo");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion = ".str_replace('row_','',$_REQUEST['id_instrumento'])."";
   //  $entity->debug = true;
    $data1 = $entity1->getData();
	//echo '<pre>';print_r($data1);
    $data1 =$data1[0];*/
	/**********************************/
	
	$SQL='SELECT * FROM siq_Apublicoobjetivo WHERE idsiq_Ainstrumentoconfiguracion="'.str_replace('row_','',$_REQUEST['id_instrumento']).'"  AND  codigoestado=100';
	
	if($Consulta=&$db->Execute($SQL)===false){
			echo 'Error en el SQL <br><br>'.$SQL;
			die;
		}
		
	$C_Data	= $Consulta->GetArray();	
    
	//echo '<pre>';print_r($C_Data);

    if($C_Data[0]['obligar']==1){
       $C_Obligar = 'checked="checked"'; 
    }else if($C_Data[0]['obligar']==0){
        $C_Obligar = '';
    }else {
      $C_Obligar = 'checked="checked"';   
    }
	
	/*********************************/
   }
   $id_in=str_replace('row_','',$_REQUEST['id_instrumento']);
  
  
  
?>
  
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script>
bkLib.onDomLoaded(function() {
        //new nicEditor({contenteditable : false}).panelInstance('titulo');
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
    });
    
    $(function() {
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter .connectedSortable');
			$("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .connectedSortable");
    });
    
    
      $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });
    
     $(function() {
        $( "#tabs" ).tabs();
    });
    
 </script>

  
    <form action="save.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apublicoobjetivo">
        <input type="hidden" name="idsiq_Apublicoobjetivo" id="idsiq_Apublicoobjetivo" value="<?php echo $C_Data[0]['idsiq_Apublicoobjetivo'] ?>">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="aprobada" id="aprobada" value="<?php echo $data['aprobada']; ?>">
        
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Instrumento</legend>
        <div>
            <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="nombre" name="nombre"><?php echo $data['nombre']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span style="color:red; font-size:9px">(*)</span>Fecha Inicio:</label></td>
                                <td>
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $data['fecha_inicio']; ?>" />
                                </td>
                                <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Fecha Fin:</label></td>
                                <td><input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $data['fecha_fin']; ?>" />
                                </td>
                                
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Estado:</label></td>
                                <td>
                                    <select id="estado" name="estado">
                                    <option value=""  >-Seleccione-</option>
                                        <option value="1" <?php if($data['estado']==1) echo "selected"; ?>>Activa</option>
                                        <option value="2" <?php if($data['estado']==2) echo "selected"; ?>>Inactiva</option>
                                    </select>
                                </td>
                                <td><label for="obligatoria"><span></span>Utiliza Secciones:</label></td>
                                <td>
                                    <input type="checkbox" name="secciones" id="secciones" tabindex="6" title="Secciones" value="1" <?php if($data['secciones']==1) echo "checked"; ?>  />
                                </td>
                                    
                            </tr>
                            <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS nombre, ' ' AS idsiq_discriminacionIndicador union 
                                                      SELECT nombre, idsiq_discriminacionIndicador
                                                      FROM siq_discriminacionIndicador where codigoestado=100 order by idsiq_discriminacionIndicador";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_discriminacionIndicador',$data['idsiq_discriminacionIndicador'],false,false,1,' id="idsiq_discriminacionIndicador" tabindex="15"  ');
                                    ?>
                                </td>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <?php //echo 'CodigoCarrera-->'.$data['codigocarrera'];
                                        $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                                        $reg_carrera = $db->Execute($query_carrera);
                                        echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="codigocarrera" tabindex="15" style="width:250px;" ');
                                    ?>
                                </td>
                                <td></td>
                                <td>
                                    
                                </td>  
                            </tr>
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Periodicidad:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS periodicidad, ' ' AS idsiq_periodicidad union 
                                                      SELECT periodicidad, idsiq_periodicidad
                                                      FROM siq_periodicidad where codigoestado=100 order by idsiq_periodicidad";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_periodicidad',$data['idsiq_periodicidad'],false,false,1,' id="idsiq_periodicidad" tabindex="15"  ');
                                    ?>
                                </td>
                                <td><label>Visualizar Instrumento:</label></td>
                                <td>
                                    <div class="derecha">
                                        <a href="instrumento_visualizar.php?aprobar=1&id_instrumento=<?php echo $id_in ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=500,height=800,scrollbars=yes'); return false;">Visualizar Instrumento</a>
                                           <!-- <a href="instrumento_visualizar.php?id_instrumento=<?php //echo $id ?>" target="_blank" class="submit" >Visualizar Instrumento</a>-->
                        
                                    </div><!-- End demo -->
                                </td>
                                    
                            </tr>
                          <!--  <tr>
                            <td valign="top"><label for="descripcion">Bienvenida:</label></td>
                                <td>
                                    <div id="mostrar_bienvenida1">
                                    <textarea style="height: 100px;" cols="50" id="mostrar_bienvenida" name="mostrar_bienvenida">
                                                <?php
                                                echo $data['mostrar_bienvenida'];
                                            ?>
                                        </textarea>
                                        </div>

                                </td>
                                <td valign="top"><label for="ayuda">Despedida:</label></td>
                                <td>
                                    <div id="mostrar_despedida1">
                                        <textarea style="height: 100px;" cols="50" id="mostrar_despedida" name="mostrar_despedida">
                                            <?php
                                                echo $data['mostrar_despedida'];
                                            ?>
                                        </textarea>
                                    </div>
                                </td>
                            </tr>-->

                        </tbody>
                    </table>
            </fieldset>
        <br>
            <fieldset>
                <table border="0">
                    <tr>
                        <td><input type="checkbox" id="Obligar" name="Obligar" <?PHP echo $C_Obligar;?> <?PHP echo $D_Fecha?> /></td>
                        <td><strong>Desea que el Instrumento sea Obligatorio</strong></td>
                    </tr>
                </table>
                <legend>Publico Objetivo</legend>
                <div id="tabs">
                <ul>
                    <li><a href="#tabs-1" style="font-size:11px">Estudiantes</a></li>	
				<?php if($_REQUEST["cat_ins"]!="EDOCENTES"){ ?>
                    <li><a href="#tabs-3" style="font-size:11px;" >Docentes</a></li>
                     <li><a href="#tabs-8" style="font-size:11px;" >Externos</a></li>
					 <?php } ?>
                    <!--<li style="visibility:collapse"><a href="#tabs-2" style="font-size:11px">Egresados</a></li>
                    
                    <li style="visibility:collapse"><a href="#tabs-4" style="font-size:11px">Decanos y Srio. Académicos</a></li>
                    <li style="visibility:collapse"><a href="#tabs-5" style="font-size:11px">Dir. de División</a></li>
                    <li style="visibility:collapse"><a href="#tabs-6" style="font-size:11px">Coordinadores EC</a></li>
                    <!--<li><a href="#tabs-7" style="font-size:11px">Administrativos</a></li>-->
                   
                </ul>
                <div id="tabs-1">
                <?PHP 
				$SQL_D='SELECT * FROM siq_Adetallepublicoobjetivo WHERE idsiq_Apublicoobjetivo="'.$C_Data[0]['idsiq_Apublicoobjetivo'].'"';
				
				if($Detalle=&$db->Execute($SQL_D)===false){
						echo 'Error en el SQL del Detalle<br><br>'.$SQL_D;
						die;
					}
					
				$C_Data2	= $Detalle->GetArray();
				
				//echo '<pre>';print_r($C_Data2);
                
                
				
				if($C_Data2[0]['E_New']==1 && $C_Data2[0]['codigoestado']==100){
					$Visibility		= 'style="visibility:visible"';
					/*********************************/
					
					/*********************************/
					}else if($C_Data2[0]['E_New']==0 && $C_Data2[0]['codigoestado']==100){
						$Visibility		= 'style="visibility:collapse"';
						
						}else{
							$Visibility		= 'style="visibility:collapse"';
							
							}
				?>
                <table width="100%" border="0">
                        <?PHP 
                        if($data['idsiq_discriminacionIndicador']==3){
                            ?>
                            <tr>
                                <td><input type="checkbox" title="" <?PHP echo $D_Fecha?> onclick="Desabilitar();" id="Multi_Instru" name="Multi_Instru" /></td>
                                <td><strong>Multi-Instrumento</strong><input <?PHP echo $D_Fecha?> type="text" value="<?PHP echo $data['codigocarrera']?>" id="CodigoCarrera" /></td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<hr style="widows:95%" />
                                </td>
                            </tr>
                            <?PHP
                        }
                        ?>
                        
                        <tr>
                            <td width="65">
                                <input type="checkbox" <?PHP echo $D_Fecha?> onclick="dato('estudiantenuevo');VerFiltro('estudiantenuevo1','Tr_FiltroNew','Tr_SemestreNew');EliminarDato('estudiantenuevo1','NewVista','id_NewDetalle','Div_New','Nuevos','estudiantenuevo','id_NewEstado','Filtro_New','estudiantesemestreNew');" name="estudiantenuevo1" id="estudiantenuevo1" tabindex="6" title="Estudiante Nuevos" <?php if($C_Data2[0]['E_New']==1 && $C_Data2[0]['codigoestado']==100) echo "checked"; ?>  />
                                <input type="hidden" name="estudiantenuevo" id="estudiantenuevo" value="<?php echo $C_Data2[0]['E_New']; ?>">
                                <input type="hidden" id="id_NewDetalle" value="<?PHP echo $C_Data2[0]['idsiq_Adetallepublicoobjetivo']?>" />
                                <input type="hidden" id="id_NewEstado"  value="<?PHP echo $C_Data2[0]['codigoestado']?>" />
                            </td>
                            <td width="779">
                                <strong>Estudiantes Nuevos</strong>
                            </td>
                        </tr>
                        <tr id="Tr_FiltroNew" <?PHP echo $Visibility?> class="NewVista">
                        	<td colspan="2">
                            	<table border="0" width="100%">
                                	<tr>
                                    	<td>
                                        	<table border="0" width="100%">
                                            	<tr>
                                                	<td>Seleccione</td>	
                            						<td>
													<?PHP 
                                                    //echo '<pre>';print_r($data);
                                                    
                                                    if($data['idsiq_discriminacionIndicador']){
                                                        $Tipo  = $data['idsiq_discriminacionIndicador'];
                                                    }else{
                                                        $Tipo  =1;
                                                    }
                                                    
													if($C_Data2[0]['E_New']==1 && $C_Data2[0]['codigoestado']==100){
														$selected	= 'selected="selected"';
														$Filtro_New	= $C_Data2[0]['filtro'];
														FiltroEstudianteUpdate('Filtro_New','0','Modalidad_id_New','Carrera_new','CargarCarrera','Td_CargarNew','Check','Mareias_New','New','',$Filtro_New,$selected);
														}else if($C_Data2[0]['E_New']==0 && $C_Data2[0]['codigoestado']==100){
															FiltroEstudiante('Filtro_New','0','Modalidad_id_New','Carrera_new','CargarCarrera','Td_CargarNew','Check','Mareias_New','New','',$Tipo);
															}else{ 
													FiltroEstudiante('Filtro_New','0','Modalidad_id_New','Carrera_new','CargarCarrera','Td_CargarNew','Check','Mareias_New','New','',$Tipo);}
													?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td id="Td_CargarNew" <?PHP echo $Visibility?> class="NewVista">
                                        	<div id="Div_New">
                                            	<?PHP 
												if($C_Data2[0]['tipocadena']==1 && $C_Data2[0]['codigoestado']==100){
													$C_Insturmneto->FacultadUpdate('Check','New',$C_Data2[0]['cadena']);
													}
												?>
                                                <?PHP 
												if($C_Data2[0]['tipocadena']==3 && $C_Data2[0]['codigoestado']==100){
												$C_Insturmneto->ModalidaCarreraMateria('Modalidad_id_New','Carrera_new','CargarCarrera','Lista','Td_CargarNew','New',$Visibility,$C_Data2[0]['modalidadsic'],$C_Data2[0]['codigocarrera'],$C_Data2[0]['cadena'],'NewVista');
												}
												?>
                                                <?PHP
												if($C_Data2[0]['tipocadena']==2 && $C_Data2[0]['codigoestado']==100){
												 $C_Insturmneto->ModalidaCarrera('Modalidad_id_New','Carrera_new','CargarCarrera','Check','Td_CargarNew','New',$C_Data2[0]['modalidadsic'],$C_Data2[0]['cadena'],$Visibility,'NewVista');
												}
												 ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr id="Tr_SemestreNew" <?PHP echo $Visibility?> class="NewVista">
                            <td valign="top">
                                Semestre
                            </td>
                            <td>
                                <select id="estudiantesemestreNew" <?PHP echo $D_Fecha?> name="estudiantesemestreNew[]" multiple> 
                                    <option value=""></option>
                                    <option value="99">Todos</option>
                                <?php 
                                    if (!empty($C_Data2[0]['semestre'])){
                                        $sem = explode(",",$C_Data2[0]['semestre']);
                                        $z=0;
                                        for ($i=1; $i<13; $i++){
                                            echo "<option value='".$i."'";
                                                if($sem[$z]==$i){
                                                    echo " selected='selected' ";
                                                    $z++;
                                                }
                                            echo ">".$i."</option>";
                                        }
                                    }else{
                                        for ($i=1; $i<13; $i++){
                                            echo "<option value='".$i."'";
                                            echo ">".$i."</option>";
                                        }
                                    }                                    
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<hr style="widows:95%" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" <?PHP echo $D_Fecha?> onclick="dato('estudianteAntiguo');VerFiltro('estudianteAntiguo1','Tr_FiltroOld','Tr_SemestreOld');EliminarDato('estudianteAntiguo1','OldVista','id_OldDetalle','Div_Old','Antiguos','estudianteAntiguo','id_OldEstado','Filtro_old','estudiantesemestreOld');" name="estudianteAntiguo1" id="estudianteAntiguo1" tabindex="6" title="Antiguos" value="1" <?php if($C_Data2[1]['E_Old']==1  && $C_Data2[1]['codigoestado']==100) echo "checked"; ?>  />
                                <input type="hidden" name="estudianteAntiguo" id="estudianteAntiguo" value="<?php echo $C_Data2[1]['E_Old']; ?>">
                                <input type="hidden" id="id_OldDetalle" value="<?PHP echo $C_Data2[1]['idsiq_Adetallepublicoobjetivo']?>" />
                                <input type="hidden" id="id_OldEstado" value="<?PHP echo $C_Data2[1]['codigoestado']?>" />
                            </td>
                            <td>
                                <strong>Estudiantes Antiguos</strong>
                            </td>
                        </tr>
                        <?PHP 
						if($C_Data2[1]['E_Old']==1 && $C_Data2[1]['codigoestado']==100){
							$Visibility		= 'style="visibility:visible"';
							}else if($C_Data2[1]['E_Old']==0 && $C_Data2[1]['codigoestado']==100){
								$Visibility		= 'style="visibility:collapse"';
								}else{
									$Visibility		= 'style="visibility:collapse"';
									}
						?>
                        <tr id="Tr_FiltroOld" <?PHP echo $Visibility?>  class="OldVista">
                        	<td colspan="2">
                            	<table border="0" width="100%">
                                	<tr>
                                    	<td>
                                        	<table border="0" width="100%">
                                            	<tr>
                                                	<td>Seleccione</td>	
                            						<td>
													<?PHP 
                                                    if($data['idsiq_discriminacionIndicador']){
                                                        $Tipo  = $data['idsiq_discriminacionIndicador'];
                                                    }else{
                                                        $Tipo  =1;
                                                    }
                                                    
													if($C_Data2[1]['E_Old']==1 && $C_Data2[1]['codigoestado']==100){
														$selected	= 'selected="selected"';
														$Filtro_Old	= $C_Data2[1]['filtro'];
														FiltroEstudianteUpdate('Filtro_old','1','modalida_old','Carrera_old','Carga_Old','Td_CargarOld','Check','Mareias_Old','Old','',$Filtro_Old,$selected);
														}else if($C_Data2[1]['E_Old']==0  && $C_Data2[1]['codigoestado']==100){
															FiltroEstudiante('Filtro_old','1','modalida_old','Carrera_old','Carga_Old','Td_CargarOld','Check','Mareias_Old','Old','',$Tipo);
															}else{
															FiltroEstudiante('Filtro_old','1','modalida_old','Carrera_old','Carga_Old','Td_CargarOld','Check','Mareias_Old','Old','',$Tipo);}
													?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td id="Td_CargarOld" <?PHP echo $Visibility?>  class="OldVista">
                                        	<div id="Div_Old">
                                            	<?PHP 
												if($C_Data2[1]['tipocadena']==1  && $C_Data2[1]['codigoestado']==100){
													$C_Insturmneto->FacultadUpdate('Check','Old',$C_Data2[1]['cadena']);
												}
												?>
                                                <?PHP 
												if($C_Data2[1]['tipocadena']==3  && $C_Data2[1]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarreraMateria('modalida_old','Carrera_old','Carga_Old','Lista','Td_CargarOld','Old',$Visibility,$C_Data2[1]['modalidadsic'],$C_Data2[1]['codigocarrera'],$C_Data2[1]['cadena'],'OldVista');
												}
												?>
                                            	<?PHP 
												if($C_Data2[1]['tipocadena']==2  && $C_Data2[1]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarrera('modalida_old','Carrera_old','Carga_Old','Check','Td_CargarOld','Old',$C_Data2[1]['modalidadsic'],$C_Data2[1]['cadena'],$Visibility,'OldVista');
												}
												?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr id="Tr_SemestreOld" <?PHP echo $Visibility?>  class="OldVista">
                            <td valign="top">
                                Semestre
                            </td>
                            <td>
                                <select id="estudiantesemestreOld" <?PHP echo $D_Fecha?> name="estudiantesemestreOld[]" multiple> 
                                    <option value=""></option>
                                    <option value="99">Todos</option>
                                <?php 
                                    if (!empty($C_Data2[1]['semestre'])){
                                        $sem = explode(",",$C_Data2[1]['semestre']);
                                        $z=0;
                                        for ($i=1; $i<13; $i++){
                                            echo "<option value='".$i."'";
                                                if($sem[$z]==$i){
                                                    echo " selected='selected' ";
                                                    $z++;
                                                }
                                            echo ">".$i."</option>";
                                        }
                                    }else{
                                        for ($i=1; $i<13; $i++){
                                            echo "<option value='".$i."'";
                                            echo ">".$i."</option>";
                                        }
                                    }                                    
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<hr style="widows:95%" />
                            </td>
                        </tr>
                        <tr style="visibility: collapse;">
                            <td>
                                <input type="checkbox" <?PHP echo $D_Fecha?> onclick="dato('estudianteEgresado');VerFiltro('estudianteEgresado1','Tr_FiltroEgr')" name="estudianteEgresado1" id="estudianteEgresado1" tabindex="6" title="Graduandos" value="1" <?php if($C_Data2[2]['E_Egr']==1  && $C_Data2[2]['codigoestado']==100) echo "checked"; ?>  />
                                <input type="hidden" name="estudianteEgresado" id="estudianteEgresado" value="<?php echo $C_Data2[2]['E_Egr']; ?>">
                                <input type="hidden" id="id_EgrDetalle" value="<?PHP echo $C_Data2[2]['idsiq_Adetallepublicoobjetivo']?>" />
                                 <input type="hidden" id="id_EgrEstado" value="<?PHP echo $C_Data2[2]['codigoestado']?>" />
                            </td>
                            <td>
                                <strong>Estudiantes Egresado</strong>
                            </td>
                        </tr>
                        <?PHP 
						if($C_Data2[2]['E_Egr']==1 && $C_Data2[2]['codigoestado']==100){
							$Visibility		= 'style="visibility:visible"';
							}else if($C_Data2[2]['E_Egr']==0  && $C_Data2[2]['codigoestado']==100){
								$Visibility		= 'style="visibility:collapse"';
								}else{
									$Visibility		= 'style="visibility:collapse"';
									}
						?>
                        <tr id="Tr_FiltroEgr" style="visibility: collapse;"   class="EgrVista">
                        	<td colspan="2">
                            	<table border="0" width="100%">
                                	<tr>
                                    	<td>
                                        	<table border="0" width="100%">
                                            	<tr>
                                                	<td>Seleccione</td>	
                            						<td>
													<?PHP 
                                                    if($data['idsiq_discriminacionIndicador']){
                                                        $Tipo  = $data['idsiq_discriminacionIndicador'];
                                                    }else{
                                                        $Tipo  =1;
                                                    }
                                                    
													if($C_Data2[2]['E_Egr']==1  && $C_Data2[2]['codigoestado']==100){
														$selected	= 'selected="selected"';
														$Filtro_Egr	= $C_Data2[2]['filtro'];
														FiltroEstudianteUpdate('Filtro_Egr','2','modalidad_Egr','Carrera_Egr','Carga_Egr','Td_CargarEgr','Check','Mareias_Egr','Egr','',$Filtro_Egr,$selected);
														}else if($C_Data2[2]['E_Egr']==0  && $C_Data2[2]['codigoestado']==100){
															FiltroEstudiante('Filtro_Egr','2','modalidad_Egr','Carrera_Egr','Carga_Egr','Td_CargarEgr','Check','Mareias_Egr','Egr','','1');
															}else{
															FiltroEstudiante('Filtro_Egr','2','modalidad_Egr','Carrera_Egr','Carga_Egr','Td_CargarEgr','Check','Mareias_Egr','Egr','','1');}
													?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td id="Td_CargarEgr" <?PHP echo $Visibility?>  class="EgrVista">
                                        	<div id="Div_Egr">
                                            	<?PHP 
												if($C_Data2[2]['tipocadena']==1  && $C_Data2[2]['codigoestado']==100){
													$C_Insturmneto->FacultadUpdate('Check','Egr',$C_Data2[2]['cadena']);
												}
												?>
                                                <?PHP 
												if($C_Data2[2]['tipocadena']==3  && $C_Data2[2]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarreraMateria('modalidad_Egr','Carrera_Egr','Carga_Egr','Lista','Td_CargarEgr','Egr',$Visibility,$C_Data2[2]['modalidadsic'],$C_Data2[2]['codigocarrera'],$C_Data2[2]['cadena'],'EgrVista');
												}
												?>
                                            	<?PHP 
												if($C_Data2[2]['tipocadena']==2  && $C_Data2[2]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarrera('modalidad_Egr','Carrera_Egr','Carga_Egr','Check','Td_CargarEgr','Egr',$C_Data2[2]['modalidadsic'],$C_Data2[2]['cadena'],$Visibility,'EgrVista');
												}
												?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2" style="visibility: collapse;" >
                            	<hr style="widows:95%" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" <?PHP echo $D_Fecha?> onclick="dato('estudiantegraduado');VerFiltro('estudiantegraduado1','Tr_FiltroGra')" name="estudiantegraduado1" id="estudiantegraduado1" tabindex="6" title="Graduados" value="1" <?php if($C_Data2[3]['E_Gra']==1  && $C_Data2[3]['codigoestado']==100) echo "checked"; ?>  />
                                <input type="hidden" name="estudiantegraduado" id="estudiantegraduado" value="<?php echo $C_Data2[3]['E_Gra']; ?>">
                                <input type="hidden" id="id_GraDetalle" value="<?PHP echo $C_Data2[3]['idsiq_Adetallepublicoobjetivo']?>" />
                                <input type="hidden" id="id_GraEstado" value="<?PHP echo $C_Data2[3]['codigoestado']?>" />
                            </td>
                            <td>
                                <strong>Estudiantes Graduados</strong>
                            </td>
                        </tr>
                        <?PHP 
						if($C_Data2[3]['E_Gra']==1 && $C_Data2[3]['codigoestado']==100){
							$Visibility		= 'style="visibility:visible"';
							}else if($C_Data2[3]['E_Gra']==0 && $C_Data2[3]['codigoestado']==100){
								$Visibility		= 'style="visibility:collapse"';
								}else{
									$Visibility		= 'style="visibility:collapse"';
									}
						?>
                        <tr id="Tr_FiltroGra" <?PHP echo $Visibility?>  class="GraVista">
                        	<td colspan="2">
                            	<table border="0" width="100%">
                                	<tr>
                                    	<td>
                                        	<table border="0" width="100%">
                                            	<tr>
                                                	<td>Seleccione</td>	
                            						<td>
													<?PHP 
                                                    
													if($C_Data2[3]['E_Gra']==1  && $C_Data2[3]['codigoestado']==100){
														$selected	= 'selected="selected"';
														$Filtro_Gra	= $C_Data2[3]['filtro'];
														ModalidadGraduado($C_Data2[3]['modalidadsic'],$C_Data2[3]['recienegresado'],$C_Data2[3]['consolidacionprofesional'],$C_Data2[3]['senior']);
														}else if($C_Data2[3]['E_Gra']==0  && $C_Data2[3]['codigoestado']==100){
															//FiltroEstudiante('Filtro_Gra','3','modalidad_Gra','Carrera_Gra','Carga_Gra','Td_CargarGra','Check','Mareias_Gra','Gra','','1');                
                                                            ModalidadGraduado();
															}else{
															//FiltroEstudiante('Filtro_Gra','3','modalidad_Gra','Carrera_Gra','Carga_Gra','Td_CargarGra','Check','Mareias_Gra','Gra','','1');
                                                            ModalidadGraduado();
                                                            }
                                                            
													?>
                                                    </td>
                                                </tr>   
                                            </table>
                                        </td>
                                        <td id="Td_CargarGra" <?PHP echo $Visibility?>  class="GraVista">
                                        	<div id="Div_Gra">
                                            	<?PHP 
												if($C_Data2[3]['tipocadena']==1  && $C_Data2[3]['codigoestado']==100){
													$C_Insturmneto->FacultadUpdate('Check','Gra',$C_Data2[3]['cadena']);
												}
												?>
                                                <?PHP 
												if($C_Data2[3]['tipocadena']==3  && $C_Data2[3]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarreraMateria('modalidad_Gra','Carrera_Gra','Carga_Gra','Lista','Td_CargarGra','Gra',$Visibility,$C_Data2[3]['modalidadsic'],$C_Data2[3]['codigocarrera'],$C_Data2[3]['cadena'],'GraVista');
												}
												?>
                                            	<?PHP 
												if($C_Data2[3]['tipocadena']==2  && $C_Data2[3]['codigoestado']==100){
													$C_Insturmneto->ModalidaCarrera('modalidad_Gra','Carrera_Gra','Carga_Gra','Check','Td_CargarGra','Gra',$C_Data2[3]['modalidadsic'],$C_Data2[3]['cadena'],$Visibility,'GraVista');
												}
												?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<hr style="widows:95%" />
                            </td>
                        </tr>
                </table>
                </div>
                <div id="tabs-2" style="visibility:collapse">
                <table>
                        <tr>
                         <td>
                            <input type="checkbox" onclick="dato('egresadorecien')" name="egresadorecien1" id="egresadorecien1" tabindex="6" title="egresadorecien" value="1" <?php if($data1['egresadorecien']==1) echo "checked"; ?>  />
                            <input type="hidden" name="egresadorecien" id="egresadorecien" value="<?php echo $data1['egresadorecien']; ?>">
                         </td>   
                         <td>
                                Recien Egresado (Entre 0-3 años de experiencia)
                            </td>
                        
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" onclick="dato('egresadoconsolidacion')" name="egresadoconsolidacion1" id="egresadoconsolidacion1" tabindex="6" title="Consolidacion Profesional" value="1" <?php if($data1['egresadoconsolidacion']==1) echo "checked"; ?>  />
                                <input type="hidden" name="egresadoconsolidacion" id="egresadoconsolidacion" value="<?php echo $data1['egresadoconsolidacion']; ?>">
                            </td>
                            <td>
                                    Consolidación Profesional (Entre 3-15 años de experiencia)
                            </td>
                        </tr>
                        <tr>    
                            <td>
                               <input type="checkbox" onclick="dato('egresadosenior')" name="egresadosenior1" id="egresadosenior1" tabindex="6" title="Egresado Senior" value="1" <?php if($data1['egresadosenior']==1) echo "checked"; ?>  />
                               <input type="hidden" name="egresadosenior" id="egresadosenior" value="<?php echo $data1['egresadosenior']; ?>">
                            </td>
                            <td>
                                    Egresado Senior (Mayor a 15 años de experiencia)
                            </td>
                            
                    </tr>

                    </table>
                </div>
                <?PHP 
                //echo '<pre>';print_r($C_Data2);
                if($C_Data2[4]['docente']==1){
                    $D_Docente  = 'checked="checked"';
                    $Docente_Style='style="visibility: visible;"';
                    $Docente_Div = 'style="display: inline;"';
                }else{
                    $D_Docente  = '';
                    $Docente_Style='style="visibility: collapse;"';
                     $Docente_Div = 'style="display: none;"';
                }
				$style="";
				if($_REQUEST["cat_ins"]=="EDOCENTES"){
					$style="display:none;";
				}
                ?>
                <div id="tabs-3" style="<?php echo $style; ?>">
                    <table border="0">
                        <tr>
                            <td><input type="hidden" id="Docente_id" name="Docente_id" value="<?PHP echo $C_Data2[4]['idsiq_Adetallepublicoobjetivo']?>" /><input id="Docentes" name="Docentes" type="checkbox" onclick="M_Docente()" <?PHP echo $D_Docente?> /></td>
                            <td><strong>Docentes</strong></td>
                            <td></td>
                            <td>
                                <table border="0">
                                    <tr <?PHP echo $Docente_Style?> id="Docente_M">
                                        <td><strong>Modalidad Academica</strong></td>
                                        <?PHP 
                                        $SQL_M='SELECT 
                    
                    							codigomodalidadacademica AS id,
                    							nombremodalidadacademica as Nombre 
                    
                    							FROM modalidadacademica
                    
                    							WHERE
                    
                    							codigoestado=100
                    							AND
                    							codigomodalidadacademica IN (200,300)';
                                                
                                             if($Modalidad=&$db->Execute($SQL_M)===false){
                                                echo 'Error en el SQL ....<br><br>'.$SQL_M;
                                                die;
                                             }   
                                        ?>
                                        <td>
                                           <select id="SelectModalidadDocente" name="SelectModalidadDocente" onchange="BuscarMod()">
                                                <option value="0"></option>
                                                <?PHP 
                                                while(!$Modalidad->EOF){
                                                    /**********************************/
                                                    if($Modalidad->fields['id']==$C_Data2[4]['modalidadsic']){
                                                        $Selected_MD='selected="selected"';
                                                    }else{
                                                        $Selected_MD='';
                                                    }
                                                    ?>
                                                    <option  value="<?PHP echo $Modalidad->fields['id']?>" <?PHP echo $Selected_MD?>><?PHP echo $Modalidad->fields['Nombre']?></option>
                                                    <?PHP
                                                    /**********************************/
                                                    $Modalidad->MoveNext();
                                                }
                                                ?>
                                           </select> 
                                        </td>
                                    </tr>
                                    
                                </table>
                            </td>
                            <tr>
                               <td colspan="4"><input type="hidden" id="CadenaDocente" name="CadenaDocente" /></td> 
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div id="Carga_ModDocente" <?PHP echo $Docente_Div?> >
                                    <?PHP 
                                    $C_Insturmneto->Mod_Docente($C_Data2[4]['modalidadsic'],$C_Data2[4]['modalidadocente']);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                        </tr>
                    </table>
                </div>
                <div id="tabs-4" style="visibility:collapse">
                    <table>
                        <tr>
                            <td>
                                Todos
                            </td>
                            <td>
                               <input type="checkbox" onclick="dato('decanos')" name="decanos1" id="decanos1" tabindex="6" title="Decanos" value="1" <?php if($data1['decanos']==1) echo "checked"; ?>  />
                               <input type="hidden" name="decanos" id="decanos" value="<?php echo $data1['decanos']; ?>">
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-5" style="visibility:collapse">
                    <table>
                        <tr>
                            <td>
                                Todos
                            </td>
                            <td>
                               <input type="checkbox" onclick="dato('directores')" name="directores1" id="directores1" tabindex="6" title="Directores" value="1" <?php if($data1['directores']==1) echo "checked"; ?>  />
                               <input type="hidden" name="directores" id="directores" value="<?php echo $data1['directores']; ?>">
                            </td>
                        </tr>
                    </table>
                </div> 
                <div id="tabs-6" style="visibility:collapse">
                    <table>
                        <tr>
                            <td>
                                Todos
                            </td>
                            <td>
                               <input type="checkbox" onclick="dato('coordinadores')" name="coordinadores1" id="coordinadores1" tabindex="6" title="Decanos" value="1" <?php if($data1['decanos']==1) echo "checked"; ?>  />
                               <input type="hidden" name="coordinadores" id="coordinadores" value="<?php echo $data1['coordinadores']; ?>">
                            </td>
                        </tr>
                    </table>
                </div> 
                <?PHP 
                if($C_Data[0]['cvs']==0 || $C_Data[0]['cvs']=='0'){
                    $Checked_csv    = 'checked="checked"';
                    $Valor_csv      =1;
                }else if($C_Data[0]['cvs']==1 || $C_Data[0]['cvs']=='1'){
                    $Checked_csv    = '';
                    $Valor_csv      = 0;
                }
                ?>
                <div id="tabs-8"  style="<?php echo $style; ?>">
                    <table>
                        <tr>
                            <td colspan="2">
                                En este modulo puede cargar el publico objetivo externo o muy especifico, por favor descragar la plantilla de ejemplo
                            </td>
                        </tr>
                        <tr>
                            <td>Cargar Archivo CSV<input type="checkbox" onclick="dato('csv');" <?PHP echo $D_Fecha?>  name="csv1" id="csv1" tabindex="6" title="Cargar csv" value="1" <?PHP echo $Checked_csv?>/>
                            <input type="hidden" name="csv" id="csv" value="<?php echo $Valor_csv; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                Ver Publico Objetivo Externo <input type="checkbox"  onclick="verpe()"  name="vp1" id="vp1" tabindex="6"   />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="pexterno"  style="display: none;">
                                    <table border="1">
                                    <?php
                                    $es="-"; $doc="-"; $vec="-"; $pad="-"; $prac="-"; $dser="-"; $adm="-"; $otr="-";
                                        echo "<tr>";
                                            echo "<td><center><b>Cedula</b></center></td>";
                                            echo "<td><center><b>Nombres</b></center></td>";
                                            echo "<td><center><b>Apellidos</b></center></td>";
                                            echo "<td><center><b>Correo</b></center></td>";
                                            echo "<td><center><b>Estudiante</b></center></td>";
                                            echo "<td><center><b>Docente</b></center></td>";
                                            echo "<td><center><b>Padre</b></center></td>";
                                            echo "<td><center><b>Vecino</b></center></td>";
                                            echo "<td><center><b>Practica</b></center></td>";
                                            echo "<td><center><b>Docencia-Servicio</b></center></td>";
                                            echo "<td><center><b>Administrativos</b></center></td>";
                                            echo "<td><center><b>Otros</b></center></td>";
                                            echo "</tr>";
                                        $query_csv= "SELECT *  FROM siq_Apublicoobjetivocsv where idsiq_Apublicoobjetivo='".$C_Data[0]['idsiq_Apublicoobjetivo']."'  AND codigoestado=100 ";
                                    // echo $query_csv;
                                        $data_in= $db->Execute($query_csv);
                                        
                                        foreach($data_in as $dt){
                                            //echo '<pre>';print_r($dt);
                                            $nombre=$dt['nombre'];
                                            $app=$dt['apellido'];
                                            $ced=$dt['cedula'];
                                            $corr=$dt['correo'];
                                            if ($dt['estudiante']==1 || $dt['estudiante']=='1'){$es='X';}else{$es="-";}
                                            if ($dt['docente']==1   || $dt['docente']=='1'){$doc='X';}else{$doc="-";} 
                                            if ($dt['padre']==1  || $dt['padre']=='1'){$pad='X';}else{$pad="-";} 
                                            if ($dt['vecinos']==1  || $dt['vecinos']=='1'){$vec='X';}else{$vec="-";} 
                                            if ($dt['practica']==1  || $dt['practica']=='1'){$prac='X';}else{$prac="-";} 
                                            if ($dt['docencia_servcio']==1  || $dt['docencia_servcio']=='1'){$dser='X';}else{$dser="-";}
                                           // echo 'xx->'.$dt['administrativos'];
                                            if ($dt['administrativos']==1  || $dt['administrativos']=='1'){$adm='X';}else{$adm="-";} 
                                            if ($dt['otros']==1  || $dt['otros']=='1'){$otr='X';}else{$otr="-";}
                                            echo "<tr>";
                                            echo "<td>".$ced."</td>";
                                            echo "<td>".$nombre."</td>";
                                            echo "<td>".$app."</td>";
                                            echo "<td>".$corr."</td>";
                                            echo "<td>".$es."</td>";
                                            echo "<td>".$doc."</td>";
                                            echo "<td>".$pad."</td>";
                                            echo "<td>".$vec."</td>";
                                            echo "<td>".$prac."</td>";
                                            echo "<td>".$dser."</td>";
                                            echo "<td>".$adm."</td>";
                                            echo "<td>".$otr."</td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                        </table>
                                </div>
                            </td>
                        </tr>
                       <!-- <tr>
                            <td>
                               Descargar Plantilla ejemplo
                            </td>
                            <td>
                                <a href="../plantilla/plantilla_ejemplo.csv" target="_blank">Descargar</a>
                            </td>   
                       </tr>
                       <tr>
                            <td><br></td>
                        </tr>
                        
                       <tr>
                           <td>Archivo a Cargar</td>
                           <td> <input type="file" name="files" id="files" /> </td>
                           <td> <input type="submit" value="...."></td>
                       </tr>-->
                    </table>
                </div>
                </div>
                
                
            </fieldset>
            <br>
        </div>
            <div class="derecha">
                <?PHP  
                //echo '->'.$Fecha_ini[0].'<'.date('Y-m-d');
                if($Fecha_ini[0]>date('Y-m-d')){
                   ?>
                   <button class="submit" type="submit">Siguiente</button>
                   <?PHP 
                }
                ?>
                &nbsp;&nbsp; 
                <a href="configuracion.php?id=<?php echo $id_instrumento ?>&cat_ins=<?PHP echo $_REQUEST['cat_ins']?>" class="submit" >Atrás</a>
                &nbsp;&nbsp; 
                <a href="configuracioninstrumentolistar.php?cat_ins=<?PHP echo $_REQUEST['cat_ins']?>" class="submit" >Regreso al menú</a>
            </div><!-- End demo -->
    </div>  
</form>
<?PHP
function FiltroEstudiante($name,$op,$modalidad,$carrera,$carga,$carga2,$type,$td_Materia='',$Ext,$index,$Tipo){
    //echo 'Tipo->'.$Tipo;
        if($Tipo==1 || $Tipo=='1'){
           ?>
            <select id="<?PHP echo $name?>" name="<?PHP echo $name?>" style="width:auto" onchange="VerOpcion('<?PHP echo $name?>','<?PHP echo $op?>','<?PHP echo $modalidad?>','<?PHP echo $carrera?>','<?PHP echo $carga?>','<?PHP echo $carga2?>','<?PHP echo $type?>','<?PHP echo $td_Materia?>','<?PHP echo $Ext?>')">
            	<option value="-1"></option>
                <option value="0">Facultad</option>
                <option value="1">Modalidad Academica</option>
                <?PHP 
        		if($op!=2 && $op!=3){
        		?>
                <option value="2">Materia</option>
                <?PHP }?>
            </select>
           <?PHP 
        }else if($Tipo==3  || $Tipo=='3'){
            ?>
            <select id="<?PHP echo $name?>" name="<?PHP echo $name?>" style="width:auto" onchange="VerOpcion('<?PHP echo $name?>','<?PHP echo $op?>','<?PHP echo $modalidad?>','<?PHP echo $carrera?>','<?PHP echo $carga?>','<?PHP echo $carga2?>','<?PHP echo $type?>','<?PHP echo $td_Materia?>','<?PHP echo $Ext?>')">
            	<option value="-1"></option>
                <option value="1">Modalidad Academica</option>
            </select>
            <?PHP
        }//fin del if
	
	}//Fin Function
	
function FiltroEstudianteUpdate($name,$op,$modalidad,$carrera,$carga,$carga2,$type,$td_Materia='',$Ext,$index,$Filtro,$selecte){
	
	if($Filtro==0){$Select_F='selected="selected"';  $Select_M='';$Select_Ma='';}
	if($Filtro==1){$Select_M='selected="selected"';  $Select_F='';$Select_Ma='';}
	if($Filtro==2){$Select_Ma='selected="selected"'; $Select_F='';$Select_M='';}
	?>
    <select id="<?PHP echo $name?>" name="<?PHP echo $name?>" style="width:auto" onchange="VerOpcion('<?PHP echo $name?>','<?PHP echo $op?>','<?PHP echo $modalidad?>','<?PHP echo $carrera?>','<?PHP echo $carga?>','<?PHP echo $carga2?>','<?PHP echo $type?>','<?PHP echo $td_Materia?>','<?PHP echo $Ext?>')">
    	<option value="-1"></option>
        <option value="0" <?PHP echo $Select_F?>>Facultad</option>
        <option value="1" <?PHP echo $Select_M?>>Modalidad Academica</option>
        <?PHP 
		if($op!=2 && $op!=3){
		?>
        <option value="2" <?PHP echo $Select_Ma?>>Materia</option>
        <?PHP }?>
    </select>
    <?PHP
	}
function ModalidadGraduado($Mod='',$Recien='',$Consoli='',$Senior=''){
    if($Mod==200 || $Mod=='200'){
        $ChecK_Pre  = 'checked="checked"';
        $ChecK_Pos  = '';
    }else if($Mod==300 || $Mod=='300'){
        $ChecK_Pre  = '';
        $ChecK_Pos  = 'checked="checked"';
    }else if($Mod==3 || $Mod=='3'){
        $ChecK_Pre  = 'checked="checked"';
        $ChecK_Pos  = 'checked="checked"';
    }
    /******************************************************************************************/
    
    $Check_recien  = '';
    $Check_Consoli = '';
    $Check_Senior  = '';
    
    if($Recien==1 || $Recien=='1'){
        $Check_recien = 'checked="checked"';
    }
    
    if($Consoli==1 || $Consoli=='1'){
        $Check_Consoli = 'checked="checked"';
    }
    
    if($Senior==1 || $Senior=='1'){
        $Check_Senior = 'checked="checked"';
    }
        
    
    ?>
    <table border="0">
        <tr>
            <td><input type="checkbox" id="Pregrado_Gra" name="Pregrado_Gra" value="1" <?PHP echo $ChecK_Pre?> /></td>
            <td><strong>Pregrado</strong></td>
            <td><input type="checkbox" id="Posgrado_Gra" name="Posgrado_Gra" value="2" <?PHP echo $ChecK_Pos?> /></td>
            <td><strong>Posgrado</strong></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="0">
                    <tr>
                        <td><input type="checkbox" id="RecienGraduado" name="RecienGraduado" <?PHP echo $Check_recien?> /></td>
                        <td><strong>Recien Egresado 0-5 A&ntilde;os</strong></td>
                    </tr>
                    <tr>    
                        <td><input type="checkbox" id="consolidacionProfe" name="consolidacionProfe" <?PHP echo $Check_Consoli?> /></td>
                        <td><strong>consolidacion Profecional 6-34 A&ntilde;os</strong></td>
                   </tr>
                   <tr>     
                        <td><input type="checkbox" id="Senior" name="Senior" <?PHP echo $Check_Senior?> /></td>
                        <td><strong>Senior mayor a 35 A&ntilde;os</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?PHP
}//function ModalidadGraduado	
?>
<script type="text/javascript">
     $("#titulo").attr("disabled",true);
     $("#fecha_inicio").attr("disabled",true);
     $("#fecha_fin").attr("disabled",true);
     $("#estado").attr("disabled",true);
     $("#secciones").attr("disabled",true);
     $("#idsiq_discriminacionIndicador").attr("disabled",true);
     $("#codigocarrera").attr("disabled",true);
     $("#codigomodalidadacademica").attr("disabled",true);
     $("#idsiq_periodicidad").attr("disabled",true);
        
        function dato(chec){
            //alert('hola')
            if($("#"+chec+"1").is(':checked')) {  
                $("#"+chec).val('1');
            }else{
                //$("#"+chec).val('NULL');
                $("#"+chec).val('0');
            }
            //alert($("#"+chec).val())
        }
        
        function verpe(){
            if ($("#vp1").is(':checked')){
                 $("#pexterno").show(); 
            }else{
                $("#pexterno").hide(); 
            }
        }
		/*******************************************************************************/
               $(':submit').click(function(event) {
                    nicEditors.findEditor('nombre').saveContent();
                     var id=$("#id_id").val();
                     var order = $("#sortable2").sortable('toArray');
                     $("#totalsecciones").val(order);
                     var veri=$("#aprobada").val();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    //alert(valido+'->ok \n'+veri)
					/************************************************/
					
					/************************************************/
					if(valido){

					 var Continue = sendForm();
					 
                     if(Continue!=false){
                        var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                           $(location).attr('href','instrumento.php?aprobar=1&id_instrumento='+id_instrumento+'&secc=1&cat_ins=<?PHP echo $_REQUEST['cat_ins']?>');
                     }
                   }
					/*********************************************/
                    /*if(valido){
						 sendForm();
                      if (veri==2){
                          sendForm();  
                      } else{
                           var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                           $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
                      }
                   }*/
                });
       /********************************************************************************/         
                function senFormcsv(id){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_file.php?idsiq_Apublicoobjetivo='+id+'&entity=Apublicoobjetivocsv',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
                }
                
                function sendForm(){//instrumento_publico_html
                     /*******************************************************/
					 var id_instrumento			= $('#idsiq_Ainstrumentoconfiguracion').val();
					 var id_publicoobjetivo		= $('#idsiq_Apublicoobjetivo').val();
					 var aprobada				= $('#aprobada').val();
					 /*************************Estudiante Nuevo***************************************/
					 if($('#estudiantenuevo1').is(':checked')){
							var E_new					= $('#estudiantenuevo').val();
							var Filtro_New				= $('#Filtro_New').val();
							var E_Type					= 1;
							
							if(Filtro_New==-1 || Filtro_New=='-1'){
								/*********************************************/
								alert('Selecione una Opcion del Estudiante Nuevo');
								$('#Filtro_New').effect("pulsate", {times:3}, 500);
								$('#Filtro_New').css('border-color','#F00');
								return false;
								/*********************************************/
								}
								
							if(Filtro_New==0 || Filtro_New=='0'){
								/******************Facultad*********************/
								var C_Datos_New				= $('#CadenaFacultadNew').val();
								var Modalidad_id_New		= '';	
								var Carrera_new				= '';
								var TipoCadena_new				= 1;
								
								if(!$('#TodasFacultadesNew').is(':checked')){
									/****************************************************/
										if(!$.trim($('#CadenaFacultadNew').val())){
											alert('Selecione Una O mas Facultades...New');
											return false;
										}
									/****************************************************/
									}
								if($('#TodasFacultadesNew').is(':checked')){
									/**************************************/
										var C_Datos_New				= 0;
										var Modalidad_id_New		= '';	
										var Carrera_new				= '';
									/**************************************/	
									}
								
								/***********************************************/
								}//if
							
							if(Filtro_New==1 || Filtro_New=='1'){
								/******************Modalidad********************/
								var Modalidad_id_New		= $('#Modalidad_id_New').val();
								var Carrera_new				= '';
								var TipoCadena_new				= 2;
								
								if(Modalidad_id_New==-1 || Modalidad_id_New=='-1'){
									/*********************************************/
									alert('Selecione una Modalidad Academica del Estudiante Nuevo');
									$('#Modalidad_id_New').effect("pulsate", {times:3}, 500);
									$('#Modalidad_id_New').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
									
								var C_Datos_New		= $('#CadenaCarreraNew').val();	
								if(!$('#TodasCarrerasNew').is(':checked')){
									/*****************************************/
									if(!$.trim($('#CadenaCarreraNew').val())){
											alert('Selecione Una O mas Carreras');
											return false;
										}
									/*****************************************/
									}
								if($('#TodasCarrerasNew').is(':checked')){
									/****************************************/
									var C_Datos_New		= 0;
									/****************************************/
									}	
								/***********************************************/
								}//if
								
							if(Filtro_New==2 || Filtro_New=='2'){
								/******************Materia**********************/
								var TipoCadena_new				= 3;
								var Modalidad_id_New		= $('#Modalidad_id_New').val();	
								
								if(Modalidad_id_New==-1 || Modalidad_id_New=='-1'){
									/*********************************************/
									alert('Selecione una Modalidad Academica del Estudiante Nuevo');
									$('#Modalidad_id_New').effect("pulsate", {times:3}, 500);
									$('#Modalidad_id_New').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
									
								var Carrera_new				= $('#Carrera_new').val(); 
								
								if(Carrera_new==-1 || Carrera_new=='-1'){
									/*********************************************/
									alert('Selecione una Carrera del Estudiante Nuevo');
									$('#Carrera_new').effect("pulsate", {times:3}, 500);
									$('#Carrera_new').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
								
								var C_Datos_New		= $('#CadenaMateriaNew').val();	
								
								if(!$.trim($('#CadenaMateriaNew').val())){
										alert('Selecione Una O mas Materias');
										return false;
									}
								/***********************************************/
								}//if	
						 /*************************************************************/		
						 var estudiantesemestreNew		= $('#estudiantesemestreNew').val();
						 
						 
						/****************************************************************/			
						 }else{
							 var E_new					= 0;
							 var Filtro_New				= '-1';	 
							 var C_Datos_New			= 'Null';
							 var Modalidad_id_New		= '';	
							 var Carrera_new			= '';
							 var TipoCadena				= '';
							 var estudiantesemestreNew	= '';
							 var E_Type					= 1;
							 }
					 /****************************Estudiante Old Antiguo***********************************/	
					 if($('#estudianteAntiguo1').is(':checked')){
							var E_Old					= $('#estudianteAntiguo').val();
							var Filtro_Old				= $('#Filtro_old').val();
							var E_Type_Old					= 2;
							
							if(Filtro_Old==-1 || Filtro_Old=='-1'){
								/*********************************************/
								alert('Selecione una Opcion del Estudiante Antiguo');
								$('#Filtro_old').effect("pulsate", {times:3}, 500);
								$('#Filtro_old').css('border-color','#F00');
								return false;
								/*********************************************/
								}
							/*
							'modalida_old','Carrera_old','Carga_Old','Td_CargarOld','Check','Mareias_Old','Old'
							*/	
							if(Filtro_Old==0 || Filtro_Old=='0'){
								/******************Facultad*********************/
								var C_Datos_Old				= $('#CadenaFacultadOld').val();
								var Modalidad_id_Old		= '';	
								var Carrera_Old				= '';
								var TipoCadena_Old			= 1;
								
								if(!$('#TodasFacultadesOld').is(':checked')){
									/****************************************************/
										if(!$.trim($('#CadenaFacultadOld').val())){
											alert('Selecione Una O mas Facultades......Old');
											return false;
										}
									/****************************************************/
									}
								if($('#TodasFacultadesOld').is(':checked')){
									/**************************************/
										var C_Datos_Old				= 0;
										var Modalidad_id_Old		= '';	
										var Carrera_Old				= '';
									/**************************************/	
									}
								
								/***********************************************/
								}//if
							
							if(Filtro_Old==1 || Filtro_Old=='1'){
								/******************Modalidad********************/
								var Modalidad_id_Old		= $('#modalida_old').val();
								var Carrera_Old				= '';
								var TipoCadena_Old				= 2;
								
								if(Modalidad_id_Old==-1 || Modalidad_id_Old=='-1'){
									/*********************************************/
									alert('Selecione una Modalidad Academica del Estudiante Antiguo');
									$('#modalida_old').effect("pulsate", {times:3}, 500);
									$('#modalida_old').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
									
								var C_Datos_Old		= $('#CadenaCarreraOld').val();	
								
								if(!$('#TodasCarrerasOld').is(':checked')){
									/*****************************************/
									if(!$.trim($('#CadenaCarreraOld').val())){
											alert('Selecione Una O mas Carreras');
											return false;
										}
									/*****************************************/
									}
								if($('#TodasCarrerasOld').is(':checked')){
									/****************************************/
									var C_Datos_Old		= 0;
									/****************************************/
									}	
								/***********************************************/
								}//if
								
							if(Filtro_Old==2 || Filtro_Old=='2'){
								/******************Materia**********************/
								var TipoCadena_Old			= 3;
								var Modalidad_id_Old		= $('#modalida_old').val();	
								
								if(Modalidad_id_Old==-1 || Modalidad_id_Old=='-1'){
									/*********************************************/
									alert('Selecione una Modalidad Academica del Estudiante Antiguo');
									$('#modalida_old').effect("pulsate", {times:3}, 500);
									$('#modalida_old').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
									
								var Carrera_Old			= $('#Carrera_old').val(); 
								
								if(Carrera_new==-1 || Carrera_new=='-1'){
									/*********************************************/
									alert('Selecione una Carrera del Estudiante Nuevo');
									$('#Carrera_old').effect("pulsate", {times:3}, 500);
									$('#Carrera_old').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
								
								var C_Datos_Old		= $('#CadenaMateriaOld').val();	
								
								if(!$.trim($('#CadenaMateriaOld').val())){
										alert('Selecione Una O mas Materias');
										return false;
									}
								/***********************************************/
								}//if	
						 /*************************************************************/		
						 var estudiantesemestreOld		= $('#estudiantesemestreOld').val();
						 
						 
						/****************************************************************/			
						 }else{
							 var E_Old					= 0;
							 var Filtro_Old				= '-1';	 
							 var C_Datos_Old			= 'Null';
							 var Modalidad_id_Old		= '';	
							 var Carrera_Old			= '';
							 var TipoCadena_Old			= '';
							 var estudiantesemestreOld	= '';
							 var E_Type_Old				= 2; 
							 }
					 /****************************Estudiante Egresado***********************************/
					 
					 if($('#estudianteEgresado1').is(':checked')){
							var E_Egre					= $('#estudianteEgresado').val();
							var Filtro_Egre				= $('#Filtro_Egr').val();
							var E_Type_Egr				= 3; 
							
							if(Filtro_Egre==-1 || Filtro_Egre=='-1'){
								/*********************************************/
								alert('Selecione una Opcion del Estudiante Egresado');
								$('#Filtro_Egr').effect("pulsate", {times:3}, 500);
								$('#Filtro_Egr').css('border-color','#F00');
								return false;
								/*********************************************/
								}
							
							if(Filtro_Egre==0 || Filtro_Egre=='0'){
								/******************Facultad*********************/
								var C_Datos_Egre			= $('#CadenaFacultadEgr').val();
								var Modalidad_id_Egre		= '';	
								var Carrera_Egre			= '';
								var TipoCadena_Egre			= 1;
								
								if(!$('#TodasFacultadesEgr').is(':checked')){
									/****************************************************/
										if(!$.trim($('#CadenaFacultadEgr').val())){
											alert('Selecione Una O mas Facultades....Egr');
											return false;
										}
									/****************************************************/
									}
								if($('#TodasFacultadesEgr').is(':checked')){
									/**************************************/
										var C_Datos_Egre			= 0;
										var Modalidad_id_Egre		= '';	
										var Carrera_Egre			= '';
									/**************************************/	
									}
								
								/***********************************************/
								}//if
							
							if(Filtro_Egre==1 || Filtro_Egre=='1'){
								/******************Modalidad********************/
								var Modalidad_id_Egre		= $('#modalidad_Egr').val();
								var Carrera_Egre			= '';
								var TipoCadena_Egre			= 2;
								
								if(Modalidad_id_New==-1 || Modalidad_id_New=='-1'){
									/*********************************************/
									alert('Selecione una Modalidad Academica del Estudiante Nuevo');
									$('#Modalidad_id_New').effect("pulsate", {times:3}, 500);
									$('#Modalidad_id_New').css('border-color','#F00');
									return false;
									/*********************************************/
									}//if
									
								var C_Datos_Egre		= $('#CadenaCarreraEgr').val();
								
								if(!$('#TodasCarrerasEgr').is(':checked')){
									/*****************************************/
									if(!$.trim($('#CadenaCarreraEgr').val())){
											alert('Selecione Una O mas Carreras');
											return false;
										}
									/*****************************************/
									}
								if($('#TodasCarrerasEgr').is(':checked')){
									/****************************************/
									var C_Datos_Egre		= 0;
									/****************************************/
									}	
								/***********************************************/
								}//if
							
						/****************************************************************/			
						 }else{
							 var E_Egre					= 0;
							 var Filtro_Egre			= '-1';	 
							 var C_Datos_Egre			= 'Null';
							 var Modalidad_id_Egre		= '';	
							 var Carrera_Egre			= '';
							 var TipoCadena_Egre		= '';
							 var E_Type_Egr				= 3;
													 
							 }
					 /****************************Estudiante Graduado***********************************/
					
					
				       if($('#estudiantegraduado1').is(':checked')){
							var E_Gra					= $('#estudiantegraduado').val();
							var E_Type_Gra				= 4;
                            
                            if(!$('#Pregrado_Gra').is(':checked') || !$('#Posgrado_Gra').is(':checked')){
                                /************************************************************************/
                                alert('Selecione una de las Modalidades de los Estudiantes Graduados');
                                $('#Pregrado_Gra').effect("pulsate", {times:3}, 500);
								$('#Pregrado_Gra').css('border-color','#F00');
                                /************************************************************************/
                                $('#Posgrado_Gra').effect("pulsate", {times:3}, 500);
								$('#Posgrado_Gra').css('border-color','#F00');
                                /************************************************************************/
                                return false;
                                /************************************************************************/
                            }//if
                            
                            if($('#Pregrado_Gra').is(':checked') && !$('#Posgrado_Gra').is(':checked')){
                                /************************************************************************/
                                var Modalidad_Gra   = 200;//Pregrado
                                /************************************************************************/
                            }//if
                            if(!$('#Pregrado_Gra').is(':checked') && $('#Posgrado_Gra').is(':checked')){
                                /**************************************************************************/
                                var Modalidad_Gra   = 300;//Posgrado
                                /**************************************************************************/
                            }//if
                            if($('#Pregrado_Gra').is(':checked') && $('#Posgrado_Gra').is(':checked')){
                                /**************************************************************************/
                                var Modalidad_Gra   = 3;//Pregrado y Posgrado
                                /**************************************************************************/
                            }//if
                            /***********************************************************************************/
                            
                            
                             if($('#Pregrado_Gra').is(':checked') || $('#Posgrado_Gra').is(':checked')){
                                
                                if(!$('#RecienGraduado').is(':checked') || !$('#consolidacionProfe').is(':checked') || !$('#Senior').is(':checked')){
                                    /************************************************************************/
                                    alert('Selecione una de las Modalidades de los Estudiantes Graduados');
                                    $('#RecienGraduado').effect("pulsate", {times:3}, 500);
    								$('#RecienGraduado').css('border-color','#F00');
                                    /************************************************************************/
                                    $('#consolidacionProfe').effect("pulsate", {times:3}, 500);
    								$('#consolidacionProfe').css('border-color','#F00');
                                    /************************************************************************/
                                    $('#Senior').effect("pulsate", {times:3}, 500);
    								$('#Senior').css('border-color','#F00');
                                    /************************************************************************/
                                    return false;
                                    /************************************************************************/
                                }//if
                                
                             }//if
                            
                            if($('#RecienGraduado').is(':checked')){
                                var recien      = 1;
                            }
                            if($('#consolidacionProfe').is(':checked')){
                                var consolidacion = 1;
                            }
                            if($('#Senior').is(':checked')){
                                var senior  = 1;
                            }
                            /***********************************************************************************/
						}else{
						   var Modalidad_Gra   = 0;
                           var E_Type_Gra	   = 4;
                           var E_Gra           = 0;
                           var recien          = 0;
                           var consolidacion   = 0;
                           var senior          = 0;
						}//if	
							   
					 /******************************************************************************/
					    var id_NewDetalle		= $('#id_NewDetalle').val();
						var id_OldDetalle		= $('#id_OldDetalle').val();
						var id_EgrDetalle		= $('#id_EgrDetalle').val();
						var id_GraDetalle		= $('#id_GraDetalle').val();
						
					 /************************CVS*******************************/
                        if($('#csv1').is(':checked')){
                            var csv = 0;
                        }else{
                            var csv = 1;
                        }
                     /*******************************************************/
                     if($('#Obligar').is(':checked')){
                        var Obligar = 1;   
                     }else{
                        var Obligar = 0;
                     }
                     /*******************************************************/
                     if($('#Docentes').is(':checked')){
                        /****************************************************/
                        var Docente     = 1;
                        
                        if($('#SelectModalidadDocente').val()==0){
                            /*********************************************/
							alert('Selecione una Modalidad Para los Docentes');
							$('#SelectModalidadDocente').effect("pulsate", {times:3}, 500);
							$('#SelectModalidadDocente').css('border-color','#F00');
							return false;
							/*********************************************/
                        }
                        
                        var M_Docente = $('#SelectModalidadDocente').val();
                        
                        $('#CadenaDocente').val('');
                        
                        if(M_Docente==200){//Pregrado
                          /**************************************************/
                          if($('#Adm_Pregrado').is(':checked')){/*Administracion y Pregrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::4');
                          }
                          
                          if($('#Pos_Pre').is(':checked')){/*Posgrado y Pregrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::6');
                          }
                          
                          if($('#Pre').is(':checked')){/*Pregrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::7');
                          }
                          /**************************************************/  
                        }else if(M_Docente==300){/*Posgrado*/
                          /**************************************************/
                          if($('#AdmPosgrado').is(':checked')){/*Administracion Posgrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::2');
                          }
                          
                          if($('#Adm_Posgrado').is(':checked')){/*Administracion Y Posgrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::3');
                          }
                          
                          if($('#Pos_Pre').is(':checked')){/*Posgrado y Pregrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::6');
                          }
                          
                          if($('#Pos').is(':checked')){/*Posgrado*/
                            $('#CadenaDocente').val($('#CadenaDocente').val()+'::5');
                          }
                          /**************************************************/  
                        }//if
                        /****************************************************/
                        var CadenaDocente   = $('#CadenaDocente').val();
                        /****************************************************/
                     }else{
                        /****************************************************/
                        var Docente         = 0;
                        var CadenaDocente   ='';
                        var M_Docente       = 0;
                        /****************************************************/
                     }
                     /*******************************************************/
                     var Docente_id     = $('#Docente_id').val();
                     /*******************************************************/
					 $.ajax({//Ajax
						  type: 'POST',
						  url: 'instrumento_publico_html.php',
						  async: false,
						  dataType: 'json',
						  data:({actionID:'Procesar',E_new:E_new,
						  							 Filtro_New:Filtro_New,
													 C_Datos_New:C_Datos_New,
													 Modalidad_id_New:Modalidad_id_New,
													 Carrera_new:Carrera_new,
													 estudiantesemestreNew:estudiantesemestreNew,
													 TipoCadena_new:TipoCadena_new,
													 E_Old:E_Old,
													 Filtro_Old:Filtro_Old,
													 C_Datos_Old:C_Datos_Old,
													 Modalidad_id_Old:Modalidad_id_Old,
													 Carrera_Old:Carrera_Old,
													 TipoCadena_Old:TipoCadena_Old,
													 estudiantesemestreOld:estudiantesemestreOld,
													 E_Egre:E_Egre,
													 Filtro_Egre:Filtro_Egre,
													 C_Datos_Egre:C_Datos_Egre,
													 Modalidad_id_Egre:Modalidad_id_Egre,
													 Carrera_Egre:Carrera_Egre,
													 TipoCadena_Egre:TipoCadena_Egre,
													 E_Gra:E_Gra,
													 Modalidad_Gra:Modalidad_Gra,
													 id_instrumento:id_instrumento,
													 id_publicoobjetivo:id_publicoobjetivo,
													 aprobada:aprobada,
													 E_Type:E_Type,
													 E_Type_Old:E_Type_Old,
													 E_Type_Egr:E_Type_Egr,
													 E_Type_Gra:E_Type_Gra,
													 id_NewDetalle:id_NewDetalle,
													 id_OldDetalle:id_OldDetalle,
													 id_EgrDetalle:id_EgrDetalle,
													 id_GraDetalle:id_GraDetalle,
                                                     csv:csv,
                                                     Obligar:Obligar,
                                                     Docente:Docente,
                                                     M_Docente:M_Docente,
                                                     CadenaDocente:CadenaDocente,
                                                     Docente_id:Docente_id,
                                                     recien:recien,
                                                     consolidacion:consolidacion,
                                                     senior:senior}),
						  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						  success: function(data){
									if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{ 
										  if($("#csv1").is(':checked')) {  
                                                var caracteristicas = "height=230,width=1000,scrollTo,resizable=1,scrollbars=1,location=0";
                                                window.open('cargar_archivo.php?idsiq_Apublicoobjetivo='+data.id, 'Popup', caracteristicas);
                                                return false;  
                                            }else{
                                                alert('No hay Datos externos')
                                            }
										}
							}//data 
					  }); //AJAX
			         /*******************************************************/
					 //$.ajax({
//                        dataType: 'json',
//                        type: 'POST',
//                        url: 'process.php',
//                        data: $('#form_test').serialize(),                
//                        success:function(data){
//                            if (data.success == true){
//                                alert(data.message);
//                                 if($("#csv1").is(':checked')) { 
//                                    var caracteristicas = "height=230,width=1000,scrollTo,resizable=1,scrollbars=1,location=0";
//                                    window.open('cargar_archivo.php?idsiq_Apublicoobjetivo='+data.id, 'Popup', caracteristicas);
//                                    return false;
//                                }else{
//                                    alert('No hay Datos externos')
//                                }
//                                
//                                //var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
//                              //  $(location).attr('href','instrumento_usuarios.php?id_instrumento='+id_instrumento+'&secc=1');
//                                //$(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
//                            }
//                            else{                        
//                                $('#msg-error').html('<p>' + data.message + '</p>');
//                                $('#msg-error').addClass('msg-error');
//                            }
//                        },
//                        error: function(data,error,errorThrown){alert(error + errorThrown);}
//                    }); 
             }
   /*******************************************************************************************/             
   
   function VerOpcion(name,op,modalidad,carrera,carga,Carga2,type,td_Materia,Ext){
	   /***************************************************/
	  // if(op==0){
		   /***************Nuevos*******************/
		   var Filtro	= $('#'+name).val();
		   
		   if(Filtro==-1 || Filtro=='-1'){
			   	alert('Debe Seleccionar Una Opcion');
				$('#'+name).effect("pulsate", {times:3}, 500);
				$('#'+name).css('border-color','#F00');
				return false;
			   }
			/***************************************/ 
			if(Filtro==0 || Filtro=='0'){
				/**********************************************/
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'instrumento_publico_html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID: 'Facultades',type:type,Ext:Ext}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
								$('#'+Carga2).css('visibility','visible');
								$('#'+Carga2).html(data);
						}//data 
				  }); //AJAX
				/**********************************************/
				}
			if(Filtro==1 || Filtro=='1'){
                /**********************************************/
                if($('#Multi_Instru').is('::checked')){
                    var CodigoCarrera   = $('#CodigoCarrera').val();
                }else{
                    var CodigoCarrera   = 0;
                }
				/**********************************************/
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'instrumento_publico_html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID: 'Modalidad',modalidad:modalidad,carrera:carrera,carga:carga,type:type,Cargamateria:td_Materia,Ext:Ext,CodigoCarrera:CodigoCarrera}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
								$('#'+Carga2).css('visibility','visible');
								$('#'+Carga2).html(data);
						}//data 
				  }); //AJAX
				/**********************************************/
				}
			if(Filtro==2 || Filtro=='2'){
				/**********************************************/
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'instrumento_publico_html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID: 'Materia',modalidad:modalidad,carrera:carrera,carga:carga,type:'Lista',td_Materia:td_Materia,Ext:Ext}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
								$('#'+Carga2).css('visibility','visible');
								$('#'+Carga2).html(data);
						}//data 
				  }); //AJAX
				/**********************************************/
				}	
		   /****************************************/
		 //  }
	   /***************************************************/
	   }
    function VerFiltro(dato,id_tr,tr_S){
		/*************************************************/
		if($('#'+dato).is(':checked')){
			/*********************************************/
				$('#'+id_tr).css('visibility','visible');
				$('#'+tr_S).css('visibility','visible');
			/*********************************************/
			}else{
				/*****************************************/
				$('#'+id_tr).css('visibility','collapse');
				$('#'+tr_S).css('visibility','collapse'); 
				/*****************************************/
				}
		/*************************************************/
		}            
	function VerCarrera(name,codigoCarrera,id_Carga,type,Cargamateria,Ext,C_CarreraCodigo){
		/**********************************************/
			var Modalidad		= $('#'+name).val();
			
			if(Modalidad==-1  || Modalidad=='-1'){
				alert('Seleccione Modalidad');
				$('#'+name).effect("pulsate", {times:3}, 500);
				$('#'+name).css('border-color','#F00');
				return false;
				}
			
		/**********************************************/		
		$.ajax({//Ajax
			  type: 'POST',
			  url: 'instrumento_publico_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'Carrera',
                     Modalidad:Modalidad,
                     codigoCarrera:codigoCarrera,
                     type:type,
                     Cargamateria:Cargamateria,
                     Ext:Ext,
                     C_CarreraCodigo:C_CarreraCodigo}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
						$('#'+id_Carga).css('visibility','visible');
						$('#'+id_Carga).html(data);
				}//data 
		  }); //AJAX
		/**********************************************/
		}	
	function Sombra(i,letra){
		/*************************/
		$('#Tr_'+letra+i).css('background-color','#CCC');
		/*************************/
		}	
	function SinSombra(i,letra,id){
		/*************************/
		if($('#'+id+i).is(':checked')){
			$('#Tr_'+letra+i).css('background-color','#4A7BF7');	
			}else{
				$('#Tr_'+letra+i).css('background-color','#FFF');
				}
		/*************************/
		}	
	function Inactivar(id,clase,hidden){ //alert('id->'+id+'\n clases->'+clase+'\n hidden->'+hidden);
		/****************************************/	
		if($('#'+id).is(':checked')){
				$('.'+clase).attr('checked',false);
				$('.'+clase).attr('disabled',true);
                $('#'+hidden).val('0');
			}else{
					$('.'+clase).attr('disabled',false);
				}
		/****************************************/
		}
	function addDato(i,hidden,check,letra,cadena){
		/***************************************************************/
		var Valor = $('#'+hidden+i).val();
		
		if($('#'+check+i).is(':checked')){
			/*******************************************/
			$('#Tr_'+letra+i).css('background-color','#4A7BF7');	
			$('#'+cadena).val($('#'+cadena).val()+'::'+Valor);
			/*******************************************/
			}else{
				/**************************************************/
				var Dato = '::'+Valor;
				
				var Cadena_Actual	= $('#'+cadena).val();
				var CadenaNew		= Cadena_Actual.replace(Dato,'');
				 
				 $('#'+cadena).val(CadenaNew);    
				 $('#Tr_'+letra+i).css('background-color','#FFF');
				/**************************************************/
				}
		/***************************************************************/
		}	
	function VerMateria(name,id_Carga,Ext){
		/*************************************************/
		var Carrera	= $('#'+name).val();
		
		if(Carrera==-1  || Carrera=='-1'){
			alert('Seleccione Carrera');
			$('#'+name).effect("pulsate", {times:3}, 500);
			$('#'+name).css('border-color','#F00');
			return false;
			}
		/**********************************************/		
		$.ajax({//Ajax
			  type: 'POST',
			  url: 'instrumento_publico_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'VerMaterias',Carrera:Carrera,Ext:Ext}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
						$('#'+id_Carga).css('visibility','visible');
						$('#'+id_Carga).html(data);
				}//data 
		  }); //AJAX
		/**********************************************/	
			
		/*************************************************/
		}
	function EliminarDato(id_Chk,clase,id_BD,Div,Descrip,chec,stado,filtro,Semestre){//'estudiantenuevo1','NewVista','id_NewDetalle','Div_New'
		/************************************************************/
		if($.trim($('#'+id_BD).val()) && $('#'+stado).val()==100 && $('#'+id_Chk).is(':checked')==false) {
			if(confirm('Seguro Desea Deshabilitar \n los Estudiantes '+Descrip)){
				/**************************Se Elimina el Reguistro***************/
				var id_Detalle	= $('#'+id_BD).val();
				
				/**********************************************/		
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'instrumento_publico_html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID: 'EliminarDetalle',id_Detalle:id_Detalle}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/*************************************/	
									$('#'+stado).val('200');
									$("#"+chec).val('0');
									$('.'+clase).css('visibility','collapse');
									$('#'+Div).html('');
									$('#'+filtro).val('-1');
									$('#'+Semestre).val('')
									
									alert('Se Ha Deshabilitado El Estudiante '+Descrip);
									/*************************************/
									}
						}//data 
				  }); //AJAX
				/**********************************************/	
				
				
				/***************************************************************/
				}else{
						$('#'+id_Chk).attr('checked',true);
						$("#"+chec).val('1');
						$('.'+clase).css('visibility','visible');
				}
		}
		/************************************************************/
		}
    function Desabilitar(){
       if($('#Multi_Instru').is(':checked')){
          /***********************************************/
          $('#estudianteEgresado1').attr('checked',false);
          $('#estudianteEgresado1').attr('disabled',true);
          $('#Filtro_Egr').val('-1');
          $('#Tr_FiltroEgr').css('visibility','collapse');//Tr visibility:collapse
          $('#Td_CargarEgr').css('visibility','collapse');//td
          $('#Div_Egr').html('');//div
          /***********************************************/
          $('#estudiantegraduado1').attr('checked',false);
          $('#estudiantegraduado1').attr('disabled',true);
          $('#Filtro_Gra').val('-1');
          $('#Tr_FiltroGra').css('visibility','collapse');//Tr visibility:collapse
          $('#Td_CargarGra').css('visibility','collapse');//td
          $('#Div_Gra').html('');//div
          /***********************************************/  
       }else{
            /************************************************/
             $('#estudianteEgresado1').attr('disabled',false);
             $('#estudiantegraduado1').attr('disabled',false);
            /************************************************/
       }//fin function 
    }   
  function M_Docente(){
    /*********************************************/
    if($('#Docentes').is(':checked')){
        /********************************************/
        $('#Docente_M').css('visibility','visible');
        /********************************************/
    }else{
        /********************************************/
        $('#Docente_M').css('visibility','collapse');
        /********************************************/
    }
    /*********************************************/
  } 
 function BuscarMod(){
    /***********************************/
    var Mod_Docente  = $('#SelectModalidadDocente').val();
    
    if(Mod_Docente!=0){
    	$.ajax({//Ajax
			  type: 'POST',
			  url: 'instrumento_publico_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID: 'ModDocente',Mod_Docente:Mod_Docente}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
				    $('#Carga_ModDocente').css('display','inline');
                    $('#Carga_ModDocente').html(data);
				}//data 
		  }); //AJAX
       }//if
    /***********************************/
 }/*BuscarMod*/ 	
</script>
    
<?php    writeFooter();
        ?>  

