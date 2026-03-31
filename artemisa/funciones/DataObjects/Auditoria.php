<?php
/**
 * Table Definition for auditoria
 */
require_once 'DB/DataObject.php';

class DataObjects_Auditoria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'auditoria';                       // table name
    var $idauditoria;                     // int(11)  not_null primary_key auto_increment
    var $numerodocumento;                 // string(50)  
    var $usuario;                         // string(50)  
    var $fechaauditoria;                  // datetime(19)  binary
    var $codigomateria;                   // int(11)  
    var $grupo;                           // string(50)  
    var $codigoestudiante;                // int(11)  
    var $notaanterior;                    // real(5)  
    var $notamodificada;                  // real(5)  
    var $corte;                           // string(50)  
    var $tipoauditoria;                   // string(50)  
    var $observacion;                     // string(50)  
    var $ip;                              // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Auditoria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
