<?php
/**
 * Table Definition for respuestas
 */
require_once 'DB/DataObject.php';

class DataObjects_Respuestas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'respuestas';                      // table name
    public $codigomateria;                   // int(11)  not_null
    public $codigoestudiante;                // string(15)  
    public $codigodocente;                   // string(15)  
    public $evaluado;                        // int(11)  
    public $idgrupo;                         // int(11)  
    public $resp1;                           // string(1)  
    public $resp2;                           // string(1)  
    public $resp3;                           // string(1)  
    public $resp4;                           // string(1)  
    public $resp5;                           // string(1)  
    public $resp6;                           // string(1)  
    public $resp7;                           // string(1)  
    public $resp8;                           // string(1)  
    public $resp9;                           // string(1)  
    public $respa1;                          // string(1)  
    public $respb1;                          // string(1)  
    public $respc1;                          // string(1)  
    public $respd1;                          // string(1)  
    public $respa2;                          // string(1)  
    public $respb2;                          // string(1)  
    public $respc2;                          // string(1)  
    public $respd2;                          // string(1)  
    public $respa3;                          // string(1)  
    public $respb3;                          // string(1)  
    public $respc3;                          // string(1)  
    public $respd3;                          // string(1)  
    public $respa4;                          // string(1)  
    public $respb4;                          // string(1)  
    public $respc4;                          // string(1)  
    public $respd4;                          // string(1)  
    public $respa5;                          // string(1)  
    public $respb5;                          // string(1)  
    public $respc5;                          // string(1)  
    public $respd5;                          // string(1)  
    public $respa6;                          // string(1)  
    public $respb6;                          // string(1)  
    public $respc6;                          // string(1)  
    public $respd6;                          // string(1)  
    public $respa7;                          // string(1)  
    public $respb7;                          // string(1)  
    public $respc7;                          // string(1)  
    public $respd7;                          // string(1)  
    public $respa8;                          // string(1)  
    public $respb8;                          // string(1)  
    public $respc8;                          // string(1)  
    public $respd8;                          // string(1)  
    public $respa9;                          // string(1)  
    public $respb9;                          // string(1)  
    public $respc9;                          // string(1)  
    public $respd9;                          // string(1)  
    public $observaciones;                   // blob(65535)  blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Respuestas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
