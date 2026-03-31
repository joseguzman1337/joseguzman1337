<?php
/**
 * Table Definition for universidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Universidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'universidad';                     // table name
    public $iduniversidad;                   // int(11)  not_null primary_key auto_increment
    public $fechauniversidad;                // date(10)  not_null binary
    public $codigouniversidad;               // string(20)  not_null
    public $nombreuniversidad;               // string(100)  not_null
    public $representantelegaluniversidad;    // string(100)  not_null
    public $direccionuniversidad;            // string(100)  not_null
    public $idciudad;                        // int(11)  not_null multiple_key
    public $telefonouniversidad;             // string(50)  not_null
    public $faxuniversidad;                  // string(50)  
    public $correouniversidad;               // string(100)  not_null
    public $paginawebuniversidad;            // string(100)  not_null
    public $nituniversidad;                  // string(50)  not_null
    public $personeriauniversidad;           // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $imagenlogouniversidad;           // string(200)  not_null
    public $esloganuniversidad;              // string(200)  not_null
    public $entidadrigeuniversidad;          // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Universidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
