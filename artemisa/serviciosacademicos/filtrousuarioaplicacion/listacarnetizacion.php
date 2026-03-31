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
        <title>Listado de carnetizacion</title>
             
         <style type="text/css" title="currentStyle">
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
                
        </style>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
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
         	
<div id="container">
    <h2>Reporte usuarios activos</h2>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>numero</th>          
                        <th>nombremodalidadacademica</th>
                        <th>nombrecarrera</th>
                        <th>total_carnets</th>
                        <th>total_matriculados_nuevos</th>
                         
                    </tr>
                </thead>
            <tbody>  
            <?php
            
                if(!empty($_POST['codigomodalidadacademica'])){
                    $modalidad = $_POST['codigomodalidadacademica'];
                    if(!empty($_POST['codigoperiodo'])){
                        $periodo = $_POST['codigoperiodo'];
                    }
                } else{
                    ?>
                    <script language="JavaScript" type="text/javascript">
                            alert("Sin datos para consulta, por favor complete los datos");
                    </script><meta http-equiv=refresh content=0;URL=buscarcarnetizacion.php><?php
                }
                
                $sQl="SELECT nombremodalidadacademica,nombrecarrera, SUM(total_carnets) as total_carnets, SUM(total_matriculados_nuevos) as total_matriculados_nuevos FROM 
                (
                (
                    SELECT codigocarrera,codigomodalidadacademica, nombremodalidadacademica,nombrecarrera, COUNT(numerodocumento) as total_carnets, 0 as total_matriculados_nuevos FROM
                    (
                        select eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral, eg.emailestudiantegeneral,c.nombrecarrera,c.codigocarrera,e.codigoestudiante, te.fechaactivaciontarjetaestudiante, moda.nombremodalidadacademica,c.codigomodalidadacademica  from prematricula pr 
                        inner join estudiante e on e.codigoestudiante=pr.codigoestudiante INNER JOIN carrera c on c.codigocarrera=e.codigocarrera INNER JOIN modalidadacademica moda on moda.codigomodalidadacademica=c.codigomodalidadacademica and c.codigomodalidadacademica='$modalidad' inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral  
                        INNER JOIN tarjetaestudiante te on te.idestudiantegeneral=eg.idestudiantegeneral and te.codigoestado=100 INNER JOIN estudianteestadistica ee on ee.codigoestudiante=e.codigoestudiante and ee.codigoprocesovidaestudiante= 400 and ee.codigoperiodo=pr.codigoperiodo and ee.codigoestado like '1%' 
                        WHERE pr.codigoperiodo='$periodo' and pr.codigoestadoprematricula IN (40,41)
                        ORDER BY c.nombrecarrera,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
                    ) AS x
                    GROUP BY x.codigocarrera
                ) 
                union all
                (
                    SELECT codigocarrera,codigomodalidadacademica, nombremodalidadacademica,nombrecarrera, 0 as total_carnets, COUNT(numerodocumento) as total_matriculados_nuevos FROM 
                    (
                        select eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral, eg.emailestudiantegeneral,c.nombrecarrera,c.codigocarrera,e.codigoestudiante, moda.nombremodalidadacademica,c.codigomodalidadacademica  from prematricula pr 
                        inner join estudiante e on e.codigoestudiante=pr.codigoestudiante INNER JOIN carrera c on c.codigocarrera=e.codigocarrera INNER JOIN modalidadacademica moda on moda.codigomodalidadacademica=c.codigomodalidadacademica  and c.codigomodalidadacademica='$modalidad'
                        inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral INNER JOIN estudianteestadistica ee on ee.codigoestudiante=e.codigoestudiante and ee.codigoprocesovidaestudiante= 400
                        and ee.codigoperiodo=pr.codigoperiodo and ee.codigoestado like '1%' WHERE pr.codigoperiodo='$periodo' and pr.codigoestadoprematricula IN (40,41)
                        ORDER BY c.nombrecarrera,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
                    ) AS x
                    GROUP BY x.codigocarrera
                ) 
                ) AS t
                GROUP BY t.codigocarrera
                ORDER BY t.codigomodalidadacademica,t.nombrecarrera ASC";
    
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
                            <td valign="top"><?php echo $datos1['nombremodalidadacademica']?></td>
                            <td valign="top"><?php echo $datos1['nombrecarrera']?></td>
                            <td valign="top"><?php echo $datos1['total_carnets']?></td>
                            <td valign="top"><?php echo $datos1['total_matriculados_nuevos']?></td>
                        </tr>
                        <?php              
                    $i++; 
                    }//foreach
                }//if
            ?>                     
            </tbody>
        </table>
    </div>
</div>  
<?php    
writeFooter();
?>       