<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    //include_once ('../EspacioFisico/templates/template.php');
    $rutaVistas = "./vistasRotaciones"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once("../../Mustache/load.php"); /*Ruta a /html/Mustache */
    include("../utilidades/helpers/funcionesLoop.php");
    //$db = getBD();
    require_once("../modelos/rotaciones/EspecialidadCarrera.php");
    if(!isset ($_SESSION['MM_Username']))
    {
        echo "No ha iniciado sesión en el sistema";
        exit();
    }
    $action = "saveEspecialidad";
    $especialidad = null;
    $editar = false;
    	$titulo = "Nueva";
    if(isset($_REQUEST["id"])){
    	$action = "updateEspecialidad";
    	$especialidad = new especialidadCarrera();
    	$especialidad->load("EspecialidadCarreraId=?", array($_REQUEST["id"]));
    	$editar = true;
    	$titulo = "Editar";
    }

    $sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera=".$_SESSION["codigofacultad"]; 
    $carrera=$db->GetRow($sql);
						
    $template = $mustache->loadTemplate('especialidad');
	echo $template->render(array('title' => 'Especialidades Carrera',	
											'carrera' =>$carrera["nombrecarrera"],
											'codigocarrera' =>$carrera["codigocarrera"],
											'action' =>$action,
											'especialidad' =>$especialidad,
											'editar' => $editar,
											'titulo' => $titulo
											)
										);
?>