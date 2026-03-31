<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    /*if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }*/
$db = getBD();
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>reporte Centro de Lenguas</title>
             
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
    <h2>Reporte Centro de Lenguas</h2>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>numero</th>
                        <th>Id estudiante</th>          
                        <th>Cod. estudiante</th>
                        <th>Cod. periodo</th>
                        <th>Cod. carrera</th>
                        <th>Nombre carrera</th>
                        <th>Nombre</th>
                        <th>Numero documento</th>
                        <th>Email estudiante</th>
                        <th>Semestre</th>
                        <th>fecha</th>
                        <th>numero orden</th>
                        <th>Nombre curso o actividad</th>
                        <th>Nivel del curso</th>
                        <th>Nota</th>
                    </tr>
                </thead>
            <tbody>  
            <?php
                if(!empty($_POST['codigoperiodoinicial'])){
                    $PeriodoInicial = $_POST['codigoperiodoinicial'];
                    if(!empty($_POST['codigoperiodofinal'])){
                         $PeriodoFinal = $_POST['codigoperiodofinal'];
                    }else{
                    $PeriodoFinal = $_POST['codigoperiodoinicial'];    
                    }
                } else{
                    ?>
                    <script language="JavaScript" type="text/javascript">
                            alert("Sin datos para consulta, por favor complete los datos");
                    </script><meta http-equiv=refresh content=0;URL=CursosCentroLenguas.php><?php
                }
                
                 $sQl="select DISTINCT eg.idestudiantegeneral, e.codigoestudiante, eg.numerodocumento, eg.emailestudiantegeneral, CONCAT (eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral)as nombre_estudiante, 
                    eg.numerodocumento, e.codigocarrera, e.codigoperiodo from estudiantegeneral eg INNER JOIN estudiante e on e.idestudiantegeneral = eg.idestudiantegeneral 
                    INNER JOIN carrera c on c.codigocarrera = e.codigocarrera INNER JOIN prematricula pm ON pm.codigoestudiante = e.codigoestudiante INNER JOIN ordenpago op ON op.idprematricula = pm.idprematricula where 
                   (e.codigoperiodo BETWEEN '$PeriodoInicial' and '$PeriodoFinal')AND pm.codigoperiodo = e.codigoperiodo AND op.codigoperiodo = e.codigoperiodo 
                                     and c.codigocentrobeneficio = 'FE000490' and pm.codigoestadoprematricula in ('40', '10')  and op.codigoestadoordenpago in ('40', '10')";
                    
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
                       if($idestudiante <> $datos1['idestudiantegeneral'] or $i==1){
                       ?> 
                            <tr>
                                <td valign="top"><?php echo $i ?></td>
                                <td valign="top"><?php echo $datos1['idestudiantegeneral']?></td>
                                <td valign="top"><?php echo $datos1['codigoestudiante']?></td>
                                <td valign="top"><?php echo $datos1['codigoperiodo']?></td>
                                
                                    <?php
                                        $sqlCarrera= "SELECT c.codigocarrera, c.nombrecarrera from carrera c JOIN estudiante e ON e.codigocarrera = c.codigocarrera 
                                        where idestudiantegeneral ='".$datos1['idestudiantegeneral']."' and c.codigocentrobeneficio <> 'FE000490' ";//AND c.codigomodalidadacademica = '200'
                                        $valoresCarrera = &$db->Execute($sqlCarrera);
                                        $datosCarrera =  $valoresCarrera->getarray();
                                        ?>
                                        <td valign="top">
                                            <ul>
                                        <?php
                                        foreach($valoresCarrera as $codigocarrera)
                                        {
                                            ?> 
                                                <li><?php echo $codigocarrera['codigocarrera']?></li>
                                            <?php
                                        }
                                        ?>
                                            </ul>
                                        </td>
                                        <td valign="top">
                                            <ul>      
                                        <?php
                                        foreach($valoresCarrera as $nombrecarrera)
                                        {
                                            ?> 
                                                <li><?php echo $nombrecarrera['nombrecarrera']?></li>
                                            <?php
                                        }
                                        ?>
                                            </ul>
                                        </td>
                                        
                                <td valign="top"><?php echo $datos1['nombre_estudiante']?></td>
                                <td valign="top"><?php echo $datos1['numerodocumento']?></td>
                                <td valign="top"><?php echo $datos1['emailestudiantegeneral']?></td>
                                <?php
                                
                                 $id = $datos1['codigoestudiante'];
                                 $carrera= $datos1['codigocarrera'];
                                 $sql2= "select DISTINCT pm.semestreprematricula, op.fechaordenpago, op.numeroordenpago, c.nombrecortocarrera, m.nombremateria, m.codigomateria                        
                                        from prematricula pm
                                        INNER JOIN ordenpago op ON op.idprematricula = pm.idprematricula
                                        INNER JOIN detalleprematricula dpm ON dpm.idprematricula = pm.idprematricula
                                        INNER JOIN materia m ON m.codigomateria = dpm.codigomateria
                                        INNER JOIN carrera c ON c.codigocarrera =  m.codigocarrera
                                        where pm.codigoestudiante = '$id' 
                                        and pm.idprematricula = dpm.idprematricula
                                        and (pm.codigoperiodo BETWEEN '$PeriodoInicial' and '$PeriodoFinal') 
                                        and op.codigoperiodo = pm.codigoperiodo
                                        and pm.codigoestadoprematricula in ('40', '10') 
                                        and op.codigoestadoordenpago in ('40', '10')";
                                    $valores2 = &$db->Execute($sql2);
                                    $datos2 = $valores2->getarray();
                                    if(!empty($datos2)){
                                        ?> 
                                        <td valign="top">
                                            <ul>
                                        <?php
                                        foreach($valores2 as $semestre)
                                        {
                                         ?>
                                         <li><?PHP echo $semestre['semestreprematricula'];?></li>
                                          <?php
                                        }
                                        ?> 
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                        <?php 
                                        foreach($valores2 as $fecha)
                                        {
                                         ?>
                                         <li><?PHP echo $fecha['fechaordenpago'];?></li>
                                          <?php
                                        }
                                        ?> 
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                        <?php
                                        foreach($valores2 as $orden)
                                        {
                                         ?>
                                         <li><?PHP echo $orden['numeroordenpago'];?></li>
                                          <?php
                                        }
                                        ?> 
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                        <?php
                                        foreach($valores2 as $nombrecarrera)
                                        {
                                         ?> 
                                         <li><?PHP echo $nombrecarrera['nombrecortocarrera'];?></li>
                                         <?php
                                        }
                                        ?> 
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                        <?php
                                        foreach($valores2 as $nivel)
                                        {
                                         ?> 
                                         <li><?PHP echo $nivel['nombremateria'];?></li>
                                         <?php
                                        }
                                        ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                        <?php
                                        foreach($valores2 as $materia){
                                            $sqlnota = "SELECT DISTINCT notadefinitiva FROM notahistorico where  codigomateria='".$materia['codigomateria']."' 
                                            and (codigoperiodo BETWEEN '$PeriodoInicial' and '$PeriodoFinal') and codigoestudiante='$id'";
                                            $valoresNota = &$db->Execute($sqlnota);
                                            $datosNota = $valoresNota->getarray();
                                            foreach($valoresNota as $nota)
                                                {
                                                 ?> 
                                                 <li><?PHP echo $nota['notadefinitiva'];?></li>
                                                 <?php
                                                }
                                        }
                                         ?>
                                            </ul>
                                        </td>
                                        <?php
                                  }else{
                                        ?> 
                                        <td valign="top">---</td>
                                        <td valign="top">---</td>
                                        <td valign="top">---</td>
                                        <td valign="top">---</td>
                                        <td valign="top">---</td> 
                                        <td valign="top">---</td>     
                                            <?php
                                    }                                
                                    ?>
                        </tr>
                        <?php
                        $idestudiante = $datos1['idestudiantegeneral'];
                        $i++;
                        }                   
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