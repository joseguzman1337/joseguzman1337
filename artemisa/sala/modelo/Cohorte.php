<?php
defined('_EXEC') or die;
/**
 * Clase Cohorte es el Modelo general de Cohorte, utilizado para la consulta del
 * numero de cohorte de un estudiente en un periodo determinado
 * Implementación de la Interface Model
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class Cohorte implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db; 
    
    public function __construct(){
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        
    }
    
    public static function getNumeroCohorte($codigoperiodo,$codigoestudiante){
        $db = Factory::createDbo();
        // Selecciona la cohorte del estudiante
	$query = "SELECT c.numerocohorte "
                . "FROM cohorte c "
                . "INNER JOIN estudiante e ON (c.codigocarrera = e.codigocarrera) "
                . "WHERE c.codigoperiodo = ".$db->qstr($codigoperiodo)." "
                . " AND e.codigoestudiante = ".$db->qstr($codigoestudiante)." "
                . " AND e.codigoperiodo*1 BETWEEN codigoperiodoinicial*1 "
                . " AND codigoperiodofinal*1";
        //d($query);
	$datoCohorte = $db->Execute($query);
        
	$row = $datoCohorte->FetchRow();
        //d($row);
	$numeroCohorte = $row['numerocohorte'];
        return $numeroCohorte;
    }
}