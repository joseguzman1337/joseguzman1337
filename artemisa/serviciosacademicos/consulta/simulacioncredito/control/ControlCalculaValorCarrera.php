<?php
/**
 * Clase encargada del control para la configuracion del simulador financiero
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Control
 * @since Enero 20, 2017
*/

$entidadCarrera = realpath(__DIR__."/../entidades/Carrera.php");
require_once($entidadCarrera); 

$entidadPeriodo = realpath(__DIR__."/../entidades/Periodo.php");
require_once($entidadPeriodo);

$entidadCohorte = realpath(__DIR__."/../entidades/Cohorte.php");
require_once($entidadCohorte);

class ControlCalculaValorCarrera
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
     * Consulta los periodos actual y siguiente
     * @access public
     * @param Object Singleton $persistencia
     * @return Array <Facultades>
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
    public function getPeriodoActualSiguiente( $persistencia )
    { 
        $Periodo = new Periodo( $persistencia );
		$Periodo->getPeriodoActualSiguiente(  );
		
        return $Periodo;
    } 
	
    /**
     * Consulta el valor del cohorte para el periodo y carrera especificados
     * @access public
     * @param Object Singleton $persistencia
     * @return Array <Facultades>
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
    public function getValorCohortePeriodoCarrera( $persistencia, $codcarrera, $periodoSiguiente )
    { 
        $Cohorte = new Cohorte( $persistencia );
		$Cohorte->getValorCohortePeriodoCarrera( $codcarrera, $periodoSiguiente );
		
        return $Cohorte;
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
    public function getCarreraPorCodigo( $persistencia, $codcarrera )
    { 
        $Carrera = new Carrera( $persistencia );
		$Carrera->getCarreraPorCodigo( $codcarrera );
		
        return $Carrera;
    }
}
?>