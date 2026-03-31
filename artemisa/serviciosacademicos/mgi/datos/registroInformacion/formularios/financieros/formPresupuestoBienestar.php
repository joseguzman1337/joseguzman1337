<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="bienestar">
<input type="hidden" name="action" value="bienestar" id="action" />
<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
<input type="hidden" name="entity" value="siq_ofpresupuestos" id="entity" />                       
  <span class="mandatory">* Son campos obligatorios</span>
  <fieldset>
    <?php
    $query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='P_EJE_PROG_BIEN'";
    $papa= $db->Execute($query_papa);
    $totalRows_papa = $papa->RecordCount();
    $row_papa = $papa->FetchRow();
    ?>                
    <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>   
    <label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
    <?php $utils->getYearsSelect("anio"); 
    $utils->pintarBotonCargar("popup_cargarDocumento(13,3,$('#bienestar #anio').val())","popup_verDocumentos(13,3,$('#bienestar #anio').val())"); ?>
    <table align="center" id="estructuraReporte"  class="formData last" width="92%">
      <thead>                   
        <tr id="dataColumns">
          <th class="column borderR" ><span>Área</span></th>
          <th class="column borderR"><span>Presupuestado</span></th>
          <th class="column borderR" ><span>Ejecutado</span></th>                            
        </tr>       
      </thead>
      <tbody>
        <?php 
        $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
        $sectores= $db->Execute($query_sectores);
        $totalRows_sectores = $sectores->RecordCount();
        while($row_sectores = $sectores->FetchRow()){ 
          $idclasificacionesinfhuerfana[]=$row_sectores["idclasificacionesinfhuerfana"];
          ?>
          <tr id="contentColumns" class="row">
          <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
          <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/presupuestado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>_presupuestado" title="Presupuestado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
          <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/ejecutado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>_ejecutado" title="Ejecutado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
        </tr>
        <?php 
      }
      ?>  
    </tbody>
  </table>
  <div class="vacio"></div>
  <div id="msg-success" class="msg-success" style="display:none"></div>
</fieldset>
<input type="hidden" name="idclasificacionesinfhuerfana" value='<?php echo base64_encode(serialize($idclasificacionesinfhuerfana)); ?>'>
<input type="hidden" name="formulario" value="bienestar" />
<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
<input type="submit" id="enviabienestar" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
$(function(){
  $("#bienestar input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
});

//Llama a la función obtener datos al iniciar el formulario
getformulario_bienestar("#bienestar");
//fin llamado

$('#bienestar #anio').bind('change', function(event) {
  getformulario_bienestar("#bienestar");
});
    
$('#enviabienestar').click(function(event) {
  event.preventDefault();
  replaceCommas("#bienestar");
  var valido= validateForm("#bienestar");
  if(valido){
    bienestar();
  }
});

function getformulario_bienestar(forname){
    var anio = $(forname + " #anio").val();
    var entity = $(forname + " #entity").val();
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: './formularios/financieros/savePresupuestos.php',
        data: { action: "getDataDynamic", entity: entity, anio: anio, padre: "<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>"},
        success:function(data){
            if (data.success == true){
                    var num = data.id.length;
                    for (i = 0; i <= num; i++) {
                        // alert(data.id_Clasificacion[i]);
                    $(forname + ' #'+data.id_Clasificacion[i]+'_presupuestado').val(data.Presupuestado[i]);
                    $(forname + ' #'+data.id_Clasificacion[i]+'_ejecutado').val(data.Ejecutado[i]);
                    };
                    addCommas(forname + '');
                    //
             }else if(data.success== false){
                var num = data.id_Clasificacion.length;
                for (i = 0; i <= num; i++) {
                  $(forname + ' #'+data.id_Clasificacion[i]+'_presupuestado').val(data.Presupuestado[i]);
                  $(forname + ' #'+data.id_Clasificacion[i]+'_ejecutado').val(data.Ejecutado[i]);
                };
                $(forname + ' #msg-success').html('<p>' + data.descrip + '</p>');
                $(forname + ' #msg-success').addClass('msg-error');
                $(forname + ' #msg-success').css('display','block');
                $(forname + " #msg-success").delay(5500).fadeOut(800);

             }else if (data.success== 'Error') {
                $(forname + ' #msg-success').html('<p>' + data.descrip + '</p>');
                $(forname + ' #msg-success').addClass('msg-error');
                $(forname + ' #msg-success').css('display','block');
                $(forname + " #msg-success").delay(5500).fadeOut(800);
                
             };
        },
    });
}

function bienestar(){//$('#form_test').serialize()
//var empresanacionale = $('#empresanacionale').val();
$.ajax({//Ajax
  type: 'POST',
  url: 'formularios/financieros/savePresupuestos.php',
  async: false,
  dataType: 'json',
  data:$('#bienestar').serialize(),
  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
  success:function(data){
    if (data.success == true){            
      $('#bienestar #msg-success').html('<p>' + data.descrip + '</p>');
      $('#bienestar #msg-success').removeClass('msg-error');
      $('#bienestar #msg-success').css('display','block');
      $("#bienestar #msg-success").delay(5500).fadeOut(800);
    }else{                        
      $('#bienestar #msg-success').html('<p>' + data.descrip + '</p>');
      $('#bienestar #msg-success').addClass('msg-error');
      $('#bienestar #msg-success').css('display','block');
      $("#bienestar #msg-success").delay(5500).fadeOut(800);
    }
  }
  //error: function(data,error,errorThrown){alert(error + errorThrown);}
  }); //AJAX
addCommas("#bienestar");
}
</script>
