<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);


session_start();
$codigocarrera = $_SESSION['codigofacultad'];

$periodo = $_SESSION['codigoperiodosesion'];
$query_selperiodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p
where p.codigoperiodo = '$periodo'
ORDER BY p.codigoperiodo DESC ";
$selperiodo = mysql_query($query_selperiodo, $sala) or die(mysql_error());
$row_selperiodo = mysql_fetch_assoc($selperiodo);
$totalRows_selperiodo = mysql_num_rows($selperiodo);
/*
 * comentar este if debido a que se autorrecarga cuando se ingresa a este archivo
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 18 de Enero de 2018.
 */
//if (! isset ($_SESSION['nombreprograma']))
// {
?>
<!-- <script>
//   window.location.reload("https://artemisa.unbosque.edu.co/");
 </script>-->
<?php
// }
// end
require('funcionmateriaaprobada.php');


$query_semestrecarrera = "SELECT nombrecarrera,MAX(semestredetalleplanestudio * 1) AS mayor
						FROM planestudio p,detalleplanestudio d,carrera c
						WHERE p.idplanestudio = d.idplanestudio
						AND c.codigocarrera = p.codigocarrera
						AND p.codigoestadoplanestudio LIKE '1%'
						and p.codigocarrera = '$codigocarrera' 
						GROUP by 1 ";
