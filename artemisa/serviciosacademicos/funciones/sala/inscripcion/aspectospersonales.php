<?php
$codigoinscripcion = $_SESSION['numerodocumentosesion'];
$query_aspectospersonales = "select *
from tipoestudianteaspectospersonales
order by 2";
$aspectospersonales = $db->Execute($query_aspectospersonales);
$totalRows_aspectospersonales = $aspectospersonales->RecordCount();
$row_aspectospersonales = $aspectospersonales->FetchRow();

//$db->debug = true;
$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
WHERE numerodocumento = '$codigoinscripcion'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica
and i.codigoestado like '1%'
AND e.idnumeroopcion = '1'
and i.idinscripcion = '".$this->idinscripcion."'";
$data = $db->Execute($query_data);
$totalRows_data = $data->RecordCount();
$row_data = $data->FetchRow();


$query_datosgrabados = "SELECT *
FROM estudianteaspectospersonales e,tipoestudianteaspectospersonales t
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idtipoestudianteaspectospersonales = t.idtipoestudianteaspectospersonales
and e.codigoestado like '1%'";
//echo $query_data;
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> "")
{
?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr id="trtitulogris">
    <td>Aspecto</td>
    <td>Descripción</td>
    <td>Acción</td>
  </tr>
<?php
    do
    {
?>
  <tr>
    <td><?php echo $row_datosgrabados['nombretipoestudianteaspectospersonales'];?></td>
    <td><?php echo $row_datosgrabados['descripcionestudianteaspectospersonales'];?></td>
    <td><a onClick="window.location.href='editaraspectospersonales_new.php?id=<?php echo $row_datosgrabados['idestudianteaspectospersonales'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
    <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?aspectospersonales&id=<?php echo $row_datosgrabados['idestudianteaspectospersonales'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar">
    </td>
  </tr>
<?php
    }
    while($row_datosgrabados = $datosgrabados->FetchRow());
?>
</table>
<?php
}
?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
    <td colspan="2" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
  </tr>
  <tr id="trtitulogris">
    <td >Tipo Aspecto*</td>
    <td >Descripci&oacute;n*</td>
  </tr>
  <tr>
    <td width="51%">
      <select name="aspecto">
        <option value="0" <?php if (!(strcmp("0", $_POST['aspecto']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
        <option value="<?php echo $row_aspectospersonales['idtipoestudianteaspectospersonales']?>"<?php if (!(strcmp($row_aspectospersonales['idtipoestudianteaspectospersonales'], $_POST['aspecto']))) {echo "SELECTED";} ?>><?php echo $row_aspectospersonales['nombretipoestudianteaspectospersonales']?></option>
<?php
}
while($row_aspectospersonales = $aspectospersonales->FetchRow());
$rows = mysql_num_rows($aspectospersonales);
?>
        </select>
    </td>
    <td width="49%" >
      <input type="text" name="descripcionaspecto" size="30" value="<?php echo $_POST['descripcionaspecto'];?>">
    </td>
  </tr>
</table>
