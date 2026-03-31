<?php
require_once("../../templates/template.php");   
/**
* Consulta Espacios físicos de la Universidad el Bosque
*/
class ConsultarEspacios{
    var $db;
    function __construct(){
        $this->db = getBD();
       }
    function ConsultarSedes(){
    	$consultaSede = "select ClasificacionEspaciosId,Nombre from ClasificacionEspacios where EspaciosFisicosId = 3";
    	if($Detalle=&$this->db->Execute($consultaSede)===false){
			echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
			die;
		}//if
		return $Detalle;
    }
    function ConsultarBloque($ClasificacionEspaciosId){
  //   	$consultaSede = "select Nombre from ClasificacionEspacios where ClasificacionEspaciosPadreId =".$ClasificacionEspaciosId;
  //   	if($Detalle=&$this->db->Execute($consultaSede)===false){
		// 	echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
		// 	die;
		// }//if
		// return $Detalle;
    }
}
?>