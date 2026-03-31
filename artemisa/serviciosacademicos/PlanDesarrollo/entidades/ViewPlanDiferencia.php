<?php
//include ('../../../kint/Kint.class.php'); 
class ViewPlanDiferencia {
    /**
    * @type int
    * @access private
    */
    private $codigoFacultad;
    /**
    * @type int
    * @access private
    */
    private $codigocarrera;
    /**
    * @type String
    * @access private
    */
    private $nombrePlanDesarrollo;
    /**
    * @type int
    * @access private
    */
    private $lineaEstrategicaId;
    /**
    * @type String
    * @access private
    */
    private $nombreLineaEstrategica;
    /**
    * @type int
    * @access private
    */
    private $programaPlanDesarrolloId;
    /**
    * @type String
    * @access private
    */
    private $nombrePrograma;
    /**
    * @type int
    * @access private
    */
    private $proyectoPlanDesarrolloId;
    /**
    * @type String
    * @access private
    */
    private $nombreProyectoPlanDesarrollo;
    /**
    * @type object 
    * @access private
    */
    private $indicadorPlanDesarrolloId;
    /**
    * @type object 
    * @access private
    */
    private $indicador;
    /**
    * @type object 
    * @access private
    */
    private $meta;
    /**
    * @type object 
    * @access private
    */
    private $alcanceMeta;
    /**
    * @type object 
    * @access private
    */
    private $diferencia;
            
