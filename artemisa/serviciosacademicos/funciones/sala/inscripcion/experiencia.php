<?php
$codigoinscripcion = $_SESSION['numerodocumentosesion'];

$query_actividad = "select *
from tipoestudiantelaboral
order by 2";
$actividad = $db->Execute($query_actividad);
$totalRows_actividad = $actividad->RecordCount();
$row_actividad = $actividad->FetchRow();

$query_ciudad1 = "select *
from pais
order by 3";
$ciudad1 = $db->Execute($query_ciudad1);
$totalRows_ciudad1 = $ciudad1->RecordCount();
$row_ciudad1 = $ciudad1->FetchRow();

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
WHERE numerodocumento = '$codigoinscripcion'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica
AND e.idnumeroopcion = '1'
and i.codigoestado like '1%'
and i.idinscripcion = '".$this->idinscripcion."'";
$data = $db->Execute($query_data);
$totalRows_data = $data->RecordCount();
$row_data = $data->FetchRow();

// vista previa
$query_datosgrabados = "SELECT *
FROM estudiantelaboral e,tipoestudiantelaboral t
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idtipoestudiantelaboral = t.idtipoestudiantelaboral
and e.codigoestado like '1%'
order by e.idtipoestudiantelaboral";
//echo $query_datosgrabados;
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();

if ($row_datosgrabados <> "")
{
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr id="trtitulogris">
    <td>Actividad</td>
    <td>Institución</td>
    <td>Cargo</td>
    <td>Descripción</td>
    <td>Editar</td>
  </tr>
<?php
    do
    {
?>
  <tr>
    <td><?php echo $row_datosgrabados['nombretipoestudiantelaboral'];?>&nbsp;</td>
    <td><?php echo $row_datosgrabados['empresaestudiantelaboral'];?>&nbsp;</td>
    <td><?php echo $row_datosgrabados['cargoestudiantelaboral'];?>&nbsp;</td>
    <td><?php echo $row_datosgrabados['descripcionestudiantelaboral'];?>&nbsp;</td>
    <td><a onClick="window.location.href='editarexperiencia_new.php?id=<?php echo $row_datosgrabados['idestudiantelaboral'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
    <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?experiencia&id=<?php echo $row_datosgrabados['idestudiantelaboral'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar">
    </td>
  </tr>
<?php
    }
    while($row_datosgrabados = $datosgrabados->FetchRow());
?>
</table>
<?php
}
//if(isset($_POST['inicial']) or isset($_GET['inicial']))
//{
// vista previa
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
    <td colspan="7"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
  </tr>
  <tr>
    <td id="tdtitulogris">Actividad*</td>
    <td>
      <select name="actividad">
        <option value="0" <?php if (!(strcmp("0", $_POST['actividad']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
        <option value="<?php echo $row_actividad['idtipoestudiantelaboral']?>"<?php if (!(strcmp($row_actividad['idtipoestudiantelaboral'], $_POST['actividad']))) {echo "SELECTED";} ?>><?php echo $row_actividad['nombretipoestudiantelaboral'];?></option>
<?php
}
while($row_actividad = $actividad->FetchRow());
?>
      </select>
    </td>
    <td id="tdtitulogris">Pais*</td>
    <td colspan="3">
      <select name="ciudadexperiencia">
        <option value="0" <?php if (!(strcmp("0", $_POST['ciudadexperiencia']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
        <option value="<?php echo $row_ciudad1['idpais']?>"<?php if (!(strcmp($row_ciudad1['idpais'], $_POST['ciudadexperiencia']))) {echo "SELECTED";} ?>><?php echo $row_ciudad1['nombrepais'];?></option>
<?php
}
while($row_ciudad1 = $ciudad1->FetchRow());
?>
      </select>
<?php
//crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala2);
?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td id="tdtitulogris">Instituci&oacute;n o empresa </td>
    <td><input name="institucion" type="text" id="institucion" size="35" maxlength="50" value="<?php echo $_POST['institucion'];?>"></td>
    <td id="tdtitulogris">Cargo*</td>
    <td colspan="3"><input name="cargo" type="text" id="cargo" size="35" maxlength="50" value="<?php echo $_POST['cargo'];?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td id="tdtitulogris">Descripci&oacute;n</td>
    <td colspan="5"><input name="descripcionestudiantelaboral" type="text" id="descripcion" size="80" maxlength="100" value="<?php echo $_POST['descripcionestudiantelaboral'];?>"></td>
  </tr>
</table>
