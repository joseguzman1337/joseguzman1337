<?php
 $fechaActual = date('Y-m-d');
if (isset($_GET['accion'])){
    $accion = $_GET['accion'];

     $codGeneral = $_GET['Codgeneral'];
     $idCarrera = $_GET['idCarrera'];
     $codigoSnies = $_GET['idCarrera'];
}
?>
<div class="modal fade" id="modalFormuulariosnies" role="dialog" aria-labelledby="modalFormuulariosnies" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="#" class="form form-horizontal" id="frmGestion">
                <div class="modal-header">
                    <h3 class="modal-title" id="tituloModal">Modal title</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                            <input type="hidden" name="contadorFila" id="contadorFila" value="<?php echo $contador;?>">
                            <div class="form-group" id="groupGeneral">
                                <label for="identificador">Codigo general:</label>
                                <input type="number" class="form-control" id="identificador" name="identificador" readonly>
                            </div>
                            <div class="form-group">
                                <label for="selecCarrera">Carrera:</label>
                                <select name="selecCarrera" class="form-control" id="selecCarrera" required style="width: 99%;">
                                    <option value="">Seleccione..</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fechaInicioCarrera">Fecha Inicio carrera snies:</label>
                                <input type="date" name="fechaInicioCarrera" class="form-control" id="fechainicioCarrera" readonly value="<?php echo $fechaActual;?>">
                            </div>
                            <div class="form-group">
                                <label for="fechaFinCarrera">Fecha final carrera snies:</label>
                                <input type="date" name="fechaFinCarrera" class="form-control" id="fechaFinCarrera" required=”required”>
                                <input type="hidden" id="ejecucionAjax" name="ejecucionAjax" value="0">
                            </div>
                            <div class="form-group">
                                <label for="codigoSnies">Codigo snies carrera registro:</label>
                                <input type="number" class="form-control" id="codigoSnies" name="codigoSnies" required=”required”>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="statusMsg" class="alert" role="alert">.</div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-primary" id="accion" name="accion" value="0"></button>
                </div>
            </form>
        </div>
    </div>
</div>
