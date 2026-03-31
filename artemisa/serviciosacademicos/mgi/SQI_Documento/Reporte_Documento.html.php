<?PHP 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
switch($actionID){
	case 'Permisos':{
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		include ('../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();
		$id = $_GET['id'];
		
		$SQL_Indi='SELECT siqindicador_id FROM siq_documento WHERE idsiq_documento="'.$id.'" and codigoestado=100';	
		
		if($Indicador=&$db->Execute($SQL_Indi)===false){
				echo 'Error en el SQL del Indicador ...<br>'.$SQL_Indi;
				die;
			}
		$Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$Indicador->fields['siqindicador_id']);	
		#echo '<pre>';print_r($Permisos);
		if(!$Permisos[1]){
				$a_vectt['val']			='FALSE';
				#$a_vectt['descrip']		='Error al Insertar El Documento....<br>'.$SQL_Insert;
				echo json_encode($a_vectt);
				exit;
			}else{
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error al Insertar El Documento....<br>'.$SQL_Insert;
				echo json_encode($a_vectt);
				exit;
				}
		
		}break;
	case 'Buscar':{
		global $db, $C_Reporte_Documento,$C_Api_Monitoreo;
		MainGeneral();
		JsGeneral();
		
		$Filtro  = $_GET['Filtro'];
		$id_filtro  = $_GET['id_filtro'];
		$fecha_ini = $_GET['fecha_ini'];
		$fecha_fin = $_GET['fecha_fin'];
		
		$C_Reporte_Documento->Resultado($Filtro,$id_filtro,$fecha_ini,$fecha_fin);
		
		}break;
	case 'AutoCompletar':{
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		include_once ('../API_Monitoreo.php'); $C_Api_Monitoreo = new API_Monitoreo();
		$List = $C_Api_Monitoreo->getQueryIndicadoresACargo();
		
		$Letra   = $_REQUEST['term'];
		$tipo    = $_REQUEST['Tipo'];
		
		
		
		if($tipo==0){
					$SQL_Filtro='SELECT  
											siq_factor.idsiq_factor As id,
											siq_factor.nombre
									FROM 
									
											siq_factor 
				
									
									WHERE
									
											(siq_factor.nombre like  "%' . $Letra . '%"  OR  siq_factor.idsiq_factor like  "%' . $Letra . '%")
											AND
											siq_factor.codigoestado=100';
				    }
			if($tipo==1){
					$SQL_Filtro='SELECT  

											idsiq_caracteristica As id,
											nombre
								
								FROM 
											siq_caracteristica
								
								WHERE
								
											(nombre like  "%' .$Letra. '%"   OR  idsiq_caracteristica like  "%' . $Letra . '%")
											AND
											codigoestado=100';
					}
				if($tipo==2){
					   $SQL_Filtro='SELECT 
			
											idsiq_aspecto as id,
											nombre
									
									FROM 
											siq_aspecto
									
									WHERE
									
											(nombre like "%' . $Letra . '%"  OR  idsiq_aspecto like  "%' . $Letra . '%")
											AND
											codigoestado=100';
					}
				if($tipo==3){
					
					 $SQL_Filtro='SELECT 
												siq_indicador.idsiq_indicador as id,
												siq_indicadorGenerico.nombre,
												siq_indicador.discriminacion,
												siq_indicador.idCarrera,
												siq_indicadorGenerico.codigo
									
									FROM 
												siq_indicador,
												siq_indicadorGenerico
									WHERE
									
												(siq_indicadorGenerico.nombre like "' . $Letra . '%"  OR  siq_indicador.idsiq_indicador   like "' . $Letra . '%"  OR siq_indicadorGenerico.codigo like "' . $Letra . '%"
)
												AND
												siq_indicadorGenerico.codigoestado=100
												AND
												siq_indicador.codigoestado=100
												AND
												siq_indicadorGenerico.idsiq_indicadorGenerico=siq_indicador.idIndicadorGenerico';
												
					}
					
				  
				if($Result_filtro=&$db->Execute($SQL_Filtro)===false){
						echo 'Error en la busqueda del filtro...<br>'.$SQL_Filtro;
						die;
					}
					
		            $Filtro_R = array();
					
					if($Lista=&$db->Execute($List)===false){
						echo 'Error en el SQL de la lista...<br>'.$List;
						die;
					}
							$R_lista=$Lista->GetArray();
							
							#echo '<pre>';print_r($R_lista);die;
							
					while(!$Result_filtro->EOF){
						
						if($tipo==3){
							
							
							
							
							for($j=0;$j<count($R_lista);$j++){
									
									if($Result_filtro->fields['id']==$R_lista[$j]['idsiq_indicador']){
										
									#echo '<br> aca...';	die;
										
						switch($Result_filtro->fields['discriminacion']){
							case '1':{$Mas_data='';
							
							}break;
							case '2':{
								
								 $SQL_falcutad='SELECT 

														codigofacultad,
														nombrefacultad
											
											FROM 
											
														facultad
											
											WHERE
											
														codigofacultad="'.$Result_filtro->fields['idFacultad'].'"';
														
														
										if($Facultad=&$db->Execute($SQL_falcutad)===false){
												echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
												die;
											}
											
							$Mas_data = '  ::  '.$Facultad->fields['nombrefacultad'];	
								
								}break;
							case '3':{
								
								 $SQL_Carrera='SELECT 

													codigocarrera,
													nombrecarrera
											
											FROM 
											
													carrera
											
											WHERE
											
													codigocarrera="'.$Result_filtro->fields['idCarrera'].'"';
													
											if($Carrera=&$db->Execute($SQL_Carrera)===false){
													echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
													die;
												}
												
							$Mas_data = '  ::  '.$Carrera->fields['nombrecarrera'];	
								
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
															idsiq_discriminacionIndicador="'.$Result_filtro->fields['discriminacion'].'"';
															
												if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
														echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
														die;
													}		
						
							
								
							$a_Vectt['label']=$Result_filtro->fields['codigo'].' :: '.$Result_filtro->fields['nombre'].'  ::  '.$Discriminacion->fields['nombre'].$Mas_data;
							$a_Vectt['value']=$Result_filtro->fields['codigo'].' :: '.$Result_filtro->fields['nombre'].'  ::  '.$Discriminacion->fields['nombre'].$Mas_data;
							$a_Vectt['Filtro_id']=$Result_filtro->fields['id'];
							
							array_push($Filtro_R, $a_Vectt);
										
										
										
										}
								}
							
							}else{
								
								
						switch($Result_filtro->fields['discriminacion']){
							case '1':{$Mas_data='';}break;
							case '2':{
								
								 $SQL_falcutad='SELECT 

														codigofacultad,
														nombrefacultad
											
											FROM 
											
														facultad
											
											WHERE
											
														codigofacultad="'.$Result_filtro->fields['idFacultad'].'"';
														
														
										if($Facultad=&$db->Execute($SQL_falcutad)===false){
												echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
												die;
											}
											
							$Mas_data = '  ::  '.$Facultad->fields['nombrefacultad'];	
								
								}break;
							case '3':{
								
								 $SQL_Carrera='SELECT 

													codigocarrera,
													nombrecarrera
											
											FROM 
											
													carrera
											
											WHERE
											
													codigocarrera="'.$Result_filtro->fields['idCarrera'].'"';
													
											if($Carrera=&$db->Execute($SQL_Carrera)===false){
													echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
													die;
												}
												
							$Mas_data = '  ::  '.$Carrera->fields['nombrecarrera'];	
								
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
															idsiq_discriminacionIndicador="'.$Result_filtro->fields['discriminacion'].'"';
															
												if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
														echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
														die;
													}		
						
							
						
							$a_Vectt['label']=$Result_filtro->fields['codigo'].' :: '.$Result_filtro->fields['nombre'].'  ::  '.$Discriminacion->fields['nombre'].$Mas_data;
							$a_Vectt['value']=$Result_filtro->fields['codigo'].' :: '.$Result_filtro->fields['nombre'].'  ::  '.$Discriminacion->fields['nombre'].$Mas_data;
							$a_Vectt['Filtro_id']=$Result_filtro->fields['id'];
							
							array_push($Filtro_R, $a_Vectt);
							}
						$Result_filtro->MoveNext();
						}				
					
					echo json_encode($Filtro_R);	
		
		}break;
	case 'VerBox':{
		global $db, $C_Reporte_Documento;
		MainGeneral();
		JsGeneral();
		
		$C_Reporte_Documento->Box_new($_GET['Tipos']);
		}break;
	default:{
		global $db, $C_Reporte_Documento;
		MainGeneral();
		JsGeneral();
		
		$C_Reporte_Documento->Principal();
		}break;	
	}
function MainGeneral(){
	global $db, $C_Reporte_Documento,$C_Api_Monitoreo;
	    require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
		include('Reporte_Documento.class.php'); $C_Reporte_Documento =new Reporte_Documento();
		
		include ('../API_Monitoreo.php'); $C_Api_Monitoreo = new API_Monitoreo();
	}
function JsGeneral(){
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
	 $(document).ready(function() {
        $("#fechainicio").datepicker({ 
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "../../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
       
        $("#fechafin").datepicker({ 
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "../../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
    });
    function Cargar_filtro(){
		var Tipos= $('#Tipos').val();	
		
		if(Tipos==-1){
				alert('Seelcione un Tipo de Filtro...!');
				return false;
			}
		if(Tipos==0){
				$('#Nom_filtro').html('Factor');
			}
		if(Tipos==1){
				$('#Nom_filtro').html('Caracteristica');
			}
		if(Tipos==2){
				$('#Nom_filtro').html('Aspecto');
			}	
		if(Tipos==3){
				$('#Nom_filtro').html('Indicador');
			}
		 $.ajax({
               type: 'GET',
               url: 'Reporte_Documento.html.php',
               data:({actionID: 'VerBox',Tipos:Tipos}),
               success: function(data){
                 $('#Box').html(data);
               } 
            });				
	}
function formReset(){
		$('#Filtro').val('');
		$('#Filtro_id').val('');
	}	
function Buscar(){
		
		var Filtro_id  = $('#Filtro_id').val();
		
		var fecha_ini = $('#fechainicio').val();
		
		var fecha_fin = $('#fechafin').val();
		if($('#Tipos').val()==0){//Factor
				var Filtro = '0';
			}
		if($('#Tipos').val()==1){//Factor
				var Filtro = '1';
			}
		if($('#Tipos').val()==2){//Factor
				var Filtro = '2';
			}	
		if($('#Tipos').val()==3){//Factor
				var Filtro = '3';
			}	
				
				 $.ajax({
					   type: 'GET',
					   url: 'Reporte_Documento.html.php',
					   data:({actionID: 'Buscar',Filtro:Filtro,id_filtro:Filtro_id,fecha_ini:fecha_ini,fecha_fin:fecha_fin}),
					   success: function(data){
						 $('#Divdetalles').html(data);
					   } 
					});	
		
	}
function Busca_active(){
		if($('#All_data').is(':checked')){
				/*********************************/
				$('#Filtro').attr('disabled',true);
				$('#Tipos').val('-1');
				$('#Tipos').attr('disabled',true);
				/*********************************/
				
				var Filtro = '4';
				var fecha_ini = $('#fechainicio').val();
				var fecha_fin = $('#fechafin').val();
				
				 $.ajax({
					   type: 'GET',
					   url: 'Reporte_Documento.html.php',
					   data:({actionID: 'Buscar',Filtro:Filtro,fecha_ini:fecha_ini,fecha_fin:fecha_fin}),
					   success: function(data){
						 $('#Divdetalles').html(data);
					   } 
					});	
				
			}else{
					/*********************************/
					$('#Filtro').attr('disabled',false);
					$('#Tipos').val('-1');
					$('#Tipos').attr('disabled',false);
					/*********************************/
				}
	}
function Modificar(id){
	
		$.ajax({
               type: 'GET',
               url: 'Reporte_Documento.html.php',
			   dataType: 'json',
               data:({actionID: 'Permisos',id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
                 		if(data.val=='FALSE'){
								alert('El Usuario No tiene Permisos...');
								location.href='Reporte_Documento.html.php';
								
							}else{
								location.href='Documento_Ver.html.php?actionID=NuevoModificar&Docuemto_id='+id;
								}
               } 
            });
		
		
	}			
    </script>
    <?PHP
	}		
?>