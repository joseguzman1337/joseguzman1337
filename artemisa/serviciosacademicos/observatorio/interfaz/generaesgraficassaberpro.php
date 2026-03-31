<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include('../templates/templateObservatorio.php');
include("../../mgi/pChart/class/pData.class.php");
include("../../mgi/pChart/class/pDraw.class.php");
include("../../mgi/pChart/class/pImage.class.php");
$fontPath = "../../mgi/pChart/fonts/";

$codigocarrre=$_POST['carrera'];

$db =writeHeader("Resultados<br>SaberPro",true,"Saber Pro");

$query_compe="select idobs_competencias, nombrecompetencia from obs_competencias where codigoestado=100";
$data_C= $db->Execute($query_compe);
$dataC= $data_C ->GetArray();
foreach($dataC as $val){
    $arr_compe[]=$val['nombrecompetencia'];
}

$query_ncarr="SELECT ec.codigocarrera, c.nombrecarrera
            FROM obs_estudiante_competencia as ec
            INNER JOIN `estudiantegeneral` as eg on (eg.idestudiantegeneral=ec.codigoestudiante)
            INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
            INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
            INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
            INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
            where ec.codigoperiodo=20132
            group by c.codigocarrera";
$data_NC= $db->Execute($query_ncarr);
$dataNC= $data_NC ->GetArray();
$total_carr=count($dataNC);

$query_nestu="SELECT ec.codigoestudiante
            FROM obs_estudiante_competencia as ec
            INNER JOIN `estudiantegeneral` as eg on (eg.idestudiantegeneral=ec.codigoestudiante)
            INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
            INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
            INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
            INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
            where ec.codigoperiodo=20132 and c.codigocarrera=5
            group by ec.codigoestudiante;";

$data_NE= $db->Execute($query_nestu);
$dataNE= $data_NE ->GetArray();
$total_ess=count($dataNE);

//**Promedio de la UEB**//

$query_ueb="SELECT ec.idobs_competencias, sum(puntaje) as tot_punt
            FROM obs_estudiante_competencia as ec
            INNER JOIN `estudiantegeneral` as eg on (eg.idestudiantegeneral=ec.codigoestudiante)
            INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
            INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
            INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
            INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
            where ec.codigoperiodo=20132
            group by ec.idobs_competencias;";
$data_U= $db->Execute($query_ueb);
foreach($data_U as $valU){
    $valT=$valU['tot_punt']/$total_carr;
    $arr_ueb[]=$valT;
}

//** Por Programa**//

$query_prog="SELECT ec.idobs_competencias, sum(puntaje) as tot_punt
                FROM obs_estudiante_competencia as ec
                INNER JOIN `estudiantegeneral` as eg on (eg.idestudiantegeneral=ec.codigoestudiante)
                INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
                INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
                INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
                where ec.codigoperiodo=20132 and c.codigocarrera=5
                group by ec.idobs_competencias;";
$data_P= $db->Execute($query_prog);
foreach($data_P as $valP){
    $valTP=$valP['tot_punt']/$total_ess;
    $arr_pro[]=$valTP;
}

//** Nacional **//