    /**
    * @type Singleton
    * @access private
    */
    private $persistencia;
    /**
    * Constructor
    * @param Singleton $persistencia
    */
    public function ViewPlanDiferencia( $persistencia ){
       $this->persistencia = $persistencia;
   }
   /**
    * Modifica el CodigoFacultad
    * @param int $codigoFacultad
    * @access public
    * @return void
    */
   public function setCodigoFacultad( $codigoFacultad ){
       $this->codigoFacultad = $codigoFacultad;
   }
    /**
     * Retorna el codigoFacultad
     * @access public
     * @return int
     */
   public function getCodigoFacultad( ){
       return $this->codigoFacultad;
   }   
   /**
    * Modifica el CodigoCarrera
    * @param int $codigoCarrera
    * @access public
    * @return void
    */    
   public function setCodigoCarrera( $codigoCarrera ){
       $this->codigoFacultad = $codigoCarrera;
   }
   /**
     * Retorna el codigoCarrera
     * @access public
     * @return int
     */
   public function getCodigoCarrera( ){
       return $this->codigocarrera;
   }
   /**
    * Modifica el NombrePlanDesarrollo
    * @param int $nombrePlanDesarrollo
    * @access public
    * @return void
    */    
   public function setNombrePlanDesarrollo( $nombrePlanDesarrollo ){
       $this->nombrePlanDesarrollo = $nombrePlanDesarrollo;
   }
    /**
     * Retorna el NombrePlanDesarrollo
     * @access public
     * @return int
     */
   public function getNombrePlanDesarrollo( ) {
       return $this->nombrePlanDesarrollo;       
   }
    /**
    * Modifica el lineaEstrategicaId
    * @param int $lineaEstrategicaId
    * @access public
    * @return void
    */  
   public function setLineaEstrategicaId( $lineaEstrategicaId ){
       $this->lineaEstrategicaId = $lineaEstrategicaId;
   }
     /**
     * Retorna el LineaEstrategicaId
     * @access public
     * @return int
     */
   public function getLineaEstrategicaId( ){
       return $this->lineaEstrategicaId;
   } 
     /**
    * Modifica el NombreLineaEstrategica
    * @param int $NombreLineaEstrategica
    * @access public
    * @return void
    */ 
   public function setNombreLineaEstrategica( $nombreLineaEstrategica ){
       $this->nombreLineaEstrategica = $nombreLineaEstrategica;
   } 
     /**
     * Retorna el NombreLineaEstrategica
     * @access public
     * @return int
     */
   public function getNombreLineaEstrategica( ){
       return $this->nombreLineaEstrategica;
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
    * Modifica el nombrePrograma
    * @param int $nombrePrograma
    * @access public
    * @return void
    */
    public function setNombrePrograma( $nombrePrograma ){
        $this->nombrePrograma = $nombrePrograma;
    }
     /**
     * Retorna el NombrePrograma
     * @access public
     * @return int
     */
    public function getNombrePrograma( ){
        return $this->nombrePrograma;
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
    * Modifica el NombreProyectoPlanDesarrollo
    * @param int $NombreProyectoPlanDesarrollo
    * @access public
    * @return void
    */
    public function  setNombreProyectoPlanDesarrollo( $nombreProyectoPlanDesarrollo ){
        $this->nombreProyectoPlanDesarrollo = $nombreProyectoPlanDesarrollo;
    }
     /**
     * Retorna el NombreProyectoPlanDesarrollo
     * @access public
     * @return int
     */
    public function getNombreProyectoPlanDesarrollo( ){
        return $this->nombreProyectoPlanDesarrollo;
    }
    /**
    * Modifica el IndicadorPlanDesarrolloId 
    * @param int $indicadorPlanDesarrolloId 
    * @access public
    * @return void
    */
    public function setIndicadorPlanDesarrolloId( $indicadorPlanDesarrolloId ){
        $this->indicadorPlanDesarrolloId = $indicadorPlanDesarrolloId;
    }
    /**
    * Retorna el IndicadorPlanDesarrolloId
    * @access public
    * @return int
    */
    public function getIndicadorPlanDesarrolloId( ){
        return $this->indicadorPlanDesarrolloId;
    } 
      /**
    * Modifica el indicador
    * @param int $indicador 
    * @access public
    * @return void
    */
    public function setIndicador( $indicador ){
        $this->indicador = $indicador;
    }
    /**
    * Retorna  Indicador
    * @access public
    * @return int
    */
    public function getIndicador(){
        return $this->indicador;
    }
    /**
    * Modifica el Diferencia 
    * @param int $diferencia 
    * @access public
    * @return void
    */
    public function setDiferencia( $diferencia ){
        $this->diferencia = $diferencia;
    }
    /**
    * Retorna el diferencia
    * @access public
    * @return int
    */
    public function getDiferencia( ){
        return $this->diferencia;
    }
      /**
    * Modifica la Meta
    * @param int $meta
    * @access public
    * @return void
    */
    public function setMeta( $meta ){
        $this->meta = $meta;
    }
        /**
    * Retorna la meta
    * @access public
    * @return string
    */
    public function getMeta(){
        return $this->meta;
    }
    
    public function setAlcanceMeta( $alcanceMeta ){
        $this->alcanceMeta = $alcanceMeta;
    }
    /**
    * Retorna el alcance de la meta
    * @access public
    * @return int
    */
    public function getAlcanceMeta( ){
        return $this->alcanceMeta;
    }
    /**
     * Consulta las  lineas estrategicas del plan de desarrollo --Metas sin avances
     * @access public
     */
    
    public function lineaSinAvances ( $codigoCarrera ){
        $linea = array ();
        $sql = "SELECT
                    LineaEstrategicaId,
                    NombreLineaEstrategica 
                FROM
                    ViewPlanReporteFaltantes 
                WHERE
                    CodigoCarrera = ? 
                GROUP BY
                    LineaEstrategicaId ";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        //echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setLineaEstrategicaId( $this->persistencia->getParametro( "LineaEstrategicaId" ) );
            $viewPlanDiferencia->setNombreLineaEstrategica( $this->persistencia->getParametro( "NombreLineaEstrategica" ) );
            $linea[]=$viewPlanDiferencia;
        }
        return $linea;
    }
    /**
     * Consulta los  programas del plan de desarrollo --Metas sin avances
     * @access public
     */
     
    public  function programaSinAvances( $codigoCarrera , $linea ){
        $programa = array ();
        $sql ="SELECT
                ProgramaPlanDesarrolloId,
                NombrePrograma 
            FROM
                ViewPlanReporteFaltantes 
            WHERE
                Codigocarrera = ? 
                AND LineaEstrategicaId = ?
            GROUP BY
                ProgramaPlanDesarrolloId,
                NombrePrograma";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        //echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
             $viewPlanDiferencia = new ViewPlanDiferencia ( null );
             $viewPlanDiferencia->setProgramaPlanDesarrolloId( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
             $viewPlanDiferencia->setNombrePrograma( $this->persistencia->getParametro( "NombrePrograma" ) );
             $programa[] = $viewPlanDiferencia;
        }
        return $programa;
    }
     /**
     * Consulta los  proyectos del plan de desarrollo --Metas sin avances
     * @access public
     */
    
    public function proyectoSinAvances ( $codigoCarrera , $linea , $programa ){
         $proyecto = array ();
         $sql = "SELECT
                    ProyectoPlanDesarrolloId,
                    NombreProyectoPlanDesarrollo 
                FROM
                    ViewPlanReporteFaltantes 
                WHERE
                    Codigocarrera = ? 
                    AND LineaEstrategicaId = ? 
                    AND ProgramaPlanDesarrolloId = ? 
                GROUP BY
                    ProyectoPlanDesarrolloId,
                    NombreProyectoPlanDesarrollo";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
       // echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
            $viewPlanDiferencia->setNombreProyectoPlanDesarrollo( $this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" ) );
            $proyecto[] = $viewPlanDiferencia;
        }
        return $proyecto;
    }
     /**
     * Consulta los  indicadores  del plan de desarrollo --Metas sin avances
     * @access public
     */
    
    public function indicadorSinAvances ( $codigoCarrera , $linea , $programa ,$proyecto ){
        $indicador = array();
        $sql = "SELECT
            IndicadorPlanDesarrolloId,
            indicador 
        FROM
            ViewPlanReporteFaltantes 
        WHERE
            Codigocarrera = ? 
            AND LineaEstrategicaId = ? 
            AND ProgramaPlanDesarrolloId = ?
            AND ProyectoPlanDesarrolloId = ?
        GROUP BY 
            IndicadorPlanDesarrolloId,
            indicador ";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
        $this->persistencia->setParametro( 3 , $proyecto, false );
       // echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
            $viewPlanDiferencia->setIndicador( $this->persistencia->getParametro( "indicador" ) );
            $indicador[] = $viewPlanDiferencia; 
        }
        return $indicador;
    }
     /**
     * Consulta las  metas del plan de desarrollo --Metas sin avances
     * @access public
     */
    
