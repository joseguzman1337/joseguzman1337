<?php
//include ('../../../kint/Kint.class.php'); 
class ViewPlanReporteAvance {
     /**
	 * @type int
	 * @access private
	 */
        private $idLineaEstrategica;
        /**
	 * @type int
	 * @access private
	 */
        private $planDesarrolloId;
        /**
	 * @type int
	 * @access private
	 */
        private $programaPlanDesarrolloId;
        /**
	 * @type int
	 * @access private
	 */
        private $proyectoPlanDesarrolloId;
        /**
	 * @type int
	 * @access private
	 */
        private $metaIndicadorPlanDesarrolloId;
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
        private $conteo;
        /**
	 * @type int
	 * @access private
	 */
        private $avance;
        /**
	 * @type Date
	 * @access private
	 */
        private $fechaFinMetaSecundaria;
        /**
	 * @type Singleton
	 * @access private
	 */
        private $persistencia;
        /**
	 * Constructor
	 * @param Singleton $persistencia
	 */
        public function ViewPlanReporteAvance( $persistencia ){
            $this->persistencia = $persistencia;
	}
        /**
	 * Modifica el IdLineaEstrategica
	 * @param int $idLineaEstrategica 
	 * @access public
	 * @return void
	 */
        public function setIdLineaEstrategica( $idLineaEstrategica ){
            $this->idLineaEstrategica=$idLineaEstrategica;
        } 
        /**
	 * Retorna el IdLineaEstrategica
	 * @access public
	 * @return int
	 */
        public function getIdLineaEstrategica( ){
            return $this->idLineaEstrategica;
        } 
         /**
	 * Modifica el PlanDesarrolloId
	 * @param int $planDesarrolloId
	 * @access public
	 * @return void
	 */
        public function setPlanDesarrolloId( $planDesarrolloId ){
            $this->planDesarrolloId = $planDesarrolloId;
        }
         /**
	 * Retorna el planDesarrolloId
	 * @access public
	 * @return int
	 */
        public function getPlanDesarrolloId( ){
            return $this->planDesarrolloId;
        }
         /**
	 * Modifica el ProgramaPlanDesarrolloId
	 * @param int $ProgramaPlanDesarrolloId
	 * @access public
	 * @return void
	 */
        public function setProgramaPlanDesarrolloId( $programaPlanDesarrolloId ){
            $this->programaPlanDesarrolloId=$programaPlanDesarrolloId;
        }
        /**
	 * Retorna el ProgramaPlanDesarrolloId
	 * @access public
	 * @return int
	 */
        public function getProgramaPlanDesarrolloId( ){
            return $this->programaPlanDesarrolloId;
        }
         /**
	 * Modifica el ProyectoPlanDesarrolloId
	 * @param int $ProyectoPlanDesarrolloId
	 * @access public
	 * @return void
	 */
        public function setProyectoPlanDesarrolloId( $proyectoPlanDesarrolloId ){
            $this->proyectoPlanDesarrolloId = $proyectoPlanDesarrolloId;
        }
        /**
	 * Retorna el ProyectoPlanDesarrolloId
	 * @access public
	 * @return int
	 */
        public function getProyectoPlanDesarrolloId( ){
            return $this->proyectoPlanDesarrolloId;
        }
         /**
	 * Modifica el MetaIndicadorPlanDesarrolloId
	 * @param int $MetaIndicadorPlanDesarrolloId
	 * @access public
	 * @return void
	 */
        public function setMetaIndicadorPlanDesarrolloId( $metaIndicadorPlanDesarrolloId ){
            $this->metaIndicadorPlanDesarrolloId = $metaIndicadorPlanDesarrolloId;
        }
        /**
	 * Retorna el MetaIndicadorPlanDesarrolloId
	 * @access public
	 * @return int
	 */
        public function getMetaIndicadorPlanDesarrolloId( ){
            return $this->metaIndicadorPlanDesarrolloId;
        }
         /**
	 * Modifica el valor meta secundaria
	 * @param int $valorMetraSecundaria
	 * @access public
	 * @return void
	 */
        public function setValorMetaSecundaria( $valorMetaSecundaria ){
            $this->valorMetaSecundaria = $valorMetaSecundaria;
        } 
        /**
	 * Retorna el valor meta secundaria
	 * @access public
	 * @return int
	 */
        public function getValorMetaSecundaria( ){
            return $this->valorMetaSecundaria;
        }
         /**
	 * Modifica el AvanceResponsableMetaSecundaria
	 * @param int $avanceResponsableMetaSecundaria
	 * @access public
	 * @return void
	 */
        public function  setAvanceResponsableMetaSecundaria( $avanceResponsableMetaSecundaria ){
            $this->avanceResponsableMetaSecundaria=$avanceResponsableMetaSecundaria;
        }
         /**
	 * Retorna el AvanceResponsableMetaSecundaria0
	 * @access public
	 * @return int
	 */
        public function getAvanceResponsableMetaSecundaria( ){
            return $this->avanceResponsableMetaSecundaria;
        }
         /**
	 * Modifica el Conteo
	 * @param int $Conteo
	 * @access public
	 * @return void
	 */
        public function setConteo( $conteo ){
            $this->conteo=$conteo;
        }
         /**
	 * Retorna el Conteo
	 * @access public
	 * @return int
	 */
        public function getConteo( ){
            return $this->conteo;
        }
        /**
	 * Modifica la fechafinmetasecundaria
	 * @param int $Conteo
	 * @access public
	 * @return void
	 */
        public function setFechaFinMetaSecundaria( $fechaFinMetaSecundaria ){
            $this->fechaFinMetaSecundaria = $fechaFinMetaSecundaria;
        }
        /**
	 * Retorna el Conteo
	 * @access public
	 * @return date
	 */
        public function getFechaFinMetaSecundaria( ){
            return $this->fechaFinMetaSecundaria;
        }
        
