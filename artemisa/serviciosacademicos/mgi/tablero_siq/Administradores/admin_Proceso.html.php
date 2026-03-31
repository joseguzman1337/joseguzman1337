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
	case 'Programa':{
		#MainGeneral();
		#JsGenral();
		MainJson();
		include('admin_Proceso.class.php');  $C_admin_Proceso = new admin_Proceso();
		
		global $C_admin_Proceso,$userid,$db;
		
		$id  =  $_GET['id'];
		
		$C_admin_Proceso->Programa_ajax($id);
		}break;
	case 'Save_AreasPro':{
		MainJson();
		global $db, $userid;
		
		$Cadena_Pro   = $_GET['Cadena_Pro'];
		$Proceso_id   = $_GET['Proceso_id'];
	    $CadenaLibre    = $_GET['CadenaLibre'];
		
		
		##################################
		 $C_Datos = explode(',',$Cadena_Pro);
		 #echo '<pre>';print_r($C_Datos);
		 #################################
		 
		 for($i=1;$i<count($C_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_procesopecar="'.$Proceso_id.'", userid_estado="'.$userid.'", changedate=NOW()
								 WHERE  codigoestado=100  AND  idsiq_area="'.$C_Datos[$i].'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }
			 }
		
		 #################################
		 ##################################
		 $L_Datos = explode(',',$CadenaLibre);
		# echo '<pre>';print_r($L_Datos);
		 #################################
		 
		 for($i=1;$i<count($L_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_procesopecar=0, userid_estado="'.$userid.'", changedate=NOW()
								 WHERE  codigoestado=100  AND  idsiq_area="'.$L_Datos[$i].'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }
			 }
		$a_vectt['val']			='TRUE';
		#$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
		echo json_encode($a_vectt);
		exit;
		
		}break;
	case 'EstructurarProceso':{
		MainGeneral();
		JsGenral();
		
		global $C_admin_Proceso,$userid,$db;
		
		$id  =  str_replace('row_','',$_GET['id']);
		
		$C_admin_Proceso->EstructuraProceso($id);
		}break;
	case 'Save_AreasPecar':{
		MainJson();
		global $db, $userid;
		
		$Cadena_P    = $_GET['Cadena_P'];
		$Pecar_id    = $_GET['Pecar_id'];
		$CadenaLibre = $_GET['CadenaLibre'];
		
		##################################
		 $C_Datos = explode(',',$Cadena_P);
		# echo '<pre>';print_r($C_Datos);
		 #################################
		 
		 for($i=1;$i<count($C_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_pecar="'.$Pecar_id.'", userid_estado="'.$userid.'", changedate=NOW()
								 WHERE  codigoestado=100  AND  idsiq_area="'.$C_Datos[$i].'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }
			 }
		
		 #################################
		 ##################################
		 $L_Datos = explode(',',$CadenaLibre);
		# echo '<pre>';print_r($C_Datos);
		 #################################
		 
		 for($i=1;$i<count($L_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_pecar=0, userid_estado="'.$userid.'", changedate=NOW()
								 WHERE  codigoestado=100  AND  idsiq_area="'.$L_Datos[$i].'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }
			 }
		
		 #################################
		
		$a_vectt['val']			='TRUE';
		#$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
		echo json_encode($a_vectt);
		exit;
		
		}break;
	case 'CargarAreas':{
		MainGeneral();
		JsGenral();
		
		global $C_admin_Proceso,$userid,$db;
		
		$id  = $_GET['id'];
		
		$C_admin_Proceso->Cargar_Areas($id);
		
		}break;
	case 'AutoCompletar':{
		MainJson();
		global $db, $userid;
		
		$Letra   = $_REQUEST['term'];
		
								$SQL_Pecar='SELECT 

														idsiq_pecar,
														nombre
											
											FROM 
											
														siq_pecar
											
											WHERE
											
														codigoestado=100
														AND
														nombre LIKE "%'.$Letra.'%" ';
														
											if($Pecar=&$db->Execute($SQL_Pecar)===false){
													echo 'Error al Buscar la Estrucutra del Pecar.....<br>'.$SQL_Pecar;
													die;
												}
							
							$Result_P = array();	
							
							while(!$Pecar->EOF){
								###############################
								$P_Vectt['label']=$Pecar->fields['nombre'];
								$P_Vectt['value']=$Pecar->fields['nombre'];
								$P_Vectt['id_Pecar']=$Pecar->fields['idsiq_pecar'];
								###############################
								array_push($Result_P,$P_Vectt);
								###############################
								$Pecar->MoveNext();
								}	
								
								echo json_encode($Result_P);				
													
		}break;
	case 'EstruturaPecar':{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();
		
		$URL = array();
		$URL[0] = 'admin_Proceso.html.php';
		$URL[1] = 'admin_Proceso.html.php?actionID=Nuevo_Proceso';
		$URL[2] = 'admin_SubProceso.html.php';
		$URL[3] = 'admin_Proceso.html.php?actionID=Nuevo_SubProceso';
		$URL[4] = 'admin_Proceso.html.php?actionID=EstruturaTablero';
		$URL[5] = 'admin_Proceso.html.php?actionID=EstruturaPecar';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de Perspectiva';
		$nombre[1]= 'Perspectiva Nueva';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivel Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 0;
		$Active[2] = 0;
		$Active[3] = 0;
		$Active[4] = 0;
		$Active[5] = 1;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_Proceso,$userid,$db;
		
		$C_admin_Proceso->EstructuraPecar();
		
		
		}break;
	case 'EstruturaTablero':{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();
		
		$URL = array();
		$URL[0] = 'admin_Proceso.html.php';
		$URL[1] = 'admin_Proceso.html.php?actionID=Nuevo_Proceso';
		$URL[2] = 'admin_SubProceso.html.php';
		$URL[3] = 'admin_Proceso.html.php?actionID=Nuevo_SubProceso';
		$URL[4] = 'admin_Proceso.html.php?actionID=EstruturaTablero';
		$URL[5] = 'admin_Proceso.html.php?actionID=EstruturaPecar';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de Perspectiva';
		$nombre[1]= 'Perspectiva Nueva';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivel Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 0;
		$Active[2] = 0;
		$Active[3] = 0;
		$Active[4] = 1;
		$Active[5] = 0;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_Proceso,$userid,$db;
		
		
		$C_admin_Proceso->EsturturaTablero();
		
		
		}break;
	case 'New_SubProceso':{
		MainJson();
		global $db, $userid;
		
		$nom_Sub    = $_GET['nom_Sub'];
		$Proceso_id = $_GET['Proceso_id'];
		
		$SQL_Insert='INSERT INTO siq_procesopecar(nombre,id_padre,userid,entrydate)VALUES("'.$nom_Sub.'","'.$Proceso_id.'","'.$userid.'",NOW())';
		
		if($Insert_SubProceso=&$db->Execute($SQL_Insert)===false){
			$a_vectt['val']			='FALSE';
			$a_vectt['descrip']		='Error al Crear el Sub-Proceso....<br>'.$SQL_Insert;
			echo json_encode($a_vectt);
			exit;
		 }
		
			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error al Crear el Sub-Proceso....<br>'.$SQL_Insert;
			echo json_encode($a_vectt);
			exit;
		
		}break;
	case 'Nuevo_SubProceso':{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();
		
		$URL = array();
		$URL[0] = 'admin_Proceso.html.php';
		$URL[1] = 'admin_Proceso.html.php?actionID=Nuevo_Proceso';
		$URL[2] = 'admin_SubProceso.html.php';
		$URL[3] = 'admin_Proceso.html.php?actionID=Nuevo_SubProceso';
		$URL[4] = 'admin_Proceso.html.php?actionID=EstruturaTablero';
		$URL[5] = 'admin_Proceso.html.php?actionID=EstruturaPecar';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de Perspectiva';
		$nombre[1]= 'Perspectiva Nueva';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivel Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 0;
		$Active[2] = 0;
		$Active[3] = 1;
		$Active[4] = 0;
		$Active[5] = 0;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_Proceso,$userid,$db;
		
		$C_admin_Proceso->Nuevo_SubProceso();
		
		
		}break;
	
	case 'New_Proceso':{
		MainJson();
		global $db, $userid;
		
		$Nombre        = $_GET['Nombre'];
		$id_pecar      = $_GET['id_pecar'];
		
		
		$SQL_Insert='INSERT INTO siq_procesopecar(nombre,id_pecar,userid,entrydate)VALUES("'.$Nombre.'","'.$id_pecar.'","'.$userid.'",NOW())';
		
		if($Insert_Proceso=&$db->Execute($SQL_Insert)===false){
			$a_vectt['val']			='FALSE';
			$a_vectt['descrip']		='Error al Crear el Proceso....<br>'.$SQL_Insert;
			echo json_encode($a_vectt);
			exit;
		 }
		 
		/*##################################
		$Proceso_id=$db->Insert_ID();
		##################################
		if($id_SubProceso==0){
				$id_Proceso = $Proceso_id;
			}else{
				$id_Proceso =$id_SubProceso;
				}
		##################################
		 $C_Datos = explode(',',$Cadena);
		# echo '<pre>';print_r($C_Datos);
		 #################################
		 
		 for($i=1;$i<count($C_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_procesopecar="'.$id_Proceso.'", userid_estado="'.$userid.'", changedate=NOW()
								 WHERE  codigoestado=100  AND  idsiq_area="'.$C_Datos[$i].'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }
			 }
		*/
		 #################################

			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
			echo json_encode($a_vectt);
			exit;
		}break;
	case 'Modificar':{
		MainJson();
		global $db, $userid;
		
		$id        = $_GET['id'];
		$Nombre    = $_GET['Nombre'];
		$id_pecar  = $_GET['id_pecar'];
		
		
		$SQL_Update='UPDATE siq_procesopecar
					 SET    nombre="'.$Nombre.'",id_pecar="'.$id_pecar.'", userid_estado="'.$userid.'", changedate=NOW()
					 WHERE  codigoestado=100  AND  idsiq_procesopecar="'.$id.'"';
					 
					 if($Update_Proceso=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Proceso....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }

			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
			echo json_encode($a_vectt);
			exit;

		}break;
	case 'Eliminar':{
		MainJson();
		global $db, $userid;
		
		$id  =  str_replace('row_','',$_GET['id']);
		
		$SQL_Update='UPDATE siq_procesopecar
					 SET    codigoestado=200, userid_estado="'.$userid.'", changedate=NOW()
					 WHERE  idsiq_procesopecar="'.$id.'"';
					 
					 if($Eliminar_Proceso=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Eliminar el Proceso....<br>'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						 }

			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
			echo json_encode($a_vectt);
			exit;
		}break;
	case 'Editar':{
		MainGeneral();
		JsGenral();
		
		global $C_admin_Proceso,$userid,$db;
		
		$id  =  str_replace('row_','',$_GET['id']);
		
		$C_admin_Proceso->Editar($id);
		
		}break;
	case'Nuevo_Proceso':{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();
		#$Cadena = '-Estructura_documento.html.php::Estructura Documento...::0-Estructura_documento.html.php?actionID=xxxx::prueba::1';
		$URL = array();
		$URL[0] = 'admin_Proceso.html.php';
		$URL[1] = 'admin_Proceso.html.php?actionID=Nuevo_Proceso';
		$URL[2] = 'admin_SubProceso.html.php';
		$URL[3] = 'admin_Proceso.html.php?actionID=Nuevo_SubProceso';
		$URL[4] = 'admin_Proceso.html.php?actionID=EstruturaTablero';
		$URL[5] = 'admin_Proceso.html.php?actionID=EstruturaPecar';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de Perspectiva';
		$nombre[1]= 'Perspectiva Nueva';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivel Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 1;
		$Active[2] = 0;
		$Active[3] = 0;
		$Active[4] = 0;
		$Active[5] = 0;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_Proceso,$userid,$db;
		
		$C_admin_Proceso->Nuevo_Proceso();
		
		}break;
	default:{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();

		$URL = array();
		$URL[0] = 'admin_Proceso.html.php';
		$URL[1] = 'admin_Proceso.html.php?actionID=Nuevo_Proceso';
		$URL[2] = 'admin_SubProceso.html.php';
		$URL[3] = 'admin_Proceso.html.php?actionID=Nuevo_SubProceso';
		$URL[4] = 'admin_Proceso.html.php?actionID=EstruturaTablero';
		$URL[5] = 'admin_Proceso.html.php?actionID=EstruturaPecar';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de Perspectiva';
		$nombre[1]= 'Perspectiva Nueva';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivel Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 1;
		$Active[1] = 0;
		$Active[2] = 0;
		$Active[3] = 0;
		$Active[4] = 0;
		$Active[5] = 0;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_Proceso,$userid,$db;
		#include('Estructura_documento.class.php');  $C_Estructura_documento = new Estructura_documento();
				
		$C_admin_Proceso->Principal();
		
	}break;
	}
function MainGeneral(){
	
		
		global $C_admin_Proceso,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		
		include('admin_Proceso.class.php');  $C_admin_Proceso = new admin_Proceso();
		
		
		
		$db=writeHeader("Gestión de Procesos",true);
		
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
#sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
</style>  
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
<script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script> 
  <script type="text/javascript">
  
   
  $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });
	/******************************/
	
	 
	/******************************/
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {  
         var sql;
       
			sql="SELECT  pro.idsiq_procesopecar,  pro.nombre, p.nombre as Nom_pecar";
		    sql+=' FROM  siq_procesopecar  as pro INNER JOIN siq_pecar as p ON pro.id_pecar=p.idsiq_pecar AND pro.codigoestado=100 AND p.codigoestado=100';   
		    
	

            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?table=siq_procesopecar&sql="+sql+"&wh=pro.codigoestado&join=true",
                "aoColumns": [
				
                { "sTitle": "Nombre de la Prespectivas" },
                { "sTitle": "Nombre Estrutura PECAR" },
				
                
                ]
            });
            /* Click event handler
			
            /* Click event handler */
           
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
					$("#ToolTables_example_3").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
					$("#ToolTables_example_3").removeClass('DTTT_disabled');
                }
             } );
            
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {editar_Proceso();}               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {eliminar_Proceso();}                
            } );
			$('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {Estructurar_Proceso();}                
            } );
           
      } );
	  
	  
	  
	function editar_Proceso(){
		
		 if(aSelected.length==1){
          var id = aSelected[0];
            
          }else{
             return false;
          }
		$.ajax({
               type: 'GET',
               url: 'admin_Proceso.html.php',
			  // dataType: 'json',
               data:({actionID: 'Editar',id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
                 		
						$('#container').html(data);		
								
               } 
            });
		}
	function eliminar_Proceso(){
		
		if(confirm('Seguro Desea Eliminar la Prespectiva Selecionada...?')){
				
					if(aSelected.length==1){
					  var id = aSelected[0];
						
					  }else{
						 return false;
					  }
						$.ajax({
							   type: 'GET',
							   url: 'admin_Proceso.html.php',
							   dataType: 'json',
							   data:({actionID: 'Eliminar',id:id}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}else{
														alert('Se ha Eliminado Correctamente...');
														location.href='admin_Proceso.html.php';
													}
							   } 
						});
				
			}
		
		}
	
	function Modificar_Proceso(){
		
		var id      = $('#id_proceso').val();
		var Nombre  = $('#nom_proceso').val();
		var id_pecar = $('#id_pecar').val();
		
		if(!$.trim(Nombre)){
				alert('Ingrese un Nombre para la Prespectiva...!');
				return false;
			}
		
			$.ajax({
               type: 'GET',
               url: 'admin_Proceso.html.php',
			   dataType: 'json',
               data:({actionID: 'Modificar',id:id,Nombre:Nombre,id_pecar:id_pecar}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
										alert('Se ha Modificado Correctamente...');
										location.href='admin_Proceso.html.php';
									}						
               } 
            });
		
		}	
		
	function New_Estrutura(){
		
		   var list = $("#sortable2").sortable('toArray');
		 	//alert(list)
		   $('#Cadena_list').val(list);
		 
		    var Cadena = $('#Cadena_list').val();
		 
			var Nombre  = $('#nom_proceso').val();
			var id_pecar = $('#id_pecar').val();
			var id_SubProceso  =0;
			
			if(!$.trim(Nombre)){
					alert('Ingrese un Nombre para la Area...!');
					return false;
				}
				
			if(id_pecar=='-1' || id_pecar==-1){
					alert('Eliga alguna Estrutura del PECAR...!');
					return false;
				}
					
			if($('#SubProceso').is(':checked')){
				
					var id_SubProceso  = $('#id_SubProceso').val();
					if(id_SubProceso=='-1' || id_SubProceso==-1){
							alert('Eliga un Nivel...!');
							return false;
						}
				}
					
			if(!$.trim(Cadena)){
					alert('Agrege el o las Area(s)..');
					return false;
				}	
				
			
		}	
		
	function Ver_Area(){
			
			if($('#SubProceso').is(':checked')){
				$('#TR_Areas').css('visibility','visible');
				}else{
						$('#TR_Areas').css('visibility','collapse');
					}
			
	}		  
	function New_SubProceso(){
				
			var nom_Sub     = $('#nom_Sub').val();	
			var Proceso_id  = $('#Proceso_id').val();
				
				
				$.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				   dataType: 'json',
				   data:({actionID: 'New_SubProceso',nom_Sub:nom_Sub,
				   								     Proceso_id:Proceso_id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
											alert('El Nivel Se Ha Creado Correctamente...');
											location.href='admin_Proceso.html.php?actionID=GestionSubProceso';
										}						
				   } 
				});	
		}
		
	
