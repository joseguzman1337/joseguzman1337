<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package entidades
	 */
	
	include '../entidades/DetallePrematricula.php';
  	
	
	class ControlPreMatricula{
		
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlPreMatricula( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Busca cantidad de materias actuales
	 * @param int $txtCodigoCarrera, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarMateriasActuales( $txtCodigoEstudiante ){
		
		/*Modified Diego Rivera <riveradiego@unbsoque.edu.co>
		*se cambian validacion de materias   a creditos case  $rangoPreMatricula >= 1 && $rangoPreMatricula <= 3  por $rangoPreMatricula >= 90 && $rangoPreMatricula < 100
		*case ( $rangoPreMatricula >= 4 ) por $rangoPreMatricula < 90  )
		* case  rangoPreMatricula == 0  por rangoPreMatricula=100
		* las validaciones se modificaron por porcentaje cumplido respecto numero de creditos del plan de estudio
		*Since november 14 , 2017 	
		*/


		$detallePreMatricula = new DetallePrematricula( $this->persistencia );
		$detallePreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );	
		$rangoPreMatricula = $detallePreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );		
	
		switch( true ){
			
			case ( $rangoPreMatricula >= 90 && $rangoPreMatricula < 100 ):
				$detallePreMatricula = "../css/images/circuloAmarillo.png";
				
				$pendienteMateria = 0;
				
			break;
			
			case ( $rangoPreMatricula < 90 ):
				$detallePreMatricula = "../css/images/circuloRojo.png";
				
				$pendienteMateria = -1;
				
			break;
			
			case ( $rangoPreMatricula == 100 ):
				$detallePreMatricula = "../css/images/circuloVerde.png";
				
				$pendienteMateria = 1;
				
			break;
		}
		
		return array( 'detallePreMatricula' => $detallePreMatricula, 'pendienteMateria' => $rangoPreMatricula );
		
	}
	
}
?>