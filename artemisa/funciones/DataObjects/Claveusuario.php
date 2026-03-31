<?php
/**
 * Table Definition for claveusuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Claveusuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'claveusuario';                    // table name
    var $idclaveusuario;                  // int(11)  not_null primary_key auto_increment
    var $idusuario;                       // int(11)  not_null multiple_key
    var $fechaclaveusuario;               // datetime(19)  not_null binary
    var $fechainicioclaveusuario;         // date(10)  not_null binary
    var $fechavenceclaveusuario;          // date(10)  not_null binary
    var $recordarclaveusuario;            // string(100)  not_null
    var $claveusuario;                    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Claveusuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
