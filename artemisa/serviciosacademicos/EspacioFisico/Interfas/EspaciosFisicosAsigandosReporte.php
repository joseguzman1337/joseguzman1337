<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace limpieza de codigo y cambio de interfaz
 * @since Agosto 9, 2019
 */ 
session_start();
include('../../../assets/Complementos/piepagina.php');

function DiasSemana($Fecha, $Op = '') {
    if ($Op == 'Nombre') {
        $dias = array('', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
    } else {
        $dias = array('', '1', '2', '3', '4', '5', '6', '7');
    }
    $fecha = $dias[date('N', strtotime($Fecha))];
    return $fecha;
}

function dameFecha($fecha, $dia) {
    list($year, $mon, $day) = explode('-', $fecha);
    return date('Y-m-d', mktime(0, 0, 0, $mon, $day + $dia, $year));
}

$fecha_Now = date('Y-m-d');

$dia = DiasSemana($fecha_Now);

$Falta = 1 - $dia;

$FechaFutura_1 = dameFecha($fecha_Now, $Falta);
$FechaFutura_2 = dameFecha($FechaFutura_1, 6);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Consultar Espacio Fisico</title>

        <style type="text/css" title="currentStyle">
            .tableFixHead          { overflow-y: auto; height: 100px; }
            .tableFixHead thead th { position: sticky; top: 0;background-color: #7BC142;}
        </style>

        <link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/general.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/chosen.css"> 
        <link type="text/css" rel="stylesheet" href="../../../assets/css/custom.css">

        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css?v=1">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap-datetimepicker.min.css?v=1">

        <script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script> 
        <script type="text/javascript" src="../../../assets/js/bootstrap.js"></script>

        <script src="../../../assets/js/moment.min.js?v=1"></script>
        <script src="../../../assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
        <script src="../../../assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
        <script src="../../../assets/js/calendar_format.js?v=1"></script>

        <script src="EspaciosFisicosAsigandosReporte.js"></script> 

    </head>
    <body>
        <header id="header" role="banner">
            <div class="header-inner">
                <div class="header_first">
                    <div class="block block-system block-system-branding-block">
                        <div class="block-inner">
                            <div class="title-suffix"></div>
                            <a href="http://www.uelbosque.edu.co/" title="Inicio" rel="home">
                                <img src="../../../assets/ejemplos/img/logo.png" alt="Inicio">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="close-search"></div>
            </div>
        </header>

        <div class="col-md-12">
            <div class="row centered-form">
                <div>
                    <div class="panel-body form-group">
                        <br>                      
                        <input type="hidden" id="actionID" name="actionID" />
                        <div class="form-group col-xs-12 col-md-10 col-md-offset-1">
                            <div class="form-group col-md-12">
                                &nbsp;
                            </div>
                            <div class="form-group col-md-12">
                                &nbsp;
                            </div>
                            <center>
                                <div class="form-group col-md-12">                                       
                                    <h2>Consultar Horario</h2>
                                </div>
                            </center>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12 custom-control">
                                        <label for="fecha_actual">Fecha Actual:</label>
                                        <input type="text" id="Fecha_ini" style="text-align: center;" class="form-control" name="Fecha_ini" readonly="readonly" value="<?PHP echo $FechaFutura_1; ?>"/>
                                    </div>
                                </div>         
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="fecha_final">Fecha Final:</label>
                                        <div class="col-xs-11 input-group date form_datetime">
                                            <input type="text" id="Fecha_Fin" style="text-align: center;" class="form-control" name="Fecha_Fin" readonly="readonly" value="<?PHP echo $FechaFutura_2; ?>" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">   
                                        <label for="nudocdocente">N&deg; Documento Docente:</label>
                                        <input type="text" id="Num_Docente" name="Num_Docente" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <th></th>
                                    <th>
                                    </th> 
                                    <div class="col-xs-12">
                                        <label for="nudocestudiante">N&deg; Documento Estudiante:</label>
                                        <input type="text" id="Num_Estudiante" name="Num_Estudiante" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">   
                                        <input type="button" id="Buscar" name="Buscar" value="Buscar" onclick="InformacionResultado()" class="btn btn-fill-green-XL" />
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="message" style="display: none">

                            </div>
                            <br>
                            <div class="col-xs-3">
                                <div id="procesando" style="display:none">
                                    <img src="../../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                                    <p>Procesando, por favor espere...</p>
                                </div>
                            </div>    
                            <br>
                            <div class="col-md-12">
                                <div class="table-responsive" id="tabla" style="display: none"> 
                                    <table id="dataR" width="80%" class="tableFixHead table table-bordered table-hover">
                                        <thead style="background-color: #7BC142;">
                                            <tr style=" color: white !important;">
                                                <th>#</th>    
                                                <th>Sede o Campus</th> 
                                                <th>Bloque</th> 
                                                <th>Espacio F&iacute;sico</th>
                                                <th>Grupo</th>
                                                <th>Programa</th>
                                                <th>Materia</th>
                                                <th>Estado</th>
                                                <th>Fecha</th> 
                                                <th>D&iacute;a</th>
                                                <th>Hora Inicial</th>                     
                                                <th>Hora Final</th>
                                                <th>Nombre Docente</th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultado">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $piepagina = new piepagina;
        $ruta = '../../../';
        echo $piepagina->Mostrar($ruta);
        ?> 
    </body>
</html>
