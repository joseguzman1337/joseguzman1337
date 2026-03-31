<?php
/**
 * Table Definition for indicadorgrupomateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorgrupomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadorgrupomateria';           // table name
    public $codigoindicadorgrupomateria;     // string(3)  not_null primary_key
    public $nombreindicadorgrupomateria;     // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorgrupomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
