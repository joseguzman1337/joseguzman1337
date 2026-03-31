<?php
/**
 * Table Definition for directivocertificado
 */
require_once 'DB/DataObject.php';

class DataObjects_Directivocertificado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'directivocertificado';            // table name
    var $iddirectivo;                     // int(11)  not_null primary_key multiple_key
    var $idcertificado;                   // int(11)  not_null primary_key multiple_key
    var $fechainiciodirectivocertificado;    // datetime(19)  not_null primary_key binary
    var $fechavencimientodirectivocertificado;    // datetime(19)  not_null primary_key binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Directivocertificado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
