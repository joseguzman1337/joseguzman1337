<?php
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;


if (isset($_POST['enviar'])) {
    if ($_POST['documento'] == "") {
        echo "<script language='JavaScript'>alert('Por favor digite un Número de documento');
            window.location.href='inicio.php';
            </script>";
        $varguardar = 1;
    } elseif ($varguardar == 0) {

        echo "<script language='JavaScript'>
            window.location.href='../tramitedediplomapdf.php?documento=".$_POST['documento']."';
            </script>";
    }
}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
           </head>
    <body>
        <form name="form1"  method="POST" action="" >

            <TABLE width="25%" border="0" align="center" cellpadding="3">

                <TR id="trgris">
                    <TD id="tdtitulogris"><div align="justify">
                            <p>
                                <label id="labelgrande"> Por  favor digite el número de documento para realizar la búsqueda.</label>
                            </p>
                        </div>
                    </TD>
                </TR>
                <tr align="center" id="trgris">
                    <td id="tdtitulogris">
                        <div align="left"> <label id="labelgrande">Número de Documento</label>
                            <INPUT type="text" name="documento" id="documento"> <br>
                        </div>
                    </td>
                </tr>
                 <tr align="center" id="trgris">
                    <td id="tdtitulogris">
                        <div align="center">
                            <INPUT type="submit" value="Enviar" name="enviar" id="enviar" >
                        </div>
                    </td>
                </tr>

            </TABLE>

        </form>

    </body>
</html>

