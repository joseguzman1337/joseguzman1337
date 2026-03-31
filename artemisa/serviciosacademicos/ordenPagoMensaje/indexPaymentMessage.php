<?php
session_start();
require_once('core/functionsPaymentsMessage.php');
require_once("../../sala/includes/adaptador.php");

$funtionsDb = new functionsPaymentsMessage($db);
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

    <!--css-->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="col-md-12 col-sm-12">
    <div>
        <button class="btn btn-info" onclick='location.href ="formCrearMensaje.php"'>Crear Mensaje</button>
    </div>
    <table id="example" class="table table-responsive table-striped table-bordered" style="width:100%">
        <thead>
        <tr style="background-color: #7BC142;color: #FFFFFF">
            <th class="text-center">#</th>
            <th class="text-center">Mensaje</th>
            <th class="text-center">Carrera</th>
            <th class="text-center">Usuario creación</th>
            <th class="text-center">fecha creación</th>
            <th class="text-center">Usuario modificación</th>
            <th class="text-center">fecha modificación</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cont = 1;
        foreach ($funtionsDb->listMessagePercentaje() as $list) {
            ?>
            <tr>
                <td><?php echo $cont?></td>
                <td><?php echo $list['mensaje'] ?></td>
                <td><?php echo $list['nombrecarrera'] ?></td>
                <td><?php echo $list['usuCrea'] ?></td>
                <td><?php echo $list['fechaCreacion'] ?></td>
                <td><?php echo $list['usuMod'] ?></td>
                <td><?php echo $list['fechaModificacion'] ?></td>
                <td style="background-color:
            <?php if ($list['estado'] == 'Activo') echo '#d5e0cb';
                else echo '#FFB9B3'; ?>"><?php echo $list['estado'] ?></td>
                <td>
                    <button class="btn btn-success" title="Editar"
                            onclick="window.location='formEditarMensaje.php?codigoOrdenPagoMensaje=<?php echo $list['codigoOrdenPagoMensaje']; ?>'">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                </td>
            </tr>
            <?php
            $cont++;
        }
        ?>
        </tbody>
    </table>

</div>
<?php
if (isset($_REQUEST['success'])) {
    echo '
        <script>
           swal("Correcto",
                    "Operación realizada correctamente",
                    "success");
        </script>  
    ';
}
if (isset($_REQUEST['error'])) {
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
        $(document).ready(function () {
            $('#example').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    })
</script>
</body>
</html>
