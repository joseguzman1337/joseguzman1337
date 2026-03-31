<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if (!isset($_SESSION['MM_Username'])) {
    ?>
    <blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi&oacute;n en el sistema</strong></blink>
    <?PHP
    exit();
}
$ruta = "../";
while (!is_file($ruta . 'Connections/sala2.php')) {
    $ruta = $ruta . "../";
}
require_once($ruta . 'Connections/sala2.php');
$rutaado = $ruta . "funciones/adodb/";
require_once($ruta . 'Connections/salaado.php');
include("js/template.php");
//$db=writeHeader("Listado Usuarios",true);

$SQL = "select sum(graduados)+ sum(graduadosantiguos) as Total, SUM(Mujeres) as Mujeres,SUM(Hombres) as Hombres from (SELECT
	date_format( now(), '%Y' ) - date_format( eg.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( eg.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
	c.nombrecarrera,
	COUNT(rg.idregistrograduado) AS graduados,
	0 graduadosantiguos,
	COUNT(
		CASE
		WHEN g.codigogenero = 100 THEN
			1
		END
	) AS Mujeres,
	COUNT(
		CASE
		WHEN g.codigogenero = 200 THEN
			1
		END
	) AS Hombres,
	p.codigoperiodo,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduado rg,
	estudiante e,
	periodo p,
	carrera c,
	modalidadacademica m,
	genero g,
	estudiantegeneral eg
WHERE
	rg.codigoestudiante = e.codigoestudiante
AND c.codigomodalidadacademica = m.codigomodalidadacademica
AND c.codigocarrera = e.codigocarrera
AND rg.codigoestado = '100'
AND rg.codigoautorizacionregistrograduado = '100'
AND eg.idestudiantegeneral = e.idestudiantegeneral
AND g.codigogenero = eg.codigogenero
AND p.codigoperiodo BETWEEN 19782
AND 20152
AND rg.fechagradoregistrograduado BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
UNION
	SELECT
		date_format( now(), '%Y' ) - date_format( EG.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( EG.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
		c.nombrecarrera,
		0 graduados,
		COUNT(
			DISTINCT rg.idregistrograduadoantiguo
		) AS graduadosantiguos,
		COUNT(
			CASE
			WHEN EG.codigogenero = 100 THEN
				1
			END
		) AS Mujeres,
		COUNT(
			CASE
			WHEN EG.codigogenero = 200 THEN
				1
			END
		) AS Hombres,
		p.codigoperiodo,

	IF (
		SUBSTRING(p.codigoperiodo, 5, 5) = '2',
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-07-16'
		),
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-01-01'
		)
	) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduadoantiguo rg,
	periodo p,
	carrera c,
	modalidadacademica m,
	estudiante E,
	estudiantegeneral EG
WHERE
	c.codigomodalidadacademica = m.codigomodalidadacademica
AND rg.codigocarrera = c.codigocarrera
AND E.codigoestudiante = rg.codigoestudiante
AND EG.idestudiantegeneral = E.idestudiantegeneral
AND rg.codigocarrera = c.codigocarrera
AND rg.fechagradoregistrograduadoantiguo BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
ORDER BY
	codigoperiodo DESC,
	nombrecarrera) tc
	WHERE edad <=25
UNION
select sum(graduados)+ sum(graduadosantiguos), SUM(Mujeres),SUM(Hombres) from (SELECT
	date_format( now(), '%Y' ) - date_format( eg.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( eg.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
	c.nombrecarrera,
	COUNT(rg.idregistrograduado) AS graduados,
	0 graduadosantiguos,
	COUNT(
		CASE
		WHEN g.codigogenero = 100 THEN
			1
		END
	) AS Mujeres,
	COUNT(
		CASE
		WHEN g.codigogenero = 200 THEN
			1
		END
	) AS Hombres,
	p.codigoperiodo,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduado rg,
	estudiante e,
	periodo p,
	carrera c,
	modalidadacademica m,
	genero g,
	estudiantegeneral eg
WHERE
	rg.codigoestudiante = e.codigoestudiante
AND c.codigomodalidadacademica = m.codigomodalidadacademica
AND c.codigocarrera = e.codigocarrera
AND rg.codigoestado = '100'
AND rg.codigoautorizacionregistrograduado = '100'
AND eg.idestudiantegeneral = e.idestudiantegeneral
AND g.codigogenero = eg.codigogenero
AND p.codigoperiodo BETWEEN 19782
AND 20152
AND rg.fechagradoregistrograduado BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
UNION
	SELECT
		date_format( now(), '%Y' ) - date_format( EG.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( EG.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
		c.nombrecarrera,
		0 graduados,
		COUNT(
			DISTINCT rg.idregistrograduadoantiguo
		) AS graduadosantiguos,
		COUNT(
			CASE
			WHEN EG.codigogenero = 100 THEN
				1
			END
		) AS Mujeres,
		COUNT(
			CASE
			WHEN EG.codigogenero = 200 THEN
				1
			END
		) AS Hombres,
		p.codigoperiodo,

	IF (
		SUBSTRING(p.codigoperiodo, 5, 5) = '2',
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-07-16'
		),
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-01-01'
		)
	) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduadoantiguo rg,
	periodo p,
	carrera c,
	modalidadacademica m,
	estudiante E,
	estudiantegeneral EG
WHERE
	c.codigomodalidadacademica = m.codigomodalidadacademica
AND rg.codigocarrera = c.codigocarrera
AND E.codigoestudiante = rg.codigoestudiante
AND EG.idestudiantegeneral = E.idestudiantegeneral
AND rg.codigocarrera = c.codigocarrera
AND rg.fechagradoregistrograduadoantiguo BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
ORDER BY
	codigoperiodo DESC,
	nombrecarrera) td
	WHERE edad > 25 AND edad<= 30
UNION
select sum(graduados)+ sum(graduadosantiguos), SUM(Mujeres),SUM(Hombres) from (
	SELECT
		date_format( now(), '%Y' ) - date_format( EG.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( EG.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
		c.nombrecarrera,
		0 graduados,
		COUNT(
			DISTINCT rg.idregistrograduadoantiguo
		) AS graduadosantiguos,
		COUNT(
			CASE
			WHEN EG.codigogenero = 100 THEN
				1
			END
		) AS Mujeres,
		COUNT(
			CASE
			WHEN EG.codigogenero = 200 THEN
				1
			END
		) AS Hombres,
		p.codigoperiodo,

	IF (
		SUBSTRING(p.codigoperiodo, 5, 5) = '2',
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-07-16'
		),
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-01-01'
		)
	) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduadoantiguo rg,
	periodo p,
	carrera c,
	modalidadacademica m,
	estudiante E,
	estudiantegeneral EG
WHERE
	c.codigomodalidadacademica = m.codigomodalidadacademica
AND rg.codigocarrera = c.codigocarrera
AND E.codigoestudiante = rg.codigoestudiante
AND EG.idestudiantegeneral = E.idestudiantegeneral
AND rg.codigocarrera = c.codigocarrera
AND rg.fechagradoregistrograduadoantiguo BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
ORDER BY
	codigoperiodo DESC,
	nombrecarrera) te
WHERE edad > 31 AND edad <= 35
UNION
select sum(graduados)+ sum(graduadosantiguos), SUM(Mujeres),SUM(Hombres) from (
	SELECT
		date_format( now(), '%Y' ) - date_format( EG.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( EG.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
		c.nombrecarrera,
		0 graduados,
		COUNT(
			DISTINCT rg.idregistrograduadoantiguo
		) AS graduadosantiguos,
		COUNT(
			CASE
			WHEN EG.codigogenero = 100 THEN
				1
			END
		) AS Mujeres,
		COUNT(
			CASE
			WHEN EG.codigogenero = 200 THEN
				1
			END
		) AS Hombres,
		p.codigoperiodo,

	IF (
		SUBSTRING(p.codigoperiodo, 5, 5) = '2',
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-07-16'
		),
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-01-01'
		)
	) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduadoantiguo rg,
	periodo p,
	carrera c,
	modalidadacademica m,
	estudiante E,
	estudiantegeneral EG
WHERE
	c.codigomodalidadacademica = m.codigomodalidadacademica
AND rg.codigocarrera = c.codigocarrera
AND E.codigoestudiante = rg.codigoestudiante
AND EG.idestudiantegeneral = E.idestudiantegeneral
AND rg.codigocarrera = c.codigocarrera
AND rg.fechagradoregistrograduadoantiguo BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
ORDER BY
	codigoperiodo DESC,
	nombrecarrera) tf
WHERE edad > 36 AND edad <= 40
UNION
select sum(graduados)+ sum(graduadosantiguos), SUM(Mujeres),SUM(Hombres) from (
	SELECT
		date_format( now(), '%Y' ) - date_format( EG.fechanacimientoestudiantegeneral, '%Y' ) -
					  ( date_format( now(), '00-%m-%d') < date_format( EG.fechanacimientoestudiantegeneral, '00-%m-%d' ) )
					AS 
					  edad,
		c.nombrecarrera,
		0 graduados,
		COUNT(
			DISTINCT rg.idregistrograduadoantiguo
		) AS graduadosantiguos,
		COUNT(
			CASE
			WHEN EG.codigogenero = 100 THEN
				1
			END
		) AS Mujeres,
		COUNT(
			CASE
			WHEN EG.codigogenero = 200 THEN
				1
			END
		) AS Hombres,
		p.codigoperiodo,

	IF (
		SUBSTRING(p.codigoperiodo, 5, 5) = '2',
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-07-16'
		),
		CONCAT(
			SUBSTRING(p.codigoperiodo, 1, 4),
			'-01-01'
		)
	) fecha_inicial,

IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
) fecha_final
FROM
	registrograduadoantiguo rg,
	periodo p,
	carrera c,
	modalidadacademica m,
	estudiante E,
	estudiantegeneral EG
WHERE
	c.codigomodalidadacademica = m.codigomodalidadacademica
AND rg.codigocarrera = c.codigocarrera
AND E.codigoestudiante = rg.codigoestudiante
AND EG.idestudiantegeneral = E.idestudiantegeneral
AND rg.codigocarrera = c.codigocarrera
AND rg.fechagradoregistrograduadoantiguo BETWEEN
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-16'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-01-01'
	)
)
AND
IF (
	SUBSTRING(p.codigoperiodo, 5, 5) = '2',
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-12-31'
	),
	CONCAT(
		SUBSTRING(p.codigoperiodo, 1, 4),
		'-07-15'
	)
)

