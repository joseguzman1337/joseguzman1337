<?php 
/*
    * @create Luis Dario Gualteros <castroluisd@unbosque.edu.co>
    * Se crea el reporte de curso Básico para listar matriculados a curso básico que posteriomente se matricularon en programas de Pregrado.
    * @since Septiembre 3 de 2018.
 */
require_once(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));

$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    require_once(PATH_ROOT.'/kint/Kint.class.php');
}

require_once(PATH_SITE.'/lib/Factory.php');

$db = Factory::createDbo();
$variables = new stdClass();
$variables->option= "";

Factory::validateSession($variables);

$user = Factory::getSessionVar('MM_Username');

?> 
    
<html>
<head>  
        <title>Curso Basico</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
    <?php
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");
    
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery.validate.min.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootbox.min.js");     
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/consulta/listadosvarios/informecursobasico/js/cursobasico.js"); 
    
        ?>    
</head>
    <body>
        <div class="container">
            
                <h1 align="center">Reporte Curso Básico</h1>
                <br>
              <div class="row">
                <div class="col-xs-4 col-xs-offset-4">
                  <label for="periodo">Periodo(*)</label>
                  <select id="periodo" name="periodo" class="form-control" style="width:350px;"></select>
                </div>
             </div>
             <br>
            <div class="col-xs-4 col-xs-offset-4">
                <div class="row">
                    <div class="col-md-5  text-center">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="Curso Basico" title="Consultar Matriculados al Curso Basico" onclick="consultar()">
                    </div>
                      <div class="col-md-18  text-center">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="Pregrado"  title="Consultar Matriculados a Pregrado" onclick="consultarPregrado()">
                    </div>
                  
                </div>
                <br>
                <div class= "row">
                      <div class="col-md-11  text-center" style="display:none;" id="exportarbtn" id="exportExcel">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../../assets/lib/ficheroExcel.php" align="center">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                            <input  id="flag_consulta" type="hidden" name="flag_consulta" value="">
                        </form>
                    </div>
            
                    
                </div>
                <br>
                <center>
                <div id="procesando" style="display:none">
                    <img src="../../../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
                </center>
            </div>    
                <div class="table-responsive" id="tabla" style="display: none">                
                    <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th>Documento</th>
                                <th>Nombre Completo</th>
                                <th>Programa Academico</th>                            
                                <th>Periodo</th>
                                <th>Situación Estudiante </th>                                                                                                                                   
                                <th>Promedio Semestre </th>                                                                                                                                   
                                <th>Email Institucional </th>                                                                                                                                   
                                <th>Email Personal </th>                                                                                                                                   
                            </tr>
                        </thead>                    
                        <tbody id="dataReporte">
                        </tbody>                     
                    </table>        
                </div>

                <div class="table-responsive" id="tablapre" style="display: none">                
                    <table id="dataRpre" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th>Documento</th>
                                <th>Nombre Completo</th>
                                <th>Programa Academico</th>                            
                                <th>Periodo</th>
                                <th>Semestre</th>
                                <th>Situación Estudiante </th>    
                                <th>Email Institucional </th>                                                                                                                                   
                               <th>Email Personal </th>         
                            </tr>
                        </thead>                    
                        <tbody id="dataReportepre">
                        </tbody>                     
                    </table>        
               </div> 
             
        </div>
    </body>
</html>
<script>
    $('#exportExcel').click(function (e) 
    {
      var flag_consulta = $('#flag_consulta').val();
        switch(flag_consulta){
            case '1':                
        $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone()).html());
                break;
            case '2':
        $("#datos_a_enviar").val($("<div>").append($("#dataRpre").eq(0).clone()).html());
                break;
        }
        $("#formInforme").submit();
    });
</script>