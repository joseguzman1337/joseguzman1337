<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan los archivos de configuracion y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Julio 9, 2018
*/
require(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require (PATH_ROOT.'/kint/Kint.class.php');
}

/**
 * Caso 278.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 21 de febrero 2019.
 */
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}

Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');
$itemId = Factory::getSessionVar('itemId');
/**
 * Caso 370.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 20 de Febrero 2019.
*/

require_once('../../../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}

require(PATH_ROOT."/serviciosacademicos/funciones/funcionpassword.php");
require_once(PATH_ROOT.'/serviciosacademicos/educacionContinuada/Excel/reader.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Actualización de pagos</title>
        <?php
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se utilizan las funciones de inclusion de librerias js y css para manejo de cache
         * @since Julio 9, 2018
        */
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/mgi/css/styleOrdenes.css");

        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/mgi/js/jquery.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/mgi/js/jquery-ui-1.8.21.custom.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/mgi/js/functions.js");
        ?>
    </head>
    <body>
        <div class="container">
            <?php
            if(!isset($_POST['buscar'])){
                ?>
                <div id="contenido" style="margin-top: 10px;">
                    <h2>Pago Masivo de Ordenes</h2>
                    <br/>
                    <div id="form"> 
                        <form action="actualizarOrdenesDePago.php" id="form_test" method="POST" enctype="multipart/form-data">
                            <h4>Pago de ordenes en SALA</h4>
                            <h4>Recuerde que las columnas deben contener:</h4>
                            <ul>
                                <li>A: ORDEN</li>
                                <li>B: VALOR_PAGADO</li>
                                <li>C: FECHA_PAGO. Formato de Fecha: (Dia-3 iniciales del mes en Inglés-año)<br>
                                 * Ejemplo: (01-JAN-19) Formato Texto.</li>
                            </ul>
                            <br/>
                            <label for="file">Archivo con las ordenes: Formato .xls</label>
                            <input accept="application/vnd.ms-excel" type="file" name="file" id="file">
                            <br/>
                            <br/>
                            <input class="btn btn-fill-green-XL first" type="submit" name="buscar" value="Procesar ordenes" />
                        </form>
                    </div>
                </div>
                <?php
            }
            
            if(isset($_POST['buscar']) &&  isset($_FILES)){
                /**
                 * @modified David Perez <perezdavid@unbosque.edu.co>
                 * @since  Julio 27, 2018
                 * Se cambia de lugar valoraporte para futuras operaciones
                */
                $valoraporte = "35000";
                //TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                
                $data->read($_FILES["file"]["tmp_name"]);
                $filas = $data->sheets[0]['numRows'];
                
                $contador=0;
                $errores = 0;
                $k=1;
                //se asume la primera como titulo
                $arrayNoExiste = array();
                $arrayDiferente = array();
                $arrayAnulada = array();
                $arrayYaPaga = array();
                $arrayProcesadas = array();
                echo "<table class='table' >"
                    . "<tr>"
                    . "<td>#</td><td>Numero orden</td>"
                    . "<td>Valor a pagar</td>"
                    . "<td>Valor pagado</td>"
                    . "<td>Resultado</td>"
                    . "<tr>";
                
                for ($z = 2; $z <= $filas; $z++){
                    echo "<tr>";
                    echo "<td>".$k."</td>";
                    if(!empty($data->sheets[0]['cells'][$z][1])){
                        $fields['numeroordenpago']=@$data->sheets[0]['cells'][$z][1];
                        
                        /**
                         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                         * Se agrega una consulta para validar si la orden ya esta paga en sala antes de hacer cualquier otra
                         * accion, si ya esta paga no se hace nada mas
                         * @since Octubre 18, 2018
                         */
                        $sql = "SELECT o.codigoestadoordenpago "
                                . " FROM ordenpago o "
                                . " INNER JOIN fechaordenpago fop ON (fop.numeroordenpago = o.numeroordenpago) "
                                . " WHERE o.numeroordenpago = ".$db->qstr($fields['numeroordenpago']);
                        
                        $estadoOrden = $db->Execute($sql) or die("$sql<br>".mysql_error());
                        $rowEstadoOrden = $estadoOrden->FetchRow();
                        if($rowEstadoOrden['codigoestadoordenpago']==40 || $rowEstadoOrden['codigoestadoordenpago']==41){
                            $arrayYaPaga[] = $fields;
                            echo "<td>".$fields['numeroordenpago']."</td>";
                            echo "<td></td><td></td><td>Ya esta pagada</td>";
                        }else{
                            /**
                             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                             * Se agrega una consulta para validar si la orden tiene un plan de pagos, en cuyo caso se toma
                             * como orden padre
                             * @since Octubre 18, 2018
                             */
                            $ordenPadreOriginal = $fields['numeroordenpago'];
                            $padre = false;
                            $query = "SELECT dp.numeroordenpago "
                                    . " FROM  ordenpago op "
                                    . " INNER JOIN prematricula p ON (op.idprematricula = p.idprematricula) "
                                    . " INNER JOIN detalleprematricula dp ON ( dp.idprematricula = p.idprematricula ) "
                                    . " WHERE op.numeroordenpago = ".$db->qstr($fields['numeroordenpago'])
                                    . "  AND  dp.codigoestadodetalleprematricula = 30 "
                                    . " LIMIT 1";

                            $ordenesPadre = $db->Execute($query);
                            $row_ordenesPadre = $ordenesPadre->FetchRow();
                            if(!empty($row_ordenesPadre) && ($row_ordenesPadre['numeroordenpago']!=$fields['numeroordenpago'])){
                                $padre = true;
                                $fields['numeroordenpago'] = $row_ordenesPadre['numeroordenpago'];
                            }                        

                            $fields['valorpagado']=@$data->sheets[0]['cells'][$z][2];
                            $fields['fechapago']=@$data->sheets[0]['cells'][$z][3];

                            $dateObj = \DateTime::createFromFormat('d-M-y', $fields['fechapago']);
                            if (!$dateObj){
                                throw new \UnexpectedValueException("Could not parse the date");
                            }

                            $fields['fechapago'] = $dateObj->format('Y-m-d');

                            /**
                             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                             * Se agrega una consulta para validar si la orden ya esta paga en sala antes de hacer cualquier otra
                             * accion, si ya esta paga no se hace nada mas
                             * @since Octubre 18, 2018
                             */
                            $sql = "SELECT o.codigoestadoordenpago "
                                    . " FROM ordenpago o "
                                    . " INNER JOIN fechaordenpago fop ON (fop.numeroordenpago = o.numeroordenpago) "
                                    . " WHERE o.numeroordenpago = ".$db->qstr($fields['numeroordenpago']);

                            $estadoOrden = $db->Execute($sql) or die("$sql<br>".mysql_error());
                            $rowEstadoOrden = $estadoOrden->FetchRow();
                            if($rowEstadoOrden['codigoestadoordenpago']==40 || $rowEstadoOrden['codigoestadoordenpago']==41){
                                $arrayYaPaga[] = $fields;
                                if($padre){
                                    echo "<td>".$fields['numeroordenpago']." - padre: ".$ordenPadreOriginal."</td>";
                                }else{
                                    echo "<td>".$fields['numeroordenpago']."</td>";
                                }

                                echo "<td></td><td></td><td>Ya esta pagada</td>";
                                if($padre){
                                        $sql = "UPDATE ordenpago SET codigoestadoordenpago='40' WHERE (numeroordenpago='".$ordenPadreOriginal."') LIMIT 1";
                                        $db->Execute($sql) or die(mysql_error());
                                } 
                            }else{

                                /**
                                 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                                 * Se modifica la consulta de modo que  se agrupen los resultados cuando 
                                 * hayan mas de una fecha y valor iguales
                                 * @since Octubre 18, 2018
                                 */
                                //consulta el estado de la orden
                                $sql = "SELECT o.numeroordenpago, o.codigoestadoordenpago, "
                                        . " fop.valorfechaordenpago AS valorapagar "
                                        . " FROM ordenpago o "
                                        . " INNER JOIN fechaordenpago fop ON (fop.numeroordenpago = o.numeroordenpago) "
                                        . " WHERE o.numeroordenpago = ".$db->qstr($fields['numeroordenpago'])
                                        . " AND (fop.valorfechaordenpago = ".$db->qstr($fields['valorpagado'])
                                        . " OR fop.valorfechaordenpago = ".$db->qstr($fields['valorpagado']- $valoraporte).")";
                                $t = ($sql." GROUP BY fop.fechaordenpago, fop.valorfechaordenpago");
                                $ordenes = $db->Execute($sql." GROUP BY fop.fechaordenpago, fop.valorfechaordenpago") or die("$sql<br>".mysql_error());
                                $row_ordenes = $ordenes->FetchRow();

                                if (($ordenes->NumRows()) > 1){
                                    $sql .=" AND ".$db->qstr($fields['fechapago'])." <= fop.fechaordenpago" 
                                            . " ORDER BY fop.fechaordenpago ASC"
                                            . " LIMIT 0,1";
                                    $ordenes = $db->Execute($sql) or die("$sql<br>".mysql_error());
                                    $row_ordenes = $ordenes->FetchRow();
                                }
                                /* FIN MODIFICACION */

                                //consulta si los datos de prematricula existen
                                $sql2 = "SELECT DISTINCT  p.idprematricula AS prematricula, p.codigoestadoprematricula, "
                                        . " dp.idprematricula AS detalleprematricula, dp.codigoestadodetalleprematricula "
                                        . " FROM detalleprematricula dp "
                                        . " INNER JOIN prematricula p ON (dp.idprematricula = p.idprematricula) "
                                        . " WHERE dp.numeroordenpago = ".$fields['numeroordenpago'];

                                $ordenes2 = $db->Execute($sql2) or die("$sql2<br>".mysql_error());
                                $row_ordenes2 = $ordenes2->FetchRow();

                                $sumarotiaaporte= $row_ordenes["valorapagar"]  + $valoraporte;
                                if($padre){
                                    echo "<td>".$fields['numeroordenpago']." - padre: ".$ordenPadreOriginal."</td>";
                                }else{
                                    echo "<td>".$fields['numeroordenpago']."</td>";
                                } 
                                //echo "<br /><br />Reporte para la orden ".$fields['numeroordenpago']."<br />";
                                if(is_null($row_ordenes["numeroordenpago"])){
                                    $arrayNoExiste[] = $fields;
                                    //echo "La orden ".$fields['numeroordenpago']." no existe.<br />";
                                    echo "<td> no existe.</td>";
                                }elseif($fields['valorpagado'] < $row_ordenes["valorapagar"] || ($sumarotiaaporte < $fields['valorpagado'])){
                                    /**
                                     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                                     * Se modifican la validacion, solamente deberia mostrar error cuando el valor pagado sea menor que el valor a pagar
                                     * @since Julio 6, 2018
                                    */
                                    $newField = array();
                                    $newField['valorapagar'] = $row_ordenes["valorapagar"];                            
                                    $arrayDiferente[] = array_merge($fields, $newField);
                                    //echo "El valor a pagar es diferente al valor pagado. Valor a pagar: ".$row_ordenes["valorapagar"].", valor pagado: ".$fields['valorpagado']."<br />";    
                                    echo "<td>".$row_ordenes["valorapagar"]."</td>";
                                    echo "<td>".$fields['valorpagado']."</td>";
                                    echo "<td>El valor a pagar es diferente al valor pagado</td>";
                                }elseif($row_ordenes["codigoestadoordenpago"] == 40 || $row_ordenes["codigoestadoordenpago"] == 41){
                                    $arrayYaPaga[] = $fields;
                                    echo "<td></td><td></td><td>Ya esta pagada</td>";
                                    //echo "La orden ".$fields['numeroordenpago']." ya está paga.<br />";
                                }elseif($row_ordenes["codigoestadoordenpago"] == 20 || $row_ordenes["codigoestadoordenpago"] == 21){
                                    $arrayAnulada[] = $fields;
                                    echo "<td></td><td></td><td>está anulada</td>";
                                    //echo "La orden ".$fields['numeroordenpago']." está anulada.<br />";
                                }else{
                                    //Después de validar se aplican los cambios
                                    if(is_null($row_ordenes2["prematricula"])){
                                        $sql = "UPDATE ordenpago SET codigoestadoordenpago='40' WHERE (numeroordenpago='".$fields['numeroordenpago']."') LIMIT 1";
                                        $db->Execute($sql) or die(mysql_error());

                                        /**
                                         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                                         * Cuando la orden que se procesa tiene una orden padre, se paga tambien la orden padre
                                         * @since Octubre 18, 2018
                                         */
                                        if($padre){
                                                $sql = "UPDATE ordenpago SET codigoestadoordenpago='40' WHERE (numeroordenpago='".$ordenPadreOriginal."') LIMIT 1";
                                                $db->Execute($sql) or die(mysql_error());
                                        }
                                    }else{
                                        //Paga orden
                                        $sql = "UPDATE ordenpago SET codigoestadoordenpago='40' WHERE (numeroordenpago='".$fields['numeroordenpago']."') LIMIT 1";
                                        $db->Execute($sql) or die(mysql_error());

                                        //Activa prematricula
                                        $sql = "UPDATE prematricula SET codigoestadoprematricula='40' WHERE (idprematricula='".$row_ordenes2["prematricula"]."') LIMIT 1";
                                        $db->Execute($sql) or die(mysql_error());

                                        //Activa detalle prematricula
                                        $sql = "UPDATE detalleprematricula SET codigoestadodetalleprematricula='30' WHERE  (numeroordenpago='".$fields['numeroordenpago']."')";
                                        $db->Execute($sql) or die(mysql_error());

                                        /**
                                         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                                         * Cuando la orden que se procesa tiene una orden padre, se paga tambien la orden padre
                                         * @since Octubre 18, 2018
                                         */
                                        if($padre){
                                                $sql = "UPDATE ordenpago SET codigoestadoordenpago='40' WHERE (numeroordenpago='".$ordenPadreOriginal."') LIMIT 1";
                                                $db->Execute($sql) or die(mysql_error());
                                        }
                                    }

                                    $arrayProcesadas[] = $fields;
                                    echo "<td></td><td></td><td>procesada correctamente.</td>";
                                    //echo "Orden ".$fields['numeroordenpago']." procesada correctamente.<br />";
                                }
                            }
                        }
                    }
                    
                    $k++;
                    echo "</tr>";
                }
                echo "</table><br><br><br>";
                
                echo "<table class='table'><tr>";
                echo "<td>Ordenes no existen: ". count($arrayNoExiste)."<br></td>";
                echo "<td>Ordenes con diferente valor: ". count($arrayDiferente)."<br>";
                echo "<td>Ordenes ya están pagas: ". count($arrayYaPaga)."<br></td>";
                echo "<td>Ordenes anuladas: ". count($arrayAnulada)."<br></td>";
                echo "<td>Ordenes procesadas correctamente: ". count($arrayProcesadas)."<br></td>";
                
            }
        
            ?>
        </div>
    </body>
</html>