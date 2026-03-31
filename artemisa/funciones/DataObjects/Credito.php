<?php
/**
 * Table Definition for credito
 */
require_once 'DB/DataObject.php';

class DataObjects_Credito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'credito';                         // table name
    var $numerocredito;                   // string(255)  not_null
    var $codigoperiodo;                   // string(8)  
    var $numeroordenmatricula;            // string(255)  
    var $codigoestudiante;                // string(15)  
    var $valorcredito;                    // real(22)  
    var $codigoestadocredito;             // real(22)  
    var $aprobacion;                      // real(22)  
    var $fechacredito;                    // datetime(19)  binary
    var $codigofinanciamiento;            // real(22)  
    var $numeropagare;                    // real(22)  
    var $estadocredito;                   // real(22)  
    var $numerodocumento;                 // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Credito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
