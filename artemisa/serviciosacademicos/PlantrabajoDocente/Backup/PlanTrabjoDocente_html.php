<?PHP 
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	?>
	<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>
	<?PHP
    exit();
} */
switch($_REQUEST['actionID']){
	case 'AutoCompleteProyecto':{
		global $db,$userid;
		 MainJson();
		 
		 
		  $Letra   		= $_REQUEST['term'];
		  $Periodo_id	= $_REQUEST['Periodo_id'];
		 
		  $SQL='SELECT 

				id_plandocente,
				id_vocacion,
				proyecto_nom,
				tipo,
				cual
				
				FROM `plandocente` 
				
				WHERE
				
				codigoestado=100
				AND
				codigoperiodo="'.$Periodo_id.'"
				AND
				proyecto_nom LIKE "%'.$Letra.'%"';
				
			if($Resultado=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ....<br>'.$SQL;
					die;
				}
				
			 $Result = array();		
			 
			 if(!$Resultado->EOF){
				 while(!$Resultado->EOF){
					 /*********************************************/
					 	$C_Result['label']		= $Resultado->fields['proyecto_nom'];
						$C_Result['value']		= $Resultado->fields['proyecto_nom'];
						$C_Result['idProyecto']	= $Resultado->fields['id_plandocente'];
						$C_Result['tipo']		= $Resultado->fields['tipo'];
						$C_Result['cual']		= $Resultado->fields['cual'];
					 /*********************************************/
					 array_push($Result,$C_Result);
					 $Resultado->MoveNext();
					 }
				 }
		 	echo json_encode($Result);
			
		}break;
	case 'AccExistentes':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		
		
		$C_PlanTrabjoDocente->AcionesDinamic($_POST['id'],$_POST['Periodo_id']);
		
		}break;
	case 'SaveTempDetalle':{
		 global $db,$userid;
		 MainJson();
		 
		 $Accion		= $_POST['Accion'];
		 $Last_id		= $_POST['Last_id'];
		 $Periodo_id	= $_POST['Periodo_id'];
		
		$SQL_Temp='INSERT INTO accionesplandocente_temp(id_plandocente,descripcion,codigoperiodo,entrydate,userid)VALUES("'.$Last_id.'","'.$Accion.'","'.$Periodo_id.'",NOW(),"'.$userid.'")';
		
				if($InsertAcion=&$db->Execute($SQL_Temp)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
						echo json_encode($a_vectt);
						exit;
					}
		
		
				$a_vectt['val']			='TRUE';
				$a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
				echo json_encode($a_vectt);
				exit;
		
		}break;
	case 'SaveTemp2':{
		 global $db,$userid;
		 MainJson();
		 
		 
		 $NomProyecto		= $_POST['NomProyecto'];
		 $TipoProyectoInv	= $_POST['TipoProyectoInv'];
		 $OtroType			= $_POST['OtroType'];
		 $Periodo_id		= $_POST['Periodo_id'];
		 
		 
		 $SQL_Temp='INSERT INTO plandocente(proyecto_nom,tipo,cual,codigoperiodo,entrydate,userid,id_vocacion)VALUES("'.$NomProyecto.'","'.$TipoProyectoInv.'","'.$OtroType.'","'.$Periodo_id.'",NOW(),"'.$userid.'","2")';
		 
		 	if($InsertPlan=&$db->Execute($SQL_Temp)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
					echo json_encode($a_vectt);
					exit;
				}
				
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			
			
			$a_vectt['val']			='TRUE';
			$a_vectt['Last_id']		=$Last_id;
			echo json_encode($a_vectt);
			exit;		
		 
		 
		}break;
	case 'SaveTabUno':{
		 global $db,$userid;
		 MainJson();
		 
		 
		 $Cadena			= $_POST['Cadena'];
		 $Auto				= $_POST['Auto'];
		 $PorcentajeUno		= $_POST['PorcentajeUno'];
		 $Consolidado		= $_POST['Consolidado'];
		 $Mejora			= $_POST['Mejora'];
		 $Periodo_id		= $_POST['Periodo_id'];
		 
		 
		 $Insert= 'INSERT INTO plandocente(id_vocacion,autoevaluacion,porcentaje,consolidacion,mejora,codigoperiodo,entrydate,userid)VALUES("1","'.$Auto.'","'.$PorcentajeUno.'","'.$Consolidado.'","'.$Mejora.'","'.$Periodo_id.'",NOW(),"'.$userid.'")';
		 
		 if($InsertPlanDocente=&$db->Execute($Insert)===false){
				$a_vectt['val']			='FALSE';
				$a_vectt['descrip']		='Error en El Insert ... '.$Insert;
				echo json_encode($a_vectt);
				exit;
			}
			
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			$C_id	= explode('::',$Cadena);
			
			for($i=1;$i<count($C_id);$i++){
				/*************************************************/
				
				$Update='UPDATE  accionesplandocente_temp
			
						 SET	 id_plandocente="'.$Last_id.'"
								 
						 WHERE	 id_accionesplandocentetemp="'.$C_id[$i].'" AND codigoestado=100';
						 
						if($UpdateAcioneRelacion=&$db->Execute($Update)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error en El Update ... '.$Update;
								echo json_encode($a_vectt);
								exit;
							} 
				
				/*************************************************/
				}
			
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Almacenado Correctamente';
			echo json_encode($a_vectt);
			exit;
		 
		}break;
	case 'TablaDinamic':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db;
		MainGeneral();
		
		$C_PlanTrabjoDocente->TablaDianmica();
		}break;
	case 'VisualizarTemp':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db;
		MainGeneral();
		
		$C_PlanTrabjoDocente->VisualizarTemp($_POST['id'],$_POST['i']);
		}break;
	case 'AcionesText':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		JsGenral();
		
		$C_PlanTrabjoDocente->Acciones();
		}break;
	case 'AcionesExixtentes':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();

		$C_PlanTrabjoDocente->AccionesExistentes($_POST['Facultad_id'],$_POST['Programa_id'],$_POST['Materia_id'],$_POST['Periodo_id'],$_POST['NameHidden']);	
		}break;
	case 'SaveTemp':{
		global $db,$userid;
		 MainJson();
		 
		 $Accion					= $_POST['Accion'];
		 $Facultad_id				= $_POST['Facultad_id'];
		 $Programa_id				= $_POST['Programa_id'];
		 $Materia_id				= $_POST['Materia_id'];
		 $Periodo_id				= $_POST['Periodo_id'];

		 /**************************************SaveTemp********************************************************/
		 
		 	$SQL_Temp='INSERT INTO accionesplandocente_temp(descripcion,facultad_id,carrera_id,materia_id,codigoperiodo,entrydate,userid)VALUES("'.$Accion.'","'.$Facultad_id.'","'.$Programa_id.'","'.$Materia_id.'","'.$Periodo_id.'",NOW(),"'.$userid.'")';
			
			if($Insert_Temp=&$db->Execute($SQL_Temp)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en El Insert Temp ... '.$SQL_Temp;
					echo json_encode($a_vectt);
					exit;
				}
			
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
			$a_vectt['Last_id']		=$Last_id;
			echo json_encode($a_vectt);
			exit;	
		 
		 /**************************************SaveTemp********************************************************/
		 		 
		}break;
	case 'AddColumnas':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		
		$C_PlanTrabjoDocente->CamposEvidencia($_GET['Indice']);
		}break;
	case 'InfoMaterias':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		//JsGenral();
		
		$C_PlanTrabjoDocente->InfoMaterias($_GET['Programa_id'],$_GET['NumDocumento'],$_GET['CodigoPeriodo'],$_GET['Materia_id']);
		}break;
	case 'Materias':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		
		$C_PlanTrabjoDocente->Materia($_GET['Programa_id'],$_GET['NumDocumento'],$_GET['CodigoPeriodo']);
		}break;
	case 'Programa':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		
		$C_PlanTrabjoDocente->Programa($_GET['CodigoFacultad'],$_GET['NumDocumento'],$_GET['CodigoPeriodo']);
		}break;
	default:{
		define(AJAX,'TRUE');
		define(BIENVENIDA,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db;
		
		MainGeneral();
		JsGenral();
		
	     $C_PlanTrabjoDocente->Principal();
		
		}break;
}
function MainGeneral(){
	
		
		global $C_PlanTrabjoDocente,$userid,$db;
		
		$userid	= 4186;
		
		$_SESSION['MM_Username']	= 'admintecnologia'; 
		
		if(AJAX=='TRUE'){
		include("../ReportesAuditoria/templates/MenuReportes.php");
		}else{
			include("../ReportesAuditoria/templates/mainjson.php");
			}
		include('PlanTrabjoDocente_Class.php');  $C_PlanTrabjoDocente = new PlanTrabjoDocente();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function MainJson(){
	global $userid,$db;
	
	$userid	= 4186;
		
	
	$_SESSION['MM_Username']	= 'admintecnologia'; 
		
		include("../ReportesAuditoria/templates/mainjson.php");
		
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function JsGenral(){
?>
 <link rel="stylesheet" href="PlanTrabjoDocente.css" type="text/css" />   
     
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
<script>	  
	function Programa(){
		
		$('#Div_Programa').html('');
		
		var CodigoFacultad	 = $('#Facultad_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
		
		/********************************************************************/	
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'Programa',CodigoFacultad:CodigoFacultad,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#Div_Programa').html(data);
			   }
			}); //AJAX
		/********************************************************************/
		}
		
    function Materias(){
		
		var Programa_id		= $('#Programa_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
		
		/*********************************************************************/
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'Materias',Programa_id:Programa_id,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#DivMateria').html(data);
			   }
			}); //AJAX
		/*********************************************************************/
		}
	function InfoMateria(){
		
		var Programa_id		 = $('#Programa_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
		var Materia_id		 = $('#Materia_id').val();
		
		/*********************************************************************/
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'InfoMaterias',Programa_id:Programa_id,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo,
											 Materia_id:Materia_id}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#Datos').html(data);
			   }
			}); //AJAX
		/*********************************************************************/
		
		}	
