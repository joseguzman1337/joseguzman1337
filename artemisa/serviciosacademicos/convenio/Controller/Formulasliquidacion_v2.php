<?php

/**
 * Nueva estructura / Sala 2.0 ft Composer
 * @modified Miguel Castañeda <castanedamiguel@unbosque.edu.co>
 * @since 05 de Junio de 2019
 */

/*
 * Cargue de esquema composer
 * A tener en cuenta esta inclusión genera la autocarga del archivo adaptor.php el cual
 * inicializa todo lo necesario para sala v1.0 esquema hecho por Andres y Diego
 *
 *
 *
 */
require_once (__DIR__ . '/../../../sala/esquemaComposer/vendor/autoload.php');

use \App\controladores\convenios\FormulasLiquidacionController;

$objFormLiquidaciones = new FormulasLiquidacionController();

// Recepción de peticiones tipo GET / Visualización de vistas

if (isset($_GET['vista'])) {

    switch ($_GET['vista']) {

        case 'liquidacionesCarrera':

            $objFormLiquidaciones->listadoPorPrograma(@$_GET['idcarrera']);

            break;

        default:

            echo "<br> UPS! ruta de vista invalida!";

            break;

    }
}


// Recepción de peticiones GET procesos

if (isset($_GET['proceso']))
{

    switch($_GET['proceso'])
    {

        case 'validarFormula':

            // Limpiar buffer ya que genera errores en archivo adapter.php de sala v1.0
            ob_clean();

            $objFormLiquidaciones->verificarFormula($_GET['esquemaFormula']);

            break;

        default:

            echo "<br> UPS! ruta de proceso invalida!";

            break;

    }

}

// Recepción de peticiones POST formulas
if (isset($_POST['procesoFormula']))
{

    switch ($_POST['procesoFormula'])
    {
        case 'crearFormulaParaConvenio':

            // Limpiar buffer ya que genera errores en archivo adapter.php de sala v1.0
            ob_clean();

            // Validar formulario
            $request = new \App\FormRequest\convenios\FormRequestCrearFormulaLiq();
            $request = $request->__validarPeticion();
            $objFormLiquidaciones->crearFormulaParaEntidad($request, $_GET['idConvenio'], $_GET['idCarrera'], $_POST['vigencia'], $_POST['esquemaFormula']);

            break;

        case 'actualizarEstadoFormula':

            // Limpiar buffer ya que genera errores en archivo adapter.php de sala v1.0
            ob_clean();
            $objFormLiquidaciones->actualizarEstadoFormula($_GET['idFormula'], $_POST['estado']);

            break;

        case 'editarFormulaParaConvenio':

            // Limpiar buffer ya que genera errores en archivo adapter.php de sala v1.0
            ob_clean();
            $objFormLiquidaciones->actualizarFormula($_POST['idFormula'], $_POST['esquemaFormula']);

            break;

        case 'validarRangoFechas' :

            // Limpiar buffer ya que genera errores en archivo adapter.php de sala v1.0
            ob_clean();

            // Validar formulario
            $request = new \App\FormRequest\convenios\FormRequestValidarRangoFechasFormulaLiq();
            $request = $request->__validarPeticion();
            $objFormLiquidaciones->verificarRangoFechas($request, $_POST['idConvenio'], $_POST['idCarrera'], $_POST['vigencia'], $_POST['idFormula']);

            break;


        default:
            echo 'UPS! peticion en formulas no encontrada';
            break;
    }



}