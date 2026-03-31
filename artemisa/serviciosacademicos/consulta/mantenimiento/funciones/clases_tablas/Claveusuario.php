<?php
/**
 * Table Definition for claveusuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Claveusuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'claveusuario';                    // table name
    public $idclaveusuario;                  // int(11)  not_null primary_key auto_increment
    public $idusuario;                       // int(11)  not_null multiple_key
    public $fechaclaveusuario;               // datetime(19)  not_null binary
    public $fechainicioclaveusuario;         // date(10)  not_null binary
    public $fechavenceclaveusuario;          // date(10)  not_null binary
    public $recordarclaveusuario;            // string(100)  not_null
    public $claveusuario;                    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Claveusuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
