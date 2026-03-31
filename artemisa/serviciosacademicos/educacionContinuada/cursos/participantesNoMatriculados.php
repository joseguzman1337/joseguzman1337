<?php
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
    
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Participantes Grupo",TRUE);
    
    $grupo = array();
    $numParticipantes = 0;
    if(isset($_REQUEST["idGrupo"])){  
       $id = $_REQUEST["idGrupo"];
       $utils = Utils::getInstance();
       $grupo = $utils->getDataEntity("grupo", $id, "idgrupo");  
       $materia = $utils->getDataEntity("materia", $grupo["codigomateria"], "codigomateria");  
       $dataDetalle = $utils->getDataEntity("detalleCursoEducacionContinuada", $materia["codigocarrera"], "codigocarrera");
       $participantes = $utils->getParticipantesInscritosGrupoCursoEducacionContinuada($db,$id);  
       $numParticipantes = count($participantes);
       $asistencia = $utils->getHorasAsistenciaGrupo($db,$id);  
       if($dataDetalle['intensidad']!=null){
           $duracion = intval($dataDetalle['intensidad']);
       }else {
           $duracion = 0;
       }
   }

?>
   
   <div id="contenido" style="margin:10px 0;">
        <h4 style="margin-top:0;">Detalle de Participantes Inscritos</h4>
		<button class="soft verParticipantes" type="button" id="bgrupo_<?php echo $id; ?>" >Visualizar participantes matriculados</button><br/>
         <?php if($numParticipantes>0){ ?>
        <table class="detalle">
		<tr>
                    <th style="text-align:center"># Orden</th>
                    <th style="text-align:center">Estado Orden</th>
                    <th style="text-align:center">Apellidos</th>
                    <th style="text-align:center">Nombres</th>
                    <th style="text-align:center">Fecha de Nacimiento</th>
                    <th style="text-align:center">Títulos</th>
                    <th style="text-align:center">Residencia</th>
                    <!--<th style="text-align:center">País de Residencia</th>-->
                    <th style="text-align:center">Documento</th>
                    <!--<th style="text-align:center">Número de Documento</th>-->
                    <th style="text-align:center">Correo Electrónico</th> 
                    <!--<th style="text-align:center">Correo Electrónico Alterno</th> -->
                    <th style="text-align:center">Teléfonos</th> 
                    <!--<th style="text-align:center">Celular</th> -->
                </tr>
                <?php $color=false;
                    for($i = 0; $i < $numParticipantes; ++$i) { 
			$titulos = $utils->getTitulosEstudiante($db,$participantes[$i]["idestudiantegeneral"]); 
                        $asistenciaE = 0;
		?>
		<tr <?php if($color){ $color=false;?> class="odd" <?php } else{ $color=true;}?>>
                    <td><?php echo $participantes[$i]['numeroordenpago']; ?>
                    </td>
                    <td class="center"><?php echo $participantes[$i]['nombreestadoordenpago']; ?></td>
                    <td><?php echo $participantes[$i]['nombresestudiantegeneral']; ?></td>
                    <td><?php echo $participantes[$i]['apellidosestudiantegeneral']; ?></td>
                    <td class="center"><?php echo date('Y-m-d', strtotime($participantes[$i]["fechanacimientoestudiantegeneral"]));$participantes[$i]["fechanacimientoestudiantegeneral"]; ?></td>
                    <td><?php echo $titulos; ?></td>
                    <td><?php echo $participantes[$i]["nombreciudad"].", ".$participantes[$i]["nombrepais"]; ?></td>
                    <!--<td><?php //echo $participantes[$i]["nombrepais"]; ?></td>-->
                    <td><?php echo $participantes[$i]["nombrecortodocumento"].". ".$participantes[$i]["numerodocumento"]; ?></td>
                    <!--<td><?php //echo $participantes[$i]["numerodocumento"]; ?></td>-->
                    <td><?php echo $participantes[$i]["emailestudiantegeneral"];
                    if($participantes[$i]["email2estudiantegeneral"]!=""){ echo "<br/><br/>Correo alterno:<br/>".$participantes[$i]["email2estudiantegeneral"]; } ?></td>
                    <!--<td><?php //echo $participantes[$i]["email2estudiantegeneral"]; ?></td>-->
                    <td><?php echo "Fijo:<br/>".$participantes[$i]["telefonoresidenciaestudiantegeneral"]."<br/><br/>Celular:<br/>".$participantes[$i]["celularestudiantegeneral"]; ?></td>
                    <!--<td><?php //echo $participantes[$i]["celularestudiantegeneral"]; ?></td>-->
		</tr> 
		<?php } ?>  
	</table>
	<?php } else { echo "No se encontraron participantes."; } ?>
   </div>
<script type="text/javascript">
     $(document).ready(function() {   
		
		$(".verParticipantes").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("bgrupo_",""); 
            var parameters=idgrupo.split("_"); 
            
            window.location.href='participantes.php?idGrupo='+parameters[0]; 
           
        });
    });
</script>

<?php writeFooter(); ?>