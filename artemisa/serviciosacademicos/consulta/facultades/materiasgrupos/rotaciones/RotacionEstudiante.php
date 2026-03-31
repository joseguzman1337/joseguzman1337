<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/templates/template.php');
    $db = getBD();

    $SQL_User="SELECT idusuario as id FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $Usario_id=$db->GetRow($SQL_User);

    $codigoestudiante = $_REQUEST['codigoestudiante'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <title>Rotación Estudiante</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="../../../../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../../../../educacionContinuada/css/style.css" rel="stylesheet">
        
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>         
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functionsMonitoreo.js"></script>  
        <script type="text/javascript" language="javascript" src="js/funcionesRotaciones.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            $('#exportExcel').click(function(e){
                $("#datos_a_enviar").val( $("<div>").append( $("#reporteGeneral").eq(0).clone()).html());
                $("#formInforme").submit();
            });
        });
        </script> 
        <script>
        function identificarmodal(id)
        {
            $('#rotacion').val(id); 
        }
        </script>
        <style>
            form span.info{
                margin-left:15px;position:relative;top:2px;
                clear: right;
                display: inline-block;
                float: left;
            }
            .modal-contenido{
              background-color: white;
              width:300px;
              padding: 10px 20px;
              margin: 20% auto;
              position: relative;
            }
            .modal{
              background-color: rgba(0,0,0,.8);
              position:fixed;
              top:0;
              right:0;
              bottom:0;
              left:0;
              opacity:0;
              pointer-events:none;
              transition: all 1s;
            }
            #miModal:target{
              opacity:1;
              pointer-events: auto;
            }
        </style> 
        <body class="body"> 
		<div id="pageContainer">
			<div id="container">
            <center><h1>LISTADO DE ROTACIONES</h1></center>
            <center>
                <table style="width: 100%;">
                    <tr>
                        <td style="aling:left;">
                            <form action="NuevaRotacionEstudiante.php" method="post">
                                <input type="submit" id="NuevaRotacion" value="Nueva Rotación"/>
                                <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $codigoestudiante?>"/>
                                <!--<input type="button" id="GeneCertificado" name="GeneCertificado" value="Generar Certificado" />-->
                            </form>
                        </td>
                        <td>
                            <form id="formInforme" style="z-index: -1; width:100%" method="post" action="../../../../utilidades/imprimirReporteExcel.php">
                                <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                                <input name="exportExcel" id="exportExcel" type="submit" value="Exportar" />
                            </form>
                        </td>
                    </tr>
                </table>
            </center>
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="reporteGeneral">
                    <thead>
                        <tr>
                            <th><strong>N°</strong></th>
                            <th><strong>Numero Documento</strong></th>
                            <th><strong>Apellidos</strong></th>
                            <th><strong>Nombres</strong></th>    
                            <th><strong>Materia</strong></th>
							<th><strong>Servicios</strong></th>
                            <th><strong>Lugar Rotacion</strong></th>
                            <th><strong>Fecha Inicio</strong></th>
                            <th><strong>Fecha Finalización</strong></th>
                            <th><strong>Periodo</strong></th>
                            <!--<th>Servicio</th>-->
                            <th><strong>Dias</strong></th>
                            <th><strong>Horas</strong></th>
                            <th><strong>Estado</strong></th>
                            <th><strong>Detalles</strong></th>                            
                            <th><strong>Eliminar</strong></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            $sqlrotaciones ="SELECT 
												m.nombremateria,
												eg.idestudiantegeneral,
												r.idsiq_convenio,
												r.FechaIngreso,
												r.FechaEgreso,
												er.NombreEstado,
												r.codigomateria,
												r.codigoperiodo,
												sc.NombreConvenio,
												eg.numerodocumento,
												eg.nombresestudiantegeneral,
												eg.apellidosestudiantegeneral,
												r.TotalDias,
												r.RotacionEstudianteId,
												r.IdUbicacionInstitucion,
												I.NombreInstitucion,
												r.TotalHoras,
												m.codigocarrera
											FROM
												RotacionEstudiantes r
												INNER JOIN estudiante ee ON ee.codigoestudiante=r.codigoestudiante
											INNER JOIN estudiante e ON e.codigoestudiante=r.codigoestudiante AND e.idestudiantegeneral = ee.idestudiantegeneral
											INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
											INNER JOIN materia m ON m.codigomateria = r.codigomateria
											INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = r.EstadoRotacionId
											INNER JOIN Convenios sc ON sc.ConvenioId = r.idsiq_convenio
											INNER JOIN InstitucionConvenios I ON I.InstitucionConvenioId = r.IdInstitucion
                                            WHERE
                                             ee.codigoestudiante = '".$codigoestudiante."'";
                                             //r.SubgrupoId = '1' AND
											 //echo $sqlrotaciones;
                            $valoresRotaciones = $db->execute($sqlrotaciones);
                            foreach($valoresRotaciones as $datosRotaciones){
                                ?>
                                    <tr>
                                        <td><?php echo $i?></td>
                                        <td><?php echo $datosRotaciones['numerodocumento']?></td>
                                        <td><?php echo $datosRotaciones['apellidosestudiantegeneral']?></td>
                                        <td><?php echo $datosRotaciones['nombresestudiantegeneral']?></td>
                                        <td><?php echo $datosRotaciones['nombremateria']?></td> 
										<td><?php 
											$sqlservicios = "SELECT j.Especialidad FROM EspecialidadCarrera j inner JOIN RotacionEspecialidades re ON re.EspecialidadCarreraId = j.EspecialidadCarreraId  WHERE re.CodigoEstado = '100' AND j.codigocarrera = '".$datosRotaciones['codigocarrera']."' and re.RotacionEstudianteId = '".$datosRotaciones['RotacionEstudianteId']."'";
											$servicios = $db->GetAll($sqlservicios);
											?>
											<ul>
											<?php
												foreach($servicios as $datos)
												{
													echo "<li>".$datos['Especialidad']."</li>";
												}
											?>
											</ul>
										</td>										
                                        <td><?php echo $datosRotaciones['NombreInstitucion']?></td>
                                        <td><?php echo $datosRotaciones['FechaIngreso']?></td>
                                        <td><?php echo $datosRotaciones['FechaEgreso']?></td>
                                        <td><?php echo $datosRotaciones['codigoperiodo']?></td>
                                        <td><?php echo $datosRotaciones['TotalDias']?></td>
                                        <td><?php echo $datosRotaciones['TotalHoras']?></td>
                                        <td><?php echo $datosRotaciones['NombreEstado']?></td>
                                        <td>
                                            <form action="DetallesRotacionEstudiante.php" method="post">
                                                <input type="hidden" name="detalle" id="detalle" value="<?php echo $datosRotaciones['RotacionEstudianteId'];?>" />
                                                <input type="image" src="../../../../mgi/images/file_search.png" width="20">
                                            </form>
                                        </td> 
                                        <td id="datos_eliminar" class="">
                                            <a href="#miModal" id="<?php echo $i;?>" onclick="identificarmodal('<?php echo $datosRotaciones['RotacionEstudianteId']; ?>');"><img src="../../../../convenio/img/iconoLupa.png" /></a>
                                            <div id="miModal" class="modal" name="<?php echo $i;?>">
                                                <div class="modal-contenido">
                                                    <div>
                                                        <a href="#">X</a>
                                                        <p>Esta seguro de elimar esta rotacion?</p>                                            
                                                        <form id="Eliminarformulario" method="post"  >
                                                            <input type="hidden" name="rotacion" id="rotacion" value="<?php echo $datosRotaciones['RotacionEstudianteId']?>" />                                            
                                                            <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo $codigoestudiante;?>" />
                                                            <input type="hidden" name="user" id="user" value="<?php echo  $Usario_id['id'];?>" />
                                                            <input type="hidden" id="action_ID" name="action_ID" value="EliminarRotacion" />                                                           
                                                            <input type="button" id="eliminar" name="eliminar" value="Aceptar" onclick="EliminarLaRotacion('#Eliminarformulario');"/>      
                                                        </form>
                                                    </div>                                          
                                                </div>  
                                            </div>
                                        </td>   
                                    </tr>
                                <?php
                                $i++;
                            }                                
                        ?>
                       </tbody>
        </table>
     </div>
                <input type="button" name="regresar" id="regresar" style="margin-top:10px"  value="Regresar" onclick="RegresarRotacion()"/>
        </div>
		</div>
		</body>
        </html>