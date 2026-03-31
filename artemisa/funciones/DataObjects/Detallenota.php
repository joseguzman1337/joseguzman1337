<?php
/**
 * Table Definition for detallenota
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallenota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallenota';                     // table name
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $idcorte;                         // int(11)  not_null multiple_key
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $nota;                            // unknown(7)  not_null
    var $numerofallasteoria;              // int(6)  not_null
    var $numerofallaspractica;            // int(6)  not_null
    var $codigotiponota;                  // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallenota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
