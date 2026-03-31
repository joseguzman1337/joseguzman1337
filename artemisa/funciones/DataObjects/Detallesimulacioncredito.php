<?php
/**
 * Table Definition for detallesimulacioncredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallesimulacioncredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallesimulacioncredito';        // table name
    var $iddetallesimulacioncredito;      // int(11)  not_null primary_key auto_increment
    var $idsimulacioncredito;             // int(11)  not_null multiple_key
    var $nocuotadetallesimulacioncredito;    // int(6)  not_null
    var $fechadesdedetallesimulacioncredito;    // date(10)  not_null binary
    var $fechahastadetallesimulacioncredito;    // date(10)  not_null binary
    var $valorcapitaldetallesimulacioncredito;    // int(11)  not_null
    var $valorinteresesdetallesimulacioncredito;    // int(11)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallesimulacioncredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
