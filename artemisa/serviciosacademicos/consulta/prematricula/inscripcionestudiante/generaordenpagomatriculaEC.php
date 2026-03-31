<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');

require_once('../../../funciones/funcionip.php');

session_start();

$ruta = "../../../funciones/";

$rutaorden = "../../../funciones/ordenpago/";

require_once($rutaorden.'claseordenpago.php');

mysql_select_db($database_sala, $sala);


		$ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
		
		if(!$ordenesxestudiante->validar_generacionordenesmatricula())

		{?>

		<script language="javascript">

			history.go(-1);

		</script>

	<?php
		exit();
		die;

		} else {
			$ordenesxestudiante->generarordenpago_matricula();
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=./pagoderechosmatricula.php?documentoingreso=".$_GET['documentoingreso']."&codigoestudiante=".$_GET['codigoestudiante']."&menuprincipal=1'>";			
			die;	
		}
		
	?>	
</div>

</body>


</html>

