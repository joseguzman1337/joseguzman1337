<?php
/**
 * Table Definition for estadosolicitudcredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadosolicitudcredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadosolicitudcredito';          // table name
    var $codigoestadosolicitudcredito;    // string(2)  not_null primary_key
    var $nombreestadosolicitudcredito;    // string(30)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadosolicitudcredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
