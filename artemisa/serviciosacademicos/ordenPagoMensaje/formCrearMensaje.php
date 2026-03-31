<?php
session_start();
require_once('core/functionsPaymentsMessage.php');
require_once("../../sala/includes/adaptador.php");

$funtionsDb = new functionsPaymentsMessage($db);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
?>
<html lang="es">
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8"/>
    <title>Mensajes Orden de Pago</title>
    <!--  Scripts  -->

    <script src="../../assets/js/jquery-3.6.0.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTableBootstrap4.js"></script>
    <script src="../../assets/js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"
            integrity="sha256-d/edyIFneUo3SvmaFnf96hRcVBcyaOy96iMkPez1kaU=" crossorigin="anonymous"></script>
    <!--css-->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css"
          integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous"/>

</head>
<body>
<div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1 ">
    <form action="ajaxfuntions.php">
        <input type="hidden" name="opcion" value="2">
        <div class="row">
            <div class="col-md-12 text-center" style="background-color: #7BC142;color: #FFFFFF">
                <h4>Crear mensaje de orden pago</h4>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-4">
                <label for="modalidad">Modalidad academica</label>
                <select name="modalidad" id="modalidad" class="form-control" onchange="selectPrograma(this.value)">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($funtionsDb->listModalities() as $modalidad) {
                        ?>
                        <option value="<?php echo $modalidad['codigomodalidadacademica'] ?>"><?php echo $modalidad['nombremodalidadacademica'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="codigocarrera">Programa academico</label>
                <select name="codigocarrera" id="codigocarrera" class="form-control" required>
                    <option value="">Seleccione una modalidad</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Seleccione..</option>
                    <option value="100">Activo</option>
                    <option value="200">Inactivo</option>
                </select>
            </div>

        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <label for="mensaje">Mensaje para orden de pago</label>
                <textarea class="form-control" required name="mensaje" id="mensaje" maxlength="500"
                          placeholder="Escriba el mensaje (max 500 caracteres)"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <button  class="btn btn-danger" onclick="window.location='indexPaymentMessage.php'">
                        Regresar
                    </button>
                </div>
                <div class="col-md-6">
                    <input type="submit" name="guardar" id="guardar" class="btn btn-success pull-right">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if(isset($_REQUEST['success']))
{
    echo '
        <script>
           swal("Correcto",
                    "Operación realizada correctamente",
                    "success");
        </script>  
    ';
}
if(isset($_REQUEST['error']))
{
    echo '
        <script>
           swal("Error",
                    "Algo ha salido mal ",
                    "error");
        </script>  
    ';
}
?>
<script>
    $(document).ready(function () {
        $('#modalidad').select2();
        $('#codigocarrera').select2();
        $('#estado').select2();
    });

    function selectPrograma(value) {
        $.ajax({
            url: 'ajaxfuntions.php',
            type: 'POST',
            data:
                {
                    opcion: 1,
                    idModalidad: value
                },
            success: function (data) {
                $('#codigocarrera').html(data);
                $('#codigocarrera').select2();
            },
            error: function () {
                swal('Error',
                    'Algo a salido mal, por favor comuniquese con Tecnología',
                    'error');
            }
        });
    }


</script>
</body>
</html>
