<?PHP 

switch($_REQUEST['actionID']){
	case 'Ventana':{
		define(AJAX,'FALSE');

		MainGeneral();
		#JsGenral();
		
		global $C_VisualizarGeneral,$userid,$db;
		
		
		$Estructura_id  = $_REQUEST['Estructura_id'];
		$Factor_id      = $_REQUEST['Factor_id'];
		$Indicador_id   = $_REQUEST['Indicador_id'];
		
		$C_VisualizarGeneral->DetallesIndicador($Estructura_id,$Factor_id,$Indicador_id);
		}break;
	case 'CargarIndicadores':{
		define(AJAX,'FALSE');

		MainGeneral();
		#JsGenral();
		
		global $C_VisualizarGeneral,$userid,$db;
		
		$Aspecto_id    = $_GET['Aspecto_id'];
		$Estructura_id = $_GET['Estructura_id'];
		$Factor_id     = $_GET['Factor_id'];
		
		$C_VisualizarGeneral->IndicadoresList($Aspecto_id,$Estructura_id,$Factor_id);
		}break;
	case 'CargarSub':{
		define(AJAX,'FALSE');

		MainGeneral();
		#JsGenral();
		
		global $C_VisualizarGeneral,$userid,$db;
		
		$Caract_id     = $_GET['Caract_id'];
		$Factor_id     = $_GET['Factor_id'];
		$Estructura_id = $_GET['Estructura_id'];
		$Doc_id        = $_GET['Doc_id'];
		
		$C_VisualizarGeneral->ListaAspecto($Caract_id,$Factor_id,$Estructura_id,$Doc_id);
		}break;
	case 'Cargar':{
		define(AJAX,'FALSE');

		MainGeneral();
		#JsGenral();
		
		global $C_VisualizarGeneral,$userid,$db;
		
		$C_VisualizarGeneral->ListaCaracteristicas($_GET['id'],$_GET['Estructura_id'],$_GET['Doc_id']);
		}break;
	case 'CargarRepositorio':{
		define(AJAX,'FALSE');

		MainGeneral();
		#JsGenral();	
                //setlocale(LC_ALL, 'es_ES.UTF8'); 
                
                $rutaRepositorio = '/var/ftp/pub/REPOSITORIO DOCUMENTOS INSTITUCIONALES/';
		
                //devuelve solo directorios
                $files = glob($_REQUEST["ruta"],GLOB_ONLYDIR);
                $directorio = true;
                $ruta = str_replace("*","",$_REQUEST["ruta"]);
                //var_dump($_SERVER["DOCUMENT_ROOT"]);
                //echo "<pre>".realpath($_REQUEST["ruta"]);
                //var_dump(realpath($_REQUEST["ruta"]));
                //var_dump($_SERVER);
                //var_dump(dirname(__FILE__));
                //var_dump($_SERVER["SCRIPT_FILENAME"]);
				
				
				//
				$id		= $_REQUEST['id'];
				
			   $Ruta_Dinamica = $_REQUEST["ruta"];
				
				$R_Dinamic = str_replace("*","",$Ruta_Dinamica);
				
				#echo '<br>New_Rut->'.$R_Dinamic;
				
				/*$carp_dinamic = explode("/", $R_Dinamic);
				
				#echo '<pre>';print_r($carp_dinamic);
				
				echo '<br>Num->'.$num = count($carp_dinamic);
				
				$num = $num-2;
				
				$New_Ruta = '';
				
				for($k=1;$k<=$num;$k++){
						echo '<br>carp_dinamic[$k]->'.$carp_dinamic[$k];	
						$New_Ruta = $New_ruta.'/'.$carp_dinamic[$k];
					}
					
				echo '<br>$New_Ruta->'.$New_Ruta;*/	
                ?>
                
                <div id="Descrip">
            	<strong style="font-size:24px; cursor:pointer"><?php echo strtoupper("DOCUMENTOS QUE ORIENTAN LA ACTIVIDAD INSTITUCIONAL"); ?></strong>
                <br />
                <?php if(strcmp ($rutaRepositorio.'*',$_REQUEST["ruta"])!==0 && $_REQUEST["directorio"]==true){ 
                    $rutaDir = str_replace($rutaRepositorio,"",$ruta); 
                    $carpetas = explode("/", $rutaDir);
                    for ($i = 0; $i < count($carpetas); $i++) { 
                        if($carpetas[$i]!="") {
							
						$pos = strpos($Ruta_Dinamica,$carpetas[$i].'/'.$carpetas[$i+1]);
                                                if($pos!==false){
                                                    $New_Ruta	= substr($Ruta_Dinamica, 0, $pos)."*";
                                                } else {
                                                    $New_Ruta	= str_replace($carpetas[$i].'/',"",$Ruta_Dinamica);
                                                }	
							
                        ?>
                        <strong <?php if($i==0){?> style="font-size:18px; cursor:pointer" onclick="Volver('<?PHP echo $New_Ruta?>',false);" <?php } else {?>  style="font-size:16px; cursor:pointer" onclick="Volver('<?PHP echo $New_Ruta?>',true);"  <?php } ?>><?php echo strtoupper(iconv("UTF-8","CP852",$carpetas[$i])); ?></strong><br />
                    <?php } }                 
                 } ?>
            </div>
            <br />
            <fieldset  style="border:#88AB0C solid 1px">
                <?php if(count($files)>0) { ?>
                    <legend>Documentos</legend>
              <?php } else { $directorio = false;
                  // me trae todos los archivos PDF
                  $files = glob($_REQUEST["ruta"].".pdf"); ?>
                    <legend>Documentos</legend>
              <?php } ?>
			<?php $j = 0;
                    foreach($files as $file)
                    {      ?>
                        <ul id="sortable_Aspecto" class="connectedSortable">
                        <li class="ui-state-default" id="Sombra_id_<?PHP echo $j?>" onmouseover="Sombralight(<?PHP echo $j?>)" onmouseout="SinSombra(<?PHP echo $j?>)" <?php if($directorio) { ?> onclick="CargarRepositorio('<?php echo $file."/*"; ?>',true)" 
                                <?php } else { ?> onclick="DescargarDocRepositorio('<?php echo "ftp://".$_SERVER["SERVER_NAME"].rawurldecode(str_replace("/var/ftp","",$file)); ?>')"<?php } ?> style="cursor:pointer"><?php if($directory){ echo str_replace($ruta,"",$file);} else { $nombre = str_replace($ruta,"",$file); echo str_replace(".pdf","",$nombre);} ?>
                            <?php if(!$directorio) { ?>                             
                                 <img src="../../images/Adobe_PDF_Reader.png" width="15" />
                             <?php   } ?>
                        </li>
                        </ul>  
                <?php $j = $j + 1; }
                    if($directorio) { 
                        // me trae todos los archivos PDF
                        $files = glob($_REQUEST["ruta"].".pdf"); 
                        foreach($files as $file)
                        {      ?>
                        <ul id="sortable_Aspecto" class="connectedSortable">
                        <li class="ui-state-default" id="Sombra_id_<?PHP echo $j?>" onmouseover="Sombralight(<?PHP echo $j?>)" onmouseout="SinSombra(<?PHP echo $j?>)" onclick="DescargarDocRepositorio('<?php echo "ftp://".$_SERVER["SERVER_NAME"].rawurldecode(str_replace("/var/ftp","",$file)); ?>')"
                            style="cursor:pointer"><?php $nombre = str_replace($ruta,"",$file); echo str_replace(".pdf","",$nombre); ?>
                                 <img src="../../images/Adobe_PDF_Reader.png" width="15" />
                        </li>
                        </ul>  
                   <?php $j = $j + 1; } }                
                ?>
             </fieldset>
                
		<?php }break;
	default:{
		define(AJAX,'FALSE');
		  
		MainGeneral();
		JsGenral();
		
		global $C_VisualizarGeneral,$userid,$db;

		$id		= $_REQUEST['id'];
		
		$C_VisualizarGeneral->Principal($id);
		}break;
	}
function MainGeneral(){
	
		global $C_VisualizarGeneral,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    //include_once("../../templates/template.php");
	    include_once("./template.php");
		
		include('VisualizarGeneral.class.php');  $C_VisualizarGeneral = new VisualizarGeneral();
		
		if(AJAX=='FALSE'){
		
		$db=writeHeader("Visualizar Documento",true,'','../../','body','Utils_monitoreo',false);
		}else if(AJAX=='TRUE'){
			$db=writeHeaderBD();
			}else{
				$db=writeHeader2("Visualizar Documento",true,false);
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
	    //include("../../templates/template.php");
            include("./template.php");
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
						
							
    </style>
     <script type="text/javascript">
		calculateWidthMenu();
		//Para que arregle el menu al cambiar el tamaño de la página
		$(window).resize(function() {
			 calculateWidthMenu();
		}); 
	</script>
   
    <script>
    	function Cargar(id,Estructura_id,Doc_id,i){
				
				var indesBtn  = $('#indesBtn').val();
				
				for(j=0;j<indesBtn;j++){
						if(j==i){
							$('#Botn_'+j).addClass('BotonImagen_New');
							$('#Botn_'+j).removeClass('BotonImagen')
							$('#LetraColor_'+j).css('color','#FFF');
							}else{
								$('#Botn_'+j).addClass('BotonImagen');
								$('#Botn_'+j).removeClass('BotonImagen_New');
								$('#LetraColor_'+j).css('color','#000');
								}
					}
				
					
				
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: 'Cargar',id:id,Estructura_id:Estructura_id,Doc_id:Doc_id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									$('#CargarInfo').html(data);
											
						   } 
					}); //AJAX
				
			}
function CargarSub(i,Caract_id,Factor_id,Estructura_id,Doc_id){
				
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: 'CargarSub',Caract_id:Caract_id,Factor_id:Factor_id,Estructura_id:Estructura_id,Doc_id:Doc_id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									$('#CargarInfo').html(data);
											
						   } 
					}); //AJAX
			
			}
 function CargarRepositorio(ruta,directorio,id){
				
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: 'CargarRepositorio',ruta:ruta,directorio:directorio,id:id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									$('#CargarInfo').html(data);
											
						   } 
					}); //AJAX
			
			}
                        
		function VerIndicaores(j,Aspecto_id,Estructura_id,Factor_id){
			
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: 'CargarIndicadores',Aspecto_id:Aspecto_id,Estructura_id:Estructura_id,Factor_id:Factor_id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									var Index  = $('#Index_Asp').val();
									
									for(i=0;i<Index;i++){
										if(i==j){
											$('#SubCargaInd_'+j).html(data);
											}else{
												$('#SubCargaInd_'+i).css('display','block');
												$('#SubCargaInd_'+i).html('');	
												}
									}
									
											
						   } 
					}); //AJAX
				
			}
		function Sombralight(i){

			var Index = $('#Index').val();
			//$('#Caracteristica_li_'+id+'_'+i).removeClass('ui-state-default');
			for(j=0;j<=Index;j++){
					if(i==j){
						$('#Sombra_id_'+i).addClass('ui-state-highlight_edit');
						}
				}
			
			
			}	
		function SinSombra(i){

			var Index = $('#Index').val();
			//$('#Caracteristica_li_'+id+'_'+i).removeClass('ui-state-default');
			for(j=0;j<=Index;j++){
					if(i==j){
						$('#Sombra_id_'+i).removeClass('ui-state-highlight_edit');
				        $('#Sombra_id_'+i).addClass('ui-state-default');
						}
				}
				
			
			}			
			function Sombralight_2(i){

			var Index = $('#Index').val();
			//$('#Caracteristica_li_'+id+'_'+i).removeClass('ui-state-default');
			for(j=0;j<=Index;j++){
					if(i==j){
						$('#Open_'+i).addClass('ui-state-highlight_edit');
						}
				}
			
			
			}	
		function SinSombra_2(i){

			var Index = $('#Index').val();
			//$('#Caracteristica_li_'+id+'_'+i).removeClass('ui-state-default');
			for(j=0;j<=Index;j++){
					if(i==j){
						$('#Open_'+i).removeClass('ui-state-highlight_edit');
				        $('#Open_'+i).addClass('ui-state-default');
						}
				}
				
			
			}			
	function Ventana(Estructura_id,Factor_id,Indicador_id){
		
		 	 var url  = 'VisualizarGeneral.html.php?actionID=Ventana&Estructura_id='+Estructura_id+'&Factor_id='+Factor_id+'&Indicador_id='+Indicador_id;
			
			 
			 var centerWidth = (window.screen.width - 850) / 2;
			 var centerHeight = (window.screen.height - 700) / 2;
	   
			 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=800, top="+centerHeight+", left="+centerWidth;
			 var mypopup = window.open(url,"",opciones);
			 //para poner la ventana en frente
			 window.focus();
			 mypopup.focus();
		
		}		
	function Closed(){
			window.close();
		}
	function BotonSombra(i){
		
			$('#Botn_'+i).removeClass('BotonImagen');
			$('#Botn_'+i).addClass(' BotonImagen_New');
		}
	function BotonSinSombra(i){
		$('#Botn_'+i).removeClass('BotonImagen_New');
			$('#Botn_'+i).addClass('BotonImagen');
		}	
	function DescargarDoc(url){
		
		popUp_3('../../SQI_Documento/'+url,'1500','800');   
		}
	function DescargarDocRepositorio(url){
		
		popUp_3(url,'1500','800');   
		}
		
		function VerIndicador(indicador_id,tipo,Descri,f_inicial,f_final){
		
		if(tipo==1){
			//../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].'&Fecha_ini='.$fecha_inicio.'&Fecha_fin='.$fecha_fin
			var Data_Url = '../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='+indicador_id+'&Fecha_ini='+f_inicial+'&Fecha_fin='+f_final;
			}
		if(tipo==2){
			var Data_Url ='../../autoevaluacion/interfaz/prueba_resul.php?indicador_id='+indicador_id+'&Descriminacion='+Descri;
			}
		if(tipo==3){
			var Data_Url ='../../datos/reportes/detalle.php?idIndicador='+indicador_id;
			}	
		/************************************************************/
		 	 var url  = Data_Url;
			 var centerWidth = (window.screen.width - 850) / 2;
			 var centerHeight = (window.screen.height - 700) / 2;
	   
			 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
			 var mypopup = window.open(url,"",opciones);
			 //para poner la ventana en frente
			 window.focus();
			 mypopup.focus();
		/************************************************************/
		}
		
	function VolverPrincipal(id){
		/**********************************************************container****/
		
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: '',id:id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									$('#container').html(data);
											
						   } 
					}); //AJAX
		/**************************************************************/
		}
	function PreVolver(Factor_id,id_Estructura,id){
		/*********************************************************************/
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'VisualizarGeneral.html.php',
				   async: false,
				   //dataType: 'json',
				   data:({actionID: 'Cargar',id:Factor_id,Estructura_id:id_Estructura,Doc_id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							
							$('#CargarInfo').html(data);
									
				   } 
			}); //AJAX
		/*********************************************************************/
		}
		
	function Volver(ruta,directorio,id){
				
				$.ajax({//Ajax
						   type: 'GET',
						   url: 'VisualizarGeneral.html.php',
						   async: false,
						   //dataType: 'json',
						   data:({actionID: 'CargarRepositorio',ruta:ruta,directorio:directorio,id:id}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
									
									$('#CargarInfo').html(data);
											
						   } 
					}); //AJAX
		}
	function VorverPreDoc(){
		alert('Aca');
		}								
    </script>
    <?PHP
	}	
?>