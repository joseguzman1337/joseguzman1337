<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante\interfaces;

defined('_EXEC') or die;

/**
 * Interface IBuild para el contrato de constructores builder del aplicativo
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\utiles\SincronizarInscripcionEstudiante\interfaces
 */
interface IBuild {

    /**
     * Este metodo será el encargado de crear los objetos involucrados
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since noviembre 15, 2018
    */
    public function build();
}
