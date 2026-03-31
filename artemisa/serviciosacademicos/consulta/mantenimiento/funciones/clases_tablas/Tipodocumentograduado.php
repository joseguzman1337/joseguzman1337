<?php
/**
 * Table Definition for tipodocumentograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodocumentograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipodocumentograduado';           // table name
    public $codigotipodocumentograduado;     // int(11)  not_null primary_key auto_increment
    public $nombretipodocumentograduado;     // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodocumentograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
