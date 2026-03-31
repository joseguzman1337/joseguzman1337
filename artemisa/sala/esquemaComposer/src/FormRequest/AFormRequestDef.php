<?php


namespace App\FormRequest;


abstract class AFormRequestDef implements IFormRequest
{


    private $reglas = array();
    private $mensajeRegla = array();
    private $reglasFallidas = array();


    /**
     * Validar si tiene permisos para acceder al request
     *
     * @return bool
     */
    protected function __autorizado()
    {
        return false;
    }

    /**
     * Reglas a validar del Request que se recibe
     *
     * @return array
     */
    protected function cargarReglas()
    {

        return $this->reglas;
    }

    /**
     * @return array
     */
    protected function cargarMensajeRegla()
    {
        return $this->mensajeRegla;
    }

    /**
     * Ejecutar lambdas de reglas definidas
     *
     * @return bool
     */
    protected function ejecutarReglas()
    {

        $pasaValidaciones = false;

        // Cargue de reglas a validar
        $this->reglas = $this->cargarReglas();

        // Cargue de mensaje por regla
        $this->mensajeRegla = $this->cargarMensajeRegla();

        // Recorrido de reglas definidas
        foreach ($this->reglas as $campo => $lamda)
        {
            //captura de nombre definidos en formulario
            $_campo = explode('.',$campo);
            $_campo = current($_campo);

            // Validar que la regla tenga una funcion anonima
            if ($lamda instanceof \Closure){

                // Ejecución de funcion anonima cargada a la regla
                $pasaValidaciones = $lamda($_POST[$_campo]);

                // Validar que la lambda no pase para cargar la falla
                if (! $pasaValidaciones)
                {
                    $mensaje =
                        isset($this->mensajeRegla[$campo])
                            ? $this->mensajeRegla[$campo] : $campo . ' Fallida!';

                    $this->reglasFallidas[$campo] = $mensaje;

                }

            }

        }

        return (bool) $pasaValidaciones;
    }
    
    /**
     * Ejecución de reglas definidas
     * @return $this
     *
     */
    public function __validarPeticion()
    {

        if (! $this->__autorizado())
            die('SIN PERMISOS PARA GENERAR ESTA PETICIÓN');

        if (! $this->ejecutarReglas())
        {

            if (! peticionAsincrona())
            {
                echo 'procesando espere un momento...';
                $this->redireccionarPorError();
            }
            else{
                $this->respuestaAsincrona();
            }

            die();

        }


        return $this;

    }

    /**
     * Redireccionar si no se cumplen las reglas definidas
     */
    private function redireccionarPorError()
    {

        $uri = $_SERVER['HTTP_REFERER'];
        header("refresh: 2; url=" .$uri);
        $this->setReglasFallidas();

    }

    /**
     * Tipo de respuesta para cuando la petición es asincronica
     */
    private function respuestaAsincrona()
    {

        header('Content-Type: application/json', true, 200);
        $reglasFallidas = array('errores' => array());

        foreach ($this->reglasFallidas as $reglaCampo => $mensaje) {
            $reglasFallidas['errores'][$reglaCampo] = $mensaje;
        }

        echo json_encode($reglasFallidas);

    }
    
    /**
     * Cargue de reglas fallidas en cookies
     */
    private function setReglasFallidas()
    {

        foreach ($this->reglasFallidas as $reglaCampo => $mensaje) {
            setcookie('error[' . $reglaCampo . ']', $mensaje);
        }

    }

    /**
     * Devolución de argumentos llegados en petición si se encuentra en los campos que llegar en el REQUEST
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {

        if (array_key_exists($name, $_REQUEST))
            return $_REQUEST[$name];

    }

}