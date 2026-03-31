<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package templates
 */
defined('_EXEC') or die;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Unificacion de documentos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $test; ?></h3>
            </div>
        </div>
        <br><br>
        <div class="container">

            <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">

                <div class="panel panel-default panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><strong>Unificación de documento</strong></h3>
                    </div>

                    <div class="panel-body">
                        <div id="msn"></div>
                        <form name="formu" action="<?php echo HTTP_SITE; ?>/index.php"  id="formu">
                            <div class="form-group">
                                <label for="tipodocumento">Tipo documento antiguo:</label>
                                <select class="form-control" name="cbmTipoDocumentoAnterior" id="cbmTipoDocumentoAnterior">
                                    <option value="">Seleccionar tipo documento Antiguo</option>
                                    <?php foreach ($Documento as $tipoDocumentoGenerala) { ?>
                                        <option value="<?php echo $tipoDocumentoGenerala->getTipoDocumento(); ?>"><?php echo $tipoDocumentoGenerala->getNombreDocumento(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div id="errorTipoDocumentoAntiguo"></div>
                            </div>
                            <div class="form-group">
                                <label for="documentoAnterior">Número documento antiguo:</label>
                                <input type="text" class="form-control" id="txtDocumentoAnterior" placeholder="Registre número documento antiguo" name="txtDocumentoAnterior" autocomplete="off" >
                                <input type="hidden" name="idEstudianteGenaralAntiguo" id="idEstudianteGenaralAntiguo" value="">
                                <div id="errordocumentoAnterior"></div>
                                <div id="nombreestudiante"></div>
                            </div>

                            <div class="form-group">
                                <label for="tipodocumento">Tipo documento nuevo:</label>
                                <select class="form-control" name="cbmTipoDocumentoNuevo" id="cbmTipoDocumentoNuevo">
                                    <option value="">Seleccionar tipo documento nuevo</option>
                                    <?php foreach ($Documento as $tipoDocumentoGeneraln) { ?>
                                        <option value="<?php echo $tipoDocumentoGeneraln->getTipoDocumento(); ?>"><?php echo $tipoDocumentoGeneraln->getNombreDocumento(); ?></option>
                                    <?php } ?>
                                </select>
                                <div id="errorTipoDocumentoNuevo"></div>
                            </div>

                            <div class="form-group">
                                <label for="DocumentoNuevo">Número documento nuevo:</label>
                                <input type="text" class="form-control" id="txtDocumentoNuevo"  placeholder="Registre número documento nuevo" name="txtDocumentoNuevo" autocomplete="off">
                                <input type="hidden" name="idEstudianteGenaralNuevo" id="idEstudianteGenaralNuevo" value="">
                                <div id="errordocumentoNuevo"></div>
                                <div id="nombreestudiantenuevo"></div>
                            </div>

                            <div class="form-group" >
                                <button type="submit" class="btn btn-success col-xs-12 col-md-4 col-md-offset-4" id="btnActualizar">Actualizar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



<?php
//Bootstrap Validator [ OPTIONAL ]
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");

echo Factory::printImportJsCss("js", HTTP_SITE . "/components/unificacionDocumento/assets/js/unificacionDocumento.js");
