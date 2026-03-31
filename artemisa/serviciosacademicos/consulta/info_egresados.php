<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace cambio de interfaz grafica
 * @since Septiembre 13, 2019
 */

include('../../assets/Complementos/piepagina.php');
$rutaado = ("../../serviciosacademicos/funciones/adodb/");
require_once("../../serviciosacademicos/Connections/salaado-pear.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <script src="../../assets/js/sweetalert.min.js"></script>

    <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
    <link type="text/css" rel="stylesheet" href="../../assets/css/custom.css">
    <style>
        .swal-button {
            padding: 7px 19px;
            border-radius: 2px;
            background-color: #7BC142;
            font-size: 12px;
            border: #7BC142;
        }

        .swal-button:hover {
            background-color: #2B3427;
        }

        /*    spinner loadig*/
        .lds-roller {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
        }

        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #82BA0F;
            margin: -4px 0 0 -4px;
        }

        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }

        .lds-roller div:nth-child(1):after {
            top: 63px;
            left: 63px;
        }

        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }

        .lds-roller div:nth-child(2):after {
            top: 68px;
            left: 56px;
        }

        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }

        .lds-roller div:nth-child(3):after {
            top: 71px;
            left: 48px;
        }

        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }

        .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
        }

        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }

        .lds-roller div:nth-child(5):after {
            top: 71px;
            left: 32px;
        }

        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }

        .lds-roller div:nth-child(6):after {
            top: 68px;
            left: 24px;
        }

        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }

        .lds-roller div:nth-child(7):after {
            top: 63px;
            left: 17px;
        }

        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }

        .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12px;
        }

        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


    </style>

    <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css?v=1">
    <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.min.css?v=1">

    <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootstrap.js"></script>

    <script src="../../assets/js/moment.min.js?v=1"></script>
    <script src="../../assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
    <script src="../../assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
    <script src="../../assets/js/calendar_format.js?v=1"></script>
    <script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>
    <script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>

    <script src="js/egresados.js"></script>

    <link rel="canonical" href="https://www.uelbosque.edu.co/egresados/actualizar_datos"/>
    <meta name="keywords"
          content="bosque,universidad el bosque,universidad del bosque,universidad,del bosque,unbosque,bogota colombia,estudiar en bogota,universidades de bogota,que estudiar en la universidad,estudios en bogota,que estudiar en bogota"/>
    <title>Información Egresados | Universidad El Bosque</title>
    <script>
        function modal(option = null) {
            $('#modal').modal(option);
        }
    </script>
</head>
<body>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div style="width: 100%">
                    <div class="lds-roller" style="margin-left: 40%">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    Cargando ...
                </div>
            </div>
        </div>
    </div>
</div>
<header id="header" role="banner">
    <div class="header-inner">
        <div class="header_first">
            <div class="block block-system block-system-branding-block">
                <div class="block-inner">
                    <div class="title-suffix"></div>
                    <a href="http://www.uelbosque.edu.co/" title="Inicio" rel="home">
                        <img src="../../assets/ejemplos/img/logo.png" alt="Inicio">
                    </a>
                </div>
            </div>
        </div>
        <div class="close-search"></div>
    </div>
