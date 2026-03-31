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
        <title>Reporte pagos PSE</title>
             
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
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
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
                                 $('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>	
  <html>
    <body>       	
    <div id="container">
        <h2>Reporte pagos PSE</h2>
    </div>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>OrdenPago</th>          
                        <th>NumeroDocumento</th>
                        <th>Valor</th>
                        <th>FechaSolicitud</th>
                        <th>FechaPago</th>
                        <th>Entidad</th>                        
                        <th>Estado</th>
                        <th>CodigoTransaccion</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
                   $inicial = $_POST['fechaInicial'];
                   $anio = substr($inicial, -4);
                   $dia = substr($inicial, 3,-5);
                   $mes = substr($inicial, 0, -8);
                   $finicial = $anio.'-'.$mes.'-'.$dia;
                   $final =$_POST['fechaFinal'];
                   $aniof = substr($final, -4);
                   $diaf = substr($final, 3,-5);
                   $mesf = substr($final, 0, -8);
                   $ffinal = $aniof.'-'.$mesf.'-'.$diaf;
                   
                               
               $sQl="SELECT reference1 AS OrdenPago, reference2 AS NumeroDocumento, transvalue AS Valor, solicitedate AS FechaSolicitud, bankprocessdate AS FechaPago, finame AS Entidad, stacode AS Estado, trazabilitycode AS CodigoTransaccion FROM
	LogPagos WHERE 	solicitedate BETWEEN '$finicial' AND '$ffinal'";
    
                if($Consulta=&$db->Execute($sQl)===false){
                   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
                   die;
                }   
                $valores = &$db->Execute($sQl);
                $datos =  $valores->getarray();
                $totaldatos=count($datos);
                if ($totaldatos>0){
                    $i=1;
                    foreach($valores as $datos1){
                    ?>
                        <tr>
                            <td valign="top"><?php echo $i ?></td>
                            <td valign="top"><?php echo $datos1['OrdenPago']?></td>
                            <td valign="top"><?php echo $datos1['NumeroDocumento']?></td>
                            <td valign="top"><?php echo $datos1['Valor']?></td>
                            <td valign="top"><?php echo $datos1['FechaSolicitud']?></td>
                            <td valign="top"><?php echo $datos1['FechaPago']?></td>
                            <td valign="top"><?php echo $datos1['Entidad']?></td>
                            <td valign="top"><?php echo $datos1['Estado']?></td>
                            <td valign="top"><?php echo $datos1['CodigoTransaccion']?></td>                    
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
      