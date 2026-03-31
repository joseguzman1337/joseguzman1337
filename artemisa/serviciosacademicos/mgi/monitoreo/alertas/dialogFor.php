<?php
    $campos = $utils->getAll($db,"categoria,tabla", "campoPlantillaAlerta","categoria","ASC","categoria","siq_","categoria <> 'Funciones' AND codigoestado='100'");
    $campos = $campos->GetArray();
?>
<div id="dialog-for" title="Insertar ciclo">
    <fieldset class="noBorder">
        <label class="grid-10-12" for="ciclo" style="text-align:left">Nombre ciclo: <span class="mandatory">(*)</span></label><br/>
        <select class="grid-2-12" id="ciclo" size="1" name="ciclo" style="width:100%">
                    <!--<option></option>-->
                    <?php 
                    for ($i = 0; $i < count($campos); $i++) {
                        $pos = strpos($campos[$i]["tabla"], ".");

                        // Note our use of ===.  Simply == would not work as expected
                        // because the position of 'a' was the 0th (first) character.
                        if ($pos === false) {
                            $table = $campos[$i]["tabla"];
                        } else {
                            $table = substr($campos[$i]["tabla"],0,$pos);
                        }
                        echo "<option value='".$table. "'>".$campos[$i]["categoria"]."</option>";
                    } ?>
        </select>
        <!--<p style="font-size:65%;margin-top:5px;"><em>Nota: para enviar los datos del ciclo se debe crear un arreglo con el nombre asignado en el campo de texto superior.</em></p>-->
    </fieldset>
</div>
