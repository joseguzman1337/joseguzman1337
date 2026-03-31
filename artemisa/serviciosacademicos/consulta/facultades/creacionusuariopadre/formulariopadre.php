<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	require_once('../../../Connections/sala2.php' );
	$fechahoy=date("Y-m-d H:i:s");
	$rutaado = "../../../funciones/adodb/";
	require_once('../../../Connections/salaado.php');
	require_once('generacionclaveusuariopadre.php');
	session_start();
	$_SESSION['MM_Username'];

	$idestudiantegeneral= $_REQUEST['idestudiantegeneral'];

	$varguardar=0;
	$patron = "^[A-z0-9\._-]+"
							."@"
							."[A-z0-9][A-z0-9-]*"
							."(\.[A-z0-9_-]+)*"
							."\.([A-z]{2,6})$";

	if (isset($_POST['enviar'])) {
			/*if ($_POST['documento']== ""){
				echo '<script language="JavaScript">alert("Debe digitar el número de documento")</script>';
				$varguardar = 1;
			}
			else*/
			if ($_POST['apellidosusuariopadre'] == "") {
				echo '<script language="JavaScript">alert("Debe Digitar los apellidos")</script>';
				$varguardar = 1;
			}
			elseif ($_POST['nombresusuariopadre'] == "") {
				echo '<script language="JavaScript">alert("Debe Digitar los nombres")</script>';
				$varguardar = 1;
			}
			elseif ($_POST['emailusuariopadre'] == "" || !ereg($patron,$_POST['emailusuariopadre'])) {
				echo '<script language="JavaScript">alert("Debe Digitar un E-mail valido")</script>';
				$varguardar = 1;
			}
			elseif ($varguardar == 0) {
				GeneraClaveUsuarioPadre($idestudiantegeneral,$_POST['documento'], $_POST['apellidosusuariopadre'], $_POST['nombresusuariopadre'],$_POST['emailusuariopadre'],$bd);
			}
	}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="">
            <table width="40%" border="1"  cellpadding="3" cellspacing="3">
                <TR id="trgris" >
                    <TD colspan="2" align="center"><LABEL id="labelresaltadogrande">DATOS DEL PADRE</LABEL></TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris">Número Documento</TD>
                    <TD><input type="text" name="documento" value="<?php if($_REQUEST['documento'] !=""){ echo $_REQUEST["documento"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;Apellidos Padre</TD>
                    <TD><input type="text" name="apellidosusuariopadre" value="<?php if($_REQUEST['apellidosusuariopadre'] !=""){ echo $_REQUEST["apellidosusuariopadre"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;Nombres Padre</TD>
                    <TD><input type="text" name="nombresusuariopadre" value="<?php if($_REQUEST['nombresusuariopadre'] !=""){ echo $_REQUEST["nombresusuariopadre"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;E-Mail Padre</TD>
                    <TD><input type="text" name="emailusuariopadre" value="<?php if($_REQUEST['emailusuariopadre'] !=""){ echo $_REQUEST["emailusuariopadre"]; }?>"></TD>
                </TR>
                <TR id="trgris" >
                    <TD colspan="2" align="center"><input type="submit" name="enviar" value="Guardar">
                        <?php
                        if(isset($_REQUEST['verifica'])){
                        ?>
						<INPUT type="button" value="Regresar" onclick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php';"/>
						<?php 
							}
							else{
						?>
						<INPUT type="button" value="Regresar" onclick="window.location.href='datospadre.php?codigoestudiante=<?php echo $_REQUEST['codigoestudiante']; ?>';"/>
						<?php
                        }
                    	?>
                    </TD>
                </TR>
            </table>
        </form>
    </body>
</html>