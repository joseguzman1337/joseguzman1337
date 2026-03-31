<?php
session_start();
include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../Connections/sala2.php');
session_start();
$codigo = $_GET['estudiante'];
?>
<style type="text/css">
    <!--
    .Estilo6 {
        font-family: Tahoma;
        font-size: x-small;
    }
    .Estilo7 {
        font-size: x-small;
        font-weight: bold;
    }
    .Estilo13 {
        color: #993300;
        font-weight: bold;
        font-family: Tahoma;
        font-size: x-small;
    }
    .Estilo15 {font-size: xx-small}
    .Estilo16 {
        font-size: 14px;
        font-weight: bold;
    }
    .Estilo17 {
        font-size: 12px;
        font-weight: bold;
    }
    -->
</style>
<form action="pazysalvo.php" method="post" name="form1" class="Estilo6">
    <p align="center"><span class="Estilo16">ACTUALIZACI&Oacute;N PAZ Y SALVOS</span><br>
    </p>
    <div align="center">
        <?php
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega en la validacion del estado de periodo el estado 4, de modo que cuando se este en proceso de cierre 
         * y activacion de nuevo periodo, si no hay periodo activo tome el periodo en inscripcion
         * @since Diciembre 19, 2018
         */

        $base = "select * 
	    from estudiante,carrera,periodo,estadoperiodo,situacioncarreraestudiante,tipoestudiante,estudiantegeneral 
		where periodo.codigoestadoperiodo = estadoperiodo.codigoestadoperiodo
		and periodo.codigoestadoperiodo IN (1,4)
	    and estudiante.idestudiantegeneral = '" . $codigo . "'
	    and estudiantegeneral.idestudiantegeneral = estudiante.idestudiantegeneral
	    and estudiante.codigocarrera=carrera.codigocarrera
	    and estudiante.codigosituacioncarreraestudiante=situacioncarreraestudiante.codigosituacioncarreraestudiante
	    and estudiante.codigotipoestudiante=tipoestudiante.codigotipoestudiante";
        //echo $base;
        $sol = mysql_db_query($database_sala, $base) or die("No se deja seleccionar");
        $totalRows1 = mysql_num_rows($sol);
        if ($totalRows1 != "") {
            $row = mysql_fetch_array($sol);
            $carrera = $row['codigocarrera'];
            ?>
        </div>

        <table width="707" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
            <tr>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo17">Estudiante</div></td>
                <td colspan="6"><div align="center" class="Estilo15"></div>
                    <div align="center" class="Estilo15"><?php echo $row['nombresestudiantegeneral']; ?>&nbsp;&nbsp;<?php echo $row['apellidosestudiantegeneral']; ?></div>
                    <div align="center" class="Estilo15"></div>
                    <div align="center" class="Estilo15"></div></td>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo17">Documento</div></td>
                <td><div align="center" class="Estilo15"><?php echo $row['numerodocumento']; ?></div></td>
            </tr>
            <tr>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo15"></div>
                    <div align="center" class="Estilo17">Carrera</div></td>
                <td colspan="4"><div align="center" class="Estilo15"></div><div align="center" class="Estilo15"><?php echo $row['nombrecarrera']; ?></div>        <div align="center" class="Estilo15"></div>        <div align="center" class="Estilo15"></div></td>
                <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="Estilo17">Tipo de Estudiante </div></td>
                <td colspan="2"><div align="center" class="Estilo15"></div>
                    <div align="center" class="Estilo15"><?php echo $row['nombretipoestudiante']; ?></div></td>
            </tr>
            <tr>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo17">Periodo </div></td>
                <td><div align="center" class="Estilo15"><?php
                        $periodo = $row['codigoperiodo'];
                        echo $periodo;
                        ?></div></td>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo17">Semestre</div></td>
                <td><div align="center" class="Estilo15"><?php echo $row['semestre']; ?></div></td>
                <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="Estilo17">Situaci&oacute;n Acad&eacute;mica</div></td>
                <td><div align="center" class="Estilo15"><?php echo $row['nombresituacioncarreraestudiante']; ?></div></td>
                <td bgcolor="#C5D5D6"><div align="center" class="Estilo17">Fecha</div></td>
                <td><div align="center" class="Estilo15"><?php echo date("Y-m-d", time()); ?></div></td>
            </tr>
        </table>
        <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
            <tr>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">Fecha Registro</span></td>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">Tipo</span></td>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">&Aacute;rea</span></td>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">Descripci&oacute;n&nbsp;</span></td>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">Estado</span></td>
                <td align="center" bgcolor="#C5D5D6"><span class="Estilo7">Operación</span></td>
            </tr>
            <?php
            $query_pazysalvo = "SELECT *
							FROM detallepazysalvoestudiante dp,carrera a,estadopazysalvoestudiante e,
							tipopazysalvoestudiante t,pazysalvoestudiante p
							WHERE dp.codigotipopazysalvoestudiante = t.codigotipopazysalvoestudiante
							AND dp.idpazysalvoestudiante=p.idpazysalvoestudiante
							AND p.codigocarrera = a.codigocarrera
							AND dp.codigoestadopazysalvoestudiante = e.codigoestadopazysalvoestudiante 
							AND p.idestudiantegeneral = '$codigo'
							order by dp.fechainiciodetallepazysalvoestudiante asc";
            /// echo $query_pazysalvo;
            $res_pazysalvo = mysql_query($query_pazysalvo, $sala) or die(mysql_error());
            $totalRows2 = mysql_num_rows($res_pazysalvo);
            if ($totalRows2 != 0) {
                while ($pazysalvo = mysql_fetch_assoc($res_pazysalvo)) {
                    $id = $pazysalvo["iddetallepazysalvoestudiante"];
                    $nombrearea = $pazysalvo["nombrecarrera"];
                    $nombretipo = $pazysalvo["nombretipopazysalvoestudiante"];
                    $descripcion = $pazysalvo["descripciondetallepazysalvoestudiante"];
                    $nombreestado = $pazysalvo["nombreestadopazysalvoestudiante"];
                    $fecha = $pazysalvo["fechainiciodetallepazysalvoestudiante"];
                    if ($pazysalvo["codigocarrera"] == 147) {
                        $url = "http://unicornio.unbosque.edu.co/uhtbin/cgisirsi.exe/UNICORN/BIBLIOBOSQ/never/29/39/X/1";
                        $descripcion = "<a href='" . $url . "' target=_newpage>CONSULTE AQUI</a>";
                    }


                    echo '<tr>					
					<td><div align="center" class="Estilo15">' . $fecha . '&nbsp;</div></td>					
					<td><div align="center" class="Estilo15">' . $nombretipo . '&nbsp;</div></td>					
					<td><div align="center" class="Estilo15">' . $nombrearea . '&nbsp;</div></td>
					<td><div align="center" class="Estilo15">' . $descripcion . '&nbsp;</div></td>
					<td><div align="center" class="Estilo15">' . $nombreestado . '&nbsp;</div></td>								
					<td align="center">
						<a href="pazysalvooperacion.php?estudiante=' . $codigo . '&accion=adicionar&periodo=' . $periodo . '"><img src="../../../imagenes/adicionar.png" width="23" height="23" alt="Adicionar"></a>';
                    if ($pazysalvo["codigocarrera"] == $_SESSION['codigofacultad']) {
                        echo '<a href="pazysalvooperacion.php?estudiante=' . $codigo . '&accion=editar&editar=' . $id . '&codigoconcepto=' . $con . '&valor=' . $val . '"><img src="../../../imagenes/editar.png" width="23" height="23" alt="Modificar"></a>
						 <a href="pazysalvooperacion.php?estudiante=' . $codigo . '&accion=eliminar&eliminar=' . $id . '"><img src="../../../imagenes/eliminar.png" width="23" height="23" alt="Anular"></td></a>';
                    }

                    echo '</tr>';
                }
            } else {
                echo '<tr>
					<td colspan="5" align="center"><strong><font color="#800040">Este estudiante no tiene deudas pendientes. </font></strong>&nbsp;</td>
					<td align="center">
						<a href="pazysalvooperacion.php?estudiante=' . $codigo . '&accion=adicionar&periodo=' . $periodo . '"><img src="../../../imagenes/adicionar.png" width="23" height="23" alt="Adicionar"></a>
				</tr>';
            }
            ?>
            <tr>
                <td colspan="6" align="center"><input type="submit" name="Submit" value="Cancelar">&nbsp;</td>
            </tr>
        </table>
    </form>
    <?php
} else {
    ?>
    <div align="center"><span class="Estilo13">No se tiene acceso para este estudiante. </span>
        <br>
        <input type="submit" name="Submit" value="Cancelar">
    </div>

    <?php
}
?>