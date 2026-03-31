<?php
/**
 * Table Definition for universidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Universidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'universidad';                     // table name
    var $iduniversidad;                   // int(11)  not_null primary_key auto_increment
    var $fechauniversidad;                // date(10)  not_null binary
    var $codigouniversidad;               // string(20)  not_null
    var $nombreuniversidad;               // string(100)  not_null
    var $representantelegaluniversidad;    // string(100)  not_null
    var $direccionuniversidad;            // string(100)  not_null
    var $idciudad;                        // int(11)  not_null multiple_key
    var $telefonouniversidad;             // string(50)  not_null
    var $faxuniversidad;                  // string(50)  
    var $correouniversidad;               // string(100)  not_null
    var $paginawebuniversidad;            // string(100)  not_null
    var $nituniversidad;                  // string(50)  not_null
    var $personeriauniversidad;           // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $imagenlogouniversidad;           // string(200)  not_null
    var $esloganuniversidad;              // string(200)  not_null
    var $entidadrigeuniversidad;          // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Universidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