function New_Proceso(){
	
	        var Nombre  = $('#nom_proceso').val();
			var id_pecar = $('#id_pecar').val();
			
			
			if(!$.trim(Nombre)){
					alert('Ingrese un Nombre para la Area...!');
					return false;
				}
				
			if(id_pecar=='-1' || id_pecar==-1){
					alert('Eliga alguna Estrutura del PECAR...!');
					return false;
				}
				
		   $.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				   dataType: 'json',
				   data:({actionID: 'New_Proceso',Nombre:Nombre,
				   								  id_pecar:id_pecar}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
											alert('La Prespectiva Se Ha Creado Correctamente...');
											location.href='admin_Proceso.html.php';
										}						
				   } 
				});	
	}
	
	function autocomplet(){
			 
				$('#Pecar').autocomplete({
					
					source: 'admin_Proceso.html.php?actionID=AutoCompletar',
					minLength: 2,
					select: function( event, ui ) {
						$('#Pecar_id').val(ui.item.id_Pecar);
						Cargar_Areas(ui.item.id_Pecar);
					}                
				});
	 }	
	
	function formReset(){
		$('#Pecar').val('');
		$('#Pecar_id').val('');
		$('#Div_carga').html('');
		}
		
	function Cargar_Areas(id){
		
			$.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				   //dataType: 'json',
				   data:({actionID: 'CargarAreas',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								$('#Div_carga').html(data);						
				   } 
				});	
				
		
		}
	function Save_AreasPecar(){
		
		   var list = $("#sortable2").sortable('toArray');
		 	//alert(list)
		   $('#Cadena_P').val(list);
		 
		    var Cadena_P = $('#Cadena_P').val();
			
			var Libre =$("#sortable1").sortable('toArray');
			$('#CadenaLibre').val(Libre);
			
			var CadenaLibre = $('#CadenaLibre').val();
			
			var Pecar_id = $('#Pecar_id').val();
			
			$.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				   dataType: 'json',
				   data:({actionID: 'Save_AreasPecar',Cadena_P:Cadena_P,Pecar_id:Pecar_id,CadenaLibre:CadenaLibre}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
										alert('Se Han Relacionado La Estructura Con Las Areas Correctamente...');
											location.href='admin_Proceso.html.php?actionID=EstruturaPecar';
										}					
				   } 
				});	
		}	
		
	function Estructurar_Proceso(){
			if(aSelected.length==1){
			  var id = aSelected[0];
				
			  }else{
				 return false;
			  }
			  
			  $.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				  // dataType: 'json',
				   data:({actionID: 'EstructurarProceso',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							
							$('#container').html(data);		
									
				   } 
				});
		}	
		
	function Save_AreasPro(){
		
			var list = $("#sortable2").sortable('toArray');
		 	//alert(list)
		   $('#Cadena_Pro').val(list);
		 
		    var Cadena_Pro = $('#Cadena_Pro').val();
			
			var Libre =$("#sortable1").sortable('toArray');
			$('#CadenaLibre').val(Libre);
			
			var CadenaLibre = $('#CadenaLibre').val();
			
			var Proceso_id = $('#Proceso_id').val();
			
			$.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				   dataType: 'json',
				   data:({actionID: 'Save_AreasPro',Cadena_Pro:Cadena_Pro,Proceso_id:Proceso_id,CadenaLibre:CadenaLibre}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
										alert('Se Han Relacionado La Estructura Con Las Areas Correctamente...');
											location.href='admin_Proceso.html.php';
										}					
				   } 
				});	
		
		}
	
	
	function VerFacultad(){
			$('#label').css('display','block');
			$('#select').css('display','block');
		}
	function VerPrograma(id){
			$.ajax({
				   type: 'GET',
				   url: 'admin_Proceso.html.php',
				  // dataType: 'json',
				   data:({actionID: 'Programa',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							$('#labelPrograma').css('display','block');
							$('#TdPrograma').css('display','block');
							$('#TdPrograma').html(data);		
									
				   } 
				});
		}	
	
	function Ocultar(){
		    $('#label').css('display','none');
			$('#select').css('display','none');
			$('#labelPrograma').css('display','none');
			$('#TdPrograma').css('display','none');
		}	
	
	function VerTablero(){
			if(!$('#Institucional').is(':checked') && !$('#Programa').is(':checked')){
					/*********************************************************************************/
					
						alert('Por Favor Elige una de las Opciones...!');
						return false;
					
					/*********************************************************************************/
				}
				
				
			if($('#Institucional').is(':checked')){
					/*********************************/
						var dato = 1;
						var Programa_id = 0;
						popUp_3('Estructura_Tablero.html.php?actionID=TableroDinamico&dato='+dato+'&Programa_id='+Programa_id,'1500','800');
					
					/*********************************/
				}	
			
			if($('#Programa').is(':checked')){
					/*********************************/
						var dato = 3;
						var Faculta_id = $('#Faculta_id').val();
						var Programa_id = $('#Programa_id').val();
						
						if(Faculta_id=='-1' || Faculta_id==-1){
								alert('Error Selecione una Facultad...!');
								return false;
							}
							
						if(Programa_id=='-1' || Programa_id==-1){
								alert('Error Selecione un Programa...!');
								return false;
							}	
						
						popUp_3('Estructura_Tablero.html.php?actionID=TableroDinamico&dato='+dato+'&Programa_id='+Programa_id,'1500','800');
					
					/*********************************/
				}	
		}	
        </script>
<?PHP 
}
?>