$query_nacio="SELECT idobs_competencias, puntaje FROM sala.obs_competencias_nacional where codigoperiodo='2013'";
$data_NA= $db->Execute($query_nacio);
foreach($data_NA as $valNA){
    $valTN=$valNA['puntaje'];
    $arr_nac[]=$valTN;
}
//print_r($arr_pro);
//   $ban=0;
//   $val=$_REQUEST['id'];
//   $sin_ind=$_REQUEST['opt'];
//   $codigoperiodo=$_REQUEST['Periodo'];
//   $ban=$_REQUEST['status'];
//   $idfacultad=$_REQUEST['idfacultad'];
//   $n='';
//        $query_carrera = "SELECT nombremateria, nombrecortomateria, codigomateria 
//                               FROM materia 
//                               where codigocarrera='".$val."'  
//                                order by nombremateria";
//    // echo $query_carrera;
//    $data_in= $db->Execute($query_carrera);
?>
<script type="text/javascript">
    $(document).ready(function(){
    	// Smart Tab
  		$('#tabs').smartTab({
                    selected: 3,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});
     
    
</script>
      <div id="tabs">
            <ul>
            <?php if (!empty($codigocarrre)){ ?><li><a href="#tabs-2"><span class="stepDesc">Programa vs UEB</span></a></li><?php } ?>
            <?php if (!empty($codigocarrre)){ ?><li><a href="#tabs-3"><span class="stepDesc">Programa vs Nacional</a></li><?php } ?>
            <li><a href="#tabs-4"><span class="stepDesc">Nacional vs UEB</a></li>
            </ul>
           <?php if (!empty($codigocarrre)){ ?>
            <div id="tabs-2" style=' height:350px'>
            <table class="CSSTableGenerator">
                <tr>
                    <td>
                        <?
                                $MyData = new pData();  
                                $MyData->addPoints($arr_pro,"Promedio Programa");
                                $MyData->addPoints($arr_ueb,"Promedio UEB");
                                $MyData->setSerieWeight("Promedio Programa",2);
                                $MyData->setSerieTicks("Promedio UEB",4);
                                $MyData->addPoints($arr_compe,"Labels");
                                $MyData->setSerieDescription("Labels","Competencias");
                                $MyData->setAbscissa("Labels");

                                $myPicture = new pImage(800,300,$MyData);
                                $myPicture->Antialias = FALSE;
                                $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
                                $myPicture->drawFilledRectangle(0,0,800,300,$Settings);
                                $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
                                $myPicture->drawGradientArea(0,0,800,300,DIRECTION_VERTICAL,$Settings);
                                $myPicture->drawGradientArea(0,0,800,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
                                $myPicture->drawRectangle(0,0,800,299,array("R"=>0,"G"=>0,"B"=>0));
                                $myPicture->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
                                $myPicture->drawText(10,16,"Resultados Programa vs. EUB",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
                                $myPicture->setFontProperties(array("FontName"=>$fontPath."pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
                                $myPicture->setGraphArea(60,40,750,280);
                                $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
                                $myPicture->drawScale($scaleSettings);
                                $myPicture->Antialias = TRUE;
                                $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
                                $myPicture->drawLineChart();
                                $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
                                $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
                               $myPicture->Render("graficas/saberpro/programa_ueb.png");
                        ?>
                        <img alt="Line chart" src="graficas/saberpro/programa_ueb.png"  style="border: 1px solid gray;"/>

                    </td>
                </tr>
            </table>
            </div>
           <?php }
           if (!empty($codigocarrre)){ ?>
          <div id="tabs-3" style=' height:350px'>
               <table class="CSSTableGenerator">
                <tr>
                    <td>
                        <?
                                $MyData2 = new pData();  
                                $MyData2->addPoints($arr_pro,"Promedio Programa");
                                $MyData2->addPoints($arr_nac,"Promedio Nacional");
                                $MyData2->setSerieWeight("Promedio Programa",2);
                                $MyData2->setSerieTicks("Promedio Nacional",4);
                                $MyData2->addPoints($arr_compe,"Labels");
                                $MyData2->setSerieDescription("Labels","Competencias");
                                $MyData2->setAbscissa("Labels");

                                $myPicture2 = new pImage(800,300,$MyData2);
                                $myPicture2->Antialias = FALSE;
                                $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
                                $myPicture2->drawFilledRectangle(0,0,800,300,$Settings);
                                $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
                                $myPicture2->drawGradientArea(0,0,800,300,DIRECTION_VERTICAL,$Settings);
                                $myPicture2->drawGradientArea(0,0,800,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
                                $myPicture2->drawRectangle(0,0,800,299,array("R"=>0,"G"=>0,"B"=>0));
                                $myPicture2->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
                                $myPicture2->drawText(10,16,"Resultados Programa vs. Nacional",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
                                $myPicture2->setFontProperties(array("FontName"=>$fontPath."pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
                                $myPicture2->setGraphArea(60,40,750,280);
                                $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
                                $myPicture2->drawScale($scaleSettings);
                                $myPicture2->Antialias = TRUE;
                                $myPicture2->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
                                $myPicture2->drawLineChart();
                                $myPicture2->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
                                $myPicture2->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
                                $myPicture2->Render("graficas/saberpro/programa_nacional.png");
                        ?>
                        <img alt="Line chart" src="graficas/saberpro/programa_nacional.png"  style="border: 1px solid gray;"/>

                    </td>
                </tr>
            </table>
          </div>
        <?php } ?>
        <div id="tabs-4" style=' height:350px'>
               <table class="CSSTableGenerator">
                <tr>
                    <td>
                        <?
                                $MyData3 = new pData();  
                                $MyData3->addPoints($arr_nac,"Promedio Nacional");
                                $MyData3->addPoints($arr_ueb,"Promedio UEB");
                                $MyData3->setSerieWeight("Promedio Nacional",2);
                                $MyData3->setSerieTicks("Promedio UEB",4);
                                $MyData3->addPoints($arr_compe,"Labels");
                                $MyData3->setSerieDescription("Labels","Competencias");
                                $MyData3->setAbscissa("Labels");

                                $myPicture3 = new pImage(800,300,$MyData3);
                                $myPicture3->Antialias = FALSE;
                                $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
                                $myPicture3->drawFilledRectangle(0,0,800,300,$Settings);
                                $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
                                $myPicture3->drawGradientArea(0,0,800,300,DIRECTION_VERTICAL,$Settings);
                                $myPicture3->drawGradientArea(0,0,800,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
                                $myPicture3->drawRectangle(0,0,800,299,array("R"=>0,"G"=>0,"B"=>0));
                                $myPicture3->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
                                $myPicture3->drawText(10,16,"Resultados Nacional vs UEB",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
                                $myPicture3->setFontProperties(array("FontName"=>$fontPath."pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
                                $myPicture3->setGraphArea(60,40,750,280);
                                $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
                                $myPicture3->drawScale($scaleSettings);
                                $myPicture3->Antialias = TRUE;
                                $myPicture3->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
                                $myPicture3->drawLineChart();
                                $myPicture3->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
                                $myPicture3->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
                                $myPicture3->Render("graficas/saberpro/nacional_ueb.png");
                        ?>
                        <img alt="Line chart" src="graficas/saberpro/nacional_ueb.png"  style="border: 1px solid gray;"/>

                    </td>
                </tr>
            </table>
          </div>
             </div>