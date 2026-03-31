<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
error_reporting(0);
require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['id']){
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("anexo");
    //print_r($entity);
    $entity->sql_where = "idsiq_anexo = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
    //print_r($data);    
    $ob_usuario = $db->Execute("select nombres,apellidos from usuario where idusuario = '".$data['idusuario']."'");
    $ob_usuario = $ob_usuario->FetchRow();
    $ob_convenio = $db->Execute("select nombreconvenio,idsiq_institucionconvenio from siq_convenio where idsiq_convenio = '".$data['idsiq_convenio']."'");
    $ob_convenio = $ob_convenio->FetchRow();        
    $ob_institucion = $db->Execute ("select nombreinstitucion from siq_institucionconvenio where idsiq_institucionconvenio = '".$ob_convenio['idsiq_institucionconvenio']."'");
    $ob_institucion = $ob_institucion->FetchRow();
    
}else{
    if($_REQUEST['idconvenio']>0){
        $ob_usuario = $db->Execute("select nombres,apellidos from usuario where idusuario = '".$_SESSION['userid']."'");
        $ob_usuario = $ob_usuario->FetchRow();
        $ob_convenio = $db->Execute("select nombreconvenio,idsiq_institucionconvenio from siq_convenio where idsiq_convenio = '".$_REQUEST['idconvenio']."'");
        $ob_convenio = $ob_convenio->FetchRow();        
        $ob_institucion = $db->Execute ("select nombreinstitucion from siq_institucionconvenio where idsiq_institucionconvenio = '".$ob_convenio['idsiq_institucionconvenio']."'");
        $ob_institucion = $ob_institucion->FetchRow();
    }
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

        <title>Convenios</title>                   
    </head>    
    <body>
        <form action="processfile.php" method="post" id="form_test" enctype="multipart/form-data">
            <input type="hidden" name="entity" value="anexo" />
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <input type="hidden" name="idsiq_convenio" value="<?php echo $_REQUEST['idconvenio'];?>" />        
            <input type="hidden" name="idusuario" value="<?php echo $_SESSION['userid'];?>" />
            <?php
            if($data['idsiq_anexo']!="")
                echo '<input type="hidden" name="idsiq_anexo" value="'.$data['idsiq_anexo'].'">';
            ?>
            <fieldset>
                <legend>Documentaci&oacute;n Anexa del Convenio</legend>
                <table border="0">                    
                    <tbody>
                        <tr>
                            <td><label for="nombreconvenio">Nombre del Convenio:</label></td>
                            <td colspan="4"><input type="text" name="nombreconvenio" id="nombreconvenio" title="Nombre del Convenio" maxlength="120" placeholder="Nombre del Convenio" autocomplete="off" value="<?php echo $ob_convenio['nombreconvenio'];?>" readonly/>
                            </td>
                            <td colspan="2"><label for="idsiq_tipoanexo">Tipo de Anexo:</label></td>
                            <td colspan="2"><?php
                                $query_tipo_anexo = "SELECT nombretipoanexo,idsiq_tipoanexo FROM siq_tipoanexo order by 1";
                                $reg_tipoanexo = $db->Execute ($query_tipo_anexo);
                                echo $reg_tipoanexo->GetMenu2('idsiq_tipoanexo',$data['idsiq_tipoanexo'],false,false,1,' ');?></td>
                        </tr>
                        <tr>
                            <td><label for="idsiq_tipoconvenio">Instituci&oacute;n:</label></td>
                            <td colspan="4"><input type="text" name="nombreinstitucion" id="nombreinstitucion" title="Nombre de Instituci&oacute;n:" maxlength="120" placeholder="Nombre de Instituci&oacute;n" autocomplete="off" value="<?php echo $ob_institucion['nombreinstitucion']?>" readonly/>
                            <td colspan="2"><label for="fecharegistro">Fecha de Registro:</label></td>
                            <td colspan="2"><input type="text" name="fecharegistro" size="12" id="fecharegistro" title="Fecha de Registro" maxlength="12" placeholder="Fecha de Registro:" autocomplete="off" value="<?php echo $data['fecharegistro']?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="fechamodificacion">Fecha de Modificaci&oacute;n:</label></td>                            
                            <td colspan="4"><input type="text" name="fechamodificacion" id="fechamodificacion" title="Ultima Fecha de Modificaci&oacute;n" maxlength="12" size="12" placeholder="Ultima Fecha de Modificaci&oacute;n" autocomplete="off" value="<?php echo date('Y-m-d');?>" readonly/></td>
                            <td colspan="2"><label for="nombreusuario">Usuario que Registra:</label></td>
                            <td colspan="2"><input type="text" name="nombreusuario" size="18" id="nombreusuario" title="Usuario que Registra" maxlength="64" placeholder="Usuario que Registra" autocomplete="off" value="<?php echo $ob_usuario['nombres']."-".$ob_usuario['apellidos'];?>" readonly /></td>
                        </tr>
                        <tr>
                            <td><label for="idsiq_juridico">Jurídico:</label></td>
                            <td colspan="4"><?php
                                $query_juridico = "SELECT nombrejuridico, idsiq_juridico FROM siq_juridico order by 1";
                                $reg_juridico = $db->Execute ($query_juridico);
                                echo $reg_juridico->GetMenu2('idsiq_juridico',$data['idsiq_juridico'],false,false,1,' ');?></td>
                            <td colspan="2"><label for="idsiq_estadoarchivo">Estado del Archivo:</label></td>
                            <td colspan="2"><?php
                                $query_estado_anexo = "SELECT nombreestado,idsiq_estadoarchivo FROM siq_estadoarchivo order by 1";
                                $reg_estadoanexo = $db->Execute ($query_estado_anexo);
                                echo $reg_estadoanexo->GetMenu2('idsiq_estadoarchivo',$data['idsiq_estadoarchivo'],false,false,1,' ');?></td>
                        </tr>
                        <tr>
                            <td><label for="nombrearchivo">Nombre del Archivo:</label></td>
                            <td colspan="4"><input type="text" name="nombrearchivo" size="24" id="nombrearchivo" title="Nombre del Archivo" maxlength="64" placeholder="Nombre del Archivo" autocomplete="off" value="<?php echo $data['nombrearchivo']?>"  /></td>
                            <td colspan="2"><label for="anio">A&ntilde;o de Creaci&oacute;n:</label></td>
                            <td colspan="2">
                                <select name="anio">
                                <?php                                
                                $anilo=2009;
                                for($i=0;$i<10;$i++){
                                    echo "<option value='".($anilo+$i)."'>".($anilo+$i)."</option>";
                                }                                
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="rutadelarchivo">Ruta de Almacenamiento:</label></td>
                            <td colspan="8"><input type="text" name="rutadelarchivo" id="rutadelarchivo" title="Ruta del Archivo" maxlength="120" placeholder="Ruta del Archivo" autocomplete="off" value="<?php echo $data['rutadelarchivo']?>" readonly /></td>
                        </tr>
                        <tr>
                            <td><label for="observacion">Observaci&oacute;n:</label></td>
                            <td colspan="8"><textarea name="observacion" rows="5" cols="60"><?php echo $data['observacion']?></textarea></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="archivo" value="100000" />
                                Archivo: <input type="file" name="_FILES" />
                            </td>    
                        </tr>
                    </tbody>
                </table> 
            </fieldset>
        </form>        
    </body>
        
</html>
