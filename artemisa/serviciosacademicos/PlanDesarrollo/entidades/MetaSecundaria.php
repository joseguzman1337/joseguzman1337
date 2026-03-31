<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 15, 2016
	*/
	//include ('../../../kint/Kint.class.php');

    class MetaSecundaria{

             /**
             * @type int
             * @access private
             */
            private $metaSecundariaPlanDesarrolloId;

             /**
             * @type int
             * @access private
             */
            private $meta;

             /**
             * @type String
             * @access private
             */
            private $nombreMetaSecundaria;

             /**
             * @type datetime
             * @access private
             */
            private $fechaInicioMetaSecundaria;

             /**
             * @type datetime
             * @access private
             */
            private $fechaFinMetaSecundaria;

             /**
             * @type int
             * @access private
             */
            private $valorMetaSecundaria;

             /**
             * @type int
             * @access private
             */
            private $avanceResponsableMetaSecundaria;

             /**
             * @type int
             * @access private
             */
            private $avanceSupervisorMetaSecundaria;

             /**
             * @type String
             * @access private
             */
            private $responsableMetaSecundaria;

            /**
             * @type int
             * @access private
             */
            private $estadoMetaSecundaria;


            //////////////////////////////////////////////////////////////////
             /**
             * @type datetime
             * @access private
             */
            private $fechaCreacion;

             /**
             * @type datetime
             * @access private
             */
            private $fechaUltimaModificacion;

            /**
             * @type String
             * @access private
             */
            private $actividadMetaSecundaria;

             /**
             * @type int
             * @access private
             */
            private $usuarioCreacion;

             /**
             * @type string
             * @access private
             */
            private $usuarioModificacion;

            /**
             * @type Singleton
             * @access private
             */
            private $persistencia;

            /**
             * @type string
             * @access private
             */
            private $emailResponsableMetaSecundaria;

            /**
             * Constructor
             * @param Singleton $persistencia
             */
            public function MetaSecundaria( $persistencia ){ 
                    $this->persistencia = $persistencia;
            }


            /**
             * Modifica el id de la Meta
             * @param int $metaSecundariaPlanDesarrolloId
             * @access public
             * @return void
             */
            public function setMetaSecundariaPlanDesarrolloId( $metaSecundariaPlanDesarrolloId ){
                    $this->metaSecundariaPlanDesarrolloId = $metaSecundariaPlanDesarrolloId;
            }

            /**
             * Retorna el id de la Meta
             * @access public
             * @return int
             */
            public function getMetaSecundariaPlanDesarrolloId( ){
                    return $this->metaSecundariaPlanDesarrolloId;
            }

            /**
             * Modifica el metaIndicadorPlanDesarrolloId de la Meta
             * @param int $metaIndicadorPlanDesarrolloId
             * @access public
             * @return void
             */
            public function setMeta( $meta ){
                    $this->meta = $meta;
            }

            /**
             * Retorna el metaIndicadorPlanDesarrolloId de la Meta
             * @access public
             * @return int
             */
            public function getMeta( ){
                    return $this->meta;
            }

            /**
             * Modifica el nombre de la Meta
             * @param String $nombreMetaSecundaria
             * @access public
             * @return void
             */
            public function setNombreMetaSecundaria( $nombreMetaSecundaria ){
                    $this->nombreMetaSecundaria = $nombreMetaSecundaria;
            }

            /**
             * Retorna el nombre de la Meta
             * @access public
             * @return String
             */
            public function getNombreMetaSecundaria( ){
                    return $this->nombreMetaSecundaria;
            }

            /**
             * Modifica la fecha inicio de la Meta
             * @param datetime $fechaInicioMetaSecundaria
             * @access public
             * @return void
             */
            public function setFechaInicioMetaSecundaria( $fechaInicioMetaSecundaria ){
                    $this->fechaInicioMetaSecundaria = $fechaInicioMetaSecundaria;
            }

            /**
             * Retorna la fecha inicio de la Meta
             * @access public
             * @return datetime
             */
            public function getFechaInicioMetaSecundaria( ){
                    return $this->fechaInicioMetaSecundaria;
            }

            /**
             * Modifica fecha fin de la Meta
             * @param datetime $fechaFinMetaSecundaria
             * @access public
             * @return void
             */
            public function setFechaFinMetaSecundaria( $fechaFinMetaSecundaria ){
                    $this->fechaFinMetaSecundaria = $fechaFinMetaSecundaria;
            }

            /**
             * Retorna la fecha fin  de la Meta
             * @access public
             * @return datetime
             */
            public function getFechaFinMetaSecundaria( ){
                    return $this->fechaFinMetaSecundaria;
            }

            /**
             * Modifica el valor de la Meta
             * @param int $valorMetaSecundaria
             * @access public
             * @return void
             */
            public function setValorMetaSecundaria( $valorMetaSecundaria ){
                    $this->valorMetaSecundaria = $valorMetaSecundaria;
            }

            /**
             * Retorna el valor de la Meta
             * @access public
             * @return int
             */
            public function getValorMetaSecundaria( ){
                    return $this->valorMetaSecundaria;
            }

            /**
             * Modifica la actividad de la Meta Secundaria
             * @param String $actividadMetaSecundaria
             * @access public
             * @return void
             */
            public function setActividadMetaSecundaria( $actividadMetaSecundaria ){
                    $this->actividadMetaSecundaria = $actividadMetaSecundaria;
            }

            /**
             * Retorna la actividad de la Meta Secundaria
             * @access public
             * @return String
             */
            public function getActividadMetaSecundaria( ){
                    return $this->actividadMetaSecundaria;
            }

            /**
             * Modifica el avance del responsable de la Meta
             * @param int $avanceResponsableMetaSecundaria
             * @access public
             * @return void
             */
            public function setAvanceResponsableMetaSecundaria( $avanceResponsableMetaSecundaria ){
                    $this->avanceResponsableMetaSecundaria = $avanceResponsableMetaSecundaria;
            }

            /**
             * Retorna el avance del responsable de la Meta
             * @access public
             * @return int
             */
            public function getAvanceResponsableMetaSecundaria( ){
                    if( !empty( $this->avanceResponsableMetaSecundaria ) ){
                            return $this->avanceResponsableMetaSecundaria;
                    }else{
                            return 0;
                    } 
            }

            /**
             * Modifica el avance del supervisor de la Meta
             * @param int $avanceSupervisorMetaSecundaria
             * @access public
             * @return void
             */
            public function setAvanceSupervisorMetaSecundaria( $avanceSupervisorMetaSecundaria ){
                    $this->avanceSupervisorMetaSecundaria = $avanceSupervisorMetaSecundaria;
            }

            /**
             * Retorna el avance del supervisor de la Meta
             * @access public
             * @return int
             */
            public function getAvanceSupervisorMetaSecundaria( ){
                    if( !empty( $this->avanceSupervisorMetaSecundaria ) ){
                            return $this->avanceSupervisorMetaSecundaria;
                    }else{
                            return 0;
                    }
            }

            /**
             * Modifica el responsable de la Meta
             * @param String $responsableMetaSecundaria
             * @access public
             * @return void
             */
            public function setResponsableMetaSecundaria( $responsableMetaSecundaria ){
                    $this->responsableMetaSecundaria = $responsableMetaSecundaria;
            }

            /**
             * Retorna el responsable de la Meta
             * @access public
             * @return String
             */
            public function getResponsableMetaSecundaria( ){
                    return $this->responsableMetaSecundaria;
            }

            /**
             * Modifica el estado de la Meta Secundaria
             * @param int $estadoMetaSecundaria
             * @access public
             * @return void
             */
            public function setEstadoMetaSecundaria( $estadoMetaSecundaria ){
                    $this->estadoMetaSecundaria = $estadoMetaSecundaria;
            }

            /**
             * Retorna el estado de la Meta Secundaria
             * @access public
             * @return int
             */
            public function getEstadoMetaSecundaria( ){
                    return $this->estadoMetaSecundaria;
            }

            //////////////////////////////////////////////////////////////////////////////////////////////
            /**
             * Modifica la fecha de creacion de la Meta
             * @param datetime fechaCreacion
             * @access public
             * @return void
             */
            public function setFechaCreacion( $fechaCreacion ){
                    $this->fechaCreacion = $fechaCreacion;
            }

            /**
             * Retorna la fecha de creacion de la Meta
             * @access public
             * @return datetime
             */
            public function getFechaCreacion( ){
                    return $this->fechaCreacion;
            }

            /**
             * Modifica la fecha de modificacion de la Meta
             * @param datetime fechaUltimaModificacion
             * @access public
             * @return void
             */
            public function setFechaUltimaModificacion( $fechaUltimaModificacion ){
                    $this->fechaUltimaModificacion = $fechaUltimaModificacion;
            }

            /**
             * Retorna la fecha de modificacion de la Meta
             * @access public
             * @return datetime
             */
            public function getFechaUltimaModificacion( ){
                    return $this->fechaUltimaModificacion;
            }

            /**
             * Modifica el usuario de creacion de la Meta
             * @param int usuarioCreacion
             * @access public
             * @return void
             */
            public function setUsuarioCreacion( $usuarioCreacion ){
                    $this->usuarioCreacion = $usuarioCreacion;
            }

            /**
             * Retorna usuario de creacion de la Meta
             * @access public
             * @return int
             */
            public function getUsuarioCreacion( ){
                    return $this->usuarioCreacion;
            }

            /**
             * Modifica el usuario de modificacion de la Meta
             * @param int usuarioModificacion
             * @access public
             * @return void
             */
            public function setUsuarioModificacion( $usuarioModificacion ){
                    $this->usuarioModificacion = $usuarioModificacion;
            }

            /**
             * Retorna usuario de modificacion de la Meta
             * @access public
             * @return int
             */
            public function getUsuarioModificacion( ){
                    return $this->usuarioModificacion;
            }



            /*Modified Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
             *se añaden set y get EmailResponsableMetaSecundaria  
             *Since April 18 , 2017 
             * */

            public function setEmailResponsableMetaSecundaria ( $emailResponsableMetaSecundaria) {

                    $this->emailResponsableMetaSecundaria = $emailResponsableMetaSecundaria;
            }

            public function getEmailResponsableMetaSecundaria( ) {

                    return $this->emailResponsableMetaSecundaria;
            }

            //fin modificacion

            /**
             * Consultar Indicadores
             * @access public
             */
            public function consultarMetaSecundaria( $metaIndicadorPlanDesarrolloId, $txtIdMetaSecundaria = 0 ,$fechaInicioMetaSecundaria = ''){
                    //$fechaInicioMetaSecundaria='2018-12-15 00:00:00';
                    $metasSecundarias = array( );
                    $inner='';
                    $where = array();
                    $params = array();

                    if(  !empty( $metaIndicadorPlanDesarrolloId ) ){
                            //$inner = 'INNER JOIN IndicadorPlanDesarrollo ipd ON (ipd.IndicadorPlanDesarrolloId = mipd.IndicadorPlanDesarrolloId)';
                            $where[] = 'mspd.MetaIndicadorPlanDesarrolloId = ? AND mspd.EstadoMetaSecundaria = 100';
                            $objParam = new stdClass();
                            $objParam->value = $metaIndicadorPlanDesarrolloId;
                            $objParam->text = false;
                            $params[0] = $objParam; 
                            unset($objParam);
                    }

                       /*Modified DIego Rivera<riveradiego@unbosque.edu>
                     */
                    if(  !empty( $fechaInicioMetaSecundaria ) ){
                            $where[] = 'mspd.FechaFinMetaSecundaria like  "%?%"';
                            $objParam = new stdClass();
                            $objParam->value = $fechaInicioMetaSecundaria;
                            $objParam->text = false;
                            $params[count($where)-1] = $objParam; 
                            unset($objParam);
                    }


                    if(  !empty( $txtIdMetaSecundaria ) ){
                            //$inner = 'INNER JOIN IndicadorPlanDesarrollo ipd ON (ipd.IndicadorPlanDesarrolloId = mipd.IndicadorPlanDesarrolloId)';
                            $where[] = 'mspd.MetaSecundariaPlanDesarrolloId = ?';
                            $objParam = new stdClass();
                            $objParam->value = $txtIdMetaSecundaria;
                            $objParam->text = false;
                            $params[count($where)-1] = $objParam; 
                            unset($objParam);
                    }

                    $where[] = 'mspd.EstadoMetaSecundaria=100';
                    $sql = "SELECT mspd.MetaSecundariaPlanDesarrolloId,
                                               mspd.MetaIndicadorPlanDesarrolloId,
                                               mspd.NombreMetaSecundaria,
                                               mspd.FechaInicioMetaSecundaria,
                                               mspd.FechaFinMetaSecundaria,
                                               mspd.ValorMetaSecundaria,
                                               mspd.ActividadMetaSecundaria,
                                               mspd.AvanceResponsableMetaSecundaria,
                                               mspd.AvanceSupervisorMetaSecundaria,
                                               mspd.ResponsableMetaSecundaria,
                                               mspd.FechaCreacion,
                                               mspd.FechaModificacion,
                                               mspd.UsuarioCreacion,
                                               mspd.UsuarioModificacion,
                                               mspd.EmailResponsableMetaSecundaria
                                      FROM MetaSecundariaPlanDesarrollo  mspd ";

                    if(!empty($inner)){
                            $sql .= $inner;
                    }

                    if(!empty($where)){
                            $sql .= ' 
                                 WHERE '.implode(' AND ',$where);
                    }
                    $sql .= ' ORDER BY mspd.FechaFinMetaSecundaria ASC ';


                    $this->persistencia->crearSentenciaSQL( $sql );

                    if(!empty($params)){
                            foreach($params as $k=>$v){
                                    $this->persistencia->setParametro( $k, $v->value, $v->text );
                            }
                    }

                    //echo ($this->persistencia->getSQLListo( )); 
                    $this->persistencia->ejecutarConsulta(  );
                    while( $this->persistencia->getNext( ) ){
                            $metaSecundaria = new MetaSecundaria( $this->persistencia );
                            $metaSecundaria->setMetaSecundariaPlanDesarrolloId( $this->persistencia->getParametro( "MetaSecundariaPlanDesarrolloId" ) );  

                            $meta = new Meta( null );
                            $meta->setMetaIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ) );

                            $metaSecundaria->setMeta( $meta );

                            $metaSecundaria->setNombreMetaSecundaria( $this->persistencia->getParametro( "NombreMetaSecundaria" ) );  
                            $metaSecundaria->setFechaInicioMetaSecundaria( $this->persistencia->getParametro( "FechaInicioMetaSecundaria" ) );  
                            $metaSecundaria->setFechaFinMetaSecundaria( $this->persistencia->getParametro( "FechaFinMetaSecundaria" ) );  
                            $metaSecundaria->setValorMetaSecundaria( $this->persistencia->getParametro( "ValorMetaSecundaria" ) );
                            $metaSecundaria->setActividadMetaSecundaria( $this->persistencia->getParametro( "ActividadMetaSecundaria" ) ); 
                            $metaSecundaria->setAvanceResponsableMetaSecundaria( $this->persistencia->getParametro( "AvanceResponsableMetaSecundaria" ) );  
                            $metaSecundaria->setAvanceSupervisorMetaSecundaria( $this->persistencia->getParametro( "AvanceSupervisorMetaSecundaria" ) );  
                            $metaSecundaria->setResponsableMetaSecundaria( $this->persistencia->getParametro( "ResponsableMetaSecundaria" ) );  

                            $metaSecundaria->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
                            $metaSecundaria->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaModificacion" ) );
                            $metaSecundaria->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
                            $metaSecundaria->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
                            $metaSecundaria->setEmailResponsableMetaSecundaria( $this->persistencia->getParametro( "EmailResponsableMetaSecundaria" ));

                            $metasSecundarias[] = $metaSecundaria;
                    }
                    $this->persistencia->freeResult( );/**/

                    return 	$metasSecundarias;/**/
            }

            /**
             * Crear Meta Principal del Indicador del Plan Desarrollo
             * @access public
             */
            public function crearMetaSecundaria( $idPersona ){
                    $sql = "INSERT INTO MetaSecundariaPlanDesarrollo (
                                            MetaSecundariaPlanDesarrolloId,
                                            MetaIndicadorPlanDesarrolloId,
                                            NombreMetaSecundaria,
                                            FechaInicioMetaSecundaria,
                                            FechaFinMetaSecundaria,
                                            ValorMetaSecundaria,
                                            ActividadMetaSecundaria,
                                            AvanceResponsableMetaSecundaria,
                                            AvanceSupervisorMetaSecundaria,
                                            ResponsableMetaSecundaria,
                                            EstadoMetaSecundaria,
                                            FechaCreacion,
                                            FechaModificacion,
                                            UsuarioCreacion,
                                            UsuarioModificacion,
                                            EmailResponsableMetaSecundaria
                                    )
                                    VALUES
                                            (
                                                    ( SELECT IFNULL( MAX( MS.MetaSecundariaPlanDesarrolloId ) +1, 1 ) 
                                                            FROM MetaSecundariaPlanDesarrollo MS
                                                     ),
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?,
                                                    ?,
                                                    NULL,
                                                    NULL,
                                                    ?,
                                                    '100',
                                                    NOW( ),
                                                    NULL,
                                                    ?,
                                                    NULL,
                                                    ?
                                            );";

                    $this->persistencia->conectar( );
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $this->getMeta( )->getMetaIndicadorPlanDesarrolloId( ), false );
                    $this->persistencia->setParametro( 1 , $this->getNombreMetaSecundaria( ) , true );
                    $this->persistencia->setParametro( 2 , $this->getFechaInicioMetaSecundaria( ) , true );
                    $this->persistencia->setParametro( 3 , $this->getFechaFinMetaSecundaria( ) , true );
                    $this->persistencia->setParametro( 4 , $this->getValorMetaSecundaria( ) , true );
                    $this->persistencia->setParametro( 5 , $this->getActividadMetaSecundaria( ), true );
                    $this->persistencia->setParametro( 6 , $this->getResponsableMetaSecundaria( ) , true );
                    $this->persistencia->setParametro( 7 , $idPersona , false );
                    $this->persistencia->setParametro (8 , $this->getEmailResponsableMetaSecundaria( ) , true);
                    //echo $this->persistencia->getSQLListo( ); exit( );
                    $this->persistencia->ejecutarUpdate(  );
                    return true;
            }

            /**
             * Contar Metas Secundarias por MetaPrincipal
             * @access public
             */
            public function cuentaMetaSecundarias( $txtIdMetaPrincipal ){

                    $sql = "SELECT COUNT(M.MetaSecundariaPlanDesarrolloId) AS cantidad_metaSecundaria
                                    FROM MetaSecundariaPlanDesarrollo M
                                    WHERE M.MetaIndicadorPlanDesarrolloId = ?
                                    AND M.EstadoMetaSecundaria = 100";

                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $txtIdMetaPrincipal , true );

                    $this->persistencia->ejecutarConsulta(  );
                    $cantidad = 0;

                    if( $this->persistencia->getNext( ) )
                            $cantidad = $this->persistencia->getParametro( "cantidad_metaSecundaria" );

                    $this->persistencia->freeResult( );

                    return $cantidad;
            }

            /**
             * Eliminar Meta Secundaria
             * @access public
             */
            public function eliminaMetaSecundaria( $idPersona, $txtIdMetaSecundaria ){
                    $sql = "UPDATE MetaSecundariaPlanDesarrollo
                                    SET 
                                     EstadoMetaSecundaria = '200',
                                     FechaModificacion = NOW( ),
                                     UsuarioModificacion = ?
                                    WHERE
                                    MetaSecundariaPlanDesarrolloId = ?;";

                    $this->persistencia->crearSentenciaSQL( $sql );

                    $this->persistencia->setParametro( 0 , $idPersona , false );
                    $this->persistencia->setParametro( 1 , $txtIdMetaSecundaria , false );
                    //echo $this->persistencia->getSQLListo( );
                    $estado = $this->persistencia->ejecutarUpdate( );

                    if( $estado )
                            $this->persistencia->confirmarTransaccion( );
                    else	
                            $this->persistencia->cancelarTransaccion( );

                    //$this->persistencia->freeResult( );
                    return $estado;	
            }

            /**
             * Actualizar Meta Secimdaroa
             * @access public
             */
            public function actualizarMetaSecundaria( $variables ){
                    $sql = "UPDATE MetaSecundariaPlanDesarrollo 
                                       SET NombreMetaSecundaria = ? ,
                                               FechaInicioMetaSecundaria = ? ,
                                               FechaFinMetaSecundaria = ? ,
                                               ValorMetaSecundaria = ? ,
                                               ActividadMetaSecundaria = ?,
                                               ResponsableMetaSecundaria = ? ,
                                               FechaModificacion = NOW( ),
                                               UsuarioModificacion = ?,
                                               EmailResponsableMetaSecundaria = ? 
                                     WHERE MetaSecundariaPlanDesarrolloId = ? ;";

                    $this->persistencia->conectar( );
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $variables->txtActualizaMeta, true );
                    $this->persistencia->setParametro( 1 , $variables->txtFechaActualizaInicioMeta , true );
                    $this->persistencia->setParametro( 2 , $variables->txtFechaActualizaFinalMeta , true );
                    $this->persistencia->setParametro( 3 , $variables->txtActualizaValorMeta , true );
                    $this->persistencia->setParametro( 4 , $variables->txtActualizaAccionMeta , true );
                    $this->persistencia->setParametro( 5 , $variables->txtActualizaResponsableMeta , true );
                    $this->persistencia->setParametro( 6 , $variables->idPersona , true );
                    $this->persistencia->setParametro( 7 , $variables->txtEmail , true );
                    $this->persistencia->setParametro( 8 , $variables->txtIdMetaSecundaria , true );
                    //ddd($this->persistencia->getSQLListo( ) );
                    $this->persistencia->ejecutarUpdate(  );
                    return true;
            }


            /**
             * Buscar Meta Secundaria Id
             * @access public
             */
            public function buscarMetaSecundariaId( $txtIdMetaSecundaria ){
                    $sql = "SELECT
                            mspd.MetaSecundariaPlanDesarrolloId,
                            mspd.MetaIndicadorPlanDesarrolloId,
                            mspd.NombreMetaSecundaria,
                            mspd.FechaInicioMetaSecundaria,
                            mspd.FechaFinMetaSecundaria,
                            mspd.ValorMetaSecundaria,
                            mspd.ActividadMetaSecundaria,
                            mspd.AvanceResponsableMetaSecundaria,
                            mspd.AvanceSupervisorMetaSecundaria,
                            mspd.ResponsableMetaSecundaria,
                            mspd.FechaCreacion,
                            mspd.FechaModificacion,
                            mspd.UsuarioCreacion,
                            mspd.UsuarioModificacion,
                            T.TipoIndicadorId
                    FROM
                            MetaSecundariaPlanDesarrollo mspd
                    INNER JOIN MetaIndicadorPlanDesarrollo M ON ( M.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId )
                    INNER JOIN IndicadorPlanDesarrollo I ON ( I.IndicadorPlanDesarrolloId = M.IndicadorPlanDesarrolloId )
                    INNER JOIN TipoIndicador T ON ( T.TipoIndicadorId = I.TipoIndicadorId )
                    WHERE
                            mspd.MetaSecundariaPlanDesarrolloId = ?
                    AND mspd.EstadoMetaSecundaria = 100";
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $txtIdMetaSecundaria , false );
                    //echo $this->persistencia->getSQLListo( ); exit( );
                    $this->persistencia->ejecutarConsulta( );
                    if( $this->persistencia->getNext( ) ){
                            $this->setMetaSecundariaPlanDesarrolloId( $this->persistencia->getParametro( "MetaSecundariaPlanDesarrolloId" ) );
                            $this->setNombreMetaSecundaria( $this->persistencia->getParametro( "NombreMetaSecundaria" ) );
                            $this->setFechaInicioMetaSecundaria( $this->persistencia->getParametro( "FechaInicioMetaSecundaria" ) );
                            $this->setFechaFinMetaSecundaria( $this->persistencia->getParametro( "FechaFinMetaSecundaria" ) );
                            $this->setValorMetaSecundaria( $this->persistencia->getParametro( "ValorMetaSecundaria" ) );
                            $this->setActividadMetaSecundaria( $this->persistencia->getParametro( "ActividadMetaSecundaria" ) );
                            $this->setAvanceResponsableMetaSecundaria( $this->persistencia->getParametro( "AvanceResponsableMetaSecundaria" ) );
                            $this->setAvanceSupervisorMetaSecundaria( $this->persistencia->getParametro( "AvanceSupervisorMetaSecundaria" ) );
                            $this->setResponsableMetaSecundaria( $this->persistencia->getParametro( "ResponsableMetaSecundaria" ) );

                            $meta = new Meta( null );
                            $meta->setMetaIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ) );

                            $indicador = new Indicador( null );
                            $tipoIndicador = new TipoIndicador( null );
                            $tipoIndicador->setIdTipoIndicador( $this->persistencia->getParametro( "TipoIndicadorId" ) );

                            $indicador->setTipoIndicador( $tipoIndicador );

                            $meta->setIndicador( $indicador );

                            $this->setMeta( $meta );
                    }

                    $this->persistencia->freeResult( );	

            }


            /**
             * Actualizar Avance Responsable, Supervisor
             * @access public
             */
            public function actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria ){
                    $sql = "UPDATE MetaSecundariaPlanDesarrollo
                                    SET 
                                     AvanceResponsableMetaSecundaria = ?, 
                                     AvanceSupervisorMetaSecundaria = ?,
                                     FechaModificacion = NOW( ),
                                     UsuarioModificacion = ?
                                    WHERE
                                    MetaSecundariaPlanDesarrolloId = ?";

                    $this->persistencia->crearSentenciaSQL( $sql );

                    $this->persistencia->setParametro( 0 , $txtAvancePropuesto , false );
                    $this->persistencia->setParametro( 1 , $txtAvanceSupervisor , false );
                    $this->persistencia->setParametro( 2 , $idPersona , false );
                    $this->persistencia->setParametro( 3 , $txtIdMetaSecundaria , false );
                    //echo $this->persistencia->getSQLListo( );
                    $estado = $this->persistencia->ejecutarUpdate( );

                    if( $estado )
                            $this->persistencia->confirmarTransaccion( );
                    else	
                            $this->persistencia->cancelarTransaccion( );

                    //$this->persistencia->freeResult( );
                    return $estado;	
            }

		
            public function consultarSecundarias( $metaPrincipal){
                    $metasSecundarias = array( );
                    $sql = "SELECT 
                                               mspd.ValorMetaSecundaria,
                                               mspd.AvanceResponsableMetaSecundaria
                                      FROM 
                                               MetaSecundariaPlanDesarrollo  mspd 
                                      WHERE
                                               mspd.MetaIndicadorPlanDesarrolloId = ? and  
                                               mspd.EstadoMetaSecundaria=100;
                                      ";
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $metaPrincipal , false );
                    //echo $this->persistencia->getSQLListo( );
                    $this->persistencia->ejecutarConsulta(  );
                    while( $this->persistencia->getNext( ) ){

                            $metaSecundaria = new MetaSecundaria( $this->persistencia );

                            $metaSecundaria->setValorMetaSecundaria( $this->persistencia->getParametro( "ValorMetaSecundaria" ) );
                            $metaSecundaria->setAvanceResponsableMetaSecundaria( $this->persistencia->getParametro( "AvanceResponsableMetaSecundaria" ) );  

                            $metasSecundarias[] = $metaSecundaria;
                    }
                    $this->persistencia->freeResult( );
                    return 	$metasSecundarias;	
            }
            
            public function alcanceMetasSecundarias ( $metaPrincipal ){
                    $sql="SELECT
                            sum( ValorMetaSecundaria ) as valoresMeta
                          FROM
                            MetaSecundariaPlanDesarrollo 
                          WHERE
                            EstadoMetaSecundaria = 100 
                            AND MetaIndicadorPlanDesarrolloId = ?";
                    
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $metaPrincipal , false );
                    $this->persistencia->ejecutarConsulta( );
                    if( $this->persistencia->getNext( ) ){
                         $this->setValorMetaSecundaria( $this->persistencia->getParametro( "valoresMeta" ) );
                    }
            }

        }
	
?>
