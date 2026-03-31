<?php
/**
 * Table Definition for ordenpagodevolucion
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpagodevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ordenpagodevolucion';             // table name
    var $idordenpagodevolucion;           // int(11)  not_null primary_key auto_increment
    var $fechaordenpagodevolucion;        // date(10)  not_null binary
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $iddirectivopreautoriza;          // int(11)  not_null multiple_key
    var $iddirectivoautoriza;             // int(11)  not_null multiple_key
    var $fechadirectivoautoriza;          // date(10)  not_null binary
    var $numerodocumentosap;              // string(30)  
    var $fechadevolucionsap;              // date(10)  binary
    var $valordevolucionsap;              // int(11)  
    var $codigotipoordenpagodevolucion;    // string(3)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpagodevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
