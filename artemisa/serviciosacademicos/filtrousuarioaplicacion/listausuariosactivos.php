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
        <title>Listado de Usuarios Activos</title>
             
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
        						{ "type": "print", "buttonText": "Imprimir" }
        					]
        		         });
                                 $('#demo').before( oTableTools.dom.container );
								 
								 resizeWindow('#container',oTable);
        		} );
        	/**************************************************************/
            
			function resizeWindow(tableContainer,table){
				 var maxWidth = $(tableContainer).width();  
				 //alert(maxWidth);
				 
				 //alert(table.width());
				 table.width(maxWidth);
			}
            
			//Para que al cambiar el tamaño de la página se arreglen las tablas
			$(window).resize(function() {
				resizeWindow('#container',oTable);
			});    
        </script>	
 </head>
 <body>  	
<div id="container">
    <h2>Reporte usuarios activos</h2>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id='example'>
                <thead>
                    <tr>
                        <th>numero</th>          
                        <th>usuario</th>
                        <th>numerodocumento</th>
                        <th>nombres</th>
                        <th>apellidos</th>
                        <th>codigorol</th>                        
                        <th>fechainiciousuario</th>
                        <th>fechavencimientousuario</th>
                        <th>fecharegistrousuario</th>
                        <th>tipo usuario</th>     
                        <th>nombre carrera</th>
                        <th>Permisos a las opciones</th>
                        <?php if(!isset($_GET['idmenuopcion'])){ ?><th>Permisos a los botones</th><?php } else { ?>
						<th>Sub-Permisos</th>
						<?php } ?>
                    </tr>
                </thead>
            <tbody>  
            <?php   
            $administrador = $_GET['tipo'];
            $codigorol = $_GET['idrol'];
            $roladmin = $_GET['busqueda'];
            $periodoingreso = $_GET['periodoingreso'];
            
                                   
                        if(isset($_GET['idmenuopcion'])){
							$opcion = $_GET['idmenuopcion'];
							$sQl="select u.usuario, u.numerodocumento, u.nombres, u.apellidos, u.codigorol, u.fechainiciousuario, u.fechavencimientousuario, u.fecharegistrousuario
									 from permisousuariomenuopcion pu 
									inner join detallepermisomenuopcion dm on dm.idpermisomenuopcion=pu.idpermisomenuopcion 
									inner join usuario u on u.idusuario=pu.idusuario 
									where dm.idmenuopcion='$opcion' AND u.fechavencimientousuario > NOW() and u.codigoestadousuario = 100
									GROUP BY u.idusuario ";
			
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
											<td valign="top"><?php echo $datos1['usuario']?></td>
											<td valign="top"><?php echo $datos1['numerodocumento']?></td>
											<td valign="top"><?php echo $datos1['nombres']?></td>
											<td valign="top"><?php echo $datos1['apellidos']?></td>
											<td valign="top"><?php echo $datos1['codigorol']?></td>
											<td valign="top"><?php echo $datos1['fechainiciousuario']?></td>
											<td valign="top"><?php echo $datos1['fechavencimientousuario']?></td>
											<td valign="top"><?php echo $datos1['fecharegistrousuario']?></td>
										<?php
									
										$usuario = $datos1['usuario']; 
										$sql2= "select tu.nombretipousuario from usuario u JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario where u.usuario = '$usuario'";
										$valores2 = &$db->Execute($sql2);
										$datos2 = $valores2->getarray();
										?>
										<td valign="top"><?php echo $datos2[0]['nombretipousuario']?></td>
										<td valign="top">
											<ul>
											<?php
												$sql3="select c.nombrecarrera from usuariofacultad uf  JOIN carrera c ON c.codigofacultad = uf.codigofacultad where uf.usuario = '$usuario' AND uf.codigoestado = 100";
												$valores3 = &$db->Execute($sql3);
												$datos3 = $valores3->getarray();
												if(!empty($datos3)){
													foreach($valores3 as $nombrecarrera){
											?>
													<li><?PHP echo $nombrecarrera['nombrecarrera'];?></li>
												<?php
													} 
												?>
													<li>-------</li>
												<?php
												}                                 
												?> 
											</ul>
										</td>
										<td valign="top">
											<ul>
											<?php
											$sql4 ="select m.nombremenuopcion from usuario u INNER JOIN permisousuariomenuopcion pu ON u.idusuario = pu.idusuario INNER JOIN detallepermisomenuopcion dp ON pu.idpermisomenuopcion = dp.idpermisomenuopcion 
													LEFT JOIN menuopcion m ON m.idmenuopcion = dp.idmenuopcion where u.usuario = '$usuario' AND dp.codigoestado = 100 AND dp.idmenuopcion='$opcion'";
											$valores4 = &$db->Execute($sql4);
											$datos4 = $valores4->getarray();
											if(!empty($datos4)){
												foreach($valores4 as $nombremenuopcion){
							   
											?>
													<li><?php echo $nombremenuopcion['nombremenuopcion'];?></li>
											<?php
												}      
											}
											?>
											</ul>
										</td>
										<td valign="top">
											<ul>
											<?php
												/*$sql5 ="SELECT mb.nombremenuboton FROM usuariorol ur join permisorolboton pr ON pr.idrol = ur.idrol join menuboton mb ON mb.idmenuboton = pr.idmenuboton WHERE	ur.usuario = '$usuario'";
												$valores5 = &$db->Execute($sql5);
												$datos5 = $valores5->getarray();
												if(!empty($datos5)){
													foreach($valores5 as $nombremenuboton){       */  
											?>
											   <li><?PHP echo $nombremenuboton['nombremenuboton'];?></li>
											<?php
												/*	}//foreach 
												}//if
												*/?>                                    
											</ul>
										</td>
										<?php           
										$i++; 
									}//foreach
							}//if total datos array 
                                
							
						} else if($codigorol == '1'){
                          $usuario = $_GET["usuario"];   
                          
                        $sQl="SELECT DISTINCT u.usuario, u.numerodocumento, u.nombres, u.apellidos, u.codigorol, u.fechainiciousuario, u.fechavencimientousuario, u.fecharegistrousuario FROM
	                           usuario u WHERE  u.usuario = '$usuario' AND u.codigoestadousuario = '100'";
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
                                <td valign="top"><?php echo $datos1['usuario']?></td>
                                <td valign="top"><?php echo $datos1['numerodocumento']?></td>
                                <td valign="top"><?php echo $datos1['nombres']?></td>
                                <td valign="top"><?php echo $datos1['apellidos']?></td>
                                <td valign="top"><?php echo $datos1['codigorol']?></td>
                                <td valign="top"><?php echo $datos1['fechainiciousuario']?></td>
                                <td valign="top"><?php echo $datos1['fechavencimientousuario']?></td>
                                <td valign="top"><?php echo $datos1['fecharegistrousuario']?></td>
                            <?php
                            $numerodocumento = $datos1['numerodocumento'];
                            $usuario = $datos1['usuario']; 
                            $sql2= "select tu.nombretipousuario from usuario u INNER JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario where u.usuario = '$usuario' ";
                            $valores2 = &$db->Execute($sql2);
                            $datos2 = $valores2->getarray();
                            ?>
                            <td valign="top"><?php echo $datos2[0]['nombretipousuario']?></td>
                            <td valign="top">
                                <ul>
                                <?php
                                   $sql3="select c.nombrecarrera FROM 	estudiante e JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral JOIN carrera c ON c.codigocarrera = e.codigocarrera WHERE
	                               eg.numerodocumento = '$numerodocumento'";
                                    $valores3 = &$db->Execute($sql3);
                                    $datos3 = $valores3->getarray();
                                    if(!empty($datos3)){
                                        foreach($valores3 as $nombrecarrera){
                                         ?>
                                        <li><?PHP echo $nombrecarrera['nombrecarrera'];?></li>
                                       <?php
                                     } 
                                    
                                    }                                 
                                    ?> 
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                 $sql4 ="select m.nombremenuopcion from usuario u INNER JOIN permisousuariomenuopcion pu ON u.idusuario = pu.idusuario INNER JOIN detallepermisomenuopcion dp ON pu.idpermisomenuopcion = dp.idpermisomenuopcion 
                                        LEFT JOIN menuopcion m ON m.idmenuopcion = dp.idmenuopcion where u.usuario = '$usuario' AND dp.codigoestado = 100";
                                $valores4 = &$db->Execute($sql4);
                                $datos4 = $valores4->getarray();
                                if(!empty($datos4)){
                                    foreach($valores4 as $nombremenuopcion){
                   
                                ?>
                                        <li><?php echo $nombremenuopcion['nombremenuopcion'];?></li>
                                <?php
                                    }      
                                }
                                
                                ?>
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                    //$sql5 ="SELECT mb.nombremenuboton FROM usuariorol ur join permisorolboton pr ON pr.idrol = ur.idrol join menuboton mb ON mb.idmenuboton = pr.idmenuboton WHERE	ur.usuario = '$usuario'";
                                    $sql5 = "SELECT mb.nombremenuboton FROM usuariorol ur JOIN permisorolboton pr ON pr.idrol = ur.idrol JOIN menuboton mb ON mb.idmenuboton = pr.idmenuboton JOIN UsuarioTipo ut ON ur.idusuariotipo = ut.UsuarioTipoId JOIN usuario u ON ut.UsuarioId = u.idusuario WHERE u.usuario= '$usuario'";
                                    
                                    $valores5 = &$db->Execute($sql5);
                                    $datos5 = $valores5->getarray();
                                    if(!empty($datos5)){
                                        foreach($valores5 as $nombremenuboton){         
                                ?>
                                        <li><?PHP echo $nombremenuboton['nombremenuboton'];?></li>
                                <?php
                                        }//foreach 
                                    }//if
                                    ?>
                                </ul>
                            </td>
                            <?php           
                            $i++; 
                            }//foreach
                            }//if total datos array
                            else{
                                ?>
                                <tr>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                <td valign="top">No existe</td>
                                </tr>
                                <?php
                            } 
                        }//if codigo rol 1
                        else{
                            if($codigorol == '2'){
                                $sQl="SELECT u.usuario, u.numerodocumento, u.nombres, u.apellidos, u.codigorol, u.fechainiciousuario, u.fechavencimientousuario, u.fecharegistrousuario FROM  usuario u 
                        where u.codigorol = '$codigorol' AND u.fechavencimientousuario > NOW() and u.codigoestadousuario = 100";
        
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
                                <td valign="top"><?php echo $datos1['usuario']?></td>
                                <td valign="top"><?php echo $datos1['numerodocumento']?></td>
                                <td valign="top"><?php echo $datos1['nombres']?></td>
                                <td valign="top"><?php echo $datos1['apellidos']?></td>
                                <td valign="top"><?php echo $datos1['codigorol']?></td>
                                <td valign="top"><?php echo $datos1['fechainiciousuario']?></td>
                                <td valign="top"><?php echo $datos1['fechavencimientousuario']?></td>
                                <td valign="top"><?php echo $datos1['fecharegistrousuario']?></td>
                            <?php
                        
                            $usuario = $datos1['usuario']; 
                            $sql2= "select tu.nombretipousuario from usuario u JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario where u.usuario = '$usuario'";
                            $valores2 = &$db->Execute($sql2);
                            $datos2 = $valores2->getarray();
                            ?>
                            <td valign="top"><?php echo $datos2[0]['nombretipousuario']?></td>
                            <td valign="top">
                                <ul>
                                <?php
                                    $sql3="select c.nombrecarrera from usuariofacultad uf  JOIN carrera c ON c.codigofacultad = uf.codigofacultad where uf.usuario = '$usuario' AND uf.codigoestado = 100";
                                    $valores3 = &$db->Execute($sql3);
                                    $datos3 = $valores3->getarray();
                                    if(!empty($datos3)){
                                        foreach($valores3 as $nombrecarrera){
                                ?>
                                        <li><?PHP echo $nombrecarrera['nombrecarrera'];?></li>
                                    <?php
                                        } 
                                    ?>
                                        <li>-------</li>
                                    <?php
                                    }                                 
                                    ?> 
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                $sql4 ="select m.nombremenuopcion from usuario u INNER JOIN permisousuariomenuopcion pu ON u.idusuario = pu.idusuario INNER JOIN detallepermisomenuopcion dp ON pu.idpermisomenuopcion = dp.idpermisomenuopcion 
                                        LEFT JOIN menuopcion m ON m.idmenuopcion = dp.idmenuopcion where u.usuario = '$usuario' AND dp.codigoestado = 100";
                                $valores4 = &$db->Execute($sql4);
                                $datos4 = $valores4->getarray();
                                if(!empty($datos4)){
                                    foreach($valores4 as $nombremenuopcion){
                   
                                ?>
                                        <li><?php echo $nombremenuopcion['nombremenuopcion'];?></li>
                                <?php
                                    }      
                                }
                                ?>
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                    //$sql5 ="SELECT mb.nombremenuboton FROM usuariorol ur join permisorolboton pr ON pr.idrol = ur.idrol join menuboton mb ON mb.idmenuboton = pr.idmenuboton WHERE	ur.usuario = '$usuario'";
                                    $sql5 = "SELECT mb.nombremenuboton FROM usuariorol ur JOIN permisorolboton pr ON pr.idrol = ur.idrol JOIN menuboton mb ON mb.idmenuboton = pr.idmenuboton JOIN UsuarioTipo ut ON ur.idusuariotipo = ut.UsuarioTipoId JOIN usuario u ON ut.UsuarioId = u.idusuario WHERE u.usuario= '$usuario'";
                                    $valores5 = &$db->Execute($sql5);
                                    $datos5 = $valores5->getarray();
                                    if(!empty($datos5)){
                                        foreach($valores5 as $nombremenuboton){         
                                ?>
                                   <li><?PHP echo $nombremenuboton['nombremenuboton'];?></li>
                                <?php
                                        }//foreach 
                                    }//if
                                    ?>                                    
                                </ul>
                            </td>
                            <?php           
                            $i++; 
                            }//foreach
                            }//if total datos array 
                                
                            }//if  codigo rol 2
                            else{
                            if($administrador == '0'){
                                    
                                foreach($roladmin as $valor){
                                    $sentencia = ' ur.idrol = '.$valor ;
                                    $tmpsentencia .= $sentencia. ' or '; 
                                }
                               // print_r($roladmin);
                                 $tmpsentencia = substr($tmpsentencia, 0, -4);                      
                            $sQl="SELECT u.usuario, u.numerodocumento, u.nombres, u.apellidos, ur.idrol, u.fechainiciousuario, u.fechavencimientousuario, u.fecharegistrousuario, r.nombrerol FROM usuario u, usuariorol ur, rol r, UsuarioTipo ut
                            WHERE u.codigorol = '3' AND u.idusuario = ut.UsuarioId AND ur.idusuariotipo = ut.UsuarioTipoId AND ur.idrol = r.idrol and ($tmpsentencia) AND u.fechavencimientousuario > NOW() and u.codigoestadousuario = 100";
                               
        
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
                                <td valign="top"><?php echo $datos1['usuario']?></td>
                                <td valign="top"><?php echo $datos1['numerodocumento']?></td>
                                <td valign="top"><?php echo $datos1['nombres']?></td>
                                <td valign="top"><?php echo $datos1['apellidos']?></td>
                                <td valign="top"><?php echo $datos1['idrol'].'- '. $datos1[nombrerol]?></td>
                                <td valign="top"><?php echo $datos1['fechainiciousuario']?></td>
                                <td valign="top"><?php echo $datos1['fechavencimientousuario']?></td>
                                <td valign="top"><?php echo $datos1['fecharegistrousuario']?></td>
                            <?php
                                                                                 
                            $usuario = $datos1['usuario']; 
                            $sql2= "select tu.nombretipousuario from usuario u JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario where u.usuario = '$usuario'";
                            $valores2 = &$db->Execute($sql2);
                            $datos2 = $valores2->getarray();
                            ?>
                            <td valign="top"><?php echo $datos2[0]['nombretipousuario']?></td>
                            <td valign="top">
                                <ul>
                                <?php
                                    $sql3="select c.nombrecarrera from usuariofacultad uf  JOIN carrera c ON c.codigofacultad = uf.codigofacultad where uf.usuario = '$usuario' AND uf.codigoestado = 100";
                                    $valores3 = &$db->Execute($sql3);
                                    $datos3 = $valores3->getarray();
                                    if(!empty($datos3)){
                                        foreach($valores3 as $nombrecarrera){
                                ?>
                                   <li><?PHP echo $nombrecarrera['nombrecarrera'];?></li>
                                    <?php
                                        } 
                                    }                                 
                                    ?> 
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                $sql4 ="select m.nombremenuopcion from usuario u INNER JOIN permisousuariomenuopcion pu ON u.idusuario = pu.idusuario INNER JOIN detallepermisomenuopcion dp ON pu.idpermisomenuopcion = dp.idpermisomenuopcion 
                                        LEFT JOIN menuopcion m ON m.idmenuopcion = dp.idmenuopcion where u.usuario = '$usuario' AND dp.codigoestado = 100";
                                $valores4 = &$db->Execute($sql4);
                                $datos4 = $valores4->getarray();
                                if(!empty($datos4)){
                                    foreach($valores4 as $nombremenuopcion){
                   
                                ?>
                                    <li><?php echo $nombremenuopcion['nombremenuopcion'];?></li>
                               <?php
                                    }      
                                }
                                
                                ?>
                                </ul>
                            </td>
                            <td valign="top">
                                <ul>
                                <?php
                                    //$sql5 = "SELECT mb.nombremenuboton FROM usuariorol ur join permisorolboton pr ON pr.idrol = ur.idrol join menuboton mb ON mb.idmenuboton = pr.idmenuboton WHERE	ur.usuario = '$usuario'";
                                    $sql5 = "SELECT mb.nombremenuboton FROM usuariorol ur JOIN permisorolboton pr ON pr.idrol = ur.idrol JOIN menuboton mb ON mb.idmenuboton = pr.idmenuboton JOIN UsuarioTipo ut ON ur.idusuariotipo = ut.UsuarioTipoId JOIN usuario u ON ut.UsuarioId = u.idusuario WHERE u.usuario= '$usuario'";
                                    $valores5 = &$db->Execute($sql5);
                                    $datos5 = $valores5->getarray();
                                    if(!empty($datos5)){
                                        foreach($valores5 as $nombremenuboton){         
                                ?>
                                    <li><?PHP echo $nombremenuboton['nombremenuboton'];?></li>
                                <?php
                                        }//foreach 
                                    }//if
                                    
                                ?>
                                </ul>
                            </td>
                            <?php           
                            $i++; 
                            }//foreach
                                }//if total datos array
                       }//if codigo rol 3
                       }
                       }
                    ?>                     
            </tbody>
        </table>
    </div>
</div>   
</body>
</html>    