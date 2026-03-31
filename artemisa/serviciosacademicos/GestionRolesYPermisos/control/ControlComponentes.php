<?php
/**
 * Clase encargada del control para la sección Permisos sobre componente
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 06, 2017
*/
//if (defined('ROOT')) {
    //require_once(ROOT+"/entidades/RelacionUsuario.php");
///}else{
	require_once("entidades/RelacionUsuario.php");
	require_once("entidades/TUsuario.php");
	require_once("entidades/Componente.php");
        require_once("entidades/Permiso.php");
//}
class ControlComponentes{
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
	public function ControlComponentes( $persistencia ){ 
		$this->persistencia = $persistencia;
		//d("hola1"); 
	}
	
	public function getRelacionUsuarioList(){ 
		$RelacionUsuario = new RelacionUsuario($this->persistencia);
		return $RelacionUsuario->getRelacionUsuarioList();
	}
	
	public function getUsuariosOptionList($relacionUsuario){ 
		$Usuario = new TUsuario($this->persistencia);
		//d($Usuario );
		$usuarioList = $Usuario->getUsuarioList($relacionUsuario); 
                //d($usuarioList);
		$options = "<select name='Usuario' id='Usuario' class='chosen-select' ><option value='-1'>Seleccionar</option>";
		foreach($usuarioList as $ul){
			//d($ul->getIduser());
			$options .= "<option value='".$ul->getIduser()."'>".$ul->getUser()."</option>";
		}
		$options .= "</select>";
		return $options;
	}
	
	public function getUsuariosTabla($relacionUsuario, $usuario=null, $idComponente=null){
		$Usuario = new TUsuario($this->persistencia);
		//d($Usuario );
		$usuarioList = $Usuario->getUsuarioList($relacionUsuario, $usuario);
		
		$componente = new Componente($this->persistencia);
		$componenteList = $componente->getComponenteList($idComponente);
		
		$arrayDatos = array();
		foreach($usuarioList as $ul){
			foreach($componenteList as $cp){
				$obj = new stdClass();
                                $obj->user = $ul;
				/*$obj->iduser = $ul->getIduser();
				$obj->user = $ul->getUser();/**/
				$obj->idComponent = $cp->__get("idmenuopcion");
				$obj->nombreMenuOpcion = $cp->__get("nombremenuopcion");
				$obj->idPadreMenuOpcion = $cp->__get("idpadremenuopcion");
				$arrayDatos[] = $obj;
			}
		}
		//d($arrayDatos);
		return $arrayDatos;
	}
        
        public function checkPermisos($relacionUsuario=null, $idUsuario=null, $idComponent=null, $tipoPermiso=null, $action=null){
            if($tipoPermiso=="recargarTablaComponentes"){
                $tipoPermiso="componentes";
            }
            $Permiso = new Permiso($this->persistencia);
            $return='';
            $class='';
            $permisoAccion = $Permiso->checkPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action);
            if(!empty($permisoAccion)){
                $return .= ' 
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-check fa-stack-1x"></i>
                    </span>  ';
            }else{
                $return .= ' 
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                    </span>  ';
                $class = "text-danger";
            }
            if(is_numeric($permisoAccion)){ 
                $return='<a class="accion '.$class.'" href="#" data-relacionUsuario="'.$relacionUsuario.'"  data-idUsuario="'.$idUsuario.'" 
                        data-idComponent="'.$idComponent.'"  data-tipoPermiso="'.$tipoPermiso.'" data-action="'.$action.'" >'.$return.'</a>';
            }
            
            return $return;
        }
        
        public function habilitarPermisos($relacionUsuario=null, $idUsuario=null, $idComponent=null, $tipoPermiso=null ){
            if($tipoPermiso=="recargarTablaComponentes"){
                $tipoPermiso="componentes";
            }
            $Permiso = new Permiso($this->persistencia);
            $return='';
            $class='';
            $permisoAccion = $Permiso->checkPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso );
            $countPermisos = is_numeric($permisoAccion->getVer()) && is_numeric($permisoAccion->getEditar()) && is_numeric($permisoAccion->getInsertar()) && is_numeric($permisoAccion->getEliminar());
            //ddd($countPermisos);
            if($countPermisos){
                $return .= ' 
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-check fa-stack-1x"></i>
                    </span>  ';
            }else{
                $return .= ' 
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                    </span>  ';
                $class = "text-danger";
            }
            
            $return='<a class="habilitarPermisos '.$class.'" href="#" data-relacionUsuario="'.$relacionUsuario.'"  data-idUsuario="'.$idUsuario.'" 
                    data-idComponent="'.$idComponent.'"  data-tipoPermiso="'.$tipoPermiso.'" >'.$return.'</a>';
                        
            return $return;/**/
        }
        
        public function actualizaPermisos ($variables = null){
            $Permiso = new Permiso($this->persistencia);
            //d($Permiso);
            return $Permiso->actualizaPermisos($variables);
        }
        
        public function habilitarPermisosParaUsuario ($variables = null){
            $Permiso = new Permiso($this->persistencia);
            //ddd($Permiso);
            return $Permiso->habilitarPermisosParaUsuario($variables);
        }
        
        public function getComponenteList($idComponente=null){
            $componente = new Componente($this->persistencia);
            $componenteList = $componente->getComponenteList($idComponente);
            return $componenteList;
        }
}
?>