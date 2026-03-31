<?PHP
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
switch($_REQUEST['actionID']){
	case 'Documental':{
		global $C_Carga_Documento;
		
		$indicador_id   = $_GET['id'];
		
		MainGeneral();
		JsGenral();
		
		$C_Carga_Documento->Documentos($indicador_id);
		}break;
	case 'Cargar_Documeto':{
		global $C_Carga_Documento;
		
		
		$indicador_id   = $_REQUEST['indicador_id'];
		
		MainGeneral();
		JsGenral();
		
		$C_Carga_Documento->CargarDocumeto($indicador_id);
		}break;
	case 'numerico':{
		global $C_Carga_Documento;
		
		$indicador_id   = $_REQUEST['indicador_id'];
		
		MainGeneral();
		JsGenral();
		
		$C_Carga_Documento->Numerico($indicador_id);
		}break;
	case 'Percepcion':{
		global $C_Carga_Documento;
		
		$pregunta_id = $_REQUEST['pregunta_id'];
		$indicador_id   = $_REQUEST['indicador_id'];
		
		MainGeneral();
		JsGenral();
		
		$C_Carga_Documento->Percepcion($indicador_id,$pregunta_id);
		
		}break;
        case 'Huerfana':{
		global $C_Carga_Documento;
		
		$idFormulario = $_REQUEST['idFormulario'];
		$pestana   = $_REQUEST['tab'];
		$periodo   = $_REQUEST['periodo'];
		
		MainGeneral();
		JsGenral();
		
                if(isset($_REQUEST['carrera'])){
                    $C_Carga_Documento->InformacionHuerfana($idFormulario,$pestana,$periodo,$_REQUEST['carrera']);
                } else {
                    $C_Carga_Documento->InformacionHuerfana($idFormulario,$pestana,$periodo);
                }
		
		}break;
	case 'Select_Ajax':{
		global $C_Carga_Documento;
		
		MainGeneral();
		JsGenral();
		
		$C_Carga_Documento->Select_ajax($_GET['Discriminacion'],$_GET['id']);
		
		}break;
	case 'Save':{
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
		include ('../API_Monitoreo.php'); $C_Api_Monitoreo = new API_Monitoreo();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];

		
		$Factor_id            = $_GET['Factor_id'];
		$caracteristica_id    = $_GET['caracteristica_id'];
		$Aspecto_id           = $_GET['Aspecto_id'];
		$Inicador_id          = $_GET['Inicador_id'];
		$url_Ubicacion        = $_GET['url_Ubicacion'];
		$Descripcion          = $_GET['Descripcion'];
		$Tipo				  = $_GET['Tipo'];
		$Periodo              = $_GET['Periodo'];
		
		$SQL_Insert='INSERT INTO  siq_documento (siqfactor_id,siqcaracteristica_id,siqaspecto_id,siqindicador_id,fecha_ingreso,userid,entrydate,periodo)VALUES("'.$Factor_id.'","'.$caracteristica_id.'","'.$Aspecto_id.'","'.$Inicador_id.'",NOW(),"'.$userid.'",NOW(),"'.$Periodo.'")';
		
			if($Insert_Doc=&$db->Execute($SQL_Insert)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error al Insertar El Documento....<br>'.$SQL_Insert;
					echo json_encode($a_vectt);
					exit;	
				}
		##################################
		$Documento__id=$db->Insert_ID();
		##################################		
		
		$SQL_Inser_Detalle='INSERT INTO siq_archivo_documento(siq_documento_id,descripcion,tipo_documento,fecha_carga,Ubicaicion_url,userid,entrydate)VALUES("'.$Documento__id.'","'.$Descripcion.'","'.$Tipo.'",NOW(),"'.$url_Ubicacion.'","'.$userid.'",NOW())';
		
				if($Inser_Detalle=&$db->Execute($SQL_Inser_Detalle)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar El Documento....<br>'.$SQL_Inser_Detalle;
						echo json_encode($a_vectt);
						exit;
					}
					
			$C_Api_Monitoreo->actualizarEstadoIndicador($Inicador_id,'2');#indicador id y estado id 2 = en proceso.		
				
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Guardo Exitosamente...!';
			echo json_encode($a_vectt);
			exit;	
		
		}break;
	case 'VerBox_Indicador':{
		global $C_Carga_Documento;
		MainGeneral();
		JsGenral();
		$C_Carga_Documento->Box_Indicador($_GET['Aspecto_id']);
		}break;
	case 'VerBox_Aspecto':{
		global $C_Carga_Documento;
		MainGeneral();
		JsGenral();
		$C_Carga_Documento->Box_Aspecto($_GET['Caracteristica_id']);
		}break;
	case 'VerBox_Carectisca':{
		global $C_Carga_Documento;
		MainGeneral();
		JsGenral();
		$C_Carga_Documento->Box_Caracteritica($_GET['factor_id']);
		}break;
	case 'AutoCompletar_Indicador':{
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
		
		$Letra   = $_REQUEST['term'];
		$Aspecto_id  = $_REQUEST['Aspecto_id'];
		
		$SQL_Indicador='SELECT 
									idsiq_indicador as id,
									nombre,
									descripcion,
									idTipo,
									idEstado,
									es_objeto_analisis,
									tiene_anexo
						
						FROM 
									siq_indicador
						
						WHERE
						
									nombre like "%' . $Letra . '%"
									AND
									codigoestado=100
									AND
									idAspecto="'.$Aspecto_id.'"';
									
									
						if($Resilt_Indicador=&$db->Execute($SQL_Indicador)===false){
								echo 'Error en el SQl indicador...<br>'.$SQL_Indicador;
								die;
							}	
					#echo '<pre>';print_r($Resilt_Indicador);
					
					$Indicador_R = array();
					
					while(!$Resilt_Indicador->EOF){
						
							$Ini_Vectt['label']=$Resilt_Indicador->fields['nombre'];
							$Ini_Vectt['value']=$Resilt_Indicador->fields['nombre'];
							$Ini_Vectt['Inicador_id']=$Resilt_Indicador->fields['id'];
							$Ini_Vectt['Analisis']=$Resilt_Indicador->fields['es_objeto_analisis'];
							$Ini_Vectt['Anexo']=$Resilt_Indicador->fields['tiene_anexo'];
							$Ini_Vectt['idTipo_indicador']=$Resilt_Indicador->fields['idTipo'];
							$Ini_Vectt['Estado']=$Resilt_Indicador->fields['idEstado'];
							
							array_push($Indicador_R, $Ini_Vectt);
						
						$Resilt_Indicador->MoveNext();
						}				
						
					echo json_encode($Indicador_R);	
		
		}break;
	case 'AutoCompletar_Aspecto':{
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
		
		$Letra   = $_REQUEST['term'];
		$Caract_id  = $_REQUEST['Caract_id'];
		
		  $SQL_Aspecto='SELECT 

								idsiq_aspecto as id,
								nombre
						
						FROM 
								siq_aspecto
						
						WHERE
						
								nombre like "%' . $Letra . '%"
								AND
								codigoestado=100
								AND
								idCaracteristica="'.$Caract_id.'"';
								
						if($Aspecto_Result=&$db->Execute($SQL_Aspecto)===false){
								echo 'Error enm el SQl Aspecto ....<br>'.$SQL_Aspecto;
								die;
							}
					
					#echo '<pre>';print_r($Aspecto_Result);
							
					$As_Result = array();
					
					while(!$Aspecto_Result->EOF){
						
							$AS_Vectt['label']=$Aspecto_Result->fields['nombre'];
							$AS_Vectt['value']=$Aspecto_Result->fields['nombre'];
							$AS_Vectt['Aspecto_id']=$Aspecto_Result->fields['id'];
						
						array_push($As_Result, $AS_Vectt);
						
						$Aspecto_Result->MoveNext();
						}				
						
						echo json_encode($As_Result);		
		
		}break;
	case 'AutoCompletar_Caracteritica':{
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
		
		$Letra   = $_REQUEST['term'];
		$Factor_id  = $_REQUEST['Factor_id'];
		
		    $SQL_Caracteristica='SELECT  

											idsiq_caracteristica As id,
											nombre
								
								FROM 
											siq_caracteristica
								
								WHERE
								
											nombre like  "%' .$Letra. '%"
											AND
											codigoestado=100
											AND
											idFactor="'.$Factor_id.'"';
											
								if($Carect_Result=&$db->Execute($SQL_Caracteristica)===false){
										echo 'Error en el SQL Caracteristicas....<br>'.$SQL_Caracteristica;
										die;
									}		
					#echo '<pre>';print_r($Carect_Result);
									
					$R_Caracteristica = array();
					
					while(!$Carect_Result->EOF){
						
							$C_Vectt['label']=$Carect_Result->fields['nombre'];
							$C_Vectt['value']=$Carect_Result->fields['nombre'];
							$C_Vectt['Caracteristica_id']=$Carect_Result->fields['id'];
						
						array_push($R_Caracteristica, $C_Vectt);
						
						$Carect_Result->MoveNext();
						}	
						
					echo json_encode($R_Caracteristica);						
		
		}break;
	case 'AutoCompletar':{
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
		
		include ('../API_Monitoreo.php'); $C_Api_Monitoreo = new API_Monitoreo();
		
		include ('../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();
		
		$List = $C_Api_Monitoreo->getQueryIndicadoresACargo();
		
		$Letra   = $_REQUEST['term'];
		$faculta_id  = $_REQUEST['faculta_id'];
		$Programa_id = $_REQUEST['Programa_id'];
		$Discriminacion_id  = $_REQUEST['Discriminacion_id'];
		
		
		if($faculta_id =='undefined' || $faculta_id =='-1'){
				$dato_faculta = '';
			}else{
					$dato_faculta = '';
				}
		if($Programa_id =='undefined' || $Programa_id =='-1'){
				$dato_programa = '';
			}else{
					$dato_programa = 'AND  ind.idCarrera = "'.$Programa_id.'"';
				}
		if($Discriminacion_id =='undefined' || $Discriminacion_id =='-1'){
				$dato_discrim='';
			}else{
					$dato_discrim=' AND ind.discriminacion="'.$Discriminacion_id.'"';
				}					
		  
		  
		   $SQL_Buscar='SELECT 
								ind.idsiq_indicador, 
								Gen.nombre as nom_indicador,
								Gen.idsiq_indicadorGenerico, 
								Gen.idAspecto, 
								ind.tiene_anexo, 
								ind.es_objeto_analisis, 
								ind.idEstado,
								ind.inexistente,
								ind.discriminacion,
								ind.idCarrera,
								Gen.idTipo,
								tipo.nombre,
								Gen.codigo 
						
						FROM 
								siq_indicador AS ind INNER JOIN siq_indicadorGenerico AS Gen  ON ind.idIndicadorGenerico=Gen.idsiq_indicadorGenerico 
													 INNER JOIN siq_tipoIndicador AS tipo ON tipo.idsiq_tipoIndicador=Gen.idTipo


						
						WHERE 
								(Gen.nombre LIKE "'.$Letra.'%"  OR  Gen.codigo LIKE "'.$Letra.'%")
								AND
								Gen.codigoestado=100
								AND 
								ind.codigoestado=100 
								AND
								tipo.codigoestado=100'.$dato_discrim.$dato_faculta.$dato_programa;
								
												
			if($R_Factor=&$db->Execute($SQL_Buscar)===false){
					echo 'Error en el SQl De las Budsqueda...<br>'.$SQL_Buscar;
					die;
				}		
			
			#echo '<pre>';print_r($R_Factor);die;
			#echo 'nombre'.$R_Factor->fields['nombre'];
			#echo '<br>nombre'.$R_Factor->fields[1];
			#echo $List;
			if($Lista_ind=&$db->Execute($List)===false){
					echo 'Error en el sql de la lista...<br>'.$List;
					die;
				}
			
			$R_Lista = $Lista_ind->GetArray();	
					
			$Result_F = array();
			
			while(!$R_Factor->EOF){
				
				for($j=0;$j<count($R_Lista);$j++){
						
						if($R_Factor->fields['idsiq_indicador']==$R_Lista[$j]['idsiq_indicador']){
							
							
				
				$Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$R_Factor->fields['idsiq_indicador']);
				
				for($i=0;$i<count($Permisos[1]);$i++){
						
						if($Permisos[1][$i]==1){
							
								 $SQL_OtherData='SELECT  

													siq_aspecto.idsiq_aspecto,
													siq_aspecto.idCaracteristica,
													siq_aspecto.nombre As aspecto_nom,
													siq_caracteristica.idsiq_caracteristica,
													siq_caracteristica.idFactor,
													siq_caracteristica.nombre As caracteristica_nom,
													siq_factor.idsiq_factor,
													siq_factor.nombre As factor_nom
										
										FROM 
										
													siq_aspecto,
													siq_caracteristica,
													siq_factor
										
										WHERE
										
													siq_aspecto.idsiq_aspecto="'.$R_Factor->fields['idAspecto'].'"
													AND
													siq_aspecto.idCaracteristica=siq_caracteristica.idsiq_caracteristica
													AND
													siq_caracteristica.idFactor=siq_factor.idsiq_factor
													AND
													siq_aspecto.codigoestado=100
													AND
													siq_caracteristica.codigoestado=100
													AND
													siq_factor.codigoestado=100';
													
										if($Other_Data=&$db->Execute($SQL_OtherData)===false){
												echo 'Error en el SQL Other data ....<br>'.$SQL_OtherData;
												die;
											}
					switch($R_Factor->fields['discriminacion']){
							case '1':{$Mas_data='';}break;
							case '2':{
								
								 $SQL_falcutad='SELECT 

														codigofacultad,
														nombrefacultad
											
											FROM 
											
														facultad
											
											WHERE
											
														codigofacultad="'.$R_Factor->fields['idFacultad'].'"';
														
														
										if($Facultad=&$db->Execute($SQL_falcutad)===false){
												echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
												die;
											}
											
							$Mas_data = ' :: '.$Facultad->fields['nombrefacultad'];	
								
								}break;
							case '3':{
								
								 $SQL_Carrera='SELECT 

													codigocarrera,
													nombrecarrera
											
											FROM 
											
													carrera
											
											WHERE
											
													codigocarrera="'.$R_Factor->fields['idCarrera'].'"';
													
											if($Carrera=&$db->Execute($SQL_Carrera)===false){
													echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
													die;
												}
												
							$Mas_data = ' :: '.$Carrera->fields['nombrecarrera'];	
								
								}break;
						}	
				
				
				
				
							
							$SQL_Discriminacion='SELECT  

															idsiq_discriminacionIndicador,
															nombre
												
												FROM 
												
															siq_discriminacionIndicador
												
												WHERE
															codigoestado=100
															AND
															idsiq_discriminacionIndicador="'.$R_Factor->fields['discriminacion'].'"';
															
												if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
														echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
														die;
													}		
													
										
				if($R_Factor->fields['idTipo']==1 && $R_Factor->fields['es_objeto_analisis']==0 && $R_Factor->fields['tiene_anexo']==0){
						
						$Tipo_Archivo='Principal';
						
					}
				if($R_Factor->fields['idTipo']==1 && $R_Factor->fields['es_objeto_analisis']==1 && $R_Factor->fields['tiene_anexo']==0){
						
						$Tipo_Archivo='Principal y Analisis';
						
					}
				if($R_Factor->fields['idTipo']==1 && $R_Factor->fields['es_objeto_analisis']==1 && $R_Factor->fields['tiene_anexo']==1){
						
						$Tipo_Archivo='Principal, Analisis y Anexo';
						
					}
				if($R_Factor->fields['idTipo']!=1 && $R_Factor->fields['es_objeto_analisis']==1 && $R_Factor->fields['tiene_anexo']==1){
						
						$Tipo_Archivo='Analisis y Anexo';
						
					}
				if($R_Factor->fields['idTipo']!=1 && $R_Factor->fields['es_objeto_analisis']==0 && $R_Factor->fields['tiene_anexo']==1){
						
						$Tipo_Archivo='Anexo';
						
					}				
				if($R_Factor->fields['idTipo']!=1 && $R_Factor->fields['es_objeto_analisis']==0 && $R_Factor->fields['tiene_anexo']==0){
						
						$Tipo_Archivo='No Tiene Archivo Relacionado';
						
					}										
										
				$Rf_Vectt['label']=$R_Factor->fields['codigo'].' :: '.$R_Factor->fields['nom_indicador'].' :: '.$Discriminacion->fields['nombre'].$Mas_data;
				$Rf_Vectt['value']=$R_Factor->fields['codigo'].' :: '.$R_Factor->fields['nom_indicador'].' '.$Mas_data;
				
				$Rf_Vectt['Inicador_id']=$R_Factor->fields['idsiq_indicador'];
				$Rf_Vectt['Aspecto_id']=$Other_Data->fields['idsiq_aspecto'];
				$Rf_Vectt['Caracteristica_id']=$Other_Data->fields['idsiq_caracteristica'];
				$Rf_Vectt['Factor_id']=$Other_Data->fields['idsiq_factor'];   
				
				$Rf_Vectt['Analisis']=$R_Factor->fields['es_objeto_analisis'];
				$Rf_Vectt['Anexo']=$R_Factor->fields['tiene_anexo'];
				$Rf_Vectt['idTipo_indicador']=$R_Factor->fields['idTipo'];
				$Rf_Vectt['NomTipo']=$R_Factor->fields['nombre'];
				$Rf_Vectt['NomArchivo']=$Tipo_Archivo;
				$Rf_Vectt['Estado']=$R_Factor->fields['idEstado'];
				
				$Rf_Vectt['nom_factor']=$Other_Data->fields['factor_nom'];
				$Rf_Vectt['nom_caracteristica']=$Other_Data->fields['caracteristica_nom'];
				$Rf_Vectt['nom_aspecto']=$Other_Data->fields['aspecto_nom'];
				$Rf_Vectt['nom_indicador']=$R_Factor->fields['nom_indicador'];
				$Rf_Vectt['Discriminacion']=$Discriminacion->fields['nombre'];
				$Rf_Vectt['Discri_value']=$R_Factor->fields['discriminacion'];
				$Rf_Vectt['tipo_discrimi']=$Mas_data;
				
				
				$Rf_Vectt['inexistente']=$R_Factor->fields['inexistente'];
				
				
							
							}
					
					}
				
					array_push($Result_F,$Rf_Vectt);
					
							}
					}
				$R_Factor->MoveNext();	
				}
				
			echo json_encode($Result_F);	
								
		}break;
	default:{
		global $C_Carga_Documento,$userid;
		MainGeneral();
		JsGenral();
		$C_Carga_Documento->Principal();
		}break;
	}
