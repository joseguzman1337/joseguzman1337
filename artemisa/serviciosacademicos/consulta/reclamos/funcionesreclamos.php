<?php
function obtenerAsunto($tipoasuntoquejareclamo)
{
    global $db;
    $query_tipo_asunto = "SELECT nombretipoasuntoquejareclamo from tipoasuntoquejareclamo where codigotipoasuntoquejareclamo = '$tipoasuntoquejareclamo'";
    $tipo_asunto = $db->Execute($query_tipo_asunto);
    $totalRows_tipo_asunto = $tipo_asunto->RecordCount();
    $row_tipo_asunto = $tipo_asunto->FetchRow();
    return $row_tipo_asunto['nombretipoasuntoquejareclamo'];
}

function obtenerTipoUsuario($tipousuario)
{

            global $db;
            $query_tipo_usuario = "select nombreusuarioquejareclamo from usuarioquejareclamo where  codigousuarioquejareclamo = '$tipousuario'";
            $tipo_usuario = $db->Execute ($query_tipo_usuario);
            $total_Rows_tipo_usuario = $tipo_usuario->RecordCount();
            $row_tipo_usuario = $tipo_usuario->FetchRow();
            return $row_tipo_usuario['nombreusuarioquejareclamo'];
}

function obtenerTipoDocumento($tipodocumento)
{

            global $db;
            $query_tipodoc = "select nombredocumento from documento  where tipodocumento not in (07, 08, 09, 10) and tipodocumento='$tipodocumento'";
            $tipodoc = $db->Execute($query_tipodoc);
            $totalRows_tipodoc = $tipodoc->RecordCount();
            $row_tipodoc = $tipodoc->FetchRow();
            return $row_tipodoc['nombredocumento'];
}

function obtenerAspectoasunto($tipoaspecto)
{

            global $db;
            $query_tipo_aspecto = "SELECT nombreaspectotipoasuntoquejareclamo from aspectotipoasuntoquejareclamo where codigoaspectotipoasuntoquejareclamo='$tipoaspecto'";
            $tipo_aspecto = $db->Execute($query_tipo_aspecto);
            $totalRows_tipo_aspecto = $tipo_aspecto->RecordCount();
            $row_tipo_aspecto = $tipo_aspecto->FetchRow();
            return $row_tipo_aspecto['nombreaspectotipoasuntoquejareclamo'];
}

function existePersona($idpersonaquejareclamo)
{

            global $db;
            $existe = true;
            $query_documento = "SELECT * from personaquejareclamo where idpersonaquejareclamo = '$idpersonaquejareclamo' ";
            $documento= $db->Execute($query_documento);
            $totalRows_documento = $documento->RecordCount();
            if($totalRows_documento == 0){
                $existe = false;
            }
            return $existe;
}

function obtenerPersona($idpersonaquejareclamo)
{

            global $db;
            $query_documento = "SELECT * from personaquejareclamo where idpersonaquejareclamo = '$idpersonaquejareclamo'";
            $documento= $db->Execute($query_documento);
            $totalRows_documento = $documento->RecordCount();
            $row_documento = $documento->FetchRow();
            return $row_documento;
}

function obtenerArea($tipoArea)
{

            global $db;
            //$db->debug = true;
            $query_modalidadacademica = "SELECT nombreareaquejareclamo, codigoareaquejareclamo from areaquejareclamo where codigoareaquejareclamo='$tipoArea'";
            $modalidadacademica= $db ->Execute($query_modalidadacademica);
            $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
            $row_modalidadacademica = $modalidadacademica->FetchRow();
            //$db->debug = false;
            return $row_modalidadacademica['nombreareaquejareclamo'];
}

function obtenerCodigoAreaQuejaReclamo($idpersonaquejareclamo)
{

            global $db;
            //$db->debug = true;
            $query_modalidadacademica = "SELECT a.codigoareaquejareclamo
            from areaquejareclamo a, personaquejareclamo p, dependenciaquejareclamo d
            where a.codigoareaquejareclamo = d.codigoareaquejareclamo
            and p.idpersonaquejareclamo = '$idpersonaquejareclamo'
            and p.iddependenciaquejareclamo = d.iddependenciaquejareclamo
            and a.codigoestado like '1%'";
            $modalidadacademica= $db ->Execute($query_modalidadacademica);
            $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
            $row_modalidadacademica = $modalidadacademica->FetchRow();
            //$db->debug = false;
            return $row_modalidadacademica['codigoareaquejareclamo'];
}

