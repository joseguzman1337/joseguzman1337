<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="desarrollo"> 
<input type="hidden" name="entity" value="siq_ofpresupuestos" id="entity" />
<input type="hidden" name="action" value="desarrollo" id="action" />
<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />                       
<span class="mandatory">* Son campos obligatorios</span>
<fieldset>
  <?php
  $query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='PPROGDESPROF'";
  $papa= $db->Execute($query_papa);
  $totalRows_papa = $papa->RecordCount();
  $row_papa = $papa->FetchRow();
  ?>
  <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
  <label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
  <?php $utils->getYearsSelect("anio");
  $utils->pintarBotonCargar("popup_cargarDocumento(13,1,$('#desarrollo #anio').val())","popup_verDocumentos(13,1,$('#desarrollo #anio').val())"); ?>
  <table align="center" id="estructuraReporte"  class="formData last" width="92%">
    <thead>                   
      <tr id="dataColumns">
        <th class="column borderR" ><span>Programa</span></th>
        <th class="column"><span>Presupuestado</span></th>
        <th class="column" ><span>Ejecutado</span></th>                                  
      </tr>       
    </thead>
    <tbody>
      <tr id="contentColumns" class="row">        
        <td class="column borderR" >
          <?php echo $row_papa['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
        </td>   
        <td class="column" >
          <input type="text" class="required number" minlength="" name="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/presupuestado" id="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>_presupuestado" title="Presupuestado" maxlength="60" tabindex="1" autocomplete="off" size="20" />
        </td>
        <td class="column" >
          <input type="text" class="required number" minlength="" name="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/ejecutado" id="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>_ejecutado" title="Ejecutado" maxlength="60" tabindex="1" autocomplete="off" size="20" />
        </td>
      </tr>
    </tbody>
  </table>
  <div class="vacio"></div>
  <div id="msg-success" class="msg-success" style="display:none"></div>
</fieldset>
<input type="hidden" name="idclasificacionesinfhuerfana" value='<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>'>
<input type="hidden" name="formulario" value="desarrollo" />
<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
<input type="submit" id="enviar" class="first" value="Registrar datos" />
</form>
<script type="text/javascript">
$(function(){
  $("#desarrollo input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
});

//Llama a la función obtener datos al iniciar el formulario
getformulario_desarrollo("#desarrollo");
//fin llamado
    
$('#enviar').click(function(event) {
  event.preventDefault();
  replaceCommas("#desarrollo");
  var valido= validateForm("#desarrollo");
  if(valido){
      desarrollo();
  }
});

$('#desarrollo #anio').bind('change', function(event) {
  getformulario_desarrollo("#desarrollo");
});

function getformulario_desarrollo(forname){
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
                $(forname +' #'+<?php echo $row_papa['idclasificacionesinfhuerfana']?>+'_presupuestado').val(data.Ejecutado);
                $(forname +' #'+<?php echo $row_papa['idclasificacionesinfhuerfana']?>+'_ejecutado').val(data.Presupuestado);
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
function desarrollo(){//$('#form_test').serialize()
//var empresanacionale = $('#empresanacionale').val();
$.ajax({//Ajax
  type: 'POST',
  url: './formularios/financieros/savePresupuestos.php',
  async: false,
  dataType: 'json',
  data:$('#desarrollo').serialize(),
  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
  success:function(data){
    if (data.success == true){
      $('#desarrollo #msg-success').html('<p>' + data.descrip + '</p>');
      $('#desarrollo #msg-success').removeClass('msg-error');
      $('#desarrollo #msg-success').css('display','block');
      $("#desarrollo #msg-success").delay(5500).fadeOut(800);                                                                       
      }
      else{                        
        $('#desarrollo #msg-success').html('<p>' + data.descrip + '</p>');
        $('#desarrollo #msg-success').addClass('msg-error');
        $('#desarrollo #msg-success').css('display','block');
        $("#desarrollo #msg-success").delay(5500).fadeOut(800);                                                                         
      }
    }
    //error: function(data,error,errorThrown){alert(error + errorThrown);}
    }); //AJAX
addCommas("#desarrollo");
}
</script>