<?php
/**
 * Table Definition for tmpmateriadivorciada
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmpmateriadivorciada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmpmateriadivorciada';            // table name
    public $codigonovasoft;                  // string(255)  multiple_key
    public $codigomateria;                   // string(255)  multiple_key
    public $codigounico;                     // string(50)  multiple_key
    public $indicador;                       // int(11)  
    public $nombre;                          // string(255)  
    public $numerocreditos;                  // real(22)  
    public $codigoperiodo;                   // int(11)  multiple_key
    public $notaminimaaprobatoria;           // real(22)  
    public $notaminimahabilitacion;          // real(22)  
    public $numerosemana;                    // real(22)  
    public $numerohorassemanales;            // real(22)  
    public $codigomodalidadmateria;          // string(255)  
    public $codigocarrera;                   // string(255)  multiple_key
    public $idgrupomateria;                  // string(50)  
    public $codigotipomateria;               // string(50)  
    public $codigoestadomateria;             // string(50)  
    public $ulasa;                           // real(22)  
    public $ulasb;                           // real(22)  
    public $ulasc;                           // real(22)  
    public $indicadorcreditos;               // real(22)  
    public $TOTAL_ULAS;                      // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmpmateriadivorciada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
