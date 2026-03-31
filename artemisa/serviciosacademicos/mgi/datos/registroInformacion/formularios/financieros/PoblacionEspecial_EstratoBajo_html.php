<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'ViewReporte':{
		global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
			
			MainGeneral();
			JsGeneral();
			
		$C_PoblacionEspecial_EstratoBajo->Reporte($_GET['codigoperiodo'],$_GET['Modalidad'],$_GET['id_Modalidad']);	
		}break;
	case 'Reporte':{
		global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
			
			MainGeneral();
			JsGeneral();
			
		$C_PoblacionEspecial_EstratoBajo->ViewReporte();	
		
		}break;
	case 'BuscarCarrera':{
		global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
		MainGeneral();
		$C_PoblacionEspecial_EstratoBajo->selectCarrera($_GET['modalidad']);

	}break;
	case 'Save':{
		global $userid,$db;
		JsonGenral();
		
		$id_modalidad			= $_GET['id_modalidad'];
		$id_carrera				= $_GET['id_carrera'];
		$Periodo				= $_GET['Periodo'];
		$num_Especiales			= $_GET['num_Especiales'];
		$Num_Bajos				= $_GET['Num_Bajos'];
        $CheckValidado          = $_GET['CheckValidado'];//Falta crear campo en la tabla
		
		
		 $SQL_Valida='SELECT 
						
						poblacionespcialbajos_id,
						modalidad_id,
						periodo
						
						FROM 
						
						poblacionespcialbajos
						
						WHERE
						
						codigoestado=100
						AND
						modalidad_id="'.$id_modalidad.'"
						AND
						periodo="'.$Periodo.'"
						AND
						carrera_id="'.$id_carrera.'"';
						
				if($PoblacionesValida=&$db->Execute($SQL_Valida)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Validar las Poblaciones Especiales.....'.$SQL_Valida;
						echo json_encode($a_vectt);    
						exit;
					}		
	
	if($PoblacionesValida->EOF){
		
		$SQL_Insert='INSERT INTO poblacionespcialbajos (modalidad_id,carrera_id,numespeciales,numbajos,periodo,entrydate,userid,Validado,codigoestado) VALUES ("'.$id_modalidad.'","'.$id_carrera.'","'.$num_Especiales.'","'.$Num_Bajos.'","'.$Periodo.'",NOW(),"'.$userid.'","'.$CheckValidado.'",100)';
		
					if($Poblaciones_Bajos=&$db->Execute($SQL_Insert)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar las Poblaciones eSPECIALES y ESTRADOS baJOS.....'.$SQL_Insert;
						echo json_encode($a_vectt);    
						exit;
					}
					
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Guardado Correctamente.';
			echo json_encode($a_vectt);    
			exit;		
					
	}else{
	
	        //$SQL_Insert='INSERT INTO poblacionespcialbajos (modalidad_id,carrera_id,numespeciales,numbajos,periodo,entrydate,userid,Validado,codigoestado) VALUES ("'.$id_modalidad.'","'.$id_carrera.'","'.$num_Especiales.'","'.$Num_Bajos.'","'.$Periodo.'",NOW(),"'.$userid.'","'.$CheckValidado.'",100)';
		$SQL_Insert='UPDATE poblacionespcialbajos set  modalidad_id="'.$id_modalidad.'",carrera_id="'.$id_carrera.'",numespeciales="'.$num_Especiales.'",numbajos="'.$Num_Bajos.'",periodo="'.$Periodo.'",entrydate=NOW(),userid="'.$userid.'",Validado="'.$CheckValidado.'"  where modalidad_id="'.$id_modalidad.'" and carrera_id="'.$id_carrera.'" and periodo="'.$Periodo.'" and codigoestado=100';
					if($Poblaciones_Bajos=&$db->Execute($SQL_Insert)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar las Poblaciones eSPECIALES y ESTRADOS baJOS.....'.$SQL_Insert;
						echo json_encode($a_vectt);    
						exit;
					}
		
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se ha actualizado la Información correctamente para el Periodo  '.$Periodo;
			echo json_encode($a_vectt);    
			exit;
		
		}
		
		}break;
	case 'Buscar':{
		global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
			
			MainGeneral();
			JsGeneral();
			
			$C_PoblacionEspecial_EstratoBajo->DibujaTabla($_GET['id_modalidad'],$_GET['id_periodo'],$_GET['id_carrera']);
		}break;
	case 'autoCompleCarrera':{
		global $userid,$db;
		JsonGenral();
		
		$Letra   = $_REQUEST['term'];
		$id_Movilidad = $_REQUEST['id_Movilidad'];
		
		  $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademicasic="'.$id_Movilidad.'"
						AND
						nombrecarrera LIKE "%'.$Letra.'%"';
						
				if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Auto Completar Carrera...<br>'.$SQL_Carrera;
						die;
					}
							
		$Result_F = array();
				
				if(!$D_Carrera->EOF){
									
					while(!$D_Carrera->EOF){
						
							$Rf_Vectt['label']=$D_Carrera->fields['nombrecarrera'];
							$Rf_Vectt['value']=$D_Carrera->fields['nombrecarrera'];
							
							$Rf_Vectt['id_carrera']=$D_Carrera->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Carrera->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);		
					
		
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
			global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
			
			MainGeneral();
			JsGeneral();
			
			$C_PoblacionEspecial_EstratoBajo->Principal();
			
			
		}break;
	}
