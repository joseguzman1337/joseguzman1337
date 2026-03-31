<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\sintomasError;

defined('_EXEC') or die;

/**
 * Clase encargada de reconocer si un estudiante tiene sintomas de dessincronizacion
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\sintomasError
 */
class InspectorSintomasDesincronizacion {

    /**
     * @type EstudianteDTO
     * @access private
     */
    private $estudianteDTO;

    /**
     * @type InscripcionDTO
     * @access private
     */
    private $inscripcionDTO;

    /**
     * Constructor de la clase InspectorSintomasDesincronizacion
     * @param EstudianteDTO $estudianteDTO
     * @param InscripcionDTO $inscripcionDTO
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */
    public function __construct($estudianteDTO, $inscripcionDTO) {
        $this->estudianteDTO = $estudianteDTO;
        $this->inscripcionDTO = $inscripcionDTO;
    }

    /**
     * Metodo valida si un estudiante tiene los sintomas de dessincronizacion de
     * estados de inscripcion 
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */
    public function validarSintomas() {
        $db = \Factory::createDbo();
        
        $query = "SELECT COUNT(1) contador
            FROM inscripcion i
            INNER JOIN estudiante e ON (e.idestudiantegeneral = i.idestudiantegeneral   	)
            INNER JOIN estudiantecarrerainscripcion eci ON ( e.codigocarrera = eci.codigocarrera AND i.idestudiantegeneral = eci.idestudiantegeneral AND eci.idinscripcion = i.idinscripcion  )
            INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral = e.idestudiantegeneral )/**/
            WHERE i.codigoperiodo = ".$db->qstr($this->inscripcionDTO->getCodigoperiodo())." 
            AND eg.idestudiantegeneral =  ".$db->qstr($this->estudianteDTO->getIdestudiantegeneral())." 
            AND i.idInscripcion =  ".$db->qstr($this->inscripcionDTO->getIdinscripcion())." 
            AND i.codigoestado = 100
            AND eci.codigoestado = 100
            AND eci.idnumeroopcion = 1 
            AND e.codigosituacioncarreraestudiante IN (105, 106, 107, 111, 113, 115/*, 300, 301*/ )
            AND i.idinscripcion NOT IN (
                SELECT ii.idInscripcion
                FROM inscripcion ii
                INNER JOIN estudiante ee ON (ee.idestudiantegeneral = ii.idestudiantegeneral AND ii.codigosituacioncarreraestudiante = ee.codigosituacioncarreraestudiante AND ii.codigoperiodo = ee.codigoperiodo 	)
                INNER JOIN estudiantecarrerainscripcion ecii ON ( ee.codigocarrera = ecii.codigocarrera AND ii.idestudiantegeneral = ecii.idestudiantegeneral AND ecii.idinscripcion = ii.idinscripcion  )
                INNER JOIN estudiantegeneral egg ON ( egg.idestudiantegeneral = ee.idestudiantegeneral )/**/
                WHERE ii.codigoperiodo = ".$db->qstr($this->inscripcionDTO->getCodigoperiodo())." 
                AND ii.codigoestado = 100
                AND ecii.codigoestado = 100
                AND ecii.idnumeroopcion = 1 
            ) ";
        
        $datos = $db->GetRow($query);
        
