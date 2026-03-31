<?php
/**
 * Table Definition for resultadopruebaestado
 */
require_once 'DB/DataObject.php';

class DataObjects_Resultadopruebaestado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'resultadopruebaestado';           // table name
    var $idresultadopruebaestado;         // int(11)  not_null primary_key auto_increment
    var $nombreresultadopruebaestado;     // string(100)  
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $numeroregistroresultadopruebaestado;    // string(30)  not_null
    var $puestoresultadopruebaestado;     // int(6)  
    var $fecharesultadopruebaestado;      // datetime(19)  binary
    var $observacionresultadopruebaestado;    // string(100)  
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Resultadopruebaestado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
