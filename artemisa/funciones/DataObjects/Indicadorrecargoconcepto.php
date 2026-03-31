<?php
/**
 * Table Definition for indicadorrecargoconcepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorrecargoconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'indicadorrecargoconcepto';        // table name
    var $codigoindicadorrecargoconcepto;    // string(3)  not_null primary_key
    var $nombreindicadorrecargoconcepto;    // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorrecargoconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
