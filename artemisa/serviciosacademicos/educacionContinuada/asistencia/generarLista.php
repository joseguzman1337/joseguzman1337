<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Lista de Asistencia",TRUE);

    $utils = Utils::getInstance();
	$id = $_REQUEST["id"];
	$participantes = $utils->getParticipantesGrupoCursoEducacionContinuada($db,$id);
?>

    <div id="contenido">
	<a href="javascript:window.print()" class="button"><img src="../images/click-here-to-print.jpg" alt="imprimir lista" id="print-button" /></a>
          <table align="center" class="viewList" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Lista de Asistencia</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Curso: <?php echo $utils->getNombreCursoGrupo($db,$id); ?></span></th> 
                            <th class="column borderR" ><span>Fecha: <?php echo $_REQUEST["fecha"]; ?></span></th> 
                        </tr>
                     </thead>
                    <tbody>  
						<?php $numParticipantes = count($participantes);
							for($i = 0; $i < $numParticipantes; ++$i) { ?>
							<tr>
								<td><?php echo $participantes[$i]['apellidosestudiantegeneral']." ".$participantes[$i]['nombresestudiantegeneral']; ?></td>
								<td></td>
							</tr>
							<?php } ?>
                    </tbody>
                </table>   
    </div>  
<?php  writeFooter(); ?>