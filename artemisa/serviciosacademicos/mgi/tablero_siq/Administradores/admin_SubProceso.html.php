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
	case 'Save_AreasSubPro':{
		MainJson();
		global $db, $userid;
		
		$Cadena_SubPro   = $_GET['Cadena_SubPro'];
		$SubProceso_id   = $_GET['SubProceso_id'];
	    $CadenaLibre    = $_GET['CadenaLibre'];
		
		
		##################################
		 $C_Datos = explode(',',$Cadena_SubPro);
		 #echo '<pre>';print_r($C_Datos);
		 #################################
		 
		 for($i=1;$i<count($C_Datos);$i++){
			 		
					$SQL_Update='UPDATE siq_area
								 SET    id_procesopecar="'.$SubProceso_id.'", userid_estado="'.$userid.'", changedate=NOW()
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
	case 'EstructurarSubProceso':{
		
		MainGeneral();
		JsGenral();
		
		global $C_admin_SubProceso,$userid,$db;
		
		$id  =  str_replace('row_','',$_GET['id']);
		
		$C_admin_SubProceso->EstructuraSubProceso($id);
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
	case 'Modificar':{
		MainJson();
		global $db, $userid;
		
		$id        = $_GET['id'];
		$Nombre    = $_GET['Nombre'];
		$Proceso_id  = $_GET['Proceso_id'];
		
		
		$SQL_Update='UPDATE siq_procesopecar
					 SET    nombre="'.$Nombre.'",id_padre="'.$Proceso_id.'", userid_estado="'.$userid.'", changedate=NOW()
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
	case 'Editar':{
		MainGeneral();
		JsGenral();
		
		global $C_admin_SubProceso,$userid,$db;
		
		$id  =  str_replace('row_','',$_GET['id']);
		
		$C_admin_SubProceso->Editar($id);
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
		$nombre[1]= 'Perspectiva Nuevo';
		$nombre[2]= 'Gestionar Definici&oacute;n de Niveles';
		$nombre[3]= 'Nivele Nuevo';
		$nombre[4]= 'Estructurar Tablero';
		$nombre[5]= 'Estructura PECAR';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 0;
		$Active[2] = 1;
		$Active[3] = 0;
		$Active[4] = 0;
		$Active[5] = 0;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_SubProceso,$userid,$db;
		#include('Estructura_documento.class.php');  $C_Estructura_documento = new Estructura_documento();
				
		$C_admin_SubProceso->Principal();
		
	}break;
}
function MainGeneral(){
	
		
		global $C_admin_SubProceso,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		
		include('admin_SubProceso.class.php');  $C_admin_SubProceso = new admin_SubProceso();
		
		
		
		$db=writeHeader("Gestión de SubProcesos",true);
		
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
   
  <script type="text/javascript">
  
   
  $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });
	/******************************/
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {  
         var sql;
       
			sql="SELECT  subPro.idsiq_procesopecar,subPro.nombre,pro.nombre as nom_proceso, p.nombre as nom_pecar";
		    sql+=' FROM siq_procesopecar as subPro INNER JOIN siq_procesopecar as pro ON subPro.id_padre=pro.idsiq_procesopecar INNER JOIN siq_pecar as p ON pro.id_pecar=p.idsiq_pecar AND subPro.codigoestado=100 AND pro.codigoestado=100 AND p.codigoestado=100';   
		      
		    
	

            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?table=siq_procesopecar&sql="+sql+"&wh=subPro.codigoestado&join=true",
                "aoColumns": [
				
                { "sTitle": "Nombre del Nivel" },
                { "sTitle": "Nombre de la Prespectiva" },
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
                {editar_SubProceso();}               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {eliminar_SubProceso();}                
            } );
			 $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {Estructurar_SubProceso();}                
            } );
           
      } );
	  
	  
	  
	function editar_SubProceso(){
		
		 if(aSelected.length==1){
          var id = aSelected[0];
            
          }else{
             return false;
          }
		$.ajax({
               type: 'GET',
               url: 'admin_SubProceso.html.php',
			  // dataType: 'json',
               data:({actionID: 'Editar',id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
                 		
						$('#container').html(data);		
								
               } 
            });
		}
	function eliminar_SubProceso(){
		
		if(confirm('Seguro Desea Eliminar el Nivel Selecionado...?')){
				
					if(aSelected.length==1){
					  var id = aSelected[0];
						
					  }else{
						 return false;
					  }
						$.ajax({
							   type: 'GET',
							   url: 'admin_SubProceso.html.php',
							   dataType: 'json',
							   data:({actionID: 'Eliminar',id:id}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}else{
														alert('Se ha Eliminado  Correctamente...');
														location.href='admin_SubProceso.html.php';
													}
							   } 
						});
				
			}
		
		}
	
	function Edit_SubProceso(){
		
		var id         = $('#id_SubPro').val();
		var Nombre     = $('#nom_Sub').val();
		var Proceso_id = $('#Proceso_id').val();
		
		if(!$.trim(Nombre)){
				alert('Ingrese un Nombre para El Nivel...!');
				return false;
			}
		
			$.ajax({
               type: 'GET',
               url: 'admin_SubProceso.html.php',
			   dataType: 'json',
               data:({actionID: 'Modificar',id:id,Nombre:Nombre,Proceso_id:Proceso_id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
										alert('Se ha Modificado el Nivel Correctamente...');
										location.href='admin_SubProceso.html.php';
									}						
               } 
            });
		
		}
	function Estructurar_SubProceso(){
		
			if(aSelected.length==1){
			  var id = aSelected[0];
				
			  }else{
				 return false;
			  }
			  
			  $.ajax({
				   type: 'GET',
				   url: 'admin_SubProceso.html.php',
				  // dataType: 'json',
				   data:({actionID: 'EstructurarSubProceso',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							
							$('#container').html(data);		
									
				   } 
				});
		}	
		
	function Save_AreasSubPro(){
		
			var list = $("#sortable2").sortable('toArray');
		 	//alert(list)
		   $('#Cadena_SubPro').val(list);
		 
		    var Cadena_SubPro = $('#Cadena_SubPro').val();
			
			var Libre =$("#sortable1").sortable('toArray');
			$('#CadenaLibre').val(Libre);
			
			var CadenaLibre = $('#CadenaLibre').val();
			
			var SubProceso_id = $('#SubProceso_id').val();
			
			$.ajax({
				   type: 'GET',
				   url: 'admin_SubProceso.html.php',
				   dataType: 'json',
				   data:({actionID: 'Save_AreasSubPro',Cadena_SubPro:Cadena_SubPro,SubProceso_id:SubProceso_id,CadenaLibre:CadenaLibre}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
										alert('Se Han Relacionado La Estructura Con Las Areas Correctamente...');
											location.href='admin_SubProceso.html.php';
										}					
				   } 
				});	
		
		}
        </script>
<?PHP 
}
?>	
	
