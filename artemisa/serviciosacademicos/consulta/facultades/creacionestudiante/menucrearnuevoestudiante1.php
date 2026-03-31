<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
    
require_once('../../../Connections/sala2.php');
session_start();

	  $usuario = $_SESSION['MM_Username'];	
	  mysql_select_db($database_sala, $sala);
	  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
	  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	  $row_tipousuario = mysql_fetch_assoc($tipousuario);
	  $totalRows_tipousuario = mysql_num_rows($tipousuario);
   
   if ($row_tipousuario['codigotipousuariofacultad'] == 200)
   {
     echo '<script language="JavaScript">window.location.href="modificarnuevoestudiante.php";</script>';					
   } 
?>
<html>
<head>
<title> Menu para creacion de estudiantes</title>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
-->
</style>
<body>
<form name="form1" method="post" action="menucrearnuevoestudiante1.php">
<?php
if($_POST['opcion'] == '1')
{
//	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=validarcrearnuevoestudiante.php'>";
   	exit();  
}
else if($_POST['opcion'] == '2')
{
//	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=modificarnuevoestudiante.php'>";
   	exit();  
}
else if($_POST['opcion'] == '3')
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=visualizarestudiante.php'>";
   	exit();  
}
?>
 
 
  <p align="center" class="Estilo1"><strong>Seleccione una opci&oacute;n </strong></p>
  <table width="20%"  border="1" align="center"  bordercolor="#003333">
    <tr>
      <td><select name="opcion" id="opcion">
        <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Seleccionar</option>
     <!--   <option value="1" <?php if (!(strcmp(1, 0))) {echo "SELECTED";} ?>>Crear Nuevo Estudiante</option>
        <option value="2" <?php if (!(strcmp(2, 0))) {echo "SELECTED";} ?>>Modificar datos Estudiante</option>-->
		<option value="3" <?php if (!(strcmp(3, 0))) {echo "SELECTED";} ?>>Visualizar datos Estudiante</option>
      </select></td>
    </tr>
  </table>
  <p align="center"><input name="enviar" type="submit" id="enviar" value="Ingresar">
  </p>
</form>
</body>
</html>
