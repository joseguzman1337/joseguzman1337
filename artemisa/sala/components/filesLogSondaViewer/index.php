<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("GetJsonRoutesFilesLog.php");
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

$getListFiles = new GetJsonRoutesFilesLog($db);
$getListFiles->getFilesArray();

?>

<html>
<head>
    <script src="../../../assets/js/jquery-3.6.0.js"></script>
    <!--  Space loading indicator  -->
    <script src="../../assets/js/spiceLoading/pace.min.js"></script>

    <!--  loading cornerIndicator  -->
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/css/" rel="stylesheet">
    <script src="../../../assets/js/dataTableBootstrap4.js"></script>
    <link href="../../assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">

    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/dataTableBootstrap4.js"></script>
    <script src="../../../assets/js/sweetalert.min.js"></script>

</head>
<body>

<div class="col-md-12">
    <table id="tableFiles" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Archivo</th>
            <th>Ruta</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($getListFiles->getFilesArray() as $file){
        ?>
        <tr>
            <td><?php echo $file;?></td>
            <td>/libsoap/logsSondaEcollet/<?php echo $file?></td>
            <td>
                <a href="components/filesLogSondaViewer/downloadFile.php?archivo=<?php echo $file?>" class="glyphicon glyphicon-download"></a>
            </td>
        </tr>
        <?php
            }
        ?>

        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tableFiles').DataTable(
            {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            }
        );
    } );

    function descargar(file) {
        document.location='sala/components/filesLogSondaViewer/downloadFile.php?archivo='+file;
    }
</script>
</body>
</html>

