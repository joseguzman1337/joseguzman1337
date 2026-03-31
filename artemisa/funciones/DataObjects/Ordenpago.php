<?php
/**
 * Table Definition for ordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ordenpago';                       // table name
    var $numeroordenpago;                 // int(11)  not_null primary_key
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $fechaordenpago;                  // date(10)  not_null binary
    var $idprematricula;                  // int(11)  not_null multiple_key
    var $fechaentregaordenpago;           // date(10)  not_null binary
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoestadoordenpago;           // string(2)  not_null multiple_key
    var $codigoimprimeordenpago;          // string(2)  not_null multiple_key
    var $observacionordenpago;            // string(200)  
    var $codigocopiaordenpago;            // string(3)  not_null multiple_key
    var $documentosapordenpago;           // string(20)  
    var $idsubperiodo;                    // int(11)  not_null multiple_key
    var $idsubperiododestino;             // int(11)  not_null multiple_key
    var $documentocuentaxcobrarsap;       // string(20)  
    var $documentocuentacompensacionsap;    // string(20)  
    var $fechapagosapordenpago;           // date(10)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
