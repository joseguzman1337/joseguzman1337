<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

<style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                /*@import "data/media/css/themes/le-frog/jquery-ui-1.9.2.custom.css";*/
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                
</style>
    
	<script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
    
<script type="text/javascript" language="javascript">
	/****************************************************************/
	$(document).ready( function () {
			
			oTable = $('#xxxx').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo2').before( oTableTools.dom.container );
		} );
	/**************************************************************/

</script>	


<script>
	function Ventana(){
		/******************************************************/
		
		
		getemail=dhtmlmodal.open('newsletterbox', 'ajax', 'PruebaVentana.php?actionID=Ventana', 'Prueba', 'width=1500px, height=600px, left=50,right=0, resize=0,top=50%,overflow:scroll,overflow-x:scroll'); return false;
		/******************************************************/
		}
</script>
<?PHP 
switch($_REQUEST['actionID']){
	case 'Ventana':{
		VentanaTabla();
		}exit;
	}
function VentanaTabla(){
	?>
<div id="demo2">    
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="xxxx">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Codigo Estudiante</th>
                <th>Nombre Carrera</th>
                <th>Codigo Materia</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>&nbsp;</th> 
                <th>&nbsp;</th> 
                <th>&nbsp;</th> 
                <th>&nbsp;</th> 
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>1</td>               
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
       </tbody>         
    </table>
</div>    	
    <?PHP
	}
?>

<input type="button" value="..." onClick="Ventana()">


