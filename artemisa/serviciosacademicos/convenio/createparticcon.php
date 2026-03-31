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
    $entity = new ManagerEntity("participante");
    $entity->sql_where = "idsiq_participante = ".str_replace('row_','',$_REQUEST['id'])."";
  //  $entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
 //   print_r($data);
}



?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Participantes</title>  
        <script>
        $.ajaxSetup({ cache:false });                     
	$(function() {
              $( "#fechanacimiento" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        maxDate:"<?php echo date('Y-m-d') ?>"
		});
                
	});
	</script>
    </head>    
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="participante" />
            <?php
            if($data['idsiq_participante']!="")
                echo '<input type="hidden" name="idsiq_participante" value="'.$data['idsiq_participante'].'">';
            ?>
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            
            <fieldset>
                <legend>Informaci&oacute;n del Participante</legend>                
                <table border="0">                    
                    <tbody>
                        <tr>
                            <td><label for="apellidoparticipante"><span style="color:red; font-size:9px">(*)</span>Apellido</label></td>
                            <td><input type="text" name="apellidoparticipante" id="apellidoparticipante" title="Apellido del Participante" maxlength="120" placeholder="Apellido del del Participante" autocomplete="off" tabindex="1" value="<?php echo $data['apellidoparticipante']; ?>"  /></td>
                            <td></td>
                            <td><label for="nombreparticipante"><span style="color:red; font-size:9px">(*)</span>Nombre</label></td>
                            <td><input type="text" name="nombreparticipante" id="nombreparticipante" title="Nombre del del Participante" maxlength="120" placeholder="Nombre del Participante" autocomplete="off" tabindex="2" value="<?php echo $data['nombreparticipante']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td><label for="idtipodocumento">Tipo Documento</label></td>
                            <td>
                                <?php
                                        $query_tipo_documento = "SELECT nombredocumento, tipodocumento FROM documento order by 1";
                                        $reg_tipo_documento = $db->Execute ($query_tipo_documento);
                                        echo $reg_tipo_documento->GetMenu2('idtipodocumento',$data['idtipodocumento'],false,false,1,' id=idtipodocumento tabindex="3" ');
                                    ?>
                            </td>
                            <td></td>
                            <td><label for="numerodocumento"><span style="color:red; font-size:9px">(*)</span>No Documento</label></td>
                            <td><input type="text" name="numerodocumento" id="numerodocumento" title="N° del Documento" maxlength="120" placeholder="N° del Documento" autocomplete="off" tabindex="4" value="<?php echo $data['numerodocumento'];?>"  /></td>
                        </tr>
                        <tr>
                            <td><label for="fechanacimiento">Fecha de Nacimiento</label></td>
                            <td><input type="text" name="fechanacimiento" id="fechanacimiento" title="Fecha de Nacimiento" maxlength="120" placeholder="Fecha de Nacimiento" autocomplete="off" tabindex="5" value="<?php echo $data['fechanacimiento'];?>"  /></td>
                            <td></td>
                            <td><label for="idpaisnacimiento">Pais de Nacimiento</label></td>
                            <td>
                                   <?php
                                        $query_pais = "SELECT nombrepais, idpais FROM pais";
                                        $reg_pais = $db->Execute ($query_pais);
                                        echo $reg_pais->GetMenu2('idpaisnacimiento',$data['idpaisnacimiento'],false,false,1,' id=idpaisnacimiento tabindex="6"');
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="iddepartamentonacimiento">Departamento de Nacimiento</label></td>
                            <td>
                                   <?php
                                        $query_departamento = "SELECT nombredepartamento, iddepartamento FROM departamento order by 1";
                                        $reg_departamento = $db->Execute ($query_departamento);
                                        echo $reg_departamento->GetMenu2('iddepartamentonacimiento',$data['iddepartamentonacimiento'],false,false,1,' id=iddepartamentonacimiento tabindex="7" ');
                                    ?>
                            </td>
                            <td></td>
                            <td><label for="idciudadnacimiento">Ciudad de Nacimiento</label></td>
                            <td>
                                   <?php
                                        $query_tipo_ciudad_naci = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                                        $reg_tipociudad_naci = $db->Execute ($query_tipo_ciudad_naci);
                                        echo $reg_tipociudad_naci->GetMenu2('idciudadnacimiento',$data['idciudadnacimiento'],false,false,1,' id=idciudadnacimiento tabindex="8" ');
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="idestadocivil">Estado Civil</label></td>
                            <td>
                                   <?php
                                        $query_tipo_estado = "SELECT nombreestadocivil, idestadocivil FROM estadocivil order by 1";
                                        $reg_tipo_estado = $db->Execute ($query_tipo_estado);
                                        echo $reg_tipo_estado->GetMenu2('idestadocivil',$data['idestadocivil'],false,false,1,' id=idestadocivil tabindex="9" ');
                                    ?>
                            </td>
                            <td></td>
                            <td><label for="codigogenero">Genero</label></td>
                            <td>
                                   <?php
                                        $query_tipo_genero = "SELECT nombregenero, codigogenero FROM genero order by 1";
                                        $reg_tipo_genero = $db->Execute ($query_tipo_genero);
                                        echo $reg_tipo_genero->GetMenu2('codigogenero',$data['codigogenero'],false,false,1,' id=codigogenero tabindex="10"');
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="idciudadrecidencia">Ciudad de Residencia</label></td>
                            <td>
                                   <?php
                                        $query_tipo_ciudad_res = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                                        $reg_tipociudad_res = $db->Execute ($query_tipo_ciudad_res);
                                        echo $reg_tipociudad_res->GetMenu2('idciudadrecidencia',$data['idciudadrecidencia'],false,false,1,' id=idciudadrecidencia tabindex="11"');
                                    ?>
                            </td>
                            <td></td>
                            <td><label for="direccionparticipante">Dirección<label></td>
                            <td><input type="text" name="direccionparticipante" id="direccionparticipante" title="Direccion" maxlength="120" placeholder="Direccion" autocomplete="off" tabindex="12" value="<?php echo $data['direccionparticipante']; ?>"  /></td>
                        </tr>
                        <tr>
                            <td><label for="telefonorecidenciaparticipante">Telefono</label></td>
                            <td><input type="text" name="telefonorecidenciaparticipante" id="telefonorecidenciaparticipante" title="Telefono" maxlength="120" placeholder="Telefono" autocomplete="off" tabindex="13" value="<?php echo $data['telefonorecidenciaparticipante']; ?>"  /></td>
                           <td></td>
                            <td><label for="emailparticipante">Email</label></td>
                            <td><input type="text" name="emailparticipante" id="emailparticipante" title="Email" maxlength="120" placeholder="Email" autocomplete="off" tabindex="14" value="<?php echo $data['emailparticipante']; ?>"  /></td>
                            
                        </tr>
                        <tr>
                            <td><label for="profesion">Profesion</label></td>
                            <td><input type="text" name="profesion" id="profesion" title="Profesion" maxlength="120" placeholder="Profesion" autocomplete="off" tabindex="15" value="<?php echo $data['profesion']; ?>"  /></td>
                            <td></td>
                            <td><label for="cargo">Cargo</label></td>
                            <td><input type="text" name="cargo" id="cargo" title="Cargo" maxlength="120" placeholder="Cargo" autocomplete="off" tabindex="16" value="<?php echo $data['cargo']; ?>"  /></td>
                            
                        </tr>
                    </tbody>
                </table> 
            </fieldset>
            <span style="color:red; font-size:9px">* Son campos obligatorios</span>
        </form>
        <div id="searh">
        </div>
        
    </body>
</html>