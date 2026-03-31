<?php
require_once('../../../Connections/sala2.php');
require('funcionvalidafallas.php');
session_start();

$usuario = $_SESSION['MM_Username'];
$carrera = $_SESSION['codigofacultad'];


if ($_POST['seguro'])
 {
	unset($_SESSION['study']);
	$totales = $_POST['total'];
	for ($i=1;$i<$totales;$i++)
	{
	 if ($_POST['periodo'.$i] == true)
	  {
		 $_SESSION['study'][] = $_POST['periodo'.$i];
		 // echo $_POST['periodo'.$i],"<br>";
	  }
	}

   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cierresemestreoperacion.php'>";
   exit();
 }
if ($_POST['cancelar'])
 {
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cierresemestreaviso.php'>";
  exit();
 }
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {
	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
.Estilo5 {font-family: tahoma; font-size: xx-small; }
-->
</style>
<br><br><br><br>
<form name="f01" action="listafallas.php" method="post">
<?php
mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT *
FROM periodo p,carreraperiodo cp
WHERE codigoestadoperiodo = '3'
AND cp.codigoperiodo = p.codigoperiodo
AND cp.codigocarrera = '$carrera'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  }
else
  {
    $query_periodo = "SELECT *
	FROM periodo p,carreraperiodo cp
	WHERE codigoestadoperiodo = '1'
	AND cp.codigoperiodo = p.codigoperiodo
	AND cp.codigocarrera = '$carrera'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);
    $periodoactual = $row_periodo['codigoperiodo'];
  }
 $w = 1;
 $per = "";
 $query_estudiantes = "SELECT DISTINCT e.codigoestudiante,p.semestreprematricula,eg.numerodocumento,CONCAT(apellidosestudiantegeneral,' ',nombresestudiantegeneral) AS nombre
 FROM estudiante e,prematricula p,estudiantegeneral eg,detalleprematricula d
 WHERE p.codigoestudiante = e.codigoestudiante
 AND e.idestudiantegeneral = eg.idestudiantegeneral
 AND p.idprematricula = d.idprematricula
 AND p.codigoperiodo = '$periodoactual'
 AND p.codigoestadoprematricula LIKE '4%'
 AND d.codigoestadodetalleprematricula LIKE '3%'
 AND e.codigocarrera = '$carrera'
 ORDER BY 1";
 $estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
 $row_estudiantes = mysql_fetch_assoc($estudiantes);
 $totalRows_estudiantes = mysql_num_rows($estudiantes);
 $banderasfallas  = 1;
 do{
       $codigoestudiante = $row_estudiantes['codigoestudiante'];

	   $query_cierre = "SELECT m.nombremateria,m.codigomateria,d.codigomateriaelectiva,m.numerocreditos,g.idgrupo,p.codigoestudiante
	   FROM prematricula p,detalleprematricula d,materia m,grupo g
	   WHERE  p.codigoestudiante = '".$codigoestudiante."'
	   AND p.idprematricula = d.idprematricula
	   AND d.codigomateria = m.codigomateria
	   AND d.idgrupo = g.idgrupo
	   AND m.codigoestadomateria = '01'
	   AND g.codigoperiodo = '$periodoactual'
	   AND p.codigoestadoprematricula LIKE '4%'
	   AND d.codigoestadodetalleprematricula LIKE '3%'";
	   $cierre= mysql_query($query_cierre, $sala) or die(mysql_error());
	   $row_cierre= mysql_fetch_assoc($cierre);
	   $totalRows_cierre= mysql_num_rows($cierre);

       do{
	      unset($resultado);
		  $resultado = validafallas ($row_cierre['codigomateria'],$row_cierre['idgrupo'],$codigoestudiante,$sala);
	      if (is_array($resultado))
		   {
		      if ($banderasfallas == 1)
			   {
			      echo "<div align='center'>";
				  echo "<span align='center' class='Estilo2 Estilo23 Estilo27 Estilo1 Estilo3'>LISTA DE ESTUDIANTES QUE PERDERAN MATERIAS POR FALLAS</span>";
				  echo "</div>";
				  echo "<br>";
?>
		         <table align="center"  bordercolor="#FF9900" border="1" width="70%">
                 <tr>
                 <td>
<?php			  echo "<table align='center'>";
				  echo "<tr  bgcolor='#C5D5D6'>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Documento</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Estudiante</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Nombre Materia</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Fallas teoricas</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Fallas Practicas</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Cant. Actividades Teoricas</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>Cant. Actividades Practicas</strong></td>";
				  echo "<td align='center' class='Estilo1 Estilo4'><strong>No Aplica <input type='checkbox' onClick='HabilitarTodos(this)'></strong></td>";
				  echo "</tr>";
				  echo "<tr>";
				  echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
				  echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
				  echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
				  echo "</tr>";
				  echo "<tr>";
			   }
			  $valor = "";
			  $valor = $codigoestudiante."-".$row_cierre['codigomateria'];
			  $per   = "periodo$w";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$row_estudiantes['numerodocumento']."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$row_estudiantes['nombre']."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$row_cierre['nombremateria']."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$resultado[2]."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$resultado[3]."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$resultado[4]."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'>".$resultado[5]."</td>";
			  echo "<td align='center' class='Estilo1 Estilo4'><input type='checkbox' name='$per' title='periodo' value='$valor'></td>";
		      echo "</tr>";
			  //echo $row_cierre['codigomateria']."-".$codigoestudiante."-".$row_estudiantes['numerodocumento'];
			 $banderasfallas ++ ;
			 $w++;
			//echo $resultado[0],"  ",$resultado[1],"  ",$resultado[2],"  ",$resultado[3],"  ",$resultado[4],"  ",$resultado[5],"<br>";
		   }
	   }while($row_cierre= mysql_fetch_assoc($cierre));
 }while($row_estudiantes = mysql_fetch_assoc($estudiantes));

 if ($banderasfallas <> 1)
  {
    echo "<tr>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "<td align='center' class='Estilo1 Estilo4'>&nbsp;</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align='center' class='Estilo1 Estilo4' colspan='3'><STRONG>ESTA SEGURO DE GENERAR EL CIERRE ?</STRONG></td>";
	echo "<td align='center' class='Estilo1 Estilo4'><input name='seguro' type='submit' id='seguro' value='Generar Cierre'></td>";
	echo "<td align='center' class='Estilo1 Estilo4'><input name='cancelar' type='submit' id='cancelar' value='Cancelar'></td>";
	echo "</tr>";
	echo "</table>";
 ?>
 </td>
</tr>
</table>
<?php
 }
else
 {
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cierresemestreoperacion.php'>";
  exit();
 }
?>
<input type="hidden" name="total" value="<?php echo $w; ?>">
<script language="javascript">
function HabilitarTodos(chkbox, seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if(elemento.type == "checkbox")
		{
			if (elemento.title == "periodo")
			{
				elemento.checked = chkbox.checked
			}
		}
	}
}
</script>
</form>