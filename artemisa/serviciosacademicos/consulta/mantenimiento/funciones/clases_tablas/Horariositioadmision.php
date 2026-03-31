<?php
/**
 * Table Definition for horariositioadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Horariositioadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'horariositioadmision';            // table name
    public $idhorariositioadmision;          // int(11)  not_null primary_key auto_increment
    public $idsitioadmision;                 // int(11)  not_null multiple_key
    public $fechainiciohorariositioadmision;    // datetime(19)  not_null binary
    public $fechafinalhorariositioadmision;    // datetime(19)  not_null binary
    public $horainicialhorariositioadmision;    // time(8)  not_null binary
    public $horafinalhorariositioadmision;    // time(8)  not_null binary
    public $intervalotiempohorariositioadmision;    // time(8)  not_null binary
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $codigotipogeneracionhorariositioadmision;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Horariositioadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
