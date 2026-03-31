<?php
/**
 * Table Definition for detallenota
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallenota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detallenota';                     // table name
    public $idgrupo;                         // int(11)  not_null multiple_key
    public $idcorte;                         // int(11)  not_null multiple_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $nota;                            // unknown(7)  not_null
    public $numerofallasteoria;              // int(6)  not_null
    public $numerofallaspractica;            // int(6)  not_null
    public $codigotiponota;                  // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallenota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