function AgregarFila(){
	/********************************************************************************************************/
	var NumFiles   =  parseFloat($('#Index').val());
	/**********************************************************/
	
		var Evidencia	= $('#Evidencia_'+NumFiles).val();
		var Descrip		= $('#Descrip_'+NumFiles).val();
		var Fecha		= $('#Fecha_'+NumFiles).val();
		//var Porcentaje	= $('#Porcentaje_'+NumFiles).val();
		
		if(!$.trim(Evidencia)){
				alert('Digite la Envidencia...');
				/***********************************************************/
				$('#Evidencia_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Evidencia_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				return false;
			}
			
		if(!$.trim(Descrip)){
				alert('Digite la Descripcion de la Evidencia...');
				/***********************************************************/
				$('#Descrip_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Descrip_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				return false;
			}
			
		if(!$.trim(Fecha)){
				alert('Seleccione la Fecha de la Evidencia...');
				/***********************************************************/
				$('#Fecha_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Fecha_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				return false;
			}
			
		//if(!$.trim(Porcentaje)){
//				alert('Digite el Porcentaje de la Evidencia...');
//				/***********************************************************/
//				$('#Porcentaje_'+NumFiles).effect("pulsate", {times:3}, 500);
//				$('#Porcentaje_'+NumFiles).css('border-color','#F00');
//				/***********************************************************/
//				return false;
//			}			
	
	/**********************************************************/
	var TblMain    =  document.getElementById("Evidencias_Table");
	var NumFiles   =  parseFloat($('#Index').val()) + 1;
	var NewTr      =  document.createElement("tr");
	NewTr.id       =  'trNewDetalle'+NumFiles;
	
	
	TblMain.appendChild(NewTr);

    $.ajax({
       url: "PlanTrabjoDocente_html.php",
       type: "GET",
       data: "actionID=AddColumnas&Indice="+NumFiles,
       success: function(data){
        $('#Index').val(NumFiles);
			$('#trNewDetalle'+NumFiles).attr('align','center');  
            $('#trNewDetalle'+NumFiles).html(data);
                               
       }
    });
	/*********************************************************************************************************/
	}		
function SaveTemp(op,NameHidden){  
		
	var Periodo_id	= $('#Periodo_id').val();	  
	
	/**************************************************************/
	if(op==1 || op=='1'){	
	
		var Facultad_id		= $('#Facultad_id').val();
		var Programa_id		= $('#Programa_id').val();
		var Materia_id		= $('#Materia_id').val();
		
		
		if(!$.trim(Facultad_id)){
			alert('Seleccione Una Faculta...');
				/***********************************************************/
				$('#Facultad_id').effect("pulsate", {times:3}, 500);
				$('#Facultad_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(!$.trim(Programa_id)){
			alert('Seleccione Una Programa...');
				/***********************************************************/
				$('#Programa_id').effect("pulsate", {times:3}, 500);
				$('#Programa_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(!$.trim(Materia_id)){
			alert('Seleccione Una Materia...');
				/***********************************************************/
				$('#Materia_id').effect("pulsate", {times:3}, 500);
				$('#Materia_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}		
		
		//console.log(nicEditors.findEditor('Accion'));
		var Accion = $.trim(document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent());
                   Accion = $("<div/>").html(Accion).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   Accion = $.trim(Accion);	
		
		//document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent();
	
		//var Accion				= $('#Accion').val();
		//alert(Accion);
		
		if(!$.trim(Accion)){
			/*************************************/
				alert('Digite El Plan De Trabajo...');
				return false;
			/*************************************/
			}
			
			
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTemp',
					 Accion:Accion,
					 Facultad_id:Facultad_id,
					 Programa_id:Programa_id,
					 Materia_id:Materia_id,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
								
								
                                var myNicEditor = nicEditors.findEditor('Accion');
                                myNicEditor.setContent(""); 

								AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden);
								/****************************/
							}
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
	}
	if(op==2 || op=='2'){
		/*********************************************************************/
		var id_CampoDos		= $('#id_CampoDos').val();
		
		if(!$.trim(id_CampoDos)){
		
		var NomProyecto			= $('#NomProyecto').val();
		var TipoProyectoInv		= $('#TipoProyectoInv').val();
		
		
		if(!$.trim(NomProyecto)){
			alert('Digite el Nombre del Proyecto...');
				/***********************************************************/
				$('#NomProyecto').effect("pulsate", {times:3}, 500);
				$('#NomProyecto').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(TipoProyectoInv=='-1' || TipoProyectoInv==-1){
			alert('Seleccione Una Tipo de Proyecto...');
				/***********************************************************/
				$('#TipoProyectoInv').effect("pulsate", {times:3}, 500);
				$('#TipoProyectoInv').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
		
		var OtroType	= '';
			
		if(TipoProyectoInv==5 || TipoProyectoInv=='5'){
			var OtroType	= $('#OtroType').val();
			if(!$.trim(OtroType)){
				alert('Digite Cual ...');
					/***********************************************************/
					$('#OtroType').effect("pulsate", {times:3}, 500);
					$('#OtroType').css('border-color','#F00');
					/***********************************************************/
					return false;	
				}
			}		
		
		//console.log(nicEditors.findEditor('Accion'));
		var Accion = $.trim(document.getElementById('AccionPd').innerHTML = nicEditors.findEditor('AccionPd').getContent());
                   Accion = $("<div/>").html(Accion).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   Accion = $.trim(Accion);	
		
		//document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent();
	
		//var Accion				= $('#Accion').val();
		//alert(Accion);
		
		if(!$.trim(Accion)){
			/*************************************/
				alert('Digite El Plan De Trabajo...');
				return false;
			/*************************************/
			}
			
			
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTemp2',
					 Accion:Accion,
					 NomProyecto:NomProyecto,
					 TipoProyectoInv:TipoProyectoInv,
					 OtroType:OtroType,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								/****************************/
								
								$('#id_CampoDos').val(data.Last_id);
								
                                /**********************Ajax Interno*******************************/
								
								 $.ajax({//Ajax
										  type: 'POST',
										  url: 'PlanTrabjoDocente_html.php',
										  async: false,
										  dataType: 'json',
										  data:({actionID:'SaveTempDetalle',
												 Accion:Accion,
												 Last_id:data.Last_id,
												 Periodo_id:Periodo_id}),
										 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
										 success:function(data){
												 if(data.val=='FALSE'){
														alert(data.descrip);
														return false;
													}else{
														
														alert(data.descrip);
														
														var myNicEditor = nicEditors.findEditor('AccionPd');
                               							 myNicEditor.setContent(""); 
														 
														
														AccionesProyecto(Periodo_id,NameHidden,2);
														}
											  }
										 }); //AJAX
								
								/***********************Fin Ajax Interno*******************************/
								/****************************/
							}
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
		}else{
			/*****************************************************************************************/
			
			var id_CampoDos		= $('#id_CampoDos').val();
			
			var Accion = $.trim(document.getElementById('AccionPd').innerHTML = nicEditors.findEditor('AccionPd').getContent());
                   Accion = $("<div/>").html(Accion).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   Accion = $.trim(Accion);	
		
		//document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent();
	
		//var Accion				= $('#Accion').val();
		//alert(Accion);
		
		if(!$.trim(Accion)){
			/*************************************/
				alert('Digite El Plan De Trabajo...');
				return false;
			/*************************************/
			}
			
			
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTempDetalle',
					 Accion:Accion,
					 Last_id:id_CampoDos,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
								
								
                                var myNicEditor = nicEditors.findEditor('AccionPd');
                                myNicEditor.setContent(""); 

								AccionesProyecto(Periodo_id,NameHidden,2);
								/****************************/
							}
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
			/******************************************************************************************/
			}
		/*********************************************************************/
		}
	if(op==3 || op=='3'){
		/**********************************************************************/
		/**********************************************************************/
		}
	if(op==4 || op=='4'){
		/**********************************************************************/
		/**********************************************************************/
		}
	/**************************************************************/
	}
function AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden){
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'AcionesExixtentes',
			  		 Facultad_id:Facultad_id,
					 Programa_id:Programa_id,
					 Materia_id:Materia_id,
					 Periodo_id:Periodo_id,
					 NameHidden:NameHidden}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	$('#Acci_Temp').css('display','inline');
					$('#AcionesTemp').html(data);
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
	}
function Color(i){
	/**************************************/
		$('#Accion_'+i).css('background-color','#999');
	/**************************************/
	}
function SinColor(i){
	/**************************************/
		$('#Accion_'+i).css('background-color','#FFF');
	/**************************************/
	}		
function Visualizar(id,i){
	/******************************************************************/
	
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'VisualizarTemp',id:id,i:i}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	$('#TablaDinamic').css('display','none')
					$('#CaragarEvidenciaTemp').css('display','inline');
				 	$('#CaragarEvidenciaTemp').css('margin','0 auto');
					$('#CaragarEvidenciaTemp').html(data);
			 }
		  }); //AJAX
	
	/******************************************************************/
	}	
