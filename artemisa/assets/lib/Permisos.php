<?php

/**
 * Clase encargada de modelo de la tabla RelacionUsuario
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 13, 2017
*/

require_once(dirname(dirname(__FILE__))."/Singleton.php");
require_once(dirname(dirname(dirname(__FILE__)))."/kint/Kint.class.php"); 
class Permisos{
    /**
     * $type int
     * @access private
    */
    private $id;
    
    /**
     * $type int
     * @access private
    */
    private $idTipoPermiso;
    
    /**
     * $type int
     * @access private
    */
    private $idComponente;
    
    /**
     * $type int
     * @access private
    */
    private $idRelacionUsuario;
    
    /**
     * $type int
     * @access private
    */
    private $idUsuario;
    
    /**
     * $type int
     * @access private
    */
    private $ver;
    
    /**
     * $type int
     * @access private
    */
    private $editar;
    
    /**
     * $type int
     * @access private
    */
    private $insertar;
    
    /**
     * $type int
     * @access private
    */
    private $eliminar;
    
    /**
     * @type Singleton
     * @access private
    */
    public $persistencia;
    
    function getId() {
        return $this->id;
    }

    function getIdTipoPermiso() {
        return $this->idTipoPermiso;
    }

    function getIdComponente() {
        return $this->idComponente;
    }

