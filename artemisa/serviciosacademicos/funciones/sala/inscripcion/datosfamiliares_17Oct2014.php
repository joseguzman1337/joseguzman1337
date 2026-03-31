<?php
//$db->debug = true;
$codigoinscripcion = $_SESSION['numerodocumentosesion']; 
//mysql_select_db($database_sala, $sala);
$query_parentesco = "select *
from tipoestudiantefamilia
order by 2";
$parentesco = $db->Execute($query_parentesco);
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();

$query_niveleducacion = "select *
from niveleducacion
order by 2";
$niveleducacion = $db->Execute($query_niveleducacion);
$totalRows_niveleducacion = $niveleducacion->RecordCount();
$row_niveleducacion = $niveleducacion->FetchRow();

$query_ciudad2 = "select *
from ciudad
order by 3";
$ciudad2 = $db->Execute($query_ciudad2);
$totalRows_ciudad2 = $ciudad2->RecordCount();
$row_ciudad2 = $ciudad2->FetchRow();

$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo
FROM inscripcionformulario ip, inscripcionmodulo im
WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
AND ip.codigomodalidadacademica = '".$codigomodalidadacademicasesion."'
AND ip.codigoestado LIKE '1%'
order by posicioninscripcionformulario";
$formularios = $db->Execute($query_formularios);
$totalRows_formularios = $formularios->RecordCount();
$row_formularios = $formularios->FetchRow();
?>

<!-- <label id="labelresaltado">Los datos de Padre y Madre son obligatorios.</label> -->

<?php 
$query_datosgrabados = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia, e.apellidosestudiantefamilia,
e.telefonoestudiantefamilia, e.ocupacionestudiantefamilia, e.idestudiantefamilia, e.idtipoestudiantefamilia
FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n 
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia								 							 
and e.idniveleducacion = n.idniveleducacion 
and e.codigoestado like '1%'
order by e.idtipoestudiantefamilia";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> "") {
    ?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr id="trtitulogris">
        <td>Parentesco</td>
        <td>Nombre</td>
        <!--  <td>Nivel de educación</td> -->
        <!--  <td>Profesi&oacute;n</td> -->
        <!-- <td>Dirección</td>  -->
        <td>Ocupación</td>
        <td>Teléfono</td>
        <td>Actualizar</td>
    </tr>
    <?php
        do {
            ?>
    <tr>
        <td><?php echo $row_datosgrabados['nombretipoestudiantefamilia'];?></td>
        <td><?php echo $row_datosgrabados['nombresestudiantefamilia'];?> <?php echo $row_datosgrabados['apellidosestudiantefamilia'];?></td>
<!-- <td><?php echo $row_datosgrabados['nombreniveleducacion'];?></td>  -->
        <!-- <td><?php echo $row_datosgrabados['profesionestudiantefamilia'];?></td>  -->
        <!-- <td><?php echo $row_datosgrabados['direccionestudiantefamilia'];?></td>  -->
        <td><?php echo $row_datosgrabados['ocupacionestudiantefamilia'];?></td>
        <td><?php echo $row_datosgrabados['telefonoestudiantefamilia'];?></td>
        <!-- <td><?php echo $row_datosgrabados['celularestudiantefamilia'];?></td>  -->
        <td><a onClick="window.location.href='editardatosfamiliares_new.php?id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
            <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?datosfamiliares&id=<?php echo $row_datosgrabados['idestudiantefamilia'];?>'" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>
    </tr>
    <?php
    }
        while($row_datosgrabados = $datosgrabados->FetchRow());
        ?>
</table> 
    <?php
}
else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) {
        ?>
<!-- <tr>
<td>Sin datos diligenciados</td>
</tr> -->
    <?php
    }
