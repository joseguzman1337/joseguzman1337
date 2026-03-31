<?php  
require_once('../../../Connections/sala2.php');
    session_start();
    $codigoestudiante = $_GET['codigo'];
	mysql_select_db($database_sala, $sala);

	$usuario = $_SESSION['MM_Username'];

    $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";
    //echo $query_tipousuario;
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario);

	require_once('nombrePromedio.php');

	$query_historico = "SELECT distinct n.codigoperiodo, p.nombreperiodo, e.codigosituacioncarreraestudiante,e.codigoestudiante,e.codigocarrera
	, pe.idplanestudio, (SELECT MAX(n.codigoperiodo)  
		from notahistorico n, periodo p, estudiante e, carreraperiodo cp
		where n.codigoestudiante = '$codigoestudiante' and e.codigoestudiante = n.codigoestudiante 
		and e.codigocarrera = cp.codigocarrera 
		and cp.codigoperiodo = p.codigoperiodo and n.codigoperiodo = cp.codigoperiodo and n.codigoestadonotahistorico not like '2%' 
		) AS maxperiodo
	from notahistorico n, periodo p, estudiante e, carreraperiodo cp, planestudioestudiante pe 
	where n.codigoestudiante = '$codigoestudiante'
	and e.codigoestudiante = n.codigoestudiante
	and e.codigocarrera = cp.codigocarrera
	and cp.codigoperiodo = p.codigoperiodo
	and n.codigoperiodo = cp.codigoperiodo
	and n.codigoestadonotahistorico not like '2%' 
	AND pe.codigoestudiante=e.codigoestudiante AND pe.codigoestadoplanestudioestudiante like '1%' 
	order by 1";
	// echo $query_historico;
	$res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
	$solicitud_historico = mysql_fetch_assoc($res_historico);
    $total_periodos = mysql_num_rows($res_historico);
	if($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100)
	{
		echo '<script language="JavaScript">alert("Este estudiante es Graduado, por lo que el certificado se expide en Secretaria General")</script>';
		echo '<script language="JavaScript">history.go(-1)</script>';
	}
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
.Estilo4 {color: #FF6600}
-->
</style>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<form name="form1" method="get" action="certificadosformulario.php">
<p align="center"><span class="Estilo1"><span class="Estilo3">SELECCIÓN DE PERIODOS</span></span></p>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
	   <tr bgcolor="#C5D5D6" class="Estilo2">
      <td colspan="2" align="center">Campos adicionales en el certificado</td>
	  </tr>
	  <tr class="Estilo2">
		<td colspan="1">
		  <input type="radio" name="tipocertificado" value="todo" >Todo<br> 
		  <?php if($solicitud_historico['idplanestudio'] != 622) { $checked="checked";} else {$checked="";} ?>
		  <input type="radio" name="tipocertificado" value="reglamento" <?php echo $checked; ?>>
		  Aplicar Reglamento<br>
<?php
   /* $query_planestudioestudiante = "SELECT p.idplanestudio
	from planestudioestudiante pe,planestudio p
	where codigoestudiante = '".$solicitud_historico['codigoestudiante']."'
	and p.idplanestudio = pe.idplanestudio
	and pe.codigoestadoplanestudioestudiante like '1%'
	and codigoestadoplanestudio like '1%'";
	// echo $query_historico;
	$res_planestudioestudiante = mysql_query($query_planestudioestudiante, $sala) or die(mysql_error());
	$solicitud_planestudioestudiante = mysql_fetch_assoc($res_planestudioestudiante);
    $total_planestudioestudiante = mysql_num_rows($res_planestudioestudiante);*/ // por Orden de Sec General 13-04-2007

	$query_situacioncarreraestudiante = "SELECT * from estudiante
	where codigoestudiante = '".$solicitud_historico['codigoestudiante']."'
	and codigosituacioncarreraestudiante like '4%'";
	//echo $query_situacioncarreraestudiante;
	$res_situacioncarreraestudiante       = mysql_query($query_situacioncarreraestudiante, $sala) or die(mysql_error());
	$solicitud_situacioncarreraestudiante = mysql_fetch_assoc($res_situacioncarreraestudiante);
    $total_situacioncarreraestudiante     = mysql_num_rows($res_situacioncarreraestudiante);
    // echo "$total_situacioncarreraestudiante       $total_planestudioestudiante";
    // if ($total_situacioncarreraestudiante >= '1' and  $total_planestudioestudiante == '0')
    //echo $total_situacioncarreraestudiante;
  //  print_r($solicitud_situacioncarreraestudiante);
   if ($total_situacioncarreraestudiante >= '1')
   {
?>

		  <input type="radio" name="tipocertificado" value="pasadas">Materias Pasadas<br>

<?php
   }
 if ($row_tipousuario['codigotipousuariofacultad'] == 200)
 {
?>
   <input type="radio" name="tipocertificado" value="semestre"><?php echo $nombrePeriodoTipoCertificado; ?><br>
<?php
 }
?>
<?php if($solicitud_historico['idplanestudio'] == 622) { $checked="checked";} else {$checked="";} ?>
		  <input type="radio" name="tipocertificado" value="equivalencias" <?php echo $checked; ?>>Certificar con Equivalencias

        </td>
		<td colspan="1">
          <input name="concredito" type="checkbox" value="1">Créditos &oacute; Ulas<br>
		  <input name="tiponota"   type="checkbox" value="2">Tipo de nota<br />
          <input name="ppsa"   type="checkbox" value="3"><?php echo $nombrePromPonderadoAcumulado; ?></td>
     </tr>
	  <tr class="Estilo2">
	    <td bgcolor="#C5D5D6"><div align="center">Todos los Periodos</div></td>
		 <td><div align="center" class="Estilo1"><input type="checkbox" onClick="HabilitarTodos(this)"></div></td>
	  </tr>
	  <tr bgcolor="#C5D5D6" class="Estilo2">
		<td align="center">Periodo&nbsp;</td>
		<td align="center" bgcolor="#C5D5D6">Seleccionar&nbsp;</td>
    </tr>
 <?php
   $w= 1;
   do{ ?>
      <tr class="Estilo1">
		<td><?php echo $solicitud_historico['nombreperiodo'];?>&nbsp;</td>
		<td align="center"><input type="checkbox" name="periodo<?php echo $w;?>" title="periodo" value="<?php echo $solicitud_historico['codigoperiodo']; ?>">&nbsp;</td>
     </tr>
<?php
    $w++;
   }while($solicitud_historico = mysql_fetch_assoc($res_historico));?>
     <tr bgcolor="#C5D5D6" class="Estilo2">
		<td align="center">Fecha de expedici&oacute;n</td>
		<td align="center" bgcolor="#C5D5D6">
			<input type="text" value="<?php echo date('d/m/Y'); ?>" id="fechaexpedicion" name="fechaexpedicion" size='10' style='text-align:center' maxlength='10' readonly>
			<input type="button" value="..." id="lanzador3" name="lanzador3">
			<script type="text/javascript">
				var cal3 = new Calendar.setup({
					 inputField     :    "fechaexpedicion",   // id of the input field
					 button         :    "lanzador3",  // What will trigger the popup of the calendar
					//button	: "fechaexpedicion",
					 ifFormat       :    "%d/%m/%Y"       // format of the input field: Mar 18, 2005
				});
			</script>
		</td>
    </tr>
</table>
<p>
  </p>
<p align="center">
  <input type="hidden" name="codigo" value="<?php echo $_GET['codigo'];?>">
  <input type="hidden" name="totalperiodos" value="<?php echo $total_periodos;?>">
  <input type="submit" name="Submit" value="Continuar">
  <script type="text/javascript">
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
</p>
</form>
