<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
include("modelo/modeloCarnetizacionGeneral.php");
$periodo=$_GET['periodo'];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro De Informacion Para Carnetizacion</title>
    <!-- CSS de Bootstrap -->
    <?php
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/select2.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/datatables.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/plugins/font-awesome/css/font-awesome.css");
    ?>
</head>
<body>
<div class="container-fluid">
    <form class="form-horizontal" role="form" name="f1" id="f1"  method="POST" action="#">
        <h3 class="text-center">CRITERIO DE BÚSQUEDA</h3><br>
        <div class="form-group">
            <label for="tipoUsuario" class="col-lg-3 control-label">*Seleccione Tipo de Usuario:</label>
            <div class="col-lg-3">
                <select name="tipoUsuario" id="tipoUsuario" class="form-control text-uppercase" required>
                    <option value="">Seleccionar</option>
                    <option value="1">Documento</option>
                    <option value="2">Tarjeta</option>
                </select>
            </div>
            <label for="busqueda_documento" class="col-lg-1 control-label">Documento:</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" name="busqueda_documento" id="busqueda_documento">
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn  btn-success" name="accion" id="accion" value="busquedaUsuario">Buscar</button>
            </div>
        </div>
    </form>
    <?php
    if (isset($_POST["accion"])){
        $accion = $_POST["accion"];
        if ($accion=="busquedaUsuario"){
            $tipoUsuario = $_POST["tipoUsuario"];
            $documento = $_POST["busqueda_documento"];

            if ($tipoUsuario == 1){
                $cnsUsuario =  modeloCarnetizacionGeneral::mdlAdministrativoDocenteDocumento($documento);
            }else if ($tipoUsuario == 2){
                $cnsUsuario =  modeloCarnetizacionGeneral::mdlAdministrativoDocenteTarjeta($documento);
            }
            if (!empty($cnsUsuario)){ ?>
            <br><br><br>

                <div class="container">

                    <div class="table table-responsive">
                        <table class="table-bordered table-striped table-hover table-condensed table-bordered" style="position:relative; width:100%;">
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                            </tr>
                            <tr>
                                <td><a href='editaresdocenadmin.php?documento=<?php echo $cnsUsuario[0]["numerodocumento"];?>&perido=<?php echo $periodo?>'><?php echo $cnsUsuario[0]["nombre"];?>&nbsp;</a></td>
                                <td><?php echo $cnsUsuario[0]["numerodocumento"];?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            <?php    }else{
            if($tipoUsuario == 2){
            $vacio = true;
            ?>
                <script language="JavaScript" type="text/javascript">
                    alert("La tarjeta a un no ha sido asignada");
                </script>
            <?php
            }else if($tipoUsuario == 1){ ?>
                <script language="JavaScript" type="text/javascript">
                    alert("El usuario no se encuentra, favor comunicarse con Talento Humano");
                </script>
                <?php
            }
            }
        }
    }
    ?>
</div>
<?php
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/datatables.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/select2.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/select2.full.min.js");
?>
</body>
</html>