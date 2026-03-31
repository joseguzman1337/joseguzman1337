<?php

namespace App\origenDatos\entidadDAO;


abstract class A_EntidadDAO implements I_EntidadDAO
{

    /**
     * @var
     */
    protected $db;


    /**
     * Guarda instancia de la clase VO
     * @var mixed
     */
    protected $entidadVO;


    public function setDb()
    {
        $this->db = \Factory::createDbo();
    }

}