<select name="iddocente" id="iddocente" class="chosen-select" >
    <option value="" >Filtrar por Docente...</option>
    <?php
    foreach($listaDocentes as $d){
        $selected = "";
        if( !empty($idDocente) && ($idDocente == $d->getIddocente()) ){
            $selected = " selected ";
        }
        ?>
        <option value="<?php echo $d->getIddocente(); ?>" <?php echo $selected; ?> ><?php echo $d->getNumerodocumento(); ?> - <?php echo $d->getNombredocente()." ".$d->getApellidodocente(); ?></option>
        <?php
    }
    ?>
</select>