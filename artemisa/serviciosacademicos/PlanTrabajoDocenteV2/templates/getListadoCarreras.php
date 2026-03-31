<select name="codigocarrera" id="codigocarrera" class="chosen-select" >
    <option value="" >Filtrar por Carrera...</option>
    <?php
    foreach($listaCarreras as $c){
        $selected = "";
        if(!empty($codigoCarrera) && ($codigoCarrera == $c->getCodigocarrera()) ){
            $selected = " selected ";
        }
        ?>
        <option value="<?php echo $c->getCodigocarrera(); ?>" <?php echo $selected; ?> ><?php echo $c->getNombrecarrera(); ?></option>
        <?php
    }
    ?>
</select>