function EvidenciaSaveTemp(){}	
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
function VerAcionesTemp(NameHidden){
	
		var Periodo_id		= $('#Periodo_id').val();
		var Facultad_id		= $('#Facultad_id').val();
		var Programa_id		= $('#Programa_id').val();
		var Materia_id		= $('#Materia_id').val();
		
		AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden);
	
	}	
function Close(){
	/******************************************************************/
	
		
	$('#TablaDinamic').css('display','inline');
	$('#CaragarEvidenciaTemp').css('display','none');
		
	
	/******************************************************************/
	}		
function FormatBox(id_Box,id_Form){
	/**********************************************************/
		$('#'+id_Form+' #'+id_Box).val('');
	/**********************************************************/
	}	
function FormatBoxEvidencia(id_Box){
	/**********************************************************/
		$('#'+id_Box).val('');
	/**********************************************************/
	}	
function CajaVer(){
	/********************************************/
		var SelectType	= $('#TipoProyectoCompromiso').val();
		
		if(SelectType=='6' || SelectType==6){
				$('#Tr_CualType').css('visibility','visible');
				$('#CualType').val('');
			}else{
					$('#CualType').val('');
					$('#Tr_CualType').css('visibility','collapse');
				}
	/********************************************/
	}	
function OtroType(){
	/********************************************/
		var SelectType	= $('#TipoProyectoInv').val();
		
		if(SelectType=='5' || SelectType==5){
				$('#Tr_OtroType').css('visibility','visible');
				$('#OtroType').val('');
			}else{
					$('#OtroType').val('');
					$('#Tr_OtroType').css('visibility','collapse');
				}
	/********************************************/
	}	
