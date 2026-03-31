<?php
/**
 * Table Definition for rotacionpasantianota
 */
require_once 'DB/DataObject.php';

class DataObjects_Rotacionpasantianota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'rotacionpasantianota';            // table name
    public $idgrupo;                         // int(11)  not_null multiple_key
    public $idcorte;                         // int(11)  not_null multiple_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $idlugarorigennota;               // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Rotacionpasantianota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
