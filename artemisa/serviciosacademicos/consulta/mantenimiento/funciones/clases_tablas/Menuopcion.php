<?php
/**
 * Table Definition for menuopcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Menuopcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'menuopcion';                      // table name
    public $idmenuopcion;                    // int(11)  not_null primary_key auto_increment
    public $nombremenuopcion;                // string(70)  not_null
    public $linkmenuopcion;                  // string(200)  not_null unique_key
    public $codigoestadomenuopcion;          // string(2)  not_null multiple_key
    public $nivelmenuopcion;                 // int(6)  not_null
    public $posicionmenuopcion;              // int(6)  not_null
    public $codigogerarquiarol;              // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Menuopcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
