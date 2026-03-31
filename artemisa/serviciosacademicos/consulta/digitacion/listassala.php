<?php
session_start();
require_once('../../Connections/sala2.php');
//$_SESSION['codigoperiodosesion'] = "20051";
$periodoactual = $_SESSION['codigoperiodosesion'];

if (!$_SESSION['codigodocente'] or !$_SESSION['codigoperiodosesion']) {
    header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
}

?>
<body oncontextmenu="return false">
    <script LANGUAGE="JavaScript1.1">
        function derecha(e) {
            if (navigator.appName == 'Netscape' && (e.which == 3 || e.which == 2)){
                alert('Botón derecho inhabilitado');
                return false;
            }
            else if (navigator.appName == 'Microsoft Internet Explorer' && (event.button == 2)){
                alert('Botón derecho inhabilitado');
            }
        }
        document.onmousedown=derecha;

        function cargarcorte() {
            var corte = document.getElementById('corte');
            var numerocorte = document.getElementById('numerocorte');
            var cuenta = corte.selectedIndex;
            cuenta++;
            //alert(cuenta);
            numerocorte.value = cuenta;
            //alert(numerocorte.value);
            return true;
        }
    </script>
<style type="text/css">
    <!--
    .style1 {
        font-family: Tahoma;
        font-size: small;
    }
    .style3 {
        font-size: x-small;
        font-weight: bold;
    }
    .style4 {font-size: x-small}
    .style5 {
        color: #FF0000;
        font-weight: bold;
    }
    body {
        margin-top: 0px;
    }
    .style51 {	font-family: Tahoma;
               font-size: x-small;
    }
    .Estilo26 {font-family: Tahoma}
    .Estilo29 {
        font-size: 12px;
        font-weight: bold;
    }
    .Estilo30 {font-family: Tahoma; font-size: 12px; }
    .Estilo31 {font-size: 12px}
    -->
</style>
<?php
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;
    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}
?>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<form name="form1" method="post" action="seleccionlista.php" onsubmit="return cargarcorte();">
<?php
    $corte=0;
    $peractivo=0;
    mysql_select_db($database_sala, $sala);
    $query_periodo = "SELECT * FROM periodo WHERE codigoestadoperiodo = '1'";
    $periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
    $row_periodo = mysql_fetch_assoc($periodo);
    $totalRows_periodo = mysql_num_rows($periodo);

    $colname_cursos = "1";
    if (isset($_SESSION['codigodocente'])) {
        $colname_cursos = (get_magic_quotes_gpc()) ? $_SESSION['codigodocente'] : addslashes($_SESSION['codigodocente']);
    }
    mysql_select_db($database_sala,$sala);
    $query_cursos = "SELECT  *
	FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
	WHERE g.numerodocumento = '".$colname_cursos."'
	and c.codigocarrera = m.codigocarrera 
	AND g.codigomateria = m.codigomateria
	AND m.codigoestadomateria = '01'
	and g.codigoperiodo = cp.codigoperiodo
	and g.codigoestadogrupo like '1%'
	and p.codigoperiodo = cp.codigoperiodo
	and p.codigoestadoperiodo = '3'
	and cp.codigoestado like '1%'
	and cp.codigocarrera = c.codigocarrera";
    //AND g.codigomaterianovasoft = m.codigomaterianovasoft
    //echo $query_cursos;
    $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
    $row_cursos = mysql_fetch_assoc($cursos);
    $totalRows_cursos = mysql_num_rows($cursos);

    if (! $row_cursos) {
        $query_cursos = "SELECT  *
    FROM grupo g,materia m,carrera c,notaarea n, carreraperiodo cp, periodo p
	WHERE n.numerodocumento = '".$colname_cursos."'
	and c.codigocarrera = m.codigocarrera 
	and g.idgrupo = n.idgrupo 
	AND g.codigomateria = m.codigomateria
	AND m.codigoestadomateria = '01'
	and g.codigoperiodo = cp.codigoperiodo
	and g.codigoestadogrupo like '1%'
	and p.codigoperiodo = cp.codigoperiodo
	and p.codigoestadoperiodo = '3'
	and cp.codigoestado like '1%'
	and cp.codigocarrera = c.codigocarrera";
        //AND g.codigomaterianovasoft = m.codigomaterianovasoft
        //echo $query_cursos;
        $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
        $row_cursos = mysql_fetch_assoc($cursos);
        $totalRows_cursos = mysql_num_rows($cursos);
    }

    if(!$row_cursos) {

        $query_cursos = "SELECT  *
	FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
	WHERE g.numerodocumento = '".$colname_cursos."'
	and c.codigocarrera = m.codigocarrera 
	AND g.codigomateria = m.codigomateria
	AND m.codigoestadomateria = '01'
    and g.codigoperiodo = cp.codigoperiodo
	and g.codigoestadogrupo like '1%'
	and p.codigoperiodo = cp.codigoperiodo
	and p.codigoestadoperiodo = '1'
	and cp.codigoestado like '1%'
	and cp.codigocarrera = c.codigocarrera";
        //AND g.codigomaterianovasoft = m.codigomaterianovasoft
        //echo $query_cursos;
        $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
        $row_cursos = mysql_fetch_assoc($cursos);
        $totalRows_cursos = mysql_num_rows($cursos);

    }

    if (! $row_cursos) {

        $query_cursos = "SELECT  *
  	 FROM grupo g,materia m,carrera c,notaarea n, carreraperiodo cp, periodo p
 	 WHERE n.numerodocumento = '".$colname_cursos."'
  	 and c.codigocarrera = m.codigocarrera 
 	 and g.idgrupo = n.idgrupo 
  	 AND g.codigomateria = m.codigomateria
	 AND m.codigoestadomateria = '01'
	 and g.codigoperiodo = cp.codigoperiodo
	 and g.codigoestadogrupo like '1%'
	 and p.codigoperiodo = cp.codigoperiodo
 	 and p.codigoestadoperiodo = '1'
 	 and cp.codigoestado like '1%'
 	 and cp.codigocarrera = c.codigocarrera";
        //AND g.codigomaterianovasoft = m.codigomaterianovasoft
        //echo $query_cursos;
        $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
        $row_cursos = mysql_fetch_assoc($cursos);
        $totalRows_cursos = mysql_num_rows($cursos);

    }

    $colname_docente = "1";
    if (isset($_SESSION['codigodocente'])) {
        $colname_docente = (get_magic_quotes_gpc()) ? $_SESSION['codigodocente'] : addslashes($_SESSION['codigodocente']);
    }

    mysql_select_db($database_sala, $sala);
    $query_docente = "SELECT * FROM docente
   WHERE numerodocumento = '".$colname_docente."'";
    $docente = mysql_query($query_docente, $sala) or die(mysql_error());
    $row_docente = mysql_fetch_assoc($docente);
    $totalRows_docente = mysql_num_rows($docente);

    ?>

    <table width="600" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
            <td colspan="3" id="tdtitulogris">CONSULTA LISTADO DE GRUPOS</td>
            <td id="tdtitulogris">Fecha</td>
            <td align="center" class="Estilo30"><?php echo date("j/m/Y G:i:s",time());?></span></td>
        </tr>
        <tr>
            <td colspan="5" class="Estilo26"><div align="center"><span class="Estilo29">Docente:&nbsp;&nbsp;</span><span class="Estilo31"><?php echo $row_docente['apellidodocente']."  ".$row_docente['nombredocente'];?></span></div></td>
        </tr>
        <tr align="center">
            <td width="10%" id="tdtitulogris">C&oacute;digo</td>
            <td id="tdtitulogris">Grupo</td>
            <td id="tdtitulogris">Materia</td>
            <td id="tdtitulogris">Facultad</td>
        </tr>
