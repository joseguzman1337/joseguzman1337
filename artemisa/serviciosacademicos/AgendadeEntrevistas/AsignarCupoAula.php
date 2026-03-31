<?php
/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Ajuste de formulario y creacion de horarios de Entrevistas para los programas de Postgrados y Educacion Virtual.
 * @since Abril 17, 2018.
*/ 

session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL); 

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
    if(!Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 621)){
       $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("/serviciosacademicos", $actual_link);
        $root = $actual_link[0]."/serviciosacademicos";
        header("Location: ".$root."/GestionRolesYPermisos/index.php?option=error");
        exit();
    }
//End Caso 105009
?>
<html>
<link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/general.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css"> 
<link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.min.css"> 
    
<script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script> 
<script type="text/javascript" src="../../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>    
<script type="text/javascript" src="../../assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>    
<script type="text/javascript" src="../../assets/js/moment.js"></script>    
<script type="text/javascript" src="../../assets/js/moment-with-locales.js"></script>    
<script type="text/javascript" src="../../assets/js/bootstrap-datetimepicker.js"></script>    
<script type="text/javascript" src="../../assets/js/chosen.jquery.min.js"></script>    
    
<script type="text/javascript" src="js/funciones.js"></script>

<script>
    $(document).ready(function(){
    $(".chosen").chosen();
       
  });
</script>
    
<script type="text/javascript"> 
    $( document ).ready(function() {
    $(".fechaEntrevista").datetimepicker({ format: 'YYYY-MM-DD', locale: 'es'});              
    $(".horaInicio").datetimepicker({ format: 'HH:ss', locale: 'es'});                  
    $(".horaFin").datetimepicker({ format: 'HH:ss', locale: 'es'});               
    });
</script>

<head>
	<title>Asignacion de Cupo a Aula</title>
	<meta charset="utf-8">
</head>
<body onload="">
   <div class="container">
	<div class="row" style = "display:block;" id="formulario1">
    <div class="row">
	  	<h1 align="center">Asignar Salon y Cupo</h1> 
	</div>
    	<br>
         <form id="formulario" name="formulario" onSubmit="return limpiar()">
            <div class="row">
                <div class="col-xs-4 col-xs-offset-1">
                  <label for="modalidad_academica">Modalidad Académica</label>
                  <select id="modalidad_academica" name="modalidad_academica"class="form-control"  style="width:400px;"  onchange="carrera()">
                  </select>
                </div>
                 <div class="col-xs-4 col-xs-offset-2">
                  <label for="responsable">Responsable</label>
                  <select id="responsable" name="responsable" class="form-control" style="width:400px;"></select>
                </div>
            </div>
            <br> 
        <div id="Program" style="display: none">     
            <div class="row">
                <div class="col-xs-4 col-xs-offset-1">
                  <label for="programa_academico">Programa Académico</label>
                  <select id="programa_academico" name="programa_academico"class="form-control"  style="width:400px;" >
                  </select>
                </div>
                <div class="col-xs-4 col-xs-offset-2">
                    <label for="aula">Salon</label>
                    <select id="aula" name="aula" class="form-control" style="width:400px;"></select>
                </div>
            </div>
         </div> 
         
            <br>
             <div class="row">
                <div class="col-xs-4 col-xs-offset-4">
                  <label for="cupo">Cupo</label>
                  <input type="text" class="form-control input-sm" style="width:350px;" id="cupo" name="cupo"  placeholder="Digite Cantidad">
                </div>
            </div>
            <br> 
            <div class="col-xs-4 col-xs-offset-4">
                <div class="row">
                    <div class="col-md-5  text-center">
                        <input class="btn btn-fill-green-XL" type="button" id="guardaraula" value="Guardar" onclick="guardar()">
                    </div>
                    <div class="col-md-18  text-center">
                         <input class="btn btn-fill-green-XL" type="button" id="consultarCupoSalon" value="Consultar" onclick="consultar()">
                    </div>
                </div>         
                <div id="procesando" style="display:none">
                    <img src="../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </div> 
             
         </form>  
       </div>
    </div>
