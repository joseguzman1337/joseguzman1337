<?php
/**
 * Table Definition for corte
 */
require_once 'DB/DataObject.php';

class DataObjects_Corte extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'corte';                           // table name
    public $idcorte;                         // int(11)  not_null primary_key auto_increment
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $numerocorte;                     // int(6)  not_null
    public $fechainicialcorte;               // date(10)  not_null binary
    public $fechafinalcorte;                 // date(10)  not_null binary
    public $porcentajecorte;                 // int(6)  not_null
    public $usuario;                         // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Corte',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
