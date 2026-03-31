<?php
/**
 * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */
class PermisoGrados {
    /**
    * @type int
    * @access private
    */
    private $rolId;
    /**
    * @type int
    * @access private
    */
    private $objetoGradoId;
    /**
    * @type String
    * @access private
    */
    private $permisoSeleccion;
    /**
    * @type String
    * @access private
    */
    private $permisoInsercion;
    /**
    * @type String
    * @access private
    */
    private $permisoActualzacion;
    /**
    * @type String
    * @access private
    */
    private $permisoEliminacion;
    /**
    * @type String
    * @access private
    */
    private $estadoPermiso;
    /**
    * @type int
    * @access private
    */
    private $existePermiso;
    
    public function getExistePermiso() {
        return $this->existePermiso;
    }

    public function getPersistencia() {
        return $this->persistencia;
    }

    public function setExistePermiso($existePermiso) {
        $this->existePermiso = $existePermiso;
    }

    public function setPersistencia($persistencia) {
        $this->persistencia = $persistencia;
    }

    private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
    public function PermisoGrados ( $persistencia ){
	$this->persistencia = $persistencia;
    }
    public function getRolId() {
        return $this->rolId;
    }

    public function getObjetoGradoId() {
        return $this->objetoGradoId;
    }

    public function getPermisoSeleccion() {
        return $this->permisoSeleccion;
    }

    public function getPermisoInsercion() {
        return $this->permisoInsercion;
    }

    public function getPermisoActualzacion() {
        return $this->permisoActualzacion;
    }

    public function getPermisoEliminacion() {
        return $this->permisoEliminacion;
    }

    public function getEstadoPermiso() {
        return $this->estadoPermiso;
    }

    public function setRolId($rolId) {
        $this->rolId = $rolId;
    }

    public function setObjetoGradoId($objetoGradoId) {
        $this->objetoGradoId = $objetoGradoId;
    }

    public function setPermisoSeleccion($permisoSeleccion) {
        $this->permisoSeleccion = $permisoSeleccion;
    }

    public function setPermisoInsercion($permisoInsercion) {
        $this->permisoInsercion = $permisoInsercion;
    }

    public function setPermisoActualzacion($permisoActualzacion) {
        $this->permisoActualzacion = $permisoActualzacion;
    }

    public function setPermisoEliminacion($permisoEliminacion) {
        $this->permisoEliminacion = $permisoEliminacion;
    }

    public function setEstadoPermiso($estadoPermiso) {
        $this->estadoPermiso = $estadoPermiso;
    }

    /**
    * Verifica si existe el permiso para el rol para identifica si debe insertar o actualizar
    * @param int $estado 
    * @param int $rol
    * @param int $permiso
    * @access public
    * @return int 
    */
    public function verificarPermiso( $estado , $rol , $permiso , $idPersona){
        
        $sql = "SELECT
                    count( * ) as conteo
                FROM
                    PermisoGrados 
                WHERE
                    ObjetoGradosId = ? 
                AND RolId =?";
        
        $this->persistencia->crearSentenciaSQL( $sql );
	$this->persistencia->setParametro( 0 , $permiso , true );
	$this->persistencia->setParametro( 1 , $rol , true );
        $this->persistencia->ejecutarConsulta(  );
        
        if( $this->persistencia->getNext( ) )
            $cantidad = $this->persistencia->getParametro( "conteo" );
            if( $cantidad == 1){
                $this->actualizarPermiso( $estado , $rol , $permiso , $idPersona );
            }else{
                $this->nuevoPermiso( $estado , $rol , $permiso , $idPersona );
            };
    }
    
    
    public function actualizarPermiso( $estado , $rol , $permiso , $idPersona){
        $sql = "UPDATE PermisoGrados 
                SET estadoPermiso = ? ,
                    usuarioCreaActualiza= ?,
                    fechaCreaActualiza = now()
                    
                WHERE 
                    ObjetoGradosId = ?
                    AND RolId = ?";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $estado , false );
        $this->persistencia->setParametro( 1 , $idPersona , false );
        $this->persistencia->setParametro( 2 , $permiso , false );
        $this->persistencia->setParametro( 3 , $rol , false );
        //echo $this->persistencia->getSQLListo( ).'<br><br>';
        $estado = $this->persistencia->ejecutarUpdate( );
    }
    
    public function nuevoPermiso( $estado , $rol , $permiso , $idPersona  ){
        $sql = "														
                INSERT INTO PermisoGrados ( 
                        RolId, 
                        ObjetoGradosId, 
                        PermisoSeleccion, 
                        PermisoInsercion, 
                        PermisoActualizacion, 
                        PermisoEliminacion, 
                        estadoPermiso,
                        usuarioCreaActualiza,
                        fechaCreaActualiza                        
                )
                VALUES
                ( ?, ?, 'SI', 'SI', 'SI', 'SI', ? ,?,now());";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $rol , false );
        $this->persistencia->setParametro( 1 , $permiso , false );
        $this->persistencia->setParametro( 2 , $estado , false );
        $this->persistencia->setParametro( 3 , $idPersona , false );        
        //echo $this->persistencia->getSQLListo( ).'<br><br>';
        $estado = $this->persistencia->ejecutarUpdate( );
    }
}
