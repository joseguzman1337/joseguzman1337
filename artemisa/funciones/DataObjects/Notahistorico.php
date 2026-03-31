<?php
/**
 * Table Definition for notahistorico
 */
require_once 'DB/DataObject.php';

class DataObjects_Notahistorico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'notahistorico';                   // table name
    var $idnotahistorico;                 // int(11)  not_null primary_key auto_increment
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigomateriaelectiva;           // int(11)  not_null multiple_key
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $notadefinitiva;                  // unknown(7)  not_null
    var $codigotiponotahistorico;         // string(3)  not_null multiple_key
    var $origennotahistorico;             // string(50)  not_null
    var $fechaprocesonotahistorico;       // datetime(19)  not_null binary
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $idplanestudio;                   // int(11)  not_null multiple_key
    var $idlineaenfasisplanestudio;       // int(11)  not_null multiple_key
    var $observacionnotahistorico;        // string(100)  
    var $codigoestadonotahistorico;       // string(3)  not_null multiple_key
    var $codigotipomateria;               // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Notahistorico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
