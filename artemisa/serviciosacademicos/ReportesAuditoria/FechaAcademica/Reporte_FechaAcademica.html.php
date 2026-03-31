<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
        /**
         * @modified Andres Ariza <emailautor@unbosque.edu.do>
         * Cuando cuando se cambia la modalidad academica se envia una peticion ajax con el actionID updatePeriodo
         * para traer los periodos correspondientes a dicha modalidad seleccionada
         * @since Junio 18, 2018
        */
        case 'updatePeriodo':
            global $C_Reporte_FechasAcademicas,$db;
            require_once("../templates/mainjson.php");
            require_once("Reporte_FechaAcademica.class.php");
            $C_Reporte_FechasAcademicas = new Reporte_FechasAcademicas();
            
            $C_Reporte_FechasAcademicas->Periodo($_GET['idModalidad']);
            break;
	case 'Buscar':{
		
		global $C_Reporte_FechasAcademicas,$userid,$db;
		
		MainGeneral();
		JsGenral();
		
		$id_Movilidad			= $_GET['id_Movilidad'];
		$Periodo				= $_GET['Periodo'];
		$id_carrera				= $_GET['id_carrera'];
													   
		$C_Reporte_FechasAcademicas->Buscar($id_Movilidad,$Periodo,$id_carrera);
		
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
						//echo $SQL_Carrera;
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
		global $C_Reporte_FechasAcademicas,$userid,$db;
		
		MainGeneral();
		JsGenral();
		
		$C_Reporte_FechasAcademicas->Principal();
		
		}break;
}
function MainGeneral(){
	
		
		global $C_Reporte_FechasAcademicas,$userid,$db;
		
		
		include("../templates/MenuReportes.php");
		
		include('Reporte_FechaAcademica.class.php');  $C_Reporte_FechasAcademicas = new Reporte_FechasAcademicas();
		
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
        /**
         * @modified Andres Ariza <emailautor@unbosque.edu.do>
         * Cuando cuando se cambia la modalidad academica se envia una peticion ajax con el actionID updatePeriodo
         * para traer los periodos correspondientes a dicha modalidad seleccionada
         * @since Junio 18, 2018
        */
        function UpdatePeriodo(obj){
            var idModalidad = $(obj).val();
            $.ajax({
                url: "Reporte_FechaAcademica.html.php",
                type: "GET",
                dataType: "html",
                data: {
                    actionID : 'updatePeriodo',
                    idModalidad : idModalidad
                },
                success: function( data ){
                    $("#Periodo").parent().html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {}
            }) ;
        }
    	function ResetModalidad(){
				$('#Modalidad').val('');
				$('#Modalidad').val('');
			}
		function ResetCarrera(){
				$('#carrera').val('');
				$('#id_carrera').val('');
			}
		function autoCompleModalidad(){
			/********************************************************/	
				$('#Modalidad').autocomplete({
						
						source: "Reporte_FechaAcademica.html.php?actionID=autoCompleModalidad",
						minLength: 2,
						select: function( event, ui ) {
							
							$('#Modalidad').val(ui.item.id_modalidad);
							
							}
						
					});//
			/********************************************************/	
			}
		function autoCompleteCarrera(){
			/********************************************************/	
			
			var id_Movilidad = $('#Modalidad').val();
			if(!$.trim(id_Movilidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad Academica');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
			
				$('#carrera').autocomplete({
						
						source: "Reporte_FechaAcademica.html.php?actionID=autoCompleteCarrera&id_Movilidad="+id_Movilidad,
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
			
				var id_Movilidad  		= $('#Modalidad').val();
				var id_carrera			= $('#id_carrera').val();
				var Periodo 			= $('#Periodo').val();
				
				if(!$.trim(id_Movilidad) || id_Movilidad=='-1' || id_Movilidad==-1){
					alert('Primero debe Buscar y Selecionar una Modalidad Academica');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
				
				if(Periodo=='-1' || Periodo==-1){
					alert('Primero debe Selecionar un Periodo');
					$('#Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
				
				if(!$.trim(id_carrera)){
					if($('#TodasCarreras').is(':checked')==false){
						alert('Primero debe Buscar y Selecionar una Carrera o Activar el Check de Todas');
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
				
				/*************************************************************************/
				
					 $.ajax({//Ajax
							  type: 'GET',
							  url: 'Reporte_FechaAcademica.html.php',
							  async: false,
							  //dataType: 'json',
							  data:({actionID:'Buscar',id_Movilidad:id_Movilidad,
							  						   Periodo:Periodo,
													   id_carrera:id_carrera}),
							 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							 success:function(data){
									$('#DivReporte').html(data);
						   }
						}); //AJAX
				
				/*************************************************************************/
			
			}	
	function ExportarExel(){
		
				var id_Movilidad  		= $('#Modalidad').val();
				var id_carrera			= $('#id_carrera').val();
				var Periodo 			= $('#Periodo').val();
				
				if(!$.trim(id_Movilidad)){
					alert('Primero debe Buscar y Selecionar una Modalidad Academica');
					$('#Modalidad').effect("pulsate", {times:3}, 500);
					return false;
				}
				
				if(Periodo=='-1' || Periodo==-1){
					alert('Primero debe Selecionar un Periodo');
					$('#Periodo').effect("pulsate", {times:3}, 500);
					return false;
				}
				
				if(!$.trim(id_carrera)){
					if($('#TodasCarreras').is(':checked')==false){
						alert('Primero debe Buscar y Selecionar una Carrera o Activar el Check de Todas');
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
					
			location.href='ExportaExcelFechaAcademica.php?id_Movilidad='+id_Movilidad+'&id_carrera='+id_carrera+'&Periodo='+Periodo;		
		
		}		
    </script>
    <?PHP
	
	}	
?>