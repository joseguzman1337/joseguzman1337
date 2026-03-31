<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'ViewReporte':{
		global $userid,$db,$C_EstudianteBenficiados;
			
			MainGeneral();
			JsGeneral();
			
			$C_EstudianteBenficiados->ViewReporte();
		}break;
	case 'Reporte':{
		global $userid,$db,$C_EstudianteBenficiados;
			
			MainGeneral();
			JsGeneral();
			
		$C_EstudianteBenficiados->Reporte($_GET['codigoperiodo'],$_GET['Modalidad'],$_GET['id_Modalidad']);	
		}break;
	case 'Save':{
		global $userid,$db;
		JsonGenral();
		
		$id_modalidad		= $_GET['id_modalidad'];
		$Cadena				= $_GET['Cadena'];
		$Periodo			= $_GET['Periodo'];
		
		$D_Cadena			= explode('::',$Cadena);
		
		   $SQL_Valida='SELECT 
						
						Estudiatebenficio_id,
						modalidadsic_id,
						periodo
						
						FROM 
						
						estudiantebeneficio
						
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
						$Datos[1]	= Apoyos
						$Datos[2]	= E_Participacion
						$Datos[3]	= E_Egresados
						$Datos[4]	= E_Aspirantes
					*/
					
					
					$SQL_Insert='INSERT INTO estudiantebeneficio(modalidadsic_id,carrera_id,apoyos,paricipacion,egresados,aspirantes,periodo,entrydate,userid) VALUES ("'.$id_modalidad.'","'.$Datos[0].'","'.$Datos[1].'","'.$Datos[2].'","'.$Datos[3].'","'.$Datos[4].'","'.$Periodo.'",NOW(),"'.$userid.'")';
					
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
		global $userid,$db,$C_EstudianteBenficiados;
			
			MainGeneral();
			JsGeneral();
			
			$C_EstudianteBenficiados->DibujaTabla($_GET['id_modalidad']);
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
			global $userid,$db,$C_EstudianteBenficiados;
			
			MainGeneral();
			JsGeneral();
			
			$C_EstudianteBenficiados->Principal();
			
			
		}break;
	}
function MainGeneral(){
	
		global $userid,$db,$C_EstudianteBenficiados;
		
	    include_once ('EstudianteBenficiados_Class.php'); $C_EstudianteBenficiados = new EstudianteBenficiados();
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
			$('#Finaciero #Modalidad').val('');
			$('#Finaciero #modalidad_ID').val('');
		}	
	function AutocompletModalidad(){
		
			/********************************************************/	
				$('#Finaciero #Modalidad').autocomplete({
						
						source: "./formularios/financieros/EstudianteBenficiados_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#Finaciero #modalidad_ID').val(ui.item.id_modalidad);
							
							DibujaTabla(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
	function DibujaTabla(id_modalidad){
			/***************************AJAX***************************************/
				 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/EstudianteBenficiados_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'Buscar',id_modalidad:id_modalidad}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#Finaciero #CargarData').html(data);
							$('#Finaciero #Guardar').css('display','inline');
				   },
				}); //AJAX
			
			/***************************AJAX***************************************/
		}			
	function Save(){
			var index			= $('#Finaciero #index').val();
			var Periodo			= $('#Finaciero #Periodo').val();
			
			if(Periodo==-1 || Periodo=='-1'){
					alert('Seleccione el Periodo');
					$('#Finaciero #Periodo').css('border-color','#F00');
					$('#Finaciero #Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			for(i=0;i<index;i++){
				/********************************************/
					var Apoyos			= $('#Apoyos_'+i).val();
					var E_Participacion	= $('#E_Participacion_'+i).val();
					var E_Egresados		= $('#E_Egresados_'+i).val();
					var E_Aspirantes	= $('#E_Aspirantes_'+i).val();
					
					if(!$.trim(Apoyos) && !$.trim(E_Participacion) && !$.trim(E_Egresados) && !$.trim(E_Aspirantes)){
						/*******************************************************************************/
						alert('Digite la Informacion o Datos en Uno o en Todos los Siguientes Campos');
							/*************************************************/
							$('#Apoyos_'+i).css('border-color','#F00');
							$('#Apoyos_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#E_Participacion_'+i).css('border-color','#F00');
							$('#E_Participacion_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#E_Egresados_'+i).css('border-color','#F00');
							$('#E_Egresados_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#E_Aspirantes_'+i).css('border-color','#F00');
							$('#E_Aspirantes_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							
							return false;
						/*******************************************************************************/
						}
				/********************************************/
				}/*for*/
		/**********************************************************************************************/
			for(i=0;i<index;i++){
				/********************************************/
					var Apoyos			= $('#Apoyos_'+i).val();
					var E_Participacion	= $('#E_Participacion_'+i).val();
					var E_Egresados		= $('#E_Egresados_'+i).val();
					var E_Aspirantes	= $('#E_Aspirantes_'+i).val();
					var CodigoCarrera	= $('"#Finaciero #CodigoCarrera_'+i).val();
					
					$('#Finaciero #Cadena').val($('#Finaciero #Cadena').val()+'::'+CodigoCarrera+'-'+Apoyos+'-'+E_Participacion+'-'+E_Egresados+'-'+E_Aspirantes);
					
			}
		/****************************************AJAX*************************************************/	
			var id_modalidad		= $('#Finaciero #id_Modalidad').val();
			var Cadena				= $('#Finaciero #Cadena').val();
			
			 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/EstudianteBenficiados_html.php',
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
						  url: '../registroInformacion/formularios/financieros/EstudianteBenficiados_html.php',
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
		
	/*function AutocompletModalidad(){
			/********************************************************/	
				//$('#Finaciero #Modalidad').autocomplete({
//						
//						source: "../registroInformacion/formularios/financieros/EstudianteBenficiados_html.php?actionID=autoCompleModalidad",
//						minLength: 2,
//						select: function( event, ui ) {
//							
//							$('#Finaciero #id_Modalidad').val(ui.item.id_modalidad);
//							
//							
//							}
//						
//					});//
			/********************************************************/	
		//	}	
    </script>
    <?PHP
	}
?>