function obtenerDependencia($tipoDependencia, $tipoArea)
{

            global $db;
                        $query_carrera = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo from dependenciaquejareclamo where codigoareaquejareclamo='$tipoArea'
                and iddependenciaquejareclamo='$tipoDependencia'";
                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
            $row_carrera = $carrera->FetchRow();
            return $row_carrera['nombredependenciaquejareclamo'];
}

function listadoquejareclamo ($idpersonaquejareclamo, $tipolistado)// = "solicitante")
{
                global $db;
                if($tipolistado == "solicitante") {
                    $filtroSolicitante = "and s.idpersonaquejareclamo = '".$idpersonaquejareclamo."'";
                }
                elseif($tipolistado == "atencionalusuario") {
                    // No hace nada por el momento
                }
                elseif($tipolistado == "areaacargo") {
                    $filtroSolicitante = "and s.iddependenciaquejareclamo = ud.iddependenciaquejareclamo
		and ud.usuarioquejareclamo = '".$_SESSION['MM_Username']."'";
                    $filtroSolicitanteFrom = ",usuariodependenciaquejareclamo ud";
                    // Hace algo 
                }
                $filtroDocumento = "";
                $filtroNombre = "";
                $filtroTipoUsuario = "";
                $filtroDestino = "";
                $filtroFecha = "";
                $filtroEstado = "";

                
                if(isset($_POST['numerodocumento'])) {
                $filtroDocumento = " and p.numerodocumentopersonaquejareclamo like '%".$_POST['numerodocumento']."%'";
                }
                if(isset($_POST['nombre'])) {
                $filtroNombre = " and concat(p.nombrespersonaquejareclamo, ' ', p.apellidospersonaquejareclamo) like  '%".$_POST['nombre']."%'";
                }
                if(isset($_POST['tipousuario'])) {
                $filtroTipoUsuario = " and u.nombreusuarioquejareclamo like '%".$_POST['tipousuario']."%'";
                }
                if(isset($_POST['destino'])) {
                $filtroDestino = " and d.nombredependenciaquejareclamo like '%".$_POST['destino']."%'";
                }
                if(isset($_POST['fecha'])) {
                $filtroFecha = " and s.fechasolicitudquejareclamo like '%".$_POST['fecha']."%'";
                }
                if(isset($_POST['estado'])) {
                $filtroEstado = " and e.nombreestadoquejareclamo like '%".$_POST['estado']."%'";
                }
                elseif($tipolistado=="atencionalusuario"){
                    $filtroEstado = " and e.codigoestadoquejareclamo in (100,300,500)";
                }

                $query_listado = "SELECT s.idsolicitudquejareclamo, p.numerodocumentopersonaquejareclamo, concat(p.nombrespersonaquejareclamo, ' ', p.apellidospersonaquejareclamo)as nombre, u.nombreusuarioquejareclamo, d.nombredependenciaquejareclamo as dependencia_destino, a.nombreaspectotipoasuntoquejareclamo, s.fechasolicitudquejareclamo, e.nombreestadoquejareclamo, e.descripcionestadoquejareclamo
                FROM usuarioquejareclamo u, personaquejareclamo p, solicitudquejareclamo s, aspectotipoasuntoquejareclamo a, estadoquejareclamo e, dependenciaquejareclamo d
                $filtroSolicitanteFrom
                where s.idpersonaquejareclamo = p.idpersonaquejareclamo
                $filtroSolicitante
                $filtroDocumento 
                $filtroNombre
                $filtroTipoUsuario
                $filtroDestino
                $filtroFecha 
                $filtroEstado
                and u.codigousuarioquejareclamo= p.codigousuarioquejareclamo
                and s.codigoaspectotipoasuntoquejareclamo = a.codigoaspectotipoasuntoquejareclamo
                and s.codigoestadoquejareclamo = e.codigoestadoquejareclamo
                and d.iddependenciaquejareclamo=s.iddependenciaquejareclamo
                order by e.codigoestadoquejareclamo desc";
                $listado= $db->Execute($query_listado);
                $totalRows_listado = $listado->RecordCount();
                $row_listado = $listado->FetchRow();
                
                
                
                if($totalRows_listado >0){
?>
    <table width="70%"  border="0" align="center" cellpadding="3" cellspacing="3">
        <TR align="center" >
            <TD colspan="8" align="center"><label id="labelresaltadogrande" >Listado de Sugerencias</label>
            </TD>
        </TR>
    </table>
    <table width="80%"  border="1" align="center" cellpadding="3" cellspacing="3">
                
                <TR id="trtitulogris">
                    <TD align="center">Número Tiquete</TD>
                    <TD width="5%" align="center">Documento Usuario</TD>
                    <TD align="center">Nombre Usuario</TD>
                    <TD align="center">Tipo Usuario</TD>
                    <TD align="center">Destino Sugerencia</TD>
                    <TD align="center">Fecha Sugerencia</TD>
                    <TD align="center">Estado Sugerencia</TD>
                    <TD align="center">Descripción  Sugerencia</TD>
                </TR>
                <?php
                if($tipolistado == "atencionalusuario" || $tipolistado == "visualizacion")
                {
                ?>
                    <TR>
                        <TD >&nbsp;</TD>
                        <TD align="center"><INPUT type="text" name="numerodocumento" id="numerodocumento" size="10" value="<?php if ($_POST['numerodocumento']!=""){
                                echo $_POST['numerodocumento']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="nombre" id="nombre"  value="<?php if ($_POST['nombre']!=""){
                                echo $_POST['nombre']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="tipousuario" id="tipousuario" size="10"  value="<?php if ($_POST['tipousuario']!=""){
                                echo $_POST['tipousuario']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="destino" id="destino" size="15px" value="<?php if ($_POST['destino']!=""){
                                echo $_POST['destino']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="fecha" id="fecha" size="8px" value="<?php if ($_POST['fecha']!=""){
                                echo $_POST['fecha']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="estado" id="estado" size="8px" value="<?php if ($_POST['estado']!=""){
                                echo $_POST['estado']; } ?>"></TD>
                        <TD align="center">&nbsp;<input type="submit" name="Filtrar" value="Filtrar"></TD>
                    </TR>
                <?php
                }
                do { ?>
                
                <TR>
                    <TD align="center"><A id="apariencialink" 
                    <?php //if ($tipolistado == "atencionalusuario") { ?>
                            href="listaimpresa.php?idsolicitudquejareclamo=<?php echo $row_listado['idsolicitudquejareclamo'].
                            "&tipolistado=".$tipolistado; ?>"
                            <?php 
                            //}
                            /*else {
                            ?>
                            href="listaimpresa.php?idsolicitudquejareclamo=<?php echo $row_listado['idsolicitudquejareclamo']; ?>"
                            <?php } */?>>
                                            
                    <?php echo $row_listado['idsolicitudquejareclamo']; ?></A>
                    </TD>
                    <TD width="5%" align="center"><?php echo $row_listado['numerodocumentopersonaquejareclamo']; ?>&nbsp;
                    </TD>
                    <TD align="center"><?php echo $row_listado['nombre']; ?>&nbsp;
                    </TD>
                    <TD width="5%" align="center"><?php echo $row_listado['nombreusuarioquejareclamo']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_listado['dependencia_destino']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_listado['fechasolicitudquejareclamo']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_listado['nombreestadoquejareclamo']; ?>
                    </TD>
                    <TD align="justify"><?php echo $row_listado['descripcionestadoquejareclamo']; ?>
                    </TD>
                </TR>
                <?php 
                } while($row_listado = $listado->FetchRow());
                ?>                
    </table>

<?php
    }
    else {
        
            echo "<script language='javascript'> 
            alert ('La busqueda no encuentra registros en proceso, en atención y no acepto.')
            window.history.back();</script>";        
    }
}

