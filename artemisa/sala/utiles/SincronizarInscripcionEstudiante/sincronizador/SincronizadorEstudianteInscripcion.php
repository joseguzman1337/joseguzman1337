<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\sincronizador;

defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Estudiante.php");
require_once(PATH_SITE."/entidad/Inscripcion.php");

/**
 * Clase encargada de la sincronizacion de los estados en inscripcion y estudiante
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\sincronizador
 */
class SincronizadorEstudianteInscripcion {

    /**
     * @type string
     * @access private
     */
    private $codigoPeriodo;

    /**
     * @type string
     * @access private
     */
    private $codigoSituacionCarreraEstudiante;

    /**
     * @type EstudianteDTO
     * @access private
     */
    private $estudiante;

    /**
     * @type InscripcionDTO
     * @access private
     */
    private $inscripcion;

    /**
     * @type EstudianteDAO
     * @access private
     */
    private $estudianteDAO;

    /**
     * @type InscripcionDAO
     * @access private
     */
    private $inscripcionDAO;
    
    private $estadosInscripcion = array(105, 106, 107, 111, 113, 115, 300);

    /**
     * Constructor de la clase SincronizadorEstudianteInscripcion
     * @param string $codigoPeriodo
     * @param string $codigoSituacionCarreraEstudiante
     * @param string $estudiante
     * @param string $inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct($codigoPeriodo = null, $codigoSituacionCarreraEstudiante = null, $estudiante = null, $inscripcion = null) {
        if(!empty($codigoPeriodo)){
            $this->codigoPeriodo = $codigoPeriodo;
        }
        if(!empty($codigoSituacionCarreraEstudiante)){
            $this->codigoSituacionCarreraEstudiante = $codigoSituacionCarreraEstudiante;
        }
        if(!empty($estudiante)){
            $this->estudiante = new \Estudiante();
            $this->estudiante->setDb();
            $this->estudiante->setCodigoEstudiante($estudiante);
            $this->estudiante->getById();
            //$estudiante;
        }
        if(!empty($inscripcion)){
            $this->inscripcion = new \Inscripcion();
            $this->inscripcion->setDb();
            $this->inscripcion->setIdinscripcion($inscripcion);
            $this->inscripcion->getById();
        }
    }
    
    /**
     * Retorna el codigoPeriodo
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return string
     */ 
    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    /**
     * Retorna el codigoSituacionCarreraEstudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return string
     */ 
    public function getCodigoSituacionCarreraEstudiante() {
        return $this->codigoSituacionCarreraEstudiante;
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
     * Retorna el inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return InscripcionDTO
     */ 
    public function getInscripcion() {
        return $this->inscripcion;
    }

    /**
     * Retorna el inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return InscripcionDTO
     */ 
    public function setCodigoPeriodo($codigoPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    /**
     * Setea el codigoSituacionCarreraEstudiante
     * @param string $codigoSituacionCarreraEstudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */  
    public function setCodigoSituacionCarreraEstudiante($codigoSituacionCarreraEstudiante) {
        $this->codigoSituacionCarreraEstudiante = $codigoSituacionCarreraEstudiante;
    }

    /**
     * Setea el estudiante
     * @param string $estudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function setEstudiante($estudiante) {
        $this->estudiante = new \Estudiante();
        $this->estudiante->setDb();
        $this->estudiante->setCodigoEstudiante($estudiante);
        $this->estudiante->getById();
    }

    /**
     * Setea el inscripcion
     * @param string $inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function setInscripcion($inscripcion) {
        $this->inscripcion = new \Inscripcion();
        $this->inscripcion->setDb();
        $this->inscripcion->setIdinscripcion($inscripcion);
        $this->inscripcion->getById();
    }

    
    /**
     * Metodo encargado de la sincronizacion de estado y periodo de estudiante e
     * inscripcion
     * @param string $inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function sincronizar() {
        $rs1 = false;
        $rs2 = false;
        $this->estudiante->setCodigoPeriodo($this->codigoPeriodo);
        $this->estudiante->setCodigoSituacionCarreraEstudiante($this->codigoSituacionCarreraEstudiante);
        $this->estudianteDAO = new \Sala\entidadDAO\EstudianteDAO($this->estudiante);
        $this->estudianteDAO->setDb();
        $rs1 = $this->estudianteDAO->save();
        
        if(in_array($this->codigoSituacionCarreraEstudiante, $this->estadosInscripcion)){
            $this->inscripcion->setCodigoPeriodo($this->codigoPeriodo);
            $this->inscripcion->setCodigoSituacionCarreraEstudiante($this->codigoSituacionCarreraEstudiante);
            $this->inscripcionDAO = new \Sala\entidadDAO\InscripcionDAO($this->inscripcion);
            $this->inscripcionDAO->setDb();
            $rs2 = $this->inscripcionDAO->save();            
        }
        
        if($rs1 || $rs2){
            return true;
        }else{
            return false;
        }
    }

}

