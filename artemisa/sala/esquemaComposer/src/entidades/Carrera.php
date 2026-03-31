<?php

namespace App\entidades;



class Carrera extends EntidadBase
{

    public $_table = 'carrera';

    function __construct()
    {

        parent::__construct(array('codigocarrera'));

    }

}