<?php

namespace App\entidades;



class CamposFormulas extends EntidadBase
{

    public $_table = 'CamposFormulas';

    /**
     * Identificadores de campos que son digitados por el usuario
     * @var array
     */
    public $camposDigitados = array(3, 6, 9, 11, 12, 15, 16, 17, 19, 20);

    function __construct()
    {

        parent::__construct(array('CamposFormulaId'));

    }


    public function getSentencia()
    {

    }

    /**
     * Retorno de arreglo con estructura [CamposFormulaId] =  'Nombre'
     *
     * @return array
     */
    public function getCamposFormArreglo()
    {

        header('Content-Type: text/html; charset=utf-8');
        $this->DB()->setFetchMode(ADODB_FETCH_ASSOC);
        $result = $this->DB()->execute('SELECT * FROM CamposFormulas ORDER BY Nombre');
        $arreglo = array();

        while(! $result->EOF)
        {
            $arreglo[$result->fields['CamposFormulaId']] = $result->fields['Nombre'];
            $result->MoveNext();
        }

        return $arreglo;
    }
    

}