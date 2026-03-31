<?php namespace App\controladores\convenios;

use App\controladores\ControladorDefecto;
use App\controladores\convenios\core\FormulasLiquidacion;
use App\FormRequest\convenios\FormRequestCrearFormulaLiq;
use App\FormRequest\convenios\FormRequestValidarRangoFechasFormulaLiq;
use App\utilidades\vistas\twig\Vista;

class FormulasLiquidacionController extends ControladorDefecto
{

    /**
     * @var FormulasLiquidacion
     */
    private $core;

    public static $urlProcesos = 'serviciosacademicos/convenio/Controller/Formulasliquidacion_v2.php';

    public function __construct()
    {

        parent::__construct();
        $this->core = new FormulasLiquidacion();

    }

    /**
     * Recepción de la petición y respuesta
     *
     * @param $idPrograma
     */
    public function listadoPorPrograma($idCarrera)
    {

        try{

            $datosBase = $this->core->getFormulasPorCarrera($idCarrera);

            $programa = $datosBase['nombreCarrera'];
            $camposFormula = $datosBase['camposFormula'];
            $camposFormulaDigitar = $datosBase['camposFormulaDigitar'];
            $operadores = FormulasLiquidacion::$operadores;
            $formulas = $this->getFormulasPorEntidad($datosBase['formulas']);

            // url de procesos
            $urlModulo = self::$urlProcesos;


            // arreglo de valores para vista
            $data = compact(
                'formulas',
                'programa',
                'camposFormula',
                'operadores',
                'camposFormulaDigitar',
                'urlModulo',
                'idCarrera'
            );

            echo Vista::render('modulos/convenios/paginas/formulasPorCarrera.html.twig', $data);

        }catch(\Exception $e){

            var_dump($e->getMessage(), $e->getTrace());
        }


    }

    /**
     * @param array $registros
     * @return array
     */
    private function getFormulasPorEntidad(array $registros)
    {

        $arregloFormateado = array();

        array_walk($registros, function($registro ,$clave) use(&$arregloFormateado){

            $posicion = $registro['InstitucionConvenioId'];

            if (! array_key_exists($posicion, $arregloFormateado)){
                $arregloFormateado[$posicion] = array();
            }

            # Datos entidad de salud y convenio
            $arregloFormateado[$posicion]['ConvenioId'] = $registro['ConvenioId'];
            $arregloFormateado[$posicion]['nombreInstitucion'] = $registro['NombreInstitucion'];
            $arregloFormateado[$posicion]['InstitucionConvenioId'] = $registro['InstitucionConvenioId'];

            unset($registro['ConvenioId']);
            unset($registro['NombreInstitucion']);
            unset($registro['InstitucionConvenioId']);
            # Datos de formula
            $arregloFormateado[$posicion]['formulas'][] = $registro;

        });

        return $arregloFormateado;

    }

    /**
     * Verificar que el esquema de la formula proporcionada sea valida
     *
     * @param $esquemaFormula
     * @throws \Exception
     */
    public function verificarFormula($esquemaFormula)
    {
        // Validar si la petición es asincrona
        $peticionAsincrona = peticionAsincrona();

        try{

            $formulaValida = FormulasLiquidacion::verificarEsquemaFormula($esquemaFormula);

            // Si es asincrona se responde en formato JSON
            if ($peticionAsincrona)
            {
                header('Content-Type: application/json');
                echo json_encode($formulaValida);
            }
            else
                var_dump($formulaValida);


        }catch (\Exception $e){

            // Si es asincrona se responde en formato JSON
            if ($peticionAsincrona)
            {
                header('Content-Type: application/json', true, 500);
                echo json_encode($e->getMessage());
            }
            else
                var_dump($e->getMessage(), $e->getTrace());

        }

    }

    ############################## CREACION DE FORMULA  PARA CONVENIO #################################################

