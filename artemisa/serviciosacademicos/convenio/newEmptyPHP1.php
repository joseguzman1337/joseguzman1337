<?php
header( 'Content-type: text/html; charset=ISO-8859-1' );
//error_reporting(0);
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
    <head>
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://raw.github.com/gist/826bff2445c8533dd7fc/797734455959ef27796b6770c95a7b39049ae6e9/AjaxUpload.2.0.min.js"></script>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />        
        <title>Convenios</title>      
        <style>
    #upload_button {
    width:120px;
    height:35px;
    text-align:center;
    /*background-image:url(boton.png);*/
    color:#CCCCCC;
    font-weight:bold;
    padding-top:15px;
    margin:auto;
} 
</style>
        <script language="javascript">
//$(document).ready(function(){
//    var button = $('#upload_button'), interval;
//    new AjaxUpload('#upload_button', {
//        action: 'uploadify.php',
//        onSubmit : function(file , ext){
//        if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
//            // extensiones permitidas
//            alert('Error: Solo se permiten imagenes');
//            // cancela upload
//            return false;
//        } else {                      
//            button.text('Uploading');
//            this.disable();
//        }
//        },
//        onComplete: function(file, response){
//            button.text('Upload');
//            // habilito upload button                       
//            this.enable();          
//            // Agrega archivo a la lista
//            $('#lista').appendTo('.files').text(file);
//        }   
//    });
//});
</script>
    </head>
    <body>
        <form enctype="multipart/form-data" action="flash_upload.php" method="POST" id="form_test">
            <input type="hidden" name="entity" value="anexo" />
            <input type="hidden" name="idsiq_convenio" value="<?php echo $_REQUEST['idconvenio'];?>" />        
            <input type="hidden" name="idusuario" value="<?php echo $_SESSION['userid'];?>" />
            <?php
            if($data['idsiq_anexo']!="")
                echo '<input type="hidden" name="idsiq_anexo" value="'.$data['idsiq_anexo'].'">';
            ?>
            <fieldset>
                <legend>Documentaci&oacute;n Anexa del Convenio</legend>
                <table>
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
                            <td>&nbsp;</td>
                            <td colspan="4">&nbsp;</td>
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
                            <td colspan="8"><textarea name="observacion" rows="5" cols="60"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="9">                            
                                <div id="upload_button">Upload</div>
                                <ul id="lista">
                                </ul>  
                           </td>
                        </tr>
                    </tbody>                    
                </table> 
            </fieldset>
        </form>
    </body>
</html>
