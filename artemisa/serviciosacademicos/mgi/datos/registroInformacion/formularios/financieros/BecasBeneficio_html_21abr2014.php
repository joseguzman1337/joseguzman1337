<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
    case 'form_apoyos':{
        global $userid,$db;
		JsonGenral();
        
        $Data_LastId    =  $_POST['Data'];
        $Data           =  explode('::',$_POST['CheckValidado']);
        
        for($i=0;$i<count($Data_LastId);$i++){
            /************************************/
            
              $SQL='SELECT idCategory 
                    FROM   siq_formCreditoYCarteraApoyos 
                    WHERE  idsiq_formCreditoYCarteraApoyos="'.$Data_LastId[$i].'"
                           AND codigoestado=100';  
                           
              if($C_Categoria=&$db->Execute($SQL)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error al Agregar elValidar del Campo del Valor....'.$SQL;
                    echo json_encode($a_vectt);    
                    exit;
              }//if
              
              if(!$D_idCategoria->EOF){
                
                    $id_Category = $C_Categoria->fields['idCategory'];
                    
                    for($j=1;$j<count($C_Data);$j++){
                        /***********************************/
                            if($id_Category==$C_Data[$j]){
                                /***************************/
                                $Update='UPDATE siq_formCreditoYCarteraApoyos
                                
                                         SET    fecha_modificacion=NOW(),
                                                usuario_modificacion="'.$userid.'",
                                                validado=1
                                                
                                         WHERE  
                                                idsiq_formCreditoYCarteraApoyos="'.$Data_LastId[$i].'"
                                                AND
                                                codigoestado=100
                                                AND
                                                idCategory="'.$id_Category.'"';/*Falta crear el campo validado*/
                                                
                                     if($Validado=&$db->Execute($Update)===false){
                                        $a_vectt['val']			='FALSE';
                                        $a_vectt['descrip']		='Error al Activar el Validar....'.$Update;
                                        echo json_encode($a_vectt);    
                                        exit;
                                     }//if           
                                /***************************/
                            }//if
                        /***********************************/
                    }//for    
                    
                }//if             
            
            /************************************/
        }//for 
        
    }break;
	case 'form_descuentosValidar':{
	   global $userid,$db;
		JsonGenral();
        
        $Data_LastId    = $_POST['Data_LastId'];
        $DataValida     = $_POST['DataValida'];
        
        $C_Data     = explode('::',$DataValida);
        
        //echo '<pre>';print_r($C_Data);die;
        
        for($i=0;$i<count($Data_LastId);$i++){
            /**********************************/
                
                $SQL='SELECT idCategory 
                      FROM   siq_detalleformCreditoYCarteraDescuentos 
                      WHERE  idsiq_detalleformCreditoYCarteraDescuentos="'.$Data_LastId[$i].'"
                             AND
                             codigoestado=100';
                             
                if($D_idCategoria=&$db->Execute($SQL)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error al Agregar elValidar del Campo del Valor....'.$SQL;
                    echo json_encode($a_vectt);    
                    exit;
                }//if             
                
                if(!$D_idCategoria->EOF){
                
                    $id_Category = $D_idCategoria->fields['idCategory'];
                    
                    for($j=1;$j<count($C_Data);$j++){
                        /***********************************/
                            if($id_Category==$C_Data[$j]){
                                /***************************/
                                $Update='UPDATE siq_detalleformCreditoYCarteraDescuentos
                                
                                         SET    fecha_modificacion=NOW(),
                                                usuario_modificacion="'.$userid.'",
                                                validado=1
                                                
                                         WHERE  
                                                idsiq_detalleformCreditoYCarteraDescuentos="'.$Data_LastId[$i].'"
                                                AND
                                                codigoestado=100
                                                AND
                                                idCategory="'.$id_Category.'"';/*Falta crear el campo validado*/
                                                
                                     if($Validado=&$db->Execute($Update)===false){
                                        $a_vectt['val']			='FALSE';
                                        $a_vectt['descrip']		='Error al Activar el Validar....'.$Update;
                                        echo json_encode($a_vectt);    
                                        exit;
                                     }//if           
                                /***************************/
                            }//if
                        /***********************************/
                    }//for    
                    
                }//if
                
            /**********************************/
        }//for
        
        $a_vectt['val']			='TRUE';
        //$a_vectt['descrip']		='Error al Activar el Validar....'.$Update;
        echo json_encode($a_vectt);    
        exit;
        
	}break;
	case 'ViewReporte':{
		global $userid,$db,$C_BecasBeneficio;
			
			MainGeneral();
			JsGeneral();
			
			$C_BecasBeneficio->ViewReporte();
		}break;
	case 'Reporte':{
		global $userid,$db,$C_BecasBeneficio;
			
			MainGeneral();
			JsGeneral();
			
		$C_BecasBeneficio->Reporte($_GET['codigoperiodo'],$_GET['Modalidad'],$_GET['id_Modalidad']);	
		}break;
	case 'Save':{
		global $userid,$db;
		JsonGenral();
		
		$id_modalidad		= $_GET['id_modalidad'];
		$Cadena				= $_GET['Cadena'];
		$Periodo			= $_GET['Periodo'];
		
		$D_Cadena			= explode('::',$Cadena);
		
		   $SQL_Valida='SELECT 
						
						becasbeneficio_id,
						modalidadsic_id,
						periodo
						
						FROM 
						
						becasbeneficio
						
						WHERE
						
						codigoestado=100
						AND
						modalidadsic_id="'.$id_modalidad.'"
						AND
						periodo="'.$Periodo.'"';
						
				if($BecaValida=&$db->Execute($SQL_Valida)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Validar las Becas Beneficio.....'.$SQL_Valida;
						echo json_encode($a_vectt);    
						exit;
					}		
		
		if($BecaValida->EOF){
		
			for($i=1;$i<count($D_Cadena);$i++){
				/**********************************************************************/
					$Datos		= explode('-',$D_Cadena[$i]);
					
					/*
						$Datos[0]	= CodigoCarrera
						$Datos[1]	= B_Academica
						$Datos[2]	= B_Poblaciones
						$Datos[3]	= B_Grado
						$Datos[4]	= B_Graduandos
					*/
					
					
					$SQL_Insert='INSERT INTO becasbeneficio(modalidadsic_id,carrera_id,academica,poblaciones,grado,graduandos,periodo,entrydate,userid) VALUES ("'.$id_modalidad.'","'.$Datos[0].'","'.$Datos[1].'","'.$Datos[2].'","'.$Datos[3].'","'.$Datos[4].'","'.$Periodo.'",NOW(),"'.$userid.'")';
					
						if($BecasBeneficio=&$db->Execute($SQL_Insert)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar las Becas Beneficio.....'.$SQL_Insert;
								echo json_encode($a_vectt);    
								exit;
							}
					
				/**********************************************************************/
				}#For
			/***************************************/	
				$a_vectt['val']			='TRUE';
				$a_vectt['descrip']		='Se HA Guardado Correctamente.';
				echo json_encode($a_vectt);    
				exit;
			/***************************************/
			}else{
				/**************************************************/
					$a_vectt['val']			='Existe';
					$a_vectt['descrip']		='Ya Existe Informacion Para el Periodo...'.$Periodo;
					echo json_encode($a_vectt);    
					exit;
				/**************************************************/
				}
		}break;
	case 'Buscar':{
		global $userid,$db,$C_BecasBeneficio;
			
			MainGeneral();
			JsGeneral();
			
			$C_BecasBeneficio->DibujaTabla($_GET['id_modalidad']);
		}break;
	case 'autoCompleModalidad':{
		global $userid,$db;
		JsonGenral();
		
		$Letra   = $_REQUEST['term'];
		
		$SQL_Modalidad='SELECT 

						codigomodalidadacademicasic  AS id,
						nombremodalidadacademicasic  AS Nombre 
						
						 FROM modalidadacademicasic
						
						WHERE
						
						codigoestado=100
						AND
						nombremodalidadacademicasic LIKE "%'.$Letra.'%"';
						
				if($D_Movilidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Autocompletar Movilidad...'.$SQL_Modalidad;
						die;
					}	
					
			$Result_F = array();
				
				if(!$D_Movilidad->EOF){
									
					while(!$D_Movilidad->EOF){
						
							$Rf_Vectt['label']=$D_Movilidad->fields['Nombre'];
							$Rf_Vectt['value']=$D_Movilidad->fields['Nombre'];
							
							$Rf_Vectt['id_modalidad']=$D_Movilidad->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Movilidad->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);				
		
		}break;
	default:{
			global $userid,$db,$C_BecasBeneficio;
			
			MainGeneral();
			JsGeneral();
			
			$C_BecasBeneficio->Principal();
			
			
		}break;
	}
