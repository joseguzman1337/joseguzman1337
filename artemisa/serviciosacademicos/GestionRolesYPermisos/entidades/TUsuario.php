<?php
/**
 * Clase encargada de modelo de la tabla RelacionUsuario
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 06, 2017
*/
//echo getcwd();

require_once("../../assets/lib/Usuario.php");

class TUsuario extends Usuario{
	
	/**
	 * $type int
	 * @access private
	 */
	private $relacionUsuario;
        
	/**
	 * $type String
	 * @access private
	 */
	private $nombreRelacionUsuario;
	
	/**
	 * Modifica el id de la Relacion Usuario
	 * @access public
	 * @return void
	 */ 
	public function setRelacionUsuario($relacionUsuario){
		$this->relacionUsuario = $relacionUsuario;
	}
	
	/**
	 * Retorna el id de la Relacion Usuario
	 * @param int $id
	 * @access public
	 * @return int
  	 */
	public function getRelacionUsuario(){
		return $this->relacionUsuario;
	}
	
	/**
	 * Modifica el nombre de la Relacion Usuario
	 * @access public
	 * @return void
	 */ 
	public function setNombreRelacionUsuario($nombreRelacionUsuario){
		$this->nombreRelacionUsuario = $nombreRelacionUsuario;
	}
	
	/**
	 * Retorna el nombre de la Relacion Usuario 
	 * @access public
	 * @return string
  	 */
	public function getNombreRelacionUsuario(){
		return $this->nombreRelacionUsuario;
	}
	
	public function TUsuario($persistencia){
		$this->persistencia = $persistencia;
	}
	
	public function getUsuarioList($relacionUsuario, $usuario = null){
                if( $usuario == -1){
                    $usuario = null;
                } 
		$page = (empty($_REQUEST['page'])?1:$_REQUEST['page']);
		$usuarios = array();
                
                $where = array();
		$params = array(); 
		switch($relacionUsuario){
			case '1':{// Tipo Usuario debe consultar la taba tipos de usuario
				$sql = "     SELECT tu.codigotipousuario id , tu.nombretipousuario nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM tipousuario tu "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 1)"
                                      ."      WHERE tu.codigoestado = 100"
                                      ."        AND tu.codigotipousuario > 100";
                                
                                if(  !empty($usuario) || (is_numeric($usuario) && $usuario==0) ){
                                        $where[] = 'tu.codigotipousuario = ?'; 
                                }
			}break;
			case '2':{// Tipo Rol debe consultar la tabla roles
				$sql = "     SELECT r.idrol id, r.nombrerol nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM rol r "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 2)"
                                      ."      WHERE r.codigoestadorol=100";
                                
                                if( !empty($usuario) || (is_numeric($usuario) && $usuario==0) ){ 
                                        $where[] = ' idrol = ? '; 
                                }
			}break;
			case '3':{// Usuario específico debe consultar la tabla usuario
				$sql = "     SELECT u.idusuario id, u.usuario nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM usuario u "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 3)"
                                      ."      WHERE codigoestadousuario=100";
                                
                                if(  !empty($usuario) || (is_numeric($usuario) && $usuario==0) ){
                                        $where[] = ' idusuario = ? '; 
                                }
			}break;
			default:{
				$sql = "SELECT * FROM ("
                                      ."     SELECT tu.codigotipousuario id , tu.nombretipousuario nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM tipousuario tu "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 1)"
                                      ."      WHERE tu.codigoestado = 100"
                                      ."        AND tu.codigotipousuario > 100"
                                      ."	 UNION "
                                      ."     SELECT r.idrol id, r.nombrerol nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM rol r "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 2)"
                                      ."      WHERE r.codigoestadorol=100"
                                      ."	 UNION "
                                      ."     SELECT u.idusuario id, u.usuario nombre, "
                                      ."            ru.id relacionUsuario, ru.nombre nombreRelacionUsuario "
                                      ."       FROM usuario u "
                                      ." INNER JOIN RelacionUsuario ru ON (ru.id = 3)"
                                      ."      WHERE codigoestadousuario=100"
                                      . ") d";
			}break;
		}
                
                if(  ( !empty($usuario) || ($usuario==0) ) && !empty($relacionUsuario)  ){ 
                        $objParam = new stdClass();
                        $objParam->value = $usuario;
                        $objParam->text = false;
                        $params[0] = $objParam; 
                        unset($objParam);
                }

                //d($sql);
				
                if(!empty($where)){
                        $sql .= ' 
                             AND '.implode(' AND ',$where);
                } 
		$this->persistencia->crearSentenciaSQL( $sql );
		//$this->persistencia->setParametro( 0 , $relacionUsuario , false );
                	
                if(!empty($params)){
                    foreach($params as $k=>$v){
                        $this->persistencia->setParametro( $k, $v->value, $v->text );
                    }
                }
		
		//d($this->persistencia->getSQLListo( ));
		$this->persistencia->ejecutarConsulta( );
		if(($_GET["option"]!="recargarUsuario")){
                    $totalRows = $this->persistencia->getTotalRows();

                    $this->persistencia->paginarResultados($page, $totalRows);
                    //d($this->persistencia->getSQLListo(TRUE));
                }
		
		while( $this->persistencia->getNext( ) ){
			//d($this->persistencia->getParametro( "nombre" ));
			$usuario = new TUsuario(null);
			$usuario->setIduser($this->persistencia->getParametro( "id" ));
			$usuario->setUser($this->persistencia->getParametro( "nombre" ));
			$usuario->setRelacionUsuario($this->persistencia->getParametro( "relacionUsuario" ));
			$usuario->setNombreRelacionUsuario($this->persistencia->getParametro( "nombreRelacionUsuario" ));
			$usuarios[] = $usuario;
		}
		return $usuarios;
	}
}
?>
