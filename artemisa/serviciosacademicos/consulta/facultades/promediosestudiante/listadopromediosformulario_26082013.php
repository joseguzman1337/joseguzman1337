<?php require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
session_start();
$periodosemestral= $_GET['periodo'];
$carrera = $_SESSION['codigofacultad'];


if ($_GET['periodo'] == 0) {
    echo '<script language="JavaScript">alert("Dede Seleccionar un Periodo")</script>';
    echo '<script language="JavaScript">history.go(-1)</script>';
}
set_time_limit(0);

$redondeo = 3;

if ($_GET['busqueda_todos']) {
    mysql_select_db($database_sala, $sala);
    $query_promedios = "select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
	from estudiante e,prematricula p,estudiantegeneral eg
	where p.codigoestudiante = e.codigoestudiante
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigocarrera = '$carrera'
	and p.codigoperiodo = '$periodosemestral'
	and p.codigoestadoprematricula like '4%'
	order by p.semestreprematricula,eg.apellidosestudiantegeneral";
    //echo $query_promedios;
    $promedios= mysql_query($query_promedios, $sala) or die(mysql_error());
    $row_promedios= mysql_fetch_assoc($promedios);
    $totalRows_promedios= mysql_num_rows($promedios);

    if (!$row_promedios) {
        $query_promedios = "SELECT DISTINCT e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
		FROM estudiante e,notahistorico n,estudiantegeneral eg
		WHERE n.codigoestudiante = e.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral
		AND e.codigocarrera = '$carrera'
		AND n.codigoperiodo = '$periodosemestral'
		AND n.codigoestadonotahistorico LIKE '1%'
		ORDER BY eg.apellidosestudiantegeneral"; 
        //echo $query_promedios;
        $promedios= mysql_query($query_promedios, $sala) or die(mysql_error());
        $row_promedios= mysql_fetch_assoc($promedios);
        $totalRows_promedios= mysql_num_rows($promedios);
    }
    do {
        if ($_GET['promedio'] == 1) {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            require('../../../funciones/notas/calculopromediosemestral.php');
            $notaspromedio[$codigoestudiante] = $promediosemestralperiodo;
        }
        else {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            //$redondeo = 3;
            //echo $redondeo;
            require('../../../funciones/notas/calculopromedioacumulado.php');
            $notaspromedio[$codigoestudiante] = $promedioacumulado;
        }
    }while($row_promedios= mysql_fetch_assoc($promedios));

}
else {
    mysql_select_db($database_sala, $sala);
    $query_promedios = "select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
	from estudiante e,prematricula p,estudiantegeneral eg
	where p.codigoestudiante = e.codigoestudiante
	and e.idestudiantegeneral = eg.idestudiantegeneral
    and e.codigocarrera = '$carrera'
	and p.codigoperiodo = '$periodosemestral'
	and p.semestreprematricula = '".$_GET['busqueda_semestre']."'
	and p.codigoestadoprematricula like '4%'
	order by eg.apellidosestudiantegeneral";
    //echo $query_promedios;
    $promedios= mysql_query($query_promedios, $sala) or die(mysql_error());
    $row_promedios= mysql_fetch_assoc($promedios);
    $totalRows_promedios= mysql_num_rows($promedios);

    do {
        if ($_GET['promedio'] == 1) {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            require('../../../funciones/notas/calculopromediosemestral.php');
            $notaspromedio[$codigoestudiante] = $promediosemestralperiodo;
        }
        else {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            require('../../../funciones/notas/calculopromedioacumulado.php');
            //$promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala, $periodo = 0, );
            $notaspromedio[$codigoestudiante] = $promedioacumulado;
        }
    }while($row_promedios= mysql_fetch_assoc($promedios));
}
?>
<style type="text/css">
    <!--
    .Estilo1 {font-family: TAHOMA}
    .Estilo2 {
        font-family: TAHOMA;
        font-weight: bold;
        font-size: x-small;
    }
    .Estilo3 {
        font-size: xx-small;
        font-weight: bold;
    }
    .Estilo4 {font-size: xx-small}
    .Estilo5 {
        font-size: x-small;
        font-weight: bold;
    }
    .Estilo6 {font-size: 14px}
    -->
</style>

<p align="center" class="Estilo2"><span class="Estilo6">LISTADO PROMEDIO</span>&nbsp;<?php if ($_GET['promedio'] == 1) echo "SEMESTRAL"; else echo "ACUMULADO";?> </p>
<table width="70%" border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6">
        <td colspan="6" class="Estilo1"><div align="center" class="Estilo5">
                <?php
                mysql_select_db($database_sala, $sala);
                $query_carrera = "select nombrecarrera
	                    from carrera 
						where codigocarrera = '$carrera'";
