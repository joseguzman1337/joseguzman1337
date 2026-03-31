<?PHP 

switch($_REQUEST['actionID']){
	case 'autoCompleteCarreraOtra':{
		global $userid,$db;
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		$id_Movilidad = $_REQUEST['id_Movilidad'];
		$CarreraOtra  = $_REQUEST['CarreraOtra'];
		
		  $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id_Movilidad.'"
						AND
						nombrecarrera LIKE "%'.$Letra.'%"
						AND
						codigocarrera<>"'.$CarreraOtra.'"';
						
				if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Auto Completar Carrera...<br>'.$SQL_Carrera;
						die;
					}
							
		$Result_F = array();
				
				if(!$D_Carrera->EOF){
									
					while(!$D_Carrera->EOF){
						
							$Rf_Vectt['label']=$D_Carrera->fields['nombrecarrera'];
							$Rf_Vectt['value']=$D_Carrera->fields['nombrecarrera'];
							
							$Rf_Vectt['id_carreraOtra']=$D_Carrera->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Carrera->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);		
					
		}break;
	case 'autoCompleteMateria':{
		global $userid,$db;
		MainJson();
		
		#echo 'Aca Entro...';
		
		$Letra   	= $_REQUEST['term'];
		$id_carrera = $_REQUEST['id_carrera'];
		
		
		if($id_carrera!=0){
				$CodicionCarrera = ' AND	codigocarrera="'.$id_carrera.'"';	
			}
		if($id_carrera==0){
				$CodicionCarrera = 'GROUP BY nombremateria';
			}	
		
		   $SQL_Materia='SELECT 
    
						codigomateria,
						nombremateria
						
						FROM 
						
						materia
						
						WHERE
						
						(codigomateria LIKE "%'.$Letra.'%" OR nombremateria LIKE "%'.$Letra.'%") '.$CodicionCarrera;  
						
						
					if($D_Materia=&$db->Execute($SQL_Materia)===false){
							echo 'Error en el SQL de Auto Completar Materia...<br>'.$SQL_Materia;
							die;
						}	
						
						
			$Result_F = array();
				
				if(!$D_Materia->EOF){
									
					while(!$D_Materia->EOF){
						
						if($id_carrera==0){
							
								$Rf_Vectt['label']=$D_Materia->fields['nombremateria'];
								$Rf_Vectt['value']=$D_Materia->fields['nombremateria'];
								$Rf_Vectt['id_Materia']=$D_Materia->fields['codigomateria'];

							
							}else{
						
								$Rf_Vectt['label']=$D_Materia->fields['codigomateria'].' :: '.$D_Materia->fields['nombremateria'];
								$Rf_Vectt['value']=$D_Materia->fields['codigomateria'].' :: '.$D_Materia->fields['nombremateria'];
								$Rf_Vectt['id_Materia']=$D_Materia->fields['codigomateria'];
							
							}
							array_push($Result_F,$Rf_Vectt);
						$D_Materia->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);					
		
		}break;	
	case'Buscar':{
		global $C_EstudianteRiesgo,$userid,$db;
		MainGeneral();
		JsGenral();
		
		
		$id_carrera			= $_GET['id_carrera'];
		$Periodo			= $_GET['Periodo'];
		$Semestre			= $_GET['Semestre'];
		$Riesgo				= $_GET['Riesgo'];
		
		
		$C_EstudianteRiesgo->Buscar($id_carrera,$Periodo,$Semestre,$Riesgo);
		
		}break;
	case 'autoCompleteCarrera':{
		global $userid,$db;
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		$id_Movilidad = $_REQUEST['id_Movilidad'];
		
		  $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id_Movilidad.'"
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
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		
		$SQL_Modalidad='SELECT 

						codigomodalidadacademica as id,
						nombremodalidadacademica as nombre
						
						
						FROM 
						
						modalidadacademica
						
						WHERE
						
						codigoestado=100
						AND
						nombremodalidadacademica LIKE "%'.$Letra.'%"';
						
				if($D_Movilidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Autocompletar Movilidad...'.$SQL_Modalidad;
						die;
					}	
					
			$Result_F = array();
				
				if(!$D_Movilidad->EOF){
									
					while(!$D_Movilidad->EOF){
						
							$Rf_Vectt['label']=$D_Movilidad->fields['nombre'];
							$Rf_Vectt['value']=$D_Movilidad->fields['nombre'];
							
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
		
		global $C_EstudianteRiesgo,$userid,$db;
		MainGeneral();
		JsGenral();
		
		$C_EstudianteRiesgo->Principal();
		
		}break;
	
	}

function MainGeneral(){
		
		
		global $C_EstudianteRiesgo,$userid,$db;
		

		include("../../templates/MenuReportes.php");

		require('Reporte_EstudianteRiesgo.class.php');  $C_EstudianteRiesgo = new Estudiante_Riesgo();

		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}

		 $userid=$Usario_id->fields['id'];
	}
function MainJson(){
	
	global $userid,$db;
		
		
		include("../../templates/mainjson.php");
		
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}	
function JsGenral(){
	?>
    <style>
    .Borde_td{
	border:#000000 1px solid;
	}
	.Titulos{
		border:#000000 1px solid;
		background-color:#90A860;
	}
    </style>
    <style type="text/css" title="currentStyle">
			@import "../../DataTables-1.9.4/media/css/demo_page.css";
			@import "../../DataTables-1.9.4/media/css/demo_table.css";
			<!--@import "../../DataTables-1.9.4/extras/TableTools/media/css/TableTools.css";-->
		</style>
    <script type="text/javascript" language="javascript" src="../../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="../../DataTables-1.9.4/media/css/jquery.dataTables.css" type="text/css" />
    <script type="text/javascript" charset="utf-8" src="../../DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
		<script type="text/javascript" charset="utf-8" src="../../DataTables-1.9.4/extras/TableTools/media/js/TableTools.js"></script>
    
    <script>
	/****************************************************************/
	$(document).ready( function () {
	//TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls" ];
	
	$('#example').dataTable( {
		//"sDom": 'T<"clear">lfrtip'
	} );
} );
	/**************************************************************/
    function ResetModalidad(){
				$('#Modalidad').val('');   
				$('#id_modalidad').val('');
			}
		function ResetCarrera(){
				$('#carrera').val('');
				$('#id_carrera').val('');
			}
		function autoCompleModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						
						source: "Reporte_EstudianteRiesgo.html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_modalidad').val(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
		function autoCompleteCarrera(){
			/********************************************************/	
			
			var id_modalidad = $('#id_modalidad').val();
			
			if(!$.trim(id_modalidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
			
				$('#carrera').autocomplete({
						
						source: "Reporte_EstudianteRiesgo.html.php?actionID=autoCompleteCarrera&id_Movilidad="+id_modalidad,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_carrera').val(ui.item.id_carrera);
							
							}
						
					});//
			/********************************************************/
			}
		function Activar(){
				
				if($('#TodasCarreras').is(':checked')){
						$('#carrera').val('');
						$('#id_carrera').val('');
						$('#carrera').attr('disabled',true);
					}else{
							$('#carrera').attr('disabled',false);
						}
				
			}
		function Buscar(){
				
				var id_carrera		= $('#id_carrera').val();
				
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')){
								var id_carrera = 0;
							}
					}
					
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')==false){
								alert('Indique que carrera ');
								$('#TodasCarreras').css('border-color','#F00');
					    		$('#TodasCarreras').effect("pulsate", {times:3}, 500);
								$('#carrera').css('border-color','#F00');
					    		$('#carrera').effect("pulsate", {times:3}, 500);
								return false;
							}
					}	
					
				var Periodo			= $('#Periodo').val();	
				
				if(Periodo==-1 || Periodo=='-1'){
						alert('Selecione un Periodo');
						$('#Periodo').css('border-color','#F00');
					    $('#Periodo').effect("pulsate", {times:3}, 500);
						return false;
					}
					
					
				var Semestre = $('#Semestre').val();	
				
				if(Semestre==-1 || Semestre=='-1'){
						alert('Seleccione el Semestre');
						$('#Semestre').css('border-color','#F00');
					    $('#Semestre').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				var Riesgo	= $('#Riesgo').val();	
				
				if(Riesgo==-1 || Riesgo=='-1'){
						alert('Seleccione el Riesgo');
						$('#Riesgo').css('border-color','#F00');
					    $('#Riesgo').effect("pulsate", {times:3}, 500);
						return false;
					}
			/*************************************************************/
				
				$('#DivReporte').html('<blink>Cargando...</blink>');
				
				$.ajax({//Ajax
					  type: 'GET',
					  url: 'Reporte_EstudianteRiesgo.html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'Buscar',id_carrera:id_carrera,
											   Periodo:Periodo,
											   Semestre:Semestre,
											   Riesgo:Riesgo}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#DivReporte').html(data);
				   },
				}); //AJAX
				
			/*************************************************************/		
				
			}	
		function ExportarExel(){
				
				var id_carrera		= $('#id_carrera').val();
				
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')){
								var id_carrera = 0;
							}
					}
					
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')==false){
								alert('Indique que carrera ');
								return false;
							}
					}	
					
				var Periodo			= $('#Periodoini').val();	
				
				if(Periodo==-1 || Periodo=='-1'){
						alert('Selecione un Periodo');
						return false;
					}
					
					location.href='ExportarExcelReporteCortes.php?id_carrera='+id_carrera+'&Periodo='+Periodo;
					
			}	
  </script>
<?PHP
}
?>