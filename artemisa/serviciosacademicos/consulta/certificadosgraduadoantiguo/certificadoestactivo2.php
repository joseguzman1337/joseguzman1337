<?php
/*
 * Caso 93513
 * @modified Luis Dario Gualteros C
 * <castroluisd@unbosque.edu.co>
 * Se agregaron las lineas para la validación de Sesión.
 * @since Agosto 29 de 2017
*/
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
// End Caso 93513
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$varguardar = 0;

if (isset($_POST['enviar'])) {
    if ($_POST['documento'] == "") {
        echo "<script language='JavaScript'>alert('Por favor digite un Número de documento');
            window.location.href='inicio.php';
            </script>";
        $varguardar = 1;
    } elseif ($varguardar == 0) {

        echo "<script language='JavaScript'>
            window.location.href='certificadoestactivopdf.php?documento=".$_POST['documento']."';
            </script>";
    }
}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
           </head>
    <body>
        <form name="form1"  method="POST" action="" >

            <TABLE width="25%" border="0" align="center" cellpadding="3">

                <TR id="trgris">
                    <TD id="tdtitulogris"><div align="justify">
                            <p>
								<!--
								 * Caso 93668
								 * @modified Luis Dario Gualteros C
								 * <castroluisd@unbosque.edu.co>
        					     * Se adiciona el titulo Verificación de Información académica de Pregrado
								 * @since Septiembre 4 de 2017.
								-->
								<div align="center"> <label id="labelgrande">Verificación de Información académica de Pregrado</label></div>				
								<!--End Caso 93668 -->
                                <div align="center"> <label id="labelresaltadogrande">Consulta datos básicos estudiantes activos</label></div>
                                <br><label id="labelgrande"> Por favor digite el número de documento para realizar la búsqueda.</label>
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

