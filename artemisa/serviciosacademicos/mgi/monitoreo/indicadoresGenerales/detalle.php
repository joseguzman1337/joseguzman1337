<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Definición Indicador",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
        $utils = new Utils_monitoreo();
        /*
         * @modified Andres Ariza <arizaandre@unbosque.edu.co>
         * se inicializa la variable $id para permitir poder pasar el parametro  como referencia
         * @since Agosto 15, 2018
         */
        $id = $_REQUEST["id"];
        $data = $utils->getDataEntity("indicadorGenerico", $id);
        $aspecto = $utils->getDataEntity("aspecto", $data["idAspecto"]);
        $tipo = $utils->getDataEntity("tipoIndicador", $data["idTipo"]);
        $area = $utils->getDataNonEntity($db, "nombre,idsiq_area", "siq_area", "idsiq_area='" . $data["area"] . "'");
        $caracteristica = $utils->getDataEntity("caracteristica", $aspecto["idCaracteristica"]);
        $factor = $utils->getDataEntity("factor", $caracteristica["idFactor"]);
        $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"], "");
        $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"], "");
    }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Definición Indicador</h2>
            <table class="detalle">
                <tr>
                    <th>Código:</th>
                    <td><?php echo $data['codigo']; ?></td>
                    <th>Identificador:</th>
                    <td><?php echo $data['idsiq_indicadorGenerico']; ?></td>
                </tr>
                <tr>
                    <th>Nombre:</th>
                    <td colspan="3"><?php echo $data['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Tipo de Indicador:</th>
                    <td><?php echo $tipo['nombre']; ?></td>
                    <th>Área:</th>
                    <td><?php echo $area['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Descripción:</th>
                    <td colspan="3"><?php echo $data['descripcion']; ?></td>
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
                </tr>
                <tr>
                    <th>Estado del registro:</th>
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

<?php  
 writeFooter(); ?> 