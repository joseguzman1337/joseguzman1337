<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../Connections/sala2.php'); 
require_once('../../../funciones/validacion.php');
?>
<?php
mysql_select_db($database_sala, $sala);
$query_selempresasalud = "SELECT idempresasalud, nombreempresasalud FROM empresasalud ORDER BY nombreempresasalud ASC";
$selempresasalud = mysql_query($query_selempresasalud, $sala) or die(mysql_error());
$row_selempresasalud = mysql_fetch_assoc($selempresasalud);
$totalRows_selempresasalud = mysql_num_rows($selempresasalud);
?>
<?php require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
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
<?php 
if ($_GET['idestudiantegeneral']){ 
$query_selperiodoactivo = "SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p
WHERE p.codigoperiodo = c.codigoperiodo
AND c.codigocarrera = '".$_SESSION['codigofacultad']."' 
AND p.codigoestadoperiodo = '1'";
$selperiodoactivo=mysql_query($query_selperiodoactivo,$sala);
$periodoactivo=mysql_fetch_assoc($selperiodoactivo);
$query_seleccionar_estudiantearp="select * from estudiantearp ep
where ep.idestudiantegeneral='".$_GET['idestudiantegeneral']."'
and ep.fechainicioestudiantearp='".$periodoactivo['fechainicioperiodo']."'
and ep.fechafinalestudiantearp='".$periodoactivo['fechavencimientoperiodo']."'
";
$seleccionar_estudiantearp=mysql_query($query_seleccionar_estudiantearp,$sala);
$cant_estudiantearp=mysql_num_rows($seleccionar_estudiantearp);
$query_datosestudiante= "SELECT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento FROM estudiantegeneral eg
WHERE  eg.idestudiantegeneral = '".$_GET['idestudiantegeneral']."'";
$datosestudiante=mysql_query($query_datosestudiante,$sala);
$datosest=mysql_fetch_assoc($datosestudiante);
if ($cant_estudiantearp==1)
{
	$estudiantearp=mysql_fetch_assoc($seleccionar_estudiantearp);
	
	}

?>
<table width="52%" border="1" align="center" cellpadding="3" bordercolor="#003333">
  <tr>
    <td width="24%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Estudiante:</div></td>
    <td width="76%" bgcolor='#FEF7ED'><p class="style2"><?php echo $datosest['nombre'];?>
        
    </p></td>
  </tr>
  <tr>
    <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Empresa de Salud: </div></td>
    <td bgcolor='#FEF7ED'>
	
      <select name="idempresasalud" id="idempresasalud">
	  <option value="" selected>Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_selempresasalud['idempresasalud']?>"<?php if($cant_estudiantearp == 1 and $row_selempresasalud['idempresasalud']==$estudiantearp['idempresasalud']){echo "selected";}?>><?php echo $row_selempresasalud['nombreempresasalud']?></option>
        <?php
} while ($row_selempresasalud = mysql_fetch_assoc($selempresasalud));
  $rows = mysql_num_rows($selempresasalud);
  if($rows > 0) {
      mysql_data_seek($selempresasalud, 0);
	  $row_selempresasalud = mysql_fetch_assoc($selempresasalud);
  }
?>
      </select>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Observaci&oacute;n:</div></td>
    <td bgcolor='#FEF7ED'>
      <input name="observacionarp" type="text" id="observacionarp" value="<?php if($cant_estudiantearp == 1){echo $estudiantearp['observacionarp'];}?>">
    
    </td>
  </tr>
</table>

<?php } 
if($cant_estudiantearp == 1){
echo '
<div align="center">
<input type="submit" name="Anular" value="Anular">
<input type="submit" name="Regresar" value="Regresar">
</div>
';
}
if($cant_estudiantearp == 0){echo '
<div align="center">
<input type="submit" name="Guardar" value="Guardar">
<input type="submit" name="Regresar" value="Regresar">
</div>
';
}

if($cant_estudiantearp == 0 and $_POST['Guardar']){
$validacionempresasalud=validar($_POST['idempresasalud'],"requerido",'<script language="JavaScript">alert("No ha seleccionado la Empresa de Salud")</script>', true);
if($validacionempresasalud==true){
	$query_insertar_estudiantearp="insert into estudiantearp(idestudiantegeneral,idempresasalud,fechainicioestudiantearp,fechafinalestudiantearp,observacionarp) 
	values ('".$datosest['idestudiantegeneral']."','".$_POST['idempresasalud']."','".$periodoactivo['fechainicioperiodo']."','".$periodoactivo['fechavencimientoperiodo']."','".$_POST['observacionarp']."')";
	$insertar_estudiantearp=mysql_query($query_insertar_estudiantearp);
		if($insertar_estudiantearp){
		echo '<script language="javascript">window.location.reload("estudiantearpmenu.php?idestudiantegeneral='.$_GET['idestudiantegeneral'].'")</script>';
		}
		else{
		echo mysql_error();
		}
	}
}
if($cant_estudiantearp == 1 and $_POST['Anular']){
$validacionempresasalud=validar($_POST['idempresasalud'],"requerido",'<script language="JavaScript">alert("No ha seleccionado la Empresa de Salud")</script>', true);
if($validacionempresasalud==true){
	$query_anular_estudiantearp="update estudiantearp set fechainicioestudiantearp='0000-00-00',fechafinalestudiantearp='0000-00-00' 
	where idestudiantegeneral='".$_GET['idestudiantegeneral']."' and fechainicioestudiantearp='".$estudiantearp['fechainicioestudiantearp']."' and fechafinalestudiantearp='".$estudiantearp['fechafinalestudiantearp']."'"; 
	$anular_estudiantearp=mysql_query($query_anular_estudiantearp);
	if($anular_estudiantearp){
		echo '<script language="javascript">window.location.reload("estudiantearpmenu.php?idestudiantegeneral='.$_GET['idestudiantegeneral'].'")</script>';
	}
	else{
	echo mysql_error();
	}
	
	}
}
if($_POST['Regresar']){
echo '<script language="javascript">window.location.reload("../../prematricula/matriculaautomaticabusquedaestudiante.php?aplicaarp")</script>';
}
mysql_free_result($selempresasalud);
?>
</form>