<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="financiamiento">
<!-- <input type="hidden" name="action" value="UpdateDynamic" id="action" /> -->
<input type="hidden" name="action" value="financiamiento" id="action" />
<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
<input type="hidden" name="entity" value="siq_ofpresupuestos" id="entity" />                      
<span class="mandatory">* Son campos obligatorios</span>
<fieldset id="valor">
    <?php
    $query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='P_FIN_INST'";
    $papa= $db->Execute($query_papa);
    $totalRows_papa = $papa->RecordCount();
    $row_papa = $papa->FetchRow();
    // echo "<pre>"; print_r($row_papa);
    ?>                
    <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
    <label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
    <?php 
    $utils->getYearsSelect("anio"); 
    $utils->pintarBotonCargar("popup_cargarDocumento(13,5,$('#financiamiento #anio').val())","popup_verDocumentos(13,5,$('#financiamiento #anio').val())");?>
    <table align="center" id="estructuraReporte"  class="formData last" width="92%">
        <thead>                         
            <tr id="dataColumns">
                <th class="column borderR" ><span>Ingresos</span></th>
                <th class="column borderR"><span>Presupuestado</span></th>
                <th class="column borderR" ><span>Ejecutado</span></th>                            
            </tr>               
        </thead>
        <tbody>
            <?php 
            $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
            $sectores= $db->Execute($query_sectores);
            $totalRows_sectores = $sectores->RecordCount();
            // echo "<pre>"; print_r($sectores->FetchRow());die;
            while($row_sectores = $sectores->FetchRow()){
                $idclasificacionesinfhuerfana[]=$row_sectores["idclasificacionesinfhuerfana"];
                // echo '<br>'.$row_sectores["idclasificacionesinfhuerfana"];  
                ?>
                <tr id="contentColumns" class="row">
                    <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
                    <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/presupuestado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>_presupuestado" title="Presupuestado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
                    <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/ejecutado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>_ejecutado" title="Ejecutado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
                </tr>
                <?php 
            }
            ?>
<input type="hidden" name="idclasificacionesinfhuerfana" value='<?php echo base64_encode(serialize($idclasificacionesinfhuerfana)); ?>'>
            <?php
            ?>  
        </tbody>
    </table>
    <div class="vacio"></div>
    <div id="msg-success" class="msg-success" style="display:none"></div>
</fieldset>
<input type="hidden" name="formulario" value="financiamiento" />
<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
<input type="submit" id="enviafinanciamiento" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
$(function(){
    $("#financiamiento input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
    });
//Llama a la función obtener datos al iniciar el formulario
getDataPresupuestos();
//fin llamado

$('#enviafinanciamiento').click(function(event) {
    event.preventDefault();
    replaceCommas("#financiamiento");
    var valido= validateForm("#financiamiento");
    if(valido){
        financiamiento();
    }
});
/* Obtener información */
$('#financiamiento #anio').bind('change', function(event) {
    getDataPresupuestos();
    });
function getDataPresupuestos(){
    var anio = $("#financiamiento #anio").val();
    var entity = $("#financiamiento #entity").val();
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: './formularios/financieros/savePresupuestos.php',
        data: { action: "getDataDynamic", entity: entity, anio: anio, padre: "<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>"},
        success:function(data){
            if (data.success == true){
                    var num = data.id.length;
                    for (i = 0; i <= 1; i++) {
                        // alert(data.id_Clasificacion[i]);
                    $('#financiamiento #'+data.id_Clasificacion[i]+'_presupuestado').val(data.Presupuestado[i]);
                    $('#financiamiento #'+data.id_Clasificacion[i]+'_ejecutado').val(data.Ejecutado[i]);
                    };
                    addCommas('#financiamiento');
                    //
             }else if(data.success== false){
                <?php 
                for ($i = 0; $i <= 1; $i++) {
                    ?>
                    $('#financiamiento #'+<?php echo $idclasificacionesinfhuerfana[$i]?>+'_presupuestado').val(data.Ejecutado);
                    $('#financiamiento #'+<?php echo $idclasificacionesinfhuerfana[$i]?>+'_ejecutado').val(data.Presupuestado);
                    <?php
                };
                ?>
                $('#financiamiento #msg-success').html('<p>' + data.descrip + '</p>');
                $('#financiamiento #msg-success').addClass('msg-error');
                $('#financiamiento #msg-success').css('display','block');
                $("#financiamiento #msg-success").delay(5500).fadeOut(800);

             }else if (data.success== 'Error') {
                $('#financiamiento #msg-success').html('<p>' + data.descrip + '</p>');
                $('#financiamiento #msg-success').addClass('msg-error');
                $('#financiamiento #msg-success').css('display','block');
                $("#financiamiento #msg-success").delay(5500).fadeOut(800);
                
             };
        },
    });
}
/* Fin Obtener información */

function financiamiento(){//$('#form_test').serialize()
//var empresanacionale = $('#empresanacionale').val();
$.ajax({//Ajax
    type: 'POST',
    url: './formularios/financieros/savePresupuestos.php',
    async: false,
    dataType: 'json',
    data:$('#financiamiento').serialize(),
    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    success:function(data){
        if (data.success == true){                    
        $('#financiamiento #msg-success').html('<p>' + data.descrip + '</p>');
        $('#financiamiento #msg-success').removeClass('msg-error');
        $('#financiamiento #msg-success').css('display','block');
        $("#financiamiento #msg-success").delay(5500).fadeOut(800);
    }
    else{                        
    $('#financiamiento #msg-success').html('<p>' + data.descrip + '</p>');
    $('#financiamiento #msg-success').addClass('msg-error');
    $('#financiamiento #msg-success').css('display','block');
    $("#financiamiento #msg-success").delay(5500).fadeOut(800);
    }
}
//error: function(data,error,errorThrown){alert(error + errorThrown);}
}); //AJAX
addCommas("#financiamiento");
}
</script>
