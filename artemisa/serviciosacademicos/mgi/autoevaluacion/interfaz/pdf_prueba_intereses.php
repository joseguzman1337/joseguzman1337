<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
header('Content-Type: text/html; charset=ISO-8859-1'); 
include_once ('../../../Grados/lib/pdf/dompdf/dompdf_config.inc.php');

$id_instrumento=$_REQUEST['id'];
$cedula=$_REQUEST['cedula'];

$nombre=sanear_string($_REQUEST['nombre']);
//echo $nombre;



function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä','Ã¡'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A','a'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î','Ã­'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I','i'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
        '',
        $string
    );


    return $string;
}

$html = ' 
<img src="../../images/cabezote-pdf.png"   width="750" /></div>';
        $maxIndex=$_REQUEST['mayor'];
             /*
              * Caso 
              * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
              * Ajuste de textos de el resultado de el resultado por cada área académica de acuerdo a la solicitud de Mercadeo.
              * @since Mayo 23, 2018.    
             */      
             if($maxIndex=='ARTE Y DISENO'){
                $Titext="<center><b>ARTE Y DISE&Ntilde;O<br><br></b></center>";
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
                $Titext="<center><b>CIENCIAS SOCIALES Y HUMANIDADES</b></center>";
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
                $Titext=" <center><b>INGENIERIA Y ADMINSTRACI&Oacute;N<br><br></b></center>";
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
          
$html.= ' <br><br>
              <table border="0" aling="center">
                 
                  <tr>
                      <td colspan="2"><div style="text-align:justify; width: 700px  " >
                          Hola '.$nombre.', identificado con D.I '.$cedula.'
                          ya tenemos el resultado de la prueba que hiciste con
                          nuestro test y el área de conocimiento con la que más te identificas según tus
                          habilidades y aptitudes es:<br></div></td>
                  </tr>
                   <tr>
                      <td><div style="font-size: 16px; width: 700px"><center>'.$Titext.'</center></div></td>
                  </tr>
                                
                  <tr>
                      <td colspan="2">
                          <div style="text-align:justify; width: 700px  " >'.$text.'
                          </div>
                         
                      </td>
                  </tr>
              </table><br><br>';
$html.= ' 

<img src="../../images/pie-u-del-bosque.png"  width="750" height="50" />';

$dompdf = new DOMPDF();

// Especificamos la variable donde hemos recogido el html.
$dompdf->load_html($html);
$dompdf->render();

// Nos muestra el PDF con el titulo
$dompdf->stream("resultadosPruebaInteres.pdf");

exit();  ?>

