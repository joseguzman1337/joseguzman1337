<?php
/**
 * Table Definition for idioma
 */
require_once 'DB/DataObject.php';

class DataObjects_Idioma extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'idioma';                          // table name
    public $ididioma;                        // int(11)  not_null primary_key auto_increment
    public $nombreidioma;                    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Idioma',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
