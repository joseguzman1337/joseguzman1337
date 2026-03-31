<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Direccion de Tecnología Universidad el Bosque
	 * @package entidades
	 */
	//include ('../../../kint/Kint.class.php');
	require_once 'Proyecto.php';
	class PlanProgramaLinea{
		
		/**.
		 * @type int
		 * @access private
		 */
		private $idPlanProgramaLinea;
		
		/**
		 * @type PlanDesarrollo
		 * @access private
		 */
		private $planDesarrollo;
		
		/**
		 * @type LineaEstrategica
		 * @access private
		 */
		private $lineaEstrategica;
		
		/**
		 * @type Programa
		 * @access private
		 */
		private $programa;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoPlanProgramaLinea;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		
		 
		/*
	     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 * se agrega variables para capturar y retornar programas lineas estrategicas
		 * @since March  15, 2017*/ 
		
		
		private $mision;
		private $planeacion;
		private $tHumano;
		private $educacion;
		private $investigacion;
		private $responsabilidad;
		private $eEstudiantil;
		private $bUniversitario;
		private $internacionalizacion;
		private $porcentaje;
		private $proyecto;
		private $meta;
		
		//fin 		 
		 
		public function setMeta ( $meta ) {
			
			$this->meta = $meta;
		}
		
		public function getMeta ( ) {
			return $this->meta;
		}
		 
		 
		private $persistencia;
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */
		public function PlanProgramaLinea( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el id del Plan Programa Linea Estrategica
		 * @param int $idPlanProgramaLinea
		 * @access public
		 */
		public function setIdPlanProgramaLinea( $idPlanProgramaLinea ){
			$this->idPlanProgramaLinea = $idPlanProgramaLinea;
		}
		
		/**
		 * Retorna el id del Plan Programa Linea Estrategica
		 * @access public
		 * @return int
		 */
		public function getIdPlanProgramaLinea( ){
			return $this->idPlanProgramaLinea;
		}
		
		/**
		 * Modifica el identificador del Plan de Desarrollo
		 * @param $planDesarrollo PlanDesarrollo
		 * @access public
		 */
		public function setPlanDesarrollo( $planDesarrollo ){
			$this->planDesarrollo = $planDesarrollo;
		}
		
		/**
		 * Retorna el identificador del Plan de Desarrollo
		 * @access public
		 * @return PlanDesarrollo
		 */
		public function getPlanDesarrollo( ){
			return $this->planDesarrollo;
		}
		
		/**
		 * Modifica la linea estrategica del Plan Programa Linea Estrategica
		 * @param LineaEstrategica $lineaEstrategica
		 * @access public
		 */
		public function setLineaEstrategica( $lineaEstrategica ){
			$this->lineaEstrategica = $lineaEstrategica;
		}
		
		/**
		 * Retorna la linea estrategica del Plan Programa Linea Estrategica
		 * @access public
		 * @return LineaEstrategica
		 */
		public function getLineaEstrategica( ){
			return $this->lineaEstrategica;
		}
		
		
		/**
		 * Modifica el programa del Plan Programa Linea Estrategica
		 * @param Programa $programa
		 * @access public
		 */
		public function setPrograma( $programa ){
			$this->programa = $programa;
		}
		
		/**
		 * Retorna el programa del Plan Programa Linea Estrategica
		 * @access public
		 * @return Programa
		 */
		public function getPrograma( ){
			return $this->programa;
		}
		
		/**
		 * Modifica el estado del Plan Programa Linea Estrategica
		 * @param int $estadoPlanProgramaLinea
		 * @access public
		 */
		public function setEstadoPlanProgramaLinea( $estadoPlanProgramaLinea ){
			$this->estadoPlanProgramaLinea = $estadoPlanProgramaLinea;
		}
		
		/**
		 * Retorna el estado del Plan Programa Linea Estrategica
		 * @access public
		 * @return int
		 */
		public function getEstadoPlanProgramaLinea( ){
			return $this->estadoPlanProgramaLinea;
		}
		
		
		/*
			* @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 	* se agregan get y set para manipular programas del plan de desarrollo asociados a las lineas estrategicas
		* @since March  15, 2017*/
		
		
		public function setMision( $mision ){
			$this->mision = $mision;
		}
		
		public function getMision( ){
			return $this->mision;
		}
		
		public function setPlaneacion( $planeacion ){
			$this->planeacion = $planeacion;
		}
		
		public function getPlaneacion( ){
			return $this->planeacion;
		}
		
		public function setThumano( $tHumano){
			$this->tHumano = $tHumano;
		}
		
		public function getThumano( ){
			return $this->tHumano;
		}
		
		public function setEducacion( $educacion ){
			$this->educacion = $educacion;	
		}
		
		public function getEducacion( ){
			return $this->educacion;
		}
		
		public function setInvestigacion( $investigacion){
			$this->investigacion = $investigacion;
		}
		
		public function getInvestigacion( ){
			return $this->investigacion;
		}
		
		public function setResponsabilidad( $responsabilidad ){
			$this->responsabilidad = $responsabilidad;
		}
		
		public function getResponsabilidad( ){
			return $this->responsabilidad;
		}
		
		public function setEestudiantil( $eEstudiantil ){
			$this->eEstudiantil = $eEstudiantil;
		}
		
		public function getEestudiantil( ){
			return $this->eEstudiantil;
		}
		
		public function setBuniversitario( $bUniversitario ){
			$this->bUniversitario = $bUniversitario;
		}
		
		public function getBuniversitario( ){
			return $this->bUniversitario;
		}
		
		public function setInternacionalizacion( $internacionalizacion ){
			$this->internacionalizacion = $internacionalizacion;
		}
		
		public function getInternacionalizacion( ){
			return $this->internacionalizacion;
		}
		
		public function setPorcentaje ( $porcentaje ){
			$this->porcentaje = $porcentaje;
		}
		
		public function getPorcentaje ( ){
			return $this->porcentaje;
		}
		
		public function setProyecto ( $proyecto ){
			$this->proyecto = $proyecto;
		}
		
		public function getProyecto ( ) {
			return $this->proyecto;
		}
		//fin modificacion
		
		/**
		 * Crea un destinatario
		 */
		public function crearPlanProgramaLinea( $idPersona ) {
			$sql = "INSERT INTO PlanDesarrolloProgramaLineaEstrategica (
						PlanDesarrolloProgramaLineaEstrategicaId,
						PlanDesarrolloId,
						LineaEstrategicaId,
						ProgramaPlanDesarrolloId,
						EstadoPlanDesarrolloLineaEstrategica,
						FechaCreacion,
						FechaUltimaModificacion,
						UsuarioCreacion,
						UsuarioModificacion
					)
					VALUES
						(( SELECT IFNULL( MAX( PDPL.PlanDesarrolloProgramaLineaEstrategicaId ) +1, 1 ) 
							FROM PlanDesarrolloProgramaLineaEstrategica PDPL
							 ), ?, ?, ?, 100, NOW( ), NULL, ?, NULL);";
					  
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getPlanDesarrollo( )->getIdPlanDesarrollo( ) , false );
			$this->persistencia->setParametro( 1 , $this->getLineaEstrategica( )->getIdLineaEstrategica( ) , false );
			$this->persistencia->setParametro( 2 , $this->getPrograma( )->getIdProgramaPlanDesarrollo( ) , false );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		/**
		 * Actualizar la Linea Estrategica del Plan de Desarrollo Programa Linea
		 * @access public
		 */
		public function actualizarPlanProgramaLinea( $txtIdLineaEstrategica, $idPersona, $txtIdPrograma ){
			$sql = "UPDATE PlanDesarrolloProgramaLineaEstrategica
					SET 
					 LineaEstrategicaId = ?,
					 FechaUltimaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE
					ProgramaPlanDesarrolloId = ?;
					";	
				
			
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $txtIdLineaEstrategica , false );
			$this->persistencia->setParametro( 1 , $idPersona , false );
			$this->persistencia->setParametro( 2 , $txtIdPrograma , false );
			//echo $this->persistencia->getSQLListo( );
			$estado = $this->persistencia->ejecutarUpdate( );
			
			if( $estado )
				$this->persistencia->confirmarTransaccion( );
			else	
				$this->persistencia->cancelarTransaccion( );
						
			//$this->persistencia->freeResult( );
			return $estado;
			
			
		}
		
		
			/*
			* @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 	* se agrega consulta de lineas estrategicas dependiendo el plan de desarrollo
		 	* @since March  15, 2017*/
		 	 	
		public function consultarPlanesLineas( $idPlandesarrollo , $idLinea = null){
			$lineas=array();
			$where = "";
			
			if( $idLinea ) {
					
				$where.="and le.LineaEstrategicaId = ?";
			}else {
				$where.="";
			}
			
		
			
			$sql= "
				SELECT
					le.LineaEstrategicaId,
					sum(
						mipd.AvanceMetaPlanDesarrollo
					)acumulaAvance,
					sum(
						mipd.AlcanceMeta
					)acumulaValorMetas,
					(
						sum(
							mipd.AvanceMetaPlanDesarrollo
						) * 100 / sum(mipd.AlcanceMeta)
					) AS porcentaje
				FROM
					MetaIndicadorPlanDesarrollo mipd
				INNER JOIN ProyectoPlanDesarrollo ppd ON ppd.ProyectoPlanDesarrolloId = mipd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaPlanDesarrollo ppde ON ppde.ProgramaPlanDesarrolloId = pppd.ProgramaPlanDesarrolloId
				INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.ProgramaPlanDesarrolloId = ppde.ProgramaPlanDesarrolloId
				INNER JOIN LineaEstrategica le ON le.LineaEstrategicaId = pdple.LineaEstrategicaId
				INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
				WHERE
				pd.PlanDesarrolloId = ? ".$where." ";
			
				
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $idPlandesarrollo , false );
			
				if( $idLinea ){
					$this->persistencia->setParametro( 1 , $idLinea , false );
				}
				
			$this->persistencia->ejecutarConsulta(  );	
			
			while( $this->persistencia->getNext( ) ){
						
					$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
					$meta = new Meta( null );
					$meta->setAlcanceMeta($this->persistencia->getParametro("acumulaValorMetas"));
					$meta->setAvanceMetaPlanDesarrollo($this->persistencia->getParametro("acumulaAvance"));
					$planProgramaLinea->setMeta( $meta );
					$planProgramaLinea->setPorcentaje($this->persistencia->getParametro("porcentaje"));
				
					$lineas[] = $planProgramaLinea;
				}
				
				return $lineas;
		}
		// fin 
		
		/*
		 * Funcion para consultar las lineas estrategicas dependiendo la facultad
		 */
		
		public function verLineasEstrategica( $idFacultad, $codigoperiodo=null , $codigoCarrera = null , $idLinea = null ){
				
			$where = "";
			$linea = array();
			if( $codigoperiodo )
			{				
                        /*MOdified Diego Rivera <riveradiego@unbosque.edu.co>
                        *Se cambia parametro  de variable $where.=" AND mipd.VigenciaMeta LIKE '%?%'";
                        *se añade relacion talba metasecuntariaplandesarrollo    INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId
                        *Since September 21,2017
                        */
                            $where.=" AND mspd.FechaFinMetaSecundaria LIKE '%?%' and mspd.EstadoMetaSecundaria=100";
                        //	
			}
			else
			{
			   $where.= "";
			}
                        /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                        *Se añade parametro de linea estrategica
                        *Since may 08,2018
                        */
                        if( $idLinea )
			{				
                            $where.=" AND lne.LineaEstrategicaId = ?";
				
			}
			else
			{
				$where.= "";
			}
		
			$sql = "
			
			SELECT
				lne.LineaEstrategicaId,
				lne.NombreLineaEstrategica,
				(sum(mipd.AvanceMetaPlanDesarrollo) * 100 / sum(mipd.AlcanceMeta) ) as porcentaje
			FROM
				LineaEstrategica lne
			LEFT JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.LineaEstrategicaId = lne.LineaEstrategicaId
			LEFT JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
			LEFT JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
			LEFT JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
			LEFT JOIN ProyectoPlanDesarrollo propd ON propd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
			LEFT JOIN MetaIndicadorPlanDesarrollo mipd ON mipd.ProyectoPlanDesarrolloId = propd.ProyectoPlanDesarrolloId
			INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId
			WHERE
				pd.CodigoFacultad = ? and
                                pd.Codigocarrera = ? and 
                                ppd.EstadoProgramaPlanDesarrollo=100 and
                                pppd.EstadoProgramaProyecto=100 and
                                propd.EstadoProyectoPlanDesarrollo=100 and
                                mipd.EstadoMeta=100 
				".$where."
			GROUP BY
				lne.LineaEstrategicaId,lne.NombreLineaEstrategica";
			
				$this->persistencia->crearSentenciaSQL( $sql );
				$this->persistencia->setParametro( 0 , $idFacultad , true );
				$this->persistencia->setParametro( 1 , $codigoCarrera , false );
				
				if( $codigoperiodo and $idLinea ){
					$this->persistencia->setParametro( 2 , $codigoperiodo , false );
                                        $this->persistencia->setParametro( 3 , $idLinea , false );
                                   
				}else  if( $codigoperiodo and $idLinea == null){
                                   	$this->persistencia->setParametro( 2 , $codigoperiodo , false );
                                
                                }else if ( $idLinea ) {
                                    
                                    $this->persistencia->setParametro( 2 , $idLinea , false );
                                    
                                }
				
				$this->persistencia->ejecutarConsulta(  );	
				//echo $this->persistencia->getSQLListo( );
				while( $this->persistencia->getNext( ) ){
					$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
					$lineaEstrategica = new LineaEstrategica( null );
					$lineaEstrategica->setIdLineaEstrategica( $this->persistencia->getParametro( "LineaEstrategicaId" ) );
					$lineaEstrategica->setNombreLineaEstrategica( $this->persistencia->getParametro( "NombreLineaEstrategica" ) );
					$planProgramaLinea->setLineaEstrategica( $lineaEstrategica );
					$planProgramaLinea->setPorcentaje( $this->persistencia->getParametro( "porcentaje" ));
					$linea[] = $planProgramaLinea;
				}
			return $linea;
		}
		/*
		 * Funcion para consultar los programas asociados a las lineas estrategicas  y facultad
		 */
		public function verLineasPrograma( $idFacultad , $idLinea , $codigoCarrera = null  , $codigoperiodo = null){
			$where = "";
	
			$linea = array();
			if( $codigoperiodo )
			{				
				/*MOdified Diego Rivera <riveradiego@unbosque.edu.co>
				*Se cambia parametro  de variable $where.=" AND mipd.VigenciaMeta LIKE '%?%'";
				*se añade relacion talba metasecuntariaplandesarrollo    INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId
				*Since September 21,2017
				*/
				$where.=" AND mspd.FechaFinMetaSecundaria LIKE '%?%' and mspd.EstadoMetaSecundaria = 100 ";
				//	
			}
			else
			{
				$where.= "";
			}
			
			$sql = "
				SELECT
					ppd.ProgramaPlanDesarrolloId,
					ppd.NombrePrograma
				FROM
					LineaEstrategica lne
				INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.LineaEstrategicaId = lne.LineaEstrategicaId
				INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
				INNER JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
				INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
				INNER JOIN ProyectoPlanDesarrollo propd ON propd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
				INNER JOIN MetaIndicadorPlanDesarrollo mipd ON mipd.ProyectoPlanDesarrolloId = propd.ProyectoPlanDesarrolloId
				";
                                if( $codigoperiodo ){
                                 $sql.="INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId";  
                                }
                        $sql.=" WHERE
					pd.CodigoFacultad = ? and 
                                        lne.LineaEstrategicaId = ? and 
                                        pd.Codigocarrera= ?  and 
                                        ppd.EstadoProgramaPlanDesarrollo=100 and
                                        pdple.EstadoPlanDesarrolloLineaEstrategica = 100 and 
                                        ppd.EstadoProgramaPlanDesarrollo = 100 and 
                                        pppd.EstadoProgramaProyecto = 100 and 
                                        propd.EstadoProyectoPlanDesarrollo = 100 
					".$where."
				GROUP BY
				ppd.ProgramaPlanDesarrolloId";
			
				$this->persistencia->crearSentenciaSQL( $sql );
				$this->persistencia->setParametro( 0 , $idFacultad , true );
				$this->persistencia->setParametro( 1 , $idLinea , false );
				$this->persistencia->setParametro( 2 , $codigoCarrera , false );
				if($codigoperiodo){
					$this->persistencia->setParametro( 3 , $codigoperiodo , false );
				}
				
				$this->persistencia->ejecutarConsulta(  );	
				//echo $this->persistencia->getSQLListo( );
				while( $this->persistencia->getNext( ) ){
				
					$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
					$programa = new Programa( null );
					$programa->setIdProgramaPlanDesarrollo($this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ));
					$programa->setNombrePrograma($this->persistencia->getParametro( "NombrePrograma" ));
				
					$planProgramaLinea->setPrograma( $programa );
					$linea[] = $planProgramaLinea;
				}
				return $linea;
		}
		
		/*
		 * Funcion para consultar los proyectos de los programas dependiendo la linea estrategica y la facultad
		 */	
		public function verLineasProyecto( $idFacultad , $idLinea , $idPrograma , $codigoCarrera , $codigoperiodo ){
	
			$where = "";
			$adicionSecundaria="";
                        $parametros = array();
			$linea = array();

			if( $codigoperiodo )
			{				
				/*MOdified Diego Rivera <riveradiego@unbosque.edu.co>
				*Se cambia parametro  de variable $where.=" AND mipd.VigenciaMeta LIKE '%?%'";
				*se añade relacion talba metasecuntariaplandesarrollo    INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId
				*Since September 21,2017
				*/
                                $adicionSecundaria.= "	
                                ( SELECT
                                count( * ) 
                                FROM
                                        MetaSecundariaPlanDesarrollo mspd
                                        INNER JOIN MetaIndicadorPlanDesarrollo met ON ( mspd.MetaIndicadorPlanDesarrolloId = met.MetaIndicadorPlanDesarrolloId ) 
                                WHERE
                                        met.ProyectoPlanDesarrolloId = propd.ProyectoPlanDesarrolloId 
                                        AND met.EstadoMeta = 100 
                                        AND mspd.FechaFinMetaSecundaria LIKE '%?%' 
                                        AND mspd.EstadoMetaSecundaria = 100 
                                        ) AS porcentaje";
                                          
				$where.=" AND mspd.FechaFinMetaSecundaria LIKE '%?%' and mspd.EstadoMetaSecundaria=100";
				//	
			}
			else
			{       
                                  $adicionSecundaria.= "(select count(*) from MetaIndicadorPlanDesarrollo met where met.ProyectoPlanDesarrolloId=propd.ProyectoPlanDesarrolloId and met.EstadoMeta = 100) as porcentaje
				";	
				$where.= "";
			}

			
			$sql = "
				SELECT
					propd.ProyectoPlanDesarrolloId,
					propd.NombreProyectoPlanDesarrollo,";
                        $sql.=$adicionSecundaria."  
					FROM
					LineaEstrategica lne
                                    INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.LineaEstrategicaId = lne.LineaEstrategicaId
                                    INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
                                    INNER JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
                                    INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                                    INNER JOIN ProyectoPlanDesarrollo propd ON propd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
                                    INNER JOIN MetaIndicadorPlanDesarrollo mipd ON mipd.ProyectoPlanDesarrolloId = propd.ProyectoPlanDesarrolloId
                                    ";
                                    if( $codigoperiodo ){
                                        $sql.="INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId
                                    ";
                                    }
                                   $sql.= "WHERE
                                            ppd.ProgramaPlanDesarrolloId= ?   and  
                                            propd.EstadoProyectoPlanDesarrollo=100 and
                                            pdple.EstadoPlanDesarrolloLineaEstrategica = 100 and 
                                            ppd.EstadoProgramaPlanDesarrollo = 100 and
                                            pppd.EstadoProgramaProyecto = 100 and
                                            mipd.EstadoMeta = 100 
                                            ".$where."
                                    GROUP BY
						propd.ProyectoPlanDesarrolloId
				
				";
			
				$this->persistencia->crearSentenciaSQL( $sql );
				
				if( $codigoperiodo ){
                                        $this->persistencia->setParametro( 0 , $codigoperiodo , false );
					$this->persistencia->setParametro( 1, $idPrograma , false );
                                        $this->persistencia->setParametro( 2, $codigoperiodo , false );
                                }else {
                                    	$this->persistencia->setParametro( 0, $idPrograma , false );
                                }

				
				$this->persistencia->ejecutarConsulta(  );	
				//echo $this->persistencia->getSQLListo( ).'<br><br>';
				while( $this->persistencia->getNext( ) ){
				
					$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
					$proyecto = new Proyecto( null );
					$proyecto->setProyectoPlanDesarrolloId($this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ));
					$proyecto->setNombreProyectoPlanDesarrollo($this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" ));
					$planProgramaLinea->setPorcentaje($this->persistencia->getParametro( "porcentaje" ));
					$planProgramaLinea->setProyecto( $proyecto );
					$linea[] = $planProgramaLinea;
				}
				return $linea;
		}
			
			
	
}
?>