<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__))."/../../../funciones/funciontiempo.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/validacion.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/errores_plandeestudio.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php' ); 


/*$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, e.numerocohorte, 
e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada
from estudiante e, estudiantegeneral eg, periodo p 
where e.codigoestudiante = '$codigoestudiante'
and e.idestudiantegeneral = eg.idestudiantegeneral
and e.codigoperiodo = p.codigoperiodo
and p.codigoestadoperiodo = '1'";
//echo "$query_horarioinicial<br>";
$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
	
// Si el query es vacio quiere decir que el estudiante ingreso en un periodo diferente al activo
if($totalRows_datosestudiante == "")
{
?>
<script language="javascript">
	alert("El estudiante no ingreso en el periodo activo, por lo tanto la generación de la orden debe hacerse manual");
	history.go(-1);
</script>
<?php
}
*/
?>
<html>
<head>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
.Estilo2 {font-size: small}
.Estilo3 {font-size: xx-small}
-->
</style>
<title>Digite fecha de pago</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<div align="center">
<form action="generarprimersemestretodos.php" name="f1" method="get">
<p align="center"><strong>Fecha de plazo de pago de la orden para todos los estudiantes nuevos 
</strong></p>
<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr> 
      <td bgcolor="#C5D5D6" class="Estilo2" align="center"> 
      <strong>Fecha*</strong></td>
      <td class="Estilo2" align="center">
	  <input type="text" name="fechapago" value="<?php if(isset($_GET['fechapago'])) { echo $_GET['fechapago']; }?>">aaaa-mm-dd
	  <span class="Estilo1"><font color="#FF0000" size="-2">
	  <?php
			if(isset($_GET['fechapago']))
			{
				//echo "entro";
				$fechapago = $_GET['fechapago'];
				$imprimir = true;
				$ffechapago = validar($fechapago,"fecha",$error3,&$imprimir);
				if($ffechapago != 0)
				{
					require('../insertarfecha.php');
				}
				else
				{
					$ffechapago = 0;
					echo "La fecha digitada no es correcta<br>";
				}
				$ffechapago = 1;
			}
?>
	  </font></span>	  </td>
    </tr>
	<tr>
	  <td colspan="2" align="center"><input type="submit" name="Aceptar" value="Aceptar"></td>
	</tr>
</table>
</form>
</div>
</body>
</html>
