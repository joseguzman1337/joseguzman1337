<?php

include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = getBD();
    $utils = Utils::getInstance();
	initializeCertificados();
	$utilsC = Utils_Certificados::getInstance();
    /*$imagenSelectSql="SELECT * FROM sala.parametrizacionEducacionContinuada where nombreCampo='imagenEncabezado';";
        $imagenSelectRow = $db->GetRow($imagenSelectSql);
        $rutaImagen=$imagenSelectRow['valor'];*/
        
    
       $grupo = $utils->getDataEntity("grupo", $_REQUEST["grupo"], "idgrupo");  
       $materia = $utils->getDataEntity("materia", $grupo["codigomateria"], "codigomateria");  
       $data = $utils->getDataEntity("carrera", $materia["codigocarrera"], "codigocarrera"); 
            if(count($data)>0){
                $dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $data["codigocarrera"],"codigocarrera","");
                
                if(count($dataPlantilla)==0){
					echo "No se ha generado la plantilla para los certificados de este curso.";
					die;
				}	
			}				
       $facultad = $utils->getDataEntity("facultad", $data["codigofacultad"], "codigofacultad");   
       $detalleCurso = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera");   
       $estudiante = $utils->getDataEntity("estudiantegeneral", $_REQUEST["estudiante"], "numerodocumento");    
       $tipoDoc = $utils->getDataEntity("documento", $estudiante["tipodocumento"], "tipodocumento");  
       $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
				
	   
       $sql = "SELECT * FROM certificadoEstudianteCursoEducacionContinuada WHERE idEstudianteGeneral=".$estudiante["idestudiantegeneral"]." 
           AND idgrupo=".$grupo["idgrupo"]." AND codigoestado=100";
       $certificadoEstudiante = $db->GetRow($sql);
       if(count($certificadoEstudiante)==0){
           //toca generar la plantilla al curso
           $fields = array();
           $fields["idEstudianteGeneral"] = $estudiante["idestudiantegeneral"];
           $fields["idgrupo"] = $grupo["idgrupo"];
           $fields["codigocarrera"] = $data["codigocarrera"];
           $fields["plantilla"] = "";
           $fields["entregado"] = 1;
           if(!isset($_REQUEST["ver"])){
            $numConsecutivo = $utils->processData("save","certificadoEstudianteCursoEducacionContinuada","idcertificadoEstudianteCursoEducacionContinuada",$fields,false);
           }               
       } /*else {
           $numConsecutivo = $certificadoEstudiante["idcertificadoEstudianteCursoEducacionContinuada"];
       }*/
       
       /*$duplicado = "";
       $tamTexto = "";
       if(isset($_REQUEST["duplicado"])&&$_REQUEST["duplicado"]==1){
           $duplicado = '<img style="width: 200px;display:block;float:left;" src="../images/duplicado_45.png">';
            $tamTexto = 'width:600px;';
       }*/
	   
	   $html = $utilsC->decodificarPlantillaPDF($dataPlantilla['plantilla'],$_REQUEST["grupo"],$_REQUEST["estudiante"],$utils,$materia["codigocarrera"],$dataPlantilla["idplantillaCursoEducacionContinuada"]);

       /***********************************
        * FALTA VALIDAR QUE EL ESTUDIANTE SI ESTUVO INSCRITO EN EL GRUPO/CURSO
        * SI EXISTE EL DETALLE DEL CURSO
        ***********************************/
        
ob_start();
    //$content='<page><style type="text/css">table{border-collapse: collapse;border-spacing: 0;border: none;}tr{border: none;} </style>'.$_POST['datos_a_enviar']."</page>";
echo "<page style='font-size: 14px;' backtop='3mm' backbottom='3mm' backleft='3mm' backright='3mm'>".$html."</page>";

/*echo "<page><img style="width: 1090px" alt="logo" src="'.$rutaImagen.'"><br><br>

    <input type="hidden" name="datos_a_enviar" id="datos_a_enviar">
        '.$duplicado.'

        <div contenteditable="true" style="width:100%" mce-content-body="" class="editable" id="mce_0" tabindex="-1" spellcheck="false"><p align="center" style="margin: 20px 0 20px;'.$tamTexto.'">LA DIVISIÓN DE EDUCACIÓN CONTINUADA</p><p align="center" style="font-size:1.1em;'.$tamTexto.'">OTORGA EL PRESENTE CERTIFICADO A:</p></div>

        <h1 align="center" style="margin:40px 0 0;font-size:1.3em;">'.$estudiante["apellidosestudiantegeneral"].' '.$estudiante["nombresestudiantegeneral"].'</h1>

        <p align="center" style="margin:5px 0 50px;">'.$tipoDoc["nombrecortodocumento"].'. '.number_format($estudiante["numerodocumento"], 0, '.', '.').'</p>

        <div contenteditable="true" style="width:100%" mce-content-body="" class="editable" id="mce_21" tabindex="-1" spellcheck="false"><p align="center">Quien asistió y cumplió los requisitos académicos establecidos para el:</p></div>
        <h3 align="center" style="margin:20px 0 0;">'.$data["nombrecarrera"].'</h3>
		
		<div contenteditable="true" style="width:100%" mce-content-body="" class="editable" id="mce_22" tabindex="-1" spellcheck="false"><p align="center" style="margin:0px 0 10px;font-size:0.9em;">Intensidad '.$detalleCurso["intensidad"].' Horas</p></div>
        <p align="center">'.$ciudad["nombrecortociudad"].', '.$grupo["fechainiciogrupo"].' a '.$grupo["fechafinalgrupo"].'.</p>
<table align="center" class="tableau" style="width:1090px;margin: 55px 0 0;">
        <tr align="center">
            <td style="width: 33%;text-align:center;"><hr/> Nombre <br> Cargo <br> Organización/Unidad</td>
            <td style="width: 33%;text-align:center;"><hr/>Nombre <br> Cargo <br> Organización/Unidad</td>
            <td style="width: 33%;text-align:center;"><hr/>Nombre <br> Cargo <br> Organización/Unidad</td>
        </tr>
    </table>     
        
        <p style="text-align:right;font-size:0.7em;margin:40px 0 0;">'.$numConsecutivo.'</p>
   
</page>';*/



/*echo "<img src='../parametrizacion/images/bosque_2013-07-09.jpg' alt='logo' style='width: 1090px'><br/><br/>";
    echo $_POST['datos_a_enviar'];*/

    $content = ob_get_clean();
    $content=  str_replace('\"', "", $content);
        //1
        //$content=  str_replace('text-align: center;', "", $content);
        //1, este no me funciono pa naa
        //$content=  str_replace('<p>', '<p align= "center">', $content);
        //2
        //$content=  str_replace('style="margin: 30px 0 40px;"', "", $content);
        //2
        //$content=  str_replace('<p><br></p>', "", $content);
        
        
    //(1) Si no toy mal el problema del centrado se debe al h1 q hay ya que despues del h1 no coje mas los estilos y too taa igualito
    //(2) el problema del cambio de pag se debe a unos brs raritos por ahi y un style wtf
    
    require_once('../html2pdf/html2pdf.class.php');
    try
    {   
        $html2pdf = new HTML2PDF('L','A4','es', true, 'UTF-8', 0);
        //$html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
		 $html2pdf->setDefaultFont('Arial');
        //$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        //$html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('certificadoEstudiante_'.$_REQUEST["estudiante"].'.pdf');
        //var_dump($content);
        //echo "<pre>";print_r($content);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    //var_dump($content);
    //echo $content;
?>