function MainGeneral(){
	
		global $userid,$db,$C_BecasBeneficio;
		
	    include_once ('BecasBeneficio_Class.php'); $C_BecasBeneficio = new BecasBeneficio();
		include_once("../../../menuGeneral.php");
		
		
			
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	
	}	
	
function JsonGenral(){
		
		global $userid,$db;
	    include("../../../templates/template.php");
		
		$db=getBD();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
		
	}	
function JsGeneral(){
	?>
    <script>
    function isNumberKey(evt){
			var e = evt; 
			var charCode = (e.which) ? e.which : e.keyCode
				console.log(charCode);
				
				//el comentado me acepta negativos
			//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
				if( charCode > 31 && (charCode < 48 || charCode > 57) ){
					//si no es - ni borrar
					if((charCode!=8 && charCode!=45)){
						return false;
					}
				}
		
			return true;
		}
	function FormatModalidad(){
			$('#Modalidad').val('');
			$('#id_Modalidad').val('');
		}	
	function AutocompletModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						
						source: "./formularios/financieros/BecasBeneficio_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Modalidad').val(ui.item.id_modalidad);
							
							DibujaTabla(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
	function DibujaTabla(id_modalidad){
			/***************************AJAX***************************************/
				
				 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/BecasBeneficio_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'Buscar',id_modalidad:id_modalidad}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#CargarData').html(data);
							$('#Guardar').css('display','inline');
				   },
				}); //AJAX
			
			/***************************AJAX***************************************/
		}			
	function Save(){
			var index			= $('#index').val();
			var Periodo			= $('#Periodo').val();
			
			if(Periodo==-1 || Periodo=='-1'){
					alert('Seleccione el Periodo');
					$('#Periodo').css('border-color','#F00');
					$('#Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			for(i=0;i<index;i++){
				/********************************************/
					var B_Academica		= $('#B_Academica_'+i).val();
					var B_Poblaciones	= $('#B_Poblaciones_'+i).val();
					var B_Grado			= $('#B_Grado_'+i).val();
					var B_Graduandos	= $('#B_Graduandos_'+i).val();
					
					if(!$.trim(B_Academica) && !$.trim(B_Poblaciones) && !$.trim(B_Grado) && !$.trim(B_Graduandos)){
						/*******************************************************************************/
						alert('Digite la Informacion o Datos en Uno o en Todos los Siguientes Campos');
							/*************************************************/
							$('#B_Academica_'+i).css('border-color','#F00');
							$('#B_Academica_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#B_Poblaciones_'+i).css('border-color','#F00');
							$('#B_Poblaciones_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#B_Grado_'+i).css('border-color','#F00');
							$('#B_Grado_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#B_Graduandos_'+i).css('border-color','#F00');
							$('#B_Graduandos_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							
							return false;
						/*******************************************************************************/
						}
				/********************************************/
				}/*for*/
		/**********************************************************************************************/
			for(i=0;i<index;i++){
				/********************************************/
					var B_Academica		= $('#B_Academica_'+i).val();
					var B_Poblaciones	= $('#B_Poblaciones_'+i).val();
					var B_Grado			= $('#B_Grado_'+i).val();
					var B_Graduandos	= $('#B_Graduandos_'+i).val();
					var CodigoCarrera	= $('#CodigoCarrera_'+i).val();
					
					$('#Cadena').val($('#Cadena').val()+'::'+CodigoCarrera+'-'+B_Academica+'-'+B_Poblaciones+'-'+B_Grado+'-'+B_Graduandos);
					
			}
		/****************************************AJAX*************************************************/	
			var id_modalidad		= $('#id_Modalidad').val();
			var Cadena				= $('#Cadena').val();
			
			 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/BecasBeneficio_html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Save',id_modalidad:id_modalidad,
					  						 Cadena:Cadena,
											 Periodo:Periodo}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
									alert(data.descrip);
									location.href='index.php';
									}else if(data.val=='Existe'){
										alert(data.descrip);
										location.href='index.php';
										}
				   },
			}); //AJAX
		/****************************************AJAX*************************************************/		
			
		}	
	function VerReporte(){
		
			var codigoperiodo	= $('#Periodo_Reporte').val();
			var Modalidad		= $('#Modalidad').val();
			var id_Modalidad	= $('#id_Modalidad').val();
			
			if(!$.trim(Modalidad)){
					alert('Digite una Modalidad a Buscar');
					return false;
				}
			
			if(codigoperiodo!=-1 || codigoperiodo!='-1'){
				/***************************************************************/
				
					 $.ajax({//Ajax
						  type: 'GET',
						  url: '../registroInformacion/formularios/financieros/BecasBeneficio_html.php',
						  async: false,
						  //dataType: 'json',
						  data:({actionID:'Reporte',codigoperiodo:codigoperiodo,Modalidad:Modalidad,id_Modalidad:id_Modalidad}),
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success:function(data){
								$('#CargarReporte').html(data);
					   },
				}); //AJAX
			}
		}
	function AutoModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						
						source: "../registroInformacion/formularios/financieros/BecasBeneficio_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Modalidad').val(ui.item.id_modalidad);
						
							
							}
						
					});//
			/********************************************************/	
			}			
    </script>
    <?PHP
	}
?>