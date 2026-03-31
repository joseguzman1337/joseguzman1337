<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../../../../Connections/sala2.php');
$rutaado = "../../../../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)).'/../../../../../funciones/sala/estudiante/estudiante.php');

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
$idestudiantegeneral = $_SESSION['sissic_idestudiantegeneral'];
$estudiantegeneral = new estudiantegeneral($idestudiantegeneral);

if(isset($_REQUEST['guardarinformacionaspirante'])) {
    echo "<script type='text/javascript'>
            window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
    </script>";
    $estudiantegeneral->guardar();
}
?>
<html>
    <head><title>INFORMACIÓN BÁSICA</title>
        <link rel="stylesheet" href="../../../../../estilos/sala.css" type="text/css">
        <script type="text/javascript">
            function recargar(direccioncompleta, direccioncompletalarga)
            {
                document.informacionAspirante.direccion1.value=direccioncompletalarga;
                document.informacionAspirante.direccion1oculta.value=direccioncompleta;
            }

            function calcular_edad()
            {
                var fecha = document.informacionAspirante.fecha1.value;
                now = new Date()
                bD = fecha.split('-');
                if(bD.length == 3)
                {
                    born = new Date(bD[0], bD[1]*1-1, bD[2]);
                    years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
                }
                document.informacionAspirante.edad1.value = years;
                return years;
            }
        </script>
    </head>
    <body>
        <form action="" method="post" name="informacionAspirante">
            <fieldset>
                <legend>INFORMACIÓN BÁSICA</legend>
                <?php
                $estudiantegeneral->editar();
                ?>
                <table width="100%">
                    <tr>
                        <td align="left">
                            <input type="submit" name="guardarinformacionaspirante" id="guardarinformacionaspirante" value="Guardar">
                        <td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </body>
</html>
<script type="text/javascript">
    calcular_edad();
</script>