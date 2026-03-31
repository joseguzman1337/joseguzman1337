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
         	
<div id="container">
    <h2>Reporte usuarios padre por carrera</h2>
        <div class="btn-export" align="right"><a target="_self" href="export.php?periodo=<?php echo $_GET['periodo'] ?>&codigocarrera=<?php echo $_GET['codigocarrera'] ?>&modalidad=<?php echo $_GET['modalidad'] ?>">Excel</a></div>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>Documento estudiante</th>
                        <th>Nombres estudiante</th>
                        <th>Apellidos estudiante</th>          
                        <th>Usuario padre</th>
                        <th>Apellido padre</th>
                        <th>Nombre padre</th>
                        <th>Documento padre</th>
                        <th>Email padre</th>
                    </tr>
                </thead>
            <tbody>  
            <?php
				if(!empty($_GET['periodo']) || !empty($_GET['codigocarrera']) || !empty($_GET['modalidad'])){
					$periodo = $_GET['periodo'];
					$carrera = $_GET['codigocarrera'];
					$modalidad = $_GET['modalidad'];					
                    $sQl = 'select eg.numerodocumento AS numerodocumento, 
                            eg.nombresestudiantegeneral AS nombresestudiantegeneral, 
                            eg.apellidosestudiantegeneral AS apellidosestudiantegeneral, 
                            GROUP_CONCAT(up.usuario SEPARATOR ",") AS usuario, 
                            GROUP_CONCAT(up.apellidosusuariopadre SEPARATOR ",") AS apellidosusuariopadre, 
                            GROUP_CONCAT(up.nombresusuariopadre SEPARATOR ",") AS nombresusuariopadre, 
                            GROUP_CONCAT(up.documentousuariopadre SEPARATOR ",") AS documentousuariopadre, 
                            GROUP_CONCAT(up.emailusuariopadre SEPARATOR ",") AS emailusuariopadre
                            from usuariopadre up, usuario u, estudiantegeneral eg, estudiante e, carrera c 
                            where u.usuario=up.usuario 
                            and eg.idestudiantegeneral=up.idestudiantegeneral 
                            and eg.idestudiantegeneral=e.idestudiantegeneral 
                            and e.codigocarrera=c.codigocarrera 
                            and u.codigotipousuario=900
							and up.codigoestado = 100
							and c.codigomodalidadacademica = '.$modalidad.'
                            and c.codigocarrera = '.$carrera.'
							and u.fecharegistrousuario >= (select fechainicioperiodo from periodo where codigoperiodo = "'.$periodo.'" )
							and u.fecharegistrousuario <= (select fechavencimientoperiodo from periodo where codigoperiodo = "'.$periodo.'" )
                            GROUP BY eg.numerodocumento;';       
					if($Consulta=&$db->Execute($sQl)===false){
					   echo 'Error en el SQL de la Consulta....<br><br>'.$sQl;
					   die;
					}   
					$valores = &$db->Execute($sQl);
					$datos =  $valores->getarray();
					$totaldatos=count($datos);
                    $anterior = '';
					if ($totaldatos>0){
                       
						foreach($valores as $datos1){
						    $rowspan = count(explode(',',$datos1['apellidosusuariopadre']));
                            if($rowspan == 1){                                
						?>
							<tr>
								<td valign="top"><?php echo $datos1['numerodocumento']?></td>
								<td valign="top"><?php echo $datos1['nombresestudiantegeneral']?></td>
								<td valign="top"><?php echo $datos1['apellidosestudiantegeneral']?></td>
								<td valign="top"><?php echo $datos1['usuario']?></td>
								<td valign="top"><?php echo $datos1['apellidosusuariopadre']?></td>
								<td valign="top"><?php echo $datos1['nombresusuariopadre']?></td>
								<td valign="top"><?php echo $datos1['documentousuariopadre']?></td>
								<td valign="top"><?php echo $datos1['emailusuariopadre']?></td>
							</tr>
						<?php                            
                            }else{
                                echo '<tr>';
                                echo '<td valign="top" rowspan="'.$rowspan.'">'.$datos1['numerodocumento'].'</td>
								<td valign="top" rowspan="'.$rowspan.'">'.$datos1['nombresestudiantegeneral'].'</td>
								<td valign="top" rowspan="'.$rowspan.'">'.$datos1['apellidosestudiantegeneral'].'</td>';
                                $usu = explode(',', $datos1['usuario']);
                                $ape = explode(',', $datos1['apellidosusuariopadre']);
                                $nom = explode(',', $datos1['nombresusuariopadre']);
                                $doc = explode(',', $datos1['documentousuariopadre']);
                                $ema = explode(',', $datos1['emailusuariopadre']);
                                for($i=0;$i<$rowspan;$i++){
                                    if($i!=0){echo '<tr>';}
                        ?>
                                <td valign="top"><?php echo $usu[$i]?></td>
								<td valign="top"><?php echo $ape[$i]?></td>
								<td valign="top"><?php echo $nom[$i]?></td>
								<td valign="top"><?php echo $doc[$i]?></td>
								<td valign="top"><?php echo $ema[$i]?></td>
                                </tr>
                        <?php        
                                }//for
                                echo '</tr>';
                            }//if rowspan
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