<?php
/**
 * Table Definition for menuboton
 */
require_once 'DB/DataObject.php';

class DataObjects_Menuboton extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'menuboton';                       // table name
    var $idmenuboton;                     // int(11)  not_null primary_key auto_increment
    var $nombremenuboton;                 // string(50)  not_null
    var $linkmenuboton;                   // string(200)  
    var $codigoestadomenuboton;           // string(2)  not_null multiple_key
    var $nivelmenuboton;                  // int(6)  not_null
    var $posicionmenuboton;               // int(6)  not_null
    var $codigogerarquiarol;              // string(2)  not_null multiple_key
    var $linkimagenboton;                 // string(200)  
    var $scriptmenuboton;                 // string(200)  not_null
    var $codigotipomenuboton;             // string(3)  not_null multiple_key
    var $variablesmenuboton;              // string(200)  
    var $propiedadesimagenmenuboton;      // string(200)  
    var $propiedadesmenuboton;            // string(200)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Menuboton',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