function Guardar(name_id,op){
	
	var Periodo_id	= $('#Periodo_id').val();	
	
	/**************************Save Primera Pestaña************************************/
	if(op==1 || op=='1'){
		/**********************************************************/
			var Cadena	= $('#CadenaTableUno').val();
			
			var Auto = $.trim(document.getElementById('Auto').innerHTML = nicEditors.findEditor('Auto').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	
				   
			var PorcentajeUno	= $('#PorcentajeUno').val();	   
			
			var Consolidado = $.trim(document.getElementById('Consolidado').innerHTML = nicEditors.findEditor('Consolidado').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	
				   
			var Mejora = $.trim(document.getElementById('Mejora').innerHTML = nicEditors.findEditor('Mejora').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabUno',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                var myNicEditor = nicEditors.findEditor('Auto');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('Consolidado');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('Mejora');
                                myNicEditor.setContent(""); 
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/	   
		/**********************************************************/
		}
	/***************************Save Segunda Pestaña***********************************/
	if(op==2 || op=='2'){
		/**********************************************************/
			var Cadena	= $('#CadenaTableDos').val();
			
			var Auto = $.trim(document.getElementById('AutoPd').innerHTML = nicEditors.findEditor('AutoPd').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	
				   
			var PorcentajeUno	= $('#PorcentajeDos').val();	   
			
			var Consolidado = $.trim(document.getElementById('ConsolidadoPd').innerHTML = nicEditors.findEditor('ConsolidadoPd').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	
				   
			var Mejora = $.trim(document.getElementById('MejoraPd').innerHTML = nicEditors.findEditor('MejoraPd').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabDos',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                var myNicEditor = nicEditors.findEditor('AutoPd');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('ConsolidadoPd');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('MejoraPd');
                                myNicEditor.setContent(""); 
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/************************Save Tercera Pestaña**************************************/
	if(op==3 || op=='3'){
		/**********************************************************/
			var Cadena	= $('#CadenaTableTres').val();
			
			var Auto = $.trim(document.getElementById('AutoPt').innerHTML = nicEditors.findEditor('AutoPt').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	
				   
			var PorcentajeUno	= $('#PorcentajeTres').val();	   
			
			var Consolidado = $.trim(document.getElementById('ConsolidadoPt').innerHTML = nicEditors.findEditor('ConsolidadoPt').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	
				   
			var Mejora = $.trim(document.getElementById('MejoraPt').innerHTML = nicEditors.findEditor('MejoraPt').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabTres',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                var myNicEditor = nicEditors.findEditor('AutoPt');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('ConsolidadoPt');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('MejoraPt');
                                myNicEditor.setContent(""); 
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/************************Save Cuarta Pestaña**************************************/
	if(op==4 || op=='4'){
		/**********************************************************/
			var Cadena	= $('#CadenaTableCuatro').val();
			
			var Auto = $.trim(document.getElementById('AutoPc').innerHTML = nicEditors.findEditor('AutoPc').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	
				   
			var PorcentajeUno	= $('#PorcentajeCuatro').val();	   
			
			var Consolidado = $.trim(document.getElementById('ConsolidadoPc').innerHTML = nicEditors.findEditor('ConsolidadoPc').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	
				   
			var Mejora = $.trim(document.getElementById('MejoraPc').innerHTML = nicEditors.findEditor('MejoraPc').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabCuatro',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                var myNicEditor = nicEditors.findEditor('AutoPc');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('ConsolidadoPc');
                                myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                var myNicEditor = nicEditors.findEditor('MejoraPc');
                                myNicEditor.setContent(""); 
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/**************************************************************/
	}
function AccionesProyecto(Periodo_id,NameHidden,op){
	/******************************************************************/
		if(op==2  || op=='2'){
				var id_CampoDos		= $('#id_CampoDos').val();
				
				
				/**********************Ajax Interno*******************************/
								
				 $.ajax({//Ajax
						  type: 'POST',
						  url: 'PlanTrabjoDocente_html.php',
						  async: false,
						  //dataType: 'json',
						  data:({actionID:'AccExistentes',
								 id:id_CampoDos,
								 Periodo_id:Periodo_id}),
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success:function(data){
								 $('#Acci_TempDos').css('display','inline');
								 $('#AcionesTempDos').html(data);
							  }
						 }); //AJAX
				
				/***********************Fin Ajax Interno*******************************/
				
			}
	/******************************************************************/
	}
function AutoCompleteProyecto(){
	
	var Periodo_id	= $('#Periodo_id').val();	
	
	/*************************************************************/
	$('#NomProyecto').autocomplete({
					
			source: "PlanTrabjoDocente_html.php?actionID=AutoCompleteProyecto&Periodo_id="+Periodo_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#id_CampoDos').val(ui.item.idProyecto);
				
				}
			
		});
	/*************************************************************/
	}			
    </script>
    <?PHP
}	
?>
