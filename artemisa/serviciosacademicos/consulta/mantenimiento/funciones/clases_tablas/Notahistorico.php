<?php
/**
 * Table Definition for notahistorico
 */
require_once 'DB/DataObject.php';

class DataObjects_Notahistorico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'notahistorico';                   // table name
    public $idnotahistorico;                 // int(11)  not_null primary_key auto_increment
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $codigomateriaelectiva;           // int(11)  not_null multiple_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $notadefinitiva;                  // unknown(7)  not_null
    public $codigotiponotahistorico;         // string(3)  not_null multiple_key
    public $origennotahistorico;             // string(50)  not_null
    public $fechaprocesonotahistorico;       // datetime(19)  not_null binary
    public $idgrupo;                         // int(11)  not_null multiple_key
    public $idplanestudio;                   // int(11)  not_null multiple_key
    public $idlineaenfasisplanestudio;       // int(11)  not_null multiple_key
    public $observacionnotahistorico;        // string(100)  
    public $codigoestadonotahistorico;       // string(3)  not_null multiple_key
    public $codigotipomateria;               // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Notahistorico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
