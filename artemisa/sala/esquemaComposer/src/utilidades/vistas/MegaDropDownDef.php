<?php


namespace App\utilidades\vistas;


class MegaDropDownDef implements IMegaDropDown
{

    /**
     * @var array
     */
    private $items = array();

    public function addItem()
    {}

    public function ubicarItems()
    {

        return '<div class="col-md-12"><i class="fa fa-ban"></i> Sin contenido adicional!</div>';

    }
}