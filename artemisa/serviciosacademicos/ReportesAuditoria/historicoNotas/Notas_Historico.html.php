<?php
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'Buscar':{
		global $C_Notas_Historico,$userid,$db;
		MainGeneral();
		JsGenral(); 
		
		$id_modalidad			= $_GET['id_modalidad'];
		$Periodoini				= $_GET['Periodoini'];
		$Periodofin				= $_GET['Periodofin'];
		$id_carrera				= $_GET['id_carrera'];      
		$Tipo_Nota				= $_GET['Tipo_Nota'];
		$id_Materia				= $_GET['id_Materia'];
		$Nom_Materia			= $_GET['Nom_Materia'];
		
		
		$C_Notas_Historico->Buscar($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia,$Nom_Materia);
		
		}break;
	case 'autoCompleteMateria':{
		global $userid,$db;
		MainJson();
		
		
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
		
		global $C_Notas_Historico,$userid,$db;
		MainGeneral();
		JsGenral();
		
		$C_Notas_Historico->Principal();
		
		}break;
	
	}

function MainGeneral(){
	
		global $C_Notas_Historico,$userid,$db;
		
		
		include("../templates/MenuReportes.php");
		
		include('Notas_Historico.class.php');  $C_Notas_Historico = new Notas_Historico();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function MainJson(){
	
	global $userid,$db;
		
		
		include("../templates/mainjson.php");
		
		
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
    <script>
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
						
						source: "Notas_Historico.html.php?actionID=autoCompleModalidad",
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
						
						source: "Notas_Historico.html.php?actionID=autoCompleteCarrera&id_Movilidad="+id_modalidad,
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
			/*************************************************************/
				var id_modalidad 		= $('#id_modalidad').val();
				var Periodoini			= $('#Periodoini').val();
				var Periodofin			= $('#Periodofin').val();
				var id_carrera			= $('#id_carrera').val();
				var Tipo_Nota			= $('#Tipo_Nota').val();
				var id_Materia			= $('#id_Materia').val();
				var Nom_Materia			= $('#Materia').val();
				
				if(!$.trim(id_modalidad)){
						alert('Primero debe Buscar y Selecionar una Modalidad Academica');
						$('#Modalidad').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				if(Periodoini==-1 || Periodoini=='-1'){
						alert('Primero debe Selecionar un Periodo Inicial');
						$('#Periodoini').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				if(Periodofin==-1 || Periodofin=='-1'){
						alert('Primero debe Selecionar un Periodo Final');
						$('#Periodofin').effect("pulsate", {times:3}, 500);
						return false;
					}		
				
				if(Tipo_Nota==-1 || Tipo_Nota=='-1'){
						alert('Primero debe Selecionar un Tipo de Nota');
						$('#Tipo_Nota').effect("pulsate", {times:3}, 500);
						return false;
					}	
					
				if(!$.trim(id_carrera)){
					if($('#TodasCarreras').is(':checked')==false){
							alert('Primero debe Buscar y Selecionar una Carrera o Activar el Check de Todas las Carreras');
							$('#carrera').effect("pulsate", {times:3}, 500);
							$('#TodasCarreras').effect("pulsate", {times:3}, 500);
							return false;
						}
					}	
					
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')){
								var id_carrera = 0;
							}
					}
					
				if(!$.trim(id_Materia)){
						if($('#TodasMaterias').is(':checked')==false){
							alert('Primero debe Buscar y Selecionar una Materia o Activar el Check de Todas las MAterias');
							$('#Materia').effect("pulsate", {times:3}, 500);
							$('#TodasMaterias').effect("pulsate", {times:3}, 500);
							return false;
						}	
					}
					
				if(!$.trim(id_Materia)){
						if($('#TodasMaterias').is(':checked')){
								var id_Materia = 0;
							}
					}	
				
						
			/*************************************************************/
				
				$('#DivReporte').html('<div>Cargando... por favor espere.</div>');
				
				$.ajax({//Ajax
					  type: 'GET',
					  url: 'Notas_Historico.html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'Buscar',id_modalidad:id_modalidad,
											   Periodoini:Periodoini,
											   Periodofin:Periodofin,
											   id_carrera:id_carrera,
											   Tipo_Nota:Tipo_Nota,
											   id_Materia:id_Materia,
											   Nom_Materia:Nom_Materia}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#DivReporte').html(data);
				   }
				}); //AJAX
				
			/*************************************************************/
			}		
		function ResetMateria(){
				$('#Materia').val('');
				$('#id_Materia').val('');
			}	
		function ActivarMateria(){
				
				if($('#TodasMaterias').is(':checked')){
						$('#Materia').val('');
						$('#id_Materia').val('');
						$('#Materia').attr('disabled',true);
					}else{
							$('#Materia').attr('disabled',false);
						}
				
			}
		function autoCompleteMateria(){
			/****************************************************/
			
			var id_carrera = $('#id_carrera').val();
			
			if(!$.trim(id_carrera)){
				if($('#TodasCarreras').is(':checked')==false){
						alert('Primero debe Buscar y Selecionar un Programa o Carrera');
						$('#carrera').effect("pulsate", {times:3}, 500);
						return false;
				   }
				}
			
				$('#Materia').autocomplete({
						
						source: "Notas_Historico.html.php?actionID=autoCompleteMateria&id_carrera="+id_carrera,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Materia').val(ui.item.id_Materia);
							
							}
						
					});//
			
			//**************************************************/
			}
		function ExportarExel(){
			/*************************************************************/
				var id_modalidad 		= $('#id_modalidad').val();
				var Periodoini			= $('#Periodoini').val();
				var Periodofin			= $('#Periodofin').val();
				var id_carrera			= $('#id_carrera').val();
				var Tipo_Nota			= $('#Tipo_Nota').val();
				var id_Materia			= $('#id_Materia').val();
				var Nom_Materia			= $('#Materia').val();
				
				if(!$.trim(id_modalidad)){
						alert('Primero debe Buscar y Selecionar una Modalidad Academica');
						$('#Modalidad').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				if(Periodoini==-1 || Periodoini=='-1'){
						alert('Primero debe Selecionar un Periodo Inicial');
						$('#Periodoini').effect("pulsate", {times:3}, 500);
						return false;
					}
					
				if(Periodofin==-1 || Periodofin=='-1'){
						alert('Primero debe Selecionar un Periodo Final');
						$('#Periodofin').effect("pulsate", {times:3}, 500);
						return false;
					}		
				
				if(Tipo_Nota==-1 || Tipo_Nota=='-1'){
						alert('Primero debe Selecionar un Tipo de Nota');
						$('#Tipo_Nota').effect("pulsate", {times:3}, 500);
						return false;
					}	
					
				if(!$.trim(id_carrera)){
					if($('#TodasCarreras').is(':checked')==false){
							alert('Primero debe Buscar y Selecionar una Carrera o Activar el Check de Todas las Carreras');
							$('#carrera').effect("pulsate", {times:3}, 500);
							$('#TodasCarreras').effect("pulsate", {times:3}, 500);
							return false;
						}
					}	
					
				if(!$.trim(id_carrera)){
						if($('#TodasCarreras').is(':checked')){
								var id_carrera = 0;
							}
					}
					
				if(!$.trim(id_Materia)){
						if($('#TodasMaterias').is(':checked')==false){
							alert('Primero debe Buscar y Selecionar una Materia o Activar el Check de Todas las MAterias');
							$('#Materia').effect("pulsate", {times:3}, 500);
							$('#TodasMaterias').effect("pulsate", {times:3}, 500);
							return false;
						}	
					}
					
				if(!$.trim(id_Materia)){
						if($('#TodasMaterias').is(':checked')){
								var id_Materia = 0;
							}
					}	
				
						
			/*************************************************************/
			
			location.href='ExportarExcelHistoricoNotas.php?id_modalidad='+id_modalidad+'&Periodoini='+Periodoini+'&Periodofin='+Periodofin+'&id_carrera='+id_carrera+'&Tipo_Nota='+Tipo_Nota+'&id_Materia='+id_Materia+'&Nom_Materia='+Nom_Materia;	
			}			
    </script>
<?PHP
}
?>