<?php
/**
 * Table Definition for detallefacturavalorpecuniario
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Detallefacturavalorpecuniario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallefacturavalorpecuniario';    // table name
    var $iddetallefacturavalorpecuniario;    // int(11)  not_null primary_key auto_increment
    var $idfacturavalorpecuniario;        // int(11)  not_null multiple_key
    var $idvalorpecuniario;               // int(11)  not_null multiple_key
    var $codigotipoestudiante;            // string(2)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallefacturavalorpecuniario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
