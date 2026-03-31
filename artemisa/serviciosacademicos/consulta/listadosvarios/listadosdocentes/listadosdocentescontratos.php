<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');
session_start();
?>
<html>
    <head>
        <title>Listado Docentes con Contrato</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<table width="100%" align="center">
<TR><TD align="center"><img src="../../../../imagenes/noticias_logo.gif" height="71" ></TD></TR>
    <tr>
<td align="center"><h2>LISTADO DOCENTES CON CONTRATO EN  <?php
            if($_REQUEST['nacodigocarrera'] != 'todas') {
            echo $_REQUEST['nanombrecarrera'];
        }
            else{
                echo "TODAS LAS CARRERRAS";
                }

                ?></h2>

        </td>
    </tr>
</table>
<form action="" method="post" name="f1">
<?php

if ($_REQUEST['nacodigomodalidadacademica'] == 100 || 200 || 300 || 400 || 500 || 600){
    if($_REQUEST['nacodigocarrera'] == 'todas') {
        $query="select distinct d.numerodocumento, d.apellidodocente,d.nombredocente, tc.nombretipocontrato,c.fechainiciocontratodocente, c.fechafinalcontratodocente, dc.horasxsemanadetallecontratodocente, e.nombreescalafon, ca.nombrecarrera
        from docente d, contratodocente c, detallecontratodocente dc, tipocontrato tc, escalafon e, carrera ca
        where d.iddocente = c.iddocente
        and c.idcontratodocente = dc.idcontratodocente
        and c.codigoestado like '1%'
        and dc.codigoestado like '1%'
        and d.codigoestado like '1%'
        and tc.codigotipocontrato = c.codigotipocontrato
        and e.codigoescalafon = c.codigoescalafon
        and dc.codigocarrera=ca.codigocarrera
        and ca.codigomodalidadacademica='".$_REQUEST['nacodigomodalidadacademica']."'";
      }
    else {
        $query="select distinct d.numerodocumento, d.apellidodocente,d.nombredocente, tc.nombretipocontrato,c.fechainiciocontratodocente, c.fechafinalcontratodocente, dc.horasxsemanadetallecontratodocente, e.nombreescalafon
        from docente d, contratodocente c, detallecontratodocente dc, tipocontrato tc, escalafon e
        where d.iddocente = c.iddocente
        and c.idcontratodocente = dc.idcontratodocente
        and c.codigoestado like '1%'
        and dc.codigoestado like '1%'
        and d.codigoestado like '1%'
        and dc.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
        and tc.codigotipocontrato = c.codigotipocontrato
        and e.codigoescalafon = c.codigoescalafon";
        }
}

$linkadd = "&nacodigocarrera=".$_REQUEST['nacodigocarrera']."&naenviar=".$_REQUEST['naenviar']."&nanombrecarrera=".$_REQUEST['nanombrecarrera']."&nacodigomodalidadacademica=".$_REQUEST['nacodigomodalidadacademica'];
$filter = "";
$rows_per_page=10;
if($_REQUEST['row_page'] != "") {
        $rows_per_page = $_REQUEST['row_page'];
}

$array_campos['apellidodocente'] = "d.apellidodocente";
$array_campos['nombredocente'] = "d.nombredocente";
$array_campos['numerodocumento'] = "d.numerodocumento";
$pager = new ADODB_Pager($db,$query);
$pager->order = true;
$pager->Filter($query,$sqlfin,$array_campos,$linkadd);
$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('Documento','Apellidos','Nombres','Tipo Contrato','Fecha Inicio Contrato','Fecha Fin Contrato','Horas X Semana','Escalafón', 'Nombre Carrera'));
?>
<br>
<input type="submit" value="Enviar" name="naenviar">
<input type="button" value="Restablecer" onClick="window.location.href='listadosdocentescontratos.php?nacodigocarrera=<?php echo $_REQUEST['nacodigocarrera']."&nanombrecarrera=".$_REQUEST['nanombrecarrera']."&nacodigomodalidadacademica=".$_REQUEST['nacodigomodalidadacademica']; ?>'">
<input type="button" value="Regresar" onClick="window.location.href='modalidaddocente.php'">
</form>
</body>
</html>
