<?php
$cnsTipoDocumentos = generalModelo::mdlTipoDocumento();
$cnsGrupoSanguineo = generalModelo::mdlGrupoSanguineo();
$cnsTipoUsiario = generalModelo::mdlTipoUsuario();
$cnsGenerousuario = generalModelo::mdlGeneroUsuario();

// rellenar fomulario si existe el id
$cnsUsuarioId ='';
if (isset($_POST["idAdministrativosDocentes"])){
    $cnsUsuarioId= generalModelo::mdlConsultaUsuarioId($_POST["idAdministrativosDocentes"]);
    $sqlNombre = $cnsUsuarioId[0]["nombresadministrativosdocentes"];
    $sqlApellido = $cnsUsuarioId[0]["apellidosadministrativosdocentes"];
    $sqlTipoDocumento = $cnsUsuarioId[0]["tipodocumento"];
    $sqlNumeroDocumento = $cnsUsuarioId[0]["numerodocumento"];
    $sqlExpedicionDocumento = $cnsUsuarioId[0]["expedidodocumento"];
    $sqlIdGruposSanguineo = $cnsUsuarioId[0]["idtipogruposanguineo"];
    $sqlIdGenero = $cnsUsuarioId[0]["codigogenero"];
    $sqlCelular = $cnsUsuarioId[0]["celularadministrativosdocentes"];
    $sqlEmail = $cnsUsuarioId[0]["emailadministrativosdocentes"];
    $sqlEmailInstitucional = $cnsUsuarioId[0]["EmailInstitucional"];
    $sqlDireccion = $cnsUsuarioId[0]["direccionadministrativosdocentes"];
    $sqlTelefono = $cnsUsuarioId[0]["telefonoadministrativosdocentes"];
    $sqlFechaTerminaContrato = $cnsUsuarioId[0]["fechaterminancioncontratoadministrativosdocentes"];
    $date = date_create($sqlFechaTerminaContrato);

    $sqlCargo = $cnsUsuarioId[0]["cargoadministrativosdocentes"];
    $sqlCodigoEstado = $cnsUsuarioId[0]["codigoestado"];
    $sqlIdTipoUsuario = $cnsUsuarioId[0]["idtipousuarioadmdocen"];

}