function estadoquejareclamo ($idsolicitudquejareclamo)
{
    global $db;
    $query_estado = "SELECT d.idsolicitudquejareclamo, d.descripcionsolicitudquejareclamo, d.estadoorigen,
    e.nombreestadoquejareclamo as nombreestadoorigen, d.estadodestino, e2.nombreestadoquejareclamo as nombreestadodestino,
    d.fechadescripcionsolicitudquejareclamo, e2.codigoestadoquejareclamo
    FROM descripcionsolicitudquejareclamo d, estadoquejareclamo e, estadoquejareclamo e2
    where d.idsolicitudquejareclamo = '$idsolicitudquejareclamo' 
    and d.estadoorigen = e.codigoestadoquejareclamo
    and d.estadodestino = e2.codigoestadoquejareclamo
    order by d.fechadescripcionsolicitudquejareclamo";
    $estado= $db->Execute($query_estado);
    $totalRows_estado = $estado->RecordCount();
    $row_estado = $estado->FetchRow();
?>
    
    <table width="70%"  border="0" align="center" cellpadding="3" cellspacing="3">
        <TR align="center" >
            <TD colspan="4" align="center"><label id="labelresaltadogrande" >Estado Sugerencia</label>
            </TD>
        </TR>
        <TR id="trtitulogris">
            <TD align="center">Estado Inicial</TD>
            <TD align="center">Estado Actual</TD>
            <TD align="center">Fecha </TD>            
            <TD align="center">Seguimiento</TD>                    
            
        </TR>
        <?php do { ?>
        <TR>
        <TD align="left"><?php echo $row_estado['nombreestadoorigen']; ?>
            </TD>
            <TD align="left"><?php echo $row_estado['nombreestadodestino']; ?>
            </TD>
            <TD align="left"><?php echo $row_estado['fechadescripcionsolicitudquejareclamo']; ?>
            </TD>            
            <TD width="50%" style="text-align:justify;"><?php echo $row_estado['descripcionsolicitudquejareclamo']; ?>
            </TD>            
        </TR>
        <?php } while($row_estado = $estado->FetchRow()) ?>
        
    </table>
<?php
}