    public function metaSinAvances ( $codigoCarrera , $linea , $programa ,$proyecto , $indicador ){
       $meta = array ();
       $sql = "SELECT
                    NombreMetaPlanDesarrollo,
                    AlcanceMeta                    
                FROM
                    ViewPlanReporteFaltantes 
                WHERE
                    Codigocarrera = ? 
                    AND LineaEstrategicaId = ? 
                    AND ProgramaPlanDesarrolloId = ?
                    AND ProyectoPlanDesarrolloId = ?
                    AND IndicadorPlanDesarrolloId = ?";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
        $this->persistencia->setParametro( 3 , $proyecto, false );
        $this->persistencia->setParametro( 4 , $indicador, false );
       // echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setMeta( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) );
            $viewPlanDiferencia->setAlcanceMeta($this->persistencia->getParametro( "AlcanceMeta" ));
            $meta[] = $viewPlanDiferencia;
        }
        return $meta;
    }
    /**
     * Consulta las  lineas estrategicas del plan de desarrollo --Metas con diferencia en el alacance  con respecto a los avances
     * @access public
     */
    
    public function lineaDiferencia ( $codigoCarrera ){
        $linea = array ();
        $sql = "SELECT
                    LineaEstrategicaId,
                    NombreLineaEstrategica 
                FROM
                    ViewPlanReporteDiferencia 
                WHERE
                    CodigoCarrera = ? 
                GROUP BY
                    LineaEstrategicaId ";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        //echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setLineaEstrategicaId( $this->persistencia->getParametro( "LineaEstrategicaId" ) );
            $viewPlanDiferencia->setNombreLineaEstrategica( $this->persistencia->getParametro( "NombreLineaEstrategica" ) );
            $linea[]=$viewPlanDiferencia;
        }
        return $linea;
    }
    /**
     * Consulta los programs del plan de desarrollo --Metas con diferencia en el alacance  con respecto a los avances
     * @access public
     */
    public  function programaDiferencia( $codigoCarrera , $linea ){
        $programa = array ();
        $sql ="SELECT
                ProgramaPlanDesarrolloId,
                NombrePrograma 
            FROM
                ViewPlanReporteDiferencia 
            WHERE
                Codigocarrera = ? 
                AND LineaEstrategicaId = ?
            GROUP BY
                ProgramaPlanDesarrolloId,
                NombrePrograma";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        //echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
             $viewPlanDiferencia = new ViewPlanDiferencia ( null );
             $viewPlanDiferencia->setProgramaPlanDesarrolloId( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
             $viewPlanDiferencia->setNombrePrograma( $this->persistencia->getParametro( "NombrePrograma" ) );
             $programa[] = $viewPlanDiferencia;
        }
        return $programa;
    }
    /**
     * Consulta los proyectos del plan de desarrollo --Metas con diferencia en el alacance  con respecto a los avances
     * @access public
     */
    public function proyectoDiferencia( $codigoCarrera , $linea , $programa ){
         $proyecto = array ();
         $sql = "SELECT
                    ProyectoPlanDesarrolloId,
                    NombreProyectoPlanDesarrollo 
                FROM
                    ViewPlanReporteDiferencia 
                WHERE
                    Codigocarrera = ? 
                    AND LineaEstrategicaId = ? 
                    AND ProgramaPlanDesarrolloId = ? 
                GROUP BY
                    ProyectoPlanDesarrolloId,
                    NombreProyectoPlanDesarrollo";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
       // echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
            $viewPlanDiferencia->setNombreProyectoPlanDesarrollo( $this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" ) );
            $proyecto[] = $viewPlanDiferencia;
        }
        return $proyecto;
    }
     /**
     * Consulta los indicadores  del plan de desarrollo --Metas con diferencia en el alacance  con respecto a los avances
     * @access public
     */   
    public function indicadorDiferencia( $codigoCarrera , $linea , $programa ,$proyecto ){
        $indicador = array();
        $sql = "SELECT
            IndicadorPlanDesarrolloId,
            indicador 
        FROM
            ViewPlanReporteDiferencia 
        WHERE
            Codigocarrera = ? 
            AND LineaEstrategicaId = ? 
            AND ProgramaPlanDesarrolloId = ?
            AND ProyectoPlanDesarrolloId = ?
        GROUP BY 
            IndicadorPlanDesarrolloId,
            indicador ";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
        $this->persistencia->setParametro( 3 , $proyecto, false );
       // echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
            $viewPlanDiferencia->setIndicador( $this->persistencia->getParametro( "indicador" ) );
            $indicador[] = $viewPlanDiferencia; 
        }
        return $indicador;
    }
    /**
     * Consulta las  metas del plan de desarrollo --Metas con diferencia en el alacance  con respecto a los avances
     * @access public
     */
    public function metaDiferencia( $codigoCarrera , $linea , $programa ,$proyecto , $indicador ){
       $meta = array ();
       $sql = "SELECT
                    NombreMetaPlanDesarrollo,
                    AlcanceMeta,
                    diferencia
                FROM
                    ViewPlanReporteDiferencia 
                WHERE
                    Codigocarrera = ? 
                    AND LineaEstrategicaId = ? 
                    AND ProgramaPlanDesarrolloId = ?
                    AND ProyectoPlanDesarrolloId = ?
                    AND IndicadorPlanDesarrolloId = ?";
        $this->persistencia->crearSentenciaSQL( $sql );
        $this->persistencia->setParametro( 0 , $codigoCarrera , false );
        $this->persistencia->setParametro( 1 , $linea, false );
        $this->persistencia->setParametro( 2 , $programa, false );
        $this->persistencia->setParametro( 3 , $proyecto, false );
        $this->persistencia->setParametro( 4 , $indicador, false );
       //echo $this->persistencia->getSQLListo( ).'<br>';
        $this->persistencia->ejecutarConsulta( );
        while( $this->persistencia->getNext( ) ){
            $viewPlanDiferencia = new ViewPlanDiferencia ( null );
            $viewPlanDiferencia->setMeta( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) );
            $viewPlanDiferencia->setAlcanceMeta($this->persistencia->getParametro( "AlcanceMeta" ) );
            $viewPlanDiferencia->setDiferencia( $this->persistencia->getParametro( "diferencia" ) );
            $meta[] = $viewPlanDiferencia;
        }
        return $meta;
    }
}

?>