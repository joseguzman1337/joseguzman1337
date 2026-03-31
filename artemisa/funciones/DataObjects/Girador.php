<?php
/**
 * Table Definition for girador
 */
require_once 'DB/DataObject.php';

class DataObjects_Girador extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'girador';                         // table name
    var $idsolicitudcredito;              // int(11)  not_null multiple_key
    var $numerodocumentogirador;          // string(15)  not_null
    var $tipodocumento;                   // string(2)  not_null multiple_key
    var $expedidodocumentogirador;        // string(20)  not_null
    var $apellidosgirador;                // string(20)  not_null
    var $nombregirador;                   // string(50)  not_null
    var $direccionresidenciagirador;      // string(30)  not_null
    var $ciudadresidenciagirador;         // string(20)  not_null
    var $telefonoresidenciagirador;       // string(20)  not_null
    var $direccioncorrespondenciagirador;    // string(30)  
    var $ciudadcorrespondenciagirador;    // string(20)  
    var $telefonocorrespondenciagirador;    // string(20)  
    var $celulargirador;                  // string(20)  
    var $emailgirador;                    // string(30)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Girador',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
