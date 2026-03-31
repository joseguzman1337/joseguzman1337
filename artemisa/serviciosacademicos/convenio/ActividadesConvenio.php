<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    include_once ('./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once('../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();
    include_once('_menuConvenios.php');
    if(!isset ($_SESSION['MM_Username']))
    {
        //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
        echo "No ha iniciado sesión en el sistema";
        exit();
    }
    $db = getBD();
    
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    if($Usario_id=$db->GetRow($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>'.$SQL_User;
		die;
	}
    $userid=$Usario_id['id'];    
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,7);
    
    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }
    $codigoFacultadSession=$_SESSION['codigofacultad'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<link media="screen, projection" type="text/css" href="css/style.css" rel="stylesheet">
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
                function AddFile(id){
                    location.href='CargarFileActividad.php?id='+id;
                }//function AddFile
        	/**************************************************************/
        </script>	
  <html>
    
    <body class="body"> 
    <div id="pageContainer">
	 <?php 
    $Menu = $C_Permisos->PermisoUsuarioConvenio($db,$userid,2,7);
        
        for($i=0;$i<count($Menu['Data']);$i++){
            $URL[]    = $Menu['Data'][$i]['Url'];
            
            $Nombre[] = $Menu['Data'][$i]['Nombre'];
            
            if($Menu['Data'][$i]['ModuloSistemaId']==7){
                $Active[] = '1';    
            }else{
                $Active[] = '0';
            }
        }//for
        
        $C_Menu_Global->writeMenu2($URL,"Sistema de Convenios",$Nombre,$Active);
     ?> 
   <div id="container">
        <center><h1>ACTIVIDADES CONVENIOS </h1></center>
    
    <div id="demo">
    <!--<form action="NuevaActividad.php">
    <input type="submit" name="NuevoConvenio" id="NuevoConvenio" value="NUEVA ACTIVIDAD" />
    </form>-->
	
           <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>ID Convenio</th>
                        <th>Nombre Convenio</th>          
                        <th>Actividad Convenio</th>
						<th>Nueva Actividad</th>
                        <th>Cargar Archivos</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
				// Obtener el codigo de la facultad
				$sqlFacultad="SELECT F.codigofacultad FROM facultad F WHERE F.codigocarreraprincipal='".$codigoFacultadSession."'";
                
                if($Consulta=&$db->Execute($sqlFacultad)===false)
                {
                   echo 'Error en el SQL de la Consulta....<br><br>'.$sqlFacultad;
                   die;
                }   
                $cod = &$db->Execute($sqlFacultad);
                $datosFacult =  $cod->getarray();
                $codFacultad2= $datosFacult[0][0];
                $codFacultad=$codigoFacultadSession;
				//si no tre codigo facultad significa que el usuario no pertenece a una facultad se le asigna el mimo codigo que llega en la sesion
				if(empty($codFacultad))
				{
					$codFacultad=$codFacultad2;
				}
				//si esAdmon esta vacio se consulta por codigofacultad, si no se traen todos los convenios
				
				if (($codFacultad !== '1')&& $codFacultad!==483 && $codFacultad!==149)
				{
					$sQl="SELECT c.ConvenioId,	c.CodigoConvenio,	c.NombreConvenio,	c.FechaInicio,	c.FechaFin,	e.nombreestado 
					FROM	Convenios c 
					INNER JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio 
					INNER JOIN conveniocarrera cc on cc.ConvenioId=c.ConvenioId
					WHERE c.idsiq_estadoconvenio = '1'
					AND cc.codigocarrera='$codFacultad' 
					AND idsiq_tipoconvenio<>1";
					//echo $sQl;
					if($Consulta=&$db->Execute($sQl)===false)
					{
					   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
					   die;
					}   
					$valores = &$db->Execute($sQl);
					$datos =  $valores->getarray();
					$totaldatos=count($datos);
				}
				else
				{
					$sQl="SELECT c.ConvenioId,	c.CodigoConvenio,	c.NombreConvenio,	c.FechaInicio,	c.FechaFin,	e.nombreestado 
					FROM	Convenios c 
					JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio 
					WHERE c.idsiq_estadoconvenio = '1'";
					if($Consulta=&$db->Execute($sQl)===false)
					{
					   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
					   die;
					}   
					$valores = &$db->Execute($sQl);
					$datos =  $valores->getarray();
					$totaldatos=count($datos);
				}	
				
                if ($totaldatos>0){
                    foreach($valores as $datos1){
                    ?>
                        <tr>
                            <td valign="top"><?php echo $datos1['CodigoConvenio']?></td>
                            <td valign="top"><?php echo $datos1['NombreConvenio']?></td>
                            <td valign="top">
								<ul>
									<?php 
											$sQlActividad="SELECT NombreActividad
												FROM   ActividadConvenios
												WHERE ConvenioId = '".$datos1['ConvenioId']."' AND CodigoEstado=100";
												if($ConsultaActividad=&$db->Execute($sQlActividad)===false)
												{
												   echo 'Error en el SQL de la Consulta....<br><br>'.$sQlActividad;
												   die;
												}   
												$valoresActividad = &$db->Execute($sQlActividad);
												$datosActividad =  $valoresActividad->getarray();
												$totaldatosActividad=count($datosActividad); 
												foreach($valoresActividad as $dataActividad)
												{?>
													<li type="circle"><?php echo $dataActividad ['NombreActividad']?></li>
										  <?php } ?>
								</ul>
							</td>
                            <td valign="top" align="center">
                                <form action="NuevaActividad.php" method="post">
                                    <input type="hidden" name="conveio" id="conveio" value="<?php echo $datos1['ConvenioId']?>" />
                                    <input type="image" src="../mgi/images/add.png" width="20" title="Adicionar Nueva Actividad">
                                </form>
                            </td>
                            <td valign="top" align="center">
                                <?PHP 
                                 if ($totaldatosActividad>0){
                                    ?>
                                    <img src="../mgi/images/cargar.jpg" width="25" title="Cargar Archivos" style="cursor: pointer;" onclick="AddFile(<?php echo $datos1['ConvenioId']?>)" />
                                    <?PHP
                                 } 
                                ?>                                
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
      