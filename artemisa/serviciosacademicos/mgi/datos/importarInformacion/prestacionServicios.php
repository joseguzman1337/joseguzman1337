<?php

    include("../templates/template.php");
    writeHeader("Importar datos",FALSE);
    
    include("./menu.php");
    writeMenu(3);
    
?>
<div id="contenido">
      <h3 style="margin-top:10px;margin-bottom:0.8em;">Importar información de personal por prestación de servicios</h3>
      <form action="process_file.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="entity" id="entity" value="prestacionServiciosPeopleSoft">
        <fieldset>
                <legend>Cargar Archivo Prestación de Servicios</legend>

                    <label style="width:150px">Archivo a Importar: <span class="mandatory">(*)</span></label>
                  <input type="file" name="files" id="files" /> 
                    <a href="../templates/plantilla_prestacion.csv" target="_blank" style="margin-left:15px;">(descargar plantilla de ejemplo)</a>
                
            </fieldset>
        <button class="submit first" type="submit">Importar información</button>
    </form>
</div>


<?php writeFooter(); ?>