<?php
/**
 * Table Definition for nota
 */
require_once 'DB/DataObject.php';

class DataObjects_Nota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'nota';                            // table name
    public $idgrupo;                         // int(11)  not_null primary_key multiple_key
    public $idcorte;                         // int(11)  not_null primary_key multiple_key
    public $fechaorigennota;                 // datetime(19)  not_null binary
    public $actividadesacademicasteoricanota;    // int(6)  not_null
    public $actividadesacademicaspracticanota;    // int(6)  not_null
    public $fechaultimoregistronota;         // datetime(19)  not_null binary
    public $codigotipoequivalencianota;      // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Nota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
