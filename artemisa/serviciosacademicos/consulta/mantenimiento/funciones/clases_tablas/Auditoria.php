<?php
/**
 * Table Definition for auditoria
 */
require_once 'DB/DataObject.php';

class DataObjects_Auditoria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'auditoria';                       // table name
    public $idauditoria;                     // int(11)  not_null primary_key auto_increment
    public $numerodocumento;                 // string(50)  
    public $usuario;                         // string(50)  
    public $fechaauditoria;                  // datetime(19)  binary
    public $codigomateria;                   // int(11)  
    public $grupo;                           // string(50)  
    public $codigoestudiante;                // int(11)  
    public $notaanterior;                    // real(5)  
    public $notamodificada;                  // real(5)  
    public $corte;                           // string(50)  
    public $tipoauditoria;                   // string(50)  
    public $observacion;                     // string(50)  
    public $ip;                              // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Auditoria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
