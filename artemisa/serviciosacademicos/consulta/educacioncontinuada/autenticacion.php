<?php

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
/*listo certificados*/
$sqlListado = "SELECT * FROM  diploma WHERE codigoestado=100"; 
$datosList = $db->GetAll($sqlListado);
function authenticate()
{
    header('WWW-Authenticate: Basic realm="Descarga de certificados: El usuario es foro y la clave es su número de documento"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Debe entrar un login y un password autorizado\n";
?>
<a href="javascript:window.location.href='autenticacion.php'">Volver</a>
<?php
    exit;
}

function esValido($documento)
{
    global $db;
    $query_datos = "select idasistente, tipodocumento, documentoasistente, concat(apellidoasistente,' ', nombreasistente) as nombre
    from asistente
    where documentoasistente = '".$documento."'";
    $datos = $db->Execute($query_datos);
    $totalRows_datos = $datos->RecordCount();
    $row_datos = $datos->FetchRow();
    if($totalRows_datos > 0)
    {        
        return true;
        
    }
    else
    {
        return false;
    }
}
if(isset($_REQUEST['documento']))
{
    if(esValido($_REQUEST['documento']))
    {
        if($_REQUEST['iddiploma']=='8')
            {
            $query_datos = "select idasistente 
            from asistente
            where documentoasistente = '".$_REQUEST['documento']."'";
            $datos = $db->Execute($query_datos);
            $totalRows_datos = $datos->RecordCount();
            $row_datos = $datos->FetchRow();
            $idasistente=$row_datos['idasistente'];
            //echo $idasistente;
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuesta/encuestaeducontinuada/encuestaeducontinuada.php?idasistente=".$idasistente."'>";
        }
        else{
        header("Location: popupcertificados.php?documento=".$_REQUEST['documento']."&iddiploma=".$_REQUEST['iddiploma']);    
        }

    }
    else{
?>
<script language="JavaScript">
    alert("El documento digitado no se encuentra, por favor revise el número de documento e ingréselo nuevamente");
</script>
<?php
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
    <link type="text/css" rel="stylesheet" href="../../../sala/assets/css/bootstrap.min.css" >
</head>
<body>
<div class="container-fluid" >
        <div class="container">
        <form method="POST" action="" name="f1">
            <input type="hidden" name="iddiploma" value="<?php echo $_REQUEST['iddiploma'];?>">
            <table class="table table-bordered table-striped table-condensed">
                <tr>
                    <td colspan="2"><b>Digite su numero de documento</b></td>
                </tr>
                <tr>
                    <td>Documento Asistente</td>
                    <td><input type="text" class="form-control" name="documento" value="" /></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" class="btn btn-block btn-success" name="Descargar" value="Descargar">Descagar Certificado</button></td>
                </tr>
            </table>
        </form>
        </div>
    <div class="container">
        <table class="table table-striped table-bordered table-condensed tab-content">
            <thead>
                <th>Id Diploma</th>
                <th>Nombre</th>
                <th>Asistente Ejemplo</th>
            </thead>
            <tbody>

    <?php
    $n=1;
    if (isset($_GET["verCertificado"])) {
        foreach ($datosList as $key => $value) {
            $sql = "SELECT a.documentoasistente 
                FROM asistentediploma ad, asistente a  
                WHERE ad.idasistente=a.idasistente AND ad.iddiploma = " . $value["iddiploma"] . " LIMIT 1";
            $datosAsis = $db->GetAll($sql);

            ?>

                    <tr>
                        <td><?php echo $value["iddiploma"];?></td>
                        <td><a href="certificados.php?documento=<?php echo $datosAsis[0]["documentoasistente"] . "&iddiploma=" . $value["iddiploma"]; ?>" target="_blank"><?php echo $value["nombrediploma"];?></a></td>
                        <td><?php echo $datosAsis[0]["documentoasistente"];?></td>
                    </tr>
        <?php $n++; }
    }
    ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>



