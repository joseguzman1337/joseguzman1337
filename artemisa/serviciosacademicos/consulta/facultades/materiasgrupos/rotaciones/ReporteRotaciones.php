<?php

if ($_REQUEST['excel'] == 1) {
    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: filename=ficheroExcel_".$_REQUEST['codigoperiodoinicial']."_".$_REQUEST['codigoperiodofinal']."_".$_REQUEST['ubicacion'].".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}

require_once(realpath(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php"));

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

setlocale(LC_MONETARY, 'es_CO');
include (PATH_ROOT . '/serviciosacademicos/utilidades/funcionesFechas.php');
include (PATH_ROOT . '/serviciosacademicos/utilidades/funcionesTexto.php');

require(PATH_ROOT . '/serviciosacademicos/convenio/Formula/Formula.php');

$SQL_User = 'SELECT idusuario as id, codigorol FROM usuario WHERE usuario="' . $_SESSION['MM_Username'] . '"';
$Usario_id = $db->GetRow($SQL_User);
$userid = $Usario_id['id'];

include_once (PATH_ROOT . '/serviciosacademicos/convenio/Permisos/class/PermisosRotacion_class.php');
$C_Permisos = new PermisosRotacion();
$Acceso = $C_Permisos->PermisoUsuarioRotacion($db, $userid, 2, 9);

foreach ($Acceso['Data'] as $datos) {
    $rol = $datos['RolSistemaId'];
}

$ubicacion = $_REQUEST['ubicacion'];
$periodoinicial = $_REQUEST['codigoperiodoinicial'];
$periodofinal = $_REQUEST['codigoperiodofinal'];
$carrera = $_GET['carrera'];
$Materia = $_GET['Materia'];
$Documento = $_GET['Documento'];
$Apellido = $_GET['Apellido'];
$convenios = $_GET['convenios'];
$instituciones = $_GET['instituciones'];

$ubicacion = limpiarCadena(filter_var($ubicacion, FILTER_SANITIZE_NUMBER_INT));
$periodoinicial = limpiarCadena(filter_var($periodoinicial, FILTER_SANITIZE_NUMBER_INT));
$periodofinal = limpiarCadena(filter_var($periodofinal, FILTER_SANITIZE_NUMBER_INT));
$carrera = limpiarCadena(filter_var($carrera, FILTER_SANITIZE_NUMBER_INT));
$Materia = limpiarCadena(filter_var($Materia, FILTER_SANITIZE_NUMBER_INT));
$Documento = limpiarCadena(filter_var($Documento, FILTER_SANITIZE_NUMBER_INT));
$convenios = limpiarCadena(filter_var($convenios, FILTER_SANITIZE_NUMBER_INT));
$instituciones = limpiarCadena(filter_var($instituciones, FILTER_SANITIZE_NUMBER_INT));
$Apellido = limpiarCadena(filter_var($Apellido, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

$reportesExcel = $_REQUEST['excel'] != 1;
$ocultarTabla = ($reportesExcel) ? 'display: none;' : '';

?>

<html>
<head>
    <meta charset="UTF-8">
    <?php echo Factory::printImportJsCss("css", HTTP_ROOT . "/serviciosacademicos/js/datatables/media/css/jquery.dataTables.css"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/mgi/js/jquery.js"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/mgi/js/jquery-ui-1.8.21.custom.min.js"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/mgi/js/functions.js"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/mgi/js/functionsMonitoreo.js"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/js/datatables/media/js/jquery.dataTables.js"); ?>
    <?php echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/consulta/facultades/materiasgrupos/rotaciones/js/funcionesRotaciones.js"); ?>
    <?php if ($reportesExcel) { ?>

        <style>
            a.toggle-vis:hover::after{
                content: ' >> Visualizar / Ocultar';
            }

            a.toggle-vis {
                margin-left: 15px;
                text-decoration: none;
                color: #828282;
            }

            a.toggle-vis-activo {
                color: #7BC142 !important;
            }

            a.toggle-vis:hover {
                text-decoration: none;
                color: #282828;
                font-size: 14px;
            }

            td.details-control {
                background: url('<?php echo $Configuration->getHTTP_ROOT()?>/imagenes/details_open.png') no-repeat center center;
                cursor: pointer;
            }
            tr.shown td.details-control {
                background: url('<?php echo $Configuration->getHTTP_ROOT()?>/imagenes/details_close.png') no-repeat center center;
            }

            div.procesando, div.divTablaResultados{
                text-align: center;
                padding: 17px;
                border: 1px solid #D7D7D7;
                border-radius: 8px;
            }

            a.linkColumnasOcultas {
                margin-right: 18px;
                text-decoration: none;
                font-size: 16px;
                color: #7BC142;
            }

        </style>

        <script type="text/javascript" language="javascript">

            var columnasTabla = [
                {"titulo" : "ID", "targets": 0, "className": 'details-control'},
                {"titulo" : "NÚMERO ID", "targets": 1 },
                {"titulo" : "APELLIDOS", "targets": 2, "width" : 8 },
                {"titulo" : "NOMBRES", "targets": 3, "width" : 15 },
                {"titulo" : "SEMESTRE", "targets": 4 },
                {"titulo" : "PROGRAMA ACADEMICO", "targets": 5 },
                {"titulo" : "SERVICIOS", "targets": 6 },
                {"titulo" : "INSTITUCION", "targets": 7 },
                {"titulo" : "FECHA INGRESO", "targets": 8 },
                {"titulo" : "FECHA EGRESO", "targets": 9 },
                {"titulo" : "ASIGNATURA", "targets": 10 },
                {"titulo" : "CREDITOS TOTALES", "targets": 11 },
                {"titulo" : "CREDITOS ASIGNATURA", "targets": 12 },
                {"titulo" : "VALOR MATRICULA", "targets": 13 },
                {"titulo" : "VALOR CREDITO ASIGNATURA", "targets": 14 },
                {"titulo" : "VALOR CREDITO DIA", "targets": 15 },
                {"titulo" : "TOTAL DIAS SEMESTRE", "targets": 16 },
                {"titulo" : "TOTAL DIAS", "targets": 17 },
                {"titulo" : "JORNADA Y DIAS", "targets": 18 },
                {"titulo" : "TOTAL HORAS", "targets": 19 },
                {"titulo" : "TIEMPO ROTACION EN SEMANA", "targets": 20 },
                {"titulo" : "CONTRAPRESTACION", "targets": 21 },
                {"titulo" : "Estado", "targets": 22 },
                {"titulo" : "Formula", "targets": 23 },
                {"titulo" : "Datos formula", "targets": 24 },
                {"titulo" : "TOTAL ESTUDIANTE", "targets": 25 }
            ];

            //Columnas a ocultar
            var columnasOcultas = [4, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
            var enlacesColumnasOcultas = "";

            /* Formatting function for row details - modify as you need */
            function format ( d ) {
                var tablaDetalle = '';
                var dataRegistro = d;

                tablaDetalle = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 80%">';
                tablaDetalle += '<tr><th colspan="2">Detallado Estudiante '+ dataRegistro[2] + ' ' + dataRegistro[3] + '</th></tr>';

                $.each(columnasOcultas, function(key, indiceColumna){

                    tituloColumna = columnasTabla[indiceColumna]['titulo'];

                    tablaDetalle += '<tr>';
                    tablaDetalle += '<th align="left">' + tituloColumna + '</th>';
                    tablaDetalle += '<td style="text-align: left !important;">' + dataRegistro[indiceColumna] + '</td>';
                    tablaDetalle += '</tr>';
                });

                console.log(d);
                return tablaDetalle;

            }


            $.each(columnasTabla, function(key, columna){

                idColumna = columna.targets;
                titulo = columna.titulo;
                linkActivo = 'toggle-vis-activo';

                for (var i = 0; i <= columnasOcultas.length; i++)
                {

                    if(columnasOcultas[i] === idColumna)
                    {
                        columnasTabla[key]['visible'] = false;
                        linkActivo = '';
                        break;
                    }

                }

                enlacesColumnasOcultas += '<a class="toggle-vis '+linkActivo+'" data-column="'+idColumna+'" href="#">'+titulo+'</a> <br>';



            });

            $(document).ready(function () {

                var tablaResultados = $('#tablaResultados').DataTable({
                    "columnDefs":columnasTabla,
                    "language" : {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "initComplete": function(settings, json) {
                        $('.divControlColumnas').html(enlacesColumnasOcultas);
                        $('#divProcensando').hide();
                        $('.divTablaResultados').show();
                    }
                });


                $('a.toggle-vis').on( 'click', function (e) {
                    e.preventDefault();

                    // Get the column API object
                    var column = tablaResultados.column( $(this).attr('data-column') );

                    // Toggle the visibility
                    column.visible( ! column.visible() );

                    if(column.visible()) $(this).addClass('toggle-vis-activo');
                    else $(this).removeClass('toggle-vis-activo');



                } );

                $('#tablaResultados tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tablaResultados.row( tr );

                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } );


            });
        </script>
    <?php } ?>
</head>
<body>
<div id="container">
    <center><h2>REPORTE PRELIQUIDACION ROTACIONES</h2></center>
    <?php
    switch ($_REQUEST['consulta2']) {
        //si la consulta es por tipo de materia o programa
        case '1': {
            $and_adicional = '';
            if ($Materia) {
                $and_adicional = 'AND r.codigomateria = ' . $Materia . ' ';
            }
            if ($_REQUEST['carrera']) {
                $and_adicional = "AND r.codigocarrera = '" . $_REQUEST['carrera'] . "'";
            }
            //consulta el nombre de la carrera
            $sqlcarrera = "select c.nombrecarrera, c.codigomodalidadacademica from carrera c "
                    . "where c.codigocarrera = '" . $_REQUEST['carrera'] . "'";
            $carrerasql = $db->GetRow($sqlcarrera);
            //consulta el nombre de la materia
            $sqlmateria = "select nombremateria from materia where codigomateria ='" . $_REQUEST['Materia'] . "'";
            $materiasql = $db->GetRow($sqlmateria);
            //si el periodo final existe el titulo se mostrara con ese dato. si no, no.
            if ($periodofinal != null) {
                $periodotexto = " Y EL PERIODO " . $periodofinal;
            }
            echo "<center><p><strong>" . $carrerasql['nombrecarrera'] . "- " . $materiasql['nombremateria'] . "<br> PERIODO ACADEMICO " . $periodoinicial . $periodotexto . "</strong></p></center>";
        }break;
        //Si la consulta es por ubicacion
        case '2': {
            $and_adicional = '';
            if ($Materia) {
                $and_adicional = 'AND r.codigomateria = ' . $Materia . ' ';
            }
            if ($ubicacion) {
                //busca el nombre de la institucion
                $sqlinstitucion = "SELECT i.InstitucionConvenioId, i.NombreInstitucion FROM InstitucionConvenios i WHERE i.InstitucionConvenioId = '" . $ubicacion . "'";
                $nombreinstitucion = $db->GetRow($sqlinstitucion);

                //si el periodo final exite lo muestra. sino, no.
                if ($periodofinal != null) {
                    $periodotexto = " Y EL PERIODO " . $periodofinal;
                }
                echo "<center><h3><strong>" . $nombreinstitucion['NombreInstitucion'] . " <br> PERIODO ACADEMICO " . $periodoinicial . $periodotexto . "</strong></h3></center>";
                $and_adicional = " AND i.InstitucionConvenioId = '" . $ubicacion . "' ";
            }
        }break;
        //Si la consulta es por un estudiante especifico
        case '3': {
            //si el periodo final exite lo muestra, sino no.
            if ($periodofinal != null) {
                $periodotexto = " Y EL PERIODO " . $periodofinal;
            }
            echo "<center><p><strong>Documento:" . $Documento . "- Apellido:" . $Apellido . " <br> PERIODO ACADEMICO " . $periodoinicial . $periodotexto . "</strong></p></center>";
            if ($Documento) {
                $and_adicional = "AND e.numerodocumento = '" . $Documento . "' ";
            } elseif ($Apellido) {
                $and_adicional = 'AND e.apellidosestudiantegeneral like "%' . $Apellido . '%"';
            }
        }break;
    }
    //variable que mostrara la suma de los resultados de las contraprestaciones.
    $total = 0;
    //valida si el periodo final no exite se define que el periodo sera el periodo inicial
    if ($periodofinal != null) {
        $periodo = $periodofinal;
    } else {
        $periodo = $periodoinicial;
    }
    ?>
</div>
<div id="demo">

    <?php if($reportesExcel){ ?>
        <div class="tablaHerramientas" style="text-align: right">

            <div class="contenedorMenu" style="width: 20%">
                <a href="#" onclick="$('.divControlColumnas').slideToggle()" class="linkColumnasOcultas"> Visibilidad Columnas </a>
                <a href="#" onclick="RegresarReporteRotacion()">
                    <img src="<?php echo $Configuration->getHTTP_ROOT()?>/assets/images/regresar.svg" width="20" title="Regresar"/>
                </a>
                <a href="<?php echo $_SERVER['REQUEST_URI'] . "&excel=1"; ?>">
                    <img id="ExportarExcel" src="images/excel.png" width="20" title="Descargar informe"/>
                </a>
                <div class="divControlColumnas" style="display: none"></div>
            </div>
        </div>

        <div class="procesando" id="divProcensando">
            <img src="<?php echo $Configuration->getHTTP_ROOT()?>/assets/ejemplos/img/Procesando.gif">
            <p> Procensando... espere por favor!</p>
        </div>

    <?php }?>

    <div class="divTablaResultados" style="<?php echo $ocultarTabla?>">
        <table class="display nowrap" id="tablaResultados">
            <thead>
            <tr>
                <th>#</th>
                <th style="font-size: 12px;">NÚMERO ID</th>
                <th style="font-size: 12px;">APELLIDOS</th>
                <th style="font-size: 12px;">NOMBRES</th>
                <th style="font-size: 12px;">SEMESTRE</th>
                <th style="font-size: 12px;">PROGRAMA ACADEMICO</th>
                <th style="font-size: 12px;">SERVICIOS</th>
                <th style="font-size: 12px;">INSTITUCION</th>
                <th style="font-size: 12px;">FECHA INGRESO</th>
                <th style="font-size: 12px;">FECHA EGRESO</th>
                <th style="font-size: 12px;">ASIGNATURA</th>
                <th style="font-size: 12px;">CREDITOS TOTALES</th>
                <th style="font-size: 12px;">CREDITOS ASIGNATURA</th>
                <th style="font-size: 12px;">VALOR MATRICULA</th>
                <th style="font-size: 12px;">VALOR CREDITO ASIGNATURA</th>
                <th style="font-size: 12px;">VALOR CREDITO DIA</th>
                <th style="font-size: 12px;">TOTAL DIAS SEMESTRE</th>
                <th style="font-size: 12px;">TOTAL DIAS</th>
                <th style="font-size: 12px;">JORNADA Y DIAS</th>
                <th style="font-size: 12px;">TOTAL HORAS</th>
                <th style="font-size: 12px;">TIEMPO ROTACION EN SEMANA</th>
                <th style="font-size: 12px;">CONTRAPRESTACION</th>
                <th style="font-size: 12px;">Estado</th>
                <th style="font-size: 12px;">Formula</th>
                <th style="font-size: 12px;">Datos formula</th>
                <th style="font-size: 12px;">TOTAL ESTUDIANTE</th>
            </tr>
            </thead>
            <tbody>
            <?php {
                if ($rol == '5' || $rol == '6') {
                    $facultad = $_SESSION['codigofacultad'];
                    $ubicacionfacultad = " and r.codigocarrera='" . $facultad . "'";
                }
            }

            //consulta de de la lista de estudiantes registrados en la rotacion y en el periodo selecionado
            $valoresrotacion = listaEstudiantes($db, $periodoinicial, $periodo, $ubicacionfacultad, $and_adicional);
            //                    $valoresrotacion = array();
            //contado de psiciones
            $i = 1;
            $total = "";

            //se ingresa para seleccionar ya validar cada uno de los datos de los estudiantes de la lista
            foreach ($valoresrotacion as $datosrotacion) {//foreach4
                $idestudiantegeneral = $datosrotacion['idestudiantegeneral'];
                $codigocarrera = $datosrotacion['codigocarrera'];
                //consulta para obtener el semestre, periodo, corte y datos del  estudiante
                $valoresEstudiante = datosEstudiante($db, $idestudiantegeneral, $codigocarrera);

                foreach ($valoresEstudiante as $datosestudiantes) {//foreach datos del estudiante

                    $semestreRotacion = getSemestreRotacion($db, $datosestudiantes['codigoestudiante'],$datosrotacion['codigoperiodo']);
                    ?>
                    <tr>
                        <td valign="top"><?php if(! $reportesExcel) echo $i ?></td><!-- # posicion-->
                        <td valign="top"><?php echo $datosestudiantes['numerodocumento'] ?></td><!-- Numero de documento-->
                        <td valign="top"><?php echo $datosestudiantes['apellidosestudiantegeneral'] ?></td><!-- apellidos-->
                        <td valign="top"><?php echo $datosestudiantes['nombresestudiantegeneral'] ?></td><!-- nombres-->
                        <td valign="top" align="center"><?php echo $semestreRotacion; ?></td><!-- semestre-->
                        <td valign="top" align="center"><strong><?php echo $datosestudiantes['nombrecarrera'] ?></strong></td><!-- nombrecarrera-->
                        <?php
                        //Sonsulta para obtener la lista de servicios o especiliadades que realizao el estudiante
                        $RotacionEstudianteId = $datosrotacion['RotacionEstudianteId'];

                        if ($RotacionEstudianteId) {
                            $resultadoservicios = servicios($db, $RotacionEstudianteId);
                        }
                        ?>
                        <td valign="top"><!-- lista de servicios o especialidades-->
                            <?php
                            foreach ($resultadoservicios as $servicios) {
                                echo $servicios['Especialidad'] . " - ";
                            }
                            ?>
                        </td>
                        <td valign="top"><?php echo $datosrotacion['NombreInstitucion'] ?></td><!-- institucion-->
                        <td valign="top"><?php echo $datosrotacion['FechaIngreso'] ?></td><!-- Fecha ingreso-->
                        <td valign="top"><?php echo $datosrotacion['FechaEgreso'] ?></td><!-- Fecha fin-->
                        <?php
                        $codigoestudiante = $datosestudiantes['codigoestudiante'];
                        $semestre = $datosestudiantes['semestre'];
                        $codigomateria = $datosrotacion['codigomateria'];
                        $idconvenio = $datosrotacion['idsiq_convenio'];
                        //consulta el total de los creditos y plan de estudios del estudiante
                        $numerocreditos = creditosEstudiante($db, $codigoestudiante, $semestre);
                        //consulta el valor del smestre para el periodo y la carrera
                        $valorsemestre = ValorSemestre($db, $periodo, $semestre, $codigocarrera);
                        //consulta los dias del semestre
                        $diassemestre = diasSemestre($db, $periodo, $codigomateria);
                        //calcula los dias habiles del semestre
                        $Dias_Calculados = CalcularFechas_new($diassemestre['fechainiciogrupo'], $diassemestre['fechafinalgrupo']);

                        $diasderotacion = Buscardias($db, $datosrotacion['RotacionEstudianteId']);

                        switch ($valorsemestre['codigomodalidadacademica']) {
                            case '200': {
                                $tipopracticante = '1';
                            }break;
                            case '300': {
                                $tipopracticante = '2';
                            }break;
                        }//switch

                        $valorcontrapestacion = CalcularContrapestacion($db, $idconvenio, $tipopracticante, $codigocarrera);
                        $tipocontraprestacion = $valorcontrapestacion['IdTipoPagoContraprestacion'];

                        if ($tipocontraprestacion == '1') {
                            $contrapestacion = (int) $valorcontrapestacion['ValorContraprestacion'];
                            $formulacontrapestacion = "0." . (int) $valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "%";
                        }
                        if ($tipocontraprestacion == '2') {
                            $nombretipocontraprestacion = "Cr.";
                        }
                        if ($tipocontraprestacion == '3') {
                            $nombretipocontraprestacion = "% + SS.";
                        }
                        if ($tipocontraprestacion == '4') {
                            $contrapestacion = "$ " . (number_format($valorcontrapestacion['ValorContraprestacion'], 2));
                            $nombretipocontraprestacion = "";
                        }
                        if ($tipocontraprestacion == '5') {
                            $nombretipocontraprestacion = "% + Cr.";
                        }

                        if ($valorsemestre['valordetallecohorte']) {
                            //Valor credito asignatura = ()valor de la matricula / total de creditos) * total de creditos de la asignatura
                            $valorcredito = ($valorsemestre['valordetallecohorte']) / ( $numerocreditos['totalcreditossemestre']);
                            $valorcreditoasignatura = (int) $valorcredito * $diassemestre['numerocreditos'];

                            $fechaSemanaIngreso = new DateTime($datosrotacion['FechaIngreso']);
                            $fechaSemanaEgreso = new DateTime($datosrotacion['FechaEgreso']);
                            $diffSemana = $fechaSemanaIngreso->diff($fechaSemanaEgreso);
                            #con el modulo de 7 obtenemos los dias adicionales de la semana

                            #obtenemos el numero de semanas exacta
                            $tiempoRotacionSemanas =  round($diffSemana->format('%a')/7);
                        }//if

                        $fechainicial = new DateTime($datosrotacion['FechaEgreso']);
                        $fechafinal = new DateTime($datosrotacion['FechaIngreso']);

                        $diferencia = $fechainicial->diff($fechafinal);
                        $Meses = $diferencia->format("%m");

                        $valoresformula['1'] = $valorsemestre['valordetallecohorte']; //valor matricula
                        $valoresformula['2'] = $numerocreditos['totalcreditossemestre']; //Total creditos
                        // 3 Horas creidto
                        $valoresformula['4'] = (int) $datosrotacion['TotalDias']; //Numero de dias rotados
                        $valoresformula['5'] = $diassemestre['numerocreditos']; //Numero de creditos de la materia
                        //6 dias en el mes
                        $valoresformula['7'] = $tiempoRotacionSemanas; //Tiempo rotacion por semanas
                        //8
                        //9 valor base
                        $valoresformula['10'] = $formulacontrapestacion; //Valor de la contraprestacion
                        //11 valor pagado a un docente
                        //12 numero
                        $valoresformula['13'] = $Dias_Calculados; //13 Dias en el semestre
                        $valoresformula['14'] = (int) $datosrotacion['Totalhoras']; // total de horas de la rotacion
                        $valoresformula['18'] = $Meses; // Numero de meses rotados

                        $valorcreditodia = ($valorcreditoasignatura / $Dias_Calculados);
                        $totalformula = Formula($db, $codigocarrera, $idconvenio, $valoresformula, $datosrotacion['FechaIngreso']);
                        ?>
                        <td valign="top" align="center"><?php echo $diassemestre['nombremateria'] . '/' . $diassemestre['codigomateria']; ?></td>
                        <!-- Asignatura-->
                        <td valign="top" align="center"><?php echo $numerocreditos['totalcreditossemestre']; ?></td><!-- Total creditos -->
                        <td valign="top" align="center"><?php echo $diassemestre['numerocreditos']; ?></td> <!-- Creditos de la signatura-->
                        <td valign="top"><?php echo ($_REQUEST['excel'] == 1) ? $valorsemestre['valordetallecohorte'] : (int) $valorsemestre['valordetallecohorte']; ?></td><!-- Valor matricula-->
                        <td valign="top"><?php echo (int) $valorcreditoasignatura; ?></td> <!-- Valor credito asignaturas-->
                        <td valign="top"><?php echo (int) $valorcreditodia; ?></td><!-- Valor credito dia-->
                        <td valign="top"><?php echo $Dias_Calculados; ?></td><!-- Total de dias del semestre-->
                        <td valign="top"><?php echo (int) $datosrotacion['TotalDias']; ?></td> <!-- Total dias de la rotacion-->
                        <td valign="top"><?php echo $datosrotacion['Jornada'] . "/" . $diasderotacion; ?></td> <!-- DIAS Y JORNADAS-->
                        <td valign="top"><?php echo $datosrotacion['Totalhoras']; ?></td> <!-- Total de horas-->
                        <td valign="top"><?php echo $tiempoRotacionSemanas; ?></td> <!-- Total de horas-->
                        <td valign="top"><?php echo $nombretipocontraprestacion . " " . (int) $contrapestacion; ?></td> <!-- valor contrapestacion -->
                        <td valign="top"><?php echo $datosrotacion['NombreEstado']; ?></td><!-- Estado-->
                        <td valign="top"><?php echo $totalformula['formula']; ?></td><!-- formula-->
                        <td valign="top"><?php echo $totalformula['campos']; ?></td><!-- formula-->
                        <td valign="top"><?php echo (int) $totalformula['total']; ?></td><!-- valor total del estudiante-->
                    </tr>
                    <?php
                }//foreach datos del estudiante
                $i++;
            }//foreach datos estudiante
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>