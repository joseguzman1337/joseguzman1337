<?php
session_start();
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../Connections/salaado.php'); 
//require_once('../../funciones/sala/estudiante/estudiante.php'); 
//require_once('claseencuesta.php'); 
//require_once('visualizarencuesta.php'); 
//require_once('almacenarreporteinferencia.php'); 
if(isset($_GET['debug']))
{
	$db->debug = true; 
}
?>
<?php
//print_r($_POST);

//$codigoperiodo = 20061;
//$tiporeporte = 'estudiantes';
$tipoencuesta = 'estudiantes';
$codigoestudiante = $_SESSION['codigo'];
//$codigocarrera = '124';
//$idencuesta = '1';
/*echo "<pre>";
print_r($_SERVER);
echo "</pre>";*/
unset($respuestas);
$fechainiciodetalleencuesta = $_POST['fechainiciodetalleencuesta'];
if(isset($_POST['Enviar']))
{
	$debeguardar = true;
	foreach($_POST as $key => $value) :
		if(ereg('^esta',$key))
		{
			$idrespuesta = ereg_replace('esta','',$key);
			if(isset($_POST['rta'.$idrespuesta]))
			{
				if($_POST['rta'.$idrespuesta] == 'true')
					$value = 1;
				else
					$value = 0;
				$respuestas[$idrespuesta] = $value;
			}
			else
			{
				//echo "<br>$idrespuesta";
				$debeguardar = false;
			}
		}
	endforeach;
	if(!$debeguardar)
	{
?>
<script language="javascript">
	alert("Todas las respuestas son requeridas");
</script>
<?php			
	}
	else
	{
/*?>
<script language="javascript">
	alert("Debe almacenar los resultados de la encuesta");
</script>
<?php*/			
	}
	/*echo "<pre>";
	print_r($respuestas);
	echo "</pre>";*/
}

switch($tipoencuesta)
{
	case 'estudiantes':
		$encuesta = new encuesta($idencuesta, $codigoestudiante);
		/*$idencuesta = '';*/
		//print_r($encuesta);
		if($encuesta->idencuesta != "")
		{
			if($debeguardar)
			{
				$encuesta->insertarRespuestas($respuestas, $fechainiciodetalleencuesta);
				//$encuesta->guardar_encuesta();
?>
<script language="javascript">
	alert("La encuesta ha sido diligenciada satisfactoriamente, puede continuar con su proceso de inscripción");
</script>
<!-- <h1>La encuesta ha sido diligenciada satisfactoriamente</h1> -->
<?php
			}		
			if(!$encuesta->diligencio_encuesta())
			{
				//print_r($encuesta);
				$encuesta->visualizar();
			}
		}
	break;
	
	default:
	break;
}
if(!$encuesta->diligencio_encuesta()&&$encuesta->encuestaactiva)
{
	//echo "Encuerntre haber";
	exit();
}
?>

