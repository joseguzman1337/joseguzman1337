<?php  require('../../../Connections/sala2.php');
$sala2 = $sala;
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
include ("calendario/calendario.php");
@session_start();
?>
<html>
    <head>
        <title>.:INGRESO ICFES:.</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>

    </head>
    <body>
        <form name="inscripcion" method="post" action="editaringresoicfes_new.php">
            <input type="hidden" name="idestudiante" value="<?php echo $_REQUEST["idestudiante"]; ?>">
            <?php
            $codigoinscripcion = $_SESSION['numerodocumentosesion'];
            $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
WHERE eg.idestudiantegeneral = '".$_REQUEST["idestudiante"]."'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica
and i.codigoestado like '1%'
AND e.idnumeroopcion = '1'
AND i.idinscripcion = '".$_SESSION['inscripcionsession']."'";
            $data = $db->Execute($query_data);
            $totalRows_data = $data->RecordCount();
            $row_data = $data->FetchRow();
            $query_asignatura = "SELECT *
FROM asignaturaestado
where codigoestado like '1%'
ORDER BY 1";
            $asignatura = $db->Execute($query_asignatura);
            $totalRows_asignatura = $asignatura->RecordCount();
            $row_asignatura = $asignatura->FetchRow();
            if(isset($_POST['inicial']) or isset($_GET['inicial'])) { // vista previa
                ?>
            <p>FORMULARIO DEL ASPIRANTE</p>
            <table width="70%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                            <tr id="trgris">
                                <td id="tdtitulogris">Nombre</td>
                                <td><?php echo $row_data['nombresestudiantegeneral'];?><?php echo $row_data['apellidosestudiantegeneral'];?></font></td>
                            </tr>
                            <tr id="trgris">
                                <td id="tdtitulogris">Modalidad Acad&eacute;mica</td>
                                <td><?php echo $row_data['nombremodalidadacademica'];?></td>
                            </tr>
                            <tr id="trgris">
                                <td id="tdtitulogris">Nombre del Programa</td>
                                <td><?php echo $row_data['nombrecarrera'];?></td>
                            </tr>
                        </table>
                            <?php
                        }
                        $query_datosgrabados = "SELECT *
