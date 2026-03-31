<?php
session_start();
$ruta = "../";
require_once('claseordenpago.php');
require_once('../../Connections/sala2.php');
//require_once('../../../kint/Kint.class.php');
//require('../../../libsoap/class.getBank.php');
mysql_select_db($database_sala, $sala);

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

if (empty($_SESSION['MM_Username']) or $_SESSION['auth'] <> true or empty($_SESSION['rol'])) {
    $_SESSION['MM_Username'] = "sinpermisos";
    $_SESSION['auth'] = true;
    $_SESSION['rol'] = "xxx";
}/**/
?>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Orden de Pago</title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <!--  Jquery  -->
        <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
        <!--    <script src="--><?php //echo HTTP_SITE; ?><!--/assets/js/jquery-3.6.0.js"></script>-->
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>

        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
        <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Darker+Grotesque&display=swap');
        </style>
        <?php
        if (isset($_GET['pse'])) {
            ?>
            <script language="javascript">
                function NoAtras() {
                    history.go(1)
                }
            </script>
            <?php
        }
        ?>
    </head>
    <script language="javascript">
        function recargar(dir)
        {
            window.location.reload(dir);
            //history.go();
        }
    </script>
    <body <?php if (isset($_GET['pse'])) { ?>onLoad="NoAtras()"<?php } ?>>
        <form name="form2" method="post" action="../../../libsoap/class.sendws.php" onSubmit="return disableForm(this);" target="_parent">
            <?php
            $orden = new Ordenpago($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo'], $_GET['numeroordenpago']);


            $orden->visualizar_ordenpago("ORDEN DE PAGO");
            if (isset($_GET['pse'])) {
                $orden->visualizar_notasordenpago("<br>Le recomendamos cambiar su clave de correo por su seguridad");
                $orden->visualizar_ordenpagopse();
            } else {
                $orden->visualizar_notasordenpago("
NOTA: DIRIJASE A EL DEPARTAMENTO DE CRÉDITO Y CARTERA Y RECLAME SU ORDEN DE PAGO
<p> DOCUMENTO NO VALIDO PARA PAGO</p>
<p>Le recomendamos cambiar su clave de correo por su seguridad.</p>
	");
            }
            ?>
        </form>
        <?php

        $query_seldocumento = "SELECT eg.numerodocumento
from estudiantegeneral eg, estudiante e
where eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '" . $_GET['codigoestudiante'] . "'";
//echo $query_permisoimpresion;
        $seldocumento = mysql_query($query_seldocumento, $sala) or die("$query_seldocumento" . mysql_error());
        $totalRows_seldocumento = mysql_num_rows($seldocumento);
        $row_seldocumento = mysql_fetch_assoc($seldocumento);

        if ($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido") {
            ?>
            <font color="#800000" class="Estilo2"><a href="../../../libsoap/ayudapse/AyudaPSE.htm" id="aparencialinknaranja">NUEVO SISTEMA DE PAGO PSE</a></font><br><br>
            <?php
        }
        ?>
        <p>
        <form>
            <input type="button" class="btn btn-success" value="Regresar" onClick="history.go(-1)">
            <?php
            // Validación si esta orden puede ser eliminada
            // Para validar la orden se requiere que esta tenga concepto de matricula, y que se la orden más reciente en cuanto a matriculas
            // Es decir que si hay varias ordenes, aca solo se van a anular las que tengan conceptos de matricula, las demás no se toman en cuenta
            // Si el usuario tiene permiso para imprimir ordemes lo deja
            // En el menu de opciones el id de la impresion en el menu es el 31
            // Los permisos toca asignarlos por boton
            // Si tiene permiso para el boton 26 puede anular ordenes de pago
            //ajuste de usuario rol de la nuev validacion de julio 2016
            $query_permisoanulacion = "SELECT rol.idrol, u.usuario FROM
	usuariorol rol
INNER JOIN permisorolboton p on rol.idrol = p.idrol
INNER JOIN menuboton m ON m.idmenuboton = p.idmenuboton
INNER JOIN UsuarioTipo ut on  ut.UsuarioTipoId = rol.idusuariotipo  
INNER JOIN usuario u on ut.UsuarioId = u.idusuario
WHERE 
p.idmenuboton = '27' and m.codigoestadomenuboton = '01'
and u.usuario ='" . $_SESSION['MM_Username'] . "'";

            $permisoanulacion = mysql_query($query_permisoanulacion, $sala) or die("$query_permisoanulacion" . mysql_error());
            $totalRows_permisoanulacion = mysql_num_rows($permisoanulacion);
            $row_permisoanulacion = mysql_fetch_assoc($permisoanulacion);
            if ($totalRows_permisoanulacion != "") {
                if ($orden->valida_anulacionordenmatricula()) {
                    ?>
                    <input type="button" class="btn btn-danger" value="Anular Orden de Pago" onClick="anularoorden()">
                    <?php
                }
            }


            $orden->imprimir_ordenpdf($ruta . "ordenpago/", $nombre = "Imprimir orden para pago en bancos");
            ?>
        </form>

    </p>

</body>
</html>
<script language="javascript">
    function anularoorden()
    {
        if (confirm("¿Esta seguro de anular esta orden de pago?"))
        {
            //window.open('editardocente.php".$dirini."&grupo1=".$codigogrupo."&idgrupo1=".$idgrupo."','miventana','width=500,height=400,left=150,top=100,scrollbars=yes')
            window.open("anularordenprematricula.php<?php echo "?numeroordenpago=" . $_GET['numeroordenpago'] . "&codigoestudiante=" . $_GET['codigoestudiante'] . "&codigoperiodo=" . $_GET['codigoperiodo'] . "&documentoingreso=" . $row_seldocumento['numerodocumento'] . ""; ?>", "miventana", "width=500,height=400,left=150,top=100,scrollbars=yes");
        }
    }
</script>
