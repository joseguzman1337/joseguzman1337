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
        <title>Listado de usuarios padre</title>
             
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
    <h2>Reporte usuarios padre por carrera</h2>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>numero de usuarios</th>          
                        <th>nombre carrera</th>
                    </tr>
                </thead>
            <tbody>  
            <?php
				if(!empty($_POST['codigomodalidadacademica']) && !empty($_POST['codigoperiodo']) && !empty($_POST['codigocarrera'])){
					$modalidad = (!empty($_POST['codigomodalidadacademica'])) ? $_POST['codigomodalidadacademica'] : false;
					$periodo = (!empty($_POST['codigoperiodo'])) ? $_POST['codigoperiodo'] : false;
					$carrera = (!empty($_POST['codigocarrera'])) ? $_POST['codigocarrera'] : false;
					$contarcarreras = count($_POST['codigocarrera']);
					
					$sQl = 'select count(distinct up.usuario) as usuariof,c.nombrecarrera, c.codigocarrera as codigocarrera from usuariopadre up, usuario u, estudiantegeneral eg, estudiante e, carrera c
							where u.usuario=up.usuario
							and eg.idestudiantegeneral=up.idestudiantegeneral
							and eg.idestudiantegeneral=e.idestudiantegeneral
							and e.codigocarrera=c.codigocarrera
							and u.codigotipousuario=900
							and up.codigoestado = 100
							and c.codigomodalidadacademica = '.$modalidad;                            
							if($carrera[0] != 1){
								if($carrera != false){
									$sQl .= ' and c.codigocarrera in (';
									for ($i=0;$i<count($carrera);$i++){
										$sQl .= $carrera[$i].',';
									}
									$sQl = substr($sQl, 0, -1);
									$sQl .= ')';
								}		
							}
							if($periodo != false){
								$sQl .= ' and u.fecharegistrousuario >= (select fechainicioperiodo from periodo where codigoperiodo = "'.$periodo.'" )
										 and u.fecharegistrousuario <= (select fechavencimientoperiodo from periodo where codigoperiodo = "'.$periodo.'" )';
							}
							$sQl .= 'group by c.nombrecarrera;';
							//echo $sQl;
					if($Consulta=&$db->Execute($sQl)===false){
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
								<td valign="top"><a href="detalleusuariospadre.php?periodo=<?php echo $periodo; ?>&codigocarrera=<?php echo $datos1['codigocarrera'] ?>&modalidad=<?php echo $modalidad ?>"><?php echo $datos1['usuariof']?></a></td>
								<td valign="top"><?php echo $datos1['nombrecarrera']?></td>
							</tr>
							<?php
						}//foreach
					}//if
				}
				else{
					?>
					<script language="JavaScript" type="text/javascript">
                            alert("Sin datos para consulta, por favor complete los datos");
                    </script><meta http-equiv=refresh content=0;URL=buscarusuariospadre.php>
					<?php
				}
            ?>                     
            </tbody>
        </table>
    </div>
</div>  
<?php    
writeFooter();
?>       