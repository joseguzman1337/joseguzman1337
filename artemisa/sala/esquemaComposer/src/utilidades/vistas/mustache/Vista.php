<?php

namespace App\utilidades\vistas\mustache;


use App\utilidades\vistas\AbstractVista;
use App\utilidades\vistas\MegaDropDownDef;

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
        $this->motor = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader($pathGeneral . '/vistas/'),
            'partials_loader' => new \Mustache_Loader_FilesystemLoader($pathGeneral . '/vistas/'),
        ));

    }

    protected function loadDataDefaul()
    {
        parent::loadDataDefaul();

        // Cargue de item por defecto
        $objMegaDropDown = new MegaDropDownDef();
        $megaDropDown = $objMegaDropDown->ubicarItems();
        $this->setVarsDefault('__megaDropDown', $megaDropDown );

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