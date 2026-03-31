<?php
/**
 * Table Definition for detallegrupomateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallegrupomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallegrupomateria';             // table name
    var $iddetallegrupomateria;           // int(11)  not_null primary_key auto_increment
    var $idgrupomateria;                  // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallegrupomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
