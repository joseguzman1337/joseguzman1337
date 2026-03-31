<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
session_start();
$usuario = $_SESSION['MM_Username'];
$carrera = $_SESSION['codigofacultad'];
$periodos = $_SESSION['codigoperiodosesion'];

 $periodo=encontrarPeriodoAnterior($periodos);

if ($_GET['buscar'])
  {
   require('reporteperdidamateriasformulario.php');   
   exit();
  }
        mysql_select_db($database_sala, $sala);
		$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
		$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
		$row_tipousuario = mysql_fetch_assoc($tipousuario);
		$totalRows_tipousuario = mysql_num_rows($tipousuario);

?>
<script language="javascript">
function enviar()
			{
				document.form1.submit();
			}
</script>
<style type="text/css">
<!--
.Estilo3 {font-size: xx-small}
-->
</style>
<?php	
 if ($row_tipousuario['codigotipousuariofacultad'] == 200)
   {
	
		mysql_select_db($database_sala, $sala);
		$query_materia = "SELECT *
						 FROM materia
						 WHERE codigocarrera = '$carrera'				     
					     AND codigoestadomateria = '01'
						 ORDER BY nombremateria";		
		//echo $query_materia;
		$materia = mysql_query($query_materia, $sala) or die(mysql_error());
		$row_materia = mysql_fetch_assoc($materia);
		$totalRows_materia = mysql_num_rows($materia);
	}
 else 
    {
       mysql_select_db($database_sala, $sala);
		$query_materia = "SELECT DISTINCT d.codigomateria,m.nombremateria
							FROM prematricula p,detalleprematricula d,estudiante e,materia m
							WHERE p.idprematricula = d.idprematricula
							AND p.codigoestudiante = e.codigoestudiante
							AND m.codigomateria = d.codigomateria
							AND p.codigoestadoprematricula LIKE '4%'
							AND d.codigoestadodetalleprematricula LIKE '3%'
							AND e.codigocarrera = '$carrera'
							and p.codigoperiodo = '$periodo'
							ORDER BY 2
";		
		$materia = mysql_query($query_materia, $sala) or die(mysql_error());
		$row_materia = mysql_fetch_assoc($materia);
		$totalRows_materia = mysql_num_rows($materia);
    } 
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {font-size: xx-small}
.Estilo13 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo14 {font-size: 12px}
-->
</style>
</head>
<div align="center" class="Estilo1">
<form name="form1" action="reporteperdidamateriasbuscar.php" method="get">
  <p class="Estilo13">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="303" bgcolor="#C6CFD0"><div align="center" class="Estilo14"> <strong>Seleccione la Materia :</strong>
      	  
      &nbsp;
	  </div></td>
	<td width="388"><span class="Estilo3"><select name="materia" id="materia" onChange="enviar()">
        <option value="0" <?php if (!(strcmp("0", $_GET['materia']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_materia['codigomateria']?>"<?php if (!(strcmp($row_materia['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_materia['nombremateria']?></option>
<?php
} while ($row_materia = mysql_fetch_assoc($materia));
  $rows = mysql_num_rows($materia);
?>
      </select>&nbsp;
	</span></td>
  </tr>
  <?php
 if(isset($_GET['materia']))
  {			
	    $query_grupo = "SELECT *
						 FROM grupo
						 WHERE codigomateria = '".$_GET['materia']."'				     
					     AND codigoestadogrupo = '10'
						 and codigoperiodo = '$periodo'";		
		$grupo = mysql_query($query_grupo, $sala) or die(mysql_error());
		$row_grupo = mysql_fetch_assoc($grupo);
		$totalRows_grupo = mysql_num_rows($grupo);		  
        //echo $query_grupo;
?>
  <tr>
    <td align="center" bgcolor="#C6CFD0"><span class="Estilo14"><strong>Seleccione el Grupo :</strong> &nbsp;&nbsp;</span></td>
    <td align="left">            
      <select name="grupo" id="grupo">
        <option value="0" <?php if (!(strcmp(0,$_GET['grupo']))) {echo "SELECTED";} ?>>Todos los Grupos</option>
        <?php
						do {  
						?>
        <option value="<?php echo $row_grupo['idgrupo']?>"<?php if (!(strcmp(0,$row_grupo['idgrupo']))) {echo "SELECTED";} ?>><?php echo $row_grupo['idgrupo'],"&nbsp;&nbsp;Grupo-",$row_grupo['nombregrupo'];?></option>
        <?php
						} while ($row_grupo = mysql_fetch_assoc($grupo));
						  $rows = mysql_num_rows($grupo);						  
						  ?>
      </select>
 &nbsp;</td>
  </tr>
   <tr>
    <td align="center" bgcolor="#C6CFD0"><span class="Estilo14"><strong>Filtrado Por:</strong> &nbsp;&nbsp;</span></td>
    <td align="left">
	<select name="estudiante">
      <option value="0">Todos Los estudiantes</option>
      <option value="1">Perdieron La Materia</option>
      <option value="2">Pasaron La Materia</option>  
	  <option value="3">Habilitan La Materia</option>     
    </select>      
 </td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Consultar">
  	  &nbsp;  	 
  	</span></td>
  </tr>
  <?php
  }
  ?>
</table>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.reload("reportematriculasbusqueda.php");
}
</script>
</html>
