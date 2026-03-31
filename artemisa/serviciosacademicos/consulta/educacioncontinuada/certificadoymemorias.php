<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../../Connections/sala2.php');
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="form1"  method="REQUEST" action="">
            <table width="50%" align="center"  border="1"  cellpadding="3" cellspacing="3">
                <TR>
                    <TD colspan="3" align="center"><img alt=""  src="../../../imagenes/noticias_logo.gif" ></TD>
                </TR>
                <tr>
                    <td>
                        <h4>Descargue Aquí su certificado: <a href="popupcertificados.php?documento=<?php echo $_REQUEST['documento']; ?>&iddiploma=<?php echo $_REQUEST['iddiploma']; ?>">III SEMINARIO EN AVANCES DE MEDICINA, DEPORTE Y SALUD I SIMPOSIO RESIDENTES POSTGRADO DE MEDICINA DEL DEPORTE, "MEDICINA A TRAVÉS DEL EJERCICIO".</a>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Descargue Aquí las memorias del evento: <a href="http://www.uelbosque.edu.co/files/Archivos/EduCon/Congresos/Pdfs/seminario3.html" >III SEMINARIO EN AVANCES DE MEDICINA, DEPORTE Y SALUD I SIMPOSIO RESIDENTES POSTGRADO DE MEDICINA DEL DEPORTE, "MEDICINA A TRAVÉS DEL EJERCICIO".</a>
                        </h4>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>


