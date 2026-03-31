<?php

$ruta = "../";
while (!is_file($ruta.'templates/template.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta."templates/template.php");
class buildFormClass {
    var $db = null;
    var $utils = null;
    
    function __construct() {
        $this->db = getBD();
        $this->utils = new Utils_datos();
    }
    
    public function initialize($database,$util) {
        $this->db = $database;
        $this->utils = $util;
    }
    
    public function getFormEquiposComputo($formulario,$id="",$class=""){  
        $sql = "SELECT valor,idsiq_valoresCampoFormulario FROM siq_valoresCampoFormulario WHERE codigoestado = '100' AND idCampo='1' ORDER BY valor ASC";
        $comunidades = $this->db->Execute($sql); ?>
        <form action="" method="post" id="<?php echo $id; ?>" class="<?php echo $class; ?>">
            <input type="hidden" name="entity" value="<?php echo $formulario["alias"]; ?>" />
            <input type="hidden" name="idsiq_formulario" value="<?php echo $formulario["idsiq_formulario"]; ?>" />
            <input type="hidden" name="action" id="action" value="save" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            
            <fieldset>   
                <legend><?php echo $formulario["nombre"]; ?></legend>
                
                <label for="nombre" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
                <select name="mes" class="required">
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select> 
                
                <div class="vacio"></div>
                
                <label for="nombre" class="grid-2-12">Año (ej: <?php echo date("Y"); ?>): <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-2-12 required" style="width:50px;" minlength="2" name="anio" id="anio" maxlength="120" tabindex="1" autocomplete="off" value="" />
                
                <div class="vacio"></div>
                
                <label for="nombre" class="grid-2-12">Al servicio de: <span class="mandatory">(*)</span></label>
                <?php
                // comunidad es el nombre del select, el segundo es el elegido por la lista, 
                //primer false que no se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                //el 1 es si es un listbox o un select, 
                echo $comunidades->GetMenu2('comunidad',null,false,false,1,'id="comunidad" class="required"'); ?>
                
                <button type="button" id="select-periodo" class="loading">Seleccionar periodo</button>
                
                <div id="formDetalle" style="display:none;">
                    <label for="nombre" class="grid-2-12">Lugar o Área: <span class="mandatory">(*)</span></label>
                    <select id="lugar" class="required" name="lugar">
                        <option value=""></option>
                    </select>
                    
                    <label for="nombre" class="grid-2-12">Cantidad: <span class="mandatory">(*)</span></label>
                    <input type="text"  class="grid-2-12 required" style="width:50px;" minlength="2" name="cantidad" id="cantidad" maxlength="20" tabindex="1" autocomplete="off" value="" />                
                
                </div>
                
                
                
            </fieldset>
            
            <input type="submit" value="Guardar cambios" class="first" id="submit" style="display:none;" />
        </form>

        <script type="text/javascript">
                $("input[name='plantilla_reporte']").bind('change',function(){
                    showCheckboxCategoria($("input[name='plantilla_reporte']:checked").val());
                });
                
                $('#select-periodo').click(function(event) {
                    if(isNaN($('#anio').val()) || $('#anio').val()==""){
                        alert("El año ingresado no es un valor válido.");
                    } else {
                        //verificar que el año ingresado no sea mayor al actual
                        var anio = parseInt($('#anio').val());
                        var anioActual = parseInt("<?php echo date("Y"); ?>");
                        
                        if(anio>anioActual){
                            alert("El año ingresado no es un valor válido.");
                        } else {                        
                            //si es valido, hacer no editable el periodo y traer datos si encuentro y poner acción en update, 
                            //sino pintar el resto del formulario vacio                            
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForValuesEquipoComputo.php',
                                async: false,
                                data: $('#form_test').serialize(),                
                                success:function(data){
                                    if (data.success == true){
                                        if(data.data.length == 0){
                                            $("#formDetalle").attr('style', 'display: block;');
                                            $("#submit").attr('style', 'display: inline;');
                                            
                                            
                                        } else {
                                            alert("Ya hay un dato guardado");
                                        }
                                    }
                                    else{                        
                                        $('#msg-error').html('<p>' + data.message + '</p>');
                                        $('#msg-error').addClass('msg-error');
                                    }
                                },
                                error: function(data,error,errorThrown){alert(error + " " + errorThrown);}
                            });  
                        }                       
                    }
                });
                
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    
                    if(valido){
                        //verificar que el año ingresado no sea mayor al actual
                    }
                    
                    if(valido){
                        sendForm();
                    }
                });
        </script>
    <?php } 
    
    public function __destruct() {
        
    }
}

?>
