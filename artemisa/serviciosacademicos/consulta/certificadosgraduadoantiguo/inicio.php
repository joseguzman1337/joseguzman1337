<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);  

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("funcionescertificado.php");
$varguardar = 0;
//session_start();
//unset ($_SESSION['session_sqr']);
    
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">

</head>
    <body>
<form name="validacion" id="validacion" method="POST" action="" >

    <?php 
    if (!isset($_POST['enviar'])) {
    ?>
    <TABLE width="25%" border="0" align="center" cellpadding="3">

                <TR id="trgris">
                    <TD id="tdtitulogris"><div align="justify">
                            <p>
                                <label id="labelgrande"> Por digite el número de documento para realizar la búsqueda.</label>
                            </p>
                        </div>
                    </TD>
                </TR>
                <tr align="center" id="trgris">
                    <td id="tdtitulogris">
                        <div align="left"> <label id="labelgrande">Número de Documento</label>
                            <INPUT type="text" name="documento"> </br>
                        </div>
                    </td>
                </tr>
                
                <tr align="center" id="trgris">
                    <td id="tdtitulogris">
                        <div align="center">
                            <INPUT type="submit" value="Enviar" name="enviar" >
                        </div>
                    </td>
                </tr>
                
    </TABLE>
    <?php 
    }
    ?>
</form>
</body>
</html>
<?php 
if (isset($_POST['enviar'])) {
        if ($_POST['documento'] == "") {
            echo "<script language='JavaScript'>alert('Por favor digite un Número de documento');
            window.location.href='inicio.php';
            </script>";
                    $varguardar = 1;
              }
        elseif ($varguardar == 0) {
            certificados($_REQUEST['documento']);            
        }
    }

?>
