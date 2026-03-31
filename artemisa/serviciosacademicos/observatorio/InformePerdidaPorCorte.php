<?php
/**
 * Caso 107381
 * Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
 * Diciembre 5 del 2018
 * Adicion para reporte de docentes, validacion de lineas y actualizacion de datos.
 */

/**
 * Caso Interno 307.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 22 de Abril 2019.
 */
set_time_limit(0);

require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */

Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');

/**
 * Caso Interno 307.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 23 de Abril 2019.
 */

$itemId = Factory::getSessionVar('itemId');
require_once('../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}

date_default_timezone_set("America/Bogota");

?>
<html>
<head>
    <title>Perdidad por Corte</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">

    <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../assets/js/moment.js"></script>
    <script type="text/javascript" src="../../assets/js/moment-with-locales.js"></script>
    <script type="text/javascript" src="../../assets/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>
    <script type="text/javascript" src="js/informePerdidaAcademica.js"></script>

    <!--  SELECT2 PARA DISEÑO DE SELECTS  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet"/>

<!--    DATATABLE-->
    <link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script>

        function exportExcel1funct()
        {
            $("#datos_a_enviar").val($("<div>").append($("#dataR1").eq(0).clone()).html());
            $("#formInforme").submit();
        }


        $('#exportExcel2').click(function (e) {
            $("#datos_a_enviar").val($("<div>").append($("#dataR2").eq(0).clone()).html());
            $("#formInforme").submit();

        });

        $('#exportExcel3').click(function (e) {
            $("#datos_a_enviar").val($("<div>").append($("#dataR3").eq(0).clone()).html());
            $("#formInforme").submit();

        });

        function hideTableColumns(idTable, columnsIndex)
        {
            var propDisplay = $('#col-'+columnsIndex).is(":visible");

            //setea el icono de ojo abierto o cerrado para ocultar columnas
            if(propDisplay)
            {
                $('#eye-'+columnsIndex).attr('class', 'glyphicon glyphicon-eye-close');
            }
            else{
                $('#eye-'+columnsIndex).attr('class', 'glyphicon glyphicon-eye-open');
            }

            $("#" + idTable + " tr").each(function() {
                    if(propDisplay == true)
                    {
                        $($(this).find("th")[columnsIndex]).hide("slow");
                        $($(this).find("td")[columnsIndex]).hide("slow");
                    }
                    else
                    {
                        $($(this).find("th")[columnsIndex]).show("slow");
                        $($(this).find("td")[columnsIndex]).show("slow");
                    }

            });
        }

        function slideToggleButton()
        {
            $('#showColumns').slideToggle();
        }
    </script>
</head>
<style type="text/css">
    /*        este css permite que el thead de la tabla sea fijo y se deplace con el scroll*/
    .tableFixHead {
        overflow-y: auto;
        height: 100px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    th {
        background: #eee;
    }

    .table-hover tbody tr:hover td {
        background: #DDDDDB;
    }

</style>
<body>
<div class="container">
    <center>
        <h2 id="titulo1" style="display:none">INFORME PERDIDA <br>DE NOTAS POR CORTE Y FINALES</h2>
        <h2 id="titulo2" style="display:none">INFORME ESTUDIANTES <br>MATERIAS MATRICULADAS REPETIDAS</h2>
        <h2 id="titulo3" style="display:none">INFORME DATOS DOCENTES<br>POR NOTAS FINALES</h2>
        <br>
        <div class="row">
            <!--            <div class="col-md-3">-->
            <!--                <h3>Tipo de Reporte</h3>-->
            <!--            </div>-->
            <div class="col-md-6">
                <label for="">Tipo de Reporte</label>
                <select id="tiporeporte" name="tiporeporte" onchange="reportes()">
                    <option value="0" selected="selected">Seleccionar</option>
                    <option value="1">Informe de Notas por Corte</option>
                    <option value="2">Informe de Materias Repetidas</option>
                    <option value="3">Informe de datos de Docentes por Notas Finales</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <div class="col-md-8">
                <div style="display:none;" id="linea1">
                    <div class="col-md-3">
                        <label for="">Periodo</label>
                    </div>
                    <div class="col-md-5">
                        <select id="periodo" name="periodo">
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="display:none;" id="linea3">
            <div class="col-md-3">
                <h3>Periodo Inicial</h3>
            </div>
            <div class="col-md-3">
                <select id="periodoinicial" name="periodoinicial">
                </select>
            </div>
            <div class="col-md-3">
                <h3>Periodo Final</h3>
            </div>
            <div class="col-md-3">
                <select id="periodofinal" name="periodofinal">
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-8" style="display:none;" id="linea2">
                <div class="col-md-3">
                    <label>Modalidad Académica:</label>
                </div>
                <div class="col-md-5">
                    <select id="modalidad" name="modalidad" onchange="programasacademicos()" style="width: 70%">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-8" style="display:none;" id="linea21">
                <div class="col-md-3">
                    <label>Programa Académico</label>
                </div>
                <div class="col-md-5">
                    <select id="carrera" name="carrera">
                    </select>
                </div>
            </div>
        </div>

        <div class="row" style="display:none;" id="linea4">
            <div class="col-md-2">
                <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar"
                       onclick="consultar()">
            </div>
            <div class="col-md-2" id="exportarbtn1" style="display:none;">
                <button class="btn btn-fill-green-XL" type="button" id="exportExcel1" onclick="exportExcel1funct()">
                    Exportar a Excel
                </button>
                <form id="formInforme" method="post" action="../../assets/lib/ficheroExcel.php">
                    <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                </form>
            </div>
        </div>
        <div class="row" style="display:none;" id="linea5">
            <div class="col-md-2">
                <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar"
                       onclick="consultarvalores()">
            </div>
            <div class="col-md-2" id="exportarbtn2" style="display:none;">
                <button class="btn btn-fill-green-XL" type="button" id="exportExcel2">
                    Exportar a Excel
                </button>
                <form id="formInforme" method="post" action="../../assets/lib/ficheroExcel.php">
                    <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                </form>
            </div>
        </div>
        <div class="row" style="display:none;" id="linea6">
            <div class="col-md-2">
                <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar"
                       onclick="consultardatosdocentes()">
            </div>
            <div class="col-md-2" id="exportarbtn3" style="display:none;">
                <button class="btn btn-fill-green-XL" type="button" id="exportExcel3">
                    Exportar a Excel
                </button>
                <form id="formInforme" method="post" action="../../assets/lib/ficheroExcel.php">
                    <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                </form>
            </div>
        </div>
        <br/>
        <div id="procesando" style="display:none">
            <img witdh="400px" src="../../assets/ejemplos/img/Procesando.gif"><br>
            <p>Procesando, por favor espere...</p>
        </div>
    </center>
    <div class="col-md-12">
        <div class="table-responsive" id="tabla1" style="display: none">
            <div class="row">
                <button class="btn btn-info" id="showColumnsButton" onclick="slideToggleButton()">Mostrar Columnas</button>
            </div>
            <div id="showColumns" style="display: none;height:250px;overflow:scroll; font-size: 10px" class="col-md-3 overflow-auto" >
                <ul class="list-group">
                    <li class="list-group-item disabled">Columnas disponibles</li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',1)">Periodo <span class="glyphicon glyphicon-eye-open" id="eye-1"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',2)">Código Programa <span class="glyphicon glyphicon-eye-open" id="eye-2"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',3)">Programa Académico <span class="glyphicon glyphicon-eye-open" id="eye-3"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',4)">Nombre Plan Estudio <span class="glyphicon glyphicon-eye-open" id="eye-4"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',5)">Código Materia <span class="glyphicon glyphicon-eye-open" id="eye-5"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',6)">Materia del Plan de Estudio <span class="glyphicon glyphicon-eye-open" id="eye-6"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',7)">Tipo Materia <span class="glyphicon glyphicon-eye-open" id="eye-7"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',8)">Créditos Materia <span class="glyphicon glyphicon-eye-open" id="eye-8"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',9)">Semestre Materia <span class="glyphicon glyphicon-eye-open" id="eye-9"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',10)">Cód Programa Dueño Materia <span class="glyphicon glyphicon-eye-open" id="eye-10"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',11)">Programa Dueño de Materia <span class="glyphicon glyphicon-eye-open" id="eye-11"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',12)">Cód Grupo <span class="glyphicon glyphicon-eye-open" id="eye-12"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',13)">Nombre Grupo <span class="glyphicon glyphicon-eye-open" id="eye-13"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',14)">Nombre Docente <span class="glyphicon glyphicon-eye-open" id="eye-14"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',15)">Jornada <span class="glyphicon glyphicon-eye-open" id="eye-15"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',16)">Total Matriculados Grupo <span class="glyphicon glyphicon-eye-open" id="eye-16"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',17)">Total Retirados Grupo <span class="glyphicon glyphicon-eye-open" id="eye-17"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',18)">Pérdida Corte_1 <span class="glyphicon glyphicon-eye-open" id="eye-18"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',19)">%C <span class="glyphicon glyphicon-eye-open" id="eye-19"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',20)">%Pérdida <span class="glyphicon glyphicon-eye-open" id="eye-20"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',21)">Estrategia Docente_C1 <span class="glyphicon glyphicon-eye-open" id="eye-21"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',22)">Pérdida Corte_2 <span class="glyphicon glyphicon-eye-open" id="eye-22"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',23)">%C <span class="glyphicon glyphicon-eye-open" id="eye-23"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',24)">%Pérdida <span class="glyphicon glyphicon-eye-open" id="eye-24"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',25)">Estrategia Docente_C2 <span class="glyphicon glyphicon-eye-open" id="eye-25"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',26)">Pérdida Corte_3 <span class="glyphicon glyphicon-eye-open" id="eye-26"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',27)">%C <span class="glyphicon glyphicon-eye-open" id="eye-27"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',28)">%Perdida <span class="glyphicon glyphicon-eye-open" id="eye-28"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',29)">Estrategia Docente_C3 <span class="glyphicon glyphicon-eye-open" id="eye-29"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',30)">Periodo Final <span class="glyphicon glyphicon-eye-open" id="eye-30"></span></li>
                    <li class="list-group-item" style="cursor:pointer" onclick="hideTableColumns('dataR1',31)">%Pérdida <span class="glyphicon glyphicon-eye-open" id="eye-31"></span></li>
                </ul>
            </div>
            <table id="dataR1"
                   class="col-md-12 table table-bordered table-hover tableFixHead  table-line-ColorBrandDark-headers" border="1" style="font-size: 10px">
                <thead>
                <tr style="">
                    <th>N°</th>
                    <th id="col-1">Periodo</th>
                    <th id="col-2">Código Programa</th>
                    <th id="col-3">Programa Académico</th>
                    <th id="col-4">Nombre Plan Estudio</th>
                    <th id="col-5">Código Materia</th>
                    <th id="col-6">Materia del Plan de Estudio</th>
                    <th id="col-7">Tipo Materia</th>
                    <th id="col-8">Créditos Materia</th>
                    <th id="col-9">Semestre Materia</th>
                    <th id="col-10">Cód Programa Dueño Materia</th>
                    <th id="col-11">Programa Dueño de Materia</th>
                    <th id="col-12">Cód Grupo</th>
                    <th id="col-13">Nombre Grupo</th>
                    <th id="col-14">Nombre Docente</th>
                    <th id="col-15">Jornada</th>
                    <th id="col-16">Total Matriculados Grupo</th>
                    <th id="col-17">Total Retirados Grupo</th>
                    <th id="col-18">Pérdida Corte_1</th>
                    <th id="col-19">%C</th>
                    <th id="col-20">%Pérdida</th>
                    <th id="col-21">Estrategia Docente_C1</th>
                    <th id="col-22">Pérdida Corte_2</th>
                    <th id="col-23">%C</th>
                    <th id="col-24">%Pérdida</th>
                    <th id="col-25">Estrategia Docente_C2</th>
                    <th id="col-26">Pérdida Corte_3</th>
                    <th id="col-27">%C</th>
                    <th id="col-28">%Perdida</th>
                    <th id="col-29">Estrategia Docente_C3</th>
                    <th id="col-30">Periodo Final</th>
                    <th id="col-31">%Pérdida</th>
                </tr>
                </thead>
                <tbody id="dataReporte1">
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-responsive" id="tabla2" style="display: none">
        <table id="dataR2" class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Carrera</th>
                <th>Nombre</th>
                <th>Numero documento</th>
                <th>Semestre</th>
                <th>Cod materia</th>
                <th>Materia</th>
                <th>Notas</th>
                <th>Veces Matriculada</th>
                <th>Periodo</th>
            </tr>
            </thead>
            <tbody id="dataReporte2">
            </tbody>
        </table>
    </div>

    <div class="table-responsive" id="tabla3" style="display: none">
        <table id="dataR3" class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombres Docente</th>
                <th>Apellidos Docente</th>
                <th>Numero documento</th>
                <th>Carrera</th>
                <th>Cod Materia</th>
                <th>Materia</th>
                <th>Periodo</th>
                <th>Grupos</th>
                <th>Estudiantes Matriculados</th>
                <th>Cantidad de perdida</th>
                <th>% perdida</th>
                <th>Promedio de notas</th>
                <th>Desviacion Estandar</th>
                <th>Nota Maxima</th>
                <th>Nota minima</th>
            </tr>
            </thead>
            <tbody id="dataReporte3">
            </tbody>
        </table>
    </div>
</div>
</body>
</html>