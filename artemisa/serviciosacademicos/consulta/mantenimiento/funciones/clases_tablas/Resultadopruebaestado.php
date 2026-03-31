<?php
/**
 * Table Definition for resultadopruebaestado
 */
require_once 'DB/DataObject.php';

class DataObjects_Resultadopruebaestado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'resultadopruebaestado';           // table name
    public $idresultadopruebaestado;         // int(11)  not_null primary_key auto_increment
    public $nombreresultadopruebaestado;     // string(100)  
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $numeroregistroresultadopruebaestado;    // string(30)  not_null
    public $puestoresultadopruebaestado;     // int(6)  
    public $fecharesultadopruebaestado;      // datetime(19)  binary
    public $observacionresultadopruebaestado;    // string(100)  
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Resultadopruebaestado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
