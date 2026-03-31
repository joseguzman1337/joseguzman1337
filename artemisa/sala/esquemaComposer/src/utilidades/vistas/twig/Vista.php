<?php

namespace App\utilidades\vistas\twig;


use App\utilidades\vistas\AbstractVista;

class Vista extends AbstractVista
{

    public function __construct()
    {
        $this->setMotor();
        $this->loadDataDefaul();

    }

    public function setMotor()
    {
        $pathGeneral = dirname(dirname(dirname(__DIR__)));
        $this->loader = new \Twig_Loader_Filesystem($pathGeneral . '/vistas/twig');
        $this->motor = new \Twig_Environment($this->loader);

    }

    public static function __callStatic($name, $arguments)
    {

        if ($name == 'render')
        {
            $instance = new static();
            return $instance->render($arguments[0], @$arguments[1]);
        }

    }

}