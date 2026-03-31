<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
//session_start();
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$codigoestudiante = $_REQUEST['codigoestudiante'];
mysql_select_db($database_sala, $sala);
$usuario = 'auxsecgen';

    $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";
    //echo $query_tipousuario;
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario);

	 $query_historico = "SELECT distinct n.codigoperiodo, p.nombreperiodo, e.codigosituacioncarreraestudiante,e.codigoestudiante
	from notahistorico n, periodo p, estudiante e, carreraperiodo cp
	where n.codigoestudiante = '$codigoestudiante'
	and e.codigoestudiante = n.codigoestudiante
	and e.codigocarrera = cp.codigocarrera
	and cp.codigoperiodo = p.codigoperiodo
	and n.codigoperiodo = cp.codigoperiodo
	and n.codigoestadonotahistorico not like '2%'
	order by 1";
	 //echo $query_historico;
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
<form name="form1" method="get" action="../entrada/notaperiodosemestrepdf.php">
<p align="center"><span class="Estilo1"><span class="Estilo3">SELECCIÓN DE PERIODOS </span></span></p>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
	   <tr bgcolor="#C5D5D6" class="Estilo2">
      <td colspan="2" align="center">Campos adicionales en el certificado</td>
	  </tr>
	  <tr class="Estilo2">
		<td colspan="1">

		  <input type="radio" name="tipocertificado" value="todo" >Todo<br>
		  <input type="radio" name="tipocertificado" value="reglamento" checked>
		  Aplicar Reglamento<br>
<?php
       $query_situacioncarreraestudiante = "SELECT * from estudiante
	where codigoestudiante = '".$solicitud_historico['codigoestudiante']."'
	and codigosituacioncarreraestudiante like '4%'";
	
	$res_situacioncarreraestudiante       = mysql_query($query_situacioncarreraestudiante, $sala) or die(mysql_error());
	$solicitud_situacioncarreraestudiante = mysql_fetch_assoc($res_situacioncarreraestudiante);
    $total_situacioncarreraestudiante     = mysql_num_rows($res_situacioncarreraestudiante);
   
    // $total_situacioncarreraestudiante;
  //  print_r($solicitud_situacioncarreraestudiante);

 /*  if ($total_situacioncarreraestudiante >= '1')
   {
?>

		  <input type="radio" name="tipocertificado" value="pasadas">Materias Pasadas<br>

<?php
   }*/
 if ($row_tipousuario['codigotipousuariofacultad'] == 200)
 {
?>
   <input type="radio" name="tipocertificado" value="semestre">Certificado por Semestre
<?php
 }
?>

        </td>
		<td colspan="1">
          <input name="concredito" type="checkbox" value="1">Créditos &oacute; Ulas<br>
		  <input name="tiponota"   type="checkbox" value="2">Tipo de nota<br />
          <input name="ppsa"   type="checkbox" value="3">Promedio Ponderado Semestral Acumulado</td>
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
		<td><?php
                echo $solicitud_historico['nombreperiodo'];?>&nbsp;</td>
		<td align="center"><input type="checkbox" name="periodo<?php
                echo $w;
                ?>" title="periodo" value="<?php
                echo $solicitud_historico['codigoperiodo'];
                ?>">&nbsp;</td>
     </tr>
<?php
    $w++;
   }while($solicitud_historico = mysql_fetch_assoc($res_historico));?>
</table>
<p>
  </p>
<p align="center">

    <input type="hidden" name="codigo" value="<?php echo $codigoestudiante ;?>">
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
