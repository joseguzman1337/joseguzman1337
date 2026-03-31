<?php
/**
 * Clase encargada de modelo de la tabla de Componentes
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 06, 2017
*/
class Componente{
	/**
	 * @type Singleton
	 * @access private
	*/
	private $persistencia;
	
	/**
	 * @type int
	 * @access private
	*/
	private $idmenuopcion;
	
	/**
	 * @type String
	 * @access private
	*/
	private $nombremenuopcion;
	
	/**
	 * @type int
	 * @access private
	*/
	private $idpadremenuopcion;
	
	public function __set($name, $value){
        $this->{$name} = $value;
    }

    public function __get($name){
        if (!empty($this->{$name})) {
            return $this->{$name};
        }
        return null;
    }
	
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	*/
	public function Componente( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Retornar una lista con  todos los componentes
	 * @param $txtCodigoFacultad
	 * @access public
	*/
	public function getComponenteList($idComponente=null){
		$componentes = array();
		$sql = "SELECT idmenuopcion, nombremenuopcion, idpadremenuopcion
				  FROM menuopcion
                                 WHERE linkmenuopcion IS NOT NULL 
                                   AND linkmenuopcion <> \"\"";
		if(!empty($idComponente)){
			$sql .= " AND idmenuopcion = ".$idComponente;
		}
                $sql .= " ORDER BY nombremenuopcion ASC";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//$this->persistencia->setParametro( 0 , $txtCodigoFacultad , false );
		//d($this->persistencia->getSQLListo( ));
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$componente = new Componente(null);
			$componente->__set( "idmenuopcion", $this->persistencia->getParametro( "idmenuopcion" ) );
			$componente->__set( "nombremenuopcion", $this->persistencia->getParametro( "nombremenuopcion" ) );
			$componente->__set( "idpadremenuopcion", $this->persistencia->getParametro( "idpadremenuopcion" ) );
			$componentes[] = $componente;
		}
		
		return $componentes;
	}
}
?>