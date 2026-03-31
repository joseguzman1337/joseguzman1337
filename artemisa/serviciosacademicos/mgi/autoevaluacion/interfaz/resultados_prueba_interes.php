<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include("../../templates/templateAutoevaluacion.php");
include("../../pChart/class/pData.class.php");
include("../../pChart/class/pDraw.class.php");
include("../../pChart/class/pImage.class.php");
$db =writeHeader("Instrumento",true,"Autoevaluacion");
$id_instrumento=$_REQUEST['id'];
$cedula=$_REQUEST['cedula'];

?>
<style>
body{ background: url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg") repeat scroll 0 0 rgba(0, 0, 0, 0);
font-family: 'PT Sans', sans-serif;
margin:0;
padding:0;
color: #3E4729;
}
#encabezado {
	    background-color: #3E4729;
	    border-bottom: 7px solid #88AB0C;
	    height: 80px;
	    width: 100%;
	    z-index: 100;
		overflow:hidden;
	}

	.cajon {
	    clear: both;
    margin: 0 auto;
    position: relative;
    text-align: left;
    width: 960px;
	}
	
	#encabezado > div > a {
	    display: block;
	    width: 172px;
	
		
	}
	
	
	fieldset{
	background: none repeat scroll 0 0 #FFFFFF;
    border: 0 none;
    box-shadow: 0 0 5px 0 #CCCCCC;
    margin: 2em 0;
    padding: 1em 2em;
    position: relative;
    width: 800px;}
fieldset > table{
	margin:1em 2em;
	}	
