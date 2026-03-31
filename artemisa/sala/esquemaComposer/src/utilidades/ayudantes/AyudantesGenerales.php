<?php


/**
 * AYUDANTES PARA BASE DE DATOS
 */

if(! function_exists('conexionDB'))
{

    /**
     * @return adodb
     */
    function conexionDB()
    {
        return \Factory::createDbo();
    }

}


/**
 * AYUDANTES PARA CONFIGURACIONES SALA V1.0
 */

if (! function_exists('configuracionS1'))
{

    /**
     * @return Configuration
     */
    function configuracionS1()
    {
        return \Configuration::getInstance();
    }

}

/**
 * AYUDANTES PARA PETICIONES
 */
if(! function_exists('peticionAsincrona'))
{
    /**
     * Validar si la petición realiazada es de tipo asincrona o no
     *
     * @return bool
     */
    function peticionAsincrona()
    {

        return
            (
                !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            );


    }
}