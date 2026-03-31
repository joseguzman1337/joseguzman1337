<?php

require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
require_once("funciones/obtener_datos.php");
$datos=new datos_ordenpago($db,$_GET['codigoestudiante'],$_GET['numeroordenpago']);
$datos->obtener_conceptos();
$datos->obtener_datos_estudiante();
$codigoconcepto= $datos->codigoconcepto;
$codigomodalidad = $datos->codigomodalidadacademica;

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <?php
        //VALIDACION APORTEBECA SOLO PREGRADO Y POSTGRADO, CON EL FIN DE MOSTRAR LA OPCIÓN DE APORTE.
        $numero_ordenes = $datos->obtener_nuevo_formato();
        
        if($numero_ordenes != '' && ($codigomodalidad == 200 || $codigomodalidad == 300 || $codigomodalidad == 800 || $codigomodalidad == 810)){
            //VALIDA SI EXISTE EL APORTE EN LA TABLA AportesBecas PARA QUE IMPRIMA EL FORMATO CON APORTE O SIN APORTE
            $resultado_aporte = $datos->consulta_aporte($_GET['numeroordenpago']);
            if($resultado_aporte==1){
                $facturaRedirecion= 'facturaAportecredicorp';
            }
            else{
               $facturaRedirecion= 'facturacredicorp';
            }
        }else{
            $facturaRedirecion= 'facturacredicorp';
        }
    ?>
    <body>
        <div style="width:100%">
            <div style="width:518px; float:left">
                <img src="../../../../imagenes/avisoimpresionfactura.jpg" width="518" height="500">
              <br>
                <input name="Aceptar" type="submit" id="Aceptar" value="Certifico"
                       onClick="window.open('<?php echo $facturaRedirecion; ?>.php<?php
                       echo "?numeroordenpago=".$_GET['numeroordenpago']."&codigoestudiante=".
                           $_GET['codigoestudiante']."&codigoperiodo=".
                           $_GET['codigoperiodo']."&documentoingreso=".$_GET['documentoingreso']."";
                       ?>','factura','width=800,height=600,left=10,top=10,sizeable=yes,scrollbars=no');
                       window.close()" style="color:#FF0033 ">
                <input name="Cancelar" type="submit" id="Cancelar" value="No certifico" onClick="window.close()" style="color:#ff0033">
            </div>
            <div style="float:left; padding-left: 10px;"><img src="../../../../imagenes/popup_landing-fundraising.jpg"></div>
        </div>
    </body>
</html>
