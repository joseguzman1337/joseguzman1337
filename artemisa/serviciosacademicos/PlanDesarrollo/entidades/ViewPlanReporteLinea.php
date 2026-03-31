<?php

/* @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */

    class ViewPlanReporteLinea {
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
        private $alcanceMeta;
        /**
	 * @type int
	 * @access private
	 */
        private $alcance;
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
	 * @type Singleton
	 * @access private
	 */
        private $persistencia;
        /**
	 * Constructor
	 * @param Singleton $persistencia
	 */
        public function ViewPlanReporteLinea( $persistencia ){
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
	 * Modifica el AlcanceMeta
	 * @param int $AlcanceMeta
	 * @access public
	 * @return void
	 */
        public function setAlcanceMeta( $alcanceMeta ){
            $this->alcanceMeta = $alcanceMeta;
        } 
        /**
	 * Retorna el AlcanceMeta
	 * @access public
	 * @return int
	 */
        public function getAlcanceMeta( ){
            return $this->alcanceMeta;
        }
         /**
	 * Modifica el Alcance
	 * @param int $Alcance
	 * @access public
	 * @return void
	 */
        public function  setAlcance( $alcance ){
            $this->alcance=$alcance;
        }
         /**
	 * Retorna el Alcance
	 * @access public
	 * @return int
	 */
        public function getAlcance( ){
            return $this->alcance;
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
        * Consulta los ProgramaPlanDesarrolloId de los  programas asociados al plan y linea estrategica
        * @access public
        */
        public function conteoPrograma ($idPlan , $idLinea ){
            $reportePrograma = array();
            $sql = "SELECT
                        ProgramaPlanDesarrolloId
                    FROM
                        ViewPlanReporteLineas 
                    WHERE
                        PlanDesarrolloId = ?
                        AND LineaEstrategicaId = ?
                    GROUP BY	
                        ProgramaPlanDesarrolloId";
            
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $idPlan , false );
            $this->persistencia->setParametro( 1 , $idLinea , false );
            //echo $this->persistencia->getSQLListo( );
            $this->persistencia->ejecutarConsulta( );
            while( $this->persistencia->getNext( ) ){
                $ViewPlanReporteLineas= new ViewPlanReporteLinea( null );
                $ViewPlanReporteLineas->setProgramaPlanDesarrolloId( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
                $reportePrograma[] = $ViewPlanReporteLineas;
            }
            return $reportePrograma;
        }
        /**
        * Consulta los ProyectoPlanDesarrolloId y cantidad de proyectos a traves del idprograma , plan y linea estrategica
        * @access public
        */
        public function conteoProyecto ( $idPlan , $idLinea , $idPrograma ){
            $reporteProyecto = array( );
            $sql = "SELECT
                        ProyectoPlanDesarrolloId,
                        ( SELECT COUNT( * ) FROM ViewPlanReporteLineas Vp WHERE Vp.ProyectoPlanDesarrolloId = ViewPlanReporteLineas.ProyectoPlanDesarrolloId ) as conteo
                    FROM
                        ViewPlanReporteLineas 
                    WHERE
                        PlanDesarrolloId = ?
                        AND LineaEstrategicaId = ? 
                        AND ProgramaPlanDesarrolloId = ?    
                    GROUP BY
                        ProyectoPlanDesarrolloId";  
            
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $idPlan , true );
            $this->persistencia->setParametro( 1 , $idLinea , false );
            $this->persistencia->setParametro( 2 , $idPrograma , false );
           // echo $this->persistencia->getSQLListo( );
            $this->persistencia->ejecutarConsulta( );
            while( $this->persistencia->getNext( ) ){
                $ViewPlanReporteLineas= new ViewPlanReporteLinea( null );
                $ViewPlanReporteLineas->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
                $ViewPlanReporteLineas->setConteo( $this->persistencia->getParametro( "conteo" ) );
                $reporteProyecto[] = $ViewPlanReporteLineas;
            }
            return $reporteProyecto;
        }
        /**
        * Consulta  el avance del plan de desarrollo a traves del calculo de porcentaje de las metas asociadas a  proyecto, programa y linea
        * Consume los metodos conteoProyecto y conteoPrograma
        * @access public
        */
        public function alcanceMetas( $idPlan , $idLinea ){
        /*@Modified Diego Rivera<riveradiego@unbosque.edu.co>
         * se cambia retorno  de array a devolver solo un valor
         *@ Since august 13 .2018
         */   
        // $reporte = array( );
            $programas = $this->conteoPrograma($idPlan, $idLinea);
            $conteoProgramas = 0;
            $retornaPorcentajeProgramas = new stdClass();
            $conteoProgramas = 0;
            $conteoAvanceProgramas = 0;
            $retornaPorcentajeProgramas->conteo = 0;
            
            foreach($programas as $pr ){
                $conteoProyectos = 0;
                $proyecto = $this->conteoProyecto($idPlan, $idLinea, $pr->getProgramaPlanDesarrolloId());    
                $retornaPorcentajeProyectos = new stdClass();
                $retornaPorcentajeProyectos->conteo=0;
                $conteoProgramas=$conteoProgramas+1;
                foreach ($proyecto as $pro) {
                    $conteoProyectos=$conteoProyectos+1;
                    $sql = "SELECT
                                ((alcance*100)/alcanceMeta) as conteo
                            FROM
                                ViewPlanReporteLineas 
                            WHERE
                                PlanDesarrolloId = ?
                                AND LineaEstrategicaId = ?
                                AND ProyectoPlanDesarrolloId = ?";

                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $idPlan , false );
                    $this->persistencia->setParametro( 1 , $idLinea , false );
                    $this->persistencia->setParametro( 2 , $pro->getProyectoPlanDesarrolloId( ), false );
                    $this->persistencia->ejecutarConsulta( );
                    $retornaObjeto = new stdClass();
                    $retornaObjeto->conteo = 0;
                    while( $this->persistencia->getNext( ) ){
                        $ViewPlanReporteLineas= new ViewPlanReporteLinea( null );
                        $ViewPlanReporteLineas->setConteo( $this->persistencia->getParametro( "conteo" ) );
                        $retornaObjeto->conteo += $this->persistencia->getParametro( "conteo" );
                    }
                    $porcentajeMeta= $retornaObjeto->conteo/$pro->getConteo();
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
            //$reporte[]=$retornaPorcentajeProgramas;
            return $retornaPorcentajeProgramas;
        }
        
    }

?>