function MainGeneral(){
		include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
	
	global $C_Carga_Documento,$userid;
	
	
		include('Carga_Documento.class.php');  $C_Carga_Documento = new Carga_Documento();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];
	}	

function JsGenral(){
	?>
<style type="text/css" title="currentStyle">
                @import "../css/normalize.css";
                @import "../../css/demo_page.css";
                @import "../../css/demo_table_jui.css";
                @import "../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
</style>    
<script src="../js/jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="../js/jquery_ui/js/jquery-ui.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<link rel="stylesheet" rev="stylesheet" href="../js/jquery_ui/css/ui-lightness/jquery-ui.custom.css" media="all" />
<link rel="stylesheet" href="../css/Style_Bosque.css" type="text/css" />
<script>
function formReset(Op){
	var Dato = Op;
		switch(Dato){
				case'1':{
						$('#Factor').val('');
						$('#Factor_id').val('');
						$('#Carecteristicas').val('');
						$('#caracteristica_id').val('');
						$('#Aspecto').val('');
						$('#Aspecto_id').val('');
						$('#Indicador').val('');
						$('#Inicador_id').val('');
				        }break;
				case'2':{
						$('#Carecteristicas').val('');
						$('#caracteristica_id').val('');
						$('#Aspecto').val('');
						$('#Aspecto_id').val('');
						$('#Indicador').val('');
						$('#Inicador_id').val('');
						}break;
				case'3':{
						$('#Aspecto').val('');
						$('#Aspecto_id').val('');
						$('#Indicador').val('');
						$('#Inicador_id').val('');
						}break;
				case'4':{
						$('#Indicador').val('');
						$('#Inicador_id').val('');
						}break;
			}
	}
 function Box_Caracteritica(factor_id){
	  $.ajax({
               type: 'GET',
               url: 'Carga_Documento.html.php',
               data:({actionID: 'VerBox_Carectisca',factor_id:factor_id}),
               success: function(data){
                 $('#Caracteistica_Box').html(data);
               } 
            });
	 }
 function Box_Aspecto(Caracteristica_id){
	  $.ajax({
               type: 'GET',
               url: 'Carga_Documento.html.php',
               data:({actionID: 'VerBox_Aspecto',Caracteristica_id:Caracteristica_id}),
               success: function(data){
                 $('#Aspecto_Box').html(data);
               } 
            });
	 }	 
 function Box_Indicador(Aspecto_id){
	  $.ajax({
               type: 'GET',
               url: 'Carga_Documento.html.php',
               data:({actionID: 'VerBox_Indicador',Aspecto_id:Aspecto_id}),
               success: function(data){
                 $('#Indicador_Box').html(data);
               } 
            });
	 }	 
 function Validar(){
	 	/*if(!$.trim($('#Factor_id').val())){
				alert('Inserte un Factor...!');
				return false;
			}
			
		if(!$.trim($('#caracteristica_id').val())){
				alert('Ingrese una Caracteristica...!');
				return false;
			}	
			
		if(!$.trim($('#Aspecto_id').val())){
				alert('Ingrese un Aspecto...!');
				return false;
			}	*/
			
		if(!$.trim($('#Inicador_id').val())){
				alert('Ingrese El Nombre del Indicador...!');
				return false;
			}
			
			if(!$.trim($('#file').val())){
					alert('Carge un Archivo...!');
					return false;
				}
		
		if($('#Tipo_Carga').val()==-1){
				alert('Elige un tipo de documento...!');
				return false;
			}
		
		if(!$.trim($('#Descripcion').val())){
				alert('Ingrese la descripcion del Archivo...!');
				return false;
			}
				
		return true;		
	 }
         
function ValidarHuefana(){
    if(!$.trim($('#numPestana').val()) || !$.trim($('#idFormulario').val())){
	alert('La información referente al formulario asociado no es correcta.');
	return false;
    }
			
    if(!$.trim($('#file').val())){
		alert('Debe elegir un archivo para cargar.');
		return false;
    }
		
    if($('#Tipo_Carga').val()==-1){
		alert('Por favor elija un tipo de documento.');
		return false;
    }
		
    if(!$.trim($('#Descripcion').val())){
	alert('Debe ingresar una descripción para el archivo antes de continuar.');
	return false;
    }
				
    return true;	
}         
function Ver_Box(){
		if($('#URL_id').is(':checked')){
				$('#Tr_URL').css('visibility','visible');
				$('#TR_Cargar').css('visibility','collapse');
				$('#File_Sub').css('display','inline');
				$('#Save_Ok').css('display','none');
			}
			
		if($('#Cargar_id').is(':checked')){
				$('#TR_Cargar').css('visibility','visible');
				$('#Tr_URL').css('visibility','collapse');
				$('#Save_Ok').css('display','inline');
				$('#File_Sub').css('display','none');
			}	
	}
function Save_Documento(){
	
		if(!$.trim($('#Factor_id').val())){
				alert('Inserte un Factor...!');
				return false;
			}
			
		if(!$.trim($('#caracteristica_id').val())){
				alert('Ingrese una Caracteristica...!');
				return false;
			}	
			
		if(!$.trim($('#Aspecto_id').val())){
				alert('Ingrese un Aspecto...!');
				return false;
			}	
			
		if(!$.trim($('#Inicador_id').val())){
				alert('Ingrese un Indicador...!');
				return false;
			}
		
		if(!$.trim($('#url_Ubicacion').val())){
				alert('Ingrese la Ubicacion del Documento...!');
				return false;
			}
			
		if($('#Tipo_URl').val()==-1){
				alert('Eliga un Tipo de Documento...!');
				return false;
			}	
		
		if(!$.trim($('#Descripcion').val())){
				alert('Ingrese la descripcion del Archivo...!');
				return false;
			}	
			
		/*******************************************************************/
		
		var Factor_id              = $('#Factor_id').val();
		var caracteristica_id      = $('#caracteristica_id').val();
		var Aspecto_id             = $('#Aspecto_id').val();
		var Inicador_id            = $('#Inicador_id').val();
		var url_Ubicacion          = $('#url_Ubicacion').val();
		var Descripcion            = $('#Descripcion').val();
		var Tipo				   = $('#Tipo_URl').val();
		var Periodo                = $('#Periodo').val();
		
		$.ajax({
               type: 'GET',
               url: 'Carga_Documento.html.php',
			   dataType: 'json',
               data:({actionID: 'Save',Factor_id:Factor_id,
			   						   caracteristica_id:caracteristica_id,
									   Aspecto_id:Aspecto_id,
									   Inicador_id:Inicador_id,
									   url_Ubicacion:url_Ubicacion,
									   Descripcion:Descripcion,
									   Tipo:Tipo,
									   Periodo:Periodo}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
                 		if(data.val=='FALSE'){
								alert(data.descrip);
								return false;
							}else{
								alert(data.descrip);
								location.href='Carga_Documento.html.php';
								}
               } 
            });
			
	}	
function validar_tipo(dato,Tp,An,Ax){
		
		var Tipo_indicador = $('#Tipo_indicador').val();
		var Anexo          = $('#Anexo').val();
		var Analisi        = $('#Analisi').val();
		
		switch(dato){
				case '0':{
					if(Tipo_indicador!=1){
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador no es Documental...!');
							return false;
						}
					}break;
				case '1':{
					if(Tipo_indicador!=1){
						if(Analisi!=1){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador No tiene \n Asociado un Documento de Analisis...!');
							return false;
						   }
						}else{
							if(Analisi!=1){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador No tiene \n Asociado un Documento de Analisis...!');
							return false;
						   }
							}
					}break;
				case '2':{
					if(Tipo_indicador!=1){
						if(Anexo!=1){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
							return false;
						   }
						}else{
							if(Anexo!=1){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
							return false;
						   }
							}
					}break;
				case'3':{
					
					 if(Tp!=1){
							if(Ax!=1 && An!=1){
									alert('El Indicador Selecionado No es de Tipo Documental y No tiene asociado \n un Documento Analisis o Anexo');
									return false;
								}
						}
					}break;
			}
		
	}	
function Activar(){
	
		var Discriminacion  = $('#Discriminacion_id').val();
		
		if(Discriminacion==3){	
		 
			$('#td_programa').css('visibility','visible');
			$('#Div_Programa').css('display','none');
			//$('#Div_Programa').html(data);
			/*************************/
			$('#td_Faculta').css('visibility','visible');
			$('#Div_Faculta').css('display','inline');
			//$('#faculta_id').val('-1');
						   
              
          
		}else if(Discriminacion==1){
			
				$('#td_programa').css('visibility','collapse');
				$('#Div_Programa').css('display','none');
				$('#Programa_id').val('-1');
						
				$('#td_Faculta').css('visibility','collapse');
				$('#Div_Faculta').css('display','none');
				$('#faculta_id').val('-1');		
			
			}
	}	
 function Program_ver(id){
	 
	 	var Discriminacion  = $('#Discriminacion_id').val();
		
		if(Discriminacion==3){	
		 $.ajax({
               type: 'GET',
               url: 'Carga_Documento.html.php',
               data:({actionID: 'Select_Ajax',Discriminacion:Discriminacion,id:id}),
               success: function(data){
					   
						   	$('#td_programa').css('visibility','visible');
							$('#Div_Programa').css('display','inline');
						   	$('#Div_Programa').html(data);
							/*************************/
							$('#td_Faculta').css('visibility','visible');
							$('#Div_Faculta').css('display','inline');
							//$('#faculta_id').val('-1');
               } 
            });	
		}else  if(Discriminacion==1){
			
				$('#td_programa').css('visibility','collapse');
				$('#Div_Programa').css('display','none');
				$('#Programa_id').val('-1');
						
				$('#td_Faculta').css('visibility','collapse');
				$('#Div_Faculta').css('display','none');
				$('#faculta_id').val('-1');		
			
			}
	 }
	function CambiarDoc(j){
		
			if(j==1){
				$('#tipoDoc').html('10 Mb Max / PDF');
				}else{
					$('#tipoDoc').html('10 Mb Max / Word');
					}
		
		} 		 
</script>
<?PHP 
}
?>