</header>
<div id="pageContainer">
    <div class="form-group col-md-12">
        &nbsp;
    </div>
    <div class="form-group col-md-12">
        &nbsp;
    </div>
    <div class="form-group col-md-12">
        &nbsp;
    </div>
    <center>
        <div class="form-group col-md-12">
            <?php
            $titulo = ($_REQUEST["opc"] == "actualizar") ? "Actualiza tus datos" : "Solicite su carné";
            $comentario = "";
            ?>
            <h2><?php echo $titulo ?> Egresados</h2>
        </div>
    </center>
    <form role="form" id="egresados" name="egresados" method="post">
        <div class="panel-body">
            <input type="hidden" id="actionID" name="actionID"/>
            <div class="form-group col-xs-12 col-md-10 col-md-offset-1">
                <div class="form-group col-md-12">
                    <h3><?php echo $comentario ?></h3>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="nombres">Documento de identidad:<span style="color:red;"> (*)</span></label>
                            <input type="text" id="documento" name="documento" value="" class="form-control"
                                   autocomplete="off" placeholder="documento"
                                   onkeypress="return val_numero_documento(event)">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12">
                            <label for="fechaDocumento">Fecha Expedición: <span style="color:red;"> (*)</span></label>
                            <div class="col-xs-11 input-group date form_datetime">
                                <input type="text" id="fechaDocumento" style="text-align: center;"
                                       class="form-control datepicker" name="fechaDocumento" readonly autocomplete="off"
                                       placeholder="AAAA-MM-DD"/>
                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="apellidos">Apellidos:<span style="color:red;"> (*)</span></label>
                            <input type="text" id="apellidos" name="apellidos" value="" class="form-control"
                                   autocomplete="off" placeholder="apellidos" onkeypress="return val_texto(event)">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="nombres">Nombre(s):<span style="color:red;"> (*)</span></label>
                            <input type="text" id="nombres" name="nombres" value="" class="form-control"
                                   autocomplete="off" placeholder="nombres" onkeypress="return val_texto(event)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="ciudad">Ciudad de residencia:<span style="color:red;"> (*)</span></label>
                            <select id="ciudad" name="ciudad" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="correo">Correo electrónico:<span style="color:red;"> (*)</span></label>
                            <input type="email" id="correo" name="correo" value="" class="form-control"
                                   autocomplete="off" placeholder="correo@ejemplo.com">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="celular">Celular:<span style="color:red;"> (*)</span></label>
                            <input type="text" id="celular" name="celular" value="" class="form-control"
                                   autocomplete="off" placeholder="celular" onkeypress="return val_numero(event)">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" value="" class="form-control"
                                   autocomplete="off" placeholder="telefono" onkeypress="return val_numero(event)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="direccion">Dirección:<span style="color:red;"> (*)</span></label>
                            <input type="text" id="direccion" name="direccion" value="" class="form-control"
                                   autocomplete="off" placeholder="direccion">
                        </div>
                    </div>
                </div>
                <hr class="col-xs-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>¿Actualmente tienes empleo?: </label>
                            <div class="form-radios">
                                <div class="form-item" id="">
                                    <label class="option" for="">
                                        <input type="radio" id="encuentra_laborando" name="encuentra_laborando"
                                               value="si" class="form-radio"/> Si
                                    </label>
                                </div>
                                <div class="form-item" id="">
                                    <label class="option" for="">
                                        <input type="radio" id="encuentra_laborando" name="encuentra_laborando"
                                               value="no" class="form-radio"/> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>Usted es: </label>
                            <div class="form-radios">
                                <div class="form-item" id="edit-submitted-usted-es-1-wrapper">
                                    <label class="option" for="edit-submitted-usted-es-1">
                                        <input type="radio" id="eusted_es" name="usted_es" value="empleado"
                                               class="form-radio"/> Empleado
                                    </label>
                                </div>
                                <div class="form-item" id="edit-submitted-usted-es-2-wrapper">
                                    <label class="option" for="edit-submitted-usted-es-2">
                                        <input type="radio" id="usted_es" name="usted_es" value="independiente"
                                               class="form-radio"/> Independiente
                                    </label>
                                </div>
                                <div class="form-item" id="edit-submitted-usted-es-3-wrapper">
                                    <label class="option" for="edit-submitted-usted-es-3">
                                        <input type="radio" id="usted_es" name="usted_es"
                                               value="Empleado e Independiente" class="form-radio"/> Empleado e
                                        Independiente
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="col-xs-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="edit-submitted-nombre-de-la-empresa-organizacion-entidad-donde-trabaja">Nombre
                                de la empresa / organización / entidad donde trabaja:</label>
                            <input type="text" id="entidaddondetrabaja" name="entidaddondetrabaja" value=""
                                   class="form-control" autocomplete="off" placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label for="edit-submitted-cargo-ocupa-actualmente-en-su-empleo">El Cargo que ocupa
                                actualmente en su empleo es:</label>
                            <input type="text" id="cargoempleo" name="cargoempleo" value="" class="form-control"
                                   autocomplete="off" placeholder="">
                        </div>
                    </div>
                </div>
                <hr class="col-xs-12">
                <div class="row">


                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>El nivel de coincidencia entre la actividad laboral actual y su carrera profesional
                                es: </label>
                            <div class="form-radios">
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="nivelcoincidencia" name="nivelcoincidencia"
                                               value="Muy coincidente" class="form-radio"/> Muy coincidente
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="nivelcoincidencia" name="nivelcoincidencia"
                                               value="Coincidente" class="form-radio"/> Coincidente
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="nivelcoincidencia" name="nivelcoincidencia"
                                               value="Poco coincidente" class="form-radio"/> Poco coincidente
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="nivelcoincidencia" name="nivelcoincidencia"
                                               value="Nada coincidente" class="form-radio"/> Nada coincidente
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>¿Qué tipo de contrato de vinculación tiene con la empresa en que labora
                                actualmente?</label>
                            <div class="form-radios">
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tipocontrato" name="tipocontrato" value="Termino Fijo"
                                               class="form-radio"/> Termino fijo
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tipocontrato" name="tipocontrato"
                                               value="Termino Indefinido" class="form-radio"/> Termino indefinido
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tipocontrato" name="tipocontrato"
                                               value="Prestacion de Servicios" class="form-radio"/> Prestacion de
                                        Servicios
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tipocontrato" name="tipocontrato" value="Otro"
                                               class="form-radio"/> Otro
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="col-xs-12">
                <div class="row">

                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>¿Cuál es su ingreso salarial actual?</label>
                            <div class="form-radios">
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 1 SMLV y 2 SMLV" class="form-radio"/> Entre 1 SMLV y 2 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 2 SMLV y 3 SMLV" class="form-radio"/> Entre 2 SMLV y 3 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 3 SMLV y 4 SMLV" class="form-radio"/> Entre 3 SMLV y 4 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 2 SMLV y 3SMLV" class="form-radio"/> Entre 2 SMLV y 3 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 4 SMLV y 5 SMLV" class="form-radio"/> Entre 4 SMLV y 5 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Entre 5 SMLV y 6 SMLV" class="form-radio"/> Entre 5 SMLV y 6 SMLV
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-en-cual-de-los-siguientes-sectores-esta-ubicada-su-empresa-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="ingresosalarial" name="ingresosalarial"
                                               value="Más de 6 SMLV" class="form-radio"/> Más de 6 SMLV
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_REQUEST["opc"] == "actualizar") {
                    ?>
                    <div class="form-group col-md-6">
                        <div class="col-xs-12 custom-control">
                            <label>¿Tiene carné de egresados?: </label>
                            <div class="form-radios">
                                <div class="form-item"
                                     id="edit-submitted-actualmente-se-encuentra-laborando-1-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tienecarnet" name="tienecarnet" value="Si"
                                               class="form-radio"/> Si
                                    </label>
                                </div>
                                <div class="form-item"
                                     id="edit-submitted-actualmente-se-encuentra-laborando-2-wrapper">
                                    <label class="option">
                                        <input type="radio" id="tienecarnet" name="tienecarnet" value="No"
                                               class="form-radio"/> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                </div>
                <hr class="col-xs-12">
                <div class="row form-group col-md-12">
                    <h5>
                        <em>
                            <input type="checkbox" id="politica" name="politica" value="1" class="">&nbsp;
                            He leido y estoy de acuerdo con los terminos de la politica de tratamiento y privacidad de
                            la informacion. Ver politica
                            <a href="https://www.unbosque.edu.co/sites/default/files/2019-01/politica-privacidad-informacion-pagina-web-universidad-el-bosque.pdf"
                               target="_blank">aqui</a>.
                        </em>
                    </h5>
                </div>

                <div class="form-group col-md-12">
                    <input type="button" id="Enviar" name="Enviar" value="Enviar" class="btn btn-fill-green-XL">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
$piepagina = new piepagina;
$ruta = '../../';
echo $piepagina->Mostrar($ruta);
?>
</body>
</html>
