<?php


namespace App\utilidades\vistas;


interface IMegaDropDown
{

    /**
     * Agregar items a la propiedad de clase items[]
     * @return $this
     */
    public function addItem();

    /**
     * @return String
     */
    public function ubicarItems();

}