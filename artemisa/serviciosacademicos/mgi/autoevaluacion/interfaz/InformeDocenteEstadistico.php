<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Ajustes para insertar texto en el select de programa academico y docente
 * @since  Noviembre 29, 2019
 */
session_start();
?>
<html>
    <head>
        <title>Informe Docente</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">         
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/select2.min.css">           
        <script type="text/javascript" src="../../../../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="../../../../assets/js/bootbox.min.js"></script>  
        <script type="text/javascript" src="../../../../assets/js/select2.min.js"></script>

    </head>
    <body>
        <div class="container">                    
            <input type="hidden" name="rol" id="rol" value="<?php echo $_SESSION["rol"]; ?>">    
            <input type="hidden" name="numerodocente" id="numerodocente" value="<?php echo $_SESSION["numerodocumento"]; ?>">    
            <input type="hidden" name="codigofacultad" id="codigofacultad" value="<?php echo $_SESSION["codigofacultad"]; ?>">    
            <div class="row">
                <div class="col-md-4">
                    <label for="carrera">Periodo(*):</label>
                    <select id="codigoperiodo" name="codigoperiodo"  class="form-control" onchange="values('codigoperiodo', this.value);instrumentos(this.value);">
                    </select>
                </div>
                <div class="col-md-4" >
                    <label for="instrumento">Instrumento(*):</label>
                    <select id="instrumento" name="instrumento"class="form-control" onchange="values('instrumento', this.value);programasacademicos(this.value);"  >
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" >
                    <label for="carrera">Programa Académico(*):</label>
                    <select id="carrera" name="carrera" class="form-control js-example-basic-single" onchange="values('carrera', this.value);docente(this.value);">
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="carrera">Docente(*):</label>
                    <select id="docente" name="docente" class="form-control js-example-basic-single" onchange="values('docente', this.value);grupos(this.value);">
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="carrera">Grupos(*):</label>
                    <select id="grupo" name="grupo" class="form-control" onchange="values('grupo', this.value);botones(this.value);">
                    </select>
                </div>
            </div>     
            <div class="col-xs-2 col-xs-offset-2">
            </div>
            <br>
            <div class="row">
                <div>
                    <a href="../plantilla/anexo.pdf" target="_blank">Ver estructura conceptual del cuestionario.</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3" id="botonparticipacion" style="display:none;">
                    <input class="btn btn-fill-green-XL" type="button" onclick="consultarparticipacion()" value="consultar participacion">
                </div>
                <div class="col-md-3" id="botonmostrar" style="display:none;">
                    <button type="button" class="btn btn-fill-green-XL" data-toggle="collapse" data-target=".multi-collapse">Mostrar Preguntas</button>
                </div>
                <div class="col-md-3" id="exportarbtn" style="display:none;">
                    <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                        Exportar a Excel
                    </button>
                    <form id="formInforme" method="post" action="../../../../assets/lib/ficheroExcel.php" align="center">
                        <input  id="flag" type="hidden" name="flag" value="">
                        <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                    </form>
                </div>
            </div>    
            <div class="col-xs-4 col-xs-offset-2">
                <div id="procesando" style="display:none">
                    <img src="../../../../assets/ejemplos/img/Procesando.gif"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </div>                
            <br>
            <div class="table-responsive" id="tabladatosadicionales" style="display: none"> 
                <table id="dataE" class="table table-bordered" style='border: 1px solid black;'>
                    <thead style='border: 1px solid black;'>  
                        <tr>
                            <th>Periodo</th>
                            <td id='periodoexc'></td>
                        </tr>
                        <tr>
                            <th>Instrumento</th>
                            <td id="instrumentoexc"> </td>
                        </tr>
                        <tr>
                            <th>Programa Académico</th>
                            <td id="carreraexc"></td>
                        </tr>
                        <tr>
                            <th>Docente</th>
                            <td id="docenteexc"></td>
                        </tr>
                        <tr>
                            <th>Grupo</th>
                            <td id="grupoexc"></td>
                        </tr>
                    </thead>
                </table>
                <table id="dataV" >
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div> 
            <div class="table-responsive" id="tablaparticipacion" style="display: none"> 
                <table class="table table-bordered"  id="dataP">
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
            </div> 
            <div class="table-responsive" id="tabla" style="display: none"> 

                <table id="dataR" class="table table-bordered">
                    <thead>
                        <tr style='background-color: #d1cfd0'>
                            <th style='border: 1px solid black;'>Registro</th>                            
                            <th style='border: 1px solid black;'>&Iacute;tem</th>                              
                            <th style='border: 1px solid black;'>Media Asignatura</th>
                            <th style='border: 1px solid black;'>Desviaci&oacute;n Asignatura</th>
                            <th style='border: 1px solid black;'>Media Programa</th>
                            <th style='border: 1px solid black;'>Desviaci&oacute;n Programa</th>
                            <th style='border: 1px solid black;'>Media Institucional </th>    
                            <th style='border: 1px solid black;'>Desviaci&oacute;n Institucional </th>    
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

    $('#exportExcel').click(function (e) {

        $("#datos_a_enviar").val($("<div>").append($("#dataE").eq(0).clone(),
                $("#dataV").eq(0).clone(),
                $("#dataP").eq(0).clone(),
                $("#dataV").eq(0).clone(),
                $("#dataR").eq(0).clone()).html());

        $("#formInforme").submit();
    });

    function grupos(docente) {

        var idInstrumento = $("#instrumento").val();
        var periodo = $('#codigoperiodo').val();
        var carrera = $('#carrera').val();
        if (periodo === null || periodo === '') {
            periodo = "20182";
        }
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: 'gruposdocente', docente: docente, periodo: periodo, carrera: carrera, idInstrumento: idInstrumento},
            success: function (data) {
                $('#grupo').html(data);
                ocultar();
            },
            error: function (data, error) {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function consultardatos() {
        var periodo = $('#codigoperiodo').val();
        var id = $("#instrumento").val();
        var grupo = $('#grupo').val();
        var nombregrupo = $('#grupo option:selected').text();
        var carrera = $('#carrera').val();

        var mvalid = "";
        if (grupo === 0 || grupo === '') {
            mvalid += "Debe seleccionar un grupo \n";
        }
        if (mvalid === "") {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: 'funcionesResultados.php',
                data: {action: 'ConsultaEstadisticaGrupo', id: id, grupo: grupo, nombregrupo: nombregrupo, periodo: periodo, carrera: carrera},
                beforeSend: function () {
                    $('#tabla').attr("style", "display:none");
                    $('#tablaparticipacion').attr("style", "display:none");
                    $('#procesando').attr("style", "display:inline");
                    consultarparticipacion(1);
                    $('#exportarbtn').attr("style", "display:none");
                    $('#botonmostrar').attr("style", "display:none");
                    $('#botonparticipacion').attr("style", "display:none");
                },
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#tabla').attr("style", "display:inline");
                    $('#exportarbtn').attr("style", "display:inline");
                    $('#botonmostrar').attr("style", "display:inline");
                    $('#botonparticipacion').attr("style", "display:inline");
                    $('#resultado').html(data);
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
        var grupo = $('#grupo').val();
        if (flag == null) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: 'funcionesResultados.php',
                data: {action: 'participantesprograma', id: id, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo, grupo: grupo},
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
                data: {action: 'participantesprograma', id: id, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo, grupo: grupo},
                beforeSend: function () {
                    $('#procesando').attr("style", "display:inline");
                },
                success: function (data) {
                    $('#resultadoparticipantes').html(data);
                }
            });
    }
    }
    function listaEstudiantesGrupoMateria(pregunta) {
        var idInstrumento = $("#instrumento").val();
        var carrera = $('#carrera').val();
        var periodo = $('#codigoperiodo').val();
        var nombrecarrera = $('#carrera option:selected').text();
        var grupo = $('#grupo').val();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: 'funcionesResultados.php',
            data: {action: 'listaEstudiantesGrupoMateria', idInstrumento: idInstrumento, carrera: carrera, nombrecarrera: nombrecarrera, periodo: periodo, grupo: grupo, pregunta: pregunta},
            success: function (data) {
                if (data != '') {
                    bootbox.dialog({
                        title: "<strong>Estudiantes</strong>",
                        message: data,
                        buttons: {
                            confirm: {
                                label: "Aceptar",
                                className: "btn btn-fill-green-XL"
                            }
                        }
                    });
                }
            }
        });
    }
    function cantidadEstudiantesCarreraPregunta(participantescarrera) {
        bootbox.dialog({
            message: "<strong>Numero de Participantes: </strong>" + participantescarrera,
            buttons: {
                confirm: {
                    label: "Aceptar",
                    className: "btn btn-fill-green-XL"
                }
            }
        });
    }

    function docente(carrera) {
        var periodo = $('#codigoperiodo').val();
        if (periodo === null || periodo === '') {
            periodo = "20182";
        }
        var numerodocente = $('#numerodocente').val();

        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: "ListadoDocentes", periodo: periodo, carrera: carrera, docente: numerodocente},
            success: function (data) {
                $('#docente').html(data);
                ocultar();
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function periodo() {
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: "ConsultarPeriodo"},
            success: function (data) {
                $('#codigoperiodo').html(data);
                ocultar();
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function programasacademicos(instrumentos) {
        var carrera = $('#codigofacultad').val();
        var documento = $('#numerodocente').val();
        var informe = "Docente";
        var rol = $('#rol').val();
        var grupo = "grupo";
        var periodo = $('#codigoperiodo').val();

        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action: 'CarrerasEncuestas', periodo: periodo, carrera: carrera, informe: informe, rol: rol, grupo: grupo, instrumentos: instrumentos, documento: documento},
            success: function (data) {
                $('#carrera').html(data);
                ocultar();
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
                ocultar();
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }

    function botones(grupo) {
        if (grupo === null || grupo === "") {
            ocultar();
        } else {
            consultardatos();
        }
    }

    function values(origen, val) {
        switch (origen) {
            case 'codigoperiodo':
                $.ajax({
                    type: 'POST',
                    url: 'funcionesResultados.php',
                    dataType: "html",
                    data: {action: 'NombrePeriodo', codigoperiodo: val},
                    success: function (data) {
                        $('#periodoexc').html(data);
                    },
                    error: function (data, error)
                    {
                        alert("Error en la consulta de los datos.");
                    }
                });
                break;
            case 'instrumento':
                $.ajax({
                    type: 'POST',
                    url: 'funcionesResultados.php',
                    dataType: "html",
                    data: {action: 'NombreInstrumento', instrumento: val},
                    success: function (data) {
                        $('#instrumentoexc').html(data);
                    },
                    error: function (data, error)
                    {
                        alert("Error en la consulta de los datos.");
                    }
                });
                break;
            case 'carrera':
                $.ajax({
                    type: 'POST',
                    url: 'funcionesResultados.php',
                    dataType: "html",
                    data: {action: 'NombreCarrera', carrera: val},
                    success: function (data) {
                        $('#carreraexc').html(data);
                    },
                    error: function (data, error)
                    {
                        alert("Error en la consulta de los datos.");
                    }
                });
                break;
            case 'docente':
                $.ajax({
                    type: 'POST',
                    url: 'funcionesResultados.php',
                    dataType: "html",
                    data: {action: 'NombreDocente', docente: val},
                    success: function (data) {
                        $('#docenteexc').html(data);
                    },
                    error: function (data, error)
                    {
                        alert("Error en la consulta de los datos.");
                    }
                });
                break;
            case 'grupo':
                $.ajax({
                    type: 'POST',
                    url: 'funcionesResultados.php',
                    dataType: "html",
                    data: {action: 'NombreGrupo', grupo: val},
                    success: function (data) {
                        $('#grupoexc').html(data);
                    },
                    error: function (data, error)
                    {
                        alert("Error en la consulta de los datos.");
                    }
                });
                break;
        }
    }

    function ocultar(){     
        $('#botonmostrar').attr("style", "display:none");
        $('#exportarbtn').attr("style", "display:none");
        $('#botonparticipacion').attr("style", "display:none");
        $('#tabla').attr("style", "display:none");
    }
</script> 