//if(isset($_POST['inicial']) or isset($_GET['inicial'])) 
{ // vista previa	  	   
    if (isset($_GET['inicial'])) {
        $moduloinicial = $_GET['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';

    }
    else {
        $moduloinicial = $_POST['inicial'];
        echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
    }
    ?>	
<script language="javascript">
    function grabar()
    {
        document.inscripcion.submit();
    }
</script>
<input type="hidden" name="grabado" value="grabado">   
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="6" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Parentesco*</td>
        <td><select name="idtipoestudiantefamilia">
                <option value="0" <?php if (!(strcmp("0", $_POST['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
        ?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $_POST['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>
    <?php
                    }
                    while($row_parentesco = $parentesco->FetchRow());
                    ?>
            </select>
        </td>
        <td id="tdtitulogris">Nombre*</td>
        <td>
            <input type="text" name="nombresestudiantefamilia" size="25" value="<?php echo $_POST['nombresestudiantefamilia'];?>">
        </td>
        <td id="tdtitulogris">Apellidos*</td>
        <td><input type="text" name="apellidosestudiantefamilia"  size="25" value="<?php echo $_POST['apellidosestudiantefamilia'];?>"></td>
        <!--  </tr>
        <tr> -->
         <!--   <td id="tdtitulogris">Edad</td>
          <td>
            <input name="edad" type="text" id="edad" size="2" maxlength="3" value="<?php echo $_POST['edadfamiliares'];?>">
          </td> -->
    </tr>
    <tr>
    <!-- <td id="tdtitulogris">Profesión</td>
     <td>
      <input type="text" name="profesion" size="25" value="<?php echo $_POST['profesion'];?>">
    </td> -->
        <td id="tdtitulogris">Ocupación</td>
        <td><input type="text" name="ocupacionestudiantefamilia" size="25" value="<?php echo $_POST['ocupacionestudiantefamilia'];?>"></td>
        <!--  </tr>
         <tr>
           <td id="tdtitulogris">E-mail</td>
           <td colspan="3"><input type="text" name="email" size="40" value="<?php echo $_POST['email'];?>"></td>
           <td id="tdtitulogris">Celular</td>
           <td><input type="text" name="celular" size="20" value="<?php echo $_POST['celular'];?>"></td>
         </tr>
        <tr>
                <td id="tdtitulogris">Ciudad</td>
                <td>
                              <select name="ciudadfamilia">
                    <option value="0" <?php if (!(strcmp("0", $_POST['ciudadfamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
        ?>
                    <option value="<?php echo $row_ciudad2['idciudad']?>"<?php if (!(strcmp($row_ciudad2['idciudad'], $_POST['ciudadfamilia']))) {echo "SELECTED";} ?>><?php echo $row_ciudad2['nombreciudad'];?></option>
    <?php
    }
            while($row_ciudad2 = $ciudad2->FetchRow());
            ?>
		       </select>
			</td>
                <td id="tdtitulogris">Direcci&oacute;n</td>
                <td> <input name="direccion1" type="text" id="direccion1" size="25" maxlength="50" value="<?php echo $_POST['direccion1'];?>">
                </td> -->
        <td id="tdtitulogris">Tel&eacute;fono</td>
        <td>
            <input name="telefonoestudiantefamilia" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefonoestudiantefamilia'];?>">
        </td>
    </tr>
   <!-- <tr>
     <td id="tdtitulogris">Nivel de Educaci&oacute;n</td>
     <td><select name="niveleducacion">
         <option value="0" <?php if (!(strcmp("0", $_POST['niveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
        ?>
         <option value="<?php echo $row_niveleducacion['idniveleducacion']?>"<?php if (!(strcmp($row_niveleducacion['idniveleducacion'], $_POST['niveleducacion']))) {echo "SELECTED";} ?>><?php echo $row_niveleducacion['nombreniveleducacion'];?></option>
    <?php
    }
    while($row_niveleducacion = $niveleducacion->FetchRow());
        ?>
       </select>
     </td>
     <td id="tdtitulogris">Direcci&oacute;n Correspondencia</td>
     <td>
             <input name="direccion2" type="text" id="direccion2" size="25"  value="<?php echo $_POST['direccion2']?>">
          </td>
     <td id="tdtitulogris">Tel&eacute;fono</td>
     <td>
       <input name="telefono2" type="text" id="telefono2" size="25" value="<?php echo $_POST['telefono2']?>">
     </td>
   </tr> -->
</table>
<!--       <br>
          <input type="button" value="Enviar" onClick="grabar()">
          <input type="button" value="Vista Previa" onClick="vista()"> -->
     <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar"> -->
<?php
} // vista previa	  
?>
     <!-- <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  -->
<script language="javascript">
    /*function recargar(dir)
{
        window.location.reload("datosfamiliares.php"+dir);
        history.go();
}*/
    function vista()
    {
        window.location.reload("vistaformularioinscripcion.php");
    }
</script> 
