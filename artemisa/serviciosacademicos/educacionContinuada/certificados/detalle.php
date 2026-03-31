<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Firma",TRUE);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
   
    if(isset($_REQUEST["id"])){  
       $utils = Utils::getInstance();
       $id = str_replace('row_','',$_REQUEST["id"]);
       $data = $utils->getDataEntity("firmaEscaneadaEducacionContinuada", $id,"idfirmaEscaneadaEducacionContinuada");  
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Docente</h2>
            <table class="detalle">
                <tr>
                    <th>Nombre:</th>
                    <td colspan="3"><?php echo $data['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Cargo:</th>
                    <td><?php echo $data['cargo']; ?></td>
                    <th>Organización/Unidad:</th>
                    <td><?php echo $data['unidad']; ?></td>
                </tr>
                <tr>
                    <th>Firma:</th>
                    <td colspan="3"><img src="<?php echo $data['ubicacionFirmaEscaneada']; ?>" style="max-width:800px" /></td>
                </tr>
                <tr>
                    <th>Fecha creación:</th>
                    <td><?php echo $data['fecha_creacion']; ?></td>
                    <th>Fecha modificación:</th>
                    <td><?php echo $data['fecha_modificacion']; ?></td>
                </tr>            
            </table>
        </div>

<?php  

 writeFooter(); ?>