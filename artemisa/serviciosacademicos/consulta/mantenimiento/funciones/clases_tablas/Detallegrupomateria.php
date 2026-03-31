<?php
/**
 * Table Definition for detallegrupomateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallegrupomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detallegrupomateria';             // table name
    public $iddetallegrupomateria;           // int(11)  not_null primary_key auto_increment
    public $idgrupomateria;                  // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallegrupomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
