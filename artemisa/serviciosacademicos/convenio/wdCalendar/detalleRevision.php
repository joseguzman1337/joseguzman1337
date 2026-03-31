<?php 
    if(isset($data["idsiq_actividadActualizar"]) && $data["idsiq_actividadActualizar"]!=null){
           $idS = $data["idsiq_actividadActualizar"];
       } else {
           $rel = $api->getRelacionIndicadorMonitoreo($_REQUEST["idIndicador"]);
           if($rel==null){
               echo "<p style='margin:5px 10px;color:red'>Este indicador no tiene fecha de vencimiento asignada, por lo cual, no tiene porque hacerse un monitoreo.</p>";
               die();
           }
           $actividad = $api->getActividadActualizarActiva($rel["idMonitoreo"]);
           $idS = $actividad["idsiq_actividadActualizar"];
    }

$revisiones = $utils->getAllComplex($db,"idsiq_revisionCalidadIndicador,comentarios,aprobado,fecha_creacion,uc.nombres as nombreCreador,uc.apellidos as apellidoCreador,um.nombres as nombreModificador, um.apellidos as apellidoModificador, fecha_modificacion", "siq_revisionCalidadIndicador r, usuario um, usuario uc","codigoestado = '100' AND idActualizacion='".$idS."' AND uc.idusuario=usuario_creacion AND um.idusuario=usuario_modificacion ORDER BY fecha_modificacion");
  
if($revisiones->_numOfRows>0){ ?>
                  <h4 class="toggler">Ver Revisiones de Calidad</h4>
                  <?php if(isset($_GET["show"])&& $_GET["show"]==true) { ?>
                  <div class="toggle">
                  <?php } else { ?>
                  <div class="toggle" style="display: none;">
                  <?php } 
                        while($row = $revisiones->FetchRow()){ ?>
                           <table class="detalle">
                                <tr>
                                <th>¿Aprobado?:</th>       
                                <td colspan="3"><?php writeYesNoStatus($row['aprobado']); ?></td>
                                </tr>
                                <?php if($row['comentarios']!="" && $row['comentarios']!=NULL ) { ?>
                                <tr>
                                <th>Comentarios:</th>
                                <td colspan="3"><?php echo $row['comentarios']; ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th>Fecha creación:</th>
                                    <td><?php echo $row['fecha_creacion']; ?></td>
                                    <th>Usuario creador:</th>
                                    <td><?php echo $row['nombreCreador']." ".$row["apellidoCreador"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="noLineBreak">Fecha modificación:</th>
                                    <td><?php echo $row['fecha_modificacion']; ?></td>
                                    <th>Usuario modificación:</th>
                                    <td><?php echo $row['nombreModificador']." ".$row["apellidoModificador"]; ?></td>
                                </tr>           
                        </table>
                       <?php } ?>
                   </div>
<?php } ?>


