<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    include_once ('./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once('_menuConvenios.php');
    $db = getBD();


    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];

    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,1);
    //echo 'variables de sala<br>';
    //var_dump($db);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="./css/style.css" rel="stylesheet"> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista Convenios</title>
             
         <style type="text/css" title="currentStyle">
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
                table#example1 tr td,table#example1 tr th{
					border:1px solid #000;
					padding: 8px 5px;
				}
				table#example1 tr th{
				  background-color: #dde;
				}
        </style>
		<link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
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
        			
        			oTable1 = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columnas",
                                           "aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools1 = new TableTools( oTable1, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Imprimir" }
        					]
        		         });
                         
                         $('#demo').before( oTableTools1.dom.container );
                                
        		} );  
        	/**************************************************************/
        </script>	
  <html>
    
    <body class="body"> 
    <div id="pageContainer">
	<?php//  writeMenu(0); ?>  
    <div id="container">
        <center><h1>CONVENIOS PRÓXIMOS A VENCER</h1></center>
    
    <div name="demo1">
          <table cellpadding="0" cellspacing="0" border="1" class="display" id="example1">
                <thead>
                    <tr>
                        <th>Código Convenio</th>
                        <th>Nombre Convenio</th>
                        <th>Tipo Convenio</th>
                        <th>Ambito</th> 
                        <th>Facultad</th>          
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
                $anio = date("Y");
                $mes = date("m");
                $dia = date("d");
                $fecha1 = $anio."-".$mes."-".$dia;
                $mes2 = ($mes + 6);
                if($mes2 >12)
                {   
                    $mes2 = $mes2 - 12;
                    $anio = $anio + 1;
                }
                $fecha = $anio."-".$mes2."-".$dia;
                
                $sQl="SELECT c.ConvenioId,	c.CodigoConvenio,	c.NombreConvenio,	c.FechaInicio,	c.FechaFin,	e.nombreestado, t.nombretipoconvenio, c.Ambito FROM Convenios c JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio join siq_tipoconvenio t on t.idsiq_tipoconvenio = c.idsiq_tipoconvenio where (c.idsiq_estadoconvenio = '1') and (c.FechaFin <  NOW() or  c.FechaFin between '".$fecha1."' and '".$fecha."')";
                          
                $valores = $db->GetAll($sQl);                
                $totaldatos=count($valores);
                if ($totaldatos>0){
                    foreach($valores as $datos1){
                    ?>
                        <tr>
                            <td valign="top" class="center"><?php echo $datos1['CodigoConvenio']?></td>
                            <td valign="top"><?php echo $datos1['NombreConvenio']?></td>
                            <td valign="top" class="center"><?php echo $datos1['nombretipoconvenio']?></td>
                            <?php switch($datos1['Ambito'])
                            {
                                case '1':
                                {
                                    ?>
                                    <td valign="top" class="center">Internacional</td>
                                    <?php
                                }
                                break;
                                case '2':
                                {
                                    ?>
                                    <td valign="top" class="center">Nacional</td>
                                    <?php
                                }
                                break;
                                default:
                                {
                                   ?>
                                    <td valign="top" class="center">---</td>
                                    <?php 
                                }
                                break;
                            }?>
                            <td valign="top"><ul>
                            <?php
                                $sqlfacultad = "select DISTINCT f.nombrefacultad from Convenios c INNER JOIN conveniocarrera cc ON cc.ConvenioId = c.ConvenioId INNER JOIN carrera ca ON ca.codigocarrera = cc.codigocarrera INNER JOIN facultad f ON ca.codigofacultad = f.codigofacultad where c.ConvenioId = '".$datos1['ConvenioId']."';";
                                $facultad = $db->GetAll($sqlfacultad);
                                foreach($facultad as $lista)
                                {
                                    ?>
                                   <li><?php echo $lista['nombrefacultad']?></li> 
                                    <?php
                                } 
                            ?></ul>
                            </td>
                            <td valign="top" class="center"><?php echo $datos1['FechaInicio']?></td>
                            <td valign="top" class="center"><?php echo $datos1['FechaFin']?></td>
                            <td valign="top" class="center"><?php echo $datos1['nombreestado']?></td>
                            <td valign="top" class="center">
                                <form action="DetalleConvenio.php" method="post">
                                    <input type="hidden" name="Detalle" id="Detalle" value="<?php echo $datos1['ConvenioId']?>" />
                                    <input type="image" src="../mgi/images/file_search.png" width="20">
                                </form>
                            </td>
                    <?php           
                    $i++; 
                    }//foreach
                }//if
                else{
                    ?>
                    <tr>
                    <td colspan="9" align="center">
                        <strong>No hay convenios proximos a vencer.</strong>
                    </td>
                    </tr>
                    <?php
                }
            ?>                     
            </tbody>
        </table>
    </div>
    </div>  	
    <div id="container">
        <center><h1>CONVENIOS ACTIVOS</h1></center>
    <div id="demo">
    <table><tr>
    <?php if($Acceso['Rol']!=3){?>
    <td><form action="NuevoConvenio.php">
    <input type="submit" name="NuevoConvenio" id="NuevoConvenio" value="CREAR CONVENIO" />
    </form></td>
    <?php }?>
    <td><form action="MenuConvenios.php">
        <input type="submit" id="regresar" name="regresar" value="REGRESAR" />
    </form></td>
    </tr>
	</table>
           <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>Código Convenio</th>
                        <th>Nombre Convenio</th>
                        <th>Tipo Convenio</th>
                        <th>Ambito</th> 
                        <th>Facultad</th>            
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
                $sQl="SELECT c.ConvenioId, c.CodigoConvenio,   c.NombreConvenio,   c.FechaInicio,  c.FechaFin, e.nombreestado, t.nombretipoconvenio, c.Ambito FROM   Convenios c JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio join siq_tipoconvenio t on t.idsiq_tipoconvenio = c.idsiq_tipoconvenio WHERE c.idsiq_estadoconvenio = '1' order by ConvenioId desc";  
                $valores = $db->GetAll($sQl);
                $totaldatos=count($valores);
                if ($totaldatos>0){
                    foreach($valores as $datos1){
                    ?>
                        <tr>
                            <td valign="top"><?php echo $datos1['CodigoConvenio']?></td>
                            <td valign="top"><?php echo $datos1['NombreConvenio']?></td>
                            <td valign="top"><?php echo $datos1['nombretipoconvenio']?></td>
                            <?php switch($datos1['Ambito'])
                            {
                                case '1':
                                {
                                    ?>
                                    <td valign="top" class="center">Internacional</td>
                                    <?php
                                }
                                break;
                                case '2':
                                {
                                    ?>
                                    <td valign="top" class="center">Nacional</td>
                                    <?php
                                }
                                break;
                                default:
                                {
                                   ?>
                                    <td valign="top" class="center">---</td>
                                    <?php 
                                }
                                break;
                            }?>
                            <td valign="top"><ul>
                            <?php
                                $sqlfacultad = "select DISTINCT f.nombrefacultad from Convenios c INNER JOIN conveniocarrera cc ON cc.ConvenioId = c.ConvenioId INNER JOIN carrera ca ON ca.codigocarrera = cc.codigocarrera INNER JOIN facultad f ON ca.codigofacultad = f.codigofacultad where c.ConvenioId = '".$datos1['ConvenioId']."';";
                                $facultad = $db->GetAll($sqlfacultad);
                                foreach($facultad as $lista)
                                {
                                    ?>
                                   <li><?php echo $lista['nombrefacultad']?></li> 
                                    <?php
                                } 
                            ?></ul>
                            </td>
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
    </div>
    </div>
  </body>
</html>
      