<?PHP
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case 'Excel':{
		global $userid,$db,$C_ListadoPlanesEstudio;
		
		MainGeneral();
		#JsGeneral();
		?>
        <style>
    	td{
			padding:15px;
			
		}
	.Titulo{
		background-color:green;
		color:white;
		border:1px solid green;
		}	
	.Table{
		
		padding:10px;
		border:5px solid gray;
		margin:0px;
		border-style:groove;/*groove  ridge*/
		}
	.Equibalencia{
		background-color:#D9FFA0;
		color:#000000;/*#D9FFA0*/
		}
	.Prerequisitos{
		background-color:#CCFFFF;
		color:#000000;/*#6699CC*/
		}	
	.Correquisito{
		background-color:#FFCC33;
		color:#000000;/*#FFCC33*/
		}			
    </style>
        <?PHP
		 $Hora = date('Y-m-d');
		 
		 				header('Content-type: application/vnd.ms-excel');
						header("Content-Disposition: attachment; filename=".$Hora.".xls");
						header("Pragma: no-cache");
						header("Expires: 0");
						
			$C_ListadoPlanesEstudio->Resultado($_GET['id_Programa'],$_GET['PlanesActivos'],0);	
		
		}break;
	case 'PlanesEstudio':{
		global $userid,$db,$C_ListadoPlanesEstudio;
		
		MainGeneral();
		JsGeneral();
		
		$CodigoCarrera		= $_GET['CodigoCarrera'];
		
		$C_ListadoPlanesEstudio->PlanesEstudio($CodigoCarrera);
		}break;
	case 'autoCompleCarrera':{
		
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
		 MainJson();
		 
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
	case 'BuscarInfo':{
		global $userid,$db,$C_ListadoPlanesEstudio;
		
		MainGeneral();
		JsGeneral();
		
		
		$C_ListadoPlanesEstudio->Resultado($_GET['id_Programa'],$_GET['PlanesActivos'],1);
		}break;
	default:{
			
			global $userid,$db,$C_ListadoPlanesEstudio;
			
			MainGeneral();
			JsGeneral();
			
			$C_ListadoPlanesEstudio->Principal($_SESSION['codigofacultad']);
			
		}break;
}
function MainGeneral(){
		
		
	
		global $userid,$db,$C_ListadoPlanesEstudio;
		
	    include_once ('ListadoPlanesEstudio_Class.php'); $C_ListadoPlanesEstudio = new ListadoPlanesEstudio();
		
		include("../../ReportesAuditoria/templates/MenuReportes.php");
		
		
			
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	
	}	
	
function MainJson(){
	global $userid,$db;
		
		
		include("../../ReportesAuditoria/templates/mainjson.php");
		
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}	
function JsGeneral(){
	?>
	
	<style>
    	td{
			padding:15px;
			
		}
	.Titulo{
		background-color:green;
		color:white;
		border:1px solid green;
		}	
	.Table{
		
		padding:10px;
		border:5px solid gray;
		margin:0px;
		border-style:groove;/*groove  ridge*/
		}
	.Equibalencia{
		background-color:#D9FFA0;
		color:#000000;/*#D9FFA0*/
		}
	.Prerequisitos{
		background-color:#CCFFFF;
		color:#000000;/*#6699CC*/
		}	
	.Correquisito{
		background-color:#FFCC33;
		color:#000000;/*#FFCC33*/
		}			
    </style>
    <script language="javascript">
	
	function BuscarInfo(){
		/*************************************************/	
			var id_Programa		= $('#id_Programa').val();
			var PlanesActivos	= $('#PlanesActivos').val();
			
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'ListadoPlanesEstudio_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'BuscarInfo',id_Programa:id_Programa,
					  							   PlanesActivos:PlanesActivos}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#CargarData').html(data);
				   }
			}); //AJAX
			
		/*************************************************/	
		}
	function ResetModalidad(){
			$('#Movilidad').val('');
			$('#id_Modalidad').val('');
		}
	function ResetPrograma(){
			$('#Programa').val('');
			$('#id_Programa').val('');
		}
	function AutoCompletModalidad(){		
	/********************************************************/	
				$('#Movilidad').autocomplete({
						
						source:"ListadoPlanesEstudio_html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Modalidad').val(ui.item.id_modalidad);
							
							
							
							}
						
					});//
			/********************************************************/	
		}
	function AutoCompletPrograma(){
		
		var id_Movilidad		= $('#id_Modalidad').val();

			/********************************************************/	
				$('#Programa').autocomplete({
						
						source: "ListadoPlanesEstudio_html.php?actionID=autoCompleCarrera&id_Movilidad="+id_Movilidad,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Programa').val(ui.item.id_carrera);
							
							BuscarPlanes(ui.item.id_carrera);
							
							}
						
					});//
			/********************************************************/	
		}	
	function BuscarPlanes(CodigoCarrera){
			/***************************AJAX***************************************/
				
				 $.ajax({//Ajax
					  type: 'GET',
					  url: 'ListadoPlanesEstudio_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'PlanesEstudio',CodigoCarrera:CodigoCarrera}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#Planes').html(data);
				   }
				}); //AJAX
			
			/***************************AJAX***************************************/
		}	
	function BuscarInfoContrucion(){
		/*************************************************/	
			var id_Programa		= $('#id_Programa').val();
			var PlanesActivos	= $('#PlanesContrucion').val();
			
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'ListadoPlanesEstudio_html.php',
					  async: false,
					  //dataType: 'json',
					  data:({actionID:'BuscarInfo',id_Programa:id_Programa,
					  							   PlanesActivos:PlanesActivos}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
							$('#CargarData').html(data);
				   }
			}); //AJAX
			
		/*************************************************/	
		}	
	function Cambio(){
			$('#PlanesActivos').val('-1')
		}	
	function Recambio(){
			$('#PlanesContrucion').val('-1')
		}	
	function ExportalExcel(id_Programa,PlanesActivos){
		
			location.href='ListadoPlanesEstudio_html.php?actionID=Excel&id_Programa'+id_Programa+'&PlanesActivos='+PlanesActivos;
		
		}	
	</script>
    <?PHP
	}
?>