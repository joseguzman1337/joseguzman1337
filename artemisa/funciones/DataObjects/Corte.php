<?php
/**
 * Table Definition for corte
 */
require_once 'DB/DataObject.php';

class DataObjects_Corte extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'corte';                           // table name
    var $idcorte;                         // int(11)  not_null primary_key auto_increment
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $numerocorte;                     // int(6)  not_null
    var $fechainicialcorte;               // date(10)  not_null binary
    var $fechafinalcorte;                 // date(10)  not_null binary
    var $porcentajecorte;                 // int(6)  not_null
    var $usuario;                         // string(30)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Corte',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
