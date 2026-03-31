<?php
require('../../../Connections/sala2.php');
$sala2 = $sala;

$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

include ("calendario/calendario.php");
@session_start();

$_SESSION['modulosesion'] = "informacionestudios";


$query_estudiante = "select idestudiantegeneral from estudiante where codigoestudiante = '".$_REQUEST['codigoestudiante']."';";
$datosestudiante = $db->Execute($query_estudiante);
$totalRows_datosgrabados = $datosestudiante->RecordCount();
$datosestudiante = $datosestudiante->FetchRow();

$query_datosgrabados = "SELECT *
FROM detalleresultadopruebaestado d,resultadopruebaestado r
WHERE r.idestudiantegeneral = '".$datosestudiante['idestudiantegeneral']."'
and r.idresultadopruebaestado = d.idresultadopruebaestado
and d.codigoestado like '1%' ";
$datosgrabados = $db->Execute($query_datosgrabados);
$arraydatos;
do {
$arraydatos[] = $row_grabados;
$row_datosgrabados = $row_grabados;
}while($row_grabados = $datosgrabados->FetchRow());


$totalRows_datosgrabados = $datosgrabados->RecordCount();
//$row_datosgrabados = $datosgrabados->FetchRow();

if ($row_datosgrabados <> "")
{
	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresoicfes_old_est.php?inicial&codigoestudiante=".$_GET['codigoestudiante']."'>";
	//exit();
}
?>
<html>
<head>
<title>.:INGRESO ICFES:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script></head>
<body>
<form name="inscripcion" method="post" action="ingresoicfes_old_est.php">
<?php

