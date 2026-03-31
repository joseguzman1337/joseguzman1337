<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Previsualizar Plantilla",TRUE);
    initializeCertificados();
    $id = str_replace('row_','',$_REQUEST["id"]);
    $utils = Utils::getInstance();
    $utilsC = Utils_Certificados::getInstance();
    if($id!=""){    
       $data = $utils->getDataEntity("plantillaGenericaEducacionContinuada", $id,"idplantillaGenericaEducacionContinuada");   
    }
    
    $html = $utilsC->decodificarPlantillaHTML($data['plantilla']);
    echo $html;
?>
<?php writeFooter(); ?>