<?php 
do {
    ?>
        <tr>
            <td class="Estilo26"><div align="center"><span class="style4"><?php echo "<a href='listassala.php?materia=".$row_cursos['codigomateria']."&grupo=".$row_cursos['idgrupo']."&nombreperiodo=".$row_periodo['codigoperiodo']."&facultad=".$row_cursos['codigocarrera']."'>".$row_cursos['codigomateria']."</a>"; ?></span></div></td>
            <td class="Estilo26"><div align="center"><span class="style4"><?php echo $row_cursos['idgrupo']; ?></span></div></td>
        <br>
        <td class="Estilo26"><div align="center"><span class="style4"><?php echo $row_cursos['nombremateria']; ?> </span></div></td>
        <td colspan="2" class="Estilo26"><div align="center"><span class="style4"><?php echo $row_cursos['nombrecarrera'];?></span></div></td>
        </tr>
    <?php
} while ($row_cursos = mysql_fetch_assoc($cursos)); 
?>

    </table>

    <span class="Estilo26">
<?php  
if (isset($_GET['materia'])) {
    $materiadocente = $_GET['materia'];
} 

        if (isset($_GET['grupo'])) {
            $grupodocente = $_GET['grupo'];
        }
        else
        if (isset($_POST['grupo'])) {
            $grupodocente = $_POST['grupo'];
        }

        if (isset($materiadocente)) {
            mysql_select_db($database_sala, $sala);
            $query_nombremateria = "SELECT materia.nombremateria,materia.codigocarrera
  FROM materia,grupo 
  WHERE grupo.codigomateria = '".$materiadocente."'
  AND grupo.idgrupo = '".$grupodocente."'
  AND grupo.codigomateria = materia.codigomateria 
  AND materia.codigoestadomateria = '01'													
  and grupo.codigoperiodo = '".$periodoactual."'";
            $nombremateria = mysql_query($query_nombremateria, $sala) or die(mysql_error());
            $row_nombremateria = mysql_fetch_assoc($nombremateria);
            $totalRows_nombremateria = mysql_num_rows($nombremateria);

            mysql_select_db($database_sala, $sala);

            $query_fecha ="SELECT  distinct idcorte
	FROM corte c,grupo g
	WHERE c.codigomateria = '".$materiadocente."'
	AND c.codigoperiodo = '".$periodoactual."'
	AND g.numerodocumento = '".$colname_cursos."'
	AND c.codigomateria = g.codigomateria
	AND c.codigoperiodo =g.codigoperiodo";
            //AND c.codigomaterianovasoft = g.codigomaterianovasoft
            //echo $query_fecha;
            $fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
            $row_fecha = mysql_fetch_assoc($fecha);
            $totalRows_fecha = mysql_num_rows($fecha);

            $i= 1;
            $contadorcortes = 0;

            if ($totalRows_fecha <> 0) {
                do {
                    $cortes[$i]=$row_fecha['idcorte'];
                    $i+=1;
                    $contadorcortes +=1;
                } while ($row_fecha = mysql_fetch_assoc($fecha));
            }
            else {
                mysql_select_db($database_sala, $sala);
                $query_fecha ="SELECT  distinct idcorte
	FROM corte c,grupo g,notaarea n
	WHERE c.codigomateria = '".$materiadocente."'
	AND c.codigoperiodo = '".$periodoactual."'
	AND n.numerodocumento = '".$colname_cursos."'
	AND c.codigomateria = g.codigomateria							
	AND c.codigoperiodo =g.codigoperiodo";
                //AND c.codigomaterianovasoft = g.codigomaterianovasoft
                $fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
                $row_fecha = mysql_fetch_assoc($fecha);
                $totalRows_fecha = mysql_num_rows($fecha);

                $i= 1;
                $contadorcortes = 0;

                if ($totalRows_fecha <> 0) {
                    do {
                        $cortes[$i]=$row_fecha['idcorte'];
                        $i+=1;
                        $contadorcortes +=1;
                    } while ($row_fecha = mysql_fetch_assoc($fecha));
                }
                else
                if ($totalRows_fecha==0) {
                    mysql_select_db($database_sala, $sala);
                    $query_fecha = "SELECT distinct idcorte
    FROM corte 
	WHERE codigocarrera = '".$row_nombremateria['codigocarrera']."'
	and codigoperiodo = '$periodoactual'
    order by numerocorte";
                    //echo $query_fecha;
                    $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                    $row_fecha = mysql_fetch_assoc($fecha);
                    $totalRows_fecha = mysql_num_rows($fecha);

                    do {
                        $cortes[$i]=$row_fecha['idcorte'];
                        $i+=1;
                        $contadorcortes +=1;
                    } while ($row_fecha = mysql_fetch_assoc($fecha));
                }
            }
            ?>
    </span>
    <table width="600"  border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
            <td colspan="4" id="tdtitulogris">Materia:&nbsp;&nbsp;&nbsp; <?php echo $row_nombremateria['nombremateria']; ?> </td>
        </tr>
        <tr>
            <td id="tdtitulogris"><div align="center" >Tipo de listado </div></td>
            <td class="Estilo26"><select name="listado" id="listado">
                    <option value="0">Seleccione el listado</option>
                    <option value="1">Consulta de Notas</option>
                    <option value="2">Planilla de Calificaciones</option>
                    <option value="3">Planilla de Asistencia</option>
                </select></td>
            <td id="tdtitulogris"><div align="center">Corte</div></td>
            <td class="Estilo26"><span class="style3"><span class="style51">
                        <select name="corte" id="corte" onchange="this.selectedIndex">
    <?php
    for($i=1; $i <= $contadorcortes ; $i++) {
        //echo $cortes[$i];
        echo "<option value='$cortes[$i]'>$i</option>";
    }
    ?>
                        </select>
                    </span></span></td>
        </tr>
        <tr>
            <td colspan="4" class="Estilo26"><div align="center">
                    <input name="Consultar" type="submit" id="Consultar" value="Consultar">
                </div></td>
        </tr>
    </table>
    <p class="Estilo26">&nbsp;</p>
    <p>&nbsp;</p>
    <p><br>
                                <?php
}	
?>
        <input name="materia" type="hidden" id="materia" value="<?php echo $_GET['materia']; ?>">
        <input name="grupo" type="hidden" id="grupo" value="<?php echo $_GET['grupo']; ?>">
        <input name="nombremateria" type="hidden" id="nombremateria" value="<?php echo $row_nombremateria['nombremateria']; ?>">
        <input name="semestre" type="hidden" id="semestre" value="<?php echo $row_nombremateria['semestre']; ?>">
        <input name="nombre" type="hidden" id="nombre" value="<?php echo $row_docente['apellidodocente']."  ".$row_docente['nombredocente'];?>">
        <input name="numerocorte" type="hidden" id="numerocorte" value="">
</form>