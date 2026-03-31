<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 

class MenusPlandesarrollo{
	/**
	 * @type string
	 * @access private
	 */
	private $codigoFacultad;
	/**
	 * @type string
	 * @access private
	 */
	private $nombreFacultad;
	/**
	 * @type int
	 * @access private
	 */
	private $codigoCarrera;
	/**
	 * @type string
	 * @access private
	 */
	private $nombreCarrera;
	/**
	 * @type int
	 * @access private
	 */
	private $lineaEstrategicaId;
	/**
	 * @type string
	 * @access private
	 */
	private $nombreLineaEstrategica;
	/**
	 * @type string
	 * @access private
	 */
	private $descripcionLineaEstrategica;
	/**
	 * @type string
	 * @access private
	 */
	private $estadoLineaEstrategica;
	/**
	 * @type string
	 * @access private
	 */
	private $programaPlanDesarrolloId;
	/**
	 * @type string
	 * @access private
	 */
	private $nombrePrograma;
	/**
	 * @type string
	 * @access private
	 */
	private $justificacionProgramaPlanDesarrollo;
	/**
	 * @type string
	 * @access private
	 */
	private $estadoProgramaPlanDesarrollo;
  	/**
	 * @type int
	 * @access private
	 */
  	private $proyectoPlanDesarrolloId;
	/**
	 * @type string
	 * @access private
	 */
	private $nombreProyectoPlanDesarrollo;
	/**
	 * @type string
	 * @access private
	 */
	private $estadoProyectoPlanDesarrollo;
	/**
	 * @type string
	 * @access private
	 */
	private $justificacionProyecto;
	/**
	 * @type string
	 * @access private
	 */
	private $accionProyecto;
	/**
	 * @type string
	 * @access private
	 */
	private $responsableProyecto;
	/**
	 * @type Singleto
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
public function MenusPlandesarrollo( $persistencia ){
	 	$this->persistencia = $persistencia;	
	 }
	/**
	 * Modifica el codigo de la facultad
	 * @access public
	 * @return void
	 */
public function setCodigoFacultad( $CodigoFacultad ){
	$this->codigoFacultad = $CodigoFacultad;	
	}	
	/**
	 * Retorna el codigo de la facultad
	 * @param string $codigoFacultdad
	 * @access public
	 * @return string
	 */
public function getCodigoFacultad( ){
	return $this->codigoFacultad;
	}
	/**
	 * Modifica el Nombre de la facultad
	 * @access public
	 * @return void
	 */	
public function setNombreFacultad( $nombreFacultad ){
	$this->nombreFacultad = $nombreFacultad;
	}	
	/**
	 * Retorna el nombre de la facultad
	 * @param string $nombreFacultdad
	 * @access public
	 * @return string
	 */

public function getNombreFacultad( ){
	return $this->nombreFacultad;
	}
	/**
	 * Modifica el codigo de la carrera
	 * @access public
	 * @return void
	 */	
public function setCodigoCarrera( $codigoCarrera ){
	$this->codigoCarrera = $codigoCarrera;
	}
	/**
	 * Retorna el codigo de la carrera
	 * @param int $codigoCarrera
	 * @access public
	 * @return int
	 */
public function getCodigoCarrera( ){
	return $this->codigoCarrera;
	}
	 /**
	 * Modifica el nombre de la carrera
	 * @access public
	 * @return void
	 */	
public function setNombreCarrera( $nombreCarrera ){
	$this->nombreCarrera = $nombreCarrera;
	}
	/**
	 * Retorna el nombre de la carrera
	 * @param string $nombreCarrera
	 * @access public
	 * @return string
	 */
public function getnombreCarrera( ){
	return $this->nombreCarrera;
	}
 	/**
	 * Modifica la lineaEstrategicaId
	 * @access public
	 * @return void
	 */	
public function setLineaEstrategicaId( $lineaEstrategicaId ){
	$this->lineaEstrategicaId = $lineaEstrategicaId;
	}	
	/**
	 * Retorna el lineaEstrategicaId
	 * @param int $lineaEstrategicaId
	 * @access public
	 * @return int
	 */
public function getLineaEstrategicaId( ){
	return $this->lineaEstrategicaId;
	}
	/**
	 * Modifica NombreLineaEstrategica
	 * @access public
	 * @return void
	 */	
public function setNombreLineaEstrategica( $nombreLineaEstrategica ){
	$this->nombreLineaEstrategica = $nombreLineaEstrategica;
	}
	/**
	 * Retorna NombreLineaEstrategica
	 * @param string $nombreLineaEstrategica 
	 * @access public
	 * @return string
	 */
public function getNombreLineaEstrategica( ){
	return $this->nombreLineaEstrategica;
	}
	/**
	 * Modifica DescripcionLineaEstrategica
	 * @access public
	 * @return void
	 */	
public function setDescripcionLineaEstrategica( $descripcionLineaEstrategica ){
	$this->descripcionLineaEstrategica = $descripcionLineaEstrategica;
	}
	/**
	 * Retorna descripcionEstrategica
	 * @param string $nombreLineaEstrategica 
	 * @access public
	 * @return string
	 */
public function getDescripcionLineaEstrategica( ){
	return $this->descripcionLineaEstrategica;
	}
	/**
	 * Modifica estadoLineaEstrategica
	 * @access public
	 * @return void
	 */	
public function setEstadoLineaEstrategica( $estadoLineaEstrategica ){
	$this->estadoLineaEstrategica = $estadoLineaEstrategica;
	}
	/**
	 * Retorna estadoLineastrategica
	 * @param string $nombreLineaEstrategica 
	 * @access public
	 * @return string
	 */
public function getEstadoLineaEstrategica( ){
	return $this->estadoLineaEstrategica;
	}
	/**
	 * Modifica ProgramaPlanDesarrolloId 
	 * @access public
	 * @return void
	 */	
public function setProgramaPlanDesarrolloId( $programaPlanDesarrolloId ){
	$this->programaPlanDesarrolloId = $programaPlanDesarrolloId;
	}
	/**
	 * Retorna ProgramaPlanDesarrolloId
	 * @param int $nombreLineaEstrategica 
	 * @access public
	 * @return int
	 */
public function getProgramaPlanDesarrolloId( ){
	return $this->programaPlanDesarrolloId;
	}
	/**
	 * Modifica NombrePrograma
	 * @access public
	 * @return void
	 */	
public function setNombrePrograma( $nombrePrograma ){
	$this->nombrePrograma = $nombrePrograma;
	}
	/**
	 * Retorna NombrePrograma
	 * @param string  $nombrePrograma 
	 * @access public
	 * @return string
	 */
public function getNombrePrograma( ){
	return $this->nombrePrograma;
	}
	/**
	 * Modifica JustificacionProgramaPlanDesarrollo
	 * @access public
	 * @return void
	 */
public function setJustificacionProgramaPlanDesarrollo( $justificacionProgramaPlanDesarrollo ){
	$this->justificacionProgramaPlanDesarrollo = $justificacionProgramaPlanDesarrollo;
	}
	/**
	 * Retorna JustificacionProgramaPlanDesarrollo
	 * @param string  $justificacionProgramaPlanDesarrollo 
	 * @access public
	 * @return string
	 */
public function getJustificacionProgramaPlanDesarrollo( ){
	return $this->justificacionProgramaPlanDesarrollo;
	}
	/**
	 * Modifica EstadoProgramaPlanDesarrollo
	 * @access public
	 * @return void
	 */
public function setEstadoProgramaPlanDesarrollo( $estadoProgramaPlanDesarrollo ){
	$this->estadoProgramaPlanDesarrollo = $estadoProgramaPlanDesarrollo;
	}
	/**
	 * Retorna EstadoProgramaPlanDesarrollo
	 * @param string  $estadoProgramaPlanDesarrollo
	 * @access public
	 * @return string
	 */
public function getEstadoProgramaPlanDesarrollo(){
	return $this->estadoProgramaPlanDesarrollo;
	}
	/**
	 * Modifica ProyectoPlanDesarrolloId
	 * @access public
	 * @return void
	 */
public function setProyectoPlanDesarrolloId( $proyectoPlanDesarrolloId){
	$this->proyectoPlanDesarrolloId = $proyectoPlanDesarrolloId;
	}
	/**
	 * Retorna ProyectoPlanDesarrolloId
	 * @param int $proyectoPlanDesarrolloId
	 * @access public
	 * @return int
	 */
public function getProyectoPlanDesarrolloId( ){
	return $this->proyectoPlanDesarrolloId;
	}
	/**
	 * Modifica NombreProyectoPlanDesarrollo
	 * @access public
	 * @return void
	 */
public function setNombreProyectoPlanDesarrollo( $nombreProyectoPlanDesarrollo ){
	$this->nombreProyectoPlanDesarrollo = $nombreProyectoPlanDesarrollo;
	}
	/**
	 * Retorna NombreProyectoPlanDesarrollo
	 * @param int $nombreProyectoPlanDesarrollo
	 * @access public
	 * @return int
	 */
public function getNombreProyectoPlanDesarrollo( ){
	return $this->nombreProyectoPlanDesarrollo;
	}
	/**
	 * Modifica estadoProyectoPlanDesarrollo
	 * @access public
	 * @return void
	 */
public function setEstadoProyectoPlanDesarrollo( $estadoProyectoPlanDesarrollo ){
	$this->estadoProyectoPlanDesarrollo = $estadoProyectoPlanDesarrollo;
	}
	/**
	 * Retorna estado ProyectoPlanDesarrollo
	 * @param string $estadoProyectoPlanDesarrollo
	 * @access public
	 * @return string
	 */
public function getEstadoProyectoPlanDesarrollo( ){
	return $this->estadoProyectoPlanDesarrollo;
	}
	/**
	 * Modifica justificacionProyecto
	 * @access public
	 * @return void
	 */
public function setJustificacionProyecto( $justificacionProyecto ){
	$this->justificacionProyecto = $justificacionProyecto;
	}
	/**
	 * Retorna justificaiconproyecto
	 * @param string justificaiconproyecto
	 * @access public
	 * @return string
	 */
public function getJustificacionProyecto( ){
	return $this->justificacionProyecto;
	}
	/**
	 * Modifica jaccionproyecto
	 * @access public
	 * @return void
	 */
public function setAccionProyecto( $accionProyecto ){
	$this->accionProyecto = $accionProyecto;
	}
	/**
	 * Retorna accionproyecto
	 * @param string $accionproyecto
	 * @access public
	 * @return string
	 */
public function getAccionProyecto( ){
	return $this->accionProyecto;
	}
	/**
	 * Modifica responsableproyecto
	 * @access public
	 * @return void
	 */
public function setResponsableProyecto( $responsableProyecto ){
	$this->responsableProyecto = $responsableProyecto;
	}
	/**
	 * Retorna responsableproyecto
	 * @param string $responsableproyecto
	 * @access public
	 * @return string
	 */
public function getResponsableProyecto( ){
	return $this->responsableProyecto;
	}

public function menusPlan( $facultad , $rol ){
	$menu = array( );
	$inner='';
	$where = array();
	$params = array();

	if( !empty( $facultad ) ){
        if ( $facultad == 10  or $rol == 89  or $rol == 101) {
            $where[] = "f.codigoestado = 100 AND p.CodigoCarrera <> ''";
        } else {
            $where[] = "f.codigoestado = 100 AND p.CodigoCarrera <> '' and p.CodigoFacultad = ?";
            $objParam = new stdClass();
            $objParam->value = $facultad;
            $objParam->text = true;
            $params[0] = $objParam;
            unset($objParam);
        }
	} else if ( $rol == 3 or $rol == 89 ) {
		$where[] = "f.codigoestado = 100 AND p.CodigoCarrera <> ''";
	}
	
	$sql = "SELECT p.CodigoFacultad as codigofacultad, LCASE(f.nombrefacultad) as nombrefacultad ".
		" FROM PlanDesarrollo p ".
		" LEFT JOIN facultad f ON ( p.CodigoFacultad = f.CodigoFacultad )";
	$sql.= 'WHERE '.$where[0];
	$sql.= 'GROUP BY  p.CodigoFacultad,f.nombrefacultad';

	if( $rol == 101 or $rol == 96 ){
        $sql.=" UNION ".
	    " ( SELECT CodigoFacultad AS codigofacultad, NombrePlanDesarrollo AS nombrefacultad".
        " FROM PlanDesarrollo WHERE CodigoFacultad = 10000 )";
    }
	$this->persistencia->crearSentenciaSQL( $sql );
	if( !empty ( $params ) ){
        foreach ( $params as $k=>$v ){
            $this->persistencia->setParametro( $k, $v->value, $v->text );
        }
    }
	$this->persistencia->ejecutarConsulta( );

	while( $this->persistencia->getNext( ) ){
        $menus = new MenusPlandesarrollo($this->persistencia);
        $menus->setCodigoFacultad($this->persistencia->getParametro('codigofacultad'));
        $menus->setNombreFacultad($this->persistencia->getParametro('nombrefacultad'));

        $menu[] = $menus;
	}	
	$this->persistencia->freeResult( );	 
	return $menu;
}


public function menucarrera( $idFacultad ){
	$menu = array( );
	
	 
		/*
		 * @modified Diego Rivera <riveradiego@unbosque.edu.co>
		 * se realiza cambio en consulta sql afecta  menu de programas academicos del modulo gestion del plan de desarrollo  esto con el fin
		 * de que permita ver los planes de desarrollo de las facultades
		 * @since  march 08, 2017
		*/
                /*@modified Diego RIvera<riveradiego@unbosque.edu.co>
                   *Se modifica consulta  se añade modalidad academica 500 y codigocarrera not in 2,3
                   *@Since Septembre 18,2018  
                   */
	
	$sql="
	SELECT
			pd.CodigoCarrera as codigocarrera,
			LCASE(pd.NombrePlanDesarrollo) as nombrecarrera
	FROM
			PlanDesarrollo pd
	WHERE
			pd.CodigoCarrera = pd.CodigoFacultad
			AND pd.codigofacultad = ?
			
	UNION
			
	SELECT
			C.codigocarrera,
			LCASE(C.nombrecarrera)as nombrecarrera
	FROM
			carrera C
	INNER JOIN facultad F ON (
			C.codigofacultad = F.codigofacultad
				)
	INNER JOIN PlanDesarrollo p ON (
			p.CodigoCarrera = C.codigocarrera
			)
	WHERE
		F.codigofacultad = ?
			AND C.codigomodalidadacademica IN (200,500)
			AND C.codigocarrera NOT IN (354, 124, 119, 140, 134,2,3)";	
	
	//fin modificacion
	
	$this->persistencia->crearSentenciaSQL( $sql );
	$this->persistencia->setParametro( 0, $idFacultad ,true );	
 	$this->persistencia->setParametro( 1, $idFacultad ,true );	
	$this->persistencia->ejecutarConsulta( );

	
	while( $this->persistencia->getNext( ) ){
		$menus = new MenusPlandesarrollo($this->persistencia);	
		$menus->setCodigoCarrera($this->persistencia->getParametro('codigocarrera'));
		$menus->setNombreCarrera($this->persistencia->getParametro('nombrecarrera'));
					
		$menu[] = $menus;
		
		}	
	//echo $this->persistencia->getSQLListo( );
	$this->persistencia->freeResult( );	 
	
	return $menu;
}


public function menulinea( $codigoFacultad , $codigoCarrera ){
	$menu = array( );
	
	/*
	 * @modified Diego Rivera <riveradiego@unbosque.edu.co>
	 * se realiza cambio en consulta sql afecta  menu de linea estrategica  del modulo gestion del plan de desarrollo 
	 * @since  march 08, 2017
	*/
	
	$sql="
	SELECT
		Lne.LineaEstrategicaId AS LineaEstrategicaId,
		LCASE(Lne.NombreLineaEstrategica) AS NombreLineaEstrategica
	FROM
		LineaEstrategica Lne
	INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON (
		pdple.LineaEstrategicaId = Lne.LineaEstrategicaId
	)
	INNER JOIN ProgramaPlanDesarrollo ppd ON (
		ppd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
	)
	INNER JOIN PlanDesarrollo p ON (
		p.PlanDesarrolloId = pdple.PlanDesarrolloId
	)
	INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (
		pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
	)
	INNER JOIN ProyectoPlanDesarrollo ppdy ON (
		ppdy.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
	)
	WHERE
		p.CodigoFacultad = ?
	AND p.CodigoCarrera = ?
	GROUP BY
		p.codigofacultad,
		p.codigocarrera,
		Lne.LineaEstrategicaId
	";
	
	// fin modificacion
	$this->persistencia->crearSentenciaSQL( $sql );
	$this->persistencia->setParametro( 0, $codigoFacultad ,true );	
	$this->persistencia->setParametro( 1, $codigoCarrera ,true );	
	
	$this->persistencia->ejecutarConsulta( );

	
	while( $this->persistencia->getNext( ) ){
		$menus = new MenusPlandesarrollo($this->persistencia);	
		$menus->setLineaEstrategicaId($this->persistencia->getParametro('LineaEstrategicaId'));
		$menus->setNombreLineaEstrategica($this->persistencia->getParametro('NombreLineaEstrategica'));
					
		$menu[] = $menus;
		
		}	
	//echo $this->persistencia->getSQLListo( );
	$this->persistencia->freeResult( );	 
	
	return $menu;
}


public function menuPrograma( $codigoFacultad , $codigoCarrera , $lineaEstrategica ){
	$menu = array( );
        /*
         * Parametro EstadoProgramaPlanDesarrollo=100
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 19 de Septiembre de 2017.
         */
	/*
	 * @modified Diego Rivera <riveradiego@unbosque.edu.co>
	 * se realiza cambio en consulta sql afecta  menu de programa  del modulo gestion del plan de desarrollo 
	 * @since  march 08, 2017
	*/
	
	$sql="
		SELECT
			ppd.ProgramaPlanDesarrolloId AS ProgramaPlanDesarrolloId,
			LCASE(ppd.NombrePrograma) AS NombrePrograma
		FROM
			ProgramaPlanDesarrollo ppd
		INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON (
			pdple.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
		)
		INNER JOIN LineaEstrategica Lne ON (
			Lne.LineaEstrategicaId = pdple.LineaEstrategicaId
		)
		INNER JOIN PlanDesarrollo p ON (
			p.PlanDesarrolloId = pdple.PlanDesarrolloId
		)
		INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (
			pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
		)
		INNER JOIN ProyectoPlanDesarrollo ppdy ON (
			ppdy.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
		)
		WHERE
			p.CodigoFacultad = ?
		AND p.CodigoCarrera = ?
		AND Lne.LineaEstrategicaId = ?
                AND ppd.EstadoProgramaPlanDesarrollo='100'
		GROUP BY
			p.codigofacultad,
			p.codigocarrera,
			Lne.LineaEstrategicaId,
			ppd.ProgramaPlanDesarrolloId
		";
		//fin modificacion
		//end
	$this->persistencia->crearSentenciaSQL( $sql );
	$this->persistencia->setParametro( 0, $codigoFacultad ,true );	
	$this->persistencia->setParametro( 1, $codigoCarrera ,true );	
	$this->persistencia->setParametro( 2, $lineaEstrategica ,true );	
	
	$this->persistencia->ejecutarConsulta( );

	
	while( $this->persistencia->getNext( ) ){
		$menus = new MenusPlandesarrollo($this->persistencia);	
		$menus->setProgramaPlanDesarrolloId($this->persistencia->getParametro('ProgramaPlanDesarrolloId'));
		$menus->setNombrePrograma($this->persistencia->getParametro('NombrePrograma'));
					
		$menu[] = $menus;
		
		}	
	//echo $this->persistencia->getSQLListo( );
	$this->persistencia->freeResult( );	 
	
	return $menu;
}

public function menuProyecto( $codigoFacultad , $codigoCarrera , $lineaEstrategica , $programa){
	$menu = array();
	
	/*
	 * @modified Diego Rivera <riveradiego@unbosque.edu.co>
	 * se realiza cambio en consulta sql afecta  menu de proyecto   del modulo gestion del plan de desarrollo  se agrega union en sql para traer los proyectos
	 * asociados a los planes de desarrollo de las facultades 
	 * @since  march 08, 2017
	*/
	 /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
          * se añade EstadoProyectoPlanDesarrollo = 100 en consulta sql
          *@since october 31,2018
          */
	
        $sql ="
          SELECT
                        ppd.ProyectoPlanDesarrolloId AS ProyectoPlanDesarrolloId,
                        ppd.NombreProyectoPlanDesarrollo AS NombreProyectoPlanDesarrollo,
                        Lne.NombreLineaEstrategica,
                        pd.NombrePrograma AS NombrePrograma,
                        ppd.NombreProyectoPlanDesarrollo,
                        LCASE(F.nombrefacultad) AS nombrefacultad,
                        LCASE(C.nombrecarrera) AS nombrecarrera
                FROM
                        facultad F
                JOIN carrera C ON C.codigofacultad = F.codigofacultad
                JOIN PlanDesarrollo p ON p.CodigoCarrera = C.codigocarrera
                AND p.CodigoFacultad = F.codigofacultad
                JOIN PlanDesarrolloProgramaLineaEstrategica pdle ON p.PlanDesarrolloId = pdle.PlanDesarrolloId
                JOIN LineaEstrategica Lne ON pdle.LineaEstrategicaId = Lne.LineaEstrategicaId
                JOIN ProgramaPlanDesarrollo pd ON pdle.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId
                JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId
                JOIN ProyectoPlanDesarrollo ppd ON pppd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
                AND pd.ProgramaPlanDesarrolloId = pppd.ProgramaPlanDesarrolloId
                WHERE
                        F.codigoestado = 100
                AND F.codigofacultad = ?
                AND C.codigocarrera = ?
                AND C.codigomodalidadacademica in ( 200, 500 )
                AND Lne.LineaEstrategicaId =?
                AND pd.ProgramaPlanDesarrolloId = ?
                AND ppd.EstadoProyectoPlanDesarrollo=100
                GROUP BY
                        F.codigofacultad,
                        C.CodigoCarrera,
                        Lne.LineaEstrategicaId,
                        pd.ProgramaPlanDesarrolloId,
                        ppd.ProyectoPlanDesarrolloId
                UNION
                        SELECT
                                ppd.ProyectoPlanDesarrolloId AS ProyectoPlanDesarrolloId,
                                ppd.NombreProyectoPlanDesarrollo AS NombreProyectoPlanDesarrollo,
                                Lne.NombreLineaEstrategica,
                                pd.NombrePrograma AS NombrePrograma,
                                ppd.NombreProyectoPlanDesarrollo,
                                LCASE(F.nombrefacultad) AS nombrefacultad,
                                LCASE(p.NombrePlanDesarrollo) AS nombrecarrera
                        FROM
                                PlanDesarrollo p
                        LEFT JOIN facultad F ON p.CodigoFacultad = F.codigofacultad
                        INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdle ON p.PlanDesarrolloId = pdle.PlanDesarrolloId
                        INNER JOIN LineaEstrategica Lne ON Lne.LineaEstrategicaId = pdle.LineaEstrategicaId
                        INNER JOIN ProgramaPlanDesarrollo pd ON pdle.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId
                        INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId
                        INNER JOIN ProyectoPlanDesarrollo ppd ON pppd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
                        AND pd.ProgramaPlanDesarrolloId = pppd.ProgramaPlanDesarrolloId
                        WHERE
                            
                        p.codigofacultad = ?
                        AND p.codigocarrera = ?
                        AND Lne.LineaEstrategicaId =?
                        AND pd.ProgramaPlanDesarrolloId = ?
                        AND p.CodigoCarrera = p.CodigoFacultad
                        AND ppd.EstadoProyectoPlanDesarrollo=100
                        GROUP BY
                                F.codigofacultad,
                                p.CodigoCarrera,
                                Lne.LineaEstrategicaId,
                                pd.ProgramaPlanDesarrolloId,
                                ppd.ProyectoPlanDesarrolloId

			";
	
	 //fin modificacion
	 
	 
	$this->persistencia->crearSentenciaSQL( $sql );
	$this->persistencia->setParametro( 0, $codigoFacultad ,true );	
	$this->persistencia->setParametro( 1, $codigoCarrera ,false );	
	$this->persistencia->setParametro( 2, $lineaEstrategica ,false );
	$this->persistencia->setParametro( 3, $programa ,false );	
	$this->persistencia->setParametro( 4, $codigoFacultad ,true );	
	$this->persistencia->setParametro( 5, $codigoCarrera ,false );	
	$this->persistencia->setParametro( 6, $lineaEstrategica ,false );
	$this->persistencia->setParametro( 7, $programa ,false );	
	
	$this->persistencia->ejecutarConsulta( );	
       // echo $this->persistencia->getSQLListo( );
        
	$this->persistencia->getSQLListo( );
		while( $this->persistencia->getNext( ) ){
		$menus = new MenusPlandesarrollo($this->persistencia);	
		$menus->setProyectoPlanDesarrolloId($this->persistencia->getParametro('ProyectoPlanDesarrolloId'));
		$menus->setNombreProyectoPlanDesarrollo($this->persistencia->getParametro('NombreProyectoPlanDesarrollo'));
		$menus->setNombreLineaEstrategica($this->persistencia->getParametro('NombreLineaEstrategica'));
		$menus->setNombrePrograma($this->persistencia->getParametro('NombrePrograma'));
		$menus->setNombreProyectoPlanDesarrollo($this->persistencia->getParametro('NombreProyectoPlanDesarrollo'));			
		$menus->setNombreFacultad($this->persistencia->getParametro('nombrefacultad'));	
		$menus->setNombreCarrera($this->persistencia->getParametro('nombrecarrera'));	
		$menu[] = $menus;
			
			}
		
	return $menu;
	}

}

?>