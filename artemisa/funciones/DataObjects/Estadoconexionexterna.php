<?php
/**
 * Table Definition for estadoconexionexterna
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoconexionexterna extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoconexionexterna';           // table name
    var $codigoestadoconexionexterna;     // string(3)  not_null primary_key
    var $nombreestadoconexionexterna;     // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $hostestadoconexionexterna;       // string(50)  not_null
    var $numerosistemaestadoconexionexterna;    // string(50)  not_null
    var $mandanteestadoconexionexterna;    // string(50)  not_null
    var $usuarioestadoconexionexterna;    // string(50)  not_null
    var $passwordestadoconexionexterna;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoconexionexterna',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
