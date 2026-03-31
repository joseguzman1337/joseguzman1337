<?php
require_once("../templates/template.php");
/**
* Consulta Espacios físicos de la Universidad el Bosque
*/
class ConsultarEspacios{
    var $db;
    function __construct(){
        $this->db =getBD();// writeHeader('Menu',true);
       }
    function ConsultarSedes(){
    	$consultaSede = "select ClasificacionEspaciosId,Nombre from ClasificacionEspacios where EspaciosFisicosId = 3 AND codigoestado = 100" ;
    	if($Detalle=&$this->db->Execute($consultaSede)===false){
			echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
			die;
		}//if
		return $Detalle;
    }
     function ConsultarEspaciosBosque($ClasificacionEspaciosId){
      $consultaBloquess = "select ClasificacionEspaciosId, Nombre, descripcion, CapacidadEstudiantes from ClasificacionEspacios where  EspaciosFisicosId<>6 AND codigoestado = 100 AND ClasificacionEspacionPadreId =".$ClasificacionEspaciosId;
     if($Detalle=&$this->db->Execute($consultaBloquess)===false){
     echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
     die;
    }//if
    return $Detalle;
    }
}
?>