    /**
     * Recepción de petición para generar creación de formula y envío de información a clase core
     *
     * @param FormRequestCrearFormulaLiq $request
     * @param $idConvenio
     * @param $idCarrera
     * @param $rangoFechas
     * @param $esquemaFormula
     * @throws \Exception
     */
    public function crearFormulaParaEntidad(FormRequestCrearFormulaLiq $request, $idConvenio, $idCarrera, $rangoFechas, $esquemaFormula)
    {

        try{

            $esquemaFormula = str_replace("\\", "", $esquemaFormula);
            $esquemaFormula = json_decode($esquemaFormula, true);
            $esquemaFormula = implode(',', $esquemaFormula);

            $creacion = $this->core->crearFormula($idConvenio, $idCarrera, $rangoFechas, $esquemaFormula);

            if ($creacion)
            {

                header('Location: ' . $_SERVER['HTTP_REFERER']);

            }else{
                echo "UPS! error en la creación de la formula de liquidación";
            }

        }catch (\Exception $e){

            var_dump($e->getMessage());

        }

    }

    /**
     * Verificar que el rango de fechas para la formula que se crea no se encuentre en el sistema cargada
     *
     * @param $idConvenio
     * @param $idCarrera
     * @param $f_desde
     * @param $_hasta
     */
    public function verificarRangoFechas(FormRequestValidarRangoFechasFormulaLiq $request, $idConvenio, $idCarrera, $vigencia, $idFormula = null)
    {

        // Validar si la petición es asincrona
        $peticionAsincrona = peticionAsincrona();

        try{

            $validaRangoFechas =
                $this->core->validarRangoFechas($idConvenio, $idCarrera, $vigencia, $idFormula) ? 'Rango asignado' : 'Rango no asignado';

            // Si es asincrona se responde en formato JSON
            if ($peticionAsincrona)
            {
                header('Content-Type: application/json');
                echo json_encode(array('respuesta' => $validaRangoFechas));
            }
            else
                var_dump($validaRangoFechas);


        }catch (\Exception $e){

            // Si es asincrona se responde en formato JSON
            if ($peticionAsincrona)
            {
                header('Content-Type: application/json', true, 500);
                echo json_encode($e->getMessage());
            }
            else
                var_dump($e->getMessage(), $e->getTrace());

        }


    }


    ############################## ACTUALIZACIÓN ESTADO FORMULA #################################################

    /**
     * Cambio de estado de formula de liquidación
     *
     * @param $idFormula
     * @param $estado
     */
    public function actualizarEstadoFormula($idFormula, $estado)
    {

        // Validar si la petición es asincrona
        $peticionAsincrona = peticionAsincrona();

        try{

            $estadoActualizado = $this->core->actualizarEstadoFormula($idFormula, $estado);

            // Si es asincrona se responde en formato JSON
            if ($peticionAsincrona)
            {
                header('Content-Type: application/json');
                echo json_encode(array('estadoActualizado' => $peticionAsincrona));
            }
            else
                echo ( 'Se actualiza estado ' . $estadoActualizado);

        }catch (\Exception $e){

            if ($peticionAsincrona)
                header('Content-Type: application/json', true,500);

            echo json_encode(array('error' => $e->getMessage()));

        }

    }

    ############################## ACTUALIZACIÓN FORMULA #################################################

    /**
     * Edición de Formula
     *
     * @param $idFormula
     * @param $esquemaFormula
     */
    public function actualizarFormula($idFormula, $esquemaFormula)
    {


        try{

            $esquemaFormula = str_replace("\\", "", $esquemaFormula);
            $esquemaFormula = json_decode($esquemaFormula, true);
            $esquemaFormula = implode(',', $esquemaFormula);

            $edicion = $this->core->editarFormula($idFormula, $esquemaFormula);

            if ($edicion)
            {

                header('Location: ' . $_SERVER['HTTP_REFERER']);

            }else{

            }

        }catch (\Exception $e){

            var_dump($e->getMessage());

        }

    }

}