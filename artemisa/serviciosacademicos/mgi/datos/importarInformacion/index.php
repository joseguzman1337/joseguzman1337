<?php

    include("../templates/template.php");
    writeHeader("Importar datos",FALSE);
    
    include("./menu.php");
    writeMenu(1);
    
?>
<div id="contenido">
      <h3 style="margin-top:10px;margin-bottom:0.8em;">Importar información de docentes y administrativos</h3>
      <form action="process_file.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="idpersonalUniversidadPeopleSoft" id="idpersonalUniversidadPeopleSoft" value="<?php echo $_REQUEST['idpersonalUniversidadPeopleSoft'] ?>">
        <input type="hidden" name="entity" id="entity" value="personalUniversidadPeopleSoft">
        <fieldset>
                <legend>Cargar Archivo Personal Universitario</legend>

                    <label style="width:150px">Archivo a Importar: <span class="mandatory">(*)</span></label>
                  <input type="file" name="files" id="files" /> 
                    <a href="../templates/plantilla_personal.csv" target="_blank" style="margin-left:15px;">(descargar plantilla de ejemplo)</a>
                
            </fieldset>
        <button class="submit first" type="submit">Importar información</button>
    </form>
</div>


<?php writeFooter(); ?>