<?php
/**
 * Table Definition for estadosolicitudcredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadosolicitudcredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadosolicitudcredito';          // table name
    public $codigoestadosolicitudcredito;    // string(2)  not_null primary_key
    public $nombreestadosolicitudcredito;    // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadosolicitudcredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
