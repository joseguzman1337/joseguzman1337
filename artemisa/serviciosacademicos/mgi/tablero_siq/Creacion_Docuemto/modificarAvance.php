<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se cambia la libreria del editor de texto y se cambia la interfaz grafica
 * @since Agosto 15, 2019
 */ 

session_start();
include_once('../../../utilidades/ValidarSesion.php');
require_once("../../datos/templates/template.php");
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include_once('oportunidad.php');
$precarga = precargarAvances($db, $_REQUEST['id']);
?>
<!DOCTYPE html>
<html>
    <head>

        <script type="text/javascript" language="javascript" src="../../../../sala/assets/js/jquery-3.1.1.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../sala/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../assets/js/bootstrap-filestyle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../../../sala/assets/css/bootstrap.min.css" />   
        <script type="text/javascript" language="javascript" src="../../../../sala/assets/plugins/bootstrap-validator/bootstrapValidator.js"></script>
        <link rel="stylesheet" type="text/css" href="../../../../sala/assets/plugins/bootstrap-validator/bootstrapValidator.min.css" />   
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css"> 
        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css"> 
        <link rel="stylesheet" href="../../../../sala/assets/jQueryRichText/src/richtext.min.css">
        <script type="text/javascript" src="../../../../sala/assets/jQueryRichText/src/jquery.richtext.js"></script>

        <script type="text/javascript" language="javascript" src="oportunidad.js"></script>

        <meta charset="UTF-8">
        <title>Modificar avances</title>
    </head>
    <body>
        <div id="pageContainer">
            <center>
                <h2>&nbsp;Modificar avances </h2>  
            </center>
        </div>
        <form class="form-horizontal" id="modificarAvance">
            <div class="panel-body">
                <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id'] ?>">
                <input type="hidden" id="tipoAccion" name="tipoAccion" value="modificarAvance">

                <div class="form-group" id="registrar">
                    <label for="descripcion" class="col-sm-3 control-label">Valoración</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="Valoracion" min="0" max="100" id="Valoracion" value="<?php echo $precarga["Valoracion"]; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="col-sm-3 control-label">Descripción del avance</label>
                    <div class="col-sm-6">
                        <div class="page-wrapper box-content">
                            <textarea id="avanceevidencia" name="avanceevidencia" class="content" rows="10" placeholder=""><?php echo $precarga["descripcionavance"]; ?></textarea>
                        </div>
                    </div>
                </div>   
                <center>
                    <button type="submit" id="accionAvance" class="btn btn-fill-green-XL">Guardar</button>
                    <button class="btn btn-fill-green-XL" onclick="window.history.go(-1); return false;">Regresar</button>
                </center>
            </div>            
        </form>
    </body>
</html>
