<?php

/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Ajustes para insertar texto en el select de programa academico
 * @since  Noviembre 29, 2019
 */
session_start();
?>
<html>
    <head>
        <title>Informe Encuesta Docente</title>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/select2.min.css">        
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../../../assets/js/select2.min.js"></script>
    </head>
    <body>
        <div class="container">              
            <input type="hidden" name="rol" id="rol" value="<?php echo $_SESSION["rol"]; ?>">    
            <input type="hidden" name="numerodocente" id="numerodocente" value="<?php echo $_SESSION["numerodocumento"]; ?>">    
            <input type="hidden" name="codigofacultad" id="codigofacultad" value="<?php echo $_SESSION["codigofacultad"]; ?>">    
            <div class="row">
                <div class="col-md-5">
                    <label for="periodo">Periodo(*):</label>
                    <select id="codigoperiodo" name="codigoperiodo"  class="form-control" onchange="instrumentos(this.value)">
                    </select>
                </div>
                <div class="col-xs-4 col-xs-offset-2" >
                    <label for="instrumento">Instrumento(*):</label>
                    <select id="instrumento" name="instrumento"class="form-control" onchange="programasacademicos(this.value)"  >
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="carrera">Programa Académico(*):</label>
                    <select id="carrera" name="carrera"class="form-control js-example-basic-single" >
                    </select>
                </div>
            </div>     
            <br>
            <div class="row">
                <div>
                    <a href="../plantilla/anexo.pdf" target="_blank">Ver estructura conceptual del cuestionario.</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <input class="btn btn-fill-green-XL" type="button" onclick="consultardatos()" value="consultar resultados">
                </div>
                <div class="col-md-3">
                    <input class="btn btn-fill-green-XL" type="button" onclick="consultarparticipacion()" value="consultar participacion">
                </div>
                <?php if ($_SESSION["rol"] == 13) { ?>                
                    <div class="col-md-3">
                        <input id="update" name="update" type="checkbox" value="1" title="Actualizar Registros"> Actualizar Registros
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-3" id="botonmostrar" style="display:none;">
                    <button type="button" class="btn btn-fill-green-XL" data-toggle="collapse" data-target=".multi-collapse">Mostrar Preguntas</button>
                </div>
                <div class="col-md-3" id="exportarbtn" style="display:none;">
                    <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                        Exportar a Excel
                    </button>
                    <form id="formInforme" method="post" action="../../../../assets/lib/ficheroExcel.php" align="center">
                        <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                    </form>
                </div>
            </div>            
            <br>
            <div class="col-xs-4 col-xs-offset-2">
                <div id="procesando" style="display:none">
                    <img src="../../../../assets/ejemplos/img/Procesando.gif"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </div>    
            <br>  
            <div class="table-responsive" id="tablaparticipacion" style="display: none"> 
                <table class="table table-bordered table-line-ColorBrandDark-headers" id="dataP">
                    <thead>  
                        <tr>
                            <th>Matriculados</th>
                            <th>Participantes</th>
                            <th>% Esperado</th>
                            <th>% Participantes</th>
                        </tr>
                    </thead>
                    <tbody id="resultadoparticipantes">
                    </tbody>
                </table>
                <table id="dataV" >
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>            
            <div class="table-responsive" id="tabla" style="display: none"> 
                <table id="dataR" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>  
                        <tr>
                            <th id="tituloresultado1" colspan="4"></th>
                            <th id="tituloresultado2" colspan="2" style="display:none"></th>                            
                        </tr>
                        <tr>
                            <th>Registro</th>                            
                            <th>Item</th>                            
                            <th id="tituloresultado3" style='background-color: #d0e3a3'></th>
                            <th style='background-color: #d0e3a3' >Desviacion</th>                            
                            <th id="tituloresultado4" style='background-color: #B6D277; display:none'>Media</th>
                            <th id="tituloresultado5" style='background-color: #B6D277; display:none'>Desviacion</th>
                        </tr>
                    </thead>
                    <tbody id="resultado">
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        periodo();
        $('.js-example-basic-single').select2();
    });

    function periodo() {
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: 'ConsultarPeriodo'},
            success: function (data) {
                $('#codigoperiodo').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function instrumentos(periodo) {
        var periodo = periodo;
        var categoria = 'EDOCENTES';
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: 'Consultainstrumentos', categoria: categoria, periodo: periodo},
            success: function (data) {
                $('#instrumento').html(data);                
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    $('#exportExcel').click(function (e) {
            $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone(),
                $("#dataV").eq(0).clone(),
                $("#dataP").eq(0).clone()).html());
        $("#formInforme").submit();
    });

    function programasacademicos(instrumentos) {
        var codigofacultad = $('#codigofacultad').val();
        var rol = $('#rol').val();
        var informe = "Institucional";
        var periodo = $('#codigoperiodo').val();
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: 'CarrerasEncuestas', carrera: codigofacultad, periodo: periodo, rol: rol, informe: informe, instrumentos: instrumentos},
            success: function (data) {
                $('#carrera').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function consultardatos() {
        var id = $("#instrumento").val();
        var carrera = $('#carrera').val();
        var nombrecarrera = $('#carrera option:selected').text();
        var periodo = $('#codigoperiodo').val();
        var update = '';
        if ($("#update").is(':checked')) {
            update += $('#update').val();
        }
        var mvalid = "";
        if (carrera === 0 || carrera === '') {
            mvalid += "Debe seleccionar una Carrera \n";
        }
        if (mvalid === "") {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: 'funcionesResultados.php',
                data: {action: 'ConsultaEstadisticaGeneral', id: id, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo, update: update},
                beforeSend: function () {
                    $('#tabla').attr("style", "display:none");
                    consultarparticipacion(1);
                    $('#tablaparticipacion').attr("style", "display:none");
                    $('#procesando').attr("style", "display:inline");
                    $('#exportarbtn').attr("style", "display:none");
                    $('#botonmostrar').attr("style", "display:none");
                    $('#botonparticipacion').attr("style", "display:none");
                },
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#tabla').attr("style", "display:inline");
                    $('#tablaparticipacion').attr("style", "display:none");
                    $('#exportarbtn').attr("style", "display:inline");
                    $('#botonmostrar').attr("style", "display:inline");
                    $('#resultado').html(data);
                    $('#tituloresultados12').html(": " + nombrecarrera);
                    var ncarrera = nombrecarrera.split(" ");
                    var depto = ncarrera.includes("DEPARTAMENTO");
                    var curso = ncarrera.includes("CURSO");
                    if (carrera === '1') {
                        $('#tituloresultado1').html("Resultados Evaluación Institucional");
                        $('#tituloresultado2').attr("style", "display:none");
                        $('#tituloresultado3').html("Media Institucional");
                        $('#tituloresultado4').attr("style", "display:none");
                        $('#tituloresultado5').attr("style", "display:none");
                    } else {
                        $('#tituloresultado1').html("Resultados Evaluación: " + nombrecarrera);
                        $('#tituloresultado2').html("Resultados Institucionales");
                        $('#tituloresultado2').removeAttr("style");
                        $('#tituloresultado4').removeAttr("style");
                        $('#tituloresultado5').removeAttr("style");
                        $('#tituloresultado4').attr("style", "background-color: #B6D277;");
                        $('#tituloresultado5').attr("style", "background-color: #B6D277;");
                        if (depto === true) {
                            $('#tituloresultado3').html("Media Departamento");
                        } else if (curso === true) {
                            $('#tituloresultado3').html("Media Curso");
                        } else {
                            $('#tituloresultado3').html("Media programa");
                        }
                    }
                }
            });
        } else {
            alert(mvalid);
        }
    }

    function consultarparticipacion(flag = null) {
        var id = $("#instrumento").val();
        var carrera = $('#carrera').val();
        var periodo = $('#codigoperiodo').val();
        var nombrecarrera = $('#carrera option:selected').text();

        if (flag == null) {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: 'funcionesResultados.php',
            data: {action: 'participantesprograma', id: id, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo},
            beforeSend: function () {
                $('#tablaparticipacion').attr("style", "display:none");
                $('#procesando').attr("style", "display:inline");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#tablaparticipacion').attr("style", "display:inline");
                $('#resultadoparticipantes').html(data);
            }
        });
        } else {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: 'funcionesResultados.php',
                data: {action: 'participantesprograma', id: id, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo},
                beforeSend: function () {
                    $('#procesando').attr("style", "display:inline");
                },
                success: function (data) {
                    $('#resultadoparticipantes').html(data);
                }
            });
    }
    }

</script>
