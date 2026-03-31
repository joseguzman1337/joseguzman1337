<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$sala1 = $sala;
$database_sala1 = $database_sala;
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');

$link = "../../../../imagenes/estudiantes/";
require_once('../../../funciones/datosestudiante.php');

session_start();
$codigoestudiante = $_REQUEST['codigoestudiante'];
//print_r($_SESSION);
//$db->debug = true;
$query_prematriculaviva = "select distinct e.codigoestudiante
from prematricula p, estudiante e, detalleprematricula d, periodo pe
where p.codigoestudiante = e.codigoestudiante
and p.idprematricula = d.idprematricula
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
and pe.codigoperiodo = p.codigoperiodo
and (pe.codigoestadoperiodo = '3' or pe.codigoestadoperiodo = '4')
and e.codigoestudiante = '$codigoestudiante'";
//echo $query_prematriculaviva;
$prematriculaviva = $db->Execute($query_prematriculaviva);
$totalRows_prematriculaviva = $prematriculaviva->RecordCount();
$row_prematriculaviva = $prematriculaviva->FetchRow();

if($totalRows_prematriculaviva == "")
{
    $query_prematriculaviva = "select distinct e.codigoestudiante
    from prematricula p, estudiante e, detalleprematricula d, periodo pe
    where p.codigoestudiante = e.codigoestudiante
    and p.idprematricula = d.idprematricula
    and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
    and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
    and pe.codigoperiodo = p.codigoperiodo
    and pe.codigoestadoperiodo = '1'
    and e.codigoestudiante = '$codigoestudiante'";
    $prematriculaviva = $db->Execute($query_prematriculaviva);
    $totalRows_prematriculaviva = $prematriculaviva->RecordCount();
    $row_prematriculaviva = $prematriculaviva->FetchRow();
}
//echo $query_prematriculaviva;
//print_r($row_planestudios);
if($totalRows_prematriculaviva > 0)
{
?>
<script language="JavaScript">
    alert('Debido a que el estudiante tiene prematricula activa no se le permite cambiar de carrera');
    history.go(-1);
</script>
<?php
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Migración de notas de estudiantes a otra facultad</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-85">
  <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<h1>MIGRAR ESTUDIANTE A OTRA FACULTAD</h1>
<?php
datosestudiante($codigoestudiante,$sala1,$database_sala1,$link);
if(!isset($_REQUEST['migrar'])) :
    //$db->debug = true;
    // Mira las carreras en las que se encuentra el estudiante
    $sql = "SELECT u.codigofacultad,c.nombrecarrera,c.codigocarrera
    FROM usuariofacultad u,carrera c, usuario us
    WHERE us.usuario=u.usuario
    and us.usuario = '".$_SESSION['MM_Username']."'
    and u.codigofacultad = c.codigocarrera
    and c.codigocarrera <> '".$_SESSION['codigofacultad']."'
    order by c.nombrecarrera";
    $rta = $db->Execute($sql);
    $totalRows_rta = $rta->RecordCount();
    if($totalRows_rta > 0):
?>
<h3>Seleccione la facultad a la que desea migrar el estudiante del siguiente listado</h3>
<table width="50%">
    <tr id="trtitulogris">
        <td>Código Facultad</td>
        <td>Nombre Facultad</td>
    </tr>
    <tr>
<?php
    while($row_rta = $rta->FetchRow()) :
?>
        <td><a href="javascript: if(confirm('¿Está seguro de migrar este estudiante a otra carrera?')){ window.location.href='migrarestudiante.php?codigoestudiante=<?php echo $codigoestudiante; ?>&migrar=<?php echo $row_rta['codigocarrera']; ?>';}"><?php echo $row_rta['codigocarrera']; ?></a></td>
        <td><?php echo $row_rta['nombrecarrera']; ?></td>
<?php
    endwhile;
?>
    </tr>
</table>
<?php

    else:
?>
<h3>Este estudiante no puede ser migrado con el usuario con el que se encuentra</h3>
<?php
    endif;
    elseif(isset($_REQUEST['migrar'])):
    require_once('../../../funciones/sala/auditoria/auditoria.php');
    $auditoria = new auditoria();
    //$db->debug=true;

    // 1. Modificar la carrera en el estudiante
    $sql1 = "update estudiante e
    set e.codigocarrera = '".$_REQUEST['migrar']."'
    where e.codigoestudiante = '$codigoestudiante'";
    $rta = $db->Execute($sql1);

    // 2. Dejar el estudiante sin plan de estudios
    /*$sql2 = "delete from planestudioestudiante p
    where p.codigoestudiante = '$codigoestudiante'";
    $rta = $db->Execute($sql2);
    */
    $sql2 = "update planestudioestudiante
    set codigoestadoplanestudioestudiante = 200, fechavencimientoplanestudioestudiante = now()
    where codigoestudiante = '$codigoestudiante'
    and codigoestadoplanestudioestudiante like '1%'";
    $rta = $db->Execute($sql2);

    $idestudiantegeneral = obtenerIdestudiantegeneral($codigoestudiante,$sala,$database_sala);

    // Si tiene inscripcion cambiarle la carrera de inscripción y aliminarlo del proceso de admisión
    $sql = "SELECT max(e.idestudiantecarrerainscripcion) as idestudiantecarrerainscripcion
    FROM estudiantecarrerainscripcion e
    WHERE e.idestudiantecarrerainscripcion
    and e.idestudiantegeneral = '$idestudiantegeneral'
    and e.codigocarrera = '".$_SESSION['codigofacultad']."'";
    $rta = $db->Execute($sql);
    $totalRows_rta = $rta->RecordCount();
    if($totalRows_rta > 0)
    {
        $row_rta = $rta->FetchRow();
        $sql2 = "update estudiantecarrerainscripcion
        set codigocarrera = '".$_REQUEST['migrar']."'
        where idestudiantegeneral = '$idestudiantegeneral'
        and codigocarrera = '".$_SESSION['codigofacultad']."'
        and idestudiantecarrerainscripcion = '".$row_rta['idestudiantecarrerainscripcion']."'";
        $rta = $db->Execute($sql2);

        $sql2 = "update estudianteadmision e, admision a, subperiodo s, carreraperiodo cp, periodo p
        set e.codigoestadoestudianteadmision = 200
        where e.idadmision = a.idadmision
        and a.codigocarrera = '".$_SESSION['codigofacultad']."'
        and a.idsubperiodo = s.idsubperiodo
        and cp.idcarreraperiodo = s.idcarreraperiodo
        and cp.codigocarrera = a.codigocarrera
        and e.codigoestudiante = '$codigoestudiante'
        and p.codigoperiodo = cp.codigoperiodo
        and p.codigoestadoperiodo = '4'";
        $rta = $db->Execute($sql2);
    }

    // 3. Guardar en el log
    $sqlIns = "INSERT INTO logmigrarestudiante (idlogmigrarestudiante, codigoestudiante, fechalogmigrarestudiante, carreraorigenlogmigrarestudiante, carreradestinologmigrarestudiante, idusuario, ip)
    VALUES (0, '$codigoestudiante', now(), '".$_SESSION['codigofacultad']."', '".$_REQUEST['migrar']."', '$auditoria->idusuario', '$auditoria->ip')";
    $db->Execute($sqlIns);
?>
<br><br>
<h1>EL ESTUDIANTE HA SIDO MIGRADO SATISFACTORIAMENTE</h1>
<h2>Para terminar debe asignar el estudiante a un plan de estudios</h2>
<?php
datosestudiante($codigoestudiante,$sala1,$database_sala1,$link);
?>
<br><br>
<input type="button" name="Regresar" value="regresar" onclick="window.location.href='../../prematricula/matriculaautomaticabusquedaestudiante.php'">
<?php
endif;
?>
</body>
</html>
