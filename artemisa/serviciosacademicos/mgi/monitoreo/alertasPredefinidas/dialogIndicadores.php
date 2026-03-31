<?php
    $campos = $utils->getAll($db,"nombre,tabla,campo_tabla", "campoPlantillaAlerta","nombre","ASC","","siq_","categoria = 'Indicador' AND codigoestado='100'");
    $campos = $campos->GetArray();
?>
<div id="dialog-indicadores" title="Insertar ciclo de indicadores a cargo">
    <fieldset class="noBorder">
        <label class="grid-10-12" for="campoI" style="text-align:left">Campos del ciclo: </label><br/>
        <select class="grid-7-12" id="campoI" size="1" name="campoI" style="width:300px" >
                    <!--<option></option>-->
                    <?php 
                    for ($i = 0; $i < count($campos); $i++) {
                        echo "<option value='{{ ".$campos[$i]["tabla"]. ".".$campos[$i]["campo_tabla"]." }}'>".$campos[$i]["nombre"]."</option>";
                    } ?>
        </select>
        
        <input type="button" class="buttonForm" value="Insertar campo" style="float:right;margin-right:15px;padding: 3px 19px 5px;position:relative;top:-2px" id="buttonInsertCampoIndicador"/>
        
        <br/>
        <label class="grid-10-12" for="cicloIndicadores" style="text-align:left;margin-top:5px;">Formato del ciclo: <span class="mandatory">(*)</span></label><br/>
        <textarea class="grid-12-12" id="cicloIndicadores" name="cicloIndicadores" style="resize: none;" rows="5"></textarea>
        <!--<p style="font-size:65%;margin-top:5px;"><em>Nota: para enviar los datos del ciclo se debe crear un arreglo con el nombre asignado en el campo de texto superior.</em></p>-->
    </fieldset>
</div>

<script type="text/javascript">
$('#buttonInsertCampoIndicador').click(function () {  
     var text = $('textarea#cicloIndicadores').val();
     $('textarea#cicloIndicadores').val(text + $("#campoI").val()); 
});

</script>
