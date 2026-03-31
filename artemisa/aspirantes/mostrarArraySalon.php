<?php

session_start();

header('Content-Type: text/html; charset=UTF-8');

$direccionsitioadmision=$_SESSION['array_salon']['direccionsitioadmision'];

$telefonositioadmision=$_SESSION['array_salon']['telefonositioadmision'];

$horainicialhorariodetallesitioadmision=$_SESSION['array_salon']['horainicialhorariodetallesitioadmision'];

$codigosalon=$_SESSION['array_salon']['codigosalon'];

$nombresalon=$_SESSION['array_salon']['nombresalon'];

list($fecha,$hora)=explode(" ",$_SESSION['array_salon']['fechainiciohorariodetallesitioadmision']);

list($ano,$mes,$dia)=explode("-",$fecha);

echo "Señor(a) Aspirante:<br>";

echo "<br>";

echo "  Usted ha sido citado para presentar el exámen de admisión en $direccionsitioadmision";

echo " el día $dia de ".devuelveMes($mes)." de $ano a las ".substr($horainicialhorariodetallesitioadmision,0,5);

echo " AM en el salón $codigosalon (".$nombresalon.").";  

/*
     * Se cambia la fecha de entrega de documentacion
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Modificado 12 de Septiembre de 2017.
 */
/*
    * Caso 100428
    * @modified Luis Dario Gualteros 
    * <castroluisd@unbosque.edu.co>
    * Se modifica el contenido del mensaje de acuerdo a la solicitud de la Facultad de Medicina (Diana Sanchez).
    * @since Mayo 9 de 2018.
*/

if($_GET["codigomodalidadacademica"]=="200"){
    echo "<br>Por favor traer: Lápiz (mirado 2), borrador, tajalápiz, el documento de identidad con el que se inscribió y copia del recibo de pago.<br> El día del exámen no se recibirá documentación.";
   /*
    * Caso 106232
    * Modificado por Luis Dario Gualteros <castroluisd@unbosque.edu.co>
    * Se documenta el siguiente mensaje de acuerdo a la solicitud de registro y control.
    * @since Octubre 12 de 2018.
    */
    //echo "Esta la deben presentar impresa el dia 15 de ".devuelveMes($mes)." de $ano, <strong>únicamente</strong>  las personas que sean citadas a la entrevista.";
    //End Caso 106232.
}
//End  Caso 100428
//End
function devuelveMes($mes){

		switch ($mes){

			case 1:

				$mes="enero";

				break;

			case 2:

				$mes="febrero";

				break;

			case 3:

				$mes="marzo";

				break;

			case 4:

				$mes="abril";

				break;

			case 5:

				$mes="mayo";

				break;

			case 6:

				$mes="junio";

				break;

			case 7:

				$mes="julio";

				break;

			case 8:

				$mes="agosto";

				break;

			case 9:

				$mes="septiembre";

				break;

			case 10:

				$mes="octubre";

				break;

			case 11:

				$mes="noviembre";

				break;

			case 12:

				$mes="diciembre";

				break;

		}

		return $mes;

	}

?>