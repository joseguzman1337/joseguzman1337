<?php
//$db->debug = true;
$codigoinscripcion = $_SESSION['numerodocumentosesion'];
$query_tipoestudianterecursofinanciero = "select *
from tipoestudianterecursofinanciero
order by 2";
$tipoestudianterecursofinanciero = $db->Execute($query_tipoestudianterecursofinanciero);
$totalRows_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->RecordCount();
$row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow();

$query_datosgrabados = "SELECT *
FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t 
WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero
and e.codigoestado like '1%'
order by nombretipoestudianterecursofinanciero";			  
//echo $query_data;
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="2" align="left">
            <?php
            if($aprobarHV) :
                $query_selforms = "select f.idformulario
from formularioestudiante f
where f.idestudiantegeneral =  '".$this->estudiantegeneral->idestudiantegeneral."'
and f.codigoestado like '1%'
and f.codigoestadodiligenciamiento like '2%'
and f.idformulario = '25'";
                $selforms = $db->Execute($query_selforms) or die(mysql_error());
                $totalRows_selforms = $selforms->RecordCount();
                $checked = "";
                if($totalRows_selforms > 0) {
                    $checked = "checked";
                }
                ?>
            <input type="checkbox" onclick="selapruebadocente(this,'25');" <?php echo $checked; ?> />
            <?php
            endif;
            ?>
            <label id="labelresaltado">RECURSOS FINANCIEROS</label>
        </td>
    </tr>
    <tr id="trtitulogris">
        <td>Tipo de recurso</td>
        <td>Descripción</td>
    </tr>
    <?php
    if ($row_datosgrabados <> "") { 
        do {
            ?>
    <tr>
        <td><?php echo $row_datosgrabados['nombretipoestudianterecursofinanciero'];?></td>
        <td><?php echo $row_datosgrabados['descripcionestudianterecursofinanciero'];?></td>
    </tr>
        <?php
        }
        while($row_datosgrabados = $datosgrabados->FetchRow());
    }
    ?>
</table>
<?php
