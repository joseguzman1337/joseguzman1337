<?PHP 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class Rotaciones{
	/////////////////////////////PRINCIPAL///////////////////////////////////
	 public function Principal($CodigoCarrera){
		global $userid,$db;
		
		#$CodigoCarrera = '';
        $ruta_rot="../../../..";
        
		?>
<!DOCTYPE HTML>
<html>
<head>
        
       <!--cambia r y ajustar-->
       <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functionsMonitoreo.js"></script> 
        <!--Hasta aca-->
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
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			
                         $('#infomateria').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                         $('#agrupaciones').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>
        <body>
        <fieldset>
        <legend>Menu Rotaciones</legend>
        <input type="button" id="rotacionesop1" name="rotacionesop1" value="Rotaciones Estudiante" onclick="window.location.href='Rotaciones_html.php?actionID=VwBusquedaRotacionesEstudiantes'"/>
            
         </fieldset>
        </body>
        </html>
        <?php    
		}#public function Principal
	/////////////////////////////PRINCIPAL///////////////////////////////////	
    
    
     
    public function VwASignacionRotacionJs(){
        
        ?>
         <script type="text/javascript">
        //inicializar tablas
        	$(document).ready( function () {
        			
        			
                         $('#asignacionrot').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                         
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
                
                
          function calendario(form,campo){
            window.open('/funciones/calendario/index.php?formulario='+form+'&nomcampo='+id,'_blank');
            
            
          }
       
    	</script>
        <title>Distribucion de Rotaciones</title>
        </head>
        
      <?php  }#public function VwASignacionRotacionJs
      
      
      



/////////////////////VwBusquedaRotacionesEstudiantes/////////////////////
public function VwBusquedaRotacionesEstudiantes($CodigoCarrera){
		global $userid,$db;
		
		#$CodigoCarrera = '';
        $ruta_rot="../../../..";
        
		?>
<!DOCTYPE HTML>
<html>
<head>
        <style type="text/css" title="currentStyle">
                <--!@import "../observatorio/data/media/css/demo_page.css";
                @import "../observatorio/data/media/css/demo_table_jui.css";
                @import "../observatorio/data/media/css/ColVis.css";
                @import "../observatorio/data/media/css/TableTools.css";
                @import "../observatorio/data/media/css/ColReorder.css";
                @import "../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../observatorio/data/media/css/jquery.modal.css";-->
                
        </style>
       <!--cambia r y ajustar-->
       <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functionsMonitoreo.js"></script> 
        <!--Hasta aca-->
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
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			
                         $('#infomateria').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                         $('#agrupaciones').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>
        <body>
        <fieldset>
        <legend>Busqueda Rotaciones</legend>
        
            <table align="center" cellpadding="0" width="98%" border="0" >
                <thead>
                   
                    <tr>
                        <td colspan="2"><center><strong>BUSQUEDA ROTACION ESTUDIANTE</strong></center></td>
                        
                   </tr>
                   <tr>
                        <td colspan="2">
                                Busqueda por:
                                <select id="busquedapor" name="busquedapor">
                                    <option value="-1">Seleccione</option>
                                    <option value="1">Estudiante</option>
                                </select>
                                <input type="text" id="campobuscar" name="campobuscar" value=""  />
                                <input type="button" id="buscar" name="buscar" value="buscar"  />
                        </td>
                        
                   </tr>     
                       
                   <tr>
                        <tr>
                    	<td colspan="2">
                            <left>
                            	 <input type="button" id="VerDetalle" name="VerDetalle" value="Ver Detalle" onclick="window.open('Rotaciones_html.php?actionID=VwFormularioDetalleRotacion','mywindow');" />
                                 <input type="button" id="NuevaRotacion" name="NuevaRotacion" value="Nueva Rotación" />
                                 <input type="button" id="GeneCertificado" name="GeneCertificado" value="Generar Certificado" />
                                 
                            </left>
                        </td>
                    </tr>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>
                        <table id="infomateria" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Materias</th>
                                    <th>N° Documento</th>
                                    <th>Nombre Estudiante</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Finalización</th>
                                    <th>Total dias</th>
                                    <th>Estado</th>
                                    <th>Periodo</th>
                                    <th>Servicio</th>
                                    
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                  <th>N°</th>
                                    <th>Materias</th>
                                    <th>N° Documento</th>
                                    <th>Nombre Estudiante</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Finalización</th>
                                    <th>Total dias</th>
                                    <th>Estado</th>
                                    <th>Periodo</th>
                                    <th>Servicio</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                
                            </tbody>
                       </table>
                                    
                    </td></tr>
                	
                </tbody>
            </table>
         </fieldset>
        </body>
        </html>
        <?php    
}#public function VwBusquedaRotacionesEstudiantes
//////////////////////////FIN VwBusquedaRotacionesEstudiantes///////////////////////////  

/////////////////////VwBusquedaRotacionesLugares/////////////////////
public function VwBusquedaRotacionesLugares($CodigoCarrera){
		global $userid,$db;
		
		#$CodigoCarrera = '';
        $ruta_rot="../../../..";
        
		?>
<!DOCTYPE HTML>
<html>
<head>
        <style type="text/css" title="currentStyle">
                <--!@import "../observatorio/data/media/css/demo_page.css";
                @import "../observatorio/data/media/css/demo_table_jui.css";
                @import "../observatorio/data/media/css/ColVis.css";
                @import "../observatorio/data/media/css/TableTools.css";
                @import "../observatorio/data/media/css/ColReorder.css";
                @import "../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../observatorio/data/media/css/jquery.modal.css";-->
                
        </style>
       <!--cambia r y ajustar-->
       <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functionsMonitoreo.js"></script> 
        <!--Hasta aca-->
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
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			
                         $('#infomateria').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                         $('#agrupaciones').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>
        <body>
        <fieldset>
        <legend>Busqueda Rotaciones</legend>
        
            <table align="center" cellpadding="0" width="98%" border="0" >
                <thead>
                   
                    <tr>
                        <td colspan="2"><center><strong>BUSQUEDA ROTACION LUGARES</strong></center></td>
                        
                   </tr>
                   <tr>
                        <td colspan="2">
                                Busqueda por:
                                <select id="busquedapor" name="busquedapor">
                                    <option value="-1">Seleccione</option>
                                    <option value="1">lugar de rotacion</option>
                                </select>
                                <input type="text" id="campobuscar" name="campobuscar" value=""  />
                                <input type="button" id="buscar" name="buscar" value="buscar"  />
                        </td>
                        
                   </tr>     
                       
                   <tr>
                        <tr>
                    	<td colspan="2">
                            <left>
                            	 <input type="button" id="VerDetalle" name="VerDetalle" value="Ver Detalle" onclick="window.open('Rotaciones_html.php?actionID=VwFormularioDetalleRotacion','mywindow');" />
                                 
                                 
                            </left>
                        </td>
                    </tr>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>
                        <table id="infomateria" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Materias</th>
                                    <th>N° Documento</th>
                                    <th>Nombre Estudiante</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Finalización</th>
                                    <th>Total dias</th>
                                    <th>Estado</th>
                                    <th>Periodo</th>
                                    <th>Servicio</th>
                                    
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                  <th>N°</th>
                                    <th>Materias</th>
                                    <th>N° Documento</th>
                                    <th>Nombre Estudiante</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Finalización</th>
                                    <th>Total dias</th>
                                    <th>Estado</th>
                                    <th>Periodo</th>
                                    <th>Servicio</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                
                            </tbody>
                       </table>
                                    
                    </td></tr>
                	
                </tbody>
            </table>
            <left><input type="button" id="procliquidacion" name="procliquidacion" value="Liquidacion Contraprestacion"  /></left>
         </fieldset>
        </body>
        </html>
        <?php    
}#public function VwBusquedaRotacionesLugares
//////////////////////////FIN VwBusquedaRotacionesLugares///////////////////////////  

    

///////////////////////////VwFormularioDetalleRotacion////////////////////////
public function VwFormularioDetalleRotacion($CodigoCarrera){
		global $userid,$db;
		
		#$CodigoCarrera = '';
        $ruta_rot="../../../..";
        
		?>
<!DOCTYPE HTML>
<html>
<head>
        
       <!--cambia r y ajustar-->
       <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functionsMonitoreo.js"></script> 
        <!--Hasta aca-->
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
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        function validar(){ 
            ////nombre            
            if(!$.trim($('#nombre').val())){
                alert('Digite un nombre...');
                $('#nombre').effect("pulsate", {times:3}, 500);
                $('#nombre').css('border-color','#F00');  
                return false;
            }
            ////fecha_ingreso           
            if(!$.trim($('#fechaingreso').val())){
                alert('Digite un fecha de ingreso...');
                $('#fechaingreso').effect("pulsate", {times:3}, 500);
                $('#fechaingreso').css('border-color','#F00');  
                return false;
            }
            
            ////materia
            if($('#materia').val()=='-1'){
               alert('Elija una materia...');
                $('#materia').effect("pulsate", {times:3}, 500);
                $('#materia').css('border-color','#F00'); 
                return false; 
                        
            }
            ////fecha_egreso           
            if(!$.trim($('#fechaegreso').val())){
                alert('elija una Fecha de egreso...');
                $('#fechaegreso').effect("pulsate", {times:3}, 500);
                $('#fechaegreso').css('border-color','#F00');  
                return false;
            }
            ////convenio
            if($('#convenio').val()=='-1'){
               alert('Elija un convenio...');
                $('#convenio').effect("pulsate", {times:3}, 500);
                $('#convenio').css('border-color','#F00'); 
                return false; 
                        
            }
            ////nota           
            if(!$.trim($('#nota').val())){
                alert('digite una nota...');
                $('#nota').effect("pulsate", {times:3}, 500);
                $('#nota').css('border-color','#F00');  
                return false;
            }
            ////lugar de rotacion
            if($('#lugarderotacion').val()=='-1'){
               alert('Elija lugar de rotacion...');
                $('#lugarderotacion').effect("pulsate", {times:3}, 500);
                $('#lugarderotacion').css('border-color','#F00'); 
                return false; 
                        
            }
            ////Estado rotacion
            if($('#estadorotacion').val()=='-1'){
               alert('Elija un Estado de rotacion...');
                $('#estadorotacion').effect("pulsate", {times:3}, 500);
                $('#estadorotacion').css('border-color','#F00'); 
                return false; 
                        
            }
            ////totaldias          
            if(!$.trim($('#totaldias').val())){
                alert('Digite un Numero de dias...');
                $('#totaldias').effect("pulsate", {times:3}, 500);
                $('#totaldias').css('border-color','#F00');  
                return false;
            }
            ////servicio
            if($('#serviciorotacion').val()=='-1'){
               alert('Elija un servicio de rotacion...');
                $('#serviciorotacion').effect("pulsate", {times:3}, 500);
                $('#serviciorotacion').css('border-color','#F00'); 
                return false; 
                        
            }
            return true;
        
        }
        function guarda_rotacion(){
            nombre=$('#nombre').val();
            fechaingreso=$('#fechaingreso').val();
            materia=$('#materia').val();
            fechaegreso=$('#fechaegreso').val();
            convenio=$('#convenio').val();
            nota=$('#nota').val();
            lugarderotacion=$('#lugarderotacion').val();
            totaldias=$('#totaldias').val();
            serviciorotacion=$('#serviciorotacion').val();
      
            $.ajax({
                type: 'POST',
                url: 'Rotaciones_html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'guardarRotaciones',
                    nombre:nombre,
                    fechaingreso:fechaingreso,
                    materia:materia,
                    fechaegreso:fechaegreso,
                    convenio:convenio,
                    nota:nota,
                    lugarderotacion:lugarderotacion,
                    totaldias:totaldias,
                    serviciorotacion:serviciorotacion
                  
                    
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert(data.descrip);
                        return true;
                                            
                    }
                }
            });
            
        }
        
        
        	$(document).ready( function () {
        			
        		$("#fechaingreso").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechaegreso").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
           	
                         
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        	} );
        	/**************************************************************/
        </script>
        <body>
        <fieldset>
        <legend>Formulario de Rotacion Estudiante</legend>
        
            <table align="center" cellpadding="0" width="98%" border="0" >
                <thead>
                   
                    <tr>
                        <td colspan="2"><center><strong>FORMULARIO DE ROTACIONES</strong></center></td>
                        
                   </tr>
                   <tr>
                        <td colspan="2">&nbsp;</td>
                   </tr>     
                       
                   <tr>
                        <tr>
                    	<td colspan="2">
                            <table align="center" border="1">
                                <tr>
                                    <td>
                                        Nombre:
                                    </td>
                                    <td>
                                        <input type="text" id="nombre" name="nombre" value="" />
                                    </td>
                                    <td>
                                        Ingreso:
                                    </td>
                                    <td>
                                        <input type="text" id="fechaingreso" name="fechaingreso" class="requerido" size="12" style="text-align:center;" readonly="readonly" value="" placeholder=""  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Materia:
                                    </td>
                                    <td>
                                        <select id="materia" name="materia" />
                                            <option value="-1">Seleccione:</option>
                                            <option value="1">Por Defecto</option>
                                    </td>
                                    <td>
                                        Egreso:
                                    </td>
                                    <td>
                                        <input type="text" id="fechaegreso" name="fechaegreso" class="requerido" size="12" style="text-align:center;" readonly="readonly" value="" placeholder=""  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Convenio:
                                    </td>
                                    <td>
                                        <select id="convenio" name="convenio"/>
                                            <option value="-1">Seleccione:</option>
                                            <option value="1">Por Defecto</option>
                                    </td>
                                    <td>
                                        Nota:
                                    </td>
                                    <td>
                                        <input type="text" id="nota" name="nota" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lugar de rotación:
                                    </td>
                                    <td>
                                        <select id="lugarderotacion" name="lugarderotacion"/>
                                            <option value="-1">Seleccione:</option>
                                            <option value="1">Por Defecto</option>
                                    </td>
                                    <td>
                                        Estado:
                                    </td>
                                    <td>
                                        <select id="estadorotacion" name="estadorotacion" />
                                            <option value="-1">Seleccione:</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                             <option value="3">Bloqueado</option>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Total Dias:
                                    </td>
                                    <td>
                                        <input type="text" id="totaldias" name="totaldias" value="" />
                                    </td>
                                    <td>
                                        Servicio:
                                    </td>
                                    <td>
                                        <select id="serviciorotacion" name="serviciorotacion"/>
                                            <option value="-1">Seleccione:</option>
                                            <option value="1">Pediatria</option>
                                            <option value="2">Cirugia</option>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <center>
                                             <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST["codigoestudiante"];?>" />
                                        	 <input type="button" id="guardar" name="guardar" value="Guardar" onclick="if(validar()){guarda_rotacion();}"/>
                                             <input type="button" id="regresar" name="regresar" value="Regresar" />
                                        </center>
                                    </td>
                                </tr>
                            </table>	 
                        </td>
                    </tr>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        </td>
                    </tr>
                	
                </tbody>
            </table>
         </fieldset>
        </body>
        </html>
        <?php    
	}#public function VwFormularioDetalleRotacion

////////////////FIN VwFormularioDetalleRotacion//////////////////////////////



//////EstudiantesGrupoMaterias
	public function EstudiantesGrupoMaterias($IdGrupo,$codigoperiodo,$idSubgrupo){
		global $userid,$db;
		
		?>
        <?PHP
        $SQL_EstudiantesGrupoMaterias="SELECT
                    d.codigomateria,
                    e.codigocarrera,
                    count(*) as totalalumnosgrupo,
                    'Todos' as nomsubgrupo                    
                FROM
                	detalleprematricula AS d
                INNER JOIN prematricula AS p ON p.idprematricula = d.idprematricula
                INNER JOIN estudiante AS e ON e.codigoestudiante = p.codigoestudiante
                INNER JOIN estudiantegeneral ON e.idestudiantegeneral = estudiantegeneral.idestudiantegeneral
                WHERE
                	(
                		p.codigoestadoprematricula LIKE '1%'
                		OR p.codigoestadoprematricula LIKE '4%'
                	)
                AND (
                	d.codigoestadodetalleprematricula LIKE '1%'
                	OR d.codigoestadodetalleprematricula LIKE '3%'
                )
                AND d.idgrupo = ".$IdGrupo."
                AND p.codigoperiodo = ".$codigoperiodo."";
                
         if(isset($idSubgrupo)&&($idSubgrupo!="")){
          $SQL_EstudiantesGrupoMaterias="SELECT
                    g.codigomateria,
                e.codigocarrera,
                Count(*) AS totalalumnosgrupo,
                Subgrupos.NombreSubgrupo AS nomsubgrupo,
                g.codigomateria
                FROM
                SubgruposEstudiantes AS subest
                INNER JOIN estudiantegeneral AS est ON subest.idestudiantegeneral = est.idestudiantegeneral
                INNER JOIN Subgrupos ON subest.SubgrupoId = Subgrupos.SubgrupoId
                INNER JOIN grupo AS g ON Subgrupos.idgrupo = g.idgrupo
                INNER JOIN materia AS e ON e.codigomateria = g.codigomateria
                WHERE
                subest.SubgrupoId = '".$idSubgrupo."'";  
        }
		
				//echo $SQL_EstudiantesGrupoMaterias."<br>";					
			if($EstudiantesGrupoMaterias=&$db->Execute($SQL_EstudiantesGrupoMaterias)===false){
					echo 'Error en el SQL de grupo de estudiantes materias....<br><br>',$SQL_EstudiantesGrupoMaterias;
					die;
			}	
		
		/***************************************************************/							
		
			if(!$EstudiantesGrupoMaterias->EOF){
               $i = 0;
    			while(!$EstudiantesGrupoMaterias->EOF){
    			 $name1 = 'FechaIngreso_'.$i;
                 $name2 = 'FechaEgreso_'.$i;                             
    				/**********************verificar si tiene alguna rotacion********************************/
                    $SQL_EstudiantesRotacion="
                                SELECT
                                    	re.RotacionEstudianteId,
                                    	re.FechaIngreso,
                                    	re.FechaEgreso,
                                    	re.TotalDias,
                                    	re.EstadoRotacionId,
                                    	sr.NombreServicio,
                                    	ui.NombreUbicacion,
                                    	sc.NombreConvenio,
                                    	er.NombreEstado
                                FROM
                                    	RotacionEstudiantes AS re
                                    INNER JOIN ServicioRotaciones AS sr ON re.ServicioRotacionId = sr.ServicioRotacionId
                                    INNER JOIN UbicacionInstituciones AS ui ON re.IdUbicacionInstitucion = ui.IdUbicacionInstitucion
                                    INNER JOIN siq_convenio AS sc ON re.idsiq_convenio = sc.idsiq_convenio
                                    INNER JOIN EstadoRotaciones AS er ON re.EstadoRotacionId = er.EstadoRotacionId
                                WHERE
                                	re.idestudiantegeneral = '".$EstudiantesGrupoMaterias->fields['idestudiantegeneral']."'
                                AND re.codigomateria='".$EstudiantesGrupoMaterias->fields['codigomateria']."'
                                AND re.codigoperiodo='".$codigoperiodo."'
                                AND re.codigocarrera='".$EstudiantesGrupoMaterias->fields['codigocarrera']."'";
    		
			        //echo $SQL_EstudiantesRotacion."<br>";					
                    if($EstudiantesRotacion=&$db->Execute($SQL_EstudiantesRotacion)===false){
    				    echo 'Error en el SQL de rotaciones de estudiantes....<br><br>',$SQL_EstudiantesRotacion;
    					die;
                    }
                    
                        
                    /*************************************************/
    				?>
                    <tr>
                    	<td style="text-align: center;"><strong><?PHP echo $EstudiantesGrupoMaterias->fields['totalalumnosgrupo']?></strong><input type="hidden" id="total_alumnos" name="total_alumnos" value="<?php echo $EstudiantesGrupoMaterias->fields['totalalumnosgrupo']; ?>" /></td>
                        <td><strong><input type="hidden" name="codcarrera_<?php echo $i?>" id="codcarrera_<?php echo $i?>" value="<?php echo $EstudiantesGrupoMaterias->fields['codigocarrera']?>" /><input type="hidden" name="codmateria_<?php echo $i?>" id="codmateria_<?php echo $i?>" value="<?php echo $EstudiantesGrupoMaterias->fields['codigomateria']?>" /><input type="hidden" name="idsubgrupo_<?php echo $i?>" id="idsubgrupo_<?php echo $i?>" value="<?php echo $idSubgrupo;?>" /><input type="hidden" name="idgrupo_<?php echo $i?>" id="idgrupo_<?php echo $i?>" value="<?php echo $IdGrupo;?>" /><?php echo $EstudiantesGrupoMaterias->fields['nomsubgrupo'] ?></strong></td>
                        <td>
                        <?php if(isset($EstudiantesRotacion->fields["NombreConvenio"])){
                                echo $EstudiantesRotacion->fields["NombreConvenio"];
                               }else{  ?>
                            <select id="convenio_<?php echo $i?>" name="convenio_<?php echo $i?>" onchange="UbicacionInstitucionesConvenio('convenio_<?php echo $i?>', 'idubicacion_<?php echo $i?>')">
                                <option value="null">Seleccione:</option>
                            <?php
                                echo $SqlConvenios = "select sc.idsiq_convenio, sc.NombreConvenio from grupo g join materia m on m.codigomateria = g.codigomateria join conveniocarrera cc on cc.codigocarrera = m.codigocarrera join siq_convenio sc ON sc.idsiq_convenio = cc.idconvenio where g.idgrupo = '".$IdGrupo."'";
                                
                                $valorconvenio = $db->execute($SqlConvenios);
                                foreach($valorconvenio as $datosconvenio){
                                    ?>
                                    <option value="<?php echo $datosconvenio['idsiq_convenio']?>"><?php echo $datosconvenio['NombreConvenio']?></option>        
                                    <?php
                                }
                            ?> 
                          </select>
                          <?php } ?>
                        </td>
                        <td>
                            <?php if(isset($EstudiantesRotacion->fields["NombreUbicacion"])){
                                echo $EstudiantesRotacion->fields["NombreUbicacion"];
                               }else{  ?>
                            <select id="idubicacion_<?php echo $i?>" name="idubicacion_<?php echo $i?>">
                            <option value="null">Seleccione:</option>
                            <?php
                            /*$sqlUbicacion= "SELECT ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM UbicacionInstituciones ui JOIN siq_convenio sc ON sc.idsiq_institucionconvenio = ui.idsiq_institucionconvenio WHERE sc.idsiq_convenio = '".$idconvenio."'";
                            $valorUbicacion = $db->execute($sqlUbicacion);
                            foreach($valorUbicacion as $datosUbicacion){
                                ?>
                                <option value="<?php echo $datosUbicacion['IdUbicacionInstitucion']?>"><?php echo $datosUbicacion['NombreUbicacion']?></option>
                                <?php
                            }*/
                            ?>            
                            </select>
                            <?php } ?>
                        </td>
                        <td><?php if(isset($EstudiantesRotacion->fields["NombreServicio"])){
                                echo $EstudiantesRotacion->fields["NombreServicio"];
                               }else{  ?><select id="servicio_<?php echo $i?>" name="servicio_<?php echo $i?>">
                                            <option value="null">Seleccione:</option>
                                    <?php
                                    $sqlServicio = "select ServicioRotacionId, NombreServicio from ServicioRotaciones where codigomateria = '".$EstudiantesGrupoMaterias->fields['codigomateria']."'";
                                    echo $sqlServicio;
                                    $valoresServicio=$db->Execute($sqlServicio);
                                    foreach($valoresServicio as $datosServicio)
                                    {
                                        ?>
                                        <option value="<?php echo $datosServicio['ServicioRotacionId']?>"><?php echo $datosServicio['NombreServicio']?></option>
                                        <?php
                                    }
        ?>   
                                       
                                  </select>
                                  <?php } ?>
                        </td>
                        <td><?php if(isset($EstudiantesRotacion->fields["FechaIngreso"])){
                                echo $EstudiantesRotacion->fields["FechaIngreso"];
                               }else{  ?><input type="text" id="<?PHP echo $name1?>" name="<?PHP echo $name1?>" class="requerido" size="12" style="text-align:center;" readonly="readonly" value="<?PHP echo $value?>" placeholder="<?PHP echo $Ejemplo?>" <?PHP echo $readonly;?> onmouseover="$('#<?PHP echo $name1?>').datepicker({
        changeMonth: true,
        changeYear: true,
        //showOn: 'button',
        buttonImage: '../../../../css/themes/smoothness/images/calendar.gif',
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd'
        });
        
               $('#ui-datepicker-div').css('display','none');" />
                                        
      
           
           <?php } ?></td>
          <td><?php if(isset($EstudiantesRotacion->fields["FechaEgreso"])){
                                echo $EstudiantesRotacion->fields["FechaEgreso"];
                               }else{  ?><input type="text" id="<?PHP echo $name2?>" name="<?PHP echo $name2?>" class="requerido" size="12" style="text-align:center;" readonly="readonly" value="<?PHP echo $value?>" placeholder="<?PHP echo $Ejemplo?>" <?PHP echo $readonly;?> onmouseover="$('#<?PHP echo $name2?>').datepicker({
        changeMonth: true,
        changeYear: true,
        //showOn: 'button',
        buttonImage: '../../../../css/themes/smoothness/images/calendar.gif',
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd'
        });
        
               $('#ui-datepicker-div').css('display','none');"/>
              <?php } ?> 
          </td>
          <td><?php if(isset($EstudiantesRotacion->fields["TotalDias"])){
                                echo $EstudiantesRotacion->fields["TotalDias"];
                               }else{  ?><input type="text" id="TotDias_<?php echo $i?>" name="TotDias_<?php echo $i?>" value=""/><!--<a onclick="window.open('./Rotaciones_html.php?actionID=VwFormularioDetalleRotacion','', 'width=600, height=600 scrollbars=no channelmode=no');" title="Ver detalles">__</a>--></td>
            <?php } ?>
            <td><?php if(isset($EstudiantesRotacion->fields["NombreEstado"])){
                                echo $EstudiantesRotacion->fields["NombreEstado"];
                               }else{  ?><select id="estadorotacion_<?php echo $i?>" name="estadorotacion_<?php echo $i?>" />
                            <option value="null">Seleccione:</option>
                            <option value="1" selected="">Activo</option>
                            <option value="2">Inactivo</option>
                            <option value="3">Bloqueado</option>
                        </select>
                        <?php } ?>
                         </td>
                        <td><?php if(isset($EstudiantesRotacion->fields["FechaEgreso"])){
                                echo "No aplica";
                               }else{  ?><input type="checkbox" name="checkestudiante_<?php echo $i?>" id="checkestudiante_<?php echo $i?>" value="on"/></td>
                                  <?php } ?>  
                                 </tr>   
                                <?PHP
                                $i++;
								/******************************************************/
								$EstudiantesGrupoMaterias->MoveNext();
								}////fin while principal
                                
							?>
                            <script type="text/javascript" >
                            var total_rows='<?php echo $i?>';
                            $("#total_rows").val('esto');
             
             for(i=0;i>=<?php echo $i; ?>;i++){
                $('#FechaIngreso_'+i).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    
                    dateFormat: 'yy-mm-dd'
                });
                
                $("#FechaEgreso_"+i).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    //showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                
                
             }    
                
               $('#ui-datepicker-div').css('display','none');
             
            
             
           </script>
                       
                    
                	
               
			<?PHP
                 return  $i;
			}
		
	}//////Fin EstudiantesGrupoMaterias

        
