<?php

/**
 * Clase encargada de modelo de la tabla RelacionUsuario
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since marzo 13, 2017
*/

require_once("../../assets/lib/Permisos.php");
class Permiso  extends Permisos{ 
    
    public function actualizaPermisos($variables){
        //d($this->persistencia);
        $permiso =  $this->getPermisos($variables->relacionUsuario, $variables->idUsuario, $variables->idComponent, $variables->tipoPermiso, $variables->action);
        $idPermiso = $permiso->getId();
        if(empty( $idPermiso )){
            $return = $this->insert($variables->relacionUsuario, $variables->idUsuario, $variables->idComponent, $variables->tipoPermiso, $variables->action);
            //se registra en el log la accion
            $this->setLog($variables->idUsuario, "Insertar", $variables->action ,$this->persistencia->getSQLListo( ), $variables->idComponent);
        }else{
            $return = $this->update($permiso->getId(), $variables->relacionUsuario, $variables->idUsuario, $variables->idComponent, $variables->tipoPermiso, $variables->action);
            //se registra en el log la accion
            $this->setLog($variables->idUsuario, "Update", $variables->action ,$this->persistencia->getSQLListo( ), $variables->idComponent);
        }
        return $return;
    }
    
    public function habilitarPermisosParaUsuario($variables){
        //d($this->persistencia);
        $permiso =  $this->getPermisos($variables->relacionUsuario, $variables->idUsuario, $variables->idComponent, $variables->tipoPermiso );
        
        $idPermiso = $permiso->getId();
        if(empty( $idPermiso )){
            $return = $this->insert($variables->relacionUsuario, $variables->idUsuario, $variables->idComponent, $variables->tipoPermiso, "ver");
            //se registra en el log la accion
            $this->setLog($variables->idUsuario, "Habilitar permisos","ver",$this->persistencia->getSQLListo( ), $variables->idComponent);
        }else{
            $return = $this->delete($permiso->getId());
            //se registra en el log la accion
            $this->setLog($variables->idUsuario, "Inhabilitar permisos","Todos",$this->persistencia->getSQLListo( ), $variables->idComponent);
        }/**/
        return $return;
    }
    
    public function insert($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action){
        $idTipoPermiso = 0;
        
        $sql = " SELECT id FROM TipoPermiso WHERE nombre = ?"; 
        
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $tipoPermiso , true );
        //d($this->persistencia->getSQLListo( ));
        $this->persistencia->ejecutarConsulta( );
        
        if( $this->persistencia->getNext( ) ){
            $idTipoPermiso = $this->persistencia->getParametro( "id" );
        }
        
        
        $sql = " INSERT INTO Permiso
                        SET idRelacionUsuario = ?,
                            idUsuario = ?,
                            idComponenteModulo = ?,
                            idTipoPermiso = ?,
                            ".$action." = ?";
        
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $relacionUsuario , false );
        $this->persistencia->setParametro( 1 , $idUsuario , false );
        $this->persistencia->setParametro( 2 , $idComponent , false );
        $this->persistencia->setParametro( 3 , $idTipoPermiso , false );
        $this->persistencia->setParametro( 4 , 1 , false );
        
        //ddd($this->persistencia->getSQLListo( ));
        return $this->persistencia->ejecutarUpdate();
    }
    public function update($id, $relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action){
        $idTipoPermiso = 0;
        
        $sql = " SELECT id FROM TipoPermiso WHERE nombre = ?"; 
        
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $tipoPermiso , true );
        //d($this->persistencia->getSQLListo( ));
        $this->persistencia->ejecutarConsulta( );
        
        if( $this->persistencia->getNext( ) ){
            $idTipoPermiso = $this->persistencia->getParametro( "id" );
        }
        $this->persistencia->freeResult();
        
        //consulto el valor actual que tiene la accion que se trata de editar
        $sql = " SELECT $action FROM Permiso WHERE id = ?";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $id , false );
        //d($this->persistencia->getSQLListo( ));
        $this->persistencia->ejecutarConsulta( );
        
        $nuevaAccion = 0;
        if( $this->persistencia->getNext( ) ){
            $nuevaAccion = $this->persistencia->getParametro( $action );
        }
        $nuevaAccion = ($nuevaAccion==1)?0:1;
        //d($nuevaAccion);
        $this->persistencia->freeResult();
        
        $sql = " UPDATE Permiso
                   SET ".$action." = ? 
                 WHERE id = ?";
        
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $nuevaAccion , false );
        $this->persistencia->setParametro( 1 , $id , false );
        /*$this->persistencia->setParametro( 0 , $relacionUsuario , false );
        $this->persistencia->setParametro( 1 , $idUsuario , false );
        $this->persistencia->setParametro( 2 , $idComponent , false );
        $this->persistencia->setParametro( 3 , $idTipoPermiso , false );
        $this->persistencia->setParametro( 4 , 1 , false );/**/
        
        //ddd($this->persistencia->getSQLListo( ));
        return $this->persistencia->ejecutarUpdate();
        
    }
    public function delete($id ){
         
        
        $sql = " DELETE FROM Permiso 
                 WHERE id = ?";
        
        $this->persistencia->crearSentenciaSQL( $sql ); 
        $this->persistencia->setParametro( 0 , $id , false );
        /*$this->persistencia->setParametro( 0 , $relacionUsuario , false );
        $this->persistencia->setParametro( 1 , $idUsuario , false );
        $this->persistencia->setParametro( 2 , $idComponent , false );
        $this->persistencia->setParametro( 3 , $idTipoPermiso , false );
        $this->persistencia->setParametro( 4 , 1 , false );/**/
        
        //ddd($this->persistencia->getSQLListo( ));
        return $this->persistencia->ejecutarUpdate();
        
    }
    
    public function setLog($idUsuarioModificado, $accion, $permiso, $sqlIngresado, $idComponente){
        $sqlIngresado = preg_replace( "/\r|\n|\s+/", " ", $sqlIngresado );
        $sql = "SELECT u.idusuario 
                  FROM usuario u 
                 WHERE u.usuario = ?";
        $this->persistencia->crearSentenciaSQL( $sql ); 
        $this->persistencia->setParametro( 0 , $_SESSION['MM_Username'] , true );
        //d($this->persistencia->getSQLListo( ));
        $this->persistencia->ejecutarConsulta( );
        if( $this->persistencia->getNext( ) ){
            $idUsuario = $this->persistencia->getParametro( "idusuario" ); 
        }
        
        $sql = " INSERT INTO LogCambioPermisos 
                         SET idUsuarioCreador = ? ,
                             idUsuarioModificado = ? ,
                             ip = ? ,
                             accion = ? ,
                             permiso = ? ,
                             `sql` = ? ,
                             idComponente = ? ,
                             fechacreacion = NOW()";
        $this->persistencia->crearSentenciaSQL( $sql ); 
        $this->persistencia->setParametro( 0 , $idUsuario , false );
        $this->persistencia->setParametro( 1 , $idUsuarioModificado , false );
        $this->persistencia->setParametro( 2 , $this->getUserIP() , true );
        $this->persistencia->setParametro( 3 , $accion , true );
        $this->persistencia->setParametro( 4 , $permiso , true );
        $this->persistencia->setParametro( 5 , addslashes($sqlIngresado) , true );
        $this->persistencia->setParametro( 6 , $idComponente , false );
        //d($this->persistencia->getSQLListo( ));
        return $this->persistencia->ejecutarUpdate();
        
    }
    // Function to get the user IP address
    function getUserIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
}

?>
