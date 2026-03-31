<?php


namespace App\entidades;


class EntidadBase extends \ADOdb_Active_Record
{

    public function __construct($pkeyarr = false, $db = false, $options = array())
    {

        /**
         * Si llega conexión personalizada se asigna de lo contrario se toma la inicializada por defecto
         */
        $db = (! $db) ? \Factory::createDbo() : $db;

        parent::__construct(false, $pkeyarr, $db, $options);

    }

}