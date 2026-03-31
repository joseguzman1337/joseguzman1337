<?php
/**
 * Table Definition for estadoconexionexterna
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoconexionexterna extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoconexionexterna';           // table name
    public $codigoestadoconexionexterna;     // string(3)  not_null primary_key
    public $nombreestadoconexionexterna;     // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $hostestadoconexionexterna;       // string(50)  not_null
    public $numerosistemaestadoconexionexterna;    // string(50)  not_null
    public $mandanteestadoconexionexterna;    // string(50)  not_null
    public $usuarioestadoconexionexterna;    // string(50)  not_null
    public $passwordestadoconexionexterna;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoconexionexterna',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
