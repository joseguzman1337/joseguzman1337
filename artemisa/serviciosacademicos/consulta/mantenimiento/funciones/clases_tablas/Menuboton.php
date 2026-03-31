<?php
/**
 * Table Definition for menuboton
 */
require_once 'DB/DataObject.php';

class DataObjects_Menuboton extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'menuboton';                       // table name
    public $idmenuboton;                     // int(11)  not_null primary_key auto_increment
    public $nombremenuboton;                 // string(50)  not_null
    public $linkmenuboton;                   // string(200)  
    public $codigoestadomenuboton;           // string(2)  not_null multiple_key
    public $nivelmenuboton;                  // int(6)  not_null
    public $posicionmenuboton;               // int(6)  not_null
    public $codigogerarquiarol;              // string(2)  not_null multiple_key
    public $linkimagenboton;                 // string(200)  
    public $scriptmenuboton;                 // string(200)  not_null
    public $codigotipomenuboton;             // string(3)  not_null multiple_key
    public $variablesmenuboton;              // string(200)  
    public $propiedadesimagenmenuboton;      // string(200)  
    public $propiedadesmenuboton;            // string(200)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Menuboton',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
