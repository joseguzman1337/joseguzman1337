<?php


namespace App\controladores;


class ControladorDefecto
{


    /**
     * Clase cargada por composer desde archivo sala/includes/adaptor.php
     * @var \Configuration
     */
    private $configSala1;

    public function __construct()
    {
        $this->configSala1 = configuracionS1();
    }

    /**
     * @return \Configuration
     */
    public function getConfigSala1()
    {
        return $this->configSala1;
    }

}