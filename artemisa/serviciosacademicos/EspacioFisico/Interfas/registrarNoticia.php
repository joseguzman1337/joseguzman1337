<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registrar Noticia",TRUE);
    
    include("./menuNoticias.php");
    writeMenuNoticia(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Noticia</h2>
            <?php 
                include("./formNoticias.php");
                writeForm(FALSE, "", $db);
             ?>
        </div>  

<?php writeFooter(); ?>