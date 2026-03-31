<?php


class EncabezadoDiplomaControl
{
    private $textEncabezadoDiploma;
    private $whitBoxEncabezado;// ancho de la caja encabezado
    private $heigthBoxEncabezado;//espacio entre linea de texto
    private $borderBoxEncabezado;//
    private $alineacionTexto;
    private $fuenteEncabezado;
    private $estiloFuenteEncabezado;
    private $tamanioFuenteEncabezado;
    public function __construct($datosEncabezado){

        $this->textEncabezadoDiploma    = $datosEncabezado["textEncabezadoDiploma"];
        $this->whitBoxEncabezado        = $datosEncabezado["whitBoxEncabezado"];
        $this->heigthBoxEncabezado      = $datosEncabezado["heigthBoxEncabezado"];
        $this->borderBoxEncabezado      = $datosEncabezado["borderBoxEncabezado"];
        $this->alineacionTexto          = $datosEncabezado["alineacionTexto"];
        $this->fuenteEncabezado         = $datosEncabezado["fuenteEncabezado"];
        $this->estiloFuenteEncabezado   = $datosEncabezado["estiloFuenteEncabezado"];
        $this->tamanioFuenteEncabezado  = $datosEncabezado["tamanioFuenteEncabezado"];
    }
    public function ctrEncabezadoDiploma(){
 }
}