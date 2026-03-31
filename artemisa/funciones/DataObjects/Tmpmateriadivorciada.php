<?php
/**
 * Table Definition for tmpmateriadivorciada
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmpmateriadivorciada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tmpmateriadivorciada';            // table name
    var $codigonovasoft;                  // string(255)  multiple_key
    var $codigomateria;                   // string(255)  multiple_key
    var $codigounico;                     // string(50)  multiple_key
    var $indicador;                       // int(11)  
    var $nombre;                          // string(255)  
    var $numerocreditos;                  // real(22)  
    var $codigoperiodo;                   // int(11)  multiple_key
    var $notaminimaaprobatoria;           // real(22)  
    var $notaminimahabilitacion;          // real(22)  
    var $numerosemana;                    // real(22)  
    var $numerohorassemanales;            // real(22)  
    var $codigomodalidadmateria;          // string(255)  
    var $codigocarrera;                   // string(255)  multiple_key
    var $idgrupomateria;                  // string(50)  
    var $codigotipomateria;               // string(50)  
    var $codigoestadomateria;             // string(50)  
    var $ulasa;                           // real(22)  
    var $ulasb;                           // real(22)  
    var $ulasc;                           // real(22)  
    var $indicadorcreditos;               // real(22)  
    var $TOTAL_ULAS;                      // real(22)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmpmateriadivorciada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
