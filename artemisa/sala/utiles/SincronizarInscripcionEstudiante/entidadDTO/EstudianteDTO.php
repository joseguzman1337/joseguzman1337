<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO;

defined('_EXEC') or die;

/**
 * Clase que contiene una version ligth del objeto entidad/Estudiante
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO
 */
class EstudianteDTO {

    /**
     * @type int
     * @access private
     */
    private $codigocarrera;

    /**
     * @type int
     * @access private
     */
    private $codigoestudiante;

    /**
     * @type string
     * @access private
     */
    private $codigoperiodo;

    /**
     * @type string
     * @access private
     */
    private $codigosituacioncarreraestudiante;

    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;

    /**
     * Constructor de la clase EstudianteDTO, unico lugar donde se setean valores
     * convierte al objeto en inmutable
     * @param Estudiante $estudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct(\Estudiante $estudiante) {
        $this->codigocarrera = $estudiante->getCodigocarrera();
        $this->codigoestudiante = $estudiante->getCodigoestudiante();
        $this->codigoperiodo = $estudiante->getCodigoperiodo();
        $this->codigosituacioncarreraestudiante = $estudiante->getCodigosituacioncarreraestudiante();
        $this->idestudiantegeneral = $estudiante->getIdestudiantegeneral();
    }
    
    /**
     * Retorna el codigocarrera
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */ 
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    /**
     * Retorna el codigoestudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */ 
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    /**
     * Retorna el codigoperiodo
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return string
     */ 
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    /**
     * Retorna el codigosituacioncarreraestudiante
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return string
     */ 
    public function getCodigosituacioncarreraestudiante() {
        return $this->codigosituacioncarreraestudiante;
    }

    /**
     * Retorna el idestudiantegeneral
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */ 
    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }


}