?>
<div class="container">
    <form class="form-horizontal" role="form" name="f2" id="f2"  method="POST" action="">
        <?php
            if($_POST["accion"]== 'formAdministrativoDocente'){ ?>
                   <h4 id='tituloProceso' style="color: #FF9E08;">Ingreso Nuevo Usuario</h4>
                <input type="hidden" name="idadministrativosdocentes" id="idadministrativosdocentes" value="">
                <?php
            }else{?>
                <h4 id="tituloProceso" style="color: #FF9E08;">Edicion Administrativos Y Docentes</h4>
                <input type="hidden" name="idadministrativosdocentes" id="idadministrativosdocentes" value="<?php echo $_POST["idAdministrativosDocentes"];?>">
                <?php
                if (isset($_POST['numeroDocumento'])){
                    $tipoUsuario = $_POST['tipoUsuario'];
                    $numeroDocumento = $_POST['numeroDocumento'];
                }

            }?>
        <style>
            .iconoObligatorio{
                background:#D9D9D6;
            }
        </style>
        <hr>
        <h6 class="text-danger">Los campos marcados con (*) Son Obligatorios</h6>
        <!--Filas-->
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <select name="tipodocumento" id="tipodocumento" class="form-control" data-toggle="tooltip" data-placement="top" title="Tipo Documento Usuario" required >
                        <option value="">Tipo documento</option>
                        <?php
                        foreach ($cnsTipoDocumentos as $clave => $valor) {
                            $tipoDocumento = $valor["tipodocumento"];
                            $nombreDocumento = $valor["nombredocumento"];
                            if ($tipoDocumento<>0){
                            ?>
                            <option value="<?php echo $tipoDocumento; ?>" <?php if (!empty($cnsUsuarioId)){ if($tipoDocumento==$sqlTipoDocumento){ echo "Selected";}} ?>><?php echo $nombreDocumento; ?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="numerodocumento" id="numerodocumento" class="form-control" placeholder="Documento ej: 123456789" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlNumeroDocumento."'";}else{ echo "disabled"; }?> data-toggle="tooltip" data-placement="top" title="Numero Documento Usuario" required>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="expedidodocumento" id="expedidodocumento" class="form-control" placeholder="Expedicion Doc:" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlExpedicionDocumento."'";}?> data-toggle="tooltip" data-placement="top" title="Expedicion de Documento U..." required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlApellido."'";}?> data-toggle="tooltip" data-placement="top" title="Apellidos Usuario" required>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                  <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlNombre."'";}?> data-toggle="tooltip" data-placement="top" title="Nombres Usuario" required>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                  <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <select name="tipogruposanguineo" id="tipogruposanguineo" class="form-control" data-toggle="tooltip" data-placement="top" title="Grupo Sanguineo Usuario" required>
                        <option value="">Grupo Sanguineo</option>
                    <?php
                        foreach ($cnsGrupoSanguineo as $clave => $valor) {
                            $idTipoGrupoSanguineo = $valor["idtipogruposanguineo"];
                            $nombreTipoGrupoSanguineo = strtoupper(trim($valor["nombretipogruposanguineo"]));
                            if ($nombreTipoGrupoSanguineo !=''){
                            ?>
                            <option value="<?php echo $idTipoGrupoSanguineo; ?>" <?php if (!empty($cnsUsuarioId)){ if($idTipoGrupoSanguineo==$sqlIdGruposSanguineo){ echo "Selected";}} ?> ><?php echo $nombreTipoGrupoSanguineo; ?></option>
                            <?php
                            }
                        }
                    ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <select name="genero" id="genero" class="form-control" data-toggle="tooltip" data-placement="top" title="Genero Usuario" required>
                        <option value="">Genero</option>

                        <?php
                        foreach ($cnsGenerousuario as $clave => $valor) {
                            $codigoGenero = $valor["codigogenero"];
                            $nombreGenero = strtoupper($valor["nombregenero"]);
                            ?>
                            <option value="<?php echo $codigoGenero; ?>" <?php if (!empty($cnsUsuarioId)){ if($codigoGenero==$sqlIdGenero){ echo "Selected";}}?> ><?php echo $nombreGenero; ?></option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <select name="tipousuarioadmdocen" id="tipousuarioadmdocen" class="form-control" data-toggle="tooltip" data-placement="top" title="Tipo Usuario" required>
                        <option value="">Tipo usuario</option>
                        <?php
                        foreach ($cnsTipoUsiario as $clave => $valor) {
                            $idTipoUsuario = $valor["idtipousuarioadmdocen"];
                            $nombreTipoUsuario = strtoupper($valor["nombretipousuarioadmdocen"]);
                            $estadoTipoUsuario = $valor["codigoestado"];
                            ?>
                            <option value="<?php echo $idTipoUsuario; ?>" <?php if (!empty($cnsUsuarioId)){ if($idTipoUsuario==$sqlIdTipoUsuario){ echo "Selected";}}?> ><?php echo $nombreTipoUsuario; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                   <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular ej: 3152845" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlCelular."'";}?> data-toggle="tooltip" data-placement="top" title="Numero Celular Usuario" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Correo, ej: @gmail.com" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlEmail."'";}?>data-toggle="tooltip" data-placement="top" title="Correo Institucional Usuario" required>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion ej: Cll Falsa Av 123" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlDireccion."'";}?>data-toggle="tooltip" data-placement="top" title="Direccion" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono ej: 744589" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlTelefono."'";}?> data-toggle="tooltip" data-placement="top" title="Telefono" required>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                      <button class="btn btn-default text-danger iconoObligatorio" type="button"><i class="text-danger">*</i></button>
                  </span>
                    <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo ej: Aux Administrativo" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlCargo."'";}?> data-toggle="tooltip" data-placement="top" title="Cargo Usuario" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default iconoObligatorio" type="button"><i>-</i></button>
                  </span>
                    <input type="datetime-local" name="fechavigencia" id="fechavigencia" class="form-control" value="<?php if (!empty($cnsUsuarioId)){ echo  date_format($date, 'Y-m-d');}?>" data-toggle="tooltip" data-placement="top" title="Fecha Fin Contrato Usuario">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default iconoObligatorio" type="button" title="Campo Opcional"><i>-</i></button>
                  </span>
                    <input type="email" name="emailInstitucional" id="emailInstitucional" class="form-control" placeholder="Email Institucional" <?php if (!empty($cnsUsuarioId)){ echo "value='".$sqlEmailInstitucional."'";}?> data-toggle="tooltip" data-placement="top" title="Email Usuario">
                </div>
            </div>
        </div>
        <div class="panel-footer text-center col-lg-6">
            <button type="submit" class="btn btn-success btn-labeled fa fa-floppy-o" name="accion" id="accion" <?php if (!empty($cnsUsuarioId)){ echo 'value="actualizarAdministrativoDocente"';}else{echo 'value="crearAdministrativoDocente"';}?> >
                <?php
                if (!empty($cnsUsuarioId)){echo "Actualizar";}else{ echo "Guardar";}
                ?>
            </button>
        </div>
        <div class="panel-footer text-center col-lg-6">
                <button type="button" class="btn btn-danger btn-labeled fa fa-arrow-left" name="accion" id="btnRegresar" value="">Regresar</button>
        </div>
    <div id="complementaFormulario"></div>

        <form action="" method="post">
        </form>


</div>