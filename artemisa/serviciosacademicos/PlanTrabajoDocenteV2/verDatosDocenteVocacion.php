<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace limpeza de codigo y se deja apuntando a la libreria predeterminda de phpmailer
 * @since Diciembre 3, 2019
 */ 
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
include_once ('../EspacioFisico/templates/template.php');

require_once(realpath(dirname(__FILE__)) . '/../funciones/phpmailer/class.phpmailer.php');

include 'lib/ControlClienteCorreo.php';


$db = getBD();

function convertirArreglo($arreglo) {
    $arregloResultado = array();
    foreach ($arreglo as $key => $row) {
        $arregloResultado[$row["id"]][] = $row;
    }
    return $arregloResultado;
}

$Periodo = $_GET["idPeriodo"];

$id_Programa = $_GET['idPrograma'];
$id_Vocaciones = explode("|", $_GET['idVocacion']);
$id_Vocaciones = array_unique($id_Vocaciones);

$idDecano = $_GET["idDecano"];

foreach ($id_Vocaciones as $id_Vocacion) {
    if ($id_Vocacion == 1) {

        $sql = 'SELECT iddocente,
		nombredocente,
		SUM(totalhoras) AS totales,
		vocacion,
		VocacionesPlanesTrabajoDocenteId
	FROM
	(SELECT pl.iddocente,
			CONCAT(
				d.nombredocente,
				" ",
				d.apellidodocente
			) AS nombredocente,
			SUM(pl.HorasPresencialesPorSemana + pl.HorasPreparacion + pl.HorasEvaluacion + pl.HorasAsesoria + pl.HorasTIC + pl.HorasInnovar + pl.HorasTaller + pl.HorasPAE) as totalHoras,
			v.Nombre AS vocacion,
			v.VocacionesPlanesTrabajoDocenteId
		FROM
			PlanesTrabajoDocenteEnsenanza pl,
			docente d,
			VocacionPlanesTrabajoDocentes v
		WHERE pl.codigoestado = 100
		AND d.iddocente = pl.iddocente 
		AND pl.iddocente = ' . $_GET["idDocente"] . '
		AND pl.codigocarrera IN (' . $id_Programa . ')
		AND v.VocacionesPlanesTrabajoDocenteId = "' . $id_Vocacion . '"
		AND pl.codigoperiodo="' . $Periodo . '"
		GROUP BY
			pl.iddocente) b';
        $datos = $db->GetRow($sql);

        $sql = 'SELECT id, nombrecarrera, nombremateria, codigomateria, totalhoras, TipoHoras 
				FROM ( SELECT
					pl.PlanTrabajoDocenteEnsenanzaId as id,
					c.nombrecarrera,
					m.nombremateria,
					m.codigomateria,
					SUM(pl.HorasPresencialesPorSemana+pl.HorasPreparacion+pl.HorasEvaluacion+pl.HorasAsesoria+
					pl.HorasTIC+pl.HorasInnovar+pl.HorasTaller+pl.HorasPAE) as totalhoras, pl.TipoHoras
				FROM
					PlanesTrabajoDocenteEnsenanza pl,
					carrera c,
				materia m
				WHERE
					pl.codigoestado = 100
				AND c.codigocarrera=pl.codigocarrera
				AND m.codigomateria=pl.codigomateria
				AND pl.iddocente = ' . $_GET["idDocente"] . '
				AND pl.codigoperiodo="' . $Periodo . '"
				AND pl.codigocarrera IN (' . $id_Programa . ')
				GROUP BY pl.codigocarrera,pl.codigomateria, pl.TipoHoras, pl.PlanTrabajoDocenteEnsenanzaId
				ORDER BY c.nombrecarrera,m.nombremateria ) b
				WHERE totalhoras != 0';
        $asignaturas = $db->GetArray($sql);

        $sql = 'SELECT
				pl.PlanTrabajoDocenteEnsenanzaId as id, 
				pl.HorasPresencialesPorSemana,
				pl.HorasPreparacion,
				pl.HorasEvaluacion,
				pl.HorasAsesoria,
				pl.HorasTIC,
                pl.HorasInnovar,
                pl.HorasTaller,
				pl.HorasPAE,
				a.Nombre as actividad
			FROM
				PlanesTrabajoDocenteEnsenanza pl 
			INNER JOIN	ActividadesPlanesTrabajoDocenteEnsenanza a ON a.PlanTrabajoDocenteEnsenanzaId=pl.PlanTrabajoDocenteEnsenanzaId
			WHERE
				pl.codigoestado = 100 
			AND pl.iddocente = ' . $_GET["idDocente"] . '
			AND pl.codigoperiodo="' . $Periodo . '"
			AND (a.codigoestado=100 OR a.codigoestado IS NULL)';
        $actividades = $db->GetArray($sql);
        $actividades = convertirArreglo($actividades);
    } else {
        $sql = 'SELECT d.iddocente,
			CONCAT(
				d.nombredocente,
				" ",
				d.apellidodocente
			) AS nombredocente,
			SUM(
				HorasDedicadas
			) AS totalHoras,
			v.Nombre AS vocacion,
			v.VocacionesPlanesTrabajoDocenteId
		FROM
			PlanesTrabajoDocenteOtros pl,
			docente d,
			VocacionPlanesTrabajoDocentes v
		WHERE
			pl.codigoestado = 100
		AND d.iddocente = pl.iddocente 
		AND pl.iddocente = ' . $_GET["idDocente"] . ' 
		AND pl.VocacionesPlanesTrabajoDocenteId=v.VocacionesPlanesTrabajoDocenteId 
		AND v.VocacionesPlanesTrabajoDocenteId = "' . $id_Vocacion . '" 
		GROUP BY
			pl.iddocente';
        $datos = $db->GetRow($sql);

        $sql = 'SELECT
					pl.PlanTrabajoDocenteOtrosId as id,
					c.nombrecarrera,
					pl.Nombres as nombremateria,
					1 as codigomateria,
					SUM(HorasDedicadas) as totalhoras, pl.TipoHoras
				FROM
					PlanesTrabajoDocenteOtros pl,
					carrera c
				WHERE
					pl.codigoestado = 100
				AND c.codigocarrera=pl.codigocarrera
				AND pl.iddocente = ' . $_GET["idDocente"] . '
				AND pl.codigoperiodo="' . $Periodo . '"
				AND pl.codigocarrera IN (' . $id_Programa . ') 
				AND pl.VocacionesPlanesTrabajoDocenteId = "' . $id_Vocacion . '" 
				GROUP BY pl.PlanTrabajoDocenteOtrosId
				ORDER BY c.nombrecarrera,pl.Nombres';
        $asignaturas = $db->GetArray($sql);

        $sql = 'SELECT
				pl.PlanTrabajoDocenteOtrosId as id, 
				pl.HorasDedicadas,
				t.Nombre as tipo,
				a.Nombre as actividad
			FROM
				PlanesTrabajoDocenteOtros pl,
				ActividadesPlanesTrabajoDocenteOtros a, 
TiposPlanesTrabajoDocenteOtros t 
			WHERE
				pl.codigoestado = 100
			AND a.PlanTrabajoDocenteOtrosId=pl.PlanTrabajoDocenteOtrosId
			AND pl.iddocente = ' . $_GET["idDocente"] . '
			AND pl.codigoperiodo= "' . $Periodo . '"
			AND a.codigoestado=100 
AND pl.TipoPlanTrabajoDocenteOtrosId=t.TipoPlanTrabajoDocenteOtrosId 
			AND pl.VocacionesPlanesTrabajoDocenteId = "' . $id_Vocacion . '"';
        $actividades = $db->GetArray($sql);
        $actividades = convertirArreglo($actividades);

        $sqlSumaHoras = 'SELECT SUM(HorasDedicadas) as totalHoras FROM (SELECT
						HorasDedicadas
					FROM
						PlanesTrabajoDocenteOtros pl,
						carrera c
					WHERE
						pl.codigoestado = 100
					AND c.codigocarrera = pl.codigocarrera
					AND pl.iddocente = ' . $_GET["idDocente"] . '
					AND pl.codigoperiodo = "' . $Periodo . '"
					AND pl.codigocarrera IN (' . $id_Programa . ')
					AND pl.VocacionesPlanesTrabajoDocenteId = "' . $id_Vocacion . '"
					GROUP BY
						pl.PlanTrabajoDocenteOtrosId
					ORDER BY
						c.nombrecarrera,
						pl.Nombres) b';
        $totalHorasOtros = $db->Execute($sqlSumaHoras);
    }
    $id_Docente = $datos['iddocente'];

    $sqlDocentesSobreSueldo = "SELECT COUNT(DocenteId) AS existe
							FROM DocenteSobreSueldos
							WHERE DocenteID = $id_Docente
							AND CodigoEstado = 100";
    $docentesSobreSueldo = $db->Execute($sqlDocentesSobreSueldo);

    $docentesSobreSueldo = $docentesSobreSueldo->fields["existe"];
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <title>Datos vocación del docente</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:700,700italic,300,300italic,100,100italic">
            <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,400,400italic">
            <link type="text/css" rel="stylesheet" href="css/styles.css" />
            <link type="text/css" rel="stylesheet" href="css/style2.css">
            <link type="text/css" rel="stylesheet" href="css/gips.css" />
            <link rel="stylesheet" href="../mgi/css/cssreset-min.css" type="text/css" /> 
            <link rel="stylesheet" href="../css/demo_page.css" type="text/css" /> 
            <link rel="stylesheet" href="../css/demo_table_jui.css" type="text/css" /> 
            <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
            <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
            <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
            <style type="text/css">
                html{
                    height: 100%;
                    margin:0;
                    padding:0;
                }
                body {
                    min-height: 100%;
                    margin:0;
                    padding:0;
                }
                #paginaDatosVocacion{
                    padding: 20px 40px;
                    background-color: #404040;
                    margin:0;
                }
                #paginaTextArea{
                    padding: 10px 40px;
                    background-color: #404040;
                    margin:0;
                }

                h3{
                    margin-top:0.2em;
                }
                h2,h3{width:860px;}
                table#tablaReporteVocacion thead tr th{
                    background-color:transparent;color:#fffc0b;border-color:#fff;
                }
                table#tablaReporteVocacion thead tr,table#tablaReporteVocacion tbody tr td {
                    border-color:#fff;
                }

                table#tablaReporteVocacion tbody{
                    background-color:transparent;color:#fff;border-color:#fff;
                }
                table#tablaReporteVocacion table.tablaActividades tr td,table#tablaReporteVocacion table.tablaActividades tr{
                    border:0;
                }
                table#tablaReporteVocacion table.tablaActividades{
                    margin-bottom:0;
                }
                #submit {
                    font-weight: normal;
                    cursor: pointer;
                    padding: 5px;
                    margin: 0 10px 20px 0;
                    border: 1px solid #ccc;
                    background: #eee;
                    border-radius: 4px 4px 4px 4px;
                    color: black;
                }

                #submit:hover {
                    background: #ddd;
                }

                #paginaTextArea h2{
                    color:#fff;
                    padding-bottom: 8px;
                }

                #txtObservacionesArea{
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: small;
                    color: #000;
                }

                #paginaTextArea{
                    width:auto; font-family: Arial, Helvetica, sans-serif;
                }

                #paginaTextArea #tablaTextArea tr, #paginaTextArea #tablaTextArea tr td{
                    border:0;
                    padding:0;
                }

                #paginaTextArea textarea{
                    clear: both;
                    display: block;
                    float: none;
                    height: 100px;
                    padding-top: 10px;
                    width: 860px;
                }

                #paginaTextArea input[type="submit"] {
                    background: #FFCC02;
                    border: none;
                    padding: 10px 25px 10px 25px;
                    color: #585858;
                    border-radius: 4px;
                    -moz-border-radius: 4px;
                    -webkit-border-radius: 4px;
                    text-shadow: 1px 1px 1px #FFE477;
                    font-weight: bold;
                    box-shadow: 1px 1px 1px #3D3D3D;
                    -webkit-box-shadow:1px 1px 1px #3D3D3D;
                    -moz-box-shadow:1px 1px 1px #3D3D3D;
                    margin-top:10px;
                }
                #paginaTextArea input[type="submit"]:hover {
                    color: #333;
                    background-color: #EBEBEB;
                }


            </style>
        </head>
        <body>
    <?php if (!empty($asignaturas)) { ?>
                <div id="paginaDatosVocacion">
                <?php if ($id_Vocacion == 1) { ?>
                        <h2><font color="white"><?php echo $datos["vocacion"] . " - " . $datos["totales"] . " horas"; ?></font></h2>
                    <?php } else {
                        ?>
                        <h2><font color="white"><?php echo $datos["vocacion"] . " - " . $totalHorasOtros->fields['totalHoras'] . " horas"; ?></font></h2>
                    <?php } ?>	
                    <h3><font color="white"><?php echo $datos["nombredocente"] ?></font></h3>

                    <table id="tablaReporteVocacion" align="center" class="formData last" style="width:860px;" border="2" bordercolor="#fff" style="margin: 20px 0;">
                        <thead>      
                            <tr class="dataColumns category">
                                <th class="column borderR"><span>Programa académico</span></th> 
        <?php if ($id_Vocacion == 2 || $id_Vocacion == 3) { ?><th class="column borderR"><span>Modalidad</span></th><?php } ?>
                                <th class="column borderR"><?php if ($id_Vocacion == 1) { ?><span>Materia</span><?php } else { ?><span>Nombre del proyecto o actividad</span><?php } ?></th>
        <?php if ($docentesSobreSueldo != 0) { ?>
                                    <th class="column borderR"><span>Tipo</span></th>
                                <?php } ?>  
                                <th class="column borderR"><span>Total horas</span></th> 
                                <th class="column borderR"><span>Actividades</span></th> 
                            </tr>
                        </thead>
        <?php foreach ($asignaturas as $asignatura) {
            ?>				
                            <tr class="dataColumns" >
                                <td class="column borderR"><?php echo $asignatura["nombrecarrera"]; ?></td>
                            <?php if ($id_Vocacion == 2 || $id_Vocacion == 3) { ?><td class="column borderR"><?php echo $actividades[$asignatura["id"]][0]["tipo"]; ?></td><?php } ?>
                                <td class="column borderR"><?php if ($asignatura["codigomateria"] != 1 || $id_Vocacion != 1) {
                    echo $asignatura["nombremateria"];
                }
                ?></td>
                                    <?php if ($docentesSobreSueldo != 0) { ?>
                                    <td class="column center borderR"><?php echo $asignatura["TipoHoras"]; ?></td>
                                <?php } ?>
                                <td class="column center borderR"><?php
                                if ($asignatura["codigomateria"] != 1 || $id_Vocacion != 1) {
                                    echo $asignatura["totalhoras"];
                                } else if ($asignatura["codigomateria"] == 1) {

                                    echo "Atención en laboratorios talleres o preclinicas: " . $actividades[$asignatura["id"]][0]["HorasTaller"] . "<br/>";
                                    echo "Atención - tutorias PAE: " . $actividades[$asignatura["id"]][0]["HorasPAE"] . "<br/>";
                                    echo "Horas dedicadas a TIC: " . $actividades[$asignatura["id"]][0]["HorasTIC"] . "<br/>";
                                    echo "Horas dedicadas a la Innovación: " . $actividades[$asignatura["id"]][0]["HorasInnovar"] . "<br/>";
                                }
                                ?></td>
                                <td class="column center">
                                    <table align="center" class="formData tablaActividades" width="100%" border="0">
                                        <?php
                                        foreach ($actividades[$asignatura["id"]] as $actividad) {
                                            ?>
                                            <tr>
                                                <td><?php echo $actividad["actividad"]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table></td>
                            </tr>    
                        <?php } ?>
                    </table>
                </div>
            <?php
            }
        } if (isset($idDecano)) {

            $sqlDirectivo = "SELECT CONCAT( U.nombres, ' ', U.apellidos ) AS Nombre,
								U.usuario U
								FROM usuario U
								INNER JOIN tipousuario TU ON(TU.codigotipousuario = U.codigotipousuario)
								WHERE idusuario = " . $idDecano . "";
            $Directivo = $db->Execute($sqlDirectivo);

            $nombreDirectivo = $Directivo->fields['Nombre'];

            if (isset($_POST["submit"])) {

                $sqlCorreo = "SELECT CONCAT( D.nombredocente, ' ', D.apellidodocente ) AS Nombre , D.emaildocente,
								U.usuario 
								FROM docente D
								INNER JOIN usuario U ON( U.numerodocumento = D.numerodocumento)
								INNER JOIN tipousuario TU ON(TU.codigotipousuario = U.codigotipousuario)
								WHERE iddocente = " . $id_Docente . "
								AND TU.codigotipousuario LIKE '5%'";

                $Docente = $db->Execute($sqlCorreo);

                $emailDocente = $Docente->fields['emaildocente'];
                $nombreDocente = $Docente->fields['Nombre'];

                $usuario = $Docente->fields['usuario'];

                $completaEmail = "@unbosque.edu.co";

                $emailUsuario = $usuario . $completaEmail;

                $observacion = mysql_real_escape_string($_POST['txtObservacionesArea']);

                $observacion = str_replace("\n", "/<br />", $observacion);

                if ($observacion != "") {

                    $observacionesDecano = "INSERT INTO ObservacionDecanos (
                                                                            ObservacionDecanosId,
                                                                            DocenteId,
                                                                            UsuarioId,
                                                                            CodigoPeriodo,
                                                                            Observacion,
                                                                            CodigoEstado,
                                                                            UsuarioCreacion,
                                                                            UsuarioUltimaModificacion,
                                                                            FechaCreacion,
                                                                            FechaUltimaModificacion,
                                                                            CodigoCarrera
                                                                            )
                                                                            VALUES
                                                                            ((SELECT IFNULL( MAX( OBS.ObservacionDecanosId ) +1, 1 ) 
                                                                FROM ObservacionDecanos OBS
                                                                 ), $id_Docente, $idDecano, $Periodo, '$observacion', default, $idDecano, $idDecano, NOW(), NOW(), $id_Programa )";
				$observacionDecano = $db->Execute( $observacionesDecano );

                    if ($observacionDecano === false) {
                        echo "<script>alert('No se ingresaron las observaciones');</script>";
                    } else {
                        echo "<script>alert('Se ingreso correctamente los comentarios');</script>";
                        if ($emailDocente != "") {
                            $controlClienteCorreo = new ControlClienteCorreo();
                            $enviarCorreo = $controlClienteCorreo->enviarObservacion($emailDocente, $emailUsuario, $nombreDocente, $id_Docente, $nombreDirectivo);
                        } else {
                            $controlClienteCorreo = new ControlClienteCorreo();
                            $enviarCorreo = $controlClienteCorreo->enviarObservacionUsuario($emailUsuario, $nombreDocente, $id_Docente, $nombreDirectivo);
                        }
                    }
                } else {
                    echo "<script>alert('Por favor ingrese una observación');</script>";
                }
            }
            ?>

            <div id="paginaTextArea">
                <h2>Ingresar observaciones sobre el plan del docente</h2>
                <form id="formTextArea" method="post" >
                    <textarea id="txtObservacionesArea" name="txtObservacionesArea" rows="10" cols="70" placeholder="Escriba sus observaciones"></textarea>
                    <input type="submit" id="submit" name="submit" value="Enviar" />
                </form>
            </div>
        <?php } ?>
    </body>
</html>