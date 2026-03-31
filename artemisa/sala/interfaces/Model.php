<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaces
 */
defined('_EXEC') or die;
interface Model {
    /**
     * Consulta las y retorna el un array de variables que se utilizan en el render de los componentes
     * @access public
     * @param Standar Object $variables
     * @return Array
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public function getVariables($variables);
}
