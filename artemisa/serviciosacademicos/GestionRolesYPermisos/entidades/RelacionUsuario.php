<?php
/**
 * Clase encargada de modelo de la tabla RelacionUsuario
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 06, 2017
*/
class RelacionUsuario{
    /**
     * @type Singleton
     * @access private
    */
    private $persistencia;

    /**
     * @type int
     * @access private
    */
    private $id;

    /**
     * @type String
     * @access private
    */
    private $nombre;

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
    public function RelacionUsuario( $persistencia ){
            $this->persistencia = $persistencia;
    }


    /**
     * Retornar una lista con  todos los valores de la tabla RelacionUsuario
     * @param $txtCodigoFacultad
     * @access public
    */
    public function getRelacionUsuarioList( ){
            $relaciones = array();
            $sql = "SELECT id, nombre
                              FROM RelacionUsuario";

            $this->persistencia->crearSentenciaSQL( $sql );
            //$this->persistencia->setParametro( 0 , $txtCodigoFacultad , false );
            //d($this->persistencia->getSQLListo( ));
            $this->persistencia->ejecutarConsulta( );
            while( $this->persistencia->getNext( ) ){
                    $relacion = new RelacionUsuario(null);
                    $relacion->__set( "id", $this->persistencia->getParametro( "id" ) );
                    $relacion->__set( "nombre", $this->persistencia->getParametro( "nombre" ) );
                    $relaciones[] = $relacion;
            }
            //ddd($relaciones);
            return $relaciones;
    }
}
?>