<?php
   $facultades = $utils->getAll($db,"codigofacultad,nombrefacultad", "facultad","nombrefacultad","ASC","","");
?>
<div id="dialog-facultades" title="Seleccionar Facultades">
    <fieldset class="noBorder">
        <input type="checkbox" name="facultades" id="facultades-all" value="si" /> Seleccionar todas<br/>
        <?php 
        while($row = $facultades->FetchRow()){
        ?>
        <input type="checkbox" name="facultad[]" value="<?php echo $row['codigofacultad']; ?>" /> <?php echo $row['nombrefacultad']; ?><br/>
        <?php } ?>
    </fieldset>
</div>

<script type="text/javascript">
    $(function() {
        $( "#facultades-all" ).click(function() {
            if($(this).is(":checked")){
                $('#dialog-facultades input:checkbox:not(:disabled)').attr('checked','checked');
            } else {
                $('#dialog-facultades input:checkbox').removeAttr('checked');
            }
        });
    });
</script>