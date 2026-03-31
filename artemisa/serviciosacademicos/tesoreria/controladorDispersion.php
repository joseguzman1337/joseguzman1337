<?php
require_once('DispersionFondos.class.php');
require_once('CargarArchivo.class.php');

$escorrecto = false;
if (isset($_REQUEST['enviar'])) {
    if (isset($_REQUEST['fecha']) && $_REQUEST['fecha'] != '') {
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_REQUEST['fecha'])) {
            $escorrecto = true;
        }
        else {
?>
            <script type="text/javascript">
                alert("La fecha digitada no es correcta");
                window.back();
            </script>
<?php
            //exit();
        }
    }
    else{
        $escorrecto = true;
    }
}
$carga = new CargarArchivo();
if ($escorrecto) {
    $carga->nombrearchivonuevo = '/tmp/dispersion.txt';
    $carga->tipospermitidos[] = 'text/plain';
    $carga->recibirArchivo();
    if ($carga->error == 0) {
        header('Content-type: ' . $carga->tipospermitidos[0]);
        header('Content-Disposition: attachment; filename="dispersion.txt"');
        $nuevadispersion = new DispersionFondos();
        $nuevadispersion->nombrearchivo = $carga->nombrearchivonuevo;
        $nuevadispersion->setCargarregistros();
        $nuevadispersion->imprimirRegistros();
    }
    else {
        echo "asdasd".$carga->mensaje;
    }

    // Con el archivo cargado hay que hacer los cambios necesarios
} else {
?>
    <html>
        <head>        
            <title>Dispersion de Fondos</title>        
            <link rel="stylesheet" type="text/css" href="../estilos/sala.css" />        
        </head>        
        <body>        
            <h1>Modificación en archivo plano de dispersión de fondos</h1>
    
            <table cellpadding="0" cellspacing="0" border="1">
                <tr>
                    <td>
                    <?php
                    $carga->formularioPrincipalConFecha();
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php
}
?>
