<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since enero  23, 2017
 * @package control
 */
include("../entidades/Documento.php");

 
 class ControlDocumento{
 	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlDocumento( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los tipos de documentos
	 * @access public
	 * @return Array<TipoDocumento>
	 */
	public function consultarTipoDocumento( ){
		$tipoDocumento = new Documento( $this->persistencia );
		return $tipoDocumento;
	}
 }
?>

