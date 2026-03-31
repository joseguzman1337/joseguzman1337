<?php
//$db->debug = true;
$query_idiomaestudiante = "SELECT *
FROM estudiantemediocomunicacion e
WHERE  e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idinscripcion = '".$this->idinscripcion."'
and e.codigoestadoestudiantemediocomunicacion like '1%'
ORDER BY 2";
$idiomaestudiante = $db->Execute($query_idiomaestudiante);
$totalRows_idiomaestudiante = $idiomaestudiante->RecordCount();
$row_idiomaestudiante = $idiomaestudiante->FetchRow();

$sinmediodecomunicacion = "codigomediocomunicacion <> ".$row_idiomaestudiante['codigomediocomunicacion'];
if ($row_idiomaestudiante <> "") {
    do {
        $sinmediodecomunicacion = $sinmediodecomunicacion ." and codigomediocomunicacion <> ".$row_idiomaestudiante['codigomediocomunicacion'];
//echo $sinidioma ,"<br>";
    }
    while($row_idiomaestudiante = $idiomaestudiante->FetchRow());
    $query_mediocomunicacion = "select *
	from mediocomunicacion
	where ($sinmediodecomunicacion)
        and codigoestado like '1%'
        and codigomediocomunicacionpadre = '0'
	order by 2";
    $mediocomunicacion = $db->Execute($query_mediocomunicacion);
    $totalRows_mediocomunicacion = $mediocomunicacion->RecordCount();
    $row_mediocomunicacion = $mediocomunicacion->FetchRow();
}
else {
    $query_mediocomunicacion = "select *
	from mediocomunicacion
	where codigoestado like '1%'
        and codigomediocomunicacionpadre = '0'
        order by 2";
    $mediocomunicacion = $db->Execute($query_mediocomunicacion);
    $totalRows_mediocomunicacion = $mediocomunicacion->RecordCount();
    $row_mediocomunicacion = $mediocomunicacion->FetchRow();
}

$query_datosgrabados = "SELECT * 
FROM estudiantemediocomunicacion e,mediocomunicacion m
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idinscripcion = '".$this->idinscripcion."'
and e.codigomediocomunicacion = m.codigomediocomunicacion
and e.codigoestadoestudiantemediocomunicacion like '1%'
order by nombremediocomunicacion";			  
//echo $query_data; 
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> "") {
    ?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr id="trtitulogris">
        <td >Medio de comunicaci&oacute;n </td>
        <td>Descripción</td>
        <td>Eliminar</td>
    </tr>
        <?php
        do {
            //$db->debug = true;
            $query_datosgrabadoshijo = "select e.*, m.*
            from estudiantemediocomunicacion e, mediocomunicacion m
            where m.codigoestado like '1%'
            and m.codigomediocomunicacionpadre = '".$row_mediocomunicacion['codigomediocomunicacion']."'
            and e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
            and e.idinscripcion = '".$this->idinscripcion."'
            and e.codigoestadoestudiantemediocomunicacion like '1%'
            and e.codigomediocomunicacion = m.codigomediocomunicacion
            order by 2";
            $datosgrabadoshijo = $db->Execute($query_datosgrabadoshijo);
            $totalRows_datosgrabadoshijo = $datosgrabadoshijo->RecordCount();
            if($totalRows_datosgrabadoshijo == 0) {
                continue;
            }
            ?>
    <tr id="trtitulogris">
        <td colspan="3"><?php echo $row_mediocomunicacion['nombremediocomunicacion'] ;?></td>
    </tr>
            <?php
            while($row_datosgrabadoshijo = $datosgrabadoshijo->FetchRow()) {
                ?>
    <tr>
        <td><?php echo $row_datosgrabadoshijo['nombremediocomunicacion'];?></td>
        <td><?php echo $row_datosgrabadoshijo['observacionestudiantemediocomunicacion'];?></td>
        <td><a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?mediocomunicacion&id=<?php echo $row_datosgrabadoshijo['idestudiantemediocomunicacion'];?>'" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>
    </tr>
                <?php

            }
        }
        while($row_mediocomunicacion = $mediocomunicacion->FetchRow());
        $mediocomunicacion->Move(0);
        ?>
</table> 
    <?php
}	      
?>
<br>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr id="trtitulogris">
        <td colspan="3"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>
    </tr>
    <tr id="trtitulogris">
        <td>Medio</td>
        <td>Seleccionar</td>
        <td>Descripción</td>
    </tr>
    <?php
    $cuentamedio = 1;
    do {
        if ($totalRows_idiomaestudiante > 0) {
            $query_mediocomunicacionhijo = "select *
	from mediocomunicacion
	where ($sinmediodecomunicacion)
        and codigoestado like '1%'
        and codigomediocomunicacionpadre = '".$row_mediocomunicacion['codigomediocomunicacion']."'
	order by 2";

        }
        else {
            $query_mediocomunicacionhijo = "select *
	from mediocomunicacion
	where codigoestado like '1%'
        and codigomediocomunicacionpadre = '".$row_mediocomunicacion['codigomediocomunicacion']."'
        order by 2";
        }
        $mediocomunicacionhijo = $db->Execute($query_mediocomunicacionhijo);
        $totalRows_mediocomunicacionhijo = $mediocomunicacionhijo->RecordCount();
        if($totalRows_mediocomunicacionhijo == 0) {
            continue;
        }
        ?>
    <tr id="trtitulogris">
        <td colspan="3"><?php echo $row_mediocomunicacion['nombremediocomunicacion'] ;?></td>
    </tr>
        <?php
        while($row_mediocomunicacionhijo = $mediocomunicacionhijo->FetchRow()) {
            ?>
    <tr>
        <td width="54%"><?php echo $row_mediocomunicacionhijo['nombremediocomunicacion'] ;?></td>
        <td width="14%">
            <input type="checkbox" name="medio<?php echo $cuentamedio;?>" value="<?php echo $row_mediocomunicacionhijo['codigomediocomunicacion'] ;?>">
        </td>
        <td width="32%">
            <input name="descripcion<?php echo $cuentamedio;?>" type="text" id="descripcion" size="40" maxlength="100" value="<?php echo $_POST['descripcion'.$cuentamedio];?>">
        </td>
    </tr>
            <?php
            $cuentamedio++;
        }
    }
    while($row_mediocomunicacion = $mediocomunicacion->FetchRow());
    ?>
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
<br>
<!--    <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">
   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  
-->
<!-- <input type="button" value="Enviar" onClick="grabar()">
<input type="button" value="Vista Previa" onClick="vista()"> -->
<input type="hidden" name="grabado" value="grabado">   
<?php
?>
