<?php

    include("template.php");
    $db = writeHeader("Editar Datos Noticia",TRUE);
	
    include("./menuNoticias.php");
    writeMenuNoticia(0);
?>
        
        <div id="contenido">
            <h2>Editar Datos Noticia</h2>
            <?php 
                include("./formNoticias.php");
                //var_dump($_REQUEST["id"]);                
                writeForm(TRUE,str_replace('row_','',$_REQUEST["id"]),$db);
            ?>
        </div>

<?php writeFooter(); ?>