FROM detalleresultadopruebaestado d,resultadopruebaestado r,asignaturaestado a
WHERE r.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
and r.idresultadopruebaestado = d.idresultadopruebaestado
and d.idasignaturaestado = a.idasignaturaestado
and d.codigoestado like '1%'
order by a.idasignaturaestado";
                        $datosgrabados = $db->Execute($query_datosgrabados);
                        $totalRows_datosgrabados = $datosgrabados->RecordCount();
                        $row_datosgrabados = $datosgrabados->FetchRow();
                        $id = $row_datosgrabados['idresultadopruebaestado'];
                        if(isset($_POST['inicial']) or isset($_GET['inicial'])) { // vista previa
                            if (isset($_GET['inicial'])) {
                                $moduloinicial = $_GET['inicial'];
                                echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';
                            }
                            else {
                                $moduloinicial = $_POST['inicial'];
                                echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
                            }
                            ?>
                        <br>
                        <table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                            <tr>
                                <td colspan="4" id="tdtitulogris">RESULTADO PRUEBA DE ESTADO</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">No. Registro<span class="Estilo4">*</span></td>
                                <td><input type="text" name="registro" value="<?php echo $row_datosgrabados['numeroregistroresultadopruebaestado']; ?>"></td>
                                <td colspan="2">&nbsp;</td>
                                <!--<td id="tdtitulogris">Nombre Resultado</td>
                                <td colspan="3"><input type="text" name="nombre" value="<?php echo $row_datosgrabados['nombreresultadopruebaestado']; ?>"></td>
                                <td id="tdtitulogris">No. Registro*</td>
                                <td><input type="text" name="registro" value="<?php echo $row_datosgrabados['numeroregistroresultadopruebaestado']; ?>"></td>-->
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Puesto</td>
                                <td colspan="1"><input type="text" name="puesto" size="3" value="<?php echo $row_datosgrabados['puestoresultadopruebaestado']; ?>" maxlength="3"></td>
                                <td id="tdtitulogris">Fecha</td>
                                <td><input name="fecha1" type="text" id="fecha1"  size="8" value="<?php echo substr($row_datosgrabados['fecharesultadopruebaestado'],0,10)?>"><button id="btfechavencimiento">...</button></td>
                                <!--<td id="tdtitulogris">Descripci&oacute;n</td>
                                <td><input type="text" name="descripcion" value="<?php echo $row_datosgrabados['observacionresultadopruebaestado']; ?>"></td>-->
                            </tr>
                            <tr>
                                <td colspan="2" id="tdtitulogris">Asignatura</td>
                                <td colspan="2" id="tdtitulogris">Puntaje</td>
                            </tr>
                                <?php
                                $cuentaidioma = 1;
                                /*echo "<tr><td>row_datosgrabados<pre>";
print_r($row_datosgrabados);
echo "</pre></td></tr>";*/
                                if ($row_datosgrabados <> "") {
                                    do {
                                        ?>
                            <tr>
                                <td colspan="2"><?php echo $row_datosgrabados['nombreasignaturaestado'] ;?> <input type="hidden" name="asignatura<?php echo $cuentaidioma;?>" value="<?php echo $row_datosgrabados['idasignaturaestado'] ; ?>"> </td>
                                <td colspan="2"><input type="text" name="puntaje<?php echo $cuentaidioma;?>" size="3" maxlength="5" value="<?php echo $row_datosgrabados['notadetalleresultadopruebaestado']; ?>"><input type="hidden" name="id<?php echo $cuentaidioma;?>" size="3"  value="<?php echo $row_datosgrabados['iddetalleresultadopruebaestado']; ?>"></td>
                                            <?php
                                            $cuentaidioma ++;
                                            // echo  $cuentaidioma ,"<br>";
                                        }while($row_datosgrabados = $datosgrabados->FetchRow());
                                    }
                                    ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <script language="javascript">
                function grabar()
                {
                    document.inscripcion.submit();
                }
                function vista()
                {
                    window.location.href="vistaformularioinscripcion.php";
                }
            </script>
            <br><br>

<!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>
<a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>
            -->
            <input type="button" value="Enviar" onClick="grabar()">
    <!-- 	<input type="button" value="Vista Previa" onClick="vista()"> -->
            <input type="hidden" name="grabado" value="grabado">
                <?php
                if (isset($_GET['idestudiante'])) {
                    ?>
            <input type="hidden" name="idestudiante" value="<?php echo $_GET['idestudiante'];?>">
                    <?php
                }
                else {
                    ?>
            <input type="hidden" name="idestudiante" value="<?php echo $_POST['idestudiante'];?>">
                    <?php
                }
                ?>
      <!-- <a onClick="regresar()" style="cursor: pointer"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Regresar"></a>  <input type="hidden" name="grabado" value="grabado">
            -->
            <input type="button" onClick="window.location.href='formulariodeinscripcion.php?<? echo $_SESSION['fppal']; ?>'" name="Regresar" value="Regresar">
                <?php
                $banderagrabar = 0;
                if (isset($_POST['grabado'])) {
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombre']) and $_POST['nombre'] <> "")) {
                        echo '<script language="JavaScript">alert("El Nombre de la Prueba es Incorrecto"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }
                    else
                    if ($_POST['registro'] == "") {
                        echo '<script language="JavaScript">alert("Debe digitar el No. de registro"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }
                    else
                    if (!eregi("^[0-9]{1,15}$", $_POST['puesto']) and $_POST['puesto'] <> "") {
                        echo '<script language="JavaScript">alert("Puesto Incorrecto"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }
                    for ($i=1; $i<$cuentaidioma;$i++) {
                        if (!eregi("^[0-9]{1,2}\.[0-9]{1,2}$", $_POST['puntaje'.$i]) or $_POST['puntaje'.$i] > 100)
                        //($_POST['puntaje'.$i] == "" or $_POST['puntaje'.$i] > 100)
                        {
                            $banderagrabar = 1;
                        }
                    }
                    if ($banderagrabar == 1) {
                        echo '<script language="JavaScript">alert("Los puntajes deben estar dados en rangos de 0 - 100 con dos decimales (00.00)"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }
                    else
                    if ($banderagrabar == 0) {
                        $base="update resultadopruebaestado
					 set nombreresultadopruebaestado = '".$_POST['nombre']."',
					 numeroregistroresultadopruebaestado = '".$_POST['registro']."',
					 puestoresultadopruebaestado = '".$_POST['puesto']."',
					 fecharesultadopruebaestado = '".$_POST['fecha1']."',
					 observacionresultadopruebaestado = '".$_POST['descripcion']."'
					 where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
					";
                        //echo $base,"<br><br><br>";
                        $sol = $db->Execute($base);
                        for ($i=1; $i<$cuentaidioma;$i++) {
                            //echo $_POST['puntaje'.$i],"<br>";
                            if ($_POST['puntaje'.$i] <> "") {
                                $base1="update detalleresultadopruebaestado
					 set notadetalleresultadopruebaestado = '".$_POST['puntaje'.$i]."'
					 where iddetalleresultadopruebaestado = '".$_POST['id'.$i]."'
					";
                                $sol1 = $db->Execute($base1);
                            }
                        }
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=editaringresoicfes_new.php?inicial&idestudiante=".$_POST['idestudiante']."'>";
                    }
                }
            } // vista previa
            ?>
        </form>

        <script type="text/javascript">
            Calendar.setup(
            {
                inputField : "fecha1", // ID of the input field
                ifFormat : "%Y-%m-%d", // the date format
                button : "btfechavencimiento" // ID of the button
            }
        );
        </script>