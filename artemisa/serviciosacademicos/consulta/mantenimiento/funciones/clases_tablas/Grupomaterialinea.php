<?php
/**
 * Table Definition for grupomaterialinea
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Grupomaterialinea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'grupomaterialinea';               // table name
    var $idgrupomaterialinea;             // int(11)  not_null primary_key auto_increment
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $idgrupomateria;                  // int(11)  not_null multiple_key
    var $fechagrupomaterialinea;          // datetime(19)  not_null binary
    var $usuario;                         // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Grupomaterialinea',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
