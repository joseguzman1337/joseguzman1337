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
            window.location.href='certificadoegresadopdf.php?documento=".$_POST['documento']."';
            </script>";
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Validación Títulos</title>
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
        					    * Se adiciona el titulo Verificación de Información académica de Grado
								* @since Septiembre 4 de 2017.
							-->
							   <div align="center"> <label id="labelgrande">Verificación de Información académica de Grado</label></div>			
							<!--End Caso 93668 -->
							
                               <div align="center"> <label id="labelresaltadogrande">Consulta títulos año 2006 y siguientes</label></div>
                                <br><label id="labelgrande">Por favor digite el número de documento para realizar la búsqueda.</label><br/>
								<span style="font-size:0.9em">Nota: si la búsqueda no arroja resultados, por favor comunicarse al correo ver&#105;f&#105;cac&#105;&#111;nt&#105;tul&#111;s&#64;unb&#111;sque.edu.co</span>
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

