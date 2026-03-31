<?php

    include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Ver Detalle Función",TRUE,$proyectoNumericos);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_numericos();
       $data = $utils->getDataEntity("funcion", $id);
       //var_dump($utils);
       //var_dump($data);
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Función</h2>
            <table class="detalle">
                <tr>
                    <th>Nombre:</th>
                    <td><?php echo $data['nombre']; ?></td>
                    <th>Estado:</th>
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

<?php   //include("./detalleResponsables.php");

 writeFooter(); ?>