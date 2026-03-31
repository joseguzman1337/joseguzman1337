<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Indicador",TRUE,$proyectoNumericos);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $entity = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_monitoreo();
       $data = $utils->getDataEntity("indicador", $id);  
       $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);  
       $aspecto = $utils->getDataEntity("aspecto", $indicadorGenerico["idAspecto"]); 
       $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
       $estado = $utils->getDataEntity("estadoIndicador", $data["idEstado"]); 
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $entity["label"] = "Tipo";
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
                    <th>Indicador:</th>
                    <td colspan="3"><?php echo $indicadorGenerico['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Aspecto a evaluar:</th>
                    <td colspan="3"><?php echo $aspecto['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Discriminación:</th>
                    <td><?php echo $discriminacion['nombre']; ?></td>
                    <th><?php echo $entity["label"]; ?>:</th>
                    <td><?php echo $entity['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Fecha de vencimiento:</th>
                    <td><?php echo $data['fecha_proximo_vencimiento']; ?></td>
                    <th>Fecha de la última actualización:</th>
                    <td><?php echo $data['fecha_ultima_actualizacion']; ?></td>
                </tr>  
                <tr>
                    <th>Estado de actualización:</th>
                    <td><?php echo $estado['nombre']; ?></td>
                    <th>Estado del registro:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr> 
                      
            </table>
        </div>

<?php   include("./detalleIndicador.php");


 writeFooter(); ?>