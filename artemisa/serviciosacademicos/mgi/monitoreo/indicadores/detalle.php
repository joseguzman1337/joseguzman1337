<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Indicador",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $entity = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_monitoreo();
       $id = $_REQUEST["id"];
       $data = $utils->getDataEntity("indicador", $id);  
       $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);  
       $aspecto = $utils->getDataEntity("aspecto", $indicadorGenerico["idAspecto"]);  
       $caracteristica = $utils->getDataEntity("caracteristica", $aspecto["idCaracteristica"]);   
       $factor = $utils->getDataEntity("factor", $caracteristica["idFactor"]);    
       $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
       $estado = $utils->getDataEntity("estadoIndicador", $data["idEstado"]); 
       $relMonitoreo = $utils->getDataNonEntity($db,"idsiq_relacionIndicadorMonitoreo,idMonitoreo", "siq_relacionIndicadorMonitoreo", "idIndicador='".$id."' AND codigoestado='100'"); 
       if(count($relMonitoreo)>0){
           $monitoreo = $utils->getDataEntity("monitoreo", $relMonitoreo["idMonitoreo"]);   
           if($monitoreo["idPeriodicidad"]!=null){
                $periodicidad = $utils->getDataEntity("periodicidad", $monitoreo["idPeriodicidad"]);
           }
           if($data["fecha_proximo_vencimiento"]==""){
                $api = new Api_Monitoreo();
                $actividad = $api->getActividadActualizarActiva($relMonitoreo["idMonitoreo"]);
                $data["fecha_proximo_vencimiento"] = $actividad["fecha_limite"];
                
                $action = "update";
                $fields = array();
                $fields["fecha_proximo_vencimiento"] = $actividad["fecha_limite"];
                $fields["idsiq_indicador"] = $data["idsiq_indicador"];
                $utils->processData($action,"indicador",$fields,false);
           }
       } else {
           $monitoreo = null;
       }
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $entity["label"] = false;
           $entity["nombre"] = $discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
           $entity["label"] = $discriminacion["nombre"];
           $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
           $entity["nombre"] = $facultad["nombrefacultad"];           
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $entity["label"] = $discriminacion["nombre"];
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $entity["nombre"] = $carrera["nombrecarrera"];  
       }       
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Indicador</h2>
            <table class="detalle">
                <tr>
                    <th>Código:</th>
                    <td><?php echo $indicadorGenerico['codigo']; ?></td>
                    <th>Id:</th>
                    <td><?php echo $data['idsiq_indicador']; ?></td>
                </tr>
                <tr>
                    <th>Indicador:</th>
                    <td colspan="3"><?php echo $indicadorGenerico['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Factor:</th>
                    <td colspan="3"><?php echo $factor['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Característica:</th>
                    <td colspan="3"><?php echo $caracteristica['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Aspecto a evaluar:</th>
                    <td colspan="3"><?php echo $aspecto['nombre']; ?></td>
                <tr>
                    <th>Discriminación:</th>
                    <td <?php if ($entity["label"]==false){ echo 'colspan="3"'; } ?>><?php echo $discriminacion['nombre']; ?></td>
                    <?php if ($entity["label"]!=false){ ?>
                        <th><?php echo $entity["label"]; ?>:</th>
                        <td><?php echo $entity['nombre']; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <th>Tipo de Indicador:</th>
                    <td <?php if($indicadorGenerico["idTipo"]!=3) { echo 'colspan="3"'; } ?>><?php echo $tipo['nombre']; ?></td>
                    <?php if($indicadorGenerico["idTipo"]==3) { ?>
                        <th><!--¿Existe?-->¿Es soportado por un documento?</th>
                        <td><?php writeYesNoStatus($data['inexistente']);//writeYesNoStatus(1-$data['inexistente']); ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <th>¿Tiene análisis?:</th>
                    <td><?php writeYesNoStatus($data['es_objeto_analisis']); ?></td>
                    <th>¿Tiene anexo?:</th>
                    <td><?php writeYesNoStatus($data['tiene_anexo']); ?></td>
                </tr>  
                <tr>
                    <th>Fecha de vencimiento:</th>
                    <td><?php echo $data['fecha_proximo_vencimiento']; if($monitoreo!=null && $monitoreo["idPeriodicidad"]!=null){ echo " (".$periodicidad["periodicidad"].")"; } ?></td>
                    <th>Fecha de la última actualización:</th>
                    <td><?php echo $data['fecha_ultima_actualizacion']; ?></td>
                </tr>  
                <tr>
                    <th>Estado de actualización:</th>
                    <td><?php echo $estado['nombre']; ?></td>
                    <th>Estado del registro:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr> 
                <tr>
                    <th>Fecha creación:</th>
                    <td><?php echo $data['fecha_creacion']; ?></td>
                    <th>Usuario creador:</th>
                    <td><?php echo $user1['nombres']." ".$user1["apellidos"]; ?></td>
                </tr>
                <tr>
                    <th>Fecha modificación:</th>
                    <td><?php echo $data['fecha_modificacion']; ?></td>
                    <th>Usuario modificación:</th>
                    <td><?php echo $user2['nombres']." ".$user2["apellidos"]; ?></td>
                </tr>           
            </table>
        </div>

<?php   include("./detalleResponsables.php");

if($data['fecha_proximo_vencimiento']=="" || $data['fecha_proximo_vencimiento']==null){
    //no tiene fecha de vencimiento por lo que las alertas no le aplican
} else {
    include("./detalleAlertas.php");
}

 writeFooter(); ?>