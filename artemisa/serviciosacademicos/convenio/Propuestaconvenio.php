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
    $Usario_id=&$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];
    
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,4);
    //echo '<pre>'; print_r($Acceso);
    $Acceso2 = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,8);
    //echo '<pre>'; print_r($Acceso2);
    
    if($Acceso['val']===false && $Acceso2['val']===false ){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <link rel="stylesheet" href="cssEmail/style.css" type="text/css" />
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista de Solicitudes Convenios</title>
        <style type="text/css" title="currentStyle">
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
        </style>
		<link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="./css/style.css" rel="stylesheet"> 
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
    </head>
    <body class="body"> 
    <div id="pageContainer">
	<?php 
    //writeMenu(2);
    /*$Menu = $C_Permisos->PermisoUsuarioConvenio($db,$userid,2,4);
    
    for($i=0;$i<count($Menu['Data']);$i++){
        $URL[]    = $Menu['Data'][$i]['Url'];
        
        $Nombre[] = $Menu['Data'][$i]['Nombre'];
        
        if($Menu['Data'][$i]['ModuloSistemaId']==4){
            $Active[] = '1';    
        }else{
            $Active[] = '0';
        }
    }//for
    
    $C_Menu_Global->writeMenu2($URL,"Sistema de Convenios",$Nombre,$Active);*/
    ?>  
    <div id="container">
        <center><h1>SOLICITUDES DE CONVENIOS</h1></center>
    </div>
    <div id="demo">
    <form action="nuevapropuesta.php">
        <input type="submit" id="NuevaPropuesta" value="Nueva Solicitud" />
    </form>
    
        <table cellpadding="0" cellspacing="0" border="1" class="display" id="example" >
            <thead>
                <tr>
                   <td>#</td>
                    <td>Responsable Convenio</td>
                    <td>Cargo Responsable</td>
                    <td>Correo Responsable</td>
                    <td># Acta Consejo Facultad</td>
                    <td>Fecha de Envío</td>
                    <td>Fecha de Creación</td>
                    <td>Usuario Solicitud</td>
                    <td>Institución</td>    
                    <td>Estado</td>
                    <td>Detalles</td>
                    <td>PDF Formato</td>
                    <td>Linea de Tiempo</td>
                </tr>
            </thead>
            <tbody>
            <?php
               /* $sqlpropuestas = "SELECT 
									SC.SolicitudConvenioId,
									SC.ResponsableConvenio,
									SC.CargoResponsableConvenio,
									SC.CorreoResponsableConvenio,
									SC.NumeroActa,
									SC.FechaEnvioSolicitud,
									SC.FechaCreacion,
									U.usuario,
									SC.NombreInstitucion,
									SC.PasoSolicitud
								FROM
									SolicitudConvenios SC 
								INNER JOIN usuario U ON ( U.idusuario = SC.UsuarioCreacion ) 
								INNER JOIN SolicitudConvenioCarrera scc on scc.SolicitudConvenioId=SC.SolicitudConvenioId AND scc.CodigoEstado=100 
								WHERE scc.codigocarrera in 
									(SELECT codigofacultad FROM usuariofacultad
										WHERE usuario='".$_SESSION['MM_Username']."' AND codigoestado=100)
                                order by SC.PasoSolicitud desc";*/
              $sqlpropuestas = "SELECT
                        (@row:=@row+1) AS row,
                        SC.SolicitudConvenioId,
                        SC.ResponsableConvenio,
                        SC.CargoResponsableConvenio,
                        SC.CorreoResponsableConvenio,
                        SC.NumeroActa,
                        SC.FechaEnvioSolicitud,
                        SC.FechaCreacion,
                        U.usuario,
                        SC.NombreInstitucion,
                        SC.PasoSolicitud
                        FROM
                        (SELECT @ROW:=0) r,
                        SolicitudConvenios SC
                        INNER JOIN usuario U ON  U.idusuario = SC.UsuarioCreacion 
                        WHERE
                        SC.usuariocreacion = '".$userid."'
                        order by 
                        SC.PasoSolicitud desc";
                $datospropuesta = $db->GetAll($sqlpropuestas);                                    
                foreach($datospropuesta  as $campospropuesta)
                {
                    echo "<tr><td>".$campospropuesta['row']."</td>";
                    echo "<td>".$campospropuesta['ResponsableConvenio']."</td>";
                    echo "<td>".$campospropuesta['CargoResponsableConvenio']."</td>";
                    echo "<td>".$campospropuesta['CorreoResponsableConvenio']."</td>";
                    echo "<td>".$campospropuesta['NumeroActa']."</td>";
                    echo "<td>".$campospropuesta['FechaEnvioSolicitud']."</td>";
                    echo "<td>".$campospropuesta['FechaCreacion']."</td>";
                    echo "<td>".$campospropuesta['usuario']."</td>";
                    echo "<td>".$campospropuesta['NombreInstitucion']."</td>";
                    //pasosoliictud 0:  1 al 5: proceso de solicitud 6: En espera de ajustes por facultad
                    switch($campospropuesta['PasoSolicitud'])
                    {
                        case '0':{$url = "nuevapropuesta";echo "<td>Solicitud Enviada</td><td></td>";}break;
                        case '1':{$url = "nuevapropuesta";echo "<td>Sin Enviar - Paso 1</td>";}break;
                        case '2':{$url = "nuevapropuesta2";echo "<td>Sin Enviar - Paso 2</td>";}break;
                        case '3':{$url = "nuevapropuesta3";echo "<td>Sin Enviar - Paso 3</td>";}break;
                        case '4':{$url = "nuevapropuesta4";echo "<td>Sin Enviar - Paso 4</td>";}break;
                        case '5':{$url = "nuevapropuesta5";echo "<td>Sin Enviar - Paso 5</td>";}break;
                        case '6':{$url = "nuevapropuesta"; echo "<td>En espera ajustes Facultad</td>";}break;
                    }
					/*if($campospropuesta['PasoSolicitud']!=0 && $campospropuesta['PasoSolicitud']!=6){
						$url = "nuevapropuesta";
						if($campospropuesta['PasoSolicitud']!=1){
							$url = $url.$campospropuesta['PasoSolicitud'];
						}
						echo "<td>Sin Enviar - Paso ".$campospropuesta['PasoSolicitud']."</td>";
					} else if($campospropuesta['PasoSolicitud']==6){
						echo "<td>En espera ajustes Facultad</td>";
					} else {
						echo "<td>Solicitud Enviada</td>";
					}*/
                    if($campospropuesta['PasoSolicitud']!='0')
                    {
                        echo "<td valign='top'><a href='".$url.".php?id=".$campospropuesta['SolicitudConvenioId']."' 
						method='post'><input type='hidden' name='Detalle' id='Detalle' value='".$campospropuesta['SolicitudConvenioId']."' />
						<input type='image' src='../mgi/images/file_search.png' width='20'></form>
						</td>";   
                    }
                    echo "<td id='archivo7'><a href='./VistaPropuestaPdf.php?id=".$campospropuesta['SolicitudConvenioId']."' target='_blank'><img src='../mgi/images/file_document.png' width='50' height='37'  border='0' alt=''/></a></td>";
                    echo "<td valign='top'><form action='lineatiempo/lineatiempo.php' method='post'>
                            <input type='hidden' id='id' name='id' value='".$campospropuesta['SolicitudConvenioId']."' />
                            <input type='submit' id='lineatiempo' name='lineatiempo' value='Linea tiempo' /></form>
                            </td>";
                    echo "</tr>";
                }
            ?>
            </tbody>  
        </table>
    </div>
    <br />
    <form action="MenuConvenios.php">
        <input type="submit" id="regresar" name="regresar" value="Regresar"/>
    </form>
    </div>
    </body>
</html>
