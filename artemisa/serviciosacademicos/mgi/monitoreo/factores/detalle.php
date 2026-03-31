<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Factor",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
        $id = $_REQUEST["id"];
       $utils = new Utils_monitoreo();
       $data = $utils->getDataEntity("factor", $id);       
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Factor</h2>
            <table class="detalle">
                <tr>
                    <th>Código:</th>
                    <td><?php echo $data['codigo']; ?></td>
                    <th>Identificador:</th>
                    <td><?php echo $data['idsiq_factor']; ?></td>
                </tr>
                <tr>
                    <th>Nombre:</th>
                    <td colspan="3"><?php echo $data['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Descripción:</th>
                    <td colspan="3"><?php echo $data['descripcion']; ?></td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td colspan="3"><?php writeStatus($data['codigoestado']); ?></td>
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

 writeFooter(); ?>