<?PHP
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
/*    
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
*/
switch($_REQUEST['actionID']){
	
	case 'Save':{
		 MainJson();
		 global $userid,$db;
		 
		 $id_Documento			= $_POST['id_Documento'];	
		 $Titulo				= $_POST['Titulo'];
		 $Cuerpo				= $_POST['Cuerpo'];
		 $Autor					= $_POST['Autor'];
		 $Dependencia			= $_POST['Dependencia'];
		 
		 
		 $SQL_Orden='SELECT
		 					TextoInicio_id,
							max(orden) AS orden
							
		 			 FROM
					 		siq_Textoinicio
					 WHERE
					 		documento_id="'.$id_Documento.'"
							AND
							codigoestado=100';
							
					
					if($D_Orden=&$db->Execute($SQL_Orden)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error En la Consulta...<br>'.$SQL_Orden;
							echo json_encode($a_vectt);    
							exit;
						}
						
		 $Orden	= $D_Orden->fields['orden']+1;				
		 
		 
		 $SQL_Insert='INSERT  INTO  siq_Textoinicio (documento_id,titulo,cuerpo,autor,dependencia,orden,userid,entrydate)VALUES("'.$id_Documento.'","'.$Titulo.'","'.$Cuerpo.'","'.$Autor.'","'.$Dependencia.'","'.$Orden.'","'.$userid.'",NOW())';
		 
		 
		 		if($Insert=&$db->Execute($SQL_Insert)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el SQL Insert Texto Inicial...<br>'.$SQL_Insert;
						echo json_encode($a_vectt);    
						exit;
					}
					
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se HA guardado Corectamente.';
			echo json_encode($a_vectt);    
			exit;		
		 
		 
		}break;
	case 'AutoCompleteDocumento':{
		 MainJson();
		 global $userid,$db;
		 
		 $Letra   = $_REQUEST['term'];
		 
		 $SQL='SELECT 
		 				idsiq_estructuradocumento  AS id, 
						nombre_documento, 
						nombre_entidad, 
						tipo_documento, 
						fechainicial, 
						fechafinal  
				FROM 
						siq_estructuradocumento 
						
				WHERE 
				
						nombre_documento LIKE "%'.$Letra.'%" 
						AND 
						codigoestado=100 ';
						
				if($Datos_Doc=&$db->Execute($SQL)===false){
						echo 'Error en eSQL De Buscar DAtos del Documento...<br>'.$SQL;
						die;
					}		
		 
		  $Result_F = array();
						
				while(!$Datos_Doc->EOF){
						$Rf_Vectt['label']=$Datos_Doc->fields['nombre_documento']; 
						$Rf_Vectt['value']=$Datos_Doc->fields['nombre_documento'];
						
						$Rf_Vectt['Documento']=$Datos_Doc->fields['nombre_documento'];
						$Rf_Vectt['Entidad']=$Datos_Doc->fields['nombre_entidad'];
						
						if($Datos_Doc->fields['tipo_documento']==1){
								$Tipo_Doc = 'Institucional';
							}else{
									$Tipo_Doc = 'Programa';
								}
						
						$Rf_Vectt['Tipo']=$Tipo_Doc;
						$Rf_Vectt['Inicial']=$Datos_Doc->fields['fechainicial'];
						$Rf_Vectt['Final']=$Datos_Doc->fields['fechafinal'];
						
						$Rf_Vectt['id_Documento']=$Datos_Doc->fields['id'];
						
						array_push($Result_F,$Rf_Vectt);
					$Datos_Doc->MoveNext();	
					}	
					
			echo json_encode($Result_F);
		 
		}break;
	default:{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		define(AJAX,'FALSE');
		MainGeneral();
		JsGenral();

		$URL = array();
		
		$URL[0] = 'Estructura_documento.html.php';
		$URL[1] = 'Estructura_documento.html.php?actionID=Gestion';
		$URL[2] = 'Texto_Inicio.html.php';
		$nombre = array();
		
		$nombre[0]= 'Estructura Documento.';
		$nombre[1]= 'Gesti&oacute;n de Estructura de Documentos.';
		$nombre[2]= 'Estructura Intro.';
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 0;
		$Active[2] = 1;
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_Texto_InicialDocumento,$userid,$db;
		#include('Estructura_documento.class.php');  $C_Estructura_documento = new Estructura_documento();
				
		$C_Texto_InicialDocumento->Principal();
		
		}break;
	}
function MainGeneral(){
	
		
		global $C_Texto_InicialDocumento,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		#
		include('Texto_Inicio.class.php');  $C_Texto_InicialDocumento = new Texto_InicialDocumento();
		
		if(AJAX=='FALSE'){
		
		$db=writeHeader("Estructura",true);
		}else{
			$db=writeHeaderBD();
			}
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
  <!--<link rel="stylesheet" href="../../css/style.css" type="text/css" />-->
					<style>
						#sortable1,sortable2,sortable_Factores, sortable_F, sortable_Ind { list-style-type: none; margin: 0; padding: 0; width: 60%; }
						#sortable1 li, sortable2 li , sortable_Factores, li sortable_F li, sortable_Ind li{ margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
						#sortable1 li span,sortable2 li span,sortable_Factores li span,sortable_F li span,sortable_Ind li span{ position: absolute; margin-left: -1.3em; }
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
						.submit {
								padding: 9px 17px;
							   font-family: Helvetica, Arial, sans-serif;
							   font-weight: bold;
							   line-height: 1;
							   color: #444;
							   border: none;
							   text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
							   background-image: -webkit-gradient( linear, 0% 0%, 0% 100%, from(#fff), to(#bbb));
							   background-image: -moz-linear-gradient(0% 100% 90deg, #BBBBBB, #FFFFFF);
							   background-color: #fff;
							   border: 1px solid #f1f1f1;
							   border-radius: 10px;
							   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5)
							}
						.Borde{
							border:#FFFFFF solid 1px;
							}		
                    </style> 
  
<script type="text/javascript" language="javascript" src="../../js/jquery.fastLiveFilter.js"></script> 

<script type="text/javascript" language="javascript" src="Texto_Inicio.js"></script> 

<?PHP
}
?>