        if($datos['contador']==0){
            return false;
        }else{
            return true;
        }
    }
 
    /**
     * Metodo estatico que no requiere instanciacion del objeto para retornar 
     * el listado de todos los estudiante que presentan sintomas para un periodo
     * de inscripcion
     * @param string $codigoPeriodoInscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */
    public static function getListaRegistrosSintomas($codigoPeriodoInscripcion) {
        $db = \Factory::createDbo();
        
        $query = "SELECT i.idinscripcion, e.codigoestudiante
            FROM inscripcion i
            INNER JOIN estudiante e ON (e.idestudiantegeneral = i.idestudiantegeneral   	)
            INNER JOIN estudiantecarrerainscripcion eci ON ( e.codigocarrera = eci.codigocarrera AND i.idestudiantegeneral = eci.idestudiantegeneral AND eci.idinscripcion = i.idinscripcion  )
            INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral = e.idestudiantegeneral )
            WHERE i.codigoperiodo = ".$db->qstr($codigoPeriodoInscripcion)." 
            AND i.codigoestado = 100
            AND eci.codigoestado = 100
            AND eci.idnumeroopcion = 1 
            AND e.codigosituacioncarreraestudiante IN (105, 106, 107, 111, 113, 115/*, 300, 301*/ )
            AND i.idinscripcion NOT IN (
                SELECT ii.idInscripcion
                FROM inscripcion ii
                INNER JOIN estudiante ee ON (ee.idestudiantegeneral = ii.idestudiantegeneral AND ii.codigosituacioncarreraestudiante = ee.codigosituacioncarreraestudiante AND ii.codigoperiodo = ee.codigoperiodo 	)
                INNER JOIN estudiantecarrerainscripcion ecii ON ( ee.codigocarrera = ecii.codigocarrera AND ii.idestudiantegeneral = ecii.idestudiantegeneral AND ecii.idinscripcion = ii.idinscripcion  )
                INNER JOIN estudiantegeneral egg ON ( egg.idestudiantegeneral = ee.idestudiantegeneral )/**/
                WHERE ii.codigoperiodo = ".$db->qstr($codigoPeriodoInscripcion)." 
                AND ii.codigoestado = 100
                AND ecii.codigoestado = 100
                AND ecii.idnumeroopcion = 1 
            ) ";
        
        $datos = $db->GetAll($query);
        
        if(!empty($datos)){
            return $datos;
        }else{
            return null;
        }
        
    }
    
    /**
     * Metodo estatico que no requiere instanciacion del objeto para validar 
     * si un estudiante determinado tiene los sintomas para un periodo de inscripcion
     * @param string $documento
     * @param string $codigoPeriodo
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */
    public static function validarSintomasByDocumento($documento, $codigoPeriodo){
        $db = \Factory::createDbo();
        
        $query = "SELECT i.idinscripcion, e.codigoestudiante
            FROM inscripcion i
            INNER JOIN estudiante e ON (e.idestudiantegeneral = i.idestudiantegeneral   	)
            INNER JOIN estudiantecarrerainscripcion eci ON ( e.codigocarrera = eci.codigocarrera AND i.idestudiantegeneral = eci.idestudiantegeneral AND eci.idinscripcion = i.idinscripcion  )
            INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral = e.idestudiantegeneral )/**/
            WHERE i.codigoperiodo = ".$db->qstr($codigoPeriodo)." 
            AND eg.numerodocumento = ".$db->qstr($documento)." 
            AND i.codigoestado = 100
            AND eci.codigoestado = 100
            AND eci.idnumeroopcion = 1 
            AND e.codigosituacioncarreraestudiante IN (105, 106, 107, 111, 113, 115/*, 300, 301*/ )
            AND i.idinscripcion NOT IN (
                SELECT ii.idInscripcion
                FROM inscripcion ii
                INNER JOIN estudiante ee ON (ee.idestudiantegeneral = ii.idestudiantegeneral AND ii.codigosituacioncarreraestudiante = ee.codigosituacioncarreraestudiante AND ii.codigoperiodo = ee.codigoperiodo 	)
                INNER JOIN estudiantecarrerainscripcion ecii ON ( ee.codigocarrera = ecii.codigocarrera AND ii.idestudiantegeneral = ecii.idestudiantegeneral AND ecii.idinscripcion = ii.idinscripcion  )
                INNER JOIN estudiantegeneral egg ON ( egg.idestudiantegeneral = ee.idestudiantegeneral )/**/
                WHERE ii.codigoperiodo = ".$db->qstr($codigoPeriodo)."  
                AND ii.codigoestado = 100
                AND ecii.codigoestado = 100
                AND ecii.idnumeroopcion = 1 
            ) ";
        $datos = $db->GetRow($query);
        
        if(!empty($datos)){
            return $datos;
        }else{
            return null;
        }
    }

}

?>