function modificarestado ($codigoestadoquejareclamo, $idsolicitudquejareclamo)
{
    global $db;

    $query_modificarestado = "SELECT codigoestadoquejareclamo, nombreestadoquejareclamo FROM estadoquejareclamo  
    where codigoestadoquejareclamo in (300, 400) ";
    $modificarestado= $db->Execute($query_modificarestado);
    $totalRows_modificarestado = $modificarestado->RecordCount();
    $row_modificarestado = $modificarestado->FetchRow();
    
?>
    <SCRIPT language="JavaScript" type="text/javascript">
    function confirmar() {
        if(confirm('¿Estás Seguro de Generar el Nuevo estado para esta solicitud?')) {
            document.getElementById('guardar').value='ok';
            document.form1.submit();
        }
    }
    </SCRIPT>
    <?php 
    $varguardar = 0;
        if (isset($_POST['guardar']) && $_POST['guardar'] != '') {
        if ($_POST['codigoestado']== 0){
            echo '<script language="JavaScript">alert("Seleccione el Estado a Cambiar")</script>';
            $varguardar = 1;
            }
        elseif ($_POST['seguimiento'] == '') {
            echo '<script language="JavaScript">alert("Digite la respuesta")</script>';
                    $varguardar = 1;
              }        
        elseif ($varguardar == 0) {
            
            $query_actualizar = "UPDATE solicitudquejareclamo SET codigoestadoquejareclamo = '".$_REQUEST['codigoestado']."'           
            where idsolicitudquejareclamo = '$idsolicitudquejareclamo'";
            $actualizar = $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            
            $query_generarestado = "INSERT INTO descripcionsolicitudquejareclamo (iddescripcionsolicitudquejareclamo, 
            idsolicitudquejareclamo, descripcionsolicitudquejareclamo, estadoorigen, estadodestino,
            fechadescripcionsolicitudquejareclamo)
            values (0,'$idsolicitudquejareclamo','{$_REQUEST['seguimiento']}',
            '{$codigoestadoquejareclamo}', '{$_REQUEST['codigoestado']}', now())";
            $generarestado = $db->Execute ($query_generarestado) or die("$query_generarestado".mysql_error());
            
            echo "<script language='javascript'>
            alert('!!Gracias!! El proceso se ha ejecutado correctamente')    
            window.history.back();
            </script>";
        }
    }   
    
    ?>
    <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
        <TR align="center" >
            <TD colspan="2" align="center"><label id="labelresaltadogrande" >Cambiar Estado Seguimiento</label>
            </TD>
        </TR>
        <TR id="trtitulogris">            
            <TD align="center"><LABEL id="labelasterisco">*</LABEL> Estado Actualización</TD>            
            <TD align="center"><LABEL id="labelasterisco">*</LABEL>Seguimiento</TD>                    
        </TR>        
        <TR>
            <TD align="center">
                <select name="codigoestado" id="codigoestado" >
                    <option value="">Seleccionar</option>
                    <?php do {?>
                        <option value="<?php echo $row_modificarestado['codigoestadoquejareclamo'];?>"
                        <?php
                        if($row_modificarestado['codigoestadoquejareclamo'] == $_POST['codigoestado']) {
                            echo "Selected";
                        } ?>>
                        <?php echo $row_modificarestado['nombreestadoquejareclamo'];?>
                    </option>
                <?php } while($row_modificarestado= $modificarestado->FetchRow())?>
                </select>
            </TD>
            <TD align="center"><TEXTAREA name="seguimiento" cols="30" rows="4"><?php if ($_POST['seguimiento']!=""){
                        echo $_POST['seguimiento']; } ?></TEXTAREA>
            </TD>
        </TR>
        <TR><TD align="center" colspan="2">
                <INPUT type="hidden" value="" name="guardar" id="guardar">
                <INPUT type="button" value="Enviar Respuesta" onclick="return confirmar()">
            </TD>
        </TR>
    </table>
