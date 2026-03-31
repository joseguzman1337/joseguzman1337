<?php
/**
 * Clase encargada del control para la configuracion del simulador financiero
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Control
 * @since Enero 20, 2017
*/

$entidadConfig = realpath(__DIR__."/../entidades/ConfigSimuladorFinanciero.php");
//d($entidadConfig);
require_once($entidadConfig);
$entidadCarrera = realpath(__DIR__."/../entidades/Carrera.php");
require_once($entidadCarrera);
class ControlConfigSimuladorFinanciero 
{
	
    /**
     * Constructor del objeto
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
    function __construct() { 
	}
	
    /**
     * Consulta la ultima configuracion activa del simulador financiero
     * @access public
     * @param Object Singleton $persistencia
     * @return Array <Facultades>
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
    public function getConfigSimuladorFinanciero( $persistencia )
    { 
        $ConfigSimuladorFinanciero = new ConfigSimuladorFinanciero( $persistencia );
		$ConfigSimuladorFinanciero->getConfigSimuladorFinanciero(  );
		
        return $ConfigSimuladorFinanciero;
    }
	
    /**
     * Consulta y retorna el listado de carreras
     * @access public 
     * @param Object Singleton $persistencia
	 * @param int $codigoModalidadAcademica
     * @return Array $carreras
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    public function getListaCarreras( $persistencia, $codigoModalidadAcademica )
    { 
        $Carrera = new Carrera( $persistencia );
		$carreras = $Carrera->getListaCarreras( $codigoModalidadAcademica );
		
        return $carreras;
    }
}
?>