//////////////////////////VwASignacionRotacionGrupo/////////////////////////////           
    public function VwASignacionRotacionGrupo($array){
        global $userid,$db;    
        
        $ruta_rot="../../../..";
         
         $idgrupo=$array["idgrupo"];
         $codigoperiodo=$array["codigoperiodo"];
         $idsubgrupo=$array["idsubgrupo"];
         
		?>
<!DOCTYPE HTML>
<html>
<head>
        <style type="text/css" title="currentStyle">
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/demo_page.css";
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/demo_table_jui.css";
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/ColVis.css";
                @import "<?php echo $ruta_rot;?>/observatorio/data/media/css/TableTools.css";
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/ColReorder.css";
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "<?php echo $ruta_rot; ?>/observatorio/data/media/css/jquery.modal.css";
                
        </style>
       <!--cambia r y ajustar-->
       <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $ruta_rot; ?>/mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $ruta_rot; ?>/mgi/js/functionsMonitoreo.js"></script> 
        <!--Hasta aca-->
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
        
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        
        function validarcheckenviar(){
           var total=parseInt($("#total_rows").val());
           var val=true;
           for(i=0;i<=total;i++){
            
            if($("#checkestudiante_"+i).prop( "checked" )==true){
                
                ;                
                if($("#convenio_"+i).val()=='null'){
                    alert("Debe escoger un convenio de los que desea guardar");
                    $("#convenio_"+i).css('outline','1px solid #F00');
			        $("#convenio_"+i).effect("pulsate", {times:3}, 500);
                    $("#convenio_"+i).focus();                    
                    val= false;
                } 
                if($("#idubicacion_"+i).val()=='null'){
                    alert("Debe escoger una ubicacion de los que desea guardar");
                    $("#idubicacion_"+i).css('outline','1px solid #F00');
			        $("#idubicacion_"+i).effect("pulsate", {times:3}, 500);
                    $("#idubicacion_"+i).focus();
                    val= false;
                }
                if($("#servicio_"+i).val()=='null'){
                    alert("Debe escoger una servicio o especialidad que desea enviar");
                    $("#servicio_"+i).css('outline','1px solid #F00');
			        $("#servicio_"+i).effect("pulsate", {times:3}, 500);
                    $("#servicio_"+i).focus();
                    val= false;
                }
                if($.trim($("#FechaIngreso_"+i).val())==''){
                  alert("Debe digitar una fecha de ingreso a enviar");
                  $('#FechaIngreso_'+i).css('outline','1px solid #F00');
		          $('#FechaIngreso_'+i).effect("pulsate", {times:3}, 500);
                  $('#FechaIngreso_'+i).focus();
                       val= false;
                }
                if($.trim($("#FechaEgreso_"+i).val())==''){
                  alert("Debe digitar una fecha de egreso a enviar");
                  $('#FechaEgreso_'+i).css('outline','1px solid #F00');
		          $('#FechaEgreso_'+i).effect("pulsate", {times:3}, 500);
                  $('#FechaEgreso_'+i).focus();
                       val= false;
                }
                if($.trim($("#TotDias_"+i).val())==''){
                  alert("Debe digitar una fecha de egreso a enviar");
                  $('#TotDias_'+i).css('outline','1px solid #F00');
		          $('#TotDias_'+i).effect("pulsate", {times:3}, 500);
                  $('#TotDias_'+i).focus();
                       val= false;
                }
                if($("#estadorotacion_"+i).val()=='null'){
                    alert("Debe escoger un estado para la rotacion de los que desea guardar");
                    $("#estadorotacion_"+i).css('outline','1px solid #F00');
			        $("#estadorotacion_"+i).effect("pulsate", {times:3}, 500);
                    $("#estadorotacion_"+i).focus();
                    val= false;
                }                                                                                                                    
            }
                
        
            //$(combosdependientes+i).prop('selectedIndex', $(comboprincipal).get(0).selectedIndex);
            
                      //alert($("#convenio_"+i).val());
           } 
           return val;
        }
        function aplicartodoscombo(checkcombo,comboprincipal,combosdependientes){
            
            var total=parseInt($("#total_rows").val());
            //alert($("#total_rows").val());
            if($(checkcombo).prop( "checked" )==true){
                //alert($("#principalconvenio" ).val());
                for(i=0;i<=total;i++){
                    
                    $(combosdependientes+i).prop('selectedIndex', $(comboprincipal).get(0).selectedIndex);
                    //alert($("#convenio_"+i).val());
                }
            }else{
                   
            }
            
        }
        /////////
        function filtrosubgrupo(idsubgrupo){
            if(idsubgrupo==""){
                 $("#rotacionesestudiantes").attr('action', 'Rotaciones_html.php?actionID=VwASignacionRotacionGrupo&idgrupo=<?php echo $idgrupo."&codigoperiodo=".$codigoperiodo; ?>');
                $("#rotacionesestudiantes").submit();
            }else{
                if(idsubgrupo=="todos"){
                    $("#sel_subgrupo").val('');
                    $("#rotacionesestudiantes").attr('action', 'Rotaciones_html.php?actionID=VwASignacionRotacionGrupo&idgrupo=<?php echo $idgrupo."&codigoperiodo=".$codigoperiodo; ?>');                                        
                    $("#rotacionesestudiantes").submit();                      
                    
                 }else{
                    $("#rotacionesestudiantes").attr('action', 'Rotaciones_html.php?actionID=VwASignacionRotacionGrupo&idgrupo=<?php echo $idgrupo."&codigoperiodo=".$codigoperiodo; ?>');
                    $("#rotacionesestudiantes").submit();   
                                    
                 }
               
                
            }
            
        }
        
        $(document).ready( function () {
        			
                    $('#asignacionrot').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "aLengthMenu": [[100], [100,  "All"]],
                                    "iDisplayLength": 100,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                    });
                         
                                                                                              
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
                
           /******************************************************/
    
        function UbicacionInstitucionesConvenio(convenio, lugar )
        {
            var idconvenio = $('#'+convenio).val(); 
            $.ajax({//Ajax
                 type: 'POST',
                 url: 'Rotaciones_html.php',
                 async: true,
                 dataType:'json',
                 data:({actionID:'Rotacionesubicacion',idconvenio:idconvenio}),
                 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                 success: function(data){
                      // Parse the returned json data
                                
                                var opts = $.parseJSON(data);
                                 //alert(opts.ubicacionrotacion);
                                // Use jQuery's each to iterate over the opts value
                                $('#'+lugar).html('');
                                $('#'+lugar).append('<option value="null">Seleccione:</option>');
                                $.each(data, function(i,ubicacion){
                                    //alert(ubicacion);
                                  $('#'+lugar).append('<option value="' +ubicacion.IdUbicacionInstitucion+ '">' + ubicacion.NombreUbicacion + '</option>');
                                });
                }//data
            });// AJAX
            
        }    
        
        
        	/**************************************************************/
        </script>
   
        
        <body>
        <fieldset>
        <legend>Distribucion de rotaciones</legend>
        <form action="Rotaciones_html.php?actionID=guardarRotaciones" method="post" id="rotacionesestudiantes">
            <table border="0" align="center" cellspacing="0" width="98%">
                <thead>
                   
                    <tr>
                        <td colspan="2"><center><strong>ASIGNACION DE ROTACION</strong></center></td>
                        
                   </tr>
                   <tr>
                        <td colspan="2">&nbsp;<input type="hidden" id="codperiodo" name="codperiodo" value="<?php echo $codigoperiodo; ?>" /><input type="hidden" id="codgrupo" name="codgrupo" value="<?php echo $idgrupo; ?>" /></td>
                   </tr>     
                       
                   <tr>
                        <td colspan="2">&nbsp;</td>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>
                        <table id="asignacionrot" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="2"><div style="text-align: left;">Subgrupos:<select id="sel_subgrupo" name="sel_subgrupo" onchange="filtrosubgrupo(this.value)">
                                            <option value="null" >Selecciones:</option>
                                            <option value="todos" >Todos</option>
                                        <?php
                                        
                                        $sqlSubgrupo= "SELECT   *
                                                       FROM
                                                    Subgrupos
                                                WHERE
                                                   idgrupo='".$array["idgrupo"]."'";
                         
                                        echo $sqlSubgrupo;
                                        if($valorSubgrupo = &$db->execute($sqlSubgrupo)===false){
                                            echo 'Error en Consulta...<br><br>'.$SQL;
                                            die;
                                        }
                                        $subgruposids=$valorSubgrupo->GetArray();
                                        foreach($subgruposids as $datosSubgrupo){
                                            ?>
                                            <option value="<?php echo $datosSubgrupo['SubgrupoId']?>"><?php echo $datosSubgrupo['NombreSubgrupo']?></option>
                                            <?php
                                        }
                                         ?>
                                    
                                    </select></div></th>
                                  <th colspan="9"></th>
                                </tr>
                                 <!-- <tr>
                                    <th>Documento</th>
                                    <th>Asignacion  </th>
                                    <th>aplicar a todos:<input type="checkbox" id="todosconvenio" name="todosconvenio" onclick="aplicartodoscombo('#todosconvenio','#principalconvenio','#convenio_');" value="true" /><br />
                                    <select id="principalconvenio" name="convenio" onchange="aplicartodoscombo('#todosconvenio','#principalconvenio','#convenio_');">
                                        <option value="-1">Seleccione:</option>
                                        <option value="1">Convenio1</option>
                                        <option value="2">Convenio2</option>
                                    </select></th>
                                    <th>aplicar a todos:<input type="checkbox" id="todosrotacion" name="todosrotacion" onclick="aplicartodoscombo('#todosrotacion','#principalrotacion','#lugarrotacion_');" value="true" /><br /><select id="principalrotacion" name="principalrotacion" onchange="aplicartodoscombo('#todosrotacion','#principalrotacion','#lugarrotacion_');">
                                                    <option value="-1">Seleccione:</option>
                                                    <option value="1">rotacion1</option>
                                                    <option value="2">rotacion2</option>
                                                    <option value="3">rotacion2</option>
                                              </select></th>
                                    <th>aplicar a todos:<input type="checkbox" id="todosespecialidad" name="todosespecialidad" onclick="aplicartodoscombo('#todosespecialidad','#principalespecialidad','#Especialidad_');" value="true" /><br /><select id="principalespecialidad" name="principalespecialidad" onchange="aplicartodoscombo('#todosespecialidad','#principalespecialidad','#Especialidad_');">
                                                    <option value="-1">Seleccione:</option>
                                                    <option value="1">Pediatria</option>
                                                    <option value="2">Cirugia</option>
                                              </select></th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Egreso</th>
                                    <th>Total Dias</th>
                                    <th>Estado Rotacion</th>
                                    th>Seleccionar</th>
                                    
                                </tr>-->
                                <tr>    
                                    <th>Cantidad Estudiantes por rotacion</th>
                                    <th>Nombre de agrupacion</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Especialidad</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Egreso</th>
                                    <th>Total Dias</th>
                                    <th>Estado Rotacion</th>
                                    <th>Seleccionar</th>
                                    
                                </tr>
                            </thead>
                     
                            <tfoot>    
                                <tr>           
                                   <th>Cantidad Estudiantes por rotacion</th>
                                    <th>Nombre de agrupacion</th>
                                    <th>Convenio</th>
                                    <th>Lugar Rotacion</th>
                                    <th>Especialidad</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Egreso</th>
                                    <th>Total Dias</th>
                                    <th>Estado Rotacion</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                <?php $total_rows=$this->EstudiantesGrupoMaterias($idgrupo,$codigoperiodo,$idsubgrupo);  ?>
                            </tbody>
                       </table>
                                    
                    </td></tr>
                	
                    <tr>
                    	<td colspan="2">
                            <center>
                                 <input type="hidden" id="total_rows" name="total_rows" value="<?php echo $total_rows; ?>"/>
                            	 <input type="submit" id="guardarrotacion" name="guardarrotacion" value="Guardar" onclick="return validarcheckenviar();" /><br /><br />
                                 <input type="button" id="Salir" name="Salir" value="Salir" />
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </fieldset>
  </body>
  </html>
              <?php    
	}#public VwASignacionRotacion  
    //////////////////////////VwASignacionRotacionJs/////////////////////////////   
    
    
    /////////////////////////guardar rotacion//////////////////////////////////
    public function GuardarNuevaRotacion($arrayRotacion){
        global $userid,$db;
        $SQL_NuevaRotacion = "INSERT INTO Rotaciones(Nombre,
                                    	MaxEstudiantes,
                                    	Status ,
                                    	codigomateria ,
                                    	Idsiq_convenio,
                                    	TipoServicioRotacionId,
                                    	Idsiq_institucionconvenio,
                                    	FechaCreacion ,
                                    	UsuarioCreacion )
                             VALUES('".$arrayRotacion["nombrerotacion"]."','".$arrayRotacion["max_estudiantes"]."','".$arrayRotacion["status"]."','".$arrayRotacion["codigomateria"]."','".$arrayRotacion["idconvenio"]."','".$arrayRotacion["tiporotacion"]."','".$arrayRotacion["idlugarrotacion"]."',
                              NOW(),'".$arrayRotacion["idusuario"]."')";
						
		if($NuevaRotacion=$db->Execute($SQL_NuevaRotacion)===false){
				$a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL_NuevaRotacion;
                echo json_encode($a_vectt);
                die;
		}
        return $db->Insert_ID();
    }
    
    
    
    /////////////////////////fin guardar rotacion   
    ///////////////////guardar rotacionEstudiante 
    public function GuardarNuevaRotacionEstudiante($arrayRotacionEstudiante){
        global $userid,$db;
        //print_r($arrayRotacionEstudiante);
       $SQL_NuevaRotacionEstudiante = "INSERT INTO RotacionEstudiantes (idestudiantegeneral,
                                                            	codigomateria,
                                                                idsiq_convenio,
                                                                IdUbicacionInstitucion,
                                                                ServicioRotacionId,
                                                                FechaIngreso,
                                                                FechaEgreso,
                                                                codigoestado,
                                                                UsuarioCreacion,
                                                                FechaCreacion,
                                                                EstadoRotacionId,
                                                                codigoperiodo,
                                                                codigocarrera,
                                                                TotalDias) VALUES ('".$arrayRotacionEstudiante["idestudiante"] ."',
                                                                                    '".$arrayRotacionEstudiante["codmateria"]."',
                                                                                    '".$arrayRotacionEstudiante["idconvenio"]."',
                                                                                    '".$arrayRotacionEstudiante["idubicacion"]."',
                                                                                    '".$arrayRotacionEstudiante["idservicio"]."',
                                                                                    '".$arrayRotacionEstudiante["fechaingreso"]."',
                                                                                    '".$arrayRotacionEstudiante["fechaegreso"]."',
                                                                                    '100',
                                                                                    '".$arrayRotacionEstudiante["usuariocreacion"]."',
                                                                                    NOW(),
                                                                                    '".$arrayRotacionEstudiante["idedorotacion"]."',
                                                                                    '".$arrayRotacionEstudiante["codperiodo"]."',
                                                                                    '".$arrayRotacionEstudiante["codcarrera"]."',
                                                                                    '".$arrayRotacionEstudiante["diasrotacion"]."');";
        				
		if($NuevaRotacionEstudiante=&$db->Execute($SQL_NuevaRotacionEstudiante)===false){
				$a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL_NuevaRotacionEstudiante;
		}else{
		        $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';
        }
        return $a_vectt;  
    }
     ///////////////////fin guardar rotacionEstudiante
     /////////buscaridvalidos
    public function BuscarAlumnosValidos($arrayRotacionEstudiante){
        global $userid,$db;
        $SQL_buscafechas="SELECT rte2.FechaIngreso,rte2.FechaEgreso FROM RotacionEstudiantes as rte2 WHERE rte2.codigomateria='".$arrayRotacionEstudiante["codmateria"]."' AND rte2.codigoperiodo = '".$arrayRotacionEstudiante["codperiodo"]."' GROUP BY rte2.FechaIngreso";
        //echo $SQL_buscafechas;
        if($BuscaFechas=&$db->Execute($SQL_buscafechas)===false){
				echo 'ERROR '.$BuscaFechas;
		}else{
		        $rangosfechas=$BuscaFechas->GetArray();
                $encontrado=0;
                $encontradob=0;
                $idestudiantes=Array();
                $i=0;
                foreach($rangosfechas as $datosRangos){
                    if((strtotime($datosRangos["FechaIngreso"]) <= strtotime($arrayRotacionEstudiante["fechaingreso"]))&&(strtotime($datosRangos["FechaEgreso"]) >= strtotime($arrayRotacionEstudiante["fechaingreso"]))){
                      $encontrado++; 
                       
                    }else{
                        if((strtotime($datosRangos["FechaIngreso"]) <= strtotime($arrayRotacionEstudiante["fechaegreso"]))&&(strtotime($datosRangos["FechaEgreso"]) >= strtotime($arrayRotacionEstudiante["fechaegreso"]))){
                            $encontrado++;    
                        }
                    }
                    if($encontrado>$encontradob){
                        $encontradob++;
                        $SQL_alumnosenrango="SELECT rte2.idestudiantegeneral FROM RotacionEstudiantes as rte2 WHERE rte2.codigomateria='".$arrayRotacionEstudiante["codmateria"]."' AND rte2.codigoperiodo = '".$arrayRotacionEstudiante["codperiodo"]."'
                        AND rte2.FechaIngreso='".$datosRangos["FechaIngreso"]."' AND rte2.FechaEgreso='".$datosRangos["FechaEgreso"]."'";
                        //echo $SQL_alumnosenrango; 
                        if($AlumnosEnRango=&$db->Execute($SQL_alumnosenrango)===false){
                            echo "ERROR en:".$SQL_alumnosenrango;
                        }else{
                            $arregloAlumnosEnRango=$AlumnosEnRango->GetArray();
                            foreach($arregloAlumnosEnRango as $datosAlumnosEnRango){
                                    $idestudiantes[$i]=$datosAlumnosEnRango["idestudiantegeneral"];
                                    $i++;
                            }
                        }
                    }                         
                                            
                                            
                }
                                         
        }
        $arrayencontrado=array();
        $arrayencontrado["encontrados"]=$encontrado;
        $arrayencontrado["idestudiantes"]= $idestudiantes;       
        return $arrayencontrado;  
    }
     /////////fin buscaridvalidos
    ////////////////////Guardar rotaciones masivas
    public function GuardarRotacionesMasivasEstudiante($arrayRotacionEstudiante){
        global $userid,$db;
        //print_r($arrayRotacionEstudiante);
        /////cadena de exclusion de alumnos en agregado
        
        $cont=0;
        $cant_alumnosregistrados=0;
        $alumnosexcluidos="";
        $a_vectt['detalles']="ERROR";
        if(isset($arrayRotacionEstudiante["regidestudiantes"])&&(count($arrayRotacionEstudiante["regidestudiantes"])>0)){
            $cant_alumnosregistrados=count($arrayRotacionEstudiante["regidestudiantes"]);
            $alumnosexcluidos=" AND est.idestudiantegeneral NOT IN(";
            foreach($arrayRotacionEstudiante["regidestudiantes"] as $itemidalumno){
                if($cont==0)
                    $cad=$itemidalumno;
                else
                    $cad=$cad.",".$itemidalumno;
                $cont++;
            } 
            $alumnosexcluidos.=$cad.")";   
        }
        
       
       $max_idrotacionesantinsert= &$db->GetRow("SELECT max(RotacionEstudianteid)as maximoid FROM RotacionEstudiantes;");
       ///////fin de generacion de cadena
       if(isset($arrayRotacionEstudiante["idsubgrupo"])&&($arrayRotacionEstudiante["idsubgrupo"]!="")){
          $selectinsert="SELECT          est.idestudiantegeneral,
                                                                                '".$arrayRotacionEstudiante["codmateria"]."' AS codigomateria,
                                                                                '".$arrayRotacionEstudiante["idconvenio"]."' aS idsiq_convenio,
                                                                                '".$arrayRotacionEstudiante["idubicacion"]."' AS IdUbicacionInstitucion ,
                                                                                '".$arrayRotacionEstudiante["idservicio"]."' AS ServicioRotacionId,
                                                                                '".$arrayRotacionEstudiante["fechaingreso"]."' AS FechaIngreso,
                                                                                '".$arrayRotacionEstudiante["fechaegreso"]."' AS FechaEgreso,
                                                                                '100' AS codigoestado,
                                                                                '".$arrayRotacionEstudiante["usuariocreacion"]."' AS UsuarioCreacion,
                                                                                NOW() AS FechaCreacion,
                                                                                '".$arrayRotacionEstudiante["idedorotacion"]."' AS EstadoRotacionId,
                                                                                '".$arrayRotacionEstudiante["codperiodo"]."' AS codigoperiodo,
                                                                                '".$arrayRotacionEstudiante["codcarrera"]."' AS codigocarrera,
                                                                                '".$arrayRotacionEstudiante["diasrotacion"]."' AS TotalDias
                                                                                 FROM
                                                                                            SubgruposEstudiantes AS subest
                                                                                            INNER JOIN estudiantegeneral AS est ON subest.idestudiantegeneral = est.idestudiantegeneral
                                                                                            WHERE
                                                                                            subest.SubgrupoId = '".$arrayRotacionEstudiante["idsubgrupo"]."'
                                                                                            ".$alumnosexcluidos." ";
        }else{
            $selectinsert="SELECT          est.idestudiantegeneral,
                                                                                '".$arrayRotacionEstudiante["codmateria"]."' AS codigomateria,
                                                                                '".$arrayRotacionEstudiante["idconvenio"]."' aS idsiq_convenio,
                                                                                '".$arrayRotacionEstudiante["idubicacion"]."' AS IdUbicacionInstitucion ,
                                                                                '".$arrayRotacionEstudiante["idservicio"]."' AS ServicioRotacionId,
                                                                                '".$arrayRotacionEstudiante["fechaingreso"]."' AS FechaIngreso,
                                                                                '".$arrayRotacionEstudiante["fechaegreso"]."' AS FechaEgreso,
                                                                                '100' AS codigoestado,
                                                                                '".$arrayRotacionEstudiante["usuariocreacion"]."' AS UsuarioCreacion,
                                                                                NOW() AS FechaCreacion,
                                                                                '".$arrayRotacionEstudiante["idedorotacion"]."' AS EstadoRotacionId,
                                                                                '".$arrayRotacionEstudiante["codperiodo"]."' AS codigoperiodo,
                                                                                '".$arrayRotacionEstudiante["codcarrera"]."' AS codigocarrera,
                                                                                '".$arrayRotacionEstudiante["diasrotacion"]."' AS TotalDias
                                                                                 FROM
                                        	detalleprematricula AS d
                                        INNER JOIN prematricula AS p ON p.idprematricula = d.idprematricula
                                        INNER JOIN estudiante AS e ON e.codigoestudiante = p.codigoestudiante
                                        INNER JOIN estudiantegeneral AS est ON e.idestudiantegeneral = est.idestudiantegeneral
                                        WHERE
                                        	(
                                        		p.codigoestadoprematricula LIKE '1%'
                                        		OR p.codigoestadoprematricula LIKE '4%'
                                        	)
                                        AND (
                                        	d.codigoestadodetalleprematricula LIKE '1%'
                                        	OR d.codigoestadodetalleprematricula LIKE '3%'
                                        )
                                        AND d.idgrupo = '".$arrayRotacionEstudiante["idgrupo"]."'
                                        AND p.codigoperiodo = '".$arrayRotacionEstudiante["codperiodo"]."'
                                        ".$alumnosexcluidos." ";
            
            
        }
       
       
              $SQL_NuevaRotacionEstudiante = "INSERT INTO RotacionEstudiantes (idestudiantegeneral,
                                                            	codigomateria,
                                                                idsiq_convenio,
                                                                IdUbicacionInstitucion,
                                                                ServicioRotacionId,
                                                                FechaIngreso,
                                                                FechaEgreso,
                                                                codigoestado,
                                                                UsuarioCreacion,
                                                                FechaCreacion,
                                                                EstadoRotacionId,
                                                                codigoperiodo,
                                                                codigocarrera,
                                                                TotalDias) ".$selectinsert.";";
                                                                                                    
        //echo $SQL_NuevaRotacionEstudiante;exit;
        if($NuevaRotacionEstudiante=&$db->Execute($SQL_NuevaRotacionEstudiante)===false){
				$a_vectt['val'] = 'FALSE';
                $a_vectt['detalles'] = 'ERROR '.$SQL_NuevaRotacionEstudiante;
		}else{
                $ultimoidguardado=$db->Insert_ID();
                $camposafectados=0;
                ////maximo id post insert
                $max_idrotacionespostinsert= &$db->GetRow("SELECT max(RotacionEstudianteid)as maximoid FROM RotacionEstudiantes;");
                ///
                $camposafectados=(intval($max_idrotacionespostinsert[0])-intval($ultimoidguardado)+1);
                if($cant_alumnosregistrados!=$arrayRotacionEstudiante["totalalumnos"]){
                    if($camposafectados==$arrayRotacionEstudiante["totalalumnos"]){
                        $a_vectt['detalles']="se agregaron todos los registros"; 
                        $a_vectt['total_add']=$arrayRotacionEstudiante["totalalumnos"];  
                    }else{
                        $a_vectt['detalles']="Se agregaron ".$camposafectados." de ".$arrayRotacionEstudiante["totalalumnos"]." estudiantes,hay estudiantes con rotacion en ese rango de fechas";
                        $a_vectt['total_add']=$camposafectados;  
                    }  
                    
                    
                }else{
                   $a_vectt['detalles']="No se agregaron estudiantes,Todos los estudiantes de esta agrupacion tienen rotaciones en ese rango de fechas";
                   $a_vectt['total_add']=0;
                }
                
		        $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';
        }
                //print_r($a_vectt);exit;
        return $a_vectt;  
    }
     ///////////////////fin guardar rotacionEstudiante  
    ////////////////////Fin guardar rotaciones masivas
    /////////////proceso de guardado de rotacion
    public function GuardandoRotaciones($arraydatos){
        global $userid,$db;
        //$arraydatos["idrotacion"]=$this->GuardarNuevaRotacion($arraydatos);
        $a_vectt=$this->GuardarNuevaRotacionEstudiante($arraydatos);  
        return $a_vectt;
    }
    ///fin de proceso de guardado de rotacion
    
	public function Autocomplet($Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre){
		/*?>
        <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $Descripcion?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $Onclick?>();" onKeyPress="<?PHP echo $Funcion?>()" /><input type="hidden" id="<?PHP echo $id_Nombre?>" />
       
            <?php */
		}
	
	public function PrintPrograma($CodigoCarrera){
		global $userid,$db;
		
		$SQL_Carrera = 'SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM carrera
						
						WHERE
						
						codigocarrera="'.$CodigoCarrera.'"';
						
				if($Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL De Carrera....<br><BR>'.$SQL_Carrera;
						die;
					}		
					
		?>			
		<strong><?PHP echo $Carrera->fields['nombrecarrera']?></strong>				
		<?PHP
		}	
	
    public function UbicacionConvenios($IdConvenio){
        global $userid,$db;
            $sqlUbicacion= "SELECT ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM UbicacionInstituciones ui JOIN siq_convenio sc ON sc.idsiq_institucionconvenio = ui.idsiq_institucionconvenio WHERE sc.idsiq_convenio = '".$IdConvenio."'";
                         
                          $valorUbicacion = $db->execute($sqlUbicacion);
                           /*
                            
                            foreach($valorUbicacion as $datosUbicacion){
                                ?>
                                <option value="<?php echo $datosUbicacion['IdUbicacionInstitucion']?>"><?php echo $datosUbicacion['NombreUbicacion']?></option>
                                <?php
                            }*/
                            
            if(count($valorUbicacion) > 0){
                foreach($valorUbicacion as $dt){
                    $arrayarea=array();
                   // echo $dt['nombreinstitucioneducativa'];
                    $arrayarea['ubicacionrotacion']['IdUbicacionInstitucion'] = $dt['IdUbicacionInstitucion'];
                    $arrayarea['ubicacionrotacion']['NombreUbicacion'] = $dt['NombreUbicacion'];
                    
                }
                echo json_encode($arrayarea);
            }
    }
    
    public function rotacionesasignadasgrupo($idgrupo,$codperiodo){
        global $userid,$db;
        $sqlrotacionesnuevas= "SELECT
                        RotacionEstudiantes.RotacionEstudianteId
                        FROM
                        detalleprematricula AS d
                        INNER JOIN prematricula AS p ON p.idprematricula = d.idprematricula
                        INNER JOIN estudiante AS e ON e.codigoestudiante = p.codigoestudiante
                        INNER JOIN estudiantegeneral ON e.idestudiantegeneral = estudiantegeneral.idestudiantegeneral
                        INNER JOIN RotacionEstudiantes ON RotacionEstudiantes.idestudiantegeneral = estudiantegeneral.idestudiantegeneral
                        WHERE ( p.codigoestadoprematricula LIKE '1%' OR p.codigoestadoprematricula LIKE '4%' ) 
                           AND ( d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%' )
                           AND d.idgrupo = '".$idgrupo."' AND p.codigoperiodo = '".$codperiodo."'";
        $rotacionesnuevas = $db->execute($sqlrotacionesnuevas);
        if(count($rotacionesnuevas) > 0){
                
            return true;
        }else{
            return false;
        }
    }
    

}#Fin Class
?>