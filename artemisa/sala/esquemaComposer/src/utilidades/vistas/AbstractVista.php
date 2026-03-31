<?php

namespace App\utilidades\vistas;


abstract class AbstractVista
{


    /**
     * @var
     */
    protected $loader;

    /**
     * @var
     */
    protected $motor;

    /**
     * Define variables por defecto necesarias para la renderización de las vistas
     * @var array
     */
    private $varsDefault = array();

    ############################## METODOS PARA CAMBIOS SOBRE VALORES POR DEFECTO A VISTAS ############################

    /**getHTTP_SITE()
     * @param $key
     * @param $content
     * @return $this
     */
    public function setVarsDefault($key, $content)
    {

        $this->varsDefault[$key] = $content;

        return $this;
    }

    /**
     * Cargue de variables por defecto para vistas
     */
    protected function loadDataDefaul()
    {
        // url para cargue de recursos publicos /css / js / img / ...
        $objConfig = configuracionS1();
        $urlSala = $objConfig->getHTTP_SITE();

        $this->setVarsDefault('__Dominio', $objConfig->getHTTP_ROOT());
        $this->setVarsDefault('__urlAsset', $urlSala . '/assets');

    }

    /**
     * @return array
     */
    public function getVarsDefault()
    {
        return $this->varsDefault;
    }

    ###################################################################################################################

    /**
     * @return void
     */
    public abstract function setMotor();


    /**
     * @param $name
     * @param $arguments
     * @return string
     */
    public function __call($name, $arguments)
    {

        if($name == 'render')
        {

            if (method_exists($this->motor, $name))
            {
                // Cargue de variables por defecto
                $argView = $this->getVarsDefault();

                // Unificación de variables defecto con variables que llegan de controlador
                if (is_array( $arguments[1] ))
                    $argView = array_merge($argView, $arguments[1]);

                return $this->motor->render($arguments[0], $argView);

            }

        }

    }

}