<?php
/**
 * Table Definition for horariositioadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Horariositioadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'horariositioadmision';            // table name
    var $idhorariositioadmision;          // int(11)  not_null primary_key auto_increment
    var $idsitioadmision;                 // int(11)  not_null multiple_key
    var $fechainiciohorariositioadmision;    // datetime(19)  not_null binary
    var $fechafinalhorariositioadmision;    // datetime(19)  not_null binary
    var $horainicialhorariositioadmision;    // time(8)  not_null binary
    var $horafinalhorariositioadmision;    // time(8)  not_null binary
    var $intervalotiempohorariositioadmision;    // time(8)  not_null binary
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $codigotipogeneracionhorariositioadmision;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Horariositioadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
