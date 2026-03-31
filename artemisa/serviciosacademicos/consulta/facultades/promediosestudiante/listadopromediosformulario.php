<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
session_start();

$periodosemestral= $_REQUEST['anio'].$_REQUEST['periodo'];
$carrera = ($_REQUEST['codigocarrera'])?$_REQUEST['codigocarrera']:$_SESSION['codigofacultad'];

set_time_limit(0);
$redondeo = 3;

if ($_REQUEST['busqueda_semestre']==2) {
    mysql_select_db($database_sala, $sala);
    $query_promedios = "select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.numerodocumento
	from estudiante e,prematricula p,estudiantegeneral eg
	where p.codigoestudiante = e.codigoestudiante
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigocarrera = '$carrera'
	and p.codigoperiodo = '$periodosemestral'
	and p.codigoestadoprematricula like '4%'
	order by p.semestreprematricula,eg.apellidosestudiantegeneral";    
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
        $promedios= mysql_query($query_promedios, $sala) or die(mysql_error());
        $row_promedios= mysql_fetch_assoc($promedios);
        $totalRows_promedios= mysql_num_rows($promedios);
    }
    do {
        if ($_REQUEST['promedio'] == 1) {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            $redondeo = 3;
            require('../../../funciones/notas/calculopromediosemestral.php');
            $notaspromedio[$codigoestudiante] = $promediosemestralperiodo;
        }
        else {
            $codigoestudiante = $row_promedios['codigoestudiante'];            
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
	and p.semestreprematricula = '".$_REQUEST['semestre']."'
	and p.codigoestadoprematricula like '4%'
	order by eg.apellidosestudiantegeneral";    
    $promedios= mysql_query($query_promedios, $sala) or die(mysql_error());
    $row_promedios= mysql_fetch_assoc($promedios);
    $totalRows_promedios= mysql_num_rows($promedios);

    do {
        if ($_REQUEST['promedio'] == 1) {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            require('../../../funciones/notas/calculopromediosemestral.php');
            $notaspromedio[$codigoestudiante] = $promediosemestralperiodo;
        }
        else {
            $codigoestudiante = $row_promedios['codigoestudiante'];
            require('../../../funciones/notas/calculopromedioacumulado.php');            
            $notaspromedio[$codigoestudiante] = $promedioacumulado;
        }
    }while($row_promedios= mysql_fetch_assoc($promedios));
}
if($_REQUEST['accion']=='Exportar') {
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=archivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
<form name="forma" method="post">
<input type="submit" name="accion" value="Exportar">
<input type="hidden" name="modalidad" value="<?=$_REQUEST['modalidad']?>">
<input type="hidden" name="codigocarrera" value="<?=$_REQUEST['codigocarrera']?>">
<input type="hidden" name="anio" value="<?=$_REQUEST['anio']?>">
<input type="hidden" name="periodo" value="<?=$_REQUEST['periodo']?>">
<input type="hidden" name="busqueda_semestre" value="<?=$_REQUEST['busqueda_semestre']?>">
<input type="hidden" name="semestre" value="<?=$_REQUEST['semestre']?>">
<input type="hidden" name="promedio" value="<?=$_REQUEST['promedio']?>">
<p align="center" class="Estilo2">
    <span class="Estilo6">LISTADO PROMEDIO (<?php echo $_REQUEST["anio"]."-".$_REQUEST["periodo"]?>)</span>
    &nbsp;<?php if($_REQUEST['promedio']==1){echo"SEMESTRAL";}else{echo "ACUMULADO";}?> 
</p>
<table width="70%" border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6">
        <td colspan="8" class="Estilo1"><div align="center" class="Estilo5">
                <?php
                mysql_select_db($database_sala, $sala);
                $query_carrera = "select nombrecarrera from carrera where codigocarrera = '$carrera'";
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
        <td class="Estilo1"><div align="center" class="Estilo3">Nro. materias cursadas</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Nro. materias habilitadas</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Promedio Semestral</div></td>
        <td class="Estilo1"><div align="center" class="Estilo3">Promedio Acumulado </div></td>
    </tr>
    <?php
    arsort ($notaspromedio);
    $puesto = 1;
    if ($_REQUEST['promedio'] == 1) { // i f1
        foreach($notaspromedio as $key => $notica) {//
            $codigoestudiante = $key;            
            $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala,0,3);
            mysql_select_db($database_sala, $sala);            
	    $query_estudiante="	select e.codigoestudiante
					,eg.apellidosestudiantegeneral
					,eg.nombresestudiantegeneral
					,p.semestreprematricula
					,eg.numerodocumento
					,coalesce(sub.numeromateriascursadas,0) as nromatcursadas
					,coalesce(sub2.numeromateriashabilitadas,0) as nromathabilitadas
				from estudiante e 
				cross join (     
					select count(*) as numeromateriascursadas
					from notahistorico 
					where codigoperiodo='$periodosemestral' and codigoestadonotahistorico=100 and codigoestudiante = '$key'
				) as sub
				cross join (
					select count(*) as numeromateriashabilitadas
					from notahistorico
					where codigoperiodo='$periodosemestral' and codigoestadonotahistorico=100 and codigoestudiante = '$key' and codigotiponotahistorico like '2%'
				) as sub2
				,prematricula p 
				,estudiantegeneral eg 
				where p.codigoestudiante = e.codigoestudiante 
					and e.idestudiantegeneral = eg.idestudiantegeneral 
					and p.codigoestudiante = '$key'
					and p.codigoestadoprematricula like '4%'
					and p.codigoperiodo = '$periodosemestral'";            
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
				AND n.codigoestadonotahistorico LIKE '1%'";                
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
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['nromatcursadas'];?>&nbsp;</div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['nromathabilitadas'];?>&nbsp;</div></td>
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
	    $query_estudiante="	select e.codigoestudiante
					,eg.apellidosestudiantegeneral
					,eg.nombresestudiantegeneral
					,p.semestreprematricula
					,eg.numerodocumento
					,coalesce(sub.numeromateriascursadas,0) as nromatcursadas
					,coalesce(sub2.numeromateriashabilitadas,0) as nromathabilitadas
				from estudiante e 
				cross join (     
					select count(*) as numeromateriascursadas
					from notahistorico 
					where codigoperiodo='$periodosemestral' and codigoestadonotahistorico=100 and codigoestudiante = '$key'
				) as sub
				cross join (
					select count(*) as numeromateriashabilitadas
					from notahistorico
					where codigoperiodo='$periodosemestral' and codigoestadonotahistorico=100 and codigoestudiante = '$key' and codigotiponotahistorico like '2%'
				) as sub2
				,prematricula p 
				,estudiantegeneral eg 
				where p.codigoestudiante = e.codigoestudiante 
					and e.idestudiantegeneral = eg.idestudiantegeneral 
					and p.codigoestudiante = '$key'
					and p.codigoperiodo = '$periodosemestral'";            
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
				AND n.codigoestadonotahistorico LIKE '1%'";                
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
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['nromatcursadas'];?>&nbsp;</div></td>
        <td class="Estilo1"><div align="center" class="Estilo4"><?php echo $row_estudiante['nromathabilitadas'];?>&nbsp;</div></td>
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
</form>	
