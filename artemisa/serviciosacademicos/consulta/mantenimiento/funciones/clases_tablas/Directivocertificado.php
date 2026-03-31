<?php
/**
 * Table Definition for directivocertificado
 */
require_once 'DB/DataObject.php';

class DataObjects_Directivocertificado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'directivocertificado';            // table name
    public $iddirectivo;                     // int(11)  not_null primary_key multiple_key
    public $idcertificado;                   // int(11)  not_null primary_key multiple_key
    public $fechainiciodirectivocertificado;    // datetime(19)  not_null primary_key binary
    public $fechavencimientodirectivocertificado;    // datetime(19)  not_null primary_key binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Directivocertificado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
