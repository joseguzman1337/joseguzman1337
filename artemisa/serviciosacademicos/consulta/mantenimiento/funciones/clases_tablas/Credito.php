<?php
/**
 * Table Definition for credito
 */
require_once 'DB/DataObject.php';

class DataObjects_Credito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'credito';                         // table name
    public $numerocredito;                   // string(255)  not_null
    public $codigoperiodo;                   // string(8)  
    public $numeroordenmatricula;            // string(255)  
    public $codigoestudiante;                // string(15)  
    public $valorcredito;                    // real(22)  
    public $codigoestadocredito;             // real(22)  
    public $aprobacion;                      // real(22)  
    public $fechacredito;                    // datetime(19)  binary
    public $codigofinanciamiento;            // real(22)  
    public $numeropagare;                    // real(22)  
    public $estadocredito;                   // real(22)  
    public $numerodocumento;                 // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Credito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
