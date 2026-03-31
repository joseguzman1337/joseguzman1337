<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\constructor;

defined('_EXEC') or die;

require_once (PATH_SITE."/entidad/Inscripcion.php");
require_once (PATH_SITE."/entidad/Estudiante.php");
require_once (PATH_SITE."/entidad/EstudianteCarreraInscripcion.php");
require_once (PATH_SITE."/entidad/EstudianteGeneral.php");


/**
 * Clase que se encarga de construir los objetos involucrados en el proceso de 
 * sincronizacion de estudiante e inscripcion
 * 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Sala\utiles\SincronizarInscripcionEstudiante\constructor
*/
class ConstructorInscripcionEstudiante implements \Sala\utiles\SincronizarInscripcionEstudiante\interfaces\IBuild {

    /**
     * @type int
     * @access private
     */
    private $codigoEstudiante;
    
    /**
     * @type EstudianteDTO
     * @access private
     */
    private $estudiante;

    /**
     * @type int
     * @access private
     */
    private $idInscripcion;

    /**
     * @type InscripcionDTO
     * @access private
     */
    private $inscripcion;

    /**
     * Constructor de la clase ConstructorInscripcionEstudiante,
     * @param int $idInscripcion
     * @param int $codigoEstudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */  
    public function __construct($idInscripcion, $codigoEstudiante) {
        $this->codigoEstudiante = $codigoEstudiante;
        $this->idInscripcion = $idInscripcion;
    }
    
    /**
     * Retorna el codigoEstudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */  
    public function getCodigoEstudiante() {
        return $this->codigoEstudiante;
    }

    /**
     * Retorna el estudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return EstudianteDTO
     */ 
    public function getEstudiante() {
        return $this->estudiante;
    }

    /**
     * Retorna el idInscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */  
    public function getIdInscripcion() {
        return $this->idInscripcion;
    }

    /**
     * Retorna el inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return InscripcionDTO
     */ 
    public function getInscripcion() {
        return $this->inscripcion;
    }

    /**
     * Metodo encargado de la creacion de los objetos involucrados en el proceso
     * de sincronizacion de estudiante e inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    public function build() {
        $inscripcion = new \Inscripcion();
        $inscripcion->setIdinscripcion($this->idInscripcion);
        $inscripcion->setDb();
        $inscripcion->getById();
        
        $this->inscripcion = new \Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\InscripcionDTO($inscripcion);
        unset($inscripcion);
        
        if(empty($this->codigoEstudiante)){
            $datosEstudianteCarreraInscripcion = \EstudianteCarreraInscripcion::getByIdInscripcionEstudiante($this->idInscripcion);
            if(!empty($datosEstudianteCarreraInscripcion[0])){
                $datosEstudiante = \Estudiante::getList(" codigocarrera = '".$datosEstudianteCarreraInscripcion[0]->getCodigocarrera()."' AND idestudiantegeneral = '".$datosEstudianteCarreraInscripcion[0]->getIdestudiantegeneral()."' ");
                if(!empty($datosEstudiante[0])){
                    $this->codigoEstudiante = $datosEstudiante[0]->getCodigoEstudiante();
                }
            }
        }
        
        $estudiante = new \Estudiante();
        $estudiante->setCodigoEstudiante($this->codigoEstudiante);
        $estudiante->setDb();
        $estudiante->getById();
        
        $this->estudiante = new \Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\EstudianteDTO($estudiante);
        unset($estudiante);
    }

}