<?php
}

function inforequerimiento ($idsolicitudquejareclamo)
{
                global $db;

                $query_listado = "SELECT s.idsolicitudquejareclamo, p.numerodocumentopersonaquejareclamo, concat(p.nombrespersonaquejareclamo, ' ', p.apellidospersonaquejareclamo)as nombre, u.nombreusuarioquejareclamo, d.nombredependenciaquejareclamo as dependencia_destino, a.nombreaspectotipoasuntoquejareclamo, s.fechasolicitudquejareclamo, s.comentariosolicitudquejareclamo
                FROM usuarioquejareclamo u, personaquejareclamo p, solicitudquejareclamo s, aspectotipoasuntoquejareclamo a, dependenciaquejareclamo d
                where s.idsolicitudquejareclamo= '$idsolicitudquejareclamo'
                and s.idpersonaquejareclamo = p.idpersonaquejareclamo
                and u.codigousuarioquejareclamo= p.codigousuarioquejareclamo
                and s.codigoaspectotipoasuntoquejareclamo = a.codigoaspectotipoasuntoquejareclamo
                and d.iddependenciaquejareclamo=s.iddependenciaquejareclamo";
                $listado= $db->Execute($query_listado);
                $totalRows_listado = $listado->RecordCount();
                $row_listado = $listado->FetchRow();



                if($totalRows_listado >0){
                    ?><div align="center" >
                        <A href="consulta.php" id="aparencialinknaranja">Inicio</A>
                    </div><br>
                    <table width="70%"  border="0" align="center" cellpadding="3" cellspacing="3">
                        <TR align="center" >
                            <TD colspan="8" align="center"><label id="labelresaltadogrande" >Tiquete</label>
                            </TD>
                        </TR>
                    </table>
                    <table width="80%"  border="1" align="center" cellpadding="3" cellspacing="3">
                        <TR id="trtitulogris">
                            <TD align="center">Número Tiquete</TD>
                            <TD width="5%" align="center">Documento Usuario</TD>
                            <TD align="center">Nombre Usuario</TD>
                            <TD align="center">Tipo Usuario</TD>
                            <TD align="center">Destino Sugerencia</TD>
                            <TD align="center">Fecha Sugerencia</TD>
                            <TD align="center">Descripción Sugerencia</TD>
                        </TR>
                        <?php   do { ?>
                        <TR>
                            <TD align="center"><?php echo $row_listado['idsolicitudquejareclamo']; ?>
                            </TD>
                            <TD width="5%" align="center"><?php echo $row_listado['numerodocumentopersonaquejareclamo']; ?>&nbsp;
                            </TD>
                            <TD align="center"><?php echo $row_listado['nombre']; ?>&nbsp;
                            </TD>
                            <TD width="5%" align="center"><?php echo $row_listado['nombreusuarioquejareclamo']; ?>
                            </TD>
                            <TD align="center"><?php echo $row_listado['dependencia_destino']; ?>
                            </TD>
                            <TD align="center"><?php echo $row_listado['fechasolicitudquejareclamo']; ?>
                            </TD>
                            <TD align="justify"><?php echo $row_listado['comentariosolicitudquejareclamo']; ?>
                            </TD>
                        </TR>
                        <?php
                        } while($row_listado = $listado->FetchRow());
                        ?>
                    </table>
<?php
                }
                else {
                    echo "<script language='javascript'>
                        alert ('La busqueda no encuentra registros en proceso, en atención y no acepto.')
                        window.history.back();</script>";
                    }
}
?>
