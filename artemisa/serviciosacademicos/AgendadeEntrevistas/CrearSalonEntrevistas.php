<?php
/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * FORMULARIO PARA EL REGISTRO DE SALONES Y CUPOS PARA CADA CARRERA.
 * @since Diciembre 27, 2017
*/ 
session_start();
include_once('../../serviciosacademicos/utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 
$user = $_SESSION['usuario'];

/*
 * Caso 105009
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario para el acceso a la carpeta de Gestión de Entrevistas.
 * @since Septiembre 13, 2018.
*/ 
    require_once('../../assets/lib/Permisos.php');
    if(!Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 620)){
       $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("/serviciosacademicos", $actual_link);
        $root = $actual_link[0]."/serviciosacademicos";
        header("Location: ".$root."/GestionRolesYPermisos/index.php?option=error");
        exit();
    }
//End Caso 105009.
?>
<html>
<link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/general.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css"> 
<script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script> 
<script type="text/javascript" src="../../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>    
<script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>    
<script type="text/javascript" src="js/funciones.js"></script>

<head>
	<title>Creación Salon para Entrevistas</title>
	<meta charset="utf-8">
</head>
<body onload="consultarSalon()">
   <div class="container">
	<div class="row">

	  	<h1 align="center">Crear Salones Para Entrevistas</h1> 
		</div>
		<br>
         <form id="formularioAulas" name="formularioAulas" onSubmit="return limpiar()">
                <div class="col-xs-4 col-xs-offset-4">
                   <div class="form-group">
                      <label for="cupo">Nombre Salón</label>
                      <input type="text" class="form-control input-sm" id="salon" name="salon"  placeholder="Digite Nombre Salón">
                   </div>
                    <div class="row">
                            <div class="col-md-7  text-center">
                                <input class="btn btn-fill-green-XL" type="button" id="guardarsalon" value="Guardar" onclick="guardarSalon()">
                            </div>
                    </div>         
                    <div id="procesando" style="display:none">
                        <img src="../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                        <p>Procesando, por favor espere...</p>
                    </div>
                </div> 
             
         </form>  
       </div>

<div class="container">
    <div class="table-responsive" id="tablaSalon" style="display: none">                
                <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th style="text-align: center">N°</th>
                            <th style="text-align: center">Nombre Salón</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center">Eliminar</th>
                        </tr>
                  </thead>                    
                    <tbody id="dataReporteS">
                    </tbody>
                </table>      
    </div>    
</div>
</body>
</html>