<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once ('../../dompdf/dompdf_config.inc.php');

$id_instrumento=$_REQUEST['id'];
$cedula=$_REQUEST['cedula'];
$nombre=$_REQUEST['nombre'];
$correo=$_REQUEST['correo'];

$html ='';
        $maxIndex=$_REQUEST['mayor'];
                 /*
                  * Caso 
                  * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                  * Ajuste de textos de el resultado de el resultado por cada área académica de acuerdo a la solicitud de Mercadeo.
                  * @since Mayo 23, 2018.    
                 */  
                if($maxIndex=='ARTE Y DISENO'){
                $Titext="<center><b>ARTE Y DISE&Ncaron;O<br><br></b></center>";
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
        
$html.= ' <table border="0" aling="center">
                 
                  <tr>
                      <td colspan="2"><div style="text-align:justify; width: 700px  " >
                          Hola '.$nombre.', identificado con D.I '.$cedula.'
                          ya tenemos el resultado de la prueba que hiciste con
                          nuestro test y el área de conocimiento con la que más te identificas según tus
                          habilidades y aptitudes es:<br><br> </div></td>
                  </tr>
                   <tr>
                      <td><label style="text-align:center;  font-size: 18px"><center>'.$Titext.'</center></label></td>
                  </tr><tr>
                      <td colspan="2">
                          <div style="text-align:justify; width: 700px  " >'.$text.'
                          </div>
                         
                      </td>
                  
                  <tr>
                      <td colspan="2" aling="cente" style="alignment-adjust: central; text-align:center;">
                         <a href="https://artemisa.unbosque.edu.co/serviciosacademicos/mgi/autoevaluacion/interfaz/phpcaptcha/Captcha_Resul.php?actionID=Externo" rel="nofollow">M&aacute;s Informaci&oacute;n</a>
                      </td>
                  </tr>
              </table><br><br>';

	$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: calamariaf@unbosque.edu.co <calamariaf@unbosque.edu.co>\r\n";
		mail($correo,'Prueba de Intereses',$html,$headers);
	
echo "<script>
    alert('Se envio el correo satisfactoriamente')
    location.href='resultados_prueba_interes.php?id=".$_REQUEST['id']."&cedula=".$_REQUEST['cedula']." '
</script>";

?>