<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\interfaces;

defined('_EXEC') or die; 
use Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\EstudianteDTO;
use Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\InscripcionDTO;

/**
 * Interface IFacade para el contrato de la fachada de acceso a los servicios 
 * del aplicativo
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\interfaces
 */
interface IFacade {

    /**
     * Este metodo será el encargado de hacer el llamado al builder
     * @access public
     * @param idInscripcion
     * @param codigoEstudiante 
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since noviembre 15, 2018
    */
    public function construir($idInscripcion, $codigoEstudiante);

    /**
     * 
     * @param codigoPeriodo
     * @param codigoSituacionCarreraEstudiante
     * @param estudiante
     * @param inscripcion
     */
    public function sincronizar($codigoPeriodo, $codigoSituacionCarreraEstudiante, $codigoestudiante, $idinscripcion);

    /**
     * 
     * @param estudianteDTO
     * @param inscripcionDTO
     */
    public function validarSintomas(EstudianteDTO $estudianteDTO, InscripcionDTO $inscripcionDTO);
}
