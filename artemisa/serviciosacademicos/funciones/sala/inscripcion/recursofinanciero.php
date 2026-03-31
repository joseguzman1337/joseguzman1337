<?php
//$db->debug = true;
$codigoinscripcion = $_SESSION['numerodocumentosesion'];
/*
 * Caso  105179.
 * Modificado por Luis Dario Gualteros C <castroluisd@unbosque.edu.co> 
 * Se quita de la lista el recurso 13 ser pilo paga temporalmente ya que no esta activo este programa para este periodo.
 * Modificado 25 de Septiembre 2018.
*/
$query_tipoestudianterecursofinanciero = "select *
from tipoestudianterecursofinanciero
where idtipoestudianterecursofinanciero in(6,3,7,9,8,10,14)
order by FIND_IN_SET(idtipoestudianterecursofinanciero, '6,9,10,3,7,8,14')";
//End Caso 105179.
$tipoestudianterecursofinanciero = $db->Execute($query_tipoestudianterecursofinanciero);
$totalRows_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->RecordCount();
$row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow();
?>
<table width="70%" border="0" cellpadding="1" cellspacing="0"
       bordercolor="#E9E9E9">
    <tr>
        <td><?php
            $query_datosgrabados = "SELECT *
            FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t 
            WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
            and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero
            and e.codigoestado like '1%'
            GROUP BY t.idtipoestudianterecursofinanciero
            order by nombretipoestudianterecursofinanciero";			  
            
            $datosgrabados = $db->Execute($query_datosgrabados);
            $totalRows_datosgrabados = $datosgrabados->RecordCount();
            $row_datosgrabados = $datosgrabados->FetchRow();
            if ($row_datosgrabados <> "") { ?>
            <table width="100%" border="1" cellpadding="1" cellspacing="0"
                   bordercolor="#E9E9E9">
                <tr id="trtitulogris">
                    <td>Tipo de recurso</td>
                    <td>Descripción</td>
                    <td>Editar</td>
                </tr>
                    <?php
                    do {
                        ?>
                <tr>
                    <td><?php echo $row_datosgrabados['nombretipoestudianterecursofinanciero'];?></td>
                    <td><?php echo $row_datosgrabados['descripcionestudianterecursofinanciero'];?></td>
                    <td>
                        <a onClick="window.location.href='editarrecursofinanciero_new.php?id=<?php echo $row_datosgrabados['idestudianterecursofinanciero'];?>'" style="cursor: pointer">
                            <img src="https://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
                        <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?recursofinanciero&id=<?php echo $row_datosgrabados['idestudianterecursofinanciero'];?>'"	style="cursor: pointer">
                            <img src="https://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a></td>
                </tr>
                        <?php
                    }
                    while($row_datosgrabados = $datosgrabados->FetchRow());
                    ?>
            </table>
                <?php
            }
            else {
                ?> <!-- <tr>
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
                ?> <br>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                <tr id="trtitulogris">
                    <td colspan="2"><?php echo $nombremodulo[$moduloinicial]; ?>
                        <a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="https://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a>
                    </td>
                </tr>
                <tr id="trtitulogris">
                    <td>Tipo de Recurso*</td>
                    <td>Descripci&oacute;n</td>
                </tr>
                <tr>
                    <td width="51%"><select name="idtipoestudianterecursofinanciero">
                            <option value="0"
                                <?php if (!(strcmp("0", $_POST['idtipoestudianterecursofinanciero']))) {
                                    echo "SELECTED";
                                        } ?>>Seleccionar</option>
                                        <?php
                                        do {
                                            ?>
                            <option value="<?php echo $row_tipoestudianterecursofinanciero['idtipoestudianterecursofinanciero']?>"
                                    <?php if (!(strcmp($row_tipoestudianterecursofinanciero['idtipoestudianterecursofinanciero'], $_POST['idtipoestudianterecursofinanciero']))) {
                                        echo "SELECTED";
                                            } ?>><?php echo $row_tipoestudianterecursofinanciero['nombretipoestudianterecursofinanciero']?></option>
                                            <?php
                                        }
                                        while($row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow());
                                        ?>
                        </select></td>
                    <td width="49%">
                        <div><input type="text" name="descripcionestudianterecursofinanciero" size="70"
                                    value="<?php echo $_POST['descripcionestudianterecursofinanciero'];?>">

                            </td>
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
                                    window.location.href="vistaformularioinscripcion.php";
                                }
                            </script>
                            <!-- <br>
                            <input type="button" value="Enviar" onClick="grabar()">
                            <input type="button" value="Vista Previa" onClick="vista()"> -->
                            <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">
                              <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>   -->
                            <!-- <input type="hidden" name="grabado" value="grabado">
                            <br>
                            <br> -->
                                <?php
                            } // vista previa
                            ?>
                            <script language="javascript">
                                /*function recargar(dir)
                            {
                                    //window.location.reload("aspectospersonales.php"+dir);
                                    window.location.href="";
                                    history.go();
                            }*/
                            </script>