//echo $query_promedios;
                $carrera= mysql_query($query_carrera, $sala) or die(mysql_error());
                $row_carrera= mysql_fetch_assoc($carrera);
                $totalRows_carrera= mysql_num_rows($carrera);
                echo $row_carrera['nombrecarrera'];
                ?>
            </div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
        <td class="Estilo1"><div align="center" class="Estilo3">Puesto</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Semestre</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Documento</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Nombre</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Promedio Semestral</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Promedio Acumulado </div></td>
    </tr>
    <?php
    arsort ($notaspromedio);
    $puesto = 1;
    if ($_GET['promedio'] == 1) { // i f1
        foreach($notaspromedio as $key => $notica) {//
            $codigoestudiante = $key;
            //require('calculopromedioacumulado.php');
            $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala,0,3);
            mysql_select_db($database_sala, $sala);
            $query_estudiante = "select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,p.semestreprematricula,eg.numerodocumento
			from estudiante e,prematricula p,estudiantegeneral eg
			where p.codigoestudiante = e.codigoestudiante
			and e.idestudiantegeneral = eg.idestudiantegeneral
			and p.codigoestudiante = '$key'
			and p.codigoestadoprematricula like '4%'
			and p.codigoperiodo = '$periodosemestral'";
            //echo $query_estudiante,"<br>";
            $estudiante= mysql_query($query_estudiante, $sala) or die(mysql_error());
            $row_estudiante= mysql_fetch_assoc($estudiante);
            $totalRows_estudiante= mysql_num_rows($estudiante);

            if (! $row_estudiante) {
                mysql_select_db($database_sala, $sala);
                $query_estudiante = "SELECT DISTINCT e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
				FROM estudiante e,notahistorico n,estudiantegeneral eg
				WHERE n.codigoestudiante = e.codigoestudiante
				AND e.idestudiantegeneral = eg.idestudiantegeneral
				AND n.codigoestudiante = '$key'
				AND n.codigoperiodo = '$periodosemestral'
				AND n.codigoestadonotahistorico LIKE '1%'
                        ";
                //echo $query_estudiante,"<br>";
                $estudiante= mysql_query($query_estudiante, $sala) or die(mysql_error());
                $row_estudiante= mysql_fetch_assoc($estudiante);
                $totalRows_estudiante= mysql_num_rows($estudiante);
            }

            ?>
    <tr>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $puesto;
                        $puesto++;?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['semestreprematricula'];?>&nbsp;</div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['numerodocumento'];?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_estudiante['nombresestudiantegeneral'];?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4">
                        <?php
                        if ($notica < 3.3) {
                            echo "<font color='red'>",$notica,"</font>";
                        }
                        else {
                            echo $notica;
                        }
                        ?>&nbsp;</div></td>
        <td class="Estilo1"><div align="center" class="Estilo4">
                        <?php
                        if ($promedioacumulado < 3.3) {
                            echo "<font color='red'>",$promedioacumulado,"</font>";
                        }
                        else {
                            echo $promedioacumulado;
                        }
                        ?>&nbsp;</div></td>
    </tr>
            <?php
            $codigoestudiante = 0;
        }
    }// if 1
    else {
        foreach($notaspromedio as $key => $notica) {//
            $codigoestudiante = $key;
            require('../../../funciones/notas/calculopromediosemestral.php');
            mysql_select_db($database_sala, $sala);
            $query_estudiante = "select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,p.semestreprematricula,eg.numerodocumento
								from estudiante e,prematricula p,estudiantegeneral eg
								where p.codigoestudiante = e.codigoestudiante
								and e.idestudiantegeneral = eg.idestudiantegeneral
								and p.codigoestudiante = '$key'
								and p.codigoperiodo = '$periodosemestral'";
            //echo $query_promedios;
            $estudiante= mysql_query($query_estudiante, $sala) or die(mysql_error());
            $row_estudiante= mysql_fetch_assoc($estudiante);
            $totalRows_estudiante= mysql_num_rows($estudiante);

            if (! $row_estudiante) {
                mysql_select_db($database_sala, $sala);
                $query_estudiante = "SELECT DISTINCT e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
				FROM estudiante e,notahistorico n,estudiantegeneral eg
				WHERE n.codigoestudiante = e.codigoestudiante
				AND e.idestudiantegeneral = eg.idestudiantegeneral
				AND n.codigoestudiante = '$key'
				AND n.codigoperiodo = '$periodosemestral'
				AND n.codigoestadonotahistorico LIKE '1%'
                        ";
                //echo $query_estudiante,"<br>";
                $estudiante= mysql_query($query_estudiante, $sala) or die(mysql_error());
                $row_estudiante= mysql_fetch_assoc($estudiante);
                $totalRows_estudiante= mysql_num_rows($estudiante);
            }
            ?>
    <tr>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $puesto;
                        $puesto++;?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['semestreprematricula'];?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['numerodocumento'];?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_estudiante['nombresestudiantegeneral'];?></div></td>
        <td class="Estilo1"><div align="center" class="Estilo4">
                        <?php
                        if ($promediosemestralperiodo < 3.3) {
                            echo "<font color='red'>",$promediosemestralperiodo,"</font>";
                        }
                        else {
                            echo $promediosemestralperiodo;
                        }
                        ?>&nbsp;</div></td>
        <td class="Estilo1"><div align="center" class="Estilo4">
                        <?php
                        if ($notica < 3.3) {
                            echo "<font color='red'>",$notica,"</font>";
                        }
                        else {
                            echo $notica;
                        }
                        ?>&nbsp;</div></td>
    </tr>
            <?php
            $codigoestudiante = 0;
        } //foreich
    }
    ?>
</table>
<br>
<p align="center">
    <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">
    <input type="button" name="Submit" value="Imprimir" onClick="window.print()">
</p>	
