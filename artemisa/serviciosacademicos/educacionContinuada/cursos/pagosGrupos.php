<?php
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/

    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Pagos Grupo",TRUE);
    
    $pagos = array();
    
    if(isset($_REQUEST["idGrupo"])){  
       $id = $_REQUEST["idGrupo"];
       $utils = Utils::getInstance();
       //aqui buscar pagos
       $pagos = $utils->getAll($db,"*","pagoPatrocinioGrupoEducacionContinuada","codigoestado=100"); 
   }
?>

<div id="contenido" style="margin:10px 0;">
         <button class="soft addBtn" type="button" id="btnPago" style="margin:0;">Agregar nuevo pago</button>
        
         <form action="save.php" method="post" id="form_test" style="display:none;">
             <h4 style="margin:0 0 10px;">Agregar nuevo pago</h4>
            <input type="hidden" name="entity" value="pagoPatrocinioGrupoEducacionContinuada" />
            <input type="hidden" name="action" value="savePagoPatrocinado" />
            <input type="hidden" name="idGrupo" value="<?php echo $id; ?>" />
            <fieldset>
                    <div class="empresa">
                        <label for="nombre" class="fixed">Empresa patrocinadora: <span class="mandatory">(*)</span></label>
                        <input type="text"  class="grid-8-12 empresaName" minlength="2" name="empresa" id="empresa" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="" />
                        <input type="hidden"  class="grid-8-12" minlength="2" name="idEmpresa" id="idEmpresa" maxlength="12" tabindex="1" autocomplete="off" value="" />
                        <input type="hidden"  class="grid-8-12" minlength="2" name="tmp_empresa" id="tmp_empresa" value="" />
                    </div>
            
                <label for="nombre" class="fixed">Factura: <span class="mandatory">(*)</span></label>
                <input type="text" title="número de factura" id="factura" name="factura" class="grid-3-12 required" maxlength="50" tabindex="1" autocomplete="off" value="" />
            
                <label for="nombre" class="fixed">Valor del pago: <span class="mandatory">(*)</span></label>
                <input type="text" title="Valor pagado" id="valor" name="valor" class="grid-3-12 required number" maxlength="50" tabindex="1" autocomplete="off" value="" />
            
                <label for="nombre" class="fixed">Fecha: <span class="mandatory">(*)</span></label>
                <input type="text" title="fecha de pago" id="fecha" name="fecha" class="grid-3-12 required" maxlength="120" tabindex="1" autocomplete="off" value="" readonly />
                <div class="vacio"></div>
                <input type="submit" class="first" id="pagosGruposPagar" value="Registrar pago">
                <a style="font-size:12px;margin-left:15px;" href="javascript:toggleBack();"> Cancelar </a>
            </fieldset>
         </form>
         
        <h4>Historial de pagos</h4>
        
        <table id="historialPagos" class="detalle">
		<tr>
                    <th style="text-align:center">Empresa patrocinadora</th>
                    <th style="text-align:center">Factura</th>
                    <th style="text-align:center">Valor</th>
                    <th style="text-align:center">Fecha</th>
                    <th style="text-align:center">Acciones</th>
                </tr>
                <?php foreach($pagos as $row) { 
                    $empresa = $utils->getDataEntity("empresa", $row["idEmpresa"], "idempresa"); ?>
                <tr id="pago<?php echo $row["idpagoPatrocinioGrupoEducacionContinuada"]; ?>" >
                    <td><?php echo $empresa["nombreempresa"]; ?></td>
                    <td><?php echo $row["factura"]; ?></td>
                    <td class="column center"><?php echo "$ ".number_format( $row["valor"]); ?></td>
                    <td class="column center"><?php echo $row["fecha"]; ?></td>
                    <td class="column center eliminarDato"><img width="16" onclick="Eliminar(<?php echo $row["idpagoPatrocinioGrupoEducacionContinuada"]; ?>)" title="Eliminar Pago" src="../../mgi/images/Close_Box_Red.png" style="cursor:pointer;"></td>
                </tr>
                <?php } ?>
        </table>
