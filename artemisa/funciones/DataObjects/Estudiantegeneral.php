<?php
/**
 * Table Definition for estudiantegeneral
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantegeneral extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantegeneral';               // table name
    var $idestudiantegeneral;             // int(11)  not_null primary_key auto_increment
    var $idtrato;                         // int(11)  not_null multiple_key
    var $idestadocivil;                   // int(11)  not_null multiple_key
    var $tipodocumento;                   // string(2)  not_null multiple_key
    var $numerodocumento;                 // string(15)  not_null multiple_key
    var $expedidodocumento;               // string(100)  not_null
    var $numerolibretamilitar;            // string(20)  not_null
    var $numerodistritolibretamilitar;    // string(10)  not_null
    var $expedidalibretamilitar;          // string(50)  not_null
    var $nombrecortoestudiantegeneral;    // string(15)  not_null
    var $nombresestudiantegeneral;        // string(25)  not_null
    var $apellidosestudiantegeneral;      // string(25)  not_null
    var $fechanacimientoestudiantegeneral;    // datetime(19)  not_null binary
    var $idciudadnacimiento;              // int(11)  not_null multiple_key
    var $codigogenero;                    // string(3)  not_null multiple_key
    var $direccionresidenciaestudiantegeneral;    // string(255)  not_null
    var $direccioncortaresidenciaestudiantegeneral;    // string(255)  
    var $ciudadresidenciaestudiantegeneral;    // string(25)  not_null
    var $telefonoresidenciaestudiantegeneral;    // string(15)  not_null
    var $telefono2estudiantegeneral;      // string(15)  
    var $celularestudiantegeneral;        // string(15)  
    var $direccioncorrespondenciaestudiantegeneral;    // string(100)  
    var $direccioncortacorrespondenciaestudiantegeneral;    // string(255)  
    var $ciudadcorrespondenciaestudiantegeneral;    // string(25)  
    var $telefonocorrespondenciaestudiantegeneral;    // string(15)  
    var $emailestudiantegeneral;          // string(100)  
    var $email2estudiantegeneral;         // string(100)  
    var $fechacreacionestudiantegeneral;    // datetime(19)  binary
    var $fechaactualizaciondatosestudiantegeneral;    // datetime(19)  binary
    var $codigotipocliente;               // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantegeneral',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
