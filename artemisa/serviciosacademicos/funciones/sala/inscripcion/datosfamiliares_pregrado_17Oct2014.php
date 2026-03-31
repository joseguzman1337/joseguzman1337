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
$tieneMadre = false;
$tienePadre = false;
$tieneHermano = false;
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
        if($row_datosgrabados['idtipoestudiantefamilia'] == 1)
                $tieneMadre = true;
            if($row_datosgrabados['idtipoestudiantefamilia'] == 2)
                $tienePadre = true;
            if($row_datosgrabados['idtipoestudiantefamilia'] == 7)
                $tieneHermano = true;
        }
        while($row_datosgrabados = $datosgrabados->FetchRow());
        $datosgrabados->Move(0);
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
<label id="labelresaltado">Si es su caso seleccione no aplica</label>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="5" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
    </tr>
    <?php
    if(!$tieneMadre) :
        ?>
    <tr>
        <td id="tdtitulogris" colspan="5">Datos de la Madre <input type="hidden" name="idmadre" value="1"></td>
    </tr>
    <tr>
        <td rowspan="2">No Aplica
            <input type="checkbox" name="nomadre" onclick="alert('Si selecciona no aplica no hay necesidad de diligenciar los datos del formulario ya que no se tomarian en cuenta')" value="sinmadre">
        </td>
        <td id="tdtitulogris">Nombre*</td>
        <td>
            <input type="text" name="nombremadre" size="25" value="<?php echo $_POST['nombremadre'];?>">
        </td>
        <td id="tdtitulogris">Apellidos*</td>
        <td><input type="text" name="apellidomadre"  size="25" value="<?php echo $_POST['apellidomadre'];?>"></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Ocupación</td>
        <td><input type="text" name="ocupacionmadre" size="25" value="<?php echo $_POST['ocupacionmadre'];?>"></td>
        <td id="tdtitulogris">Tel&eacute;fono</td>
        <td>
            <input name="telefonomadre" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefonomadre'];?>">
        </td>
    </tr>
    <?php
    endif;
    if(!$tienePadre) :
        ?>
    <tr>
        <td id="tdtitulogris" colspan="5">Datos del Padre <input type="hidden" name="idpadre" value="2"></td>
    </tr>
    <tr>
        <td rowspan="2">No Aplica <input type="checkbox" name="nopadre" onclick="alert('Si selecciona no aplica no hay necesidad de diligenciar los datos del formulario ya que no se tomarian en cuenta')" value="sinpadre"></td>
        <td id="tdtitulogris">Nombre*</td>
        <td>
            <input type="text" name="nombrepadre" size="25" value="<?php echo $_POST['nombrepadre'];?>">
        </td>
        <td id="tdtitulogris">Apellidos*</td>
        <td><input type="text" name="apellidopadre"  size="25" value="<?php echo $_POST['apellidopadre'];?>"></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Ocupación</td>
        <td><input type="text" name="ocupacionpadre" size="25" value="<?php echo $_POST['ocupacionpadre'];?>"></td>
        <td id="tdtitulogris">Tel&eacute;fono</td>
        <td>
            <input name="telefonopadre" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefonopadre'];?>">
        </td>
    </tr>
    <?php
    endif;
    if(!$tieneHermano) :
        ?>
    <tr>
        <td id="tdtitulogris" colspan="5">Datos de un Hermano <input type="hidden" name="idhermano" value="7"></td>
    </tr>
    <tr>
        <td rowspan="2">No Aplica <input type="checkbox" name="nohermano" onclick="alert('Si selecciona no aplica no hay necesidad de diligenciar los datos del formulario ya que no se tomarian en cuenta')" value="sinhermano"></td>
        <td id="tdtitulogris">Nombre*</td>
        <td>
            <input type="text" name="nombrehermano" size="25" value="<?php echo $_POST['nombrehermano'];?>">
        </td>
        <td id="tdtitulogris">Apellidos*</td>
        <td><input type="text" name="apellidohermano"  size="25" value="<?php echo $_POST['apellidohermano'];?>"></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Ocupación</td>
        <td><input type="text" name="ocupacionhermano" size="25" value="<?php echo $_POST['ocupacionhermano'];?>"></td>
        <td id="tdtitulogris">Tel&eacute;fono</td>
        <td>
            <input name="telefonohermano" type="text" id="Celular4" size="25" value="<?php echo $_POST['telefonohermano'];?>">
        </td>
    </tr>
    <?php
    endif;
    ?>
</table>
<?php
    } // vista previa
    ?>
  <!-- <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  -->
<script language="javascript">
    /*function recargar(dir)
{
        window.location.href="datosfamiliares.php"+dir;
        history.go();
}*/
    function vista()
    {
        window.location.href="vistaformularioinscripcion.php";
    }
</script>