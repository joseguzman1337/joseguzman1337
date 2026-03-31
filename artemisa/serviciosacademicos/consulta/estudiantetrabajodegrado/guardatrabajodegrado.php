<?php
	header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

$_SESSION['MM_Username'];
$codigoestudiante = $_REQUEST['codigoestudiante'];

$varguardar=0;
$varanular=0;
$query_permisocarrera ="SELECT dpe.idtipodetallepazysalvoegresado, tdpe.nombretipodetallepazysalvoegresado as validacion,dpe.ubicacionpaginadetallepazysalvoegresado as orden_ubicacion_carta,dpe.textodetallepazysalvoegresado as texto, tdpe.codigotiporegistro, e.codigoestudiante
	FROM
		pazysalvoegresado pe, detallepazysalvoegresado dpe, tipodetallepazysalvoegresado tdpe, estudiante e
	WHERE
		pe.idpazysalvoegresado=dpe.idpazysalvoegresado
	AND dpe.codigoestado=100
	AND NOW() BETWEEN pe.fechadesdepazysalvoegresado AND pe.fechahastapazysalvoegresado
	AND dpe.idtipodetallepazysalvoegresado=tdpe.idtipodetallepazysalvoegresado
	AND tdpe.idtipodetallepazysalvoegresado='9'
	AND e.codigoestudiante = '$codigoestudiante'
	AND e.codigocarrera=pe.codigocarrera
	ORDER BY dpe.ubicacionpaginadetallepazysalvoegresado";

	$permisocarrera= $db->Execute($query_permisocarrera);
	$totalRows_permisocarrera = $permisocarrera->RecordCount();
	$row_permisocarrera = $permisocarrera->FetchRow();

