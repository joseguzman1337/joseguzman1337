<?php
    include("../templates/template.php");
    $db = writeHeader("Nuevo Reporte",TRUE);
    
    include("./menu.php");
    writeMenu(2);
?>
        
        <div id="contenido">
            <h2>Crear Nuevo Reporte</h2>
            <?php 
                include("./form.php");
                writeForm(FALSE,$db);
            ?>
        </div>

<?php writeFooter(); ?>
 