<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include_once ('../../../../EspacioFisico/templates/template.php');
$db = getBD();

$ubicacion = $_REQUEST['ubicacion'];
$periodo = $_REQUEST['codigoperiodo'];
$carrera = $_GET['carrera'];
$idgrupo= $_GET['idgrupo'];
$idsubgrupo=$_GET['idsubgrupo'];
?>
<!DOCTYPE HTML>
<html>
    <head>
       
        <link rel="stylesheet" href="../../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css" title="currentStyle">
                @import "../../../../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
                @import "../../../../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
                @import "../../../../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
                @import "../../../../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
                @import "../../../../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
                
        </style>
        
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>         
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functionsMonitoreo.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../../../consulta/estadisticas/riesgos/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../../../consulta/estadisticas/riesgos/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../../../consulta/estadisticas/riesgos/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../../../consulta/estadisticas/riesgos/data/media/js/jquery.modal.js"></script>
         <script type="text/javascript" language="javascript" src="js/funcionesRotaciones.js"></script>
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
                
          function filtrosubgrupo(idsubgrupo){
            if(idsubgrupo==""){
                 
                window.location='ReporteRotacionesgrupos.php?idgrupo=<?php echo $idgrupo."&codigoperiodo=".$periodo; ?>';
            }else{
                if(idsubgrupo=="todos"){
                    $("#sel_subgrupo").val('');
                    window.location='ReporteRotacionesgrupos.php?idgrupo=<?php echo $idgrupo."&codigoperiodo=".$periodo; ?>';                                        
                                        
                    
                 }else{
                    window.location='ReporteRotacionesgrupos.php?&idgrupo=<?php echo $idgrupo."&codigoperiodo=".$periodo; ?>&idsubgrupo='+idsubgrupo+'';
                       
                                    
                 }
               
                
            }
            
        }
        	/**************************************************************/
        </script>
    </head>
    <body>       	
    <div id="container">
   
        <center><h2>REPORTE ROTACIONES AGRUPACIONES</h2></center>
        <div style="text-align: left;">Subgrupos:
            <select id="sel_subgrupo" name="sel_subgrupo" onchange="filtrosubgrupo(this.value)">
                <option value="null" >Selecciones:</option>
                <option value="todos" >Todos</option>
                <?php
                    $sqlSubgrupo= "SELECT   *  FROM Subgrupos WHERE idgrupo='".$idgrupo."'";
                    echo $sqlSubgrupo;
                    if($valorSubgrupo = &$db->execute($sqlSubgrupo)===false){
                        echo 'Error en Consulta...<br><br>'.$SQL;
                        die;
                    }
                    $subgruposids=$valorSubgrupo->GetArray();
                    foreach($subgruposids as $datosSubgrupo)
                    {
                        ?>
                        <option value="<?php echo $datosSubgrupo['SubgrupoId']?>"><?php echo $datosSubgrupo['NombreSubgrupo']?></option>
                        <?php
                    }
                ?>                    
            </select>
        </div>
        <?php
      
            if(!empty($carrera))
            {
                $sqlreporte = " AND r.codigocarrera ='".$carrera."' and r.codigomateria = '".$Materia."'";
                $sqlmateria ="select c.nombrecarrera, m.nombremateria from materia m JOIN carrera c on c.codigocarrera = m.codigocarrera where m.codigocarrera = '".$carrera."' and m.codigomateria = '".$Materia."'";
                $valormateria = $db->execute($sqlmateria);
                foreach($valormateria as $datosmateria){
                ?>
                <center><?php echo $datosmateria['nombrecarrera']." ".$datosmateria['nombremateria']." ";?><br /><?php  echo 'Periodo: '.$periodo?></center><br />
                <?php
                }    
            }else{
                if(!empty($idsubgrupo))
                {
                    $consultaestudiantegeneral  ="INNER JOIN SubgruposEstudiantes se ON se.idestudiantegeneral = e.idestudiantegeneral";
                    $sqlreporte.=" AND se.SubgrupoId='".$idsubgrupo."' ";
                }
            }
        ?>
   </div>
    <div id="demo">
           <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cedula</th>          
                        <th>Nombres</th>
                        <th>Semestre</th>
                        <th>servicio</th>
                        <th>Fecha ingreso</th>
                        <th>Fecha egreso </th>
                        <th>total dias</th> 
                        
                   </tr>
                </thead>
            <tbody>  
            <?php
            
            $Sqlrotaciones="SELECT r.RotacionEstudianteId, r.codigoestudiante, m.nombremateria, sc.NombreConvenio, u.NombreUbicacion, sr.NombreServicio, r.FechaIngreso, r.FechaEgreso,
	r.codigoestado,	er.NombreEstado, r.codigoperiodo, c.nombrecarrera, r.TotalDias, c.codigocarrera, r.idsiq_convenio, r.IdUbicacionInstitucion, e.idestudiantegeneral 
    FROM
    RotacionEstudiantes r
    INNER JOIN estudiante e ON e.codigoestudiante = r.codigoestudiante
    INNER JOIN UbicacionInstituciones u ON u.IdUbicacionInstitucion = r.IdUbicacionInstitucion
    INNER JOIN Convenios sc on sc.ConvenioId = r.idsiq_convenio
    INNER JOIN ServicioRotaciones sr ON sr.ServicioRotacionId = r.ServicioRotacionId
    INNER JOIN materia m  ON m.codigomateria = r.codigomateria
    INNER JOIN carrera c ON c.codigocarrera = r.codigocarrera
    INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = r.EstadoRotacionId
    ".$consultaestudiantegeneral." 
    WHERE
    r.codigoperiodo = '".$periodo."'
    ".$sqlreporte;
                
                //echo $Sqlrotaciones.'<br>';
                if($Consulta=$db->Execute($Sqlrotaciones)===false){
                   echo 'Error en el SQL de la Consulta....<br><br>'.$Sqlrotaciones;
                   die;
                }   
                $valoresrotacion = $db->Execute($Sqlrotaciones);
                $datos =  $valoresrotacion->getarray();
                $totaldatos=count($datos);
                if ($totaldatos>0)
                {
                    $i=1;
                    foreach($valoresrotacion as $datosrotacion)
                    { 
                      $sqlestudiante = "SELECT e.semestre, e.codigoperiodo, e.numerocohorte, e.codigoestudiante, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento FROM estudiante e, estudiantegeneral eg WHERE e.idestudiantegeneral = '".$datosrotacion['idestudiantegeneral']."' AND e.codigocarrera = '".$datosrotacion['codigocarrera']."' and eg.idestudiantegeneral = e.idestudiantegeneral ";
                      //echo $sqlestudiante.'<br>';
                        $valoresestduiante = $db->execute($sqlestudiante);
                        foreach($valoresestduiante as $datosestudiantes)
                        {
                            ?>
                             <tr>
                                <td valign="top"><?php echo $i ?></td>
                                <td valign="top"><?php echo $datosestudiantes['numerodocumento']?></td>
                                <td valign="top"><?php echo $datosestudiantes['nombresestudiantegeneral']." ".$datosestudiantes['apellidosestudiantegeneral']?></td>
                                <td valign="top"><?php echo $datosestudiantes['semestre']?></td>
                                <td valign="top"><?php echo $datosrotacion['NombreServicio']?></td>
                                <td valign="top"><?php echo $datosrotacion['FechaIngreso']?></td>
                                <td valign="top"><?php echo $datosrotacion['FechaEgreso']?></td>
                                <td valign="top"><?php echo $datosrotacion['TotalDias']?></td>
                            
                                          <?php
                                  
                        }//foreach        
                    $i++; 
                    }//foreach
                }//if
                
            ?>    
                                                
            </tbody>
        </table>
        <input type="button" name="regresar" id="regresar" value="Regresar" onclick="location.href='../detallesmateria.php?codigomateria1=<?php echo $_GET["codigomateria1"];?>&carrera1=<?php echo $_GET["carrera1"];?>'"/>
        
        
        
     </div>
  </body>
</html>
      