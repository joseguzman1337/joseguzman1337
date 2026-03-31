<?php

/*
 * INCLUSIÓN DE BACK PARA VALIDACIÓN DE PROGRAMA Y CONCEPTO PEOPLE
 *
 * debe definir la variable $cargarVerificacionProgramaFtConcepto_Back = true;
 * antes de realizar el require de este archivo para que se cargue la validación back
 *
 */
if ( isset($cargarVerificacionProgramaFtConcepto_Back) && $cargarVerificacionProgramaFtConcepto_Back == true )
    require_once (__DIR__ . '/verificarConceptoPorPrograma.php');

?>




<?php

/*
 * INCLUSIÓN DE FRONT PARA VALIDACIÓN DE PROGRAMA Y CONCEPTO PEOPLE
 *
 * debe definir la variable $cargarVerificacionProgramaFtConcepto_Front = true;
 * antes de realizar el require de este archivo para que se cargue la validación front
 *
 */
if(isset($cargarVerificacionProgramaFtConcepto_Front) && $cargarVerificacionProgramaFtConcepto_Front == true) : ?>

    <!-- LIBRERIAS Y SCRIPTS PARA EJECUCIÓN DE VALIDACIÓN PROGRAMAS Y CONCEPTOS PEOPLE-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo $Configuration->getHTTP_SITE()?>/assets/js/jquery-3.1.1.js"></script>
    <script src="<?php echo $Configuration->getHTTP_ROOT()?>/serviciosacademicos/consulta/ordenpagovarias/verificarConceptosPorPrograma.js"></script>

    <script>
        <?php // Para acceder a la variable $Configuration requerir archivo (sala/includes/adaptador.php) ?>
        var urlRoot = '<?php echo $Configuration->getHTTP_ROOT()?>';
        var objOrdenesPago = new ClassOrdenesPago(urlRoot);

    </script>

<?php endif ?>







