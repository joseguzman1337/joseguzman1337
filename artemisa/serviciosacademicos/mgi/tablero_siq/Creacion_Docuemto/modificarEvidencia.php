<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
require_once("../../datos/templates/template.php");
require('oportunidad.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
$id = $_REQUEST["id"];
$evidencias = verEvidenciaActualizar($id,$db);
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
        <script type="text/javascript" language="javascript" src="oportunidad.js"></script>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<script>
$(":file").filestyle({input: false});
$(".buttonText").html("Seleccionar archivo");
</script>
<body>
    <form class="form-horizontal" id="actualizarEvidencia" enctype="multipart/form-data">
            <div class="panel-body">
                <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']?>">
                <input type="hidden" id="tipoAccion" name="tipoAccion" value="modificarEvidencia">
                    <div class="form-group" id="registrar">
                            <label for="archivo" class="col-sm-3 control-label">Archivo Actual</label>
                            <div class="col-sm-6">
                                   <label class="custom-file">
                                       <a href="<?php echo $evidencias["Ubicacion_url"].$evidencias["nombre"]?>" download><?php echo $evidencias["nombre"]?></a>
                                       <input type="hidden" id="archivoActual" name="archivo" value="<?php echo $evidencias["nombre"]?>" >
                                  </label>
                            </div>
                    </div>    
                    <div class="form-group" id="registrar">
                            <label for="archivo" class="col-sm-3 control-label">Modificar Archivo</label>
                            <div class="col-sm-6">
                                   <label class="custom-file">
                                        <input type="file" id="archivo" name="archivo" class="filestyle" data-input="false">
                                        <span class="custom-file-control"></span>(Excel,Pdf,Word)
                                  </label>
                            </div>
                    </div>
                
                  <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Nombre de la evidencia</label>
                            <div class="col-sm-6">
                                <textarea placeholder="Descripcion" name="descripcion" class="form-control" id="descripcion" type="text"><?php echo $evidencias["descripcion"]?></textarea>
                            </div>
                    </div>
                 </div>
            <button type="submit" id="accionActualizar" class="btn btn-default">Actualizar</button>
    </form>
</body>

</html>