$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die(mysql_error());
$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);
?>
<style type="text/css">
    <!--
    .Estilo1 {font-family: Tahoma; font-size: 12px}
    .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
    .Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
    .Estilo4 {color: #FF0000}
    -->
</style>
<form name="form1" method="post" action="">
    <p align="center"><span class="Estilo3">LISTADO DE MATERIAS PENDIENTES DE ESTUDIANTES DE &Uacute;LTIMO SEMESTRE</span><br>
        <span class="Estilo2"><?php echo $row_selperiodo['nombreperiodo']; ?>&nbsp;<br>
            &nbsp;<?php echo date("Y-m-d"); ?></span></p>
    <table width="60%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
        <tr bgcolor="#C5D5D6" class="Estilo2">
            <td colspan="6"4 align="center"><?php echo $row_semestrecarrera['nombrecarrera']; ?></td>
        </tr>
        <tr bgcolor="#C5D5D6" class="Estilo2">
            <td colspan="1" align="center">Documento</td>
            <td colspan="1" align="center">Nombre Estudiante</td>
            <td colspan="1" align="center">Código Materia</td>
            <td colspan="1" align="center">Semestre</td>
            <td colspan="1" align="center">Nombre Materia</td>
            <td colspan="1" align="center">Estado</td>
        </tr>
        <?php
        mysql_select_db($database_sala, $sala);
        $query_estudiante = "select distinct e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,eg.numerodocumento
					 from estudiante e,ordenpago o,prematricula p,estudiantegeneral eg
					 where e.codigoestudiante = o.codigoestudiante					
					 and e.idestudiantegeneral = eg.idestudiantegeneral
					 and o.idprematricula = p.idprematricula
					 and o.codigoestadoordenpago like '4%'
					 and p.codigoestadoprematricula like '4%'					
					 and o.codigoperiodo = '$periodo'
					 and p.semestreprematricula = '" . $row_semestrecarrera['mayor'] . "'
					 AND e.codigocarrera = '$codigocarrera'
					 order by 3 ";
        $estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
        $row_estudiante = mysql_fetch_assoc($estudiante);
        $totalRows_estudiante = mysql_num_rows($estudiante);
        $contadorperdidas = 0;
        $contadorganadas = 0;
        if (!$row_estudiante) {
            echo "<script language='JavaScript'>alert('No Presenta estudiantes en ultimo semestre')</script>";
            /*
             * Se comenta esta linea para que no muestre el codigo fuente
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Modificado 18 de Enero de 2018.
             */
//    echo "<script language='JavaScript'>history.go(-1)</script>";
//    end
        }

        do {
            unset($materiaspropuestas);
            unset($codigoestudiante);
            unset($totalmaterias);
            unset($semestre);
            $cuentamateriaspendientes = 0;
            $codigoestudiante = $row_estudiante['codigoestudiante'];
            require('generarcargaestudiante.php');
            if ($materiaspropuestas <> "") {
                foreach ($materiaspropuestas as $k => $v) {
                    $totalmaterias[] = $v['codigomateria'];
                }
            }
            if ($materiasobligatorias <> "") {
                foreach ($materiasobligatorias as $k1 => $v1) {
                    $totalmaterias[] = $v1['codigomateria'];
                }
            }
            ?>
            <tr class="Estilo1">   
                <td rowspan="<?php echo count($totalmaterias); ?>"><div align="center"><?php echo $row_estudiante['numerodocumento']; ?></div></td>
                <td rowspan="<?php echo count($totalmaterias); ?>"><div align="center"><?php echo $row_estudiante['apellidosestudiantegeneral']; ?><br>
            <?php echo $row_estudiante['nombresestudiantegeneral']; ?></div></td>
            <?php
            if ($totalmaterias <> "") {
                foreach ($totalmaterias as $k => $v) {
                    $query_materiasfaltantes = "SELECT * 
			                              from materia m
										  where codigomateria = '" . $v . "'  
									";

                    $materiasfaltantes = mysql_query($query_materiasfaltantes, $sala) or die(mysql_error());
                    $row_materiasfaltantes = mysql_fetch_assoc($materiasfaltantes);
                    $totalRows_materiasfaltantes = mysql_num_rows($materiasfaltantes);

                    $query_seltotalcreditossemestre2 = "SELECT *
								FROM detalleplanestudio d,planestudioestudiante p
								WHERE d.idplanestudio = p.idplanestudio
								AND p.codigoestudiante = '$codigoestudiante'
								AND d.codigomateria = '$v'									
								AND p.codigoestadoplanestudioestudiante LIKE '1%' ";
                    $seltotalcreditossemestre2 = mysql_db_query($database_sala, $query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2" . mysql_error());
                    $totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
                    $row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);

                    if ($row_seltotalcreditossemestre2 == "") {
                        $query_seltotalcreditossemestre2 = "SELECT *
											FROM detallelineaenfasisplanestudio d,planestudioestudiante p
											WHERE d.idplanestudio = p.idplanestudio
											AND p.codigoestudiante = '$codigoestudiante'
											AND d.codigomateriadetallelineaenfasisplanestudio = '$v'											
											AND p.codigoestadoplanestudioestudiante LIKE '1%' ";
                        $seltotalcreditossemestre2 = mysql_db_query($database_sala, $query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2" . mysql_error());
                        $totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
                        $row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);


                        $semestre = $row_seltotalcreditossemestre2['semestredetallelineaenfasisplanestudio'];
                    } else {
                        $semestre = $row_seltotalcreditossemestre2['semestredetalleplanestudio'];
                    }

                    $query_estadomateria = "SELECT *
											FROM detalleprematricula d,prematricula p
											WHERE d.idprematricula = p.idprematricula
											AND p.codigoestudiante = '$codigoestudiante'
											AND d.codigomateria = '$v'
											AND p.codigoestadoprematricula like '4%'
											and d.codigoestadodetalleprematricula like '3%'										
											AND p.codigoperiodo = '$periodo' ";

                    $estadomateria = mysql_db_query($database_sala, $query_estadomateria) or die("$query_seltotalcreditossemestre2" . mysql_error());
                    $totalRows_estadomateria = mysql_num_rows($estadomateria);
                    $row_estadomateria = mysql_fetch_array($estadomateria);

                    if ($row_estadomateria <> "") {
                        $estado = "Matriculada";
                    } else {
                        $estado = "Sin Matricular";
                        $cuentamateriaspendientes = 1;
                    }
                    ?>	
                        <td align="center" class="Estilo1"><?php echo $v; ?></td>
                        <td align="center" class="Estilo1"><?php echo $semestre; ?></td>
                        <td align="center" class="Estilo1"><?php echo $row_materiasfaltantes['nombremateria']; ?></td>	
                        <td align="center" class="Estilo1"><?php echo $estado; ?></td>			 
                    </tr>
                        <?php
                    }
                }
                unset($materiaspropuestas);
                unset($codigoestudiante);
                unset($value1);
                unset($key3);
                unset($value3);
                if ($cuentamateriaspendientes == 0) {
                    $contadorganadas++;
                } else {
                    $contadorperdidas++;
                }
            } while ($row_estudiante = mysql_fetch_assoc($estudiante));
            ?>
        <tr>
            <td colspan="6" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" class="Estilo2" bgcolor="#C5D5D6"><div align="center"><span class="Estilo5">Total de Estudiantes con Materias Pendientes</span></div></td>
            <td colspan="2" class="Estilo2"><div align="center"><?php echo $contadorperdidas; ?></div></td>			
        </tr>
        <tr>
            <td colspan="4" class="Estilo2" bgcolor="#C5D5D6"><div align="center"><span class="Estilo5">Total de Estudiantes Sin Materias Pendientes</span></div></td>
            <td colspan="2" class="Estilo2" ><div align="center"><?php echo $contadorganadas; ?></div></td>			
        </tr>
    </table>
    <br>
    <div align="center">
        <input type="button" name="Submit" value="Imprimir" onClick="window.print()">

    </div>
    <p align="center">&nbsp;</p>
</form>