<div class="container"><div class="table-responsive" id="tabla" style="display: none">                
                <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th style="text-align: center">N°</th>
                            <th style="text-align: center">Carrera</th>
                            <th style="text-align: center">Salon de Entrevistas</th>
                            <th style="text-align: center">Responsable</th>
                            <th style="text-align: center">Cupo Salon</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center">Eliminar</th>
                            <th style="text-align: center">Horario Grafico</th>
                            <th style="text-align: center">Crear/Ver Horarios</th>
                        </tr>
                  </thead>                    
                    <tbody id="dataReporte">
                    </tbody>
                </table>      
            </div>    
    </div>
   
<div class="container">
	<div class="row" style = "display:none;" id="formCrearEntrevistas">
        <div class="row">
	  	<h1 align="center">Crear Entrevistas</h1> 
	</div>
       
		<br>
         <form id="formularioCreaEntrevistas" name="formularioCreaEntrevistas" onSubmit="return limpiar()">
                <div class="col-xs-4 col-xs-offset-4">
                   <div class='input-group date'>
                       <label for="fechaE">Fecha Entrevista</label>
                       <input class="fechaEntrevista" name="fechaE" type="text" placeholder="Fecha" size="12" id="fechaE">     
                    </div>
                    <br>
                      <div class='input-group date'>
                       <label for="horaIni">Hora Inicio</label>
                       <input class="horaInicio" name="fechainicialcorte" type="text" placeholder="Hora Inicio" size="12" id="fechainicialcorte">     
                    </div>
                     <br>
                      <div class='input-group date'>
                       <label for="horaFinal">Hora Final</label>
                       <input class="horaFin" name="horaF" type="text" placeholder="Hora Final" size="12" id="horaF">   
                        <input type="hidden" name="codcarrreraSalon" id="codcarrreraSalon" value="" />
                    </div>
                    <br>
                    <div class="row">
                            <div class="col-md-10  text-center">
                                <input class="btn btn-fill-green-XL" type="button" id="guardarentrevista" value="Guardar" onclick="guardarEntrevistas()">
                                 <a href="./AsignarCupoAula.php" class="btn btn-fill-green-XL" title="Volver a Asignar Salon y Cupo">Regresar</a>
                            </div>
                    </div>         
                    <div id="procesando" style="display:none">
                        <img src="../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                        <p>Procesando, por favor espere...</p>
                    </div>
                </div> 
             
         </form>  
       </div>
</div>  
    
<div class="container"><div class="table-responsive" id="tablaEntrevistas" style="display: none">                
        <h1 align="center">Entrevistas Programadas</h1> 
                <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th style="text-align: center">N°</th>
                            <th style="text-align: center">Carrera</th>
                            <th style="text-align: center">Salon de Entrevistas</th>
                            <th style="text-align: center">Fecha Entrevista</th>
                            <th style="text-align: center">Hora Inicio</th>
                            <th style="text-align: center">Hora Fin</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center">Eliminar</th>
                            
                        </tr>
                  </thead>                    
                    <tbody id="dataReporteE">
                    </tbody>
                </table>      
            </div>    
</div>
 <div class="container"><div class="table-responsive" id="soloverEntrevistas" style="display: none">                
        <h1 align="center">Entrevistas Programadas</h1> 
        <a href="./AsignarCupoAula.php" title="Ir la página anterior">Volver</a>
                <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th style="text-align: center">N°</th>
                            <th style="text-align: center">Carrera</th>
                            <th style="text-align: center">Salon de Entrevistas</th>
                            <th style="text-align: center">Fecha Entrevista</th>
                            <th style="text-align: center">Hora Inicio</th>
                            <th style="text-align: center">Hora Fin</th>
                                                        
                        </tr>
                  </thead>                    
                    <tbody id="dataReporteV">
                    </tbody>
                </table>      
            </div>    
 </div>   
</body>
</html>