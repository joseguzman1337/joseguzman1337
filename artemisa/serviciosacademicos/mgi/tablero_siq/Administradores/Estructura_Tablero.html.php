<?PHP
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/*session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
	
	case 'TableroDinamico':{
		MainGeneral();
		JsGenral();
		
		global $C_Estructura_Tablero,$userid,$db;
		
		$dato        = $_GET['dato'];
		$Programa_id = $_GET['Programa_id'];
		
		$C_Estructura_Tablero->TableroDinamico($dato,$Programa_id);
		}break;
	case 'Nombre_area':{
		MainJson();
		global $userid,$db;
		
		$id_area    = $_GET['id_area'];
		
		
							 $SQL_areas='SELECT 

													idsiq_area,
													nombre
										
										
										FROM 
										
													siq_area
										
										WHERE
										
													idsiq_area="'.$id_area.'"
													AND
													codigoestado=100';
													
										if($Nombre_area=&$db->Execute($SQL_areas)===false){
												$a_vectt['val']			='FALSE';
												$a_vectt['descrip']		='Error al Buscar Nombre del Area....<br>'.$SQL_areas;
												echo json_encode($a_vectt);
												exit;
											}	
											
					$a_vectt['val']			='TRUE';
					$a_vectt['Nombre']		=$Nombre_area->fields['nombre'];
					echo json_encode($a_vectt);
					exit;								
		
		}break;
	default:{
		
		MainGeneral();
		JsGenral();
		
		global $C_Estructura_Tablero,$userid,$db;
		
		$id         = $_REQUEST['id_area'];
		$dato       = $_REQUEST['dato'];
		$programa   = $_REQUEST['programa'];
							
		$C_Estructura_Tablero->Principal($id,$dato,$programa);
		
	}break;
	}
function MainGeneral(){
	
		
		global $C_Estructura_Tablero,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		
		include('Estructura_Tablero.class.php');  $C_Estructura_Tablero = new Estructura_Tablero();
		
		
		
		#$db=writeHeader("Estrutura Doscuento",true);
	   $db=writeHeader("Gestión de Tablero",true);
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}	
function MainJson(){
	    global $userid,$db;
	    include("../../templates/template.php");
		$db=writeHeaderBD();
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function JsGenral(){
	?>
<style>
.first{
padding: 0px 14px 0px;
padding: 0px 14px 0px;
font-size: 20px;
cursor: pointer;
text-align: center;
display:inline-block;
/*border:1px solid #D4D4D4; */ 
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
-khtml-border-radius: 10px;
border-radius: 10px;
-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
box-shadow: 0 1px 2px rgba(0,0,0,.2);
background: #5D7D0E;
text-shadow: 0 1px 1px rgba(0,0,0,.3);
background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E));
/*filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#7DB72F', endColorstr='#4E7D0E');*/
border: 1px solid #538312;
color: #E8F0DE;
margin-left: 10px;


   
	}

 fieldset {
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
border-color:#CCC;
border-style: solid;
border-width: 1px;

}
legend {
color: #000; 
font-size:14px;
font-weight: bold;
letter-spacing:-1px;
padding-bottom:20px;
padding-top:8px;
text-transform:capitalize;
}
.Text th .Text td{ 

font-family:"Times New Roman", Times, serif;
border:0px solid #000;
	padding:.5em;
	}
.cajas{
	border-color:#CCC;
	background-color:#FFF; 
	
	}
.Border{
	border:0px solid #000;
	padding:.5em;
	}
</style>

 <script language="javascript">
 $(function() {
		 var icons = {
            header: "ui-icon-circle-arrow-e",
            activeHeader: "ui-icon-circle-arrow-s"
        };
        
        $( "#accordion" ).accordion({
            heightStyle: "content",
			icons: icons,
			collapsible: true
			
        });
    });
function VerIndicador(id_area,dato,programa){
			
			
			$.ajax({
				   type: 'GET',
				   url: 'Estructura_Tablero.html.php',
				   dataType: 'json',
				   data:({actionID: 'Nombre_area',id_area:id_area}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
										getemail=dhtmlmodal.open('newsletterbox', 'ajax', 'Estructura_Tablero.html.php?&id_area='+id_area+'&dato='+dato+'&programa='+programa, 'Indicadores Del Area '+data.Nombre, 'width=900px, height=600px, left=300,right=0, resize=0,top=100%'); return false;
										}					
				   } 
				});	
			
		}
function VerSemafor(){
		var Semaforo_id = $('#Semaforo_id').val();
		
		if(Semaforo_id==0){
				
				$('.Semaforo').css('display','none');
				$('#Semaforo_id').val(1);
				$('#Semaforo_img').css('opacity','0.3');
							
			}else{
				
					$('.Semaforo').css('display','block');
					$('#Semaforo_id').val(0);
					$('#Semaforo_img').css('opacity','1');
				
				}
	}			
 </script>
<?PHP 
}
?>