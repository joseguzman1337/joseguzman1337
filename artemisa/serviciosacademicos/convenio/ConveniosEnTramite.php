<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    $db = getBD();
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();

    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];

    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,1);
    $Acceso2 = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,13);
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="./css/style.css" rel="stylesheet"> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Convenios En trámite</title>
             
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
            <center><h1>CONVENIOS EN TRAMITE</h1></center>
        </div>
        <div id="demo">
            <form action="MenuConvenios.php">
                <input type="submit" id="regresar" name="regresar" value="REGRESAR" />
            </form>
            <?php
            switch($Acceso2[Rol])
            {
                case '9'://Administrador Convenios Internacionales
                {
                  $ambito = "where SC.ambito = '2'"; 
                    
                }break;
                case '10'://Administrador Convenios Nacionales 
                {
                  $ambito = "where SC.ambito = '1'";  
                }break;
                default:
                {
                    $ambito = "";
                }break;
            }
             
            ?>
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                       <!-- <th>Código Convenio</th>-->
                        <th>Nombre Convenio</th>
                        <th>Programa académico</th>
                        <th>Responsable Convenio</th>
                        <th>Correo Responsable</th>          
                        <th>Fecha inicio trámite</th>
                        <th>Ambito</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Linea de <br/>Tiempo</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
			
                $sqlpropuestas = "SELECT 
										co.ConvenioId,
										IF(co.NombreConvenio IS NULL, SC.NombreInstitucion,co.NombreConvenio) as nombreConvenio,
										c.nombrecarrera,
										SC.ResponsableConvenio,
										SC.CorreoResponsableConvenio,
										SC.FechaEnvioSolicitud,
										SC.FechaCreacion,
                                        SC.SolicitudConvenioId,
										U.usuario,
                                        cp.Nombre,
                                        cp.ConvenioProcesoId,
                                        SC.ambito                                        
									FROM
										SolicitudConvenios SC 
									INNER JOIN usuario U ON ( U.idusuario = SC.UsuarioCreacion ) 
									INNER JOIN SolicitudConvenioCarrera scc on scc.SolicitudConvenioId=SC.SolicitudConvenioId AND scc.CodigoEstado=100  
									INNER JOIN carrera c on c.codigocarrera=scc.codigocarrera
									LEFT JOIN RelacionSolicitudConvenio rsc on rsc.SolicitudConvenioId=SC.SolicitudConvenioId AND rsc.CodigoEstado=100
									LEFT JOIN Convenios co on co.ConvenioId=rsc.ConvenioID
                                    INNER JOIN ConvenioProceso cp ON cp.ConvenioProcesoId = SC.ConvenioProcesoId ".$ambito."                                    
									order by ConvenioProcesoId DESC";                                                                        
                $Consulta=$db->GetAll($sqlpropuestas);
                foreach($Consulta as $datos1){
                    ?>
                        <tr>
                            <!--<td valign="top"><?php echo $datos1['CodigoConvenio']?></td>-->
                            <td valign="top"><?php echo $datos1['nombreConvenio']?></td>
                            <td valign="top"><?php echo $datos1['nombrecarrera']?></td>
                            <td valign="top"><?php echo $datos1['ResponsableConvenio']?></td>
                            <td valign="top"><?php echo $datos1['CorreoResponsableConvenio']?></td>
                            <td valign="top"><?php echo $datos1['FechaEnvioSolicitud']?></td>
                            <td valign="top"><?php if($datos1['ambito']== '1'){ echo "Internacional";} if($datos1['ambito']== '2'){ echo "Nacional";}?></td>
                            <td valign="top"><?php echo $datos1['Nombre'];//$datos1['nombreestado']?></td>
                            <td valign="top">
                            <?php
                                if($Acceso2['Rol']==12){
                                    if($datos1['ConvenioProcesoId']== '6' || $datos1['ConvenioProcesoId']== '7' || $datos1['ConvenioProcesoId']== '3' || $datos1['ConvenioProcesoId']== '13')
                                    {
                                        $dato = "procesofirmas.php";
                                    }
                                    else
                                    {
                                        $dato = "VistaPropuesta.php";
                                    }
                                }
                                else
                                {
                                    $dato = "VistaPropuesta.php";
                                }
                            ?>
			                    <form action="<?php echo $dato ?>" method="post">                               
                                <input type="hidden" id="id" name="id" value="<?php echo $datos1['SolicitudConvenioId']?>" />
                                <input type="submit" id="detalles" name="detalles" value="Detalles" />
                                </form>
                            </td>
                            <td valign="top"><form action="lineatiempo/lineatiempo.php" method="post">
                            <input type="hidden" id="id" name="id" value="<?php echo $datos1['SolicitudConvenioId']?>" />
                            <input type="submit" id="lineatiempo" name="lineatiempo" value="Linea tiempo" /></form>
                            </td>
						</tr>
                    <?php      
                    }//foreach
            ?>                     
            </tbody>
        </table>
    </div>
  </body>
</html>
      