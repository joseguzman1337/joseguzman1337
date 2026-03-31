<?php
/**
 * Table Definition for directivo
 */
require_once 'DB/DataObject.php';

class DataObjects_Directivo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'directivo';                       // table name
    var $iddirectivo;                     // int(11)  not_null primary_key auto_increment
    var $nombrecortodirectivo;            // string(15)  not_null unique_key
    var $numerodocumentodirectivo;        // string(20)  not_null multiple_key
    var $apellidosdirectivo;              // string(50)  not_null
    var $nombresdirectivo;                // string(50)  not_null
    var $cargodirectivo;                  // string(100)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $fechainiciodirectivo;            // datetime(19)  not_null binary
    var $fechavencimientodirectivo;       // datetime(19)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $codigotipodirectivo;             // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Directivo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