//$db->debug =true;
$query_data = "select eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica
from estudiantegeneral eg inner join estudiante b on eg.idestudiantegeneral = b.idestudiantegeneral
inner join carrera c on b.codigocarrera = c.codigocarrera
inner join modalidadacademica m on c.codigomodalidadacademica = m.codigomodalidadacademica
inner join ciudad ci on eg.idciudadnacimiento = ci.idciudad
where eg.idestudiantegeneral = '".$datosestudiante['idestudiantegeneral']."'; ";
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
if(isset($_POST['inicial']) or isset($_GET['inicial']))
{
?>
	<p>FORMULARIO DEL ASPIRANTE</p>
<table width="50%" border="0" cellpadding="0" cellspacing="0">
 <tr>
 <td>
    <table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
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
if(isset($_POST['inicial']) or isset($_GET['inicial']))
{ // vista previa
     if (isset($_GET['inicial']))
	   {
	      $moduloinicial = $_GET['inicial'];
	      echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';
	   }
	  else
	   {
	      $moduloinicial = $_POST['inicial'];
	      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
	   }
	?>
	<BR>
	<table width="70%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr>
        <td colspan="6" id="tdtitulogris">RESULTADO PRUEBA DE ESTADO</td>
      </tr>
	  <tr>
        <td colspan="6" id="tdtitulogris"><label id="labelresaltado">ATENCION! Para los resultados icfes que tengan Ciencias Sociales, por favor diligenciar ese puntaje en Historia y Geografia.
            <br>
            Para la informaci&oacute;n que no aplique por favor Ingresar el valor 0
            </label></td>
      </tr>
      <tr>
        <!--<td width="24%" id="tdtitulogris">Nombre Resultado</td>
        <td colspan="3"><input type="text" name="nombre" value="<?php echo $_POST['nombre']; ?>"></td>-->
        <td id="tdtitulogris">No. Registro<span class="Estilo4">*</span></td>
        <td><input type="text" name="registro" value="<?php echo $row_datosgrabados['numeroregistroresultadopruebaestado']; ?>"></td>
        <td colspan="2">&nbsp;</td>
      </tr>
	 <tr>
        <td id="tdtitulogris">Puesto</td>
        <td width="15%" colspan="1"><input type="text" name="puesto" size="3" value="<?php echo $row_datosgrabados['puestoresultadopruebaestado']; ?>" maxlength="3"></td>
        <td id="tdtitulogris">Fecha</td>
        <td><input name="fecha1" type="text" id="fecha1"  size="8" value="<?php echo substr($row_datosgrabados['fecharesultadopruebaestado'],0,10)?>"><button id="btfechavencimiento">...</button></td>
        <!--<td id="tdtitulogris">Descripci&oacute;n</td>
		<td><input type="text" name="descripcion" value="<?php echo $_POST['descripcion']; ?>"></td>-->
      </tr>
      <tr>
        <td colspan="2" id="tdtitulogris" align="center">ASIGNATURA</td>
        <td colspan="1" id="tdtitulogris" align="center">PUNTAJE (00.00)</td>
        <td colspan="1" id="tdtitulogris" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      <?php
      $cuentaidioma = 1;
	 if ($row_asignatura <> "")
	  {
	   do{
?>
      <tr>
        <td colspan="2"><?php echo $row_asignatura['nombreasignaturaestado'] ;?> <input type="hidden" name="asignatura<?php echo $cuentaidioma;?>" value="<?php echo $row_asignatura['idasignaturaestado'] ; ?>"> </td>
        <td colspan="1"align="center"><input type="text" name="puntaje<?php echo $cuentaidioma;?>" size="3" maxlength="5" value="<?php echo  $arraydatos[$cuentaidioma]['notadetalleresultadopruebaestado']; ?>"></td>
        <td colspan="1"align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <?php
       $cuentaidioma ++;
      }while($row_asignatura = $asignatura->FetchRow());
   }
?>
      </tr>
	  <tr>
	   <td colspan="6"><a href="http://www.icfesinteractivo.gov.co/resultados/res_est/sniee_log_per.jsp"  target="_blank" id="aparencialinknaranja">CONSULTAR PUNTAJE ICFES</a></td>
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
   window.location.reload("vistaformularioinscripcion.php");
}
</script>
<br><br>
  <!--  <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>
   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>
    -->
 	<input type="button" value="Enviar" onClick="grabar()">
<!--	<input type="button" value="Vista Previa" onClick="vista()">  -->
	<input type="hidden" name="grabado" value="grabado">
<?php
   if (isset($_GET['codigoestudiante'])) {
?>
      <input type="hidden" name="codigoestudiante" value="<?php echo $_GET['codigoestudiante'];?>">
<?
    }else {
      echo '<input type="hidden" name="codigoestudiante" value="'.$_POST['codigoestudiante'].'"/>';
 }
?>
      
<input type="button" onClick="window.location.href='../../prematricula/matriculaautomaticabusquedaestudiante.php?codigocreado=<? echo $row_data['numerodocumento']; ?>'" name="Regresar" value="Regresar">
<!-- <a onClick="history.go(-1)" style="cursor: pointer"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Regresar"></a>  <input type="hidden" name="grabado" value="grabado">
 --><?php
$banderagrabar = 0;

if (isset($_POST['grabado'])) {    
	 if ((!ereg("^([a-zA-Zï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½]+([A-Za-zï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½]*|( [A-Za-zï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½]+)*))*$",$_POST['nombre']) and $_POST['nombre'] <> ""))	  {
	    echo '<script language="JavaScript">alert("El Nombre de la Prueba es Incorrecto");</script>';
		$banderagrabar = 1;
	  } else  if ($_POST['registro'] == "") {
	     echo '<script language="JavaScript">alert("Debe digitar el No. de registro");</script>';
		$banderagrabar = 1;
	  } else  if (!eregi("^[0-9]{1,15}$", $_POST['puesto']) and $_POST['puesto'] <> "") {
	     echo '<script language="JavaScript">alert("Puesto Incorrecto"); </script>';
		$banderagrabar = 1;
	  }
	  for ($i=1; $i<$cuentaidioma;$i++) {
	     if (!eregi("^[0-9]{1,2}\.[0-9]{1,2}$", $_POST['puntaje'.$i]) or $_POST['puntaje'.$i]> 100) $banderagrabar = 1;		  
	  }
	 if ($banderagrabar == 1)  {
		  echo '<script language="JavaScript">alert("Debe digitar todos los puntajes, los cuales deben estar dados en rangos de 0 - 100 con dos decimales (00.00)");</script>';
	      $banderagrabar = 1;
	   } else if ($banderagrabar == 0){               
                 if($row_datosgrabados['idresultadopruebaestado']){
                    $query_resultado = "update resultadopruebaestado set
                    nombreresultadopruebaestado = '".$_POST['nombre']."',idestudiantegeneral = '".$datosestudiante['idestudiantegeneral']."',
                    numeroregistroresultadopruebaestado = '".$_POST['registro']."',
                    puestoresultadopruebaestado = '".$_POST['puesto']."',
                    fecharesultadopruebaestado = '".$_POST['fecha1']."',
                    observacionresultadopruebaestado ='".$_POST['descripcion']."',
                    codigoestado = '100' where idresultadopruebaestado = ".$row_datosgrabados['idresultadopruebaestado'].";";                    
                    $resultado = $db->Execute($query_resultado);
                    for ($i=1; $i<$cuentaidioma;$i++){
                        if ($_POST['puntaje'.$i] <> "") {
                            $query_puntajeresultado = "update detalleresultadopruebaestado 
                            set notadetalleresultadopruebaestado = '".$_POST['puntaje'.$i]."' where idresultadopruebaestado = '".$row_datosgrabados['idresultadopruebaestado']."' and idasignaturaestado = '".$_POST['asignatura'.$i]."'
                            and codigoestado = 100 ;";
                            $puntajeresultado = $db->Execute($query_puntajeresultado);
                        }
                    }
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresoicfes_old_est.php?inicial&codigoestudiante=".$_POST['codigoestudiante']."'>";
                 }else{                                          
                    $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,codigoestado)
                    VALUES(0,'".$_POST['nombre']."','".$datosestudiante['idestudiantegeneral']."','".$_POST['registro']."','".$_POST['puesto']."','".$_POST['fecha1']."','".$_POST['descripcion']."','100' )";
                    $resultado = $db->Execute($query_resultado);
                    $idrespuesta = $db->Insert_ID();
                    for ($i=1; $i<$cuentaidioma;$i++){
                        if ($_POST['puntaje'.$i] <> "") {
                            $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,codigoestado)
                            VALUES(0,'$idrespuesta','".$_POST['asignatura'.$i]."','".$_POST['puntaje'.$i]."','100' )";
                            $puntajeresultado = $db->Execute($query_puntajeresultado);
                        }
                    }
                     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresoicfes_old_est.php?inicial&codigoestudiante=".$_POST['codigoestudiante']."'>";
                 }
          }
 }
} // vista previa

?>

<script language="javascript">
function recargar(dir)
{
	window.location.reload("idiomas.php"+dir);
	history.go();
}
</script>
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