<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Previsualizar Plantilla",TRUE);
    initializeCertificados();
    $id = str_replace('row_','',$_REQUEST["id"]);
    $utils = Utils::getInstance();
    $utilsC = Utils_Certificados::getInstance();
    if($id!=""){    
       $dataPlantilla = $utils->getDataEntity("plantillaGenericaEducacionContinuada", $id,"idplantillaGenericaEducacionContinuada");   
    }
    //es el certificado
    /*if($id==1){
        
    }*/
    
    $grupo = $utils->getDataEntity("grupo", $_REQUEST["grupo"], "idgrupo");  
    $materia = $utils->getDataEntity("materia", $grupo["codigomateria"], "codigomateria");     
    $html = $utilsC->decodificarPlantillaPDF($dataPlantilla['plantilla'],$_REQUEST["grupo"],$_REQUEST["estudiante"],$utils,$materia["codigocarrera"]);
    
    /*$html = $utilsC->decodificarPlantillaHTML($dataPlantilla['plantilla']);
    
    $grupo = $utils->getDataEntity("grupo", $_REQUEST["grupo"], "idgrupo"); 
   
    
    $materia = $utils->getDataEntity("materia", $grupo["codigomateria"], "codigomateria");  
    $data = $utils->getDataEntity("carrera", $materia["codigocarrera"], "codigocarrera");   
    $html = str_replace("{{nombrePrograma}}", $data["nombrecarrera"], $html);
    
    $detalleCurso = $utils->getDataEntity("detalleCursoEducacionContinuada", $materia["codigocarrera"], "codigocarrera");   
    $html = str_replace("{{intensidadPrograma}}", $detalleCurso["intensidad"], $html);
    
    $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
    $html = str_replace("{{ciudadPrograma}}", $ciudad["nombreciudad"], $html);
    
    $estudiante = $utils->getDataEntity("estudiantegeneral", $_REQUEST["estudiante"], "numerodocumento");    
    $html = str_replace("{{nombreEstudiante}}", $estudiante["nombresestudiantegeneral"], $html);
    
    $sql = "SELECT * FROM certificadoEstudianteCursoEducacionContinuada WHERE idEstudianteGeneral=".$estudiante["idestudiantegeneral"]." 
           AND idgrupo=".$grupo["idgrupo"]." AND codigoestado=100";
    $certificadoEstudiante = $db->GetRow($sql);
    if($certificadoEstudiante!=NULL && count($certificadoEstudiante)>0){
        $numConsecutivo = $certificadoEstudiante["idcertificadoEstudianteCursoEducacionContinuada"];
        $html = str_replace("{{consecutivoCertificado}}", $certificadoEstudiante["idcertificadoEstudianteCursoEducacionContinuada"], $html);
    }
       
       
    
    
    $date=date('d-m-Y');
    $html = str_replace("{{fechaActual}}",$date , $html);*/
    
    $html = str_replace("{{fechaGrupoPrograma}}", $grupo["fechainiciogrupo"], $html);
    
 $content = ob_get_clean();
    if($id==1){
       $content= "<page style='font-size: 14px;' backtop='3mm' backbottom='3mm' backleft='3mm' backright='3mm'>".$html."</page>";
    } else {
        $content= "<page style='font-size: 14px;' backtop='7mm' backbottom='7mm' backleft='10mm' backright='10mm'>".$html."</page>";        
    }    
    $content=  str_replace('\"', "", $content);
    require_once('../html2pdf/html2pdf.class.php');
    try
    {
        //$html2pdf = new HTML2PDF('P','A4','es');
        if($dataPlantilla["layout"]==1){
            $html2pdf = new HTML2PDF('L','A4','es', true, 'UTF-8', 0);
        } else {
            $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
        }
        $html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('documento'.date("d-m-Y").'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        //echo $e;
        exit;
    }
?>
<?php writeFooter(); ?>