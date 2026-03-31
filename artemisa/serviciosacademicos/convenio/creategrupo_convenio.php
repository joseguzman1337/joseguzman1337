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
    $entity = new ManagerEntity("grupoconvenio");
    $entity->sql_where = "idsiq_grupoconvenio = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
    //print_r($data);
}

if($_REQUEST['idsiq_detalle_convenio']){    
    require_once '../class/ManagerEntity.php';
    $entity2 = new ManagerEntity("detalle_convenio");
    $entity2->sql_where = "idsiq_detalle_convenio = ".$_REQUEST['idsiq_detalle_convenio']."";
   // $entity2->debug = true;
    $data2 = $entity2->getData();
    $data2 = $data2[0];
   // print_r($data2);
    //echo "<br>";
}

if (!empty($data2['idsiq_convenio'])){
    require_once '../class/ManagerEntity.php';
    $entity3 = new ManagerEntity("convenio");
    $entity3->sql_where = "idsiq_convenio = ".$data2['idsiq_convenio']."";
   // $entity3->debug = true;
    $data3 = $entity3->getData();
    $data3 = $data3[0];
    //print_r($data3);
    //echo "<br>";
}

if($data['iddocente']>0){    
    require_once '../class/ManagerEntity.php';
    $entity5 = new ManagerEntity("docente");
    $entity5->prefix="";
    $entity5->sql_where = "iddocente= ".$data['iddocente']."";
    //$entity5->debug = true;
    $data5 = $entity5->getData();
    $data5 = $data5[0];
}


?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Convenios</title>                   
        <script>
            $(function() {
                $('#numeroparticipante').numeric();
            });  
        </script>
    </head>    
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="grupoconvenio" />
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <?php
            if($data['idsiq_grupoconvenio']!="")
                echo '<input type="hidden" name="idsiq_grupoconvenio" value="'.$data['idsiq_grupoconvenio'].'">';
            ?>
            <input type="hidden" name="iddocente" id="iddocente" value="<?php echo $data['iddocente'] ?>" />
             <input type="hidden" name="idsiq_detalle_convenio" id="idsiq_detalle_convenio" value="<?php echo $data2['idsiq_detalle_convenio']?>">
            <fieldset>
                <legend>Informaci&oacute;n del Grupo - Convenio</legend>                
                <table border="0">                    
                    <tbody>
                       <tr>
                            <td><label for="codigogrupo"><span style="color:red; font-size:9px">(*)</span>Código Grupo:</label></td>
                            <td><input type="text" name="codigogrupo" id="codigogrupo" title="Código Grupo" maxlength="120" tabindex="1" placeholder="Código Grupo" autocomplete="off" value="<?php echo $data['codigogrupo']?>" /></td>
                            <td></td>
                            <td><label for="convenio">Convenio:</label></td>
                            <td><input type="text" name="convenio" id="convenio" title="Convenio" maxlength="120" placeholder="Convenio" tabindex="2" autocomplete="off" value="<?php echo $data3['nombreconvenio']?>" readonly /></td>
                        <tr>
                            <td><label for="detalleconvenio">Detalle Convenio:</label></td>
                            <td><input type="text" name="detalleconvenio" id="detalleconvenio" title="Detalle Convenio" maxlength="120" tabindex="3" placeholder="Detalle Convenio" autocomplete="off" value="<?php echo $data2['numeroconvenio']?>" readonly /></td>
                            <td></td>
                            <td><label for="numeroparticipante"><span style="color:red; font-size:9px">(*)</span>Numero Max de Participantes:</label></td>
                            <td><input type="text" name="numeroparticipante" id="numeroparticipante" title="Numero de Participantes" tabindex="4" maxlength="120" placeholder="Numero de Participantes" autocomplete="off" value="<?php echo $data['numeroparticipante']?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="nombreparticipante"><span style="color:red; font-size:9px">(*)</span>Docente:</label></td>
                            <td>
                               <input type="text" name="nombredocente" id="nombredocente" title="Nombre del Docente" maxlength="250" tabindex="5" placeholder="Nombre del Docente" autocomplete="off" value="<?php echo $data5['nombredocente'].' '.$data5['apellidodocente']?>" readonly/>
                           </td>
                            <td width="10%"><span><img id="remotejsonp" src="img/iconoLupa.png" width="15px" heigth="15px"/></span></td>
                            </td>
                              <td><label for="codigoperiodo">Periodo Academico:</label></td>
                            <td>
                                 <?php
                                        $query_codigoperiodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc limit 5";
                                        $reg_codigoperiodo= $db->Execute ($query_codigoperiodo);
                                        echo $reg_codigoperiodo->GetMenu2('codigoperiodo',$data['codigoperiodo'],false,false,1,' tabindex="6" ');
                                    ?>
                            </td>
                        </tr>
                        </tr>
                        <tr>
                            <td><label for="descripcion">Descripción:</label></td>
                            <td>
                            <input type="text" name="descripcion" id="descripcion" title="Descripción" maxlength="120" tabindex="7" placeholder="Descripción" autocomplete="off" value="<?php echo $data['descripcion']; ?>"  />   
                            </td>
                            <td>
                            </td>
                            <td></td>                            
                        </tr>
                    </tbody>
                </table> 
            </fieldset>
             <span style="color:red; font-size:9px">* Son campos obligatorios</span>
        </form>
       
        <div id="searh">
        </div>
        
    </body>
    <script>  
        
         function Popup(){ 
            if (window.showModalDialog) {
                var iddata = window.showModalDialog("lookupdocente.php","name","dialogWidth:555px;dialogHeight:250px");
            } else {
            iddata = window.open('lookupdocente.php','name','height=255,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
            }
           // alert(val(iddata.id));
            nom=iddata.nombredocente;
            app=iddata.apellidodocente;
            $("#nombredocente").val(nom+' '+app);
            $("#iddocente").val(iddata.iddocente);
        }
        
                     
        $("#remotejsonp").click( function (){
            Popup();
            return false;            
        });
        
 

        </script> 
</html>