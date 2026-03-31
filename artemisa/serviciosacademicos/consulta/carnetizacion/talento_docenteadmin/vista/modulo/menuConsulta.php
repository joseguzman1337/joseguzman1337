<?php
$tiposUsuario = generalModelo::mdlTipoUsuario();
?>
<div class="container">
    <h3 style="color: #FF9E08;">BUSQUEDA E INGRESO DE ADMINISTRATIVOS Y DOCENTES</h3>
    <strong><small>Señor Usuario si desea consultar o modificar un Usario por favor seleccione el tipo de usuario y digite el número de documento, si desea ingresar un nuevo registro por favor presione el botón Nuevo Registro</small></></h5>
    <br><br>
    <div class="row">
            <div class="col-lg-12">
                <form class="form-inline" role="form" name="f1" id="f1"  method="POST" action="">
                    <div class="form-group">
                        <label for="tipoUsuario" class="col-lg-4 control-label">* Tipo Usuario</label>
                        <div class="col-lg-2">
                            <select name="tipoUsuario" id="tipoUsuario" class="form-control text-uppercase" required>
                                <option value="">Seleccionar</option>
                                <?php
                                foreach ($tiposUsuario as $clave => $valor) {
                                    $idTipoUsuario = $valor["idtipousuarioadmdocen"];
                                    $nombreTipoUsuario = strtoupper($valor["nombretipousuarioadmdocen"]);
                                    $estadoTipoUsuario = $valor["codigoestado"];
                                    ?>
                                    <option value="<?php echo $idTipoUsuario; ?>"><?php echo $nombreTipoUsuario; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numeroDocumento" class="col-lg-5 control-label">* Número Documento</label>
                        <div class="col-lg-2">
                            <input type="number" class="form-control" name="numeroDocumento" id="numeroDocumento" placeholder="123456789">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit"  name="accion" value="consultarUsuario" class="btn btn-default">Consultar</button>
                        </div>
                    </div>
                </form >
            </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form  class="form-horizontal" role="form"   method="POST" action="">
                <button type="submit"  name="accion" value="formAdministrativoDocente" class="btn btn-success">Crear Registro</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST["accion"])){
        $accion = $_POST["accion"];
        if ($accion == "consultarUsuario"){
            include('consultaUsuario.php');
        }
    }
    ?>
</div>
