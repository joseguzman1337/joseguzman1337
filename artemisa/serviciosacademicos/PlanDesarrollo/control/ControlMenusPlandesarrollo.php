<?php
    /**
     * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
     * @copyright Dirección de Tecnología Universidad el Bosque
     * @package control
     * @since febrero  15, 2017
     */ 
    include('../entidades/MenusPlandesarrollo.php');
     
    class ControlMenusPlandesarrollo{
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
	public function ControlMenusPlandesarrollo( $persistencia ){
		$this->persistencia = $persistencia;
	}
		/*
		 * @ Diego Rivera <riveradiego@unbosque.edu.co>
		 * funcion carga menu de facultades
		 * @since  march 08, 2017
		*/
	public function  menufacultad( ){
					
		if( isset ( $_SESSION["datoSesion"] ) ){
			$user = $_SESSION["datoSesion"];
			$idPersona = $user[ 0 ];
			$luser = $user[ 1 ];
			$lrol = $user[3];
			$txtCodigoFacultad = $user[4];
			$persistencia = new Singleton( );
			$persistencia = $persistencia->unserializar( $user[ 5 ] );
			$persistencia->conectar( );
		}else{
			header("Location:error.php");
		}
		
	
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menusplan( $txtCodigoFacultad ,$lrol);
				
		$idFacultad = 0;
		$html = "<ul class='navbar navbar-default nav '>";
			foreach ($menus as $menu){
				$html.= "<li><a href='#facultades_$idFacultad' data-toggle='collapse' class='ln restaurar'>";
					$html.=  ucwords(strtolower ($menu->getNombreFacultad()));	
					$html.=" <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
					$html.= $this->menucarrera( $menu->getCodigoFacultad() , $idFacultad );
				$html.= "</li>";
			
			$idFacultad++;
				}
		$html.="</ul>";
		
		return $html;	
	}
		//consulta de menus para reportes 
		public function menusfacultad($txtCodigoFacultad, $lrol)
		{
			$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
			$menus = $menuPlanDesarrollo->menusplan( $txtCodigoFacultad ,$lrol);
			
			return $menus;
		}
	/*
		 * @ Diego Rivera <riveradiego@unbosque.edu.co>
		 * funcion carga menu de carreras
		 * @since  march 08, 2017
		*/
	public function menucarrera( $codigoFacultad , $idFacultad ){
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menucarrera( $codigoFacultad );
		$html = "<ul class='nav collapse' id='facultades_$idFacultad'>";
		$idCarrera = 0;
			foreach ($menus as $menu){
				$idcarreas='carreras_'.$codigoFacultad.$idFacultad.$idCarrera;
				$carrera=$menu->getNombreCarrera();
				$codigoCarrera=$menu->getCodigoCarrera();
				$html.= "<li><a href='#carreras_$codigoFacultad$idFacultad$idCarrera' data-toggle='collapse' class='ln restaurar'>";
					$html.=  ucwords(strtolower ($carrera));	
					$html.=" <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
					$html.= $this->menuLinea($codigoFacultad, $menu->getCodigoCarrera() , $idcarreas );
					
				$html.= "</li>";
			$idCarrera++;	
			}
		$html.="</ul>";
		
		return $html;	
	}
	
	public function verCarrera($CodigoFacultad){
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menucarrera( $CodigoFacultad );
		return $menus;

		
	}
	/*
		 * @ Diego Rivera <riveradiego@unbosque.edu.co>
		 * funcion carga menu de lineas estrategica
		 * @since  march 08, 2017
		*/
	public function menuLinea( $codigoFacultad , $codigoCarrera , $idCarreras ){
			
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menulinea( $codigoFacultad , $codigoCarrera );
		$existencia = count( $menus );
		$html ="<ul class='nav collapse' id='$idCarreras' ><li><a href='#linea$idCarreras' data-toggle='collapse' class='ln restaurar'>Línea estratégica <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
		
		if( $existencia>0 ){
		$html.= "<ul class='nav collapse' id='linea$idCarreras'>";
			$idLineaDetalle = 0;
			foreach ($menus as $menu){
			$idLineas='lineadetalle'.$idCarreras.$idLineaDetalle;
				$html.= "<li><a href='#lineadetalle$idCarreras$idLineaDetalle' data-toggle='collapse' class='ln restaurar'>";
						$html.= ucwords(strtolower ($menu->getNombreLineaEstrategica ()));	
						$html.=" <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
						$html.=$this->menuPrograma($codigoFacultad, $codigoCarrera, $menu->getLineaEstrategicaId () , $idLineas);				
				$html.= "</li>";
			$idLineaDetalle++;
				}
		$html.="</ul>";
		}
		 $html.="</li></ul>";
		return $html;	
	}
	
	/*
		 * @ Diego Rivera <riveradiego@unbosque.edu.co>
		 * funcion carga menu programa
		 * @since  march 08, 2017
		*/
	public function menuPrograma( $codigoFacultad , $codigoCarrera , $lineaEstrategicaId , $idLineas ){
			
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menuPrograma($codigoFacultad, $codigoCarrera, $lineaEstrategicaId);
		$html ="<ul  class='nav collapse' id='$idLineas'><li><a href='#programa$idLineas' data-toggle='collapse' class='ln restaurar'>Programa <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
		
		$existencia = count($menus);
		 if($existencia>0){
				$idPrograma = 0;
		$html.= "<ul class='nav collapse' id='programa$idLineas'>";
			foreach ($menus as $menu){
				$idProgramas ='programadetalle'.$idLineas.$idPrograma; 
				$html.= "<li><a href='#programadetalle$idLineas$idPrograma' data-toggle='collapse' class='ln restaurar'>";
						$html.= ucwords(strtolower ($menu->getNombrePrograma ()));	
						$html.=" <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
						$html.=$this->menuProyecto($codigoFacultad, $codigoCarrera, $lineaEstrategicaId, $menu->getProgramaPlanDesarrolloId () , $idProgramas , $idPrograma  );
								
				$html.= "</li>";
			$idPrograma++;
				}
		$html.="</ul>";
		}
		 $html.="</li></ul>";
		return $html;	
			
	}
	/*
		 * @ Diego Rivera <riveradiego@unbosque.edu.co>
		 * funcion carga menu proyectos
		 * @since  march 08, 2017
		*/
	public function menuProyecto( $codigoFacultad , $codigoCarrera , $lineaEstrategicaId ,$idPrograma ,$idProgramas , $consecutivo ){
		$menuPlanDesarrollo = new MenusPlandesarrollo( $this->persistencia );
		$menus = $menuPlanDesarrollo->menuProyecto($codigoFacultad, $codigoCarrera, $lineaEstrategicaId, $idPrograma);
		$existencia = count($menus);	
			
		$html="<ul  class='nav collapse' id='$idProgramas'><li><a href='#proyecto$idProgramas' data-toggle='collapse' class='ln restaurar'>Proyecto <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
		if($existencia > 0){
			
		$html.= "<ul class='nav collapse' id='proyecto$idProgramas'>";
		$idProyecto = 0;
		$consecutivo=explode("_",$idProgramas);
		$consecutivo=$consecutivo[1];
			foreach ($menus as $menu){
			$html.= "<li><a href='#' data-toggle='collapse' class='datos ln iniciopagina' id='datosenvio_$consecutivo$idProyecto'>";
			$html.=$menu->getNombreProyectoPlanDesarrollo();
			$html.="</a>";
			$idPlan = $menu->getProyectoPlanDesarrolloId();
			$nombreFacultad = $menu->getNombreFacultad();
			$nombreCarrera = $menu->getNombreCarrera();
			$nombreLinea = $menu->getNombreLineaEstrategica();
			$nombrePrograma = $menu->getNombrePrograma();
			$nombreProyecto = $menu->getNombreProyectoPlanDesarrollo();
			
		
			/*
			 * @ Diego Rivera <riveradiego@unbosque.edu.co>
			 *  variables para cargar ruta en  parte superior del modulo gestion del plan de desarrollo
			 * @since  march 08, 2017
			*/
			$html.="<input type='hidden' class='datos'  id='facultad_$consecutivo$idProyecto' value='$codigoFacultad' >";
			$html.="<input type='hidden' class='datos'  id='programaacademico_$consecutivo$idProyecto' value='$codigoCarrera' >";
			$html.="<input type='hidden' class='datos'  id='lineaestrategica_$consecutivo$idProyecto' value='$lineaEstrategicaId' >";
			$html.="<input type='hidden' class='datos'  id='programa_$consecutivo$idProyecto' value='$idPrograma' >";
			$html.="<input type='hidden' class='datos'  id='proyecto_$consecutivo$idProyecto' value='$idPlan' >";
			$html.="<input type='hidden' class='datos'  id='facultades_$consecutivo$idProyecto' value='$nombreFacultad' >";
			$html.="<input type='hidden' class='datos'  id='carreras_$consecutivo$idProyecto' value='$nombreCarrera' >";
			$html.="<input type='hidden' class='datos'  id='lineas_$consecutivo$idProyecto' value='$nombreLinea' >";
			$html.="<input type='hidden' class='datos'  id='programas_$consecutivo$idProyecto' value='$nombrePrograma' >";
			$html.="<input type='hidden' class='datos'  id='proyectos_$consecutivo$idProyecto' value='$nombreProyecto' >";
			$html.= "</li>";
			$idProyecto++;
			}
		
		$html.="</ul>";
		}
		$html.="</ul>";
	
		return $html;
	}
	
	
	
	public function consultarMenu(  ){
		return $this->menufacultad(  );
	}
		
}


?>