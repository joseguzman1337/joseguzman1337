<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'BuscarData':{
		global $userid,$db,$C_MovilidadAcademica;
			
			MainGeneral();
			JsGeneral();
			
		  $C_MovilidadAcademica->DataResult($_GET['modalidad'],$_GET['unidadAcademica'],$_GET['Periodo']);
			
		}break;
	case 'ReporteDefault':{
		global $userid,$db,$C_MovilidadAcademica;
			
			MainGeneral();
			JsGeneral();
			
			$C_MovilidadAcademica->Reporte($_REQUEST['id']);
			
		}break;
	case 'Save':{
		JsonGenral();
		
		global $userid,$db;
		
		
		$Cadena_1			= $_GET['Cadena_1'];
		$Cadena_2			= $_GET['Cadena_2'];
		$Cadena_3			= $_GET['Cadena_3'];
		$Cadena_4			= $_GET['Cadena_4'];
		$Cadena_5			= $_GET['Cadena_5'];
		$Cadena_6			= $_GET['Cadena_6'];
		$Cadena_7			= $_GET['Cadena_7'];
		$Cadena_8			= $_GET['Cadena_8'];
		$modalidad			= $_GET['modalidad'];									   
		$unidadAcademica	= $_GET['unidadAcademica'];
		$Periodo			= $_GET['Periodo'];
		
		$D_Cadena1		= explode('-',$Cadena_1);
		$D_Cadena2		= explode('-',$Cadena_2);
		$D_Cadena3		= explode('-',$Cadena_3);
		$D_Cadena4		= explode('-',$Cadena_4);
		$D_Cadena5		= explode('-',$Cadena_5);
		$D_Cadena6		= explode('-',$Cadena_6);
		$D_Cadena7		= explode('-',$Cadena_7);
		$D_Cadena8		= explode('-',$Cadena_8);
		
		/***************************************************************************************/
			$SQL_V='SELECT 

					idmovilidadacademica,
					periodo
					
					FROM movilidadacademica			
					
					WHERE
					
					periodo="'.$Periodo.'"
					AND
					codigoestado=100
					AND
					modalidad_id="'.$modalidad.'"
						AND
						carrera_id="'.$unidadAcademica.'"';
					
				if($V_Periodo=&$db->Execute($SQL_V)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Validar el Perido De la Movilida Estudiantil.....'.$SQL_V;
						echo json_encode($a_vectt);    
						exit;
					}
					
			if($V_Periodo->EOF){
					
				
		/***************************************************************************************/
		#echo '<pre>';print_r($D_Cadena1);
		
		/*
			[0] => 1
			[1] => 21
			[2] => 2
			[3] => 1
			[4] => 2
		*/
		
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("1","'.$D_Cadena1[0].'","'.$D_Cadena1[1].'","'.$D_Cadena1[2].'","'.$D_Cadena1[3].'","'.$D_Cadena1[4].'","1","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena1.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("2","'.$D_Cadena2[0].'","'.$D_Cadena2[1].'","'.$D_Cadena2[2].'","'.$D_Cadena2[3].'","'.$D_Cadena2[4].'","1","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena2.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica  (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("3","'.$D_Cadena3[0].'","'.$D_Cadena3[1].'","'.$D_Cadena3[2].'","'.$D_Cadena3[3].'","'.$D_Cadena3[4].'","1","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena3.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("4","'.$D_Cadena4[0].'","'.$D_Cadena4[1].'","'.$D_Cadena4[2].'","'.$D_Cadena4[3].'","'.$D_Cadena4[4].'","1","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena4.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************
								Insert de la Segunda Tabla
		**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("1","'.$D_Cadena5[0].'","'.$D_Cadena5[1].'","'.$D_Cadena5[2].'","'.$D_Cadena5[3].'","'.$D_Cadena5[4].'","2","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena5.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica  (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("2","'.$D_Cadena6[0].'","'.$D_Cadena6[1].'","'.$D_Cadena6[2].'","'.$D_Cadena6[3].'","'.$D_Cadena6[4].'","2","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena6.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO movilidadacademica  (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("3","'.$D_Cadena7[0].'","'.$D_Cadena7[1].'","'.$D_Cadena7[2].'","'.$D_Cadena7[3].'","'.$D_Cadena7[4].'","2","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena7.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			$SQL_Movilidad='INSERT INTO  movilidadacademica (pais,internado,pasantia,practica,semestreacademico,dobletitulacion,tipo,modalidad_id,carrera_id,entrydate,userid,periodo)VALUES("4","'.$D_Cadena8[0].'","'.$D_Cadena8[1].'","'.$D_Cadena8[2].'","'.$D_Cadena8[3].'","'.$D_Cadena8[4].'","2","'.$modalidad.'","'.$unidadAcademica.'",NOW(),"'.$userid.'","'.$Periodo.'")';
			
				if($Insert_Movilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar la Movilidad Academica en la D_Cadena8.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
		/**************************************************************************************/
			
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Guardado Correctamente';
			echo json_encode($a_vectt);
			exit;		
			
			}else{
				
						$a_vectt['val']			='EXISTE';
						$a_vectt['descrip']		='Informacion Existente para el Perido '.$Periodo;
						echo json_encode($a_vectt);
						exit;
				}
		}break;
	default:{
			
			global $userid,$db,$C_MovilidadAcademica;
			
			MainGeneral();
			JsGeneral();
			
			$C_MovilidadAcademica->Principal($_REQUEST['id']);
			
		}break;
}
function MainGeneral(){
	
		global $userid,$db,$C_MovilidadAcademica;
		
	    include_once ('MovilidadAcademica_Class.php'); $C_MovilidadAcademica = new MovilidadAcademica();
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
    <script language="javascript">
        
        $(document).on('change', "#xxxxx #modalidad", function(){
                    $("#xxxxx #unidadAcademica").html("");
	$("#xxxxx #unidadAcademica").css("width","auto");   
		
	if($('#xxxxx  #modalidad').val()!=""){
		var mod = $('#xxxxx #modalidad').val();
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: '../searchs/lookForCareersByModalidadSIC.php',
				data: { modalidad: mod },     
				success:function(data){
					 var html = '<option value="" selected></option>';
					 var i = 0;
						while(data.length>i){
							html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
							i = i + 1;
						}                                    
			
						$("#xxxxx #unidadAcademica").html(html);
						$("#xxxxx #unidadAcademica").css("width","500px");                                        
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});  
	}
                    changeFormModalidad("#xxxxx");
                });
                
                $(document).on('change', "#xxxxx #unidadAcademica", function(){
                    console.log("hola!!! ");
                    changeFormModalidad("#xxxxx");
                });
	
	/*$('#xxxxx #modalidad').change(function(event) {
	$("#xxxxx #unidadAcademica").html("");
	$("#xxxxx #unidadAcademica").css("width","auto");   
		
	if($('#xxxxx  #modalidad').val()!=""){
		var mod = $('#xxxxx #modalidad').val();
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: '../searchs/lookForCareersByModalidad.php',
				data: { modalidad: mod },     
				success:function(data){
					 var html = '<option value="" selected></option>';
					 var i = 0;
						while(data.length>i){
							html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
							i = i + 1;
						}                                    
			
						$("#xxxxx #unidadAcademica").html(html);
						$("#xxxxx #unidadAcademica").css("width","500px");                                        
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});  
	}
});*/


/*********************************************************************************************/
$('#R_View #modalidad').change(function(event) {
	$("#R_View #unidadAcademica").html("");
	$("#R_View #unidadAcademica").css("width","auto");   
		
	if($('#R_View  #modalidad').val()!=""){
		var mod = $('#R_View #modalidad').val();
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: '../searchs/lookForCareersByModalidadSIC.php',
				data: { modalidad: mod },     
				success:function(data){
					 var html = '<option value="" selected></option>';
					 var i = 0;
						while(data.length>i){
							html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
							i = i + 1;
						}                                    
			
						$("#R_View #unidadAcademica").html(html);
						$("#R_View #unidadAcademica").css("width","500px");                                        
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});  
	}
});
	
/**********************************************************************************************/
	
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
	
   function Save(){
    
        $('#xxxxx  #Guardar').css('display','none');
    
	   /*******************************************************************/
	   		if($('#xxxxx  #modalidad').val()=='' || !$('#xxxxx  #modalidad').val()){
					alert('Seleccione una de las Modalidades Academicas');
					$('#xxxxx #modalidad').css('border-color','#F00');
					$('#xxxxx  #modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			if($('#xxxxx #unidadAcademica').val()=='' || !$('#xxxxx #unidadAcademica').val()){
					alert('Seleccione una de las Unidades Academicas');
					$('#xxxxx #unidadAcademica').css('border-color','#F00');
					$('#xxxxx #unidadAcademica').effect("pulsate", {times:3}, 500);
					return false;
				}
			
			if($('#Periodo').val()==-1 || $('#Periodo').val()=='-1'){
					alert('Seleccione el Periodo');
					$('#Periodo').css('border-color','#F00');
					$('#Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}		
	   		/***********************************************************/
			var Campo1 = 'Intervalo_Uno';
			var Campo2 = 'Pasantia_uno';
			var Campo3 = 'Practica_Uno';
			var Campo4 = 'Semestre_Uno';
			var Campo5 = 'Doble_uno';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/	
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Dos';
			var Campo2 = 'Pasantia_Dos';
			var Campo3 = 'Practica_Dos';
			var Campo4 = 'Semestre_Dos';
			var Campo5 = 'Doble_Dos';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/				
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Tres';
			var Campo2 = 'Pasantia_Tres';
			var Campo3 = 'Practica_Tres';
			var Campo4 = 'Semestre_Tres';
			var Campo5 = 'Doble_Tres';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/				
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Cuatro';
			var Campo2 = 'Pasantia_Cuatro';
			var Campo3 = 'Practica_Cuatro';
			var Campo4 = 'Semestre_Cuatro';
			var Campo5 = 'Doble_Cuatro';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			
			if(Result==false){
					return false;
				}
			/***********************************************************/
			var Campo1 = 'Intervalo_Cinco';
			var Campo2 = 'Pasantia_Cinco';
			var Campo3 = 'Practica_Cinco';
			var Campo4 = 'Semestre_Cinco';
			var Campo5 = 'Doble_Cinco';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/	
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Seis';
			var Campo2 = 'Pasantia_Seis';
			var Campo3 = 'Practica_Seis';
			var Campo4 = 'Semestre_Seis';
			var Campo5 = 'Doble_Seis';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/				
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Siete';
			var Campo2 = 'Pasantia_Siete';
			var Campo3 = 'Practica_Siete';
			var Campo4 = 'Semestre_Siete';
			var Campo5 = 'Doble_Siete';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			/***********************************************************/				
			if(Result==false){
					return false;
				}
				
			var Campo1 = 'Intervalo_Ocho';
			var Campo2 = 'Pasantia_Ocho';
			var Campo3 = 'Practica_Ocho';
			var Campo4 = 'Semestre_Ocho';
			var Campo5 = 'Doble_Ocho';
			
	   		var Result = Valida(Campo1,Campo2,Campo3,Campo4,Campo5)
			
			if(Result==false){
					return false;
				}
			/*******************************************************************************/		
			
				var Cadena_1 = $('#Intervalo_Uno').val()+'-'+$('#Pasantia_uno').val()+'-'+$('#Practica_Uno').val()+'-'+$('#Semestre_Uno').val()+'-'+$('#Doble_uno').val();
				
				var Cadena_2 = $('#Intervalo_Dos').val()+'-'+$('#Pasantia_Dos').val()+'-'+$('#Practica_Dos').val()+'-'+$('#Semestre_Dos').val()+'-'+$('#Doble_Dos').val();
				
				var Cadena_3 = $('#Intervalo_Tres').val()+'-'+$('#Pasantia_Tres').val()+'-'+$('#Practica_Tres').val()+'-'+$('#Semestre_Tres').val()+'-'+$('#Doble_Tres').val();
				
				var Cadena_4 = $('#Intervalo_Cuatro').val()+'-'+$('#Pasantia_Cuatro').val()+'-'+$('#Practica_Cuatro').val()+'-'+$('#Semestre_Cuatro').val()+'-'+$('#Doble_Cuatro').val();
				
				var Cadena_5 = $('#Intervalo_Cinco').val()+'-'+$('#Pasantia_Cinco').val()+'-'+$('#Practica_Cinco').val()+'-'+$('#Semestre_Cinco').val()+'-'+$('#Doble_Cinco').val();
				
				var Cadena_6 = $('#Intervalo_Seis').val()+'-'+$('#Pasantia_Seis').val()+'-'+$('#Practica_Seis').val()+'-'+$('#Semestre_Seis').val()+'-'+$('#Doble_Seis').val();
				
				var Cadena_7 = $('#Intervalo_Siete').val()+'-'+$('#Pasantia_Siete').val()+'-'+$('#Practica_Siete').val()+'-'+$('#Semestre_Siete').val()+'-'+$('#Doble_Siete').val();
				
				var Cadena_8 = $('#Intervalo_Ocho').val()+'-'+$('#Pasantia_Ocho').val()+'-'+$('#Practica_Ocho').val()+'-'+$('#Semestre_Ocho').val()+'-'+$('#Doble_Ocho').val();
				
				var modalidad			= $('#xxxxx #modalidad').val();
				var unidadAcademica		= $('#xxxxx #unidadAcademica').val();
				var Periodo				= $('#Periodo').val();
				
			//*******************************AJAX*****************************************//
				$.ajax({//Ajax
					   type: 'GET',
					   url: 'formularios/academicos/MovilidadAcademica_html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'Save',Cadena_1:Cadena_1,
					   						   Cadena_2:Cadena_2,
											   Cadena_3:Cadena_3,
											   Cadena_4:Cadena_4,
											   Cadena_5:Cadena_5,
											   Cadena_6:Cadena_6,
											   Cadena_7:Cadena_7,
											   Cadena_8:Cadena_8,
											   modalidad:modalidad,
											   unidadAcademica:unidadAcademica,
											   Periodo:Periodo}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
                                            $('#xxxxx  #Guardar').css('display','inline');
											return false;
										}else if(data.val=='TRUE'){
												alert(data.descrip);
                                                $('#xxxxx  #Guardar').css('display','inline');
												location.href='index.php';	
											}else if(data.val=='EXISTE'){
												alert(data.descrip);
                                                $('#xxxxx  #Guardar').css('display','inline');
												location.href='index.php';	
												}
					   } 
				}); //AJAX	
		//*******************************AJAX*****************************************//	
	   /*******************************************************************/
	   } 
	 function Valida(Campo1,Campo2,Campo3,Campo4,Campo5){
		 /*******************************************************************/
	   		if(!$.trim($('#'+Campo1).val()) && !$.trim($('#'+Campo2).val()) && !$.trim($('#'+Campo3).val()) && !$.trim($('#'+Campo4).val()) && !$.trim($('#'+Campo5).val())){
					alert('Digite la Informacion o Datos en Uno o en Todos los Siguientes Campos');
					/*************************************************/
					$('#'+Campo1).css('border-color','#F00');
					$('#'+Campo1).effect("pulsate", {times:3}, 500);
					/*************************************************/
					$('#'+Campo2).css('border-color','#F00');
					$('#'+Campo2).effect("pulsate", {times:3}, 500);
					/*************************************************/
					$('#'+Campo3).css('border-color','#F00');
					$('#'+Campo3).effect("pulsate", {times:3}, 500);
					/*************************************************/
					$('#'+Campo4).css('border-color','#F00');
					$('#'+Campo4).effect("pulsate", {times:3}, 500);
					/*************************************************/
					$('#'+Campo5).css('border-color','#F00');
					$('#'+Campo5).effect("pulsate", {times:3}, 500);
					/*************************************************/
					return false;
				}
	   /*******************************************************************/
		 }             
		  
	function Buscar(){
            <?php $url = 'formularios/academicos/MovilidadAcademica_html.php';
            if(!is_file('formularios/academicos/MovilidadAcademica_html.php'))
            {
                $url = '../registroInformacion/formularios/academicos/MovilidadAcademica_html.php';
            } ?>
            
		/*************************************************************/	
			var modalidad			= $('#R_View  #modalidad').val();
			var unidadAcademica		= $('#R_View  #unidadAcademica').val();
			var Periodo				= $('#R_View  #Periodo').val();
			
			if(unidadAcademica=='' || !unidadAcademica){
					alert('Seleccione una de las Unidades Academicas');
					$('#R_View #unidadAcademica').css('border-color','#F00');
					$('#R_View #unidadAcademica').effect("pulsate", {times:3}, 500);
					return false;
				}
				
			if(Periodo=='' || !Periodo){
					alert('Seleccione un Periodo');
					$('#R_View #Periodo').css('border-color','#F00');
					$('#R_View #Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}	
		/*************************************************************/
		//*******************************AJAX*****************************************//
				$.ajax({//Ajax
					   type: 'GET',
					   url: '<?php echo $url; ?>',
					   async: false,
					   //dataType: 'json',
					   data:({actionID: 'BuscarData',modalidad:modalidad,
					   								 unidadAcademica:unidadAcademica,
					   								 Periodo:Periodo}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   		$('#CargarData').html(data);	
					   } 
				}); //AJAX	
		//*******************************AJAX*****************************************//	
		}		 
	</script>
    <?PHP
	}
?>