</div>

<script type="text/javascript">
    
    $("#btnPago").click(function () {
        $("#btnPago").toggle();
        $("#form_test").toggle(800);
    });
    
    function toggleBack(){
        $("#form_test").toggle(400);     
        $("#btnPago").toggle();   
        $("#form_test input[type=text]").val("");
        $('#idEmpresa').val("");
        $('#tmp_empresa').val("");
    }
    
    $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if($('#empresa').val()==""){
                            $( "#empresa" ).addClass('error');
                            $( "#empresa" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                    }      
                    if(valido){
                        sendForm();
                    }
     });
    
    function sendForm(){
           $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: $('#form_test').serialize(),                
                    success:function(data){
                            if (data.success == true){
                                 toggleBack();
                                 console.log(data);
                                 var html = "<tr id='pago"+data.data.idpagoPatrocinioGrupoEducacionContinuada+"'><td>"+data.dataEmpresa.nombreempresa+"</td>";
                                 html += "<td>"+data.data.factura+"</td><td class='column center'>"+numberWithCommas(data.data.valor)+"</td><td class='column center'>"+data.data.fecha+"</td>";
                                 html += "<td class='column center eliminarDato'><img width='16' onclick='Eliminar("+data.data.idpagoPatrocinioGrupoEducacionContinuada+")' title='Eliminar Pago' src='../../mgi/images/Close_Box_Red.png' style='cursor:pointer;' /></td></tr>";
                                 $("#historialPagos tr:last-child").after(html);
                            }
                            else{ 
                                alert(data.message);
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
           });            
     }
    

/*$('#pagosGruposNit').change(function(e){
    e.preventDefault();
    var nit = $('#pagosGruposNit').val();
    
    $.ajax({
        url: 'buscarEmpresa.php',
        type: 'POST',
        dataType: 'json',
        data: {nit: nit},
        success: function(data) {
            if(data.mensaje == "success"){
                document.getElementById("pagosGruposNombre").style.visibility="visible";
                document.getElementById("pagosGruposNombreLabel").style.visibility="visible";
                document.getElementById("pagosGruposNombre").value=data.nombre;
            }
            else{
                document.getElementById("pagosGruposNombre").style.visible="hidden";
                document.getElementById("pagosGruposNombreLabel").style.visible="hidden";
            }
        }
    });
});*/

$( "#fecha" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd",
      maxDate: "+0d"
});

                
                $(document).ready(function() {
                    $('#ui-datepicker-div').hide();
                    
                    $(document).on("keyup",".empresaName",function(event){
                        $(this).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url: "../searches/lookForEmpresas.php",
                                    dataType: "json",
                                    data: {
                                        term: request.term
                                    },
                                    success: function( data ) {
                                        response( $.map( data, function( item ) {
                                            return {
                                                label: item.label,
                                                value: item.value,
                                                id: item.id
                                            }
                                        }));
                                    }
                                });
                            },
                            minLength: 2,
                            selectFirst: false,
                            open: function(event, ui) {
                                var maxWidth = $('#form_test').width()-200;  
                                var width = $(this).autocomplete("widget").width();
                                if(width>maxWidth){
                                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                                }
                                $('#tmp_empresa').val($('#empresa').val());
                            },
                            select: function( event, ui ) {
                                //alert(ui.item.id);
                                if(ui.item.value=="null"){
                                    event.preventDefault();
                                    $('#empresa').val($('#tmp_empresa').val());
                                }
                                $('#idEmpresa').val(ui.item.id);
                            }                
                        });
                    });
                });
                
         function Eliminar(id, entity){
                 $.ajax({
                      dataType: 'json',
                      type: 'POST',
                      url: 'process.php',
                      data: { action: "inactivateEntity", id: id, entity: 'pagoPatrocinioGrupoEducacionContinuada' },     
                      success:function(data){
                            //todo bien :), eliminar de la tabla
                            $('#pago'+data.id).remove();
                      },
                      error: function(data,error,errorThrown){alert(error + errorThrown);}
                });  
         }
</script>