function MainGeneral(){
	
		global $userid,$db,$C_PoblacionEspecial_EstratoBajo;
		
	    include_once ('PoblacionEspecial_EstratoBajo_Class.php'); $C_PoblacionEspecial_EstratoBajo = new PoblacionEspecial_EstratoBajo();
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
			$('#qqqq #Modalidad').val('');
			$('#qqqq #id_Modalidad').val('');
		}
	function FormatCarrera(){
			$('#qqqq #Carrera').val('');
			$('#qqqq #id_carrera').val('');
		}		
	function AutocompletModalidad(){
		
			/********************************************************/	
				$('#qqqq #Modalidad').autocomplete({
						
						source: "./formularios/financieros/PoblacionEspecial_EstratoBajo_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#qqqq #id_Modalidad').val(ui.item.id_modalidad);
							
							
							
							}
						
					});//
			/********************************************************/	
		}
	function AutocompletCarrera(){
					var id_Movilidad		= $('#qqqq #id_Modalidad').val();

			/********************************************************/	
				$('#qqqq #Carrera').autocomplete({
						
						source: "./formularios/financieros/PoblacionEspecial_EstratoBajo_html.php?actionID=autoCompleCarrera&id_Movilidad="+id_Movilidad,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#qqqq #id_carrera').val(ui.item.id_carrera);
							
							DibujaTabla();
							
							}
						
					});//
			/********************************************************/	
			}
	function buscarDatos(){
		// FormatModalidad();
		// FormatCarrera();
		
		var modalidadBuscar = $('#qqqq #id_Modalidad').val();
		var periodoBuscar = $('#qqqq #Periodo').val();
		var carreraBuscar = $('#qqqq #id_carrera').val();
		
		DibujaTabla(modalidadBuscar,periodoBuscar,carreraBuscar);
	}
	function buscarCarrera(){
		var modalidadBuscar = $('#qqqq #id_Modalidad').val();

		 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/PoblacionEspecial_EstratoBajo_html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID:'BuscarCarrera',modalidad:modalidadBuscar}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#qqqq #th_programa').html(data);
							//$('#qqqq #Guarda').css('display','inline');
				   },
				}); //AJAX
	}
	function DibujaTabla(id_modalidad,id_periodo,id_carrera){
			/***************************AJAX***************************************/
				
				 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/PoblacionEspecial_EstratoBajo_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'Buscar',id_modalidad:id_modalidad,id_periodo:id_periodo,id_carrera:id_carrera}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#qqqq #CargarInfo').html(data);
							$('#qqqq #Guarda').css('display','inline');
				   },
				}); //AJAX
			
			/***************************AJAX***************************************/
		}			
	function Save(){
			var Periodo			= $('#qqqq #Periodo').val();
			var id_modalidad		= $('#qqqq #id_Modalidad').val();
			var id_carrera			= $('#qqqq #id_carrera').val();
			
			
			if(!$.trim(id_modalidad)){
				alert('Seleccione la Modalidad');
					$('#qqqq #Modalidad').css('border-color','#F00');
					$('#qqqq #Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
				
			if(!$.trim(id_carrera)){
				alert('Seleccione la carrera');
					$('#qqqq #id_carrera').css('border-color','#F00');
					$('#qqqq #id_carrera').effect("pulsate", {times:3}, 500);
					return false;
				}	
			
			if(Periodo==-1 || Periodo=='-1'){
					alert('Seleccione el Periodo');
					$('#qqqq #Periodo').css('border-color','#F00');
					$('#qqqq #Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			
				
				
					var num_Especiales		= $('#num_Especiales').val();
					var Num_Bajos			= $('#Num_Bajos').val();
                    
					
					if(!$.trim(num_Especiales) && !$.trim(Num_Bajos)){
						/*******************************************************************************/
						alert('Digite la Informacion o Datos en Uno o en Todos los Siguientes Campos');
							/*************************************************/
							$('#num_Especiales').css('border-color','#F00');
							$('#num_Especiales').effect("pulsate", {times:3}, 500);
							/*************************************************/
							/*************************************************/
							$('#Num_Bajos').css('border-color','#F00');
							$('#Num_Bajos').effect("pulsate", {times:3}, 500);
							/*************************************************/
							return false;
						/*******************************************************************************/
						}
						
					
				/********************************************/
			
            if($('#CheckValidador').is(':checked')){
                var CheckValidado = 1;
            }else{
                var CheckValidado = 0;
            }
            
		/**********************************************************************************************/
			
		/****************************************AJAX*************************************************/	
			
			
			 $.ajax({//Ajax
					  type: 'GET',
					  url: './formularios/financieros/PoblacionEspecial_EstratoBajo_html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Save',id_modalidad:id_modalidad,
					  						 id_carrera:id_carrera,
											 Periodo:Periodo,
											 num_Especiales:num_Especiales,
											 Num_Bajos:Num_Bajos,CheckValidado:CheckValidado}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
									alert(data.descrip);
									location.href='index.php';
									}else if(data.val=='EXISTE'){
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
					  url: '../registroInformacion/formularios/financieros/PoblacionEspecial_EstratoBajo_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'ViewReporte',codigoperiodo:codigoperiodo,Modalidad:Modalidad,id_Modalidad:id_Modalidad}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#qqqq #CargarReporte').html(data);
				   },
			}); //AJAX
				
				/***************************************************************/
				}
			
		}		
	function AutoModalidad(){
		
			/********************************************************/	
				$('#qqqq #Modalidad').autocomplete({
						
						source: "../registroInformacion/formularios/financieros/PoblacionEspecial_EstratoBajo_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#qqqq #id_Modalidad').val(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
		}	
    </script>
    <?PHP
	}
?>