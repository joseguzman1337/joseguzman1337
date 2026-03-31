<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
//session_start();
require_once('seguridadlistagrupos.php');

if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";

header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");

exit();
}

//$carrera = $_SESSION['codigofacultad'];
?>
<html>
    <style type="text/css">
        <!--
        .Estilo3 {
            font-family: Tahoma;
            font-size: x-small;
            font-weight: bold;
        }
        .Estilo4 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
        .Estilo5 {font-size: 14px}
        -->
    </style>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Mostrar listado</title>
    </head>

    <body>
        <?php
        $codigo = $_GET['codigo'];
        $idgrupo = $_GET['idgrupo'];
        $query_materia = "SELECT m.nombremateria, m.codigomateria, c.nombrecarrera, concat(d.nombredocente,' ',d.apellidodocente) as nombre
FROM materia m, carrera c, docente d, grupo g
where m.codigocarrera = c.codigocarrera
and g.numerodocumento = d.numerodocumento
and g.codigomateria = m.codigomateria
and g.idgrupo = '$idgrupo'
and m.codigomateria = '$codigo'";
//and m.codigocarrera = '$carrera'
        $res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
        $materia = mysql_fetch_assoc($res_materia);
        $nombrecarrera = $materia["nombrecarrera"];

// Si la materia es de humanidades entra
        if (!$materia) {
            $query_materia = "SELECT m.nombremateria, m.codigomateria, concat(d.nombredocente,' ',d.apellidodocente) as nombre
	FROM materia m,  docente d, grupo g
	where g.numerodocumento = d.numerodocumento
	and g.codigomateria = m.codigomateria
	and g.idgrupo = '$idgrupo'
	and m.codigomateria = '$codigo'";
            //and m.codigocarrera = '$carrera'
            //echo $query_materia;
            $res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
            $materia = mysql_fetch_assoc($res_materia);
            $nombrecarrera = "HUMANIDADES";
        }
        ?>
        <p align="center" class="Estilo4">DATOS DE LA MATERIA </p>
        <table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
            <tr bgcolor="#C5D5D6">
                <td align="center"><font size="2" face="Tahoma"><strong>Nombre Materia</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>C&oacute;digo Materia</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>&Aacute;rea Responsable </strong></td>
                <td align="center"><font size="2" face="Tahoma"><strong>Profesor</strong>&nbsp;</td>
            </tr>
            <?php
            $nombredocente = $materia["nombre"];
            $nombremateria = $materia["nombremateria"];
            $codigomateria = $materia["codigomateria"];

            echo "<tr>
	<td align='center'><font size='2' face='Tahoma'>$nombremateria&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$codigomateria&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$nombrecarrera&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$nombredocente&nbsp;</td>
</tr>";
            ?>
        </table>
        <p align="center" class="Estilo3 Estilo5"><strong>DATOS DEL GRUPO </strong></p>
        <table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
            <tr bgcolor="#C5D5D6">
                <td align="center"><font size="2" face="Tahoma"><strong>Periodo</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>C&oacute;digo Grupo</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>Nombre Grupo</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>Cupo</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>Prematriculados</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>Matriculados</strong>&nbsp;</td>
                <td align="center"><font size="2" face="Tahoma"><strong>Total Grupo</strong>&nbsp;</td>
            </tr>
            <?php
            $codigogrupo = $_GET['codigogrupo'];
            $nombregrupo = $_GET['nombregrupo'];
            $maximogrupo = $_GET['maximogrupo'];
            $matriculadosgrupo = $_GET['matriculadosgrupo'];
            $matriculados = $_GET['matriculados'];
            $prematriculados = $_GET['prematriculados'];

            echo "<tr>
	<td align='center'><font size='2' face='Tahoma'>" . $_SESSION['codigoperiodosesion'] . "&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$idgrupo&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$nombregrupo&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$maximogrupo&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$prematriculados&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$matriculados&nbsp;</td>
	<td align='center'><font size='2' face='Tahoma'>$matriculadosgrupo&nbsp;</td>
</tr>";
            ?>
        </table>
        <?php
            $query_horario = "select s.nombresede, sa.nombresalon, d.nombredia, h.horainicial, h.horafinal
