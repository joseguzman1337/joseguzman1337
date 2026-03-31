<?php
session_start();
$fechahoy=date("Y-m-d");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("../../funciones/sala_genericas/Excel/reader.php");
require_once("cargaarchivotellmemore.php");
if(!isset ($_SESSION['MM_Username'])){
echo "No tiene permiso para acceder a esta opción";
exit();
}
/*echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";*/
if(isset($_POST["enviar"])){
        //$_FILES
        cargaarchivotellmemore($_FILES,$_POST,$db);
        }
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="form1"  method="POST" action="" enctype="multipart/form-data" >            
            <TABLE width="50%" border="0" align="center" cellpadding="3">
                <TR id="trgris">
                    <TD align="center" colspan="2"><label id="labelresaltadogrande">Notas Tell Me More</label></TD>
                </TR>
                <TR >
                    <TD><P>Seleccione el archivo que desea cargar con la lista de resultados</P></TD>
                    <TD><input type="file" name="resultados"></TD>
                </TR>
                <TR id="trgris">
                    <TD align="center" colspan="2"><INPUT type="submit" value="Enviar" name="enviar" ></TD>
                </TR>
            </TABLE>
        </form>
    </body>
</html>
