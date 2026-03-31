<?php
   $indicadores = $utils->getIndicadoresReporte($db,$id,false);
?>
<div id="dialog-indicadores" title="Indicadores asociados" style="display:none">
    <fieldset class="noBorder">
        <?php if($indicadores!=false) { ?>
            <ul>
            <?php $cont = 0;
            while($row = $indicadores->FetchRow()){ $cont = $cont + 1;
            ?>
                <li><?php echo $row['codigo']." - ".$row['nombre']; ?></li>
            <?php } 
            ?>
            </ul>
        <?php if($cont == 0) { echo "No hay indicadores asociados"; }  } else { echo "No hay indicadores asociados"; } ?>
    </fieldset>
</div>