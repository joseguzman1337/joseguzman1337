<?php
/**
 * Table Definition for menuopcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Menuopcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'menuopcion';                      // table name
    var $idmenuopcion;                    // int(11)  not_null primary_key auto_increment
    var $nombremenuopcion;                // string(70)  not_null
    var $linkmenuopcion;                  // string(200)  not_null unique_key
    var $codigoestadomenuopcion;          // string(2)  not_null multiple_key
    var $nivelmenuopcion;                 // int(6)  not_null
    var $posicionmenuopcion;              // int(6)  not_null
    var $codigogerarquiarol;              // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Menuopcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