    function getIdRelacionUsuario() {
        return $this->idRelacionUsuario;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getVer() {
        return $this->ver;
    }

    function getEditar() {
        return $this->editar;
    }

    function getInsertar() {
        return $this->insertar;
    }

    function getEliminar() {
        return $this->eliminar;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdTipoPermiso($idTipoPermiso) {
        $this->idTipoPermiso = $idTipoPermiso;
    }

    function setIdComponente($idComponente) {
        $this->idComponente = $idComponente;
    }

    function setIdRelacionUsuario($idRelacionUsuario) {
        $this->idRelacionUsuario = $idRelacionUsuario;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setVer($ver) {
        $this->ver = $ver;
    }

    function setEditar($editar) {
        $this->editar = $editar;
    }

    function setInsertar($insertar) {
        $this->insertar = $insertar;
    }

    function setEliminar($eliminar) {
        $this->eliminar = $eliminar;
    }

    function getPersistencia() {
        return $this->persistencia;
    }

    function setPersistencia($persistencia) {
        $this->persistencia = $persistencia;
    }

    function __construct( $persistencia) {
        $this->persistencia = $persistencia;
    }
    
    public function getPermisos($relacionUsuario=null, $idUsuario=null, $idComponent=null, $tipoPermiso=null, $action=null, $id=null){
        //d($this->persistencia);
        $permiso = new Permisos(null);
        $where = array();
        $params = array();
        
        $sql = "SELECT p.id, p.idTipoPermiso, idRelacionUsuario,
                       p.idUsuario, p.editar, p.ver, p.insertar, p.eliminar
                  FROM Permiso p
            INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso) ";
        
        if(!empty($id)){
            $pos = count($where);
            $where[] = 'p.id = ?'; 
            $objParam = new stdClass();
            $objParam->value = $id;
            $objParam->text = false;
            $params[$pos] = $objParam; 
            unset($objParam);
        }
        if(!empty($relacionUsuario)){
            $pos = count($where);
            $where[] = 'p.idRelacionUsuario = ?'; 
            $objParam = new stdClass();
            $objParam->value = $relacionUsuario;
            $objParam->text = false;
            $params[$pos] = $objParam; 
            unset($objParam);
        }
        if(!empty($idUsuario) || ($idUsuario==0)){
            $pos = count($where);
            $where[] = 'p.idUsuario = ?'; 
            $objParam = new stdClass();
            $objParam->value = $idUsuario;
            $objParam->text = false;
            $params[$pos] = $objParam; 
            unset($objParam);
        }
        if(!empty($idComponent)){
            $pos = count($where);
            $where[] = 'p.idComponenteModulo = ?'; 
            $objParam = new stdClass();
            $objParam->value = $idComponent;
            $objParam->text = false;
            $params[$pos] = $objParam; 
            unset($objParam);
        }
        if(!empty($tipoPermiso)){
            $pos = count($where);
            $where[] = 'tp.nombre = ?'; 
            $objParam = new stdClass();
            $objParam->value = $tipoPermiso;
            $objParam->text = true;
            $params[$pos] = $objParam; 
            unset($objParam);
        }
        
        if(!empty($where)){
                $sql .= ' 
                     WHERE '.implode(' AND ',$where);
        }

        $this->persistencia->crearSentenciaSQL( $sql ); 
        
        if(!empty($params)){
            foreach($params as $k=>$v){
                $this->persistencia->setParametro( $k, $v->value, $v->text );
            }
        }
        
        //d($this->persistencia->getSQLListo( ));
        
        $this->persistencia->ejecutarConsulta( );
        if( $this->persistencia->getNext( ) ){
            $permiso->setId($this->persistencia->getParametro( "id"));
            $permiso->setIdTipoPermiso($this->persistencia->getParametro( "idTipoPermiso" ));
            $permiso->setIdRelacionUsuario($this->persistencia->getParametro( "idRelacionUsuario" ));
            $permiso->setIdUsuario($this->persistencia->getParametro( "idUsuario" ));
            $permiso->setVer($this->persistencia->getParametro( "ver" ));
            $permiso->setInsertar($this->persistencia->getParametro( "insertar" ));
            $permiso->setEliminar($this->persistencia->getParametro( "eliminar" ));
            $permiso->setEditar($this->persistencia->getParametro( "editar" ));
        }
        return $permiso;
    }
    
    public function checkPermisos($relacionUsuario=null, $idUsuario=null, $idComponent=null, $tipoPermiso=null, $action=null){
        $permiso =  $this->getPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action);
        //ddd($permiso);
        
        if(!empty($action)){
            $permisoAccion = $permiso->{'get'.ucfirst($action)}() ;
            //$return =  !empty( $permisoAccion );
            //d($permisoAccion);
            return $permisoAccion;
        }else{
            return $permiso;
        }
    }
    
    public static function validarPermisiosModuloUsuario($idUsuario, $idModulo=null, $accion=null ){
        
    }


    public static function validarPermisosComponenteUsuario($Usuario, $idComponente, $accion=null ){
        $idRol = 0;
        $idTipoUsuario = 0;
        
        $persistencia = new Singleton( );
        $persistencia->conectar( ); 
        
        $sql = "SELECT u.idusuario, r.idrol, tu.codigotipousuario
                  FROM usuario u
            INNER JOIN UsuarioTipo ut ON ( ut.UsuarioId  = u.idusuario )
            INNER JOIN tipousuario tu ON ( tu.codigotipousuario = ut.CodigoTipoUsuario )
            INNER JOIN usuariorol ur ON ( ur.idusuariotipo=ut.UsuarioTipoId )
            INNER JOIN rol r ON (r.idrol = ur.idrol)
                 WHERE u.usuario = ?";
        $persistencia->crearSentenciaSQL( $sql );
        
        $persistencia->setParametro( 0, $Usuario, true );
        //d($persistencia->getSQLListo( ));
        $persistencia->ejecutarConsulta( );
        if( $persistencia->getNext( ) ){
            $idUsuario = $persistencia->getParametro( "idusuario" );
            $idRol = $persistencia->getParametro( "idrol" );
            $idTipoUsuario = $persistencia->getParametro( "codigotipousuario" );
        }
        $persistencia->freeResult();
        
        $Permisos = new Permisos($persistencia);
        
        //validamos los permisos del usuario a nivel Usuario Especifico para el componente, idRelacionUsuario = 3
        $PermisoUsuario = $Permisos->getPermisos(3,$idUsuario, $idComponente, "componentes", $accion);
        //d($accion);
        if(empty($accion)){
            $countPerisos = $PermisoUsuario->getVer() + $PermisoUsuario->getEditar() + $PermisoUsuario->getInsertar() + $PermisoUsuario->getEliminar();
        }else{
            $countPerisos = $PermisoUsuario->{"get".ucfirst($accion)}();
        }
        //d($countPerisos);
        /*
         * Para validar los permisos heredados de rol el conteo de permisos del usuario especifico debe estar en 0 y el registro no debe existir en base de datos
         * motivo por el cual los permisos de ver, editar, insertar y eliminar NO deben ser numericos
        */
        if( empty($countPerisos) && !is_numeric($PermisoUsuario->getVer()) && !is_numeric($PermisoUsuario->getEditar()) && !is_numeric($PermisoUsuario->getInsertar()) && !is_numeric($PermisoUsuario->getEliminar()) ){
            if(!empty($idRol)){
                //validamos los permisos del usuario a nivel Rol para el componente, idRelacionUsuario = 2
                $PermisoRol = $Permisos->getPermisos(2,$idRol, $idComponente, "componentes", $accion);
                if(empty($accion)){
                    $countPerisos += $PermisoRol->getVer() + $PermisoRol->getEditar() + $PermisoRol->getInsertar() + $PermisoRol->getEliminar();
                }else{
                    $countPerisos += $PermisoRol->{"get".ucfirst($accion)}();
                }
            }
            /*
             * Para validar los permisos heredados deltipo de usuario el conteo de permisos del usuario especifico debe estar en 0 y el registro no debe existir en base de datos
             * motivo por el cual los permisos de ver, editar, insertar y eliminar NO deben ser numericos
            */
            if( empty($countPerisos) && !is_numeric($PermisoRol->getVer()) && !is_numeric($PermisoRol->getEditar()) && !is_numeric($PermisoRol->getInsertar()) && !is_numeric($PermisoRol->getEliminar()) ){
               if(!empty($idTipoUsuario)){
                    //validamos los permisos del usuario a nivel Tipo Usuario para el componente, idRelacionUsuario = 1
                    $PermisoTipoUsuario = $Permisos->getPermisos(1,$idTipoUsuario, $idComponente, "componentes", $accion);
                    if(empty($accion)){
                        $countPerisos += $PermisoTipoUsuario->getVer() + $PermisoTipoUsuario->getEditar() + $PermisoTipoUsuario->getInsertar() + $PermisoTipoUsuario->getEliminar();
                    }else{
                        $countPerisos += $PermisoTipoUsuario->{"get".ucfirst($accion)}();
                    }
                } 
            }
        }
        return !empty($countPerisos);
    }
    
    public static function validarPermisosComponenteRol($idRol, $idComponente, $accion=null){
         
        $persistencia = new Singleton( );
        $persistencia->conectar( );
        
        $Permisos = new Permisos($persistencia);
        
        //validamos los permisos del usuario como usuario especifico para el componente, idRelacionUsuario = 3
        $Permiso=$Permisos->getPermisos(2,$idRol, $idComponente, "componentes", $accion);
        $countPerisos = $Permiso->getVer() + $Permiso->getEditar() + $Permiso->getInsertar() + $Permiso->getEliminar();
        
        return !empty($countPerisos);
    }
    
    public static function validarPermisosComponenteTipoUsuario($idTipoUsuario, $idComponente, $accion=null){
         
        $persistencia = new Singleton( );
        $persistencia->conectar( ); 
        
        $Permisos = new Permisos($persistencia);
        
        //validamos los permisos del usuario como usuario especifico para el componente, idRelacionUsuario = 3
        $Permiso=$Permisos->getPermisos(2,$idTipoUsuario, $idComponente, "componentes", $accion);
        $countPerisos = $Permiso->getVer() + $Permiso->getEditar() + $Permiso->getInsertar() + $Permiso->getEliminar();
        
        return !empty($countPerisos);
    }
    
   
    
}
