<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO;

defined('_EXEC') or die;


/**
 * Clase que contiene una version ligth del objeto entidad/Inscripcion
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO
 */
class InscripcionDTO {

    /**
     * @type string
     * @access private
     */
    private $codigoestado;

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
     * @type int
     * @access private
     */
    private $idinscripcion;

    /**
     * Constructor de la clase InscripcionDTO, unico lugar donde se setean valores
     * convierte al objeto en inmutable
     * @param Inscripcion $inscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct(\Inscripcion $inscripcion) {
        $this->codigoestado = $inscripcion->getCodigoestado();
        $this->codigoperiodo = $inscripcion->getCodigoperiodo();
        $this->codigosituacioncarreraestudiante = $inscripcion->getCodigosituacioncarreraestudiante();
        $this->idestudiantegeneral = $inscripcion->getIdestudiantegeneral();
        $this->idinscripcion = $inscripcion->getIdinscripcion();
    }
    
    /**
     * Retorna el codigoestado
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return string
     */ 
    public function getCodigoestado() {
        return $this->codigoestado;
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

    /**
     * Retorna el idinscripcion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return int
     */ 
    public function getIdinscripcion() {
        return $this->idinscripcion;
    }
}
