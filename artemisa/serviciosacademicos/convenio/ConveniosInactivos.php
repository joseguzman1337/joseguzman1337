<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista Convenios</title>
             
         <style type="text/css" title="currentStyle">
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
                
        </style>
        <script type='text/javascript' language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../consulta/estadisticas/riesgos/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/jquery.modal.js"></script>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columnas",
                                           "aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools = new TableTools( oTable, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Imprimir" }
        					]
        		         });
                                 $('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>	
  <html>
    <body>       	
    <div id="container">
        <center><h1>CONVENIOS INACTIVOS</h1></center>
    </div>
    <div id="demo">
	<form action="MenuConvenios.php">
    <input type="submit" name="MenuConvenio" id="MenuConvenio" value="MENU" />
	</form>
     <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>Codigo Convenio</th>
                        <th>Nombre Convenio</th>          
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
                $sQl="SELECT c.ConvenioId,	c.CodigoConvenio,	c.NombreConvenio,	c.FechaInicio,	c.FechaFin,	e.nombreestado FROM	Convenios c JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio where c.idsiq_estadoconvenio = '3'";
                if($Consulta=&$db->Execute($sQl)===false)
                {
                   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
                   die;
                }   
                $valores = &$db->Execute($sQl);
                $datos =  $valores->getarray();
                $totaldatos=count($datos);
                if ($totaldatos>0){
                    foreach($valores as $datos1){
                    ?>
                        <tr>
                            <td valign="top"><?php echo $datos1['CodigoConvenio']?></td>
                            <td valign="top"><?php echo $datos1['NombreConvenio']?></td>
                            <td valign="top"><?php echo $datos1['FechaInicio']?></td>
                            <td valign="top"><?php echo $datos1['FechaFin']?></td>
                            <td valign="top"><?php echo $datos1['nombreestado']?></td>
                            <td valign="top">
                                <form action="DetalleConvenio.php" method="post">
                                    <input type="hidden" name="Detalle" id="Detalle" value="<?php echo $datos1['ConvenioId']?>" />
                                    <input type="image" src="../mgi/images/file_search.png" width="20">
                                </form>
                            </td>
                    <?php           
                    $i++; 
                    }//foreach
                }//if
            ?>                     
            </tbody>
        </table>
    </div>
  </body>
</html>
      