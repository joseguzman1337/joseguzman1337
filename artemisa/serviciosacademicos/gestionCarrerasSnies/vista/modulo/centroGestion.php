<?php
    $carrerasSnies = controladorCarrera::ctrCarreraSnies();
    $programasUbosque = controladorCarrera::ctrProgramaUbosque();
    ?>
<div class="container">
    <h2>Gestion  de Carreras</h2><hr>

    <div class="form-group">
        <button class="btn btn-success btn-labeled fa fa-plus-circle btnAccionSnies" id="crear" data-toggle="modal" data-target="#modalFormuulariosnies">Crear Carrera Snies</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-condensed table-hover table-bordered" id="tbCarreras">
            <caption class="caption"> Carreras Snies</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Snies</th>
                    <th>Carrera</th>
                    <th>Fech inicio</th>
                    <th>Fecha fin</th>
                    <th>Modificar</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($carrerasSnies as $key => $value) {
                $contador = $value["contador"];
                $idCarreraRegistro = $value["idCarreraRegistro"];
                $codigoSniesCarreraRegistro = $value["codigoSniesCarreraRegistro"];
                $numeroRegistroCarreraRegistro = $value["numeroregistrocarreraregistro"];
                $codigoCarrera = $value["codigoCarrera"];
                $fechaInicioCarreraRegistro = $value["fechaInicioCarreraRegistro"];
                $nombreCarrera = $value["nombreCarrera"];
                $fechaInicioCarreraRegistro = $value["fechaInicioCarreraRegistro"];
                $fechaFinalCarreraRegistro = $value["fechaFinalCarreraRegistro"];
            ?>
                <tr class="filas" id="fila_<?php echo $contador;?>">
                    <td><?php echo $contador;?></td>

                    <td><?php echo trim($idCarreraRegistro);?>
                        <input type="hidden" id="codigoCarrera_<?php echo $contador;?>" name="codigoCarrera" value="<?php echo $codigoCarrera;?>">
                        <input type="hidden" id="idCarreraRegistro_<?php echo $contador;?>" name="idCarreraRegistro" value="<?php echo $idCarreraRegistro;?>">
                    </td>
                    <td id="codigoSnies_<?php echo $contador;?>"><?php echo $codigoSniesCarreraRegistro;?></td>
                    <td id="nombreCarrera_<?php echo $contador;?>"><?php echo $nombreCarrera;?></td>
                    <td id="fechaInicio_<?php echo $contador;?>"title="fecha Inicio Carrera Registro" ><?php echo $fechaInicioCarreraRegistro;?></td>
                    <td id="fechaFin_<?php echo $contador;?>" title="fecha Final Carrera Registro"><?php echo $fechaFinalCarreraRegistro;?></td>
                    <td class="text-center">
                        <span class="fa fa-pencil-square-o fa-lg text-success btnAccionSnies" id="modificar_<?php echo $contador;?>" data-toggle="modal" data-target="#modalFormuulariosnies" style="cursor: pointer;"></span>
                    </td>
                </tr>
            <?php
            }?>
            </tbody>
        </table>
    </div>
    <div id="cargaCarrera"></div>
</div>
<?php include('modalFomularioSnies.php'); ?>