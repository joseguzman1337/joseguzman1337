<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    
    $db = writeHeader("Ver Detalle Periodicidad",TRUE,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_monitoreo();
       $id = $_REQUEST["id"];
       $data = $utils->getDataEntity("periodicidad", $id);    
       $tipo = $utils->getDataEntity("tipoValorPeriodicidad", $data["tipo_valor"]); 
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Periodicidad</h2>
            <table class="detalle">
                <tr>
                    <th>Nombre:</th>
                    <td colspan="3"><?php echo $data['periodicidad']; ?></td>
                </tr>
                <tr>
                    <th>Identificador:</th>
                    <td><?php echo $data['idsiq_periodicidad']; ?></td>
                    <th>Estado:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr>
                <tr>
                    <th>Valor:</th>
                    <td><?php echo $data['valor']; ?></td>
                    <th>Tipo de valor:</th>
                    <td><?php echo $tipo['nombre']; ?></td>
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

<?php writeFooter(); ?>