<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Entidades
 */
class UsuarioFacultad extends Persona{
	/**
	 * @type String
	 * @access private
	 */	
	 
	private $usuario;
	/**
	 * @type String
	 * @access private
	 */	
	 
	private $emailUsuarioFacultad;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	 
	private $persistencia;
		/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	 
	public function UsuarioFacultad( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica Usuario
	 * @param String  usuario 
	 * @access public
	 */

	public function setUsuario( $usuario ) {
		
		$this->usuario = $usuario;
	}
	
	/**
	 * Retorna el usuario 
	 * @access public
	 * @return String
	 */
	public function getUsuario( ) {
			
		return $this->usuario;
	}
	
	
	/**
	 * Modifica EmailUsuarioFacultad
	 * @param String  EmailUsuarioFacultad
	 * @access public
	 */
	public function setEmailUsuarioFacultad( $emailUsuarioFacultad ) {
			
		$this->emailUsuarioFacultad = $emailUsuarioFacultad;
	}
	
	/**
	 * Retorna EmailUsuarioFacultad
	 * @access public
	 * @return String
	 */
	public function getEmailUsuarioFacultad( ) {
		
		return $this->emailUsuarioFacultad;
	}
	
	/**
	 * consulta nombre y email de funcionarios activos
	 * @access public
	 */
	
	public function buscarEmail ( $email ){
			
		$emailUsuarioFacultad = array( );
		
		
		$sql = "
			SELECT
				uf.emailusuariofacultad,
				u.nombres, 
				u.apellidos
			FROM
				usuariofacultad uf
			INNER JOIN usuario u ON (uf.usuario = u.usuario)
			WHERE
				uf.codigoestado = 100
				AND u.codigoestadousuario = 100
				AND uf.emailusuariofacultad <> ''
				and  uf.emailusuariofacultad like '%?%'
			GROUP BY
				uf.usuario";
				
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $email , false );
			$this->persistencia->ejecutarConsulta( );
			
			while( $this->persistencia->getNext( ) ){
					$usuarioFacultad = new UsuarioFacultad( $this->persistencia );
					$usuarioFacultad->setEmailUsuarioFacultad( $this->persistencia->getParametro( 'emailusuariofacultad' ) );
					$usuarioFacultad->setNombres($this->persistencia->getParametro( 'nombres' ) );
					$usuarioFacultad->setApellidos($this->persistencia->getParametro( 'apellidos' ) );
					
					$emailUsuarioFacultad[] = $usuarioFacultad;
				
			}		
			
			return $emailUsuarioFacultad;
	}
	
	
	
	public function buscarNombre ( $nombre ){
			
		$nombreUsuarioFacultad = array( );
		
		
		$sql = "
                        SELECT
                                * 
                        FROM
                                (
                        SELECT
                                u.nombres,
                                u.apellidos,
                                uf.emailusuariofacultad 
                        FROM
                                usuariofacultad uf
                                INNER JOIN usuario u ON ( uf.usuario = u.usuario ) 
                        WHERE
                                uf.codigoestado = 100 
                                AND u.codigoestadousuario = 100 
                                AND uf.emailusuariofacultad <> '' 
                                AND CONCAT_WS( ' ', u.nombres, u.apellidos ) LIKE '%?%' 
                        GROUP BY
                                uf.usuario 
                        UNION
                        SELECT
                                ppd.ResponsableProgramaPlanDesarrollo AS nombres,
                                '' AS apellidos,
                                ppd.EmailResponsableProgramaPlanDesarrollo AS emailusuariofacultad 
                        FROM
                                ProgramaPlanDesarrollo ppd 
                        WHERE
                                ppd.ResponsableProgramaPlanDesarrollo <> '' 
                                AND ppd.ResponsableProgramaPlanDesarrollo LIKE '%?%'
                        UNION
                        SELECT
                                prpd.ResponsableProyecto AS nombres,
                                '' AS apellidos,
                                prpd.EmailResponsableProyecto AS emailusuariofacultad 
                        FROM
                                ProyectoPlanDesarrollo prpd 
                        WHERE
                                prpd.ResponsableProyecto <> '' 
                                AND prpd.ResponsableProyecto LIKE '%?%'
                        UNION
                        SELECT
                                mspd.ResponsableMetaSecundaria AS nombres,
                                '' AS apellidos,
                                mspd.EmailResponsableMetaSecundaria AS emailusuariofacultad 
                        FROM
                                MetaSecundariaPlanDesarrollo mspd 
                        WHERE
                                mspd.ResponsableMetaSecundaria <> ''
                                AND mspd.ResponsableMetaSecundaria LIKE '%?%'
                                ) AS T1 
                        GROUP BY
                                nombres
                        ";

			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $nombre , false );
                        $this->persistencia->setParametro( 1 , $nombre , false );
                        $this->persistencia->setParametro( 2 , $nombre , false );
                        $this->persistencia->setParametro( 3 , $nombre , false );
			$this->persistencia->ejecutarConsulta( );
			
			while( $this->persistencia->getNext( ) ){
					$usuarioFacultad = new UsuarioFacultad( $this->persistencia );
					$usuarioFacultad->setEmailUsuarioFacultad( $this->persistencia->getParametro( 'emailusuariofacultad' ) );
					$usuarioFacultad->setNombres($this->persistencia->getParametro( 'nombres' ) );
					$usuarioFacultad->setApellidos($this->persistencia->getParametro( 'apellidos' ) );
					
					$nombreUsuarioFacultad[] = $usuarioFacultad;
				
			}		
			
			return $nombreUsuarioFacultad;
	}
	
	
	
}



?>