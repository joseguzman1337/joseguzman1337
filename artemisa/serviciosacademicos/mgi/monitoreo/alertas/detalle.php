<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Tipo de Alerta",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
    $tipo = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_monitoreo();
       $data = $utils->getDataEntity("tipoAlerta", $id);  
       if($data["idTipoResponsable"]!=NULL){
            $tipo = $utils->getDataEntity("tipoResponsabilidad", $data["idTipoResponsable"]); 
       }
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Tipo de Alerta</h2>
            <table class="detalle">                
                <tr>
                    <th>Nombre:</th>
                    <td><?php echo $data['nombre']; ?></td>
                    <th>Tipo del responsable destinatario:</th>
                    <td><?php echo $tipo['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Asunto del correo:</th>
                    <td><?php echo $data['asunto_correo']; ?></td>
                    <th>Estado del registro:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr>
                <tr>
                    <th>Plantilla del mensaje:</th>
                    <td colspan="3"><?php echo $data['plantilla_correo']; ?></td>
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

<?php   include("./detalleDestinatarios.php");

 writeFooter(); ?>