GROUP BY
	c.codigocarrera,
	p.codigoperiodo
ORDER BY
	codigoperiodo DESC,
	nombrecarrera) tg
WHERE edad > 40";

if ($Data = &$db->Execute($SQL) === false) {
    echo 'Error en el SQL Data Solicitudes....<br><br>' . $SQL;
    die;
}
$Resultado = $Data->GetArray();
?>
    <!--<img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" onclick="ExportarExcel();" title="Exportar a Excel" />-->


<link type="text/css" rel="stylesheet" href="js/jquery.dataTables.css" />
<script type="text/javascript" language="javascript" src="js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>  
<form>
    <body>
        <div id="container" style="width:50%">
            <div id="test">                
                <h2>Distribuci&oacute;n de los egresados por facultad</h2>
                <table width="150%" cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                    <thead>
                        <tr>
                            <th colspan="1">Grupos de Edad</th>						                    
                            <th colspan="2">Mujeres</th>
                            <th colspan="2">Hombres</th>
                            <th colspan="2">Total</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><p>#</p></th>
                            <th><p>%</p></th>     
                            <th><p>#</p></th>                                   
                            <th><p>%</p></th> 
                            <th><p>#</p></th>                                   
                            <th><p>%</p></th> 
                        </tr>
                    </thead>
                    <tbody> 
                        <?PHP
                        $num = count($Resultado);
                        $totalH = 0;
                        for ($i = 0; $i <= count($Resultado); $i++) {
                            $totalH = $totalH + $Resultado[$i]['Hombres'];
                            $totalM = $totalM + $Resultado[$i]['Mujeres'];
                        }
                        for ($i = 0; $i <= count($Resultado); $i++) {
                            if ($Resultado[$i]['nombrefacultad'] <> '0') {
                                $id = $Resultado[$i]['SolicitudAsignacionEspacioId'];
                                //  print_r ($Resultado[$i]['SolicitudAsignacionEspacioId']);
                               if ($i <> count($Resultado)) {
                                    if($i ===0){
                                        $titulo=("25 o menós");
                                    }if($i===1){
                                        $titulo="26 a 30";
                                    }if($i===2){
                                        $titulo="31 a 35";
                                    }if($i===3){
                                        $titulo="36 a 40";
                                    }if($i===4){
                                        $titulo="Más de 40";
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><b><?PHP echo $titulo; ?></b></td>
                                        <td align="center"><?PHP echo $Resultado[$i]['Mujeres']; ?></td>
                                        <td align="center"><?PHP echo number_format(($Resultado[$i]['Mujeres'] * 100) / $totalM, 2, ',', ' '); ?></td>
                                        <td align="center"><?PHP echo $Resultado[$i]['Hombres']; ?></td>                       
                                        <td align="center"><?PHP echo number_format(($Resultado[$i]['Hombres'] * 100) / $totalH, 2, ',', ' '); ?></td>
                                        <td align="center"><?PHP echo ($Resultado[$i]['Hombres']+ $Resultado[$i]['Mujeres']);?></td>                       
                                        <td align="center"><?PHP echo number_format((($Resultado[$i]['Hombres']+ $Resultado[$i]['Mujeres']) * 100) / ($totalH+$totalM), 2, ',', ' '); ?></td>
                                        <?PHP
                                        /*                                         * ************************************************** */
                                    } else {                                        
                                        echo "<td><b>Total</b></td>";
                                        echo "<td align='center'>".$totalM."</td>";
                                        echo "<td align='center'>".($totalM*100)/$totalM."</td>";
                                        echo "<td align='center'>".$totalH."</td>";
                                        echo "<td align='center'>".($totalH*100)/ $totalH."</td>";
                                        echo "<td align='center'>".($totalH+$totalM)."</td>";
                                        echo "<td align='center'>".(($totalH+$totalM) * 100)/($totalH+$totalM)."</td>";
                                    }
                                    echo "</tr>";
                                }
                            }//for
                            ?>    

                    </tbody>
                </table>
            </div>
        </div>
    </body>
</form>
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion" >
    <body>
        <table border="1" align="left" >
            <tr>
                <td align="center" size="5">
                    <p><img src="js/images/Office-Excel-icon.png" width="30" style="cursor: pointer;" class="botonExcel" /></button></p><FONT SIZE=1><b>Exportar a Excel</b></FONT></b>
                    <input type="hidden" id="datos_a_enviar2" name="datos_a_enviar2" />
                </td>
                <td align="center" >
                    <p><a href="menugraduados.php" ><img  width="30" src="js/images/return.png" /></a></p><b><FONT SIZE=1>Retornar</FONT></b>
                  
                </td>
            </tr>
        </table>
    </body>
</form>


<script type="text/javascript">
    $(".botonExcel").click(function (event) {
            $("#datos_a_enviar2").val($("<div>").append($("#example").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
    });
</script>


<?php writeFooter();
?>       


