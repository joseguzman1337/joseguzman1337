<?php
/*
 * Ajustes de limpieza codigo y modificacion de interfaz
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
session_start();
include_once(realpath(dirname(__FILE__)) . '/../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once(realpath(dirname(__FILE__)) . '/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)) . '/../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/conexion/conexion.php');
?>
<meta charset="utf-8">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
<script language="Javascript">
    function abrir(pagina, ventana, parametros) {
        window.open(pagina, ventana, parametros);
    }
</script>
<?php
$query_detallegrupomateria = "select distinct dgm.idgrupomateria, gm.nombregrupomateria,m.nombremateria,m.codigomateria,c.nombrecarrera
from detallegrupomateria dgm,grupomateria gm,materia m,carrera c
where 
gm.idgrupomateria='" . $_GET['idgrupomateria'] . "'
and dgm.idgrupomateria=gm.idgrupomateria
and m.codigomateria=dgm.codigomateria
and m.codigocarrera=c.codigocarrera
order by m.nombremateria asc
";
$query_detallegrupomateria;
$detallegrupomateria = $sala->query($query_detallegrupomateria);
$row_detallegrupomateria = $detallegrupomateria->fetchRow();
?>
<body>
    <div class="container">
        <form name="form1" method="post" action="">
            <center><h2>LISTADO DE MATERIAS ASOCIADAS A GRUPO</h2></center>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th colspan="3" bgcolor="#CCDADD"><div align="center">GRUPO&nbsp;<?php echo $_GET['nombregrupomateria'] ?></div></th>
                    </tr>
                    <tr bgcolor="#CCDADD">
                        <th><div align="center">Codigo</div></th>
                        <th><div align="center">Materia</div></th>
                        <th><div align="center">Carrera</div></th>
                    </tr>
                    <?php do { ?>
                        <tr>
                            <td><div align="center"><?php echo $row_detallegrupomateria['codigomateria'] ?></div></td>
                            <td><div align="center"><?php echo $row_detallegrupomateria['nombremateria'] ?></div></td>
                            <td><div align="center"><?php echo $row_detallegrupomateria['nombrecarrera'] ?></div></td>
                        </tr>
                    <?php } while ($row_detallegrupomateria = $detallegrupomateria->fetchRow()) ?>
                    <tr>
                        <td colspan="3">
                            <div align="center">
                                <input class="btn btn-fill-green-XL" name="Nuevo" type="button" id="Nuevo" value="Nueva Asociaci&oacute;n" onclick="location.href = 'detallegrupomateria_nuevo_lista.php?idgrupomateria=<?php echo $_GET['idgrupomateria'] ?>&codigotipomateria=4-5&nombregrupomateria=<?php echo $_GET['nombregrupomateria'] ?>'">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="btn btn-fill-green-XL" name="" type="button" id="" value="Regresar" onclick="location.href = 'grupomateria_listado.php'">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</body>
<!--end-->