if($totalRows_permisocarrera !=0){
    $query_trabajogrado ="SELECT idtrabajodegrado, codigoestudiante, nombretrabajodegrado, caracteristicastrabajodegrado, fechaaprobaciontrabajodegrado, directorprogramatrabajodegrado, directortesistrabajodegrado, certificadobibliotecatrabajodegrado, nombrerevistatrabajodegrado, capitulolibrotrabajodegrado, librotrabajodegrado, paginastrabajodegrado, volumentrabajodegrado, issntrabajodegrado, isbntrabajodegrado, codigoestado 
	FROM trabajodegrado
    where codigoestudiante = '$codigoestudiante'
    and codigoestado like '1%' ";
    $trabajogrado= $db->Execute($query_trabajogrado);
    $totalRows_trabajogrado = $trabajogrado->RecordCount();
    $row_trabajogrado = $trabajogrado->FetchRow();
    
    if($totalRows_trabajogrado !=0){
     $idtrabajodegrado=$row_trabajogrado['idtrabajodegrado'];
    }
        
    if (isset($_POST['enviar'])) {
    $entro = false;
        if ($_POST['nombretrabajo']== ""){
            echo '<script language="JavaScript">alert("Debe Digitar el nombre del trabajo de grado")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['caracteristicas'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar las caracteristicas del trabajo de grado")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['fechaaprobacion'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar o digitar la fecha de aprobación")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['directorprogramatrabajodegrado'] == "") {
            echo '<script language="JavaScript">alert("Debe digitar el nombre del director de programa")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['directortesistrabajodegrado'] == "") {
            echo '<script language="JavaScript">alert("Debe digitar el nombre del director de la tesis")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['directortesistrabajodegrado'] == "") {
            echo '<script language="JavaScript">alert("Debe digitar el nombre del director de la tesis")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['certificadobibliotecatrabajodegrado'] == "") {
            echo '<script language="JavaScript">alert("Debe digitar el certificado de biblioteca")</script>';
            $varguardar = 1;
        }
        elseif ($varguardar == 0) {
            if (isset($idtrabajodegrado)){
                $query_actualizar = "UPDATE trabajodegrado SET 
                codigoestudiante='$codigoestudiante', 
                nombretrabajodegrado='".$_POST['nombretrabajo']."',  caracteristicastrabajodegrado='".$_POST['caracteristicas']."',
                fechaaprobaciontrabajodegrado='".$_POST['fechaaprobacion']."', directorprogramatrabajodegrado='".$_POST['directorprogramatrabajodegrado']."', directortesistrabajodegrado='".$_POST['directortesistrabajodegrado']."', certificadobibliotecatrabajodegrado='".$_POST['certificadobibliotecatrabajodegrado']."', nombrerevistatrabajodegrado='".$_POST['nombrerevistatrabajodegrado']."', capitulolibrotrabajodegrado='".$_POST['capitulolibrotrabajodegrado']."', librotrabajodegrado='".$_POST['librotrabajodegrado']."', paginastrabajodegrado='".$_POST['paginastrabajodegrado']."',  volumentrabajodegrado='".$_POST['volumentrabajodegrado']."',
                issntrabajodegrado='".$_POST['issntrabajodegrado']."',
                isbntrabajodegrado='".$_POST['isbntrabajodegrado']."',
                fechamodificaciontrabajodegrado=now(),
                usuariocreadortrabajodegrado='".$_SESSION['MM_Username']."',
                codigoestado = 100
                WHERE idtrabajodegrado = '{$row_trabajogrado['idtrabajodegrado']}'
                AND codigoestudiante='$codigoestudiante'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente'); 
				window.location.href='../prematricula/matriculaautomaticaordenmatricula.php';
				</script>";            
                $entro = true;
                //exit();
            }
            else {
            $query_guardar = "INSERT INTO trabajodegrado (idtrabajodegrado, codigoestudiante, nombretrabajodegrado, caracteristicastrabajodegrado, fechaaprobaciontrabajodegrado, directorprogramatrabajodegrado, directortesistrabajodegrado, certificadobibliotecatrabajodegrado, nombrerevistatrabajodegrado, capitulolibrotrabajodegrado, librotrabajodegrado, paginastrabajodegrado, volumentrabajodegrado, issntrabajodegrado, isbntrabajodegrado, fechacreaciontrabajodegrado, fechamodificaciontrabajodegrado, usuariocreadortrabajodegrado, codigoestado) values (0, '{$codigoestudiante}','{$_POST['nombretrabajo']}','{$_POST['caracteristicas']}','{$_POST['fechaaprobacion']}','{$_POST['directorprogramatrabajodegrado']}','{$_POST['directortesistrabajodegrado']}','{$_POST['certificadobibliotecatrabajodegrado']}','{$_POST['nombrerevistatrabajodegrado']}','{$_POST['capitulolibrotrabajodegrado']}','{$_POST['librotrabajodegrado']}','{$_POST['paginastrabajodegrado']}','{$_POST['volumentrabajodegrado']}','{$_POST['issntrabajodegrado']}','{$_POST['isbntrabajodegrado']}', now(), now(), '{$_SESSION['MM_Username']}', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());            
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  
             window.location.href='guardatrabajodegrado.php?codigoestudiante=$codigoestudiante' ;
			 window.location.href='../prematricula/matriculaautomaticaordenmatricula.php';
			 </script>";
            $entro = true;
            }            
        }
    } 
	/*
	  * Caso 92588
	  * @modified Luis Dario Gualteros C
	  * <castroluisd@unbosque.edu.co>
	  * Se crea la opción que permite eliminar los registros de trabajo de grado dentro de la opción Estudiante.
	  * @since Agosto 2 de 2017
	*/
	if (isset($_POST['eliminar'])) {
    $entro = false;
		if ($varanular == 0) {
            if (isset($idtrabajodegrado)){
				$query_actualizar = "UPDATE trabajodegrado SET codigoestado = 200 where idtrabajodegrado = '$idtrabajodegrado'";
				$actualizar= $db->Execute($query_actualizar) or die("$query_actualizar".mysql_error());
			   echo "<script language='javascript'> alert('Se ha eliminado el registro correctamente');
					window.location.href='../prematricula/matriculaautomaticaordenmatricula.php';
				    </script>";
			}
		}	
	}
	//End Caso 92588
?>

    <html>
    <head>
    <script language="javascript">
    /*   function muestralista() {
            if(document.f1.publicacion[1].checked){
                document.getElementById("div1").style.visibility = "visible";
                document.getElementById("div2").style.visibility = "hidden";
            }
            if(document.f1.publicacion[0].checked){
                document.getElementById("div1").style.visibility = "hidden";
                document.getElementById("div2").style.visibility = "visible";
            }
        }*/
    </script>

    <title>Trabajos de Grado</title>
    <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    <style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
    <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
    <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
    <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
    
    <body>
    <form name="f1" method="POST" >
    
        <table width="50%" border="0" align="center" cellpadding="3" cellspacing="3">
            <tr id="trtitulogris">
                <TD align="center"  colspan="2"><LABEL  id="labelresaltadogrande">INGRESO TRABAJOS DE GRADO</LABEL></TD>
            </tr>
            <tr align="left">
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Nombre del Trabajo
                </td>
                    <TD>
                        <INPUT type="text" name="nombretrabajo" id="nombretrabajo" value="<?php 
                    if(!isset($_POST['nombretrabajo'])) { echo $row_trabajogrado['nombretrabajodegrado']; } else { echo $_POST['nombretrabajo']; } ?>">
                    </TD>
            </tr>
            <tr align="left" >
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Características de Aprobación 
                </td>
                    <TD>
                        <INPUT type="text" name="caracteristicas" id="caracteristicas" value="<?php 
                    if(!isset($_POST['caracteristicas'])) { echo $row_trabajogrado['caracteristicastrabajodegrado']; } else { echo $_POST['caracteristicas']; } ?>">
                    </TD>
            </tr>
            <tr align="left" >
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Fecha de Aprobación
                </td>
                <TD>
                
                    <INPUT type="text" name="fechaaprobacion" id="fechaaprobacion"  value="<?php 
                    if(!isset($_POST['fechaaprobacion'])) { echo $row_trabajogrado['fechaaprobaciontrabajodegrado']; } else { echo $_POST['fechaaprobacion']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                    <script type="text/javascript">
                        Calendar.setup(
                                {
                                inputField  : "fechaaprobacion",  // ID of the input field
                                ifFormat    : "%Y-%m-%d",   // the date format
                                onUpdate    : "fechaaprobacion" // ID of the button
                                }
                                );
                    </script>                    
                </TD>      
            </tr>
            <tr align="left" >
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Director de Programa
                </td>                
                    <TD><INPUT type="text" name="directorprogramatrabajodegrado" id="directorprogramatrabajodegrado" value="<?php 
                    if(!isset($_POST['directorprogramatrabajodegrado'])) { echo $row_trabajogrado['directorprogramatrabajodegrado']; } else { echo $_POST['directorprogramatrabajodegrado']; } ?>"></TD>                
            </tr>
            <tr align="left" >
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Director de Tesis
                </td>                
                    <TD><INPUT type="text" name="directortesistrabajodegrado" id="directortesistrabajodegrado" value="<?php 
                    if(!isset($_POST['directortesistrabajodegrado'])) { echo $row_trabajogrado['directortesistrabajodegrado']; } else { echo $_POST['directortesistrabajodegrado']; } ?>"></TD>                
            </tr>
            <tr align="left" >
                <td id="tdtitulogris">
                    <LABEL id="labelasterisco">*</LABEL>Certificación de Entrega a Biblioteca
                </td>                
                    <TD><INPUT type="text" name="certificadobibliotecatrabajodegrado" id="certificadobibliotecatrabajodegrado" value="<?php 
                    if(!isset($_POST['certificadobibliotecatrabajodegrado'])) { echo $row_trabajogrado['certificadobibliotecatrabajodegrado']; } else { echo $_POST['certificadobibliotecatrabajodegrado']; } ?>"></TD>                
            </tr>
            <tr align="left">
                <td id="tdtitulogris" colspan="2">Publicación (NOTA: Si el trabajo de grado tiene publicación por favor complete el ingreso de la información en las casillas que se muestran a continuación)
                </td>            
            </tr>
            <TR >
                <TD id="tdtitulogris">Nombre de la Revista</TD>               
                    <TD><INPUT type="text" name="nombrerevistatrabajodegrado" id="nombrerevistatrabajodegrado" value="<?php 
                    if(!isset($_POST['nombrerevistatrabajodegrado'])) { echo $row_trabajogrado['nombrerevistatrabajodegrado']; } else { echo $_POST['nombrerevistatrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">Capitulo de Libro</TD>                
                    <TD><INPUT type="text" name="capitulolibrotrabajodegrado" id="capitulolibrotrabajodegrado" value="<?php 
                    if(!isset($_POST['capitulolibrotrabajodegrado'])) { echo $row_trabajogrado['capitulolibrotrabajodegrado']; } else { echo $_POST['capitulolibrotrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">Libro</TD>
                <TD><INPUT type="text" name="librotrabajodegrado" id="librotrabajodegrado" value="<?php 
                    if(!isset($_POST['librotrabajodegrado'])) { echo $row_trabajogrado['librotrabajodegrado']; } else { echo $_POST['librotrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">Páginas</TD>                
                    <TD><INPUT type="text" name="paginastrabajodegrado" id="paginastrabajodegrado" value="<?php if(!isset($_POST['paginastrabajodegrado'])) { echo $row_trabajogrado['paginastrabajodegrado']; } else { echo $_POST['paginastrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">Volumen</TD>                
                    <TD><INPUT type="text" name="volumentrabajodegrado" id="volumentrabajodegrado" value="<?php if(!isset($_POST['volumentrabajodegrado'])) { echo $row_trabajogrado['volumentrabajodegrado']; } else { echo $_POST['volumentrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">ISSN </TD>                
                    <TD><INPUT type="text" name="issntrabajodegrado" id="issntrabajodegrado" value="<?php if(!isset($_POST['issntrabajodegrado'])) { echo $row_trabajogrado['issntrabajodegrado']; } else { echo $_POST['issntrabajodegrado']; } ?>"></TD>                
            </TR>
            <TR >
                <TD id="tdtitulogris">ISBN</TD>                
                    <TD><INPUT type="text" name="isbntrabajodegrado" id="isbntrabajodegrado" value="<?php if(!isset($_POST['isbntrabajodegrado'])) { echo $row_trabajogrado['isbntrabajodegrado']; } else { echo $_POST['isbntrabajodegrado']; } ?>"></TD>                
            </TR>
            <tr align="left">
                <TD colspan="2" id="tdtitulogris">Nota: Los campos marcados con <LABEL id="labelasterisco">*</LABEL> son campos obligatorios.</TD>
            </tr>
            <tr align="center">
                <TD colspan="2" id="tdtitulogris"><input type="submit" name="enviar" value="Guardar">
                <INPUT type="button" value="Regresar" onclick="window.location.href='../prematricula/matriculaautomaticaordenmatricula.php';">
                <?php if (isset($idtrabajodegrado)){ ?>                        
                        <INPUT type="submit" value="Anular Trabajo" name="eliminar">
                        
                    <?php } ?>
                </TD>
            </tr>
            
        </table>
    </form>
    </body>
    </html>
<?php 
}
else{
    echo "<script language='javascript'>alert('La carrera del estudiante NO TIENE permiso para ingresar a el formulario de trabajo de grado');
     window.history.back();
    </script>";
}
?>
