<?php
$ctrCnsUsuario = controlConsultaUsuario::ctrConsultausuario();
?>

<hr>
<h2 style="color: #FF9E08;">Información del Usuario</h2>
<div class="table-responsive text-center">
    <table class="table table-bordered table-condensed table-hover table-striped" id="myTable" style="font-size: 13px;">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">CodUsuario</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Terminación Contrato</th>
            <th>Actualizar</th>
        </tr>
        </thead>
        <tbody>

        <?php
        for ($i=1; $i<=count($ctrCnsUsuario); $i++){
            ?>

                <tr>
                    <td class="text-center"><?php echo $ctrCnsUsuario[$i]['contador']; ?></td>
                    <td id="idusuario_<?php echo $i;?>" class="text-left"><?php echo $ctrCnsUsuario[$i]['idAdministrativosDocentes'];?></td>
                    <td class="text-left"><?php echo $ctrCnsUsuario[$i]['nombreUsuarioAdministrativo'];?></td>
                    <td class="text-left"><?php echo $ctrCnsUsuario[$i]['numeroDocumento']; ?></td>
                    <td class="text-center"><?php echo $ctrCnsUsuario[$i]['terminacionContrato']; ?></td>
                    <td class="text-center">
                        <button type="submit" class="btn btn-success btnActualiza" id="btnsAccion_<?php echo $i;?>" value="">
                            <i class="fa fa-refresh fa-1x fa-fw success"></i>
                        </button>
                    </td>
                </tr>

          <?php  }
        ?>
        </tbody>
    </table>
    <form action="" id="frmActualizar" method="post">
        <input type="hidden" name="idAdministrativosDocentes" id="idAdministrativosDocentes" value="">
        <input type="hidden" name="accion" value="pasoActualizarAdministrativoDocente">
    </form>
</div>
