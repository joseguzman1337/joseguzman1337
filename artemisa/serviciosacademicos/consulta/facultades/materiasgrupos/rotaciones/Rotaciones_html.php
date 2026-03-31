<?PHP 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	
     case 'Rotacionesubicacion':{
            global $userid,$db,$C_Rotaciones;
            MainGeneral();
            $C_Rotaciones->UbicacionConvenios($_POST["idconvenio"]);
        }break;
	case 'VwASignacionRotacionGrupo':{
		global $userid,$db,$C_Rotaciones;
		MainGeneral();
        ///validacion de datos
                
        $array=array();
        if((settype($_GET['codigoperiodo'], 'integer'))&&(settype($_GET['idgrupo'], 'integer'))){
            $array["codigoperiodo"]=$_GET['codigoperiodo'];
            $array["idgrupo"]=$_GET['idgrupo'];
            if(isset($_POST["sel_subgrupo"])&&($_POST["sel_subgrupo"]!="null")){
                 $array["idsubgrupo"]=$_POST['sel_subgrupo'];
                            
            }            
        }else{
            $array[]=0;
            $array[]=0;
        }
        
        $C_Rotaciones->VwASignacionRotacionGrupo($array);
		}break;
	case 'VwFormularioDetalleRotacion':{
		global $userid,$db,$C_Rotaciones;
		 MainGeneral();
        $C_Rotaciones->VwFormularioDetalleRotacion();
		}break;
    case 'VwBusquedaRotacionesEstudiantes':{
		global $userid,$db,$C_Rotaciones;
		 MainGeneral();
        $C_Rotaciones->VwBusquedaRotacionesEstudiantes();
		}break;    
    case 'VwBusquedaRotacionesLugares':{
		global $userid,$db,$C_Rotaciones;
		 MainGeneral();
        $C_Rotaciones->VwBusquedaRotacionesLugares();
		}break;
    case 'guardarRotaciones':{
		global $userid,$db,$C_Rotaciones;
        
		 MainGeneral();
         $cont=0;
         $contok=0;
         for($i=0;$i<$_POST["total_rows"];$i++){
            if(isset($_POST["checkestudiante_".$i])&&($_POST["checkestudiante_".$i]=="on")){
                
                 $cont++;
                 $arraydatos=array();
                  if(isset($_POST["idsubgrupo_".$i])&&($_POST["idsubgrupo_".$i])){
                    $arraydatos["idsubgrupo"]=$_POST["idsubgrupo_".$i];  
                  }
                  
                  
                  $arraydatos["idgrupo"]=$_POST["idgrupo_".$i];
                  $arraydatos["codmateria"]=$_POST["codmateria_".$i];
                  $arraydatos["idconvenio"]=$_POST["convenio_".$i];
                  $arraydatos["idubicacion"]=$_POST["idubicacion_".$i];
                  $arraydatos["idservicio"]=$_POST["servicio_".$i];
                  $arraydatos["fechaingreso"]=$_POST["FechaIngreso_".$i];
                  $arraydatos["fechaegreso"]=$_POST["FechaEgreso_".$i];
                  $arraydatos["usuariocreacion"]=$userid;
                  $arraydatos["idedorotacion"]=$_POST["estadorotacion_".$i];
                  $arraydatos["codperiodo"]=$_POST["codperiodo"];
                  $arraydatos["codcarrera"]=$_POST["codcarrera_".$i];
                  $arraydatos["diasrotacion"]=$_POST["TotDias_".$i];
                  $arraydatos["totalalumnos"]=$_POST["total_alumnos"];
                  
                  
                  /////////////////////modificar cantidad de cupos////////////////////
                  
                  $sqlcupos = "select NumeroCupos, NumeroCuposAsignados from UbicacionInstitucionCupos  where IdUbicacionInstitucion = '".$_POST["idubicacion_".$i]."'";
                  //echo  $sqlcupos;
                  $valorcupos =  &$db->GetRow($sqlcupos);
                  if(isset($valorcupos)&&($valorcupos!=0)){
                     if(intval($arraydatos["totalalumnos"]) >=intval($valorcupos['NumeroCupos'])&&((intval($arraydatos["totalalumnos"]+$valorcupos['NumeroCuposAsignados'])>intval($valorcupos['NumeroCupos']))))
                     {
                         $descrip= 'sin cupos disponibles para la cantidad de alumnos en esta agrupacion';
                         $respuesta['val']='FALSE';
                         echo "<script>alert('".$descrip."')</script>";
                         $respuesta['detalles'] = 'sin cupos'.$sqlcupos;
                     }else
                     {
                          
                          $datoscoincidencia=$C_Rotaciones->BuscarAlumnosValidos($arraydatos);
                          $arraydatos["cant_fechascoincdnt"]=$datoscoincidencia["encontrados"];
                          $arraydatos["regidestudiantes"]=$datoscoincidencia["idestudiantes"];
                          $respuesta=$C_Rotaciones->GuardarRotacionesMasivasEstudiante($arraydatos);
                          $cupoasgnado =  $respuesta['total_add']+$valorcupos['NumeroCuposAsignados'];
                          $cupoasgnado;
                          $sqlagregarcupos = "UPDATE UbicacionInstitucionCupos SET NumeroCuposAsignados = '".$cupoasgnado."', UsuarioUltimaModificacion = '".$userid."', FechaUltimaModificacion = NOW() WHERE IdUbicacionInstitucion = '".$arraydatos["idubicacion"]."'"; 
                          $agregar=$db->Execute($sqlagregarcupos);
                          $descrip = 'La rotaciones fue agregadas';
                     }
                  }
                  if($respuesta['val']!='FALSE'){
                    $contok++;
                    
                  }
                  
            }
            
            
         }
         echo "<script>alert('".$respuesta['detalles']."')</script>";
         echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=Rotaciones_html.php?actionID=VwASignacionRotacionGrupo&idgrupo=".$_POST["codgrupo"]."&codigoperiodo=".$_POST["codperiodo"]."'>";         
         
         
		}break;    
	default:{
			
			global $userid,$db,$C_Rotaciones;
			
			MainGeneral();
           
			//JsGeneral();
			
			$C_Rotaciones->Principal($_SESSION['codigofacultad']);
			
		}break;
}
function MainGeneral(){
		
		
	
		global $userid,$db,$C_Rotaciones;
		
	    include_once ('Rotaciones_Class.php'); $C_Rotaciones = new Rotaciones();
		
		include_once("../../../../ReportesAuditoria/templates/mainjson.php");
        //include("../ReportesAuditoria/templates/MenuReportes.php");
		
		 
			
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	
	}	
	
function MainJson(){
	global $userid,$db;
		
		
		include_once("../../../../ReportesAuditoria/templates/mainjson.php");
		
		
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
            border: 0px;
			
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
					  url: 'Rotaciones_html.php',
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
						
						source:"Rotaciones_html.php?actionID=autoCompleModalidad",
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
						
						source: "Rotaciones_html.php?actionID=autoCompleCarrera&id_Movilidad="+id_Movilidad,
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
					  url: 'Rotaciones_html.php',
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
					  url: 'Rotaciones_html.php',
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
		
			location.href='Rotaciones_html.php?actionID=Excel&id_Programa'+id_Programa+'&PlanesActivos='+PlanesActivos;
		
		}
   
     
        
        
	</script>
    <title>Distribucion de Rotaciones</title>
    </head>
    
    <?PHP
	}
?>