<?php
/**
 * Table Definition for estadocuentaestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadocuentaestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadocuentaestudiante';          // table name
    var $idestadocuentaestudiante;        // int(11)  not_null primary_key auto_increment
    var $numerodocumentocontractualestadocuentaestudiante;    // string(50)  not_null
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $numerocuentacontratoestadocuentaestudiante;    // string(20)  not_null
    var $cuentaoperacionprincipal;        // string(20)  not_null
    var $cuentaoperacionparcial;          // string(20)  not_null
    var $denominacioncuentaoperacionprincipal;    // string(50)  not_null
    var $fechavencimientoestadocuentaestudiante;    // date(10)  not_null binary
    var $valorestadocuentaestudiante;     // unknown(15)  not_null
    var $codigocentrobeneficio;           // string(20)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadocuentaestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
