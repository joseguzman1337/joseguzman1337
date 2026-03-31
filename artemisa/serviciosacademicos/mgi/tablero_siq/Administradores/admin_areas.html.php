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
	case 'New_area':{
		MainJson();
		global $db, $userid;
		
		$Nombre  = $_GET['Nombre'];
		$Radio   = $_GET['Radio'];
		
		$SQL_Insert='INSERT INTO siq_area(nombre,userid,entrydate,disponible)VALUES("'.$Nombre.'","'.$userid.'",NOW(),"'.$Radio.'")';
		
		if($Update_Area=&$db->Execute($SQL_Insert)===false){
			$a_vectt['val']			='FALSE';
			$a_vectt['descrip']		='Error al Crear el Area....<br>'.$SQL_Insert;
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
		
		$id      = $_GET['id'];
		$Nombre  = $_GET['Nombre'];
		$Radio   = $_GET['Radio'];
		
		
		$SQL_Update='UPDATE siq_area
					 SET    nombre="'.$Nombre.'", userid_estado="'.$userid.'", changedate=NOW(), disponible="'.$Radio.'"
					 WHERE  codigoestado=100  AND  idsiq_area="'.$id.'"';
					 
					 if($Update_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar el Nombre del Area....<br>'.$SQL_Update;
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
		
		$area_id  =  str_replace('row_','',$_GET['area_id']);
		
		$SQL_Update='UPDATE siq_area
					 SET    codigoestado=200, userid_estado="'.$userid.'", changedate=NOW()
					 WHERE  idsiq_area="'.$area_id.'"';
					 
					 if($Eliminar_Area=&$db->Execute($SQL_Update)===false){
						    $a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Eliminar el Nombre del Area....<br>'.$SQL_Update;
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
		
		global $C_admin_areas,$userid,$db;
		
		$area_id  =  str_replace('row_','',$_GET['area_id']);
		
		$C_admin_areas->Editar($area_id);
		
		}break;
	case'Nueava_Area':{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();
		#$Cadena = '-Estructura_documento.html.php::Estructura Documento...::0-Estructura_documento.html.php?actionID=xxxx::prueba::1';
		$URL = array();
		$URL[0] = 'admin_areas.html.php';
		$URL[1] = 'admin_areas.html.php?actionID=Nueava_Area';
		
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de areas';
		$nombre[1]= 'Nueva Area...';
		
		$Active = array();
		$Active[0] = 0;
		$Active[1] = 1;
		
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_areas,$userid,$db;
		
		$C_admin_areas->Nueva_area();
		
		}break;
	default:{
		include('../../Menu.class.php');  #$C_Menu_Global = new Menu_Global();
		MainGeneral();
		JsGenral();

		$URL = array();
		$URL[0] = 'admin_areas.html.php';
		$URL[1] = 'admin_areas.html.php?actionID=Nueava_Area';
		$nombre = array();
		$nombre[0]= 'Gestionar Definici&oacute;n de areas';
		$nombre[1]= 'Nueva Area...';
		$Active = array();
		$Active[0] = 1;
		$Active[1] = 0;
		Menu_Global::writeMenu($URL,$nombre,$Active);
		
		global $C_admin_areas,$userid,$db;
		#include('Estructura_documento.class.php');  $C_Estructura_documento = new Estructura_documento();
				
		$C_admin_areas->Principal();
		
	}break;
	}
function MainGeneral(){
	
		
		global $C_admin_areas,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		
		include('admin_areas.class.php');  $C_admin_areas = new admin_areas();
		
		
		
		$db=writeHeader("Gestión de Areas",true);
		
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
  
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
   
  <script type="text/javascript">
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {  
         var sql;
       
			sql="SELECT   a.idsiq_area, a.nombre, date(a.changedate) as fecha, u.apellidos, u.nombres";
		    sql+=' FROM siq_area as a INNER JOIN usuario as u ON a.userid=u.idusuario and a.codigoestado=100 and u.codigoestadousuario=100';   
		    //sql+=' WHERE a.codigoestado=100 and u.codigoestadousuario=100';
        // alert(sql);
	

            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?table=siq_area&sql="+sql+"&wh=a.codigoestado&join=true",
                "aoColumns": [
				
                { "sTitle": "Nombre del Area" },
                { "sTitle": "Fecha Última Modificación" },
				{ "sTitle": "Nombre Usuario" , "bVisible":false },
                { "sTitle": "xxxxxxxxxxxx" , "bVisible":false }
                
                ]
            });
            /* Click event handler
			{ "fnRender": function ( oObj ) {
					//console.log(oObj);
					   return oObj.aData[3] + ' ' + oObj.aData[2] + '';     
				  },
				"aTargets": [ 2 ]}, */
            /* Click event handler */
           
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }
             } );
            
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {editar_area();}               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {eliminar_area();}                
            } );
           
      } );
	function editar_area(){
		
		 if(aSelected.length==1){
          var id = aSelected[0];
            
          }else{
             return false;
          }
		$.ajax({
               type: 'GET',
               url: 'admin_areas.html.php',
			  // dataType: 'json',
               data:({actionID: 'Editar',area_id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
                 		/*if(data.val=='FALSE'){
								alert(data.descrip);
								return false;
							}else{
								alert(data.descrip);
								location.href='Carga_Documento.html.php';
								}*/
						$('#container').html(data);		
								
               } 
            });
		}
	function eliminar_area(){
		
		if(confirm('Seguro Desea Eliminar el Area Selecionada...?')){
				
					if(aSelected.length==1){
					  var id = aSelected[0];
						
					  }else{
						 return false;
					  }
						$.ajax({
							   type: 'GET',
							   url: 'admin_areas.html.php',
							   dataType: 'json',
							   data:({actionID: 'Eliminar',area_id:id}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}else{
														alert('Se ha Eliminado el Area Correctamente...');
														location.href='admin_areas.html.php';
													}
							   } 
						});
				
			}
		
		}
	
	function Modificar_Area(){
		
		var id      = $('#id_area').val();
		var Nombre  = $('#nom_area').val();
		if($('#si').is(':checked')){
				var Radio = 0;
			}else{
					var Radio = 1;
				}
		
		if(!$.trim(Nombre)){
				alert('Ingrese un Nombre para la Area...!');
				return false;
			}
		
			$.ajax({
               type: 'GET',
               url: 'admin_areas.html.php',
			   dataType: 'json',
               data:({actionID: 'Modificar',id:id,Nombre:Nombre,Radio:Radio}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
               success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
										alert('Se ha Modificado el Nombre del Area Correctamente...');
										location.href='admin_areas.html.php';
									}						
               } 
            });
		
		}	
		
	function New_Area(){
			var Nombre  = $('#nom_area').val();
		
			if(!$.trim(Nombre)){
					alert('Ingrese un Nombre para la Area...!');
					return false;
				}
			if($('#si').is(':checked')){
				var Radio = 0;
			}else{
					var Radio = 1;
				}	
				
			$.ajax({
				   type: 'GET',
				   url: 'admin_areas.html.php',
				   dataType: 'json',
				   data:({actionID: 'New_area',Nombre:Nombre,Radio:Radio}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
											alert('Se ha Creado el Area Correctamente...');
											location.href='admin_areas.html.php';
										}						
				   } 
				});	
		}		  
        </script>
<?PHP 
}
?>