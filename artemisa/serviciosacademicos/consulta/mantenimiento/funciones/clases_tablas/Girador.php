<?php
/**
 * Table Definition for girador
 */
require_once 'DB/DataObject.php';

class DataObjects_Girador extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'girador';                         // table name
    public $idsolicitudcredito;              // int(11)  not_null multiple_key
    public $numerodocumentogirador;          // string(15)  not_null
    public $tipodocumento;                   // string(2)  not_null multiple_key
    public $expedidodocumentogirador;        // string(20)  not_null
    public $apellidosgirador;                // string(20)  not_null
    public $nombregirador;                   // string(50)  not_null
    public $direccionresidenciagirador;      // string(30)  not_null
    public $ciudadresidenciagirador;         // string(20)  not_null
    public $telefonoresidenciagirador;       // string(20)  not_null
    public $direccioncorrespondenciagirador;    // string(30)  
    public $ciudadcorrespondenciagirador;    // string(20)  
    public $telefonocorrespondenciagirador;    // string(20)  
    public $celulargirador;                  // string(20)  
    public $emailgirador;                    // string(30)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Girador',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
