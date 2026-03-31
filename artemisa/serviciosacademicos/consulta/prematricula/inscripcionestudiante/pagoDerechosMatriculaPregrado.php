<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";

include(realpath(dirname(__FILE__)."/../../../../assets/Complementos/piepagina.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidad/Estudiante.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidad/OrdenPagoEntity.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidad/EstudianteGeneral.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidad/Carrera.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidadDAO/CarreraDAO.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidadDAO/OrdenPagoDAO.php"));
require_once(realpath(dirname(__FILE__)."/../../../../sala/entidadDAO/EstudianteDAO.php"));
require_once(realpath(dirname(__FILE__)."/../../../../serviciosacademicos/funciones/ordenpago/claseordenpago.php"));
require_once(realpath(dirname(__FILE__)."/../../../../serviciosacademicos/funciones/funcionip.php"));

$carreraObj = new Carrera();
$estudianteObj = new Estudiante();
$estudianteGeneralObj = new EstudianteGeneral();

$carreraDao = new \Sala\entidadDAO\CarreraDAO($carreraObj);
$estudianteDao = new \Sala\entidadDAO\EstudianteDAO($estudianteObj);

if (!isset($_SESSION["MM_Username"]) && trim($_SESSION["MM_Username"]) == '') {
    $_SESSION['auth'] = true;
    $_SESSION["MM_Username"] = "Manejo Sistema";
    $_SESSION['rol'] = "1";
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pagos pendientes</title>
    <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    <?php
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/cornerIndicator/cornerIndicator.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/normalize.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-page.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/general.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/chosen.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/custom.css");

        echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/jquery-3.6.0.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/bootstrap.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/custom.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/spiceLoading/pace.min.js");
    ?>
    <script type="text/javascript">
        function regresarIngresoEC() {
            location.href = 'ingresoPagoDerechosMatriculaPregrado.php';
        }
    </script>
</head>
<body>
<header id="header" role="banner">
    <div class="header-inner">
        <div class="header_first">
            <div class="block block-system block-system-branding-block">
                <div class="block-inner">
                    <div class="title-suffix"></div>
                    <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                        <img alt="Universidad El Bosque" src="../../../../assets/ejemplos/img/logo.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row centered-form">
        <div class="panel-body form-group">
            <center>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <?php
                #obtiene carreras por las ordenes pendientes del estudiante
                $carrerasOrder = $carreraDao->getCarreersOrderPymentsByStudent($_SESSION['numerodocumento']);

                ?>
                <h1>PAGOS PENDIENTES DE SALA</h1><br>
                <?php

                #datos del estudiante por numero de documento
                $estudianteGeneralObj->setNumeroDocumento($_SESSION['numerodocumento']);
                $estudianteGeneralObj->getById();


                $idestudiantegeneral = $estudianteGeneralObj->getIdestudiantegeneral();
                $nombre = $estudianteGeneralObj->getNombresestudiantegeneral() . " " . $estudianteGeneralObj->getApellidosestudiantegeneral();
                $documento = $estudianteGeneralObj->getNumeroDocumento();

                ?>

                <?php if(($nombre && $nombre !== ' ') && ($documento && $documento !== '')): ?>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-line-ColorBrandDark45-headers">
                            <tr id="trtituloNaranjaInst">
                                <th colspan="2" style="color: #FFFFFF;">Nombre Estudiante</th>
                                <th style="color: #FFFFFF;">Documento</th>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 12px"><?php echo $nombre; ?></td>
                                <td style="font-size: 12px"><?php echo $documento; ?></td>
                            </tr>
                        </table>
                    </div>
                
                <?php endif; ?>

                <?php
                $ordenPagoObj = new OrdenPagoEntity();
                if(count($carrerasOrder) > 0){
                    foreach ($carrerasOrder as $carrera) {

                        $ordenDAO = new \Sala\entidadDAO\OrdenPagoDAO($ordenPagoObj);
                        $orders = $ordenDAO->getOrdersByCarreerByStuden($_SESSION['numerodocumento'], $carrera['codigocarrera']);

                        ?>
                        <div class="col-md-10 col-md-offset-1 ">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tr id="tdtituloNaranjaInst">
                                        <th style="width: 50%">Programa</th>
                                        <th style="width: 50%">Modalidad</th>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px"><?php echo $carrera['nombrecarrera']?></td>
                                        <td style="font-size: 12px"><?php echo $carrera['nombremodalidadacademica']?></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr id="">
                                        <th>Orden</th>
                                        <th>Periodo</th>
                                        <th>Valor</th>
                                        <th>Fecha</th>
                                        <th>Pago</th>
                                    </tr>
                                    <?php
                                    foreach($orders as $order){
                                        $orderPayment = new OrdenPagoEntity();
                                        $orderPayment->setNumeroordenpago($order['numeroordenpago']);
                                        $orderPayment->getById();
                                        $ordenPagoDAO = new \Sala\entidadDAO\OrdenPagoDAO($orderPayment);

                                        $dataFechaOrdenPago = $ordenPagoDAO->getDateOrderPayment($order['numeroordenpago']);
                                        $actualDate = new DateTime(date('Y-m-d'));
                                        $expiredDate = new DateTime($dataFechaOrdenPago['fechaordenpago']);
                                        $diffDate = $expiredDate >= $actualDate;

                                        ?>
                                        <tr>
                                            <td>
                                                <a onclick='window.open("../../../funciones/ordenpago/verorden.php?numeroordenpago=<?php echo $orderPayment -> getNumeroordenpago()?>&codigoestudiante=<?php echo $orderPayment->getCodigoEstudiante()?>&codigoperiodo=<?php echo $orderPayment->getCodigoPeriodo()?>&ipimpresora=","miventana","width=1070,height=550,left=10,top=10,sizeable=yes,scrollbars=yes")' id="aparencialink">
                                                    <?php echo $orderPayment->getNumeroordenpago();?>
                                                </a>
<!--                                                <a href="--><?php //echo "../../../funciones/ordenpago/verorden.php?numeroordenpago=".$order['numeroordenpago']."&codigoestudiante=".$orderPayment->getCodigoEstudiante()."&codigoperiodo=".$orderPayment->getCodigoPeriodo()."&ipimpresora="; ?><!--">-->
<!--                                                    --><?php //echo $orderPayment->getNumeroordenpago();?>
<!--                                                </a>-->
                                            </td>
                                            <td><?php echo $orderPayment->getCodigoPeriodo();?></td>
                                            <td><?php echo number_format($dataFechaOrdenPago['valorfechaordenpago'])?></td>
                                            <td><?php echo $dataFechaOrdenPago['fechaordenpago']?>
                                            </td>
                                            <td>
                                                <?php
                                                if($diffDate)
                                                {?>
                                                    <b>
                                                        <a href="<?php echo "../../../funciones/ordenpago/verorden.php?pse=" . $dataFechaOrdenPago['valorfechaordenpago'] . "&numeroordenpago=".$order['numeroordenpago']."&codigoestudiante=".$orderPayment->getCodigoEstudiante()."&codigoperiodo=".$orderPayment->getCodigoPeriodo()."&ipimpresora="; ?>">Pagos Electrónicos</a>
                                                    </b>
                                                    <a onclick='window.open("../../../funciones/ordenpago/factura_pdf_nueva/confirmacion.php?numeroordenpago=<?php echo $order['numeroordenpago']?>&amp;codigoestudiante=<?php echo $orderPayment->getCodigoEstudiante()?>>&amp;codigoperiodo=<?php echo $orderPayment->getCodigoPeriodo()?>&amp;documentoingreso=<?php echo $documento?>","miventana","width=1070,height=550,left=10,top=10,sizeable=yes,scrollbars=yes")' id="aparencialink">Imprimir (pago en bancos)</a>
                                                <?php
                                                }
                                                else
                                                {?>
                                                   <b>ORDENES POR PAGAR FUERA DE LA FECHA LIMITE</b>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }//foreach
                                    ?>

                                </table>
                            </div>

                        </div>

                        <?php
                    }
                }else
                    {?>
                        <div class="col-md-12">
                            <h2>En este momento no cuenta con ordenes pendientes de pago.</h2>
                        </div>
                    <?php
                    }
                ?>
                </div>
            </center>
        </div>
    </div>
</div>

<?php

/* Adición de la integracion con Sala Virtual */

    // 1. se obtiene la url por enviar

    
    $protocol = "https";
    
    if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"
    ||$Configuration->getEntorno()=="Preproduccion")
    {
        $protocol = "http";
    }
    
    $urlToSend = $protocol."://".$_SERVER['HTTP_HOST']."/".$_SERVER['REQUEST_URI'].$_SESSION['numerodocumento']."&moduloPublico";
   
    // 2. cambiar la informacion parametrizada
    $urlToSend = str_replace('artemisa','artemisavirtual',$urlToSend);
    
    // 3. Realizar la conexion
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlToSend);
        
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $curl_output = curl_exec ($ch); 

    curl_close ($ch);
  
    // 4. Imprimir resultado
    echo $curl_output;
   

?>
<div class="container">
    <div class="row centered-form">
        <div class="panel-body form-group">
            <center>
                <input type="button" value="Regresar" onClick="regresarIngresoEC()" class="btn btn-fill-green-XL">
            </center>
        </div>
    </div>
</div>            

<?php
$piepagina = new piepagina;
$ruta = '../../../../';
echo $piepagina->Mostrar($ruta);
?>
</body>
</html>
