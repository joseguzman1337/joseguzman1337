<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
require_once('../Connections/salasiq.php');

$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
if($_REQUEST['id']){
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("institucionconvenio");
    $entity->sql_where = "idsiq_institucionconvenio = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        
        <title>Instituciones de convenios</title>   
        <script>
          $.ajaxSetup({ cache:false }); 
       </script>
    </head>            
    <body>
        <form action="save.php" method="post" id="form_test">
            <?php
            if($data['idsiq_institucionconvenio']!="")
                echo '<input type="hidden" name="idsiq_institucionconvenio" value="'.$data['idsiq_institucionconvenio'].'">';
            ?>            
            <input type="hidden" name="entity" value="institucionconvenio">
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <fieldset>
                <legend>Informaci&oacute;n del la Instituci&oacute;n-Convenio</legend>
                <table border="0">
                    <tr>
                        <td>
                            <label for="nombreinstitucion"><span style="color:red; font-size:9px">(*)</span>Nombre de la instituci&oacute;n:</label>
                        </td>
                        <td>
                            <input type="text" name="nombreinstitucion" id="nombreinstitucion" title="Nombre de la instituci&oacute;n" maxlength="120" placeholder="Nombre de la instituci&oacute;n" autocomplete="off" tabindex="1" value="<?php echo $data['nombreinstitucion']?>" />
                        </td>
                        <td>
                            <label for="nit">Nit:</label> 
                        </td>    
                        <td>    
                            <input type="text" name="nit" id="nit" title="Nit" maxlength="14" placeholder="Nit" autocomplete="off" tabindex="2" value="<?php echo $data['nit']?>"/>
                        </td>                        
                    </tr>   
                    <tr>
                        <td>
                            <label for="direccion">Direcci&oacute;n:</label> 
                        </td>
                        <td>
                            <input type="text" name="direccion" id="direcccion" title="Direcci&oacute;n" maxlength="120" size="25" placeholder="Direcci&oacute;n" autocomplete="off" tabindex="3" value="<?php echo $data['direccion']?>"/>
                        </td>
                        <td>
                            <label for="nit">Tel&eacute;fono:</label>
                        </td>
                        <td>
                            <input type="text" name="telefono" id="Telefono" title="Tel&eacute;fono" maxlength="22" placeholder="Tel&eacute;fono" autocomplete="off" tabindex="4" value="<?php echo $data['telefono']?>" />
                        </td>                        
                    </tr>
                    <tr>
                            <td>
                            <label for="idsiq_tipoinstitucion">Tipo de Instituci&oacute;n:</label> 
                        </td>    
                        <td>
                            <?php
                                $query_tipo_institucion = "SELECT nombretipoinstitucion,idsiq_tipoinstitucion FROM siq_tipoinstitucion order by 1";
                                $reg_tipoinst = $db->Execute ($query_tipo_institucion);
                                echo $reg_tipoinst->GetMenu2('idsiq_tipoinstitucion',$data['idsiq_tipoinstitucion'],false,false,1,' tabindex="6" ');
                            ?>                            
                        </td>    
                         <td>
			      <label for="nit">Teléfono 2:</label>
                         </td>
                        <td>
			      <input type="text" name="telefonodos" id="telefonodos" title="Tel&eacute;fono" maxlength="22" placeholder="Tel&eacute;fono" autocomplete="off" tabindex="4" value="<?php echo $data['telefonodos']?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nombreinstitucionsuscribe">Nombre de la instituci&oacute;n que suscribe:</label> 
                        </td>
                        <td>
                            <input type="text" name="nombreinstitucionsuscribe" size="35" id="nombreinstitucionsuscribe" title="Nombre de la instituci&oacute;n que suscribe:" maxlength="120" tabindex="7" placeholder="Nombre de la instituci&oacute;n que suscribe:" autocomplete="off" value="<?php echo $data['nombreinstitucionsuscribe']?>"/>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            <label for="representantelegal">Representante legal:</label> 
                        </td>
                        <td>
                            <input type="text" name="representantelegal" id="representantelegal" title="Representante legal" maxlength="120" placeholder="Representante legal" autocomplete="off" tabindex="8" value="<?php echo $data['representantelegal']?>" />
                        </td>
                        <td>
                            <label for="identificacion">Identificaci&oacute;n:</label> 
                        </td>
                        <td>
                            <input type="text" name="identificacion" id="identificacion" title="Identificaci&oacute;n" maxlength="14" placeholder="Identificaci&oacute;n" autocomplete="off" tabindex="9" value="<?php echo $data['identificacion']?>" />
                        </td>                       
                    </tr>
                    <tr>
                        <td>
                            <label for="emailrpresentante">Email del representante:</label> 
                        </td>
                        <td>
                            <input type="text" name="emailrpresentante" id="emailrpresentante" title="Email del representante" maxlength="120" placeholder="Email del representante" autocomplete="off" tabindex="10" value="<?php echo $data['emailrpresentante']?>" />
                        </td>                        
                        
                        <td>
                            <label for="ciudadexpedicion">Ciudad Expedición:</label> 
                        </td>
                        <td>
                            <input type="text" name="ciudadexpedicion" id="ciudadexpedicion" title="Ciudad Expedición" maxlength="30" placeholder="Ciudad Expedición" autocomplete="off" tabindex="10" value="<?php echo $data['ciudadexpedicion']?>" />
                        </td>                        
                        
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend>Persona de Contacto</legend>
                <table>
                <tr>
                    <td>Nombre:
                    </td>
                    <td><input type="text" name="nombrecontacto" id="nombrecontacto" title="Nombre del Contacto" maxlength="120" placeholder="Nombre del Contacto" autocomplete="off" tabindex="11" value="<?php echo $data['nombrecontacto']?>" />
                    </td>
                    <td>Telefono:
                    </td>
                    <td><input type="text" name="telefonocontacto" id="telefonocontacto" title="Telefono del Contacto" maxlength="22" placeholder="Telefono del Contacto" autocomplete="off" tabindex="12" value="<?php echo $data['telefonocontacto']?>" />
                    </td>
                </tr>                
                <tr>
                    <td>Cargo:
                    </td>
                    <td><input type="text" name="cargocontacto" id="cargocontacto" title="Cargo del contacto"  placeholder="Cargo del contacto" autocomplete="off" tabindex="12" value="<?php echo $data['cargocontacto']?>" />
                    </td>
                   <td>
                            <label for="email">Email del Contacto:</label>
                        </td>
                        <td colspan="2">
                            <input type="email" name="email" id="email" title="Correo electr&oacute;nico" maxlength="120" placeholder="Correo electr&oacute;nico" autocomplete="off" tabindex="5" value="<?php echo $data['email']?>" />
                        </td>

                </tr>
                <tr>
                    <td>&nbsp;
                    </td>
                    <td>&nbsp;
                    </td>
                   <td>
                            <label for="emailcontactodos">Email del Contacto 2:</label>
                        </td>
                        <td colspan="2">
                            <input type="email" name="emailcontactodos" id="emailcontactodos" title="Correo Electr&oacute;nico Dos" maxlength="120" placeholder="Correo Electr&oacute;nico Dos" autocomplete="off" tabindex="5" value="<?php echo $data['emailcontactodos']?>" />
                        </td>

                </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend>Persona de Contacto Universidad</legend>
                <table>
                <tr>
                    <td>Nombre:
                    </td>
                    <td><input type="text" name="nombrecontactobosque" id="nombrecontactobosque" title="Nombre del Contacto Universidad" maxlength="120" placeholder="Nombre del Contacto Universidad" autocomplete="off" tabindex="11" value="<?php echo $data['nombrecontactobosque']?>" />
                    </td>
                    <td>Telefono:
                    </td>
                    <td><input type="text" name="telefonocontactobosque" id="telefonocontactobosque" title="Telefono del Contacto Universidad" maxlength="22" placeholder="Telefono del Contacto Universidad" autocomplete="off" tabindex="12" value="<?php echo $data['telefonocontactobosque']?>" />
                    </td>
                </tr>                
                <tr>
                    <td>Cargo:
                    </td>
                    <td><input type="text" name="cargocontactobosque" id="cargocontactobosque" title="Cargo del contacto Universidad"  placeholder="Cargo del contacto Universidad" autocomplete="off" tabindex="12" value="<?php echo $data['cargocontactobosque']?>" />
                    </td>
                   <td>
                            <label for="email">Email:</label>
                        </td>
                        <td colspan="2">
                            <input type="email" name="emailcontactobosque" id="emailcontactobosque" title="Correo Electr&oacute;nico" maxlength="120" placeholder="Correo Electr&oacute;nico" autocomplete="off" tabindex="5" value="<?php echo $data['emailcontactobosque']?>" />
                        </td>
                </tr>
                <tr>
                    <td>&nbsp;
                    </td>
                    <td>&nbsp;
                    </td>
                   <td>
                            <label for="emailcontactobosquedos">Email 2:</label>
                        </td>
                        <td colspan="2">
                            <input type="email" name="emailcontactobosquedos" id="emailcontactobosquedos" title="Correo Electr&oacute;nico Dos" maxlength="120" placeholder="Correo Electr&oacute;nico Dos" autocomplete="off" tabindex="5" value="<?php echo $data['emailcontactobosquedos']?>" />
                        </td>

                </tr>
                </table>
            </fieldset>
            <span style="color:red; font-size:9px">* Son campos obligatorios</span>
        </form>
    </body>
</html>