          /**
        * Consulta los ProgramaPlanDesarrolloId de los  programas asociados al plan y linea estrategica
        * @access public
        */
        public function conteoPrograma ($idPlan , $idLinea , $periodo){
            $reportePrograma = array();
            $sql = 'SELECT
                        ProgramaPlanDesarrolloId
                    FROM
                        ViewPlanReporteAvances 
                    WHERE
                        PlanDesarrolloId = ?
                        AND LineaEstrategicaId = ? 
                        AND  FechaFinMetaSecundaria like "%?%"
                    GROUP BY	
                        ProgramaPlanDesarrolloId';
            
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $idPlan , false );
            $this->persistencia->setParametro( 1 , $idLinea , false );
            $this->persistencia->setParametro( 2 , $periodo , false );
            //echo $this->persistencia->getSQLListo( ).'<br>';
            $this->persistencia->ejecutarConsulta( );
            while( $this->persistencia->getNext( ) ){
                $ViewPlanReporteLineas= new ViewPlanReporteAvance( null );
                $ViewPlanReporteLineas->setProgramaPlanDesarrolloId( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
                $reportePrograma[] = $ViewPlanReporteLineas;
            }
            return $reportePrograma;
        }
         /**
        * Consulta los ProyectoPlanDesarrolloId y cantidad de proyectos a traves del idprograma , plan y linea estrategica
        * @access public
        */
        public function conteoProyecto ( $idPlan , $idLinea , $idPrograma , $periodo){
            $reporteProyecto = array( );
            $sql = 'SELECT
                        ProyectoPlanDesarrolloId,
                        ( SELECT COUNT( * ) FROM ViewPlanReporteAvances Vp WHERE Vp.ProyectoPlanDesarrolloId = ViewPlanReporteAvances.ProyectoPlanDesarrolloId AND ViewPlanReporteAvances.FechaFinMetaSecundaria = FechaFinMetaSecundaria ) AS conteo 
                    FROM
                        ViewPlanReporteAvances 
                    WHERE
                        PlanDesarrolloId = ?
                        AND LineaEstrategicaId = ? 
                        AND ProgramaPlanDesarrolloId = ?   
                        AND  FechaFinMetaSecundaria like "%?%"
                    GROUP BY
                        ProyectoPlanDesarrolloId';  
            
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $idPlan , true );
            $this->persistencia->setParametro( 1 , $idLinea , false );
            $this->persistencia->setParametro( 2 , $idPrograma , false );
            $this->persistencia->setParametro( 3 , $periodo, false );
            // echo $this->persistencia->getSQLListo( ).'<br>';
            $this->persistencia->ejecutarConsulta( );
            while( $this->persistencia->getNext( ) ){
                $ViewPlanReporteLineas= new ViewPlanReporteAvance( null );
                $ViewPlanReporteLineas->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
                $ViewPlanReporteLineas->setConteo( $this->persistencia->getParametro( "conteo" ) );
                $reporteProyecto[] = $ViewPlanReporteLineas;
            }
            return $reporteProyecto;
        }
        
        public function ValorAvance($idPlan , $idLinea , $idProyecto , $periodo ){
            $sql='
                  SELECT
                        count(*) as conteo
                  FROM
                        ViewPlanReporteAvances  
                  WHERE
                        PlanDesarrolloId = ?
                        AND LineaEstrategicaId = ?
                        AND ProyectoPlanDesarrolloId = ?
                        AND FechaFinMetaSecundaria like "%?%"';
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $idPlan , true );
            $this->persistencia->setParametro( 1 , $idLinea , false );
            $this->persistencia->setParametro( 2 , $idProyecto , false );
            $this->persistencia->setParametro( 3 , $periodo, false );
            //echo $this->persistencia->getSQLListo( ).'<br>';
            $this->persistencia->ejecutarConsulta( );
            if( $this->persistencia->getNext( ) ){
                $ViewPlanReporteLineas= new ViewPlanReporteAvance( null );
                $ViewPlanReporteLineas->setConteo($this->persistencia->getParametro("conteo"));
            }
            return $ViewPlanReporteLineas;
        }
        
         /**
        * Consulta  el avance del plan de desarrollo a traves del calculo de porcentaje de las metas asociadas a  proyecto, programa y linea
        * Consume los metodos conteoProyecto y conteoPrograma
        * @access public
        */
        public function alcanceMetasAnuales( $idPlan , $idLinea , $periodo){
           /*@Modified Diego Rivera<riveradiego@unbosque.edu.co>
            * se cambia retorno  de array a devolver solo un valor
            * @Since august 13 .2018
            */
            //$reporte = array( );
            $programas = $this->conteoPrograma($idPlan, $idLinea , $periodo);
            $conteoProgramas = 0;
            $retornaPorcentajeProgramas = new stdClass();
            $conteoProgramas = 0;
            $conteoAvanceProgramas = 0;
            $retornaPorcentajeProgramas->conteo = 0;
            
            foreach( $programas as $pr ){
                $conteoProyectos = 0;
                $proyecto = $this->conteoProyecto( $idPlan, $idLinea, $pr->getProgramaPlanDesarrolloId() , $periodo );  
                $retornaPorcentajeProyectos = new stdClass();
                $retornaPorcentajeProyectos->conteo=0;
                $conteoProgramas=$conteoProgramas+1;
                foreach ($proyecto as $pro) {
                    $equivalencia=$this->ValorAvance( $idPlan, $idLinea, $pro->getProyectoPlanDesarrolloId( ) , $periodo );
                    $conteoProyectos=$conteoProyectos+1;
                    $sql = 'SELECT
                                ((alcance*100)/ValorMetaSecundaria) as conteo
                            FROM
                                ViewPlanReporteAvances  
                            WHERE
                                PlanDesarrolloId = ?
                                AND LineaEstrategicaId = ?
                                AND ProyectoPlanDesarrolloId = ?
                                AND FechaFinMetaSecundaria like "%?%"';

                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $idPlan , false );
                    $this->persistencia->setParametro( 1 , $idLinea , false );
                    $this->persistencia->setParametro( 2 , $pro->getProyectoPlanDesarrolloId( ), false );
                    $this->persistencia->setParametro( 3 , $periodo , false );
                    $this->persistencia->ejecutarConsulta( );
                    $retornaObjeto = new stdClass();
                    $retornaObjeto->conteo = 0;
                    while( $this->persistencia->getNext( ) ){
                        $ViewPlanReporteLineas= new ViewPlanReporteLinea( null );
                        $ViewPlanReporteLineas->setConteo( $this->persistencia->getParametro( "conteo" ) );
                        $retornaObjeto->conteo += $this->persistencia->getParametro( "conteo" );
                    }
                    $porcentajeMeta= $retornaObjeto->conteo/$equivalencia->getConteo();
                    $retornaPorcentajeProyectos->conteo+=$retornaObjeto->conteo=$porcentajeMeta;
                }
                $porcentajeProyecto = $retornaPorcentajeProyectos->conteo;
                $retornaPorcentajeProyectos->conteo=$porcentajeProyecto/$conteoProyectos;
                $conteoAvanceProgramas= $conteoAvanceProgramas+$porcentajeProyecto/$conteoProyectos;
            }
            $total = 0;
            if($conteoProgramas== 0){
               $total=0;
            }else{
               $total= $conteoAvanceProgramas/$conteoProgramas;
            }
            $retornaPorcentajeProgramas->conteo=$total; 
           // $reporte[]=$retornaPorcentajeProgramas;
            return $retornaPorcentajeProgramas;
        }
        
}

?>