from horario h, sede s, salon sa, dia d
where h.codigosalon = sa.codigosalon
and sa.codigosede = s.codigosede
and h.codigodia = d.codigodia
and h.idgrupo = '$idgrupo'";
            $res_horario = mysql_query($query_horario, $sala) or die(mysql_error());
        ?>
            <p align="center" class="Estilo4"><strong>HORARIO </strong></p>
            <table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
                <tr bgcolor="#C5D5D6">
                    <td align="center"><font size="2" face="Tahoma"><strong>Sede</strong>&nbsp;</td>
                    <td align="center"><font size="2" face="Tahoma"><strong>Salón</strong>&nbsp;</td>
                    <td align="center"><font size="2" face="Tahoma"><strong>Día</strong>&nbsp;</td>
                    <td align="center"><font size="2" face="Tahoma"><strong>Hora Inicial</strong>&nbsp;</td>
                    <td align="center"><font size="2" face="Tahoma"><strong>Hora Final</strong>&nbsp;</td>
                </tr>
            <?php
            while ($horario = mysql_fetch_assoc($res_horario)) {
                $nombresede = $horario["nombresede"];
                $nombresalon = $horario["nombresalon"];
                $nombredia = $horario["nombredia"];
                $horainicial = $horario["horainicial"];
                $horafinal = $horario["horafinal"];
                echo "<tr>
			<td align='center'><font size='2' face='Tahoma'>$nombresede&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$nombresalon&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$nombredia&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$horainicial&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$horafinal&nbsp;</td>
		</tr>";
            }
            ?>
        </table>

        <?php
            require("calculoestudiantesinscritos.php");
            if ($total_prematriculados != 0 || $total_prematriculados2 != 0) {
        ?>
                <p align="center" class="Estilo4"><strong>ESTUDIANTES PREMATRICULADOS</strong></p>
                <table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr bgcolor="#C5D5D6">
                        <td align="center"><font size="2" face="Tahoma"><strong>Facultad</strong></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Documento</strong></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Nombre Estudiante</strong>&nbsp;</td>
                    </tr>
            <?php
                while ($inscritos = mysql_fetch_assoc($res_inscritos)) {
                    $nombreestudiante = $inscritos["nombre"];
                    $codigoestudiante = $inscritos["numerodocumento"];
                    $nombrefacultad = $inscritos["nombrecarrera"];
                    /* OJO este codigo es para efectuar el cambio de grupo
                      echo "<tr>
                      <td align='center' class='Estilo4'>$nombrefacultad&nbsp;</td>
                      <td align='center' class='Estilo4'><a href='cambiogrupos.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$matriculados&prematriculados=$prematriculados'>$codigoestudiante&nbsp;</a></td>
                      <td align='center' class='Estilo4'>$nombreestudiante&nbsp;</td>
                      </tr>";
                     */
                    echo "<tr>
			<td align='center'><font size='2' face='Tahoma'>$nombrefacultad&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$codigoestudiante&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$nombreestudiante&nbsp;</td>
		</tr>";
                }
                $boolinscritos2 = false;
                while ($inscritos2 = mysql_fetch_assoc($res_inscritos2)) {
                    $nombreestudiante = $inscritos2["nombre"];
                    $codigoestudiante = $inscritos2["numerodocumento"];
                    $nombrefacultad = $inscritos2["nombrecarrera"];
                    /* OJO Este codigo es para efectuar el cambio de grupo
                      echo "<tr  bgcolor='#D4D4D4'>
                      <td align='center' class='Estilo4'>$nombrefacultad&nbsp;</td>
                      <td align='center' class='Estilo4'><a href='cambiogrupos.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$matriculados&prematriculados=$prematriculados'>$codigoestudiante&nbsp;</a></td>
                      <td align='center' class='Estilo4'>$nombreestudiante&nbsp;</td>
                      </tr>";
                     */
                    echo "<tr  bgcolor='#D4D4D4'>
			<td align='center'><font size='2' face='Tahoma'>$nombrefacultad&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$codigoestudiante&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$nombreestudiante&nbsp;</td>
		</tr>";
                    $boolinscritos2 = true;
                }
            ?>
            </table>
        <?php
                if ($boolinscritos2) {
        ?>
                    <p align="center" class="Estilo3"><font color="#800000"><strong>Los estudiantes sombreados tienen una deuda por concepto de matricula</strong></font></p>
        <?php
                }
            }
            if ($total_matriculados != 0) {
        ?>
                <p align="center" class="Estilo4"><strong>ESTUDIANTES MATRICULADOS</strong></p>
                <table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr bgcolor="#C5D5D6">
                        <td align="center"><font size="2" face="Tahoma"><strong>Facultad</strong></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Documento</strong>&nbsp;</td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Nombre Estudiante</strong>&nbsp;</td>
						<td align="center"><font size="2" face="Tahoma"><strong>Email Personal</strong>&nbsp;</td>
						<td align="center"><font size="2" face="Tahoma"><strong>Email Institucional</strong>&nbsp;</td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Foto</strong>&nbsp;</td>
                    </tr>
            <?php
                while ($matriculados = mysql_fetch_assoc($res_matriculados)) {
                    $nombreestudiante = $matriculados["nombre"];
                    $codigoestudiante = $matriculados["numerodocumento"];
                    $nombrefacultad = $matriculados["nombrecarrera"];

                    $query_horario = "select A.numerodocumento,B.emailestudiantegeneral,B.email2estudiantegeneral 
					from estudiantedocumento A 
					INNER JOIN estudiantegeneral B ON (A.idestudiantegeneral = B.idestudiantegeneral) 
					where A.idestudiantegeneral='" . $matriculados["idestudiantegeneral"] . "' 
					order by A.idestudiantedocumento desc";					
                    $res_estdocumento = mysql_query($query_horario, $sala) or die(mysql_error());
                    while ($estdocumento = mysql_fetch_assoc($res_estdocumento)) {

                        $filename = "../../../../imagenes/estudiantes/" . $estdocumento["numerodocumento"] . ".jpg";
                        $filename2 = "../../../../imagenes/estudiantes/" . $estdocumento["numerodocumento"] . ".JPG";
                        $desconocido = "../../../../imagenes/desconocido.jpg";
                        if (is_file($filename)) {
                            $imagen = "<img src='" . $filename . "' width='80px' height='120px' />";
                            break;
                        } else if (is_file($filename2)) {
                            $imagen = "<img src='" . $filename2 . "' width='80px' height='120px' />";
                            break;
                        } else {
                            $imagen = "<img src='" . $desconocido . "' width='80px' height='120px' />";
                        }
						$email=$estdocumento['emailestudiantegeneral'];
						$email2=$estdocumento['email2estudiantegeneral'];
						$numeroDocumento=$estdocumento["numerodocumento"];
						
                    }
                    /* OJO este codigo es para efectuar el cambio de grupo
                      echo "<tr>
                      <td align='center' class='Estilo4'>$nombrefacultad&nbsp;</td>
                      <td align='center' class='Estilo4'><a href='cambiogrupos.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$matriculados&prematriculados=$prematriculados'>$codigoestudiante&nbsp;</a></td>
                      <td align='center' class='Estilo4'>$nombreestudiante&nbsp;</td>
                      </tr>";
                     */
					$queryUsuarioInsti = "select usuario 
					from usuario
					where numerodocumento = '$codigoestudiante'
					AND codigotipousuario = 600";
					$res_ususario = mysql_query($queryUsuarioInsti, $sala) or die(mysql_error());
					$documento = mysql_fetch_assoc($res_ususario);
					$usuario=trim($documento['usuario']).'@unbosque.edu.co';
                    echo "<tr>
			<td align='center'><font size='2' face='Tahoma'>$nombrefacultad&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$codigoestudiante&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$nombreestudiante&nbsp;</td>
			<td align='center'><font size='2' face='Tahoma'>$email</td>
			<td align='center'><font size='2' face='Tahoma'>$usuario</td>
                <td align='center'><font size='2' face='Tahoma'>$imagen&nbsp;</td>
		</tr>"; $usuario=null;$queryUsuarioInsti=null; $email=null;
                }
            ?>
            </table>
        <?php
            }
        ?>
            <p align="center"><input type="button" onClick="print()" value="Imprimir">
            <?php
            if (isset($_SESSION['codigofacultad'])) {
            ?>
                <!--
                <input type="button"  name="ira" onClick="<?php
                echo "window.open('cambiargrupoacademico.php','miventana','width=600,height=400,top=200,left=150')";
            ?>" value="Cambio de grupo academico"> -->
            <?php
            }
            ?>
            <br><br><input type="button" onClick="history.go(-1)" value="Salir">
        </p>
    </body>
    <script language="javascript">
        function ira()
        {
            window.location.reload("cambiargrupoacademico.php");
        }
    </script>
</html>