fieldset > legend
{
	padding: 40px 0 0 0;
	}	
  #progressbar .ui-progressbar-value {
    background-color: #006400;
    background: #006400;
  }

  div.centrado{
    text-align: center;
    display: block;
    margin: auto;
}
input[type="submit"] {
    background: url("http://www.uelbosque.edu.co/sites/default/themes/ueb/images/boton-de-busqueda.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    border-color: #DDE2BC;
    border-style: solid;
    border-width: 1px;
    height: 25px;
    line-height: 25px;
    margin: 5px 0 0;
    padding: 3px;
    text-align: center;
}

.boton {
    border: 1px solid #006400; /*anchura, estilo y color borde*/
    padding: 10px; /*espacio alrededor texto*/
    background-color: #228B22; /*color botón*/
    color: #ffffff; /*color texto*/
    text-decoration: none; /*decoración texto*/
    text-transform: uppercase; /*capitalización texto*/
    font-family: 'Helvetica', sans-serif; /*tipografía texto*/
    border-radius: 50px; /*bordes redondos*/
}

  </style>

<div id="contenido">
  <center>
    <form  method="post" action="instrumento_aplicar.php?id_instrumento=<?php echo $id_instrumento ?>" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $id_instrumento ?>">
        <input type="hidden" name="entity" id="entity" value="Arespuestainstrumento">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cedula" id="cedula" value="<?PHP echo $_REQUEST['cedula']?>" />
                 <div id="encabezado">
		<div class="cajon">
			<a title="Ir a la página principal" href="http://www.uelbosque.edu.co"><img id="logoU" alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"></a>			<!-- herramientas -->									
		</div>
	</div>
        <?php 
        $sql_ced="SELECT * FROM siq_Apublicoobjetivocsv WHERE cedula='".$_REQUEST['cedula']."' ";
        $data_ced = $db->Execute($sql_ced);  
        $dataC= $data_ced->GetArray();
        $dataC=$dataC[0];
        
        $sql_secc="SELECT s.idsiq_Ainstrumentoconfiguracion, s.idsiq_Ainstrumentoseccion,
                        s.idsiq_Aseccion, se.nombre
                 FROM siq_Ainstrumentoseccion as s
                 INNER JOIN siq_Ainstrumentoconfiguracion AS i 
                 on (s.idsiq_Ainstrumentoconfiguracion=i.idsiq_Ainstrumentoconfiguracion and i.codigoestado=100)
                 INNER JOIN siq_Aseccion as se on (s.idsiq_Aseccion=se.idsiq_Aseccion and se.codigoestado=100)
                 WHERE s.idsiq_Ainstrumentoconfiguracion='".$_REQUEST['id']."' and s.codigoestado=100";       
                  
         $data_secc = $db->Execute($sql_secc);  
         $i=0; $secc0=''; $secc1='';  $secc2='';  $secc3='';    
         foreach($data_secc as $dt_cp){
                if ($i>=0 && $i<4 ){
                    $secc0.=$dt_cp['idsiq_Aseccion'].',';
                }else if ($i>=4 && $i<=11 ){
                    $secc1.=$dt_cp['idsiq_Aseccion'].',';
                }else if ($i>=12 && $i<=16 ){
                    $secc2.=$dt_cp['idsiq_Aseccion'].',';
                }else if ($i>=17 && $i<=22 ){
                    $secc3 .=$dt_cp['idsiq_Aseccion'].',';
                }
            $i++;
         }

                $secc[0] = substr($secc0, 0, -1);
                $secc[1] = substr($secc1, 0, -1);
                $secc[2] = substr($secc2, 0, -1);
                $secc[3] = substr($secc3, 0, -1);
           $i=0;
          /*
           * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
           * Ajuste consulta para que muestre Interés Vocacional de la prueba realizada.
           * @since Febrero 26, 2018.
          */ 
          foreach($secc as $val){
            $sql_S1="SELECT count(i.idsiq_Apregunta) as total
                    FROM siq_Ainstrumento as i 
                    inner join siq_Apregunta as p on (i.idsiq_Apregunta=p.idsiq_Apregunta and p.codigoestado=100)
                    inner join siq_Aseccion as s on (i.idsiq_Aseccion=s.idsiq_Aseccion and s.codigoestado=100)
                    inner join siq_Arespuestainstrumento as r on (i.idsiq_Ainstrumentoconfiguracion=r.idsiq_Ainstrumentoconfiguracion and p.idsiq_Apregunta=r.idsiq_Apregunta  and r.codigoestado=100 )
                    where i.codigoestado=100 and i.idsiq_Ainstrumentoconfiguracion='".$_REQUEST['id']."'
                    and i.idsiq_Aseccion in (".$val.") and r.cedula='".$_REQUEST['cedula']."'";
            
            $dataS1 = $db->Execute($sql_S1);
            $data_S1=$dataS1->GetArray();
            $T_S1=$data_S1[0]['total'];
            $TV_s1=$T_S1*3;
          
            $sql_cp="SELECT r.idsiq_Ainstrumentoconfiguracion, r.idsiq_Apregunta, p.titulo,
                            r.idsiq_Apreguntarespuesta, re.valor, i.idsiq_Aseccion
                     FROM siq_Arespuestainstrumento as r
                     inner join siq_Apregunta as p on (r.idsiq_Apregunta=p.idsiq_Apregunta and p.codigoestado=100)
                     INNER JOIN siq_Apreguntarespuesta as re on (r.idsiq_Apreguntarespuesta=re.idsiq_Apreguntarespuesta and re.codigoestado=100)
                     INNER JOIN siq_Ainstrumento as i ON (i.idsiq_Ainstrumentoconfiguracion=r.idsiq_Ainstrumentoconfiguracion and r.idsiq_Apregunta=i.idsiq_Apregunta and i.codigoestado=100)
                     WHERE r.idsiq_Ainstrumentoconfiguracion='".$_REQUEST['id']."' and i.idsiq_Aseccion in (".$val.")
                     and r.codigoestado=100 and r.cedula='".$_REQUEST['cedula']."' ";
            
            $dataS2 = $db->Execute($sql_cp);
            $valorR=0; $TvalorR=0; $tT=0; $j=0;
            foreach($dataS2 as $val2){
               // $valorR=($val2['valor']*5);
                $valorR=$val2['valor'];
                $TvalorR=($valorR*100)/($TV_s1);
                $tT=$tT+$TvalorR;
                
            }
                            
              
               if($i==0){ 
                   $dataR[]=round($tT);
                   $dataT[]='ARTE Y DISEÑO';
                   $dataTt['ARTE Y DISENO']=$tT;
               }else if($i==1){
                   $dataR[]=round($tT); 
                   $dataT[]='CIENCIAS NATURALES Y DE LA SALUD';
                    $dataTt['CIENCIAS NATURALES Y DE LA SALUD']=$tT;
               }else if($i==2){
                   $dataR[]=round($tT);  
                   $dataT[]='CIENCIAS SOCIALES Y HUMANIDADES';
                    $dataTt['CIENCIAS SOCIALES Y HUMANIDADES']=$tT;
               }else if($i==3){
                   $dataR[]=round($tT);
                   $dataT[]='INGENIERIA Y ADMINSTRACIÓN';
                    $dataTt['INGENIERIA Y ADMINSTRACION']=$tT;
               }
            //$dataR[]=$tT;
            $i++;
            }   
  
            $maxValue = max($dataTt);
            $maxIndex = array_search(max($dataTt), $dataTt);
            
            $idaspirante=$dataC['idsiq_Apublicoobjetivocsv'];
            $cedula=$dataC['cedula'];
            // Guardar el resultado de la prueba presentada.       
            $SQL_insertResult = "UPDATE `siq_Apublicoobjetivocsv`
                SET `texto` = '$maxIndex'
                WHERE
                    (`idsiq_Apublicoobjetivocsv` = '$idaspirante')
                AND(`cedula` = '$cedula')
                LIMIT 1";
            $resultInsert = $db->Execute($SQL_insertResult);  
          
          if($resultInsert==false){
              echo "Error al insertar ";
          }else{
            /*
              * Caso 
              * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
              * Ajuste de textos de el resultado de el resultado por cada área académica de acuerdo a la solicitud de Mercadeo.
              * @since Mayo 23, 2018.    
            */  
            if($maxIndex=='ARTE Y DISENO'){
                $Titext="<center><b>ARTE Y DISE&Ncaron;O<br><br></b></center>";
                $url = "https://conectandomeconlau.com.co/artes-y-diseno/";
                $text=" 
                  Si te salió esta área de conocimiento debes saber que son profesionales que usan
                múltiples técnicas artísticas en función de la creatividad, de manera que permiten al
                arte cumplir su papel y optimizar su participación en áreas concretas como la
                construcción, la comunicación, el entretenimiento, la tecnología, el mercado y la
                cultura.
                <br><br>
                
                Las carreras que podrías estudiar son: Arquitectura, Arte Dramático, Artes Plásticas,
                Diseño Industrial, Diseño de Comunicación, Formación Musical.<br><br>
                
                Si quieres conocer las diferentes carreras que tiene esta área de conocimiento
                <strong>descarga nuestras guías académicas</strong> y resuelve tus dudas acerca de la profesión
                que te apasiona.<br><br>
                ";
            }else if($maxIndex=='CIENCIAS NATURALES Y DE LA SALUD'){
                $Titext="<center><b>CIENCIAS NATURALES Y DE LA SALUD<br><br></b></center>";
                $url = "https://conectandomeconlau.com.co/ciencias-naturales-y-de-salud/";
                $text="
                  Si te salió esta área de conocimiento debes saber que son profesionales que se
               interesan por temas como: el funcionamiento del cuerpo humano, la preservación
               animal y la naturaleza.<br><br>
                
               Las carreras que podrías estudiar son: Biología, Enfermería 
               Instrumentación Quirúrgica, Medicina, Odontología, Optometría
               y Química Farmacéutica.<br><br>
                
               Si quieres conocer las diferentes carreras que tiene esta área de conocimiento
               <strong>descarga nuestras guías académicas</strong> y resuelve tus dudas acerca de la profesión
               que te apasiona.<br><br>
              ";
            }else if($maxIndex=='CIENCIAS SOCIALES Y HUMANIDADES'){
                $Titext="<center><b>CIENCIAS SOCIALES Y HUMANIDADES<br><br></b></center>";
                  $url = "https://conectandomeconlau.com.co/ciencias-sociales/";
                $text="
               Si te salió esta área de conocimiento debes saber que son profesionales que se
               involucran e interactuar con la sociedad analizando su comportamiento desde
               diferentes ángulos. También se relacionan con las Humanidades que son aquellas
               disciplinas que analizan la presencia del ser humano en el mundo.
              <br><br>
                
               Las carreras que podrías estudiar son: Ciencia Política, Derecho, Filosofía, Licenciatura en Educación Infantil
               Psicología, Licenciatura en Bilingüismo con Énfasis en la Enseñanza del Inglés.
               <br><br>
                
               Si quieres conocer las diferentes carreras que tiene esta área de conocimiento
               <strong>descarga nuestras guías académicas</strong> y resuelve tus dudas acerca de la profesión
               que te apasiona.<br><br>
              ";
            }else if($maxIndex=='INGENIERIA Y ADMINSTRACION'){
                $Titext=" <center><b>INGENIERIA Y ADMINSTRACI&#211;N<br><br></b></center>";
                $url = "https://conectandomeconlau.com.co/ingenieria-y-administracion/";
                $text="
                 Si te salió esta área de conocimiento debes saber que son profesionales que se
                interesan por entender y satisfacer las necesidades humanas a través de
                conocimientos científicos, tecnológicos, administrativos y organizacionales.<br><br>
                
                Las carreras que podrías estudiar son: Administración de Empresas, Bioingeniería,
                Ingeniería Ambiental, Ingeniería Electrónica, Ingeniería Industrial, Ingeniería de
                Sistemas, Negocios Internacionales, Contaduría Pública, Matemáticas y Estadística.<br><br>
                
                Si quieres conocer las diferentes carreras que tiene esta área de conocimiento
                <strong>descarga nuestras guías académicas</strong> y resuelve tus dudas acerca de la profesión
                que te apasiona.<br><br>
                ";
            }
            $nombre=$dataC['nombre'].' '.$dataC['apellido'];
            $correo=$dataC['correo'];
          }
            ?>
              <fieldset>
              <table border="0" aling="center">
                 
                  <tr>
                      <td colspan='2'><div style="text-align:justify; width: 1000px  " >
                          Hola <?php echo $dataC['nombre'].' '.$dataC['apellido'] ?>, identificado con D.I <?php echo $dataC['cedula']; ?>
                          ya tenemos el resultado de la prueba que hiciste con
                          nuestro test y el área de conocimiento con la que más te identificas según tus
                          habilidades y aptitudes es:<br><br> </div></td>
                  </tr>
                  <tr>
                      <td><label style=" font-size: 18px"><?php echo $Titext ?></label></td>
                  </tr>
				  
                  <tr>
                       <td colspan='2' align='center' style=' alignment-adjust: central; text-align:center;'>
                           <?php
                                $MyData = new pData();  
                                $MyData->addPoints($dataR,"Areas");
                                $MyData->setAxisName(0,"Porcentaje");
                                $MyData->addPoints($dataT,"Porcentaje");
                                $MyData->setSerieDescription("Porcentaje","Porcentaje");
                                $MyData->setAbscissa("Porcentaje");

                                $myPicture = new pImage(500,300,$MyData);

                                $myPicture->setGraphArea(50,30,500,250);
                          
                                $myPicture->setFontProperties(array("FontName"=>"../../pChart/fonts/pf_arma_five.ttf","FontSize"=>6));
                          
                               /*     
                               $scaleSettings = array("XMargin"=>15,"YMargin"=>15,"Floating"=>TRUE,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
                               $scaleSettings = array("CycleBackground"=>TRUE,"LabelRotation"=>15,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10);
                               $myPicture->drawScale($scaleSettings);
                          
                                //echo '<pre>', print_r($myPicture); 
                          
                                $settings = array("Gradient"=>TRUE, "DisplayValues"=>TRUE, "Rounded"=>TRUE, "DisplayR"=>0, "DisplayG"=>0, "DisplayB"=>0, "DisplayShadow"=>TRUE);
                          
                                $myPicture->drawBarChart($settings);

                                $myPicture->drawLegend(400,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

                                $myPicture->Render("graficas/grafica_".$_REQUEST['cedula'].".png");
                          
                                //echo '<pre>', print_r($myPicture); die;
                                
                            */
                                ?>

                            <!--<img alt="Line chart" src="graficas/grafica_<?php echo $_REQUEST['cedula'] ?>.png" width="650px" style="border: 1px solid gray;"/>-->
                      </td>
           
                  </tr>
                  
                  <tr>
                      <td colspan='2' style=' alignment-adjust: central; text-align: justify;'>
                          <br><br><?php echo $text ?>
                          <br>
                      </td>
                  </tr>
                  <tr>
                      <td colspan='2' style=' alignment-adjust: central; text-align:center;' >
                          <br><br>
                          <a href='enviar_prueba_intereses.php?id=<?php echo $_REQUEST['id'] ?>&cedula=<?php echo $_REQUEST['cedula'] ?>&mayor=<?php echo $maxIndex?>&nombre=<?php echo  $nombre ?>&correo=<?php echo $dataC['correo'] ?>'><img alt="Enviar por Correo" src="../../images/e_mail.png" width="80px" heigth='80px' title="Enviar resultados por Correo"/></a>
                          <a href='pdf_prueba_intereses.php?id=<?php echo $_REQUEST['id'] ?>&cedula=<?php echo $_REQUEST['cedula'] ?>&mayor=<?php echo $maxIndex?>&nombre=<?php echo $nombre ?>&correo=<?php echo $dataC['correo'] ?>'><img alt="Ver PDF" src="../../images/cargar.jpg" width="80px" heigth='80px' title="Descargar Resultado en PDF" /></a>
                      </td>
                  </tr>
                  <tr>
                      <td colspan='2' style=' alignment-adjust: central; text-align:center;'>
                        <br>
                        <a href="<? echo $url ?>" target="_blank">
                            <input type="button"  title="Conoce más sobre tu Vocación" class="boton" style="cursor:pointer" value="Mas Información"/>
                        </a>  
                        </br>
                     </td>
                  </tr>
              </table>
             </fieldset>
  </form>
  </center>
</DIV>
 <script type="text/javascript">
    setTimeout(function(){window.top.location="<?php echo $url ?>"} , 5000);
</script>
