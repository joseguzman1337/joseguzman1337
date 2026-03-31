<?php
/**
 * Table Definition for simulacioncredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Simulacioncredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'simulacioncredito';               // table name
    var $idsimulacioncredito;             // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $fechasimulacioncredito;          // datetime(19)  not_null binary
    var $valorsimulacioncredito;          // int(11)  not_null
    var $fechadesdesimulacioncredito;     // date(10)  not_null binary
    var $fechahastasimulacioncredito;     // date(10)  not_null binary
    var $numerocuotassimulacioncredito;    // int(6)  not_null
    var $observacionsimulacioncredito;    // string(200)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idcondicioncredito;              // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Simulacioncredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
