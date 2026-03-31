<?php
/**
 * Table Definition for estadocuentaestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadocuentaestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadocuentaestudiante';          // table name
    public $idestadocuentaestudiante;        // int(11)  not_null primary_key auto_increment
    public $numerodocumentocontractualestadocuentaestudiante;    // string(50)  not_null
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $numerocuentacontratoestadocuentaestudiante;    // string(20)  not_null
    public $cuentaoperacionprincipal;        // string(20)  not_null
    public $cuentaoperacionparcial;          // string(20)  not_null
    public $denominacioncuentaoperacionprincipal;    // string(50)  not_null
    public $fechavencimientoestadocuentaestudiante;    // date(10)  not_null binary
    public $valorestadocuentaestudiante;     // unknown(15)  not_null
    public $codigocentrobeneficio;           // string(20)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadocuentaestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
