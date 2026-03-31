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
    $entity = new ManagerEntity("detalle_participante");
    $entity->sql_where = "idsiq_detalle_participante = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
    
}
//echo $_REQUEST['idsiq_detalle_convenio'].'ok';
if($_REQUEST['idsiq_detalle_convenio']){    
    require_once '../class/ManagerEntity.php';
    $entity2 = new ManagerEntity("detalle_convenio");
    $entity2->sql_where = "idsiq_detalle_convenio = ".$_REQUEST['idsiq_detalle_convenio']."";
   // $entity2->debug = true;
    $data2 = $entity2->getData();
    $data2 = $data2[0];
}

if($data['idsiq_participante']>0){    
    require_once '../class/ManagerEntity.php';
    $entity3 = new ManagerEntity("participante");
    $entity3->sql_where = "idsiq_participante = ".$data['idsiq_participante']."";
   // $entity3->debug = true;
    $data3 = $entity3->getData();
    $data3 = $data3[0];
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Convenios</title>                   
    </head>    
    <script>
    $.ajaxSetup({ cache:false }); 
    </script>
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="detalle_participante" />
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <?php
            if($data['idsiq_detalle_participante']!="")
                echo '<input type="hidden" name="idsiq_detalle_participante" value="'.$data['idsiq_detalle_participante'].'">';
            ?>
            <input type="hidden" name="idsiq_participante" id="idsiq_participante" value="<?php echo $data['idsiq_participante'] ?>" />
             <input type="hidden" name="idsiq_detalle_convenio" value="<?php echo $data2['idsiq_detalle_convenio']?>">
            <fieldset>
                <legend>Informaci&oacute;n del Detalle - Participante</legend>                
                <table>                    
                    <tbody>
                        <tr>
                            <td><label for="nombreparticipante"><span style="color:red; font-size:9px">(*)</span>Nombre Participante:</label></td>
                            <td>
                                <button id="remotejsonp" class="DTTT_button DTTT_button_text DTTT_disabled"><span>Buscar</span></button>
                                <input type="text" name="nombreparticipante" id="nombreparticipante" title="Nombre del Participante" maxlength="200" placeholder="Nombre del Participante" autocomplete="off" value="<?php echo $data3['nombreparticipante'].' '.$data3['apellidoparticipante']?>" readonly/>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="detalleconvenio">Detalle Convenio:</label></td>
                            <td><input type="text" name="detalleconvenio" id="detalleconvenio" title="Detalle Convenio" maxlength="120" placeholder="Detalle Convenio" autocomplete="off" value="<?php echo $data2['numeroconvenio']?>" readonly /></td>
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
           /* if (window.showModalDialog) {
                var iddata = window.showModalDialog("lookupParticipante.php","name","dialogWidth:555px;dialogHeight:250px");
            } else {
                iddata = window.open('lookuParticipante.php','name','height=255,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
            }
                alert(iddata);
           // $("#nombreparticipante").val(iddata.nombre);
          //  $("#idsiq_detalle_convenio").val(iddata.id);
          //  $("#idsiq_participante").val(iddata.id);*/
           if (window.showModalDialog){
                var iddata = window.showModalDialog("lookupParticipante.php","name","dialogWidth:555px;dialogHeight:250px");
            } else {
            iddata = window.open('lookupParticipante.php','name','height=255,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
            }
            $("#nombreparticipante").val(iddata.nombre);
            $("#idsiq_participante").val(iddata.id)
            /*var objHidden = document.getElementById("idsiq_institucionconvenio");            
            objHidden.value = iddata.id.substring(4,iddata.id.length);  */
        }
                     
        $("#remotejsonp").click( function (){
            Popup();
            return false;            
        });

        </script> 
</html>