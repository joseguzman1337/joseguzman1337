<?php
/**
 * Table Definition for ordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ordenpago';                       // table name
    public $numeroordenpago;                 // int(11)  not_null primary_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $fechaordenpago;                  // date(10)  not_null binary
    public $idprematricula;                  // int(11)  not_null multiple_key
    public $fechaentregaordenpago;           // date(10)  not_null binary
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigoestadoordenpago;           // string(2)  not_null multiple_key
    public $codigoimprimeordenpago;          // string(2)  not_null multiple_key
    public $observacionordenpago;            // string(50)  
    public $codigocopiaordenpago;            // string(3)  not_null multiple_key
    public $documentosapordenpago;           // string(20)  
    public $idsubperiodo;                    // int(11)  not_null multiple_key
    public $documentocuentaxcobrarsap;       // string(20)  
    public $documentocuentacompensacionsap;    // string(20)  
    public $fechapagosapordenpago;           // date(10)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
