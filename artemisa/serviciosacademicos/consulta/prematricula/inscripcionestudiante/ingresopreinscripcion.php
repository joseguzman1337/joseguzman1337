<?php
    require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
    Factory::validateSession($variables);

    $pos = strpos($Configuration->getEntorno(), "local");
    if($Configuration->getEntorno()=="local" ||
        $Configuration->getEntorno()=="pruebas" ||
        $Configuration->getEntorno()=="Preproduccion" || $pos!==false){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_WARNING);
        require_once(PATH_ROOT.'/kint/Kint.class.php');
    }

    if (!isset($_REQUEST['referred'])) {
        @session_start();
        if (!isset($_SESSION['MM_Username'])) {
            $GLOBALS['MM_Username'];
            $_SESSION['MM_Username'] = "estudiante";
        } else {
            if (isset($_SESSION['codigocarrerasesion'])) {
                unset($_SESSION['codigocarrerasesion']);
            }
        }
    }
    if ($_SESSION['MM_Username'] == "estudiante") {
        ?>
        <a href="<?php echo HTTP_ROOT;?>/aspirantes/aspirantes.php" target="_top"
           id="aparencialinknaranja">Inicio</a>
        <?php
    }
?>
<html>
    <head>
        <title>Ingreso Aspirante</title>
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/custom.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/bootstrap.min.css");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
        ?>
    </head>
    <?php
    if (isset($_REQUEST['referred'])) {
        ?>
        <body id="educon-site">
        <?php
    } else {
        echo '<body> <div class="container">';
    }
    if (isset($_REQUEST['referred'])) {
        ?>
        <div>
            <div>
                <a href="http://www.uelbosque.edu.co/programas_academicos/educacion_continuada">
                <img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logo_educon.png"
                     alt="" class="logo-educon"></a>
            </div>
        </div>
            <div>
                <div>
                    <h1>PROCESO DE INSCRIPCIÓN</h1>
                    <div class="content clear-block">
                        Digite su número de documento:</p>
                </div>
                <div>
                    <form method="post" enctype="multipart/form-data" action="ingresopreinscripcion.php">
                        <div class="form-group col-xs-12 col-md-12">
                            <input type="hidden" name="referred" value="educontinuada">
                            <input type="text" name="documentoingreso" value="" class="form-control"s
                                   placeholder="Número de documento" required>
                        </div>
                        <?php
                        unset($_SESSION["numerodocumentosesion"]);
                        unset($_SESSION["modalidadacademicasesion"]);
                        unset($_SESSION["inscripcionsession"]);
                        if ($_POST['documentoingreso'] == true) {
                            if (!eregi("^[A-z0-9]{1,15}$", $_POST['documentoingreso'])) {
                                echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';
                                $banderagrabar = 1;
                            } else {
                                $documento = $_POST['documentoingreso'];

                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento&logincorrecto&referred=" . $_REQUEST['referred'] . "'>";
                            }
                        }
                        ?>
                        <div class="form-group col-xs-12 col-md-12">
                            <input type="submit" name="Ingresar" id="Ingresar" value="Ingresar"
                               class="btn btn-fill-green-XL">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row centered-form">
            <div class="panel-body form-group">
                <div class="row">
                    <div class="form-group col-md-12">
                        <h1>PROCESO DE INSCRIPCI&Oacute;N</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                    <p>Si ha estudiado en la Universidad con anterioridad ingrese por
                    <a href="<?php echo HTTP_ROOT;?>/aspirantes//usuarioaspirante/recuperarclave.php" target="_top">
                    Se te olvido la contraseña?</a>
                    de la pagina anterior y siga los pasos para  que el sistema
                    le envíe un usuario y una contraseña a su e-mail, si no digite su número de documento:</p>
                    </div>
                </div>
                <form role="form" name="f1" action="ingresopreinscripcion.php"
                      method="post" enctype="multipart/form-data">
                    <div class="form-group col-xs-12 col-md-12">
                            <?php if (isset($_REQUEST['referred'])) { ?>
                                <input type="hidden" name="referred" value="<?php echo @$_REQUEST['referred'] ?>">
                            <?php } ?>
                            <input type="text" name="documentoingreso" id="documentoingreso" class="form-control"
                                   value="<?php echo @$_POST['documentoingreso']; ?>"
                                   placeholder="Número de documento" required>
                    </div>
                    <?php
                    unset($_SESSION["numerodocumentosesion"]);
                    unset($_SESSION["modalidadacademicasesion"]);
                    unset($_SESSION["inscripcionsession"]);
                    if (!empty($_POST['documentoingreso'])) {
                        if (!eregi("^[A-z0-9]{1,15}$", $_POST['documentoingreso'])) {
                            echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';
                            $banderagrabar = 1;
                        } else {
                            $documento = $_POST['documentoingreso'];
                            if ($_SESSION['MM_Username'] == "estudiante") {
                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento'>";
                            } else {
                                if (!isset($_REQUEST['referred'])) {
                                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento&logincorrecto'>";
                                } else {
                                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento&logincorrecto&referred=" . $_REQUEST['referred'] . "'>";
                                }
                            }
                        }
                    }
                    ?>
                    <div class="form-group col-xs-12 col-md-12">
                            <input type="submit" id="Ingresar" name="Ingresar" value="Ingresar"
                                   class="btn btn-fill-green-XL" >
                    </div>
                </form>
            </div>
        </div>
        <?php
        }
        ?>
        </div>
    </body>
</html>