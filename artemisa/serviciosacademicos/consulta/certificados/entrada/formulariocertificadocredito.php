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
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<form name="form1" method="get" action="../certificadocreditos.php">
<p align="center"><span class="Estilo1"><span class="Estilo3">SELECCIÓN DE PERIODOS </span></span></p>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
	   <tr bgcolor="#C5D5D6" class="Estilo2">
      <td colspan="2" align="center">Campos adicionales en el certificado</td>
	  </tr>
	  <tr class="Estilo2">
		<td colspan="1">

		  <input type="radio" name="tipocertificado" value="todo" >Todo<br>
		<!--  <input type="radio" name="tipocertificado" value="reglamento" checked>
		  Aplicar Reglamento<br>-->
<?php
       $query_situacioncarreraestudiante = "SELECT * from estudiante
	where codigoestudiante = '".$solicitud_historico['codigoestudiante']."'
	and codigosituacioncarreraestudiante like '4%'";

	$res_situacioncarreraestudiante       = mysql_query($query_situacioncarreraestudiante, $sala) or die(mysql_error());
	$solicitud_situacioncarreraestudiante = mysql_fetch_assoc($res_situacioncarreraestudiante);
    $total_situacioncarreraestudiante     = mysql_num_rows($res_situacioncarreraestudiante);

    // $total_situacioncarreraestudiante;
  //  print_r($solicitud_situacioncarreraestudiante);

   if ($total_situacioncarreraestudiante >= '1')
   {
?>

		  <input type="radio" name="tipocertificado" value="pasadas">Materias Pasadas<br>

<?php
   }


?>

        </td>
		<td colspan="1">
          <input name="concredito" type="checkbox" value="1">Créditos<br>
           <TD id="tdtitulogris"> <label id="labelgrande">Crédito Pais</label><div align="justify">
            <td><select name="pais" id="pais" onchange="document.fsel.submit()">
                                    <option value="" selected>Seleccionar</option>
<?php
echo $query_pais = "SELECT * FROM pais where idpais  in (1,239,11,6)";
$pais = $db->Execute($query_pais);
$totalRows_pais = $pais->RecordCount();
$row_pais = $pais->FetchRow();
do {
    $selected = " ";
    if ($row_pais['idpais'] == $_REQUEST['pais'])
        $selected = "selected";
?>
                                        <option value="<?php echo $row_pais['idpais']; ?>" <?php echo $selected; ?>>
                                    <?php echo $row_pais['nombrepais']; ?>
                                    </option>
                                    <?php
                                }
                                while ($row_pais = $pais->FetchRow());
                                    ?>
                                </select>
               
	    <input name="maxcredito" colspan="2"type="checkbox" value="1">Máximo Créditos <br>
          <input name="mincredito" colspan="2" type="checkbox" value="1">Mínimo Créditos <br>
                
		<!-- <input name="tiponota"   type="checkbox" value="2">Tipo de nota<br />
          <input name="ppsa"   type="checkbox" value="3">Promedio Ponderado Semestral Acumulado</td>-->
    
	  <tr class="Estilo2">
	    <td colspan="2" bgcolor="#C5D5D6"><div align="center">Todos los Periodos</div></td>
		 <td colspan="2"><div align="center" class="Estilo1"><input type="checkbox" onClick="HabilitarTodos(this)"></div></td>
	  </tr>
	  <tr bgcolor="#C5D5D6" class="Estilo2">
		<td   colspan="2"align="center">Periodo&nbsp;</td>
		<td   colspan="2"align="center" bgcolor="#C5D5D6">Seleccionar&nbsp;</td>
    </tr>
 <?php
   $w= 1;
   do{ ?>
      <tr class="Estilo1">
		<td  colspan="2"><?php
                echo $solicitud_historico['nombreperiodo'];?>&nbsp;</td>
		<td   colspan="4"align="center"><input type="checkbox" name="periodo<?php
                echo $w;
                ?>" title="periodo" value="<?php
                echo $solicitud_historico['codigoperiodo'];
                ?>">&nbsp;</td>
     </tr>
<?php
    $w++;
   }while($solicitud_historico = mysql_fetch_assoc($res_historico));?>

     <tr bgcolor="#C5D5D6" class="Estilo2">
		<td  colspan="4"align="center">Fecha de expedici&oacute;n</td>
		<td  colspan="4"align="center" bgcolor="#C5D5D6">
			<input type="text" value="<?=date('d/m/Y')?>" id="fechaexpedicion" name="fechaexpedicion"
                               size='10' style='text-align:center' maxlength='10' readonly="readonly">
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

    <?
   echo $fechaexp='';
    ?>

</table>
<p>
  </p>
<p align="center">

    <input type="hidden" name="codigo" value="<?php echo $codigoestudiante ;?>">
    <input type="hidden" name="codigocarrera" value="<?php echo $solicitud_historico['codigocarrera'] ;?>">
   <input type="hidden" name="totalperiodos" value="<?php echo $total_periodos;?>">
   <input type="submit" name="Submit" value="Continuar">
  <input type="button" value="Regresar" onclick="javascript:history.back();">
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






