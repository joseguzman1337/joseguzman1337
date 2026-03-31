<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $rutaVistas = "./vistasRotaciones"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once(realpath(dirname(__FILE__))."/../../Mustache/load.php"); /*Ruta a /html/Mustache */
	include(realpath(dirname(__FILE__))."/../utilidades/helpers/funcionesLoop.php");
    
    require_once("../modelos/Materia.php");

    $action = "saveMateria";
    $especialidad = null;
    $editar = false;
    $titulo = "Nueva";
    if(isset($_REQUEST["id"])){
    	$action = "updateMateria";
    	$especialidad = new materia();
    	$especialidad->load("codigomateria=?", array($_REQUEST["id"]));
    	$editar = true;
    	$titulo = "Detalle Rotación Materia";
    }

    $sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera=".$_SESSION["codigofacultad"]; 
    $carrera=$db->GetRow($sql);
						
	$query ="select TipoRotacionId, NombreTipoRotacion from TipoRotaciones where codigoestado = '100' ";
	$tiposE=$db->Execute($query);
	$tipos = array();
	foreach($tiposE as $tipo){
			$tipo["selected"] = "";
		if($tipo["TipoRotacionId"]==$especialidad->tiporotacionid){
			$tipo["selected"] = "selected";
		}
		$tipos[]=$tipo;
	}
						
	$template = $mustache->loadTemplate('materia');
	echo $template->render(array('title' => 'Detalle Rotación Materia',	
						'carrera' =>$carrera["nombrecarrera"],
						'codigocarrera' =>$carrera["codigocarrera"],
						'action' =>$action,
						'materia' =>$especialidad,
						'editar' => $editar,
						'titulo' => $titulo,
						'tipos' => $tipos
						)
					);
?>
      