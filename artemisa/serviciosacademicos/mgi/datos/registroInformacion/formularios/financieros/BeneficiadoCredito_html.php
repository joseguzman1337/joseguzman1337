<?PHP 
session_start();
// echo "<pre>"; print_r($_SESSION);
// echo "<pre>"; print_r($_REQUEST);
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'ViewReporte':{
		global $userid,$db,$C_BeneficiadoCredito;
			
			MainGeneral();
			JsGeneral();
			
			$C_BeneficiadoCredito->ViewReporte();
		}break;
	case 'Reporte':{
		global $userid,$db,$C_BeneficiadoCredito;
			
			MainGeneral();
			JsGeneral();
			
		$C_BeneficiadoCredito->Reporte($_GET['codigoperiodo'],$_GET['Modalidad'],$_GET['id_Modalidad']);	
		}break;
	case 'Save':{
		global $userid,$db;
		JsonGenral();
		
		$id_modalidad		= $_POST['id_modalidad'];
		$Cadena				= $_POST['Cadena'];
		$Periodo			= $_POST['Periodo'];
		
		$D_Cadena			= explode('::',$Cadena);//beneficiocredito
		
		  $SQL_Valida='SELECT 
						
						beneficiocredito_id,
						modalidadsic_id,
						periodo
						
						FROM 
						
						beneficiocredito
						
						WHERE
						
						codigoestado=100
						AND
						modalidadsic_id="'.$id_modalidad.'"
						AND
						periodo="'.$Periodo.'"';
						
				if($BeneficioValida=&$db->Execute($SQL_Valida)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Validar las Becas Beneficio.....'.$SQL_Valida;
						echo json_encode($a_vectt);    
						exit;
					}		
		
		if($BeneficioValida->EOF){
		
			for($i=1;$i<count($D_Cadena);$i++){
				/**********************************************************************/
					$Datos		= explode('-',$D_Cadena[$i]);
					
					/*
						$Datos[0]	= CodigoCarrera
						$Datos[1]	= EntidadFinaciera	
						$Datos[2]	= icetex
						$Datos[3]	= credito Universidad
						$Datos[4]	= V_Finaciera
						$Datos[5]	= V_Icetex
						$Datos[6]	= V_CreUniversidad
					*/
					
					
					$SQL_Insert='INSERT INTO beneficiocredito(modalidadsic_id,carrera_id,EntidadFinaciera,valorEntidad,icetex,valorIcetex,CreUniversidad,valorUniversidad,periodo,entrydate,userid) VALUES ("'.$id_modalidad.'","'.$Datos[0].'","'.$Datos[1].'","'.$Datos[4].'","'.$Datos[2].'","'.$Datos[5].'","'.$Datos[3].'","'.$Datos[6].'","'.$Periodo.'",NOW(),"'.$userid.'")';
					
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
				
				for($i=1;$i<count($D_Cadena);$i++){
				/**********************************************************************/
					$Datos		= explode('-',$D_Cadena[$i]);
					
					/*
						$Datos[0]	= CodigoCarrera
						$Datos[1]	= EntidadFinaciera	
						$Datos[2]	= icetex
						$Datos[3]	= credito Universidad
						$Datos[4]	= V_Finaciera
						$Datos[5]	= V_Icetex
						$Datos[6]	= V_CreUniversidad
					*/
					
					
					//$SQL_Insert='INSERT INTO beneficiocredito(modalidadsic_id,carrera_id,EntidadFinaciera,valorEntidad,icetex,valorIcetex,CreUniversidad,valorUniversidad,periodo,entrydate,userid) VALUES ("'.$id_modalidad.'","'.$Datos[0].'","'.$Datos[1].'","'.$Datos[4].'","'.$Datos[2].'","'.$Datos[5].'","'.$Datos[3].'","'.$Datos[6].'","'.$Periodo.'",NOW(),"'.$userid.'")';
					$SQL_Insert='UPDATE beneficiocredito set  modalidadsic_id="'.$id_modalidad.'",carrera_id="'.$Datos[0].'",EntidadFinaciera="'.$Datos[1].'",valorEntidad="'.$Datos[2].'",icetex="'.$Datos[3].'",valorIcetex="'.$Datos[4].'",CreUniversidad="'.$Datos[5].'",valorUniversidad="'.$Datos[6].'",periodo="'.$Periodo.'",entrydate=NOW(),userid="'.$userid.'" where modalidadsic_id="'.$id_modalidad.'" and carrera_id="'.$Datos[0].'" and periodo="'.$Periodo.'" and codigoestado=100';
						if($BecasBeneficio=&$db->Execute($SQL_Insert)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar las Becas Beneficio.....'.$SQL_Insert;
								echo json_encode($a_vectt);    
								exit;
							}
					
				/**********************************************************************/
				}#For
				
				/**************************************************/
					$a_vectt['val']			='TRUE';
					$a_vectt['descrip']		='Se ha actualizado la información correctamente Para el Periodo...'.$Periodo;
					echo json_encode($a_vectt);    
					exit;
				/**************************************************/
				} 
		}break;
	case 'Buscar':{
		global $userid,$db,$C_BeneficiadoCredito;
			
			MainGeneral();
			JsGeneral();
			
			$C_BeneficiadoCredito->DibujaTabla($_GET['id_modalidad'],$_GET['id_periodo']);
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
			global $userid,$db,$C_BeneficiadoCredito;
			MainGeneral();
			JsGeneral();		
			$C_BeneficiadoCredito->Principal();
			
			
		}break;
	}
function MainGeneral(){
	
		global $userid,$db,$C_BeneficiadoCredito;
		
	    include_once ('BeneficiadoCredito_Class.php'); 
	    $C_BeneficiadoCredito = new BeneficiadoCredito();
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
			$('#zzzz #Modalidad').val('');
			$('#zzzz #id_Modalidad').val('');
		}	
	function AutocompletModalidad(){
		
			/********************************************************/	
				$('#zzzz #Modalidad').autocomplete({
						
						source: "./formularios/financieros/BeneficiadoCredito_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#zzzz #id_Modalidad').val(ui.item.id_modalidad);
							
							DibujaTabla(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
	function dataNew(){
		
		var modalidadBuscar = $('#zzzz #id_Modalidad').val();
                var periodoBuscar = $('#zzzz #Periodo').val();
		DibujaTabla(modalidadBuscar,periodoBuscar);

	}
	function DibujaTabla(id_modalidad,id_periodo){
			/***************************AJAX***************************************/
				 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/BeneficiadoCredito_html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID:'Buscar',id_modalidad:id_modalidad,id_periodo:id_periodo}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#zzzz #CargarInfo').html(data);
				 			$('#zzzz #Guarda').css('display','inline');
				   },
			}); //AJAX
			
			/***************************AJAX***************************************/
		}			
	function Save(){
			var index			= $('#zzzz  #index').val();
			var Periodo			= $('#zzzz  #Periodo').val();
			
			if(Periodo==-1 || Periodo=='-1'){
					alert('Seleccione el Periodo');
					$('#zzzz #Periodo').css('border-color','#F00');
					$('#zzzz #Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			for(i=0;i<index;i++){
				/********************************************/
				
				
					var EntidadFinaciera		= $('#EntidadFinaciera_'+i).val();
					var Icetex					= $('#Icetex_'+i).val();
					var CreUniversidad			= $('#CreUniversidad_'+i).val();
					var V_Finaciera				= $('#V_Finaciera_'+i).val();
					var V_Icetex				= $('#V_Icetex_'+i).val();
					var V_CreUniversidad		= $('#V_Universidad_'+i).val();
					
					
					if(!$.trim(EntidadFinaciera) && !$.trim(Icetex) && !$.trim(CreUniversidad)){
						/*******************************************************************************/
						alert('Digite la Informacion o Datos en Uno o en Todos los Siguientes Campos');
							/*************************************************/
							$('#EntidadFinaciera_'+i).css('border-color','#F00');
							$('#EntidadFinaciera_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#Icetex_'+i).css('border-color','#F00');
							$('#Icetex_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							$('#CreUniversidad_'+i).css('border-color','#F00');
							$('#CreUniversidad_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							return false;
						/*******************************************************************************/
						}
						
					if($.trim(EntidadFinaciera) && !$.trim(V_Finaciera)){

						var msn	= 'Digite la Informacion en el Siguiente Campo';
						
						alert(msn);
						
							/*************************************************/
							$('#V_Finaciera_'+i).css('border-color','#F00');
							$('#V_Finaciera_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							return false;
						
						}
					
					if($.trim(Icetex) && !$.trim(V_Icetex)){

						var msn	= 'Digite la Informacion en el Siguiente Campo';
						
						alert(msn);
						
							/*************************************************/
							$('#V_Icetex_'+i).css('border-color','#F00');
							$('#V_Icetex_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							return false;
						
						}		
						
					if($.trim(CreUniversidad) && !$.trim(V_CreUniversidad)){

						var msn	= 'Digite la Informacion en el Siguiente Campo';
						
						alert(msn);
						
							/*************************************************/
							$('#V_Universidad_'+i).css('border-color','#F00');
							$('#V_Universidad_'+i).effect("pulsate", {times:3}, 500);
							/*************************************************/
							return false;
						
						}			
				/********************************************/
				}/*for*/
		/**********************************************************************************************/
			for(i=0;i<index;i++){
				/********************************************/
					var EntidadFinaciera		= $('#EntidadFinaciera_'+i).val();
					var Icetex					= $('#Icetex_'+i).val();
					var CreUniversidad			= $('#CreUniversidad_'+i).val();
					var CodigoCarrera			= $('#CodigoCarrera_'+i).val();
					var V_Finaciera				= $('#V_Finaciera_'+i).val();
					var V_Icetex				= $('#V_Icetex_'+i).val();
					var V_CreUniversidad		= $('#V_Universidad_'+i).val();
					
					$('#zzzz #Cadena').val($('#zzzz #Cadena').val()+'::'+CodigoCarrera+'-'+EntidadFinaciera+'-'+Icetex+'-'+CreUniversidad+'-'+V_Finaciera+'-'+V_Icetex+'-'+V_CreUniversidad);
					
			}
		/****************************************AJAX*************************************************/	
			var id_modalidad		= $('#zzzz #id_Modalidad').val();
			var Cadena				= $('#zzzz #Cadena').val();
			
			 $.ajax({//Ajax
					  type: 'POST',
					  url: './formularios/financieros/BeneficiadoCredito_html.php',
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
						  url: '../registroInformacion/formularios/financieros/BeneficiadoCredito_html.php',
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
				$('#zzzz #Modalidad').autocomplete({
						
						source: "../registroInformacion/formularios/financieros/BeneficiadoCredito_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#zzzz #id_Modalidad').val(ui.item.id_modalidad);
							
						
							
							}
						
					});//
			/********************************************************/	
			}		
    </script>
    <?PHP
	}
?>