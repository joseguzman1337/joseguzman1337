<?php function getFormacion($selected=null,$disable=""){ ?>
        <label for="modalidad" class="fixedLabel">Nivel De Formación: <span class="mandatory">(*)</span></label>
        <select name="modalidad" id="modalidad" class="modalidad" style='font-size:0.8em' <?php echo $disable; ?>>
                <option value="" <?php if($selected=="" || $selected==null) { echo "selected"; } ?> ></option>
                <option value='200' <?php if($selected==200) { echo "selected"; } ?> >Pregrado</option>
                <option value='300' <?php if($selected==300) { echo "selected"; } ?> >Especialización</option>
                <option value='301' <?php if($selected==301) { echo "selected"; } ?> >Maestría</option>
                <option value='302' <?php if($selected==302) { echo "selected"; } ?> >Doctorado</option>
        </select>
    <?php }

    function getProgramas($carreras,$selected=null,$disable=""){ ?>   

        <label for="unidadAcademica" class="fixedLabel">Programa: <span class="mandatory">(*)</span></label>
        <select name="codigocarrera" id="unidadAcademica" class="required unidadAcademica" style='font-size:0.8em;width:auto'
               <?php echo $disable; ?> >
                <option value="" <?php if($selected=="" || $selected==null) { echo "selected"; } ?> ></option>
                <?php foreach ($carreras as $row) {
                    if($row["codigocarrera"]==$selected){
                        echo '<option value="'.$row["codigocarrera"].'" selected >'.$row["nombrecarrera"].'</option>';
                    } else {
                        echo '<option value="'.$row["codigocarrera"].'" >'.$row["nombrecarrera"].'</option>';}

                    } ?>
        </select>
    <?php }
