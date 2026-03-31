<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.AZUL {color: #0000FF;Tahoma;font-size: 14px; font-weight: bold;}
-->
</style>
<script language="JavaScript1.2">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

<script language="javascript">
function enviar()
{
	document.aplicaarp.submit();
}
</script>

<?php 
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
?>
<?php
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica where codigomodalidadacademica='".$_GET['modalidadacademica']."'";

$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_tomaideempresasalud = "SELECT idempresasalud, nombreempresasalud FROM empresasalud";
$tomaideempresasalud = mysql_query($query_tomaideempresasalud, $sala) or die(mysql_error());
$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
$totalRows_tomaideempresasalud = mysql_num_rows($tomaideempresasalud);

mysql_select_db($database_sala, $sala);
$query_tomatipoconcepto = "SELECT codigoconcepto, nombreconcepto FROM concepto where codigoreferenciaconcepto='100' order by nombreconcepto ASC";
$tomatipoconcepto = mysql_query($query_tomatipoconcepto, $sala) or die(mysql_error());
$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
$totalRows_tomatipoconcepto = mysql_num_rows($tomatipoconcepto);



?>


<form name="aplicaarp" method="post" action="">
  <p align="center" class="Estilo3">ARP - CONSULTAR REGISTROS</p>
  <table width="60%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
          <td bgcolor='#FEF7ED'><div align="center"><?php echo $_GET['codigoperiodo']?></div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica</div></td>
          <td bgcolor='#FEF7ED'>
              <div align="center"><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?>
                <?php if(isset($_GET['modalidadacademica']) or isset($_GET['modalidadacademica']))
                {
                	mysql_select_db($database_sala, $sala);
                	if(isset($_POST['modalidadacademica']))
                	{
                		$query_carrerapormodalidad = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
		WHERE c.codigomodalidadacademica = '".$_POST['modalidadacademica']."' ORDER by c.nombrecarrera asc";
                	}
                	if(isset($_GET['modalidadacademica']))
                	{
                		$query_carrerapormodalidad = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
		WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' ORDER by c.nombrecarrera asc";
                	}
                	$carrerapormodalidad = mysql_query($query_carrerapormodalidad, $sala) or die(mysql_error());
                	$row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad);
                	$totalRows_carrerapormodalidad = mysql_num_rows($carrerapormodalidad);
   ?>
              </div></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
          </tr>
		</table> 
	    <?php echo "<table>";
	    do
	    {
	    	$chequear="";
	    	$query_verifica_chequeado="select idaplicaarp from aplicaarp where codigoperiodo='".$_GET['codigoperiodo']."' and codigocarrera='".$row_carrerapormodalidad['codigocarrera']."' and codigotipoaplicaarp='100'";
	    	//echo $query_verifica_chequeado;
	    	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
	    	$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
	    	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
	    	if ($row_verifica_chequeado > 0){$chequear="<img src='../../../../imagenes/ok.PNG' width='16' height='16'>";}
	    	echo "<tr>
			<td align='center' valign='bottom'>$chequear</td>
			<td colspan='2'><span class='Estilo1'>


			<a href='aplicaarpconsultar_emergente.php?codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."&codigocarrera=".$row_carrerapormodalidad['codigocarrera']." '>".$row_carrerapormodalidad['nombrecarrera']."</a> 
			</span>&nbsp;</td>
			</tr>
		  ";}
	    	while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));
	  ?>
        <?php } echo "</table>"?>
  </table>
  <?php  
  if (isset($_GET['codigocarrera'])){
  	$codigocarrera=$_GET['codigocarrera'];
  	$query_consultacarrera = "SELECT * FROM aplicaarp a
	WHERE a.codigocarrera = '$codigocarrera' and codigotipoaplicaarp='100' and codigoperiodo='".$_GET['codigoperiodo']."'";
  	$consultacarrera = mysql_query($query_consultacarrera, $sala) or die(mysql_error());
  	$row_consultacarrera= mysql_fetch_assoc($consultacarrera);
  	$numrows_consultacarrera=mysql_num_rows($consultacarrera);
  }
?>
<br>
  <?php if (isset($_GET['codigocarrera']))
  { ?>
  <table width="60%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
		  
		  <?php 
		  $query_nomcarrera="select nombrecarrera from carrera where codigocarrera='".$_GET['codigocarrera']."'";
		  $nomcarrera=mysql_query($query_nomcarrera,$sala);
		  $carrera=mysql_fetch_assoc($nomcarrera);
		  echo $carrera['nombrecarrera'];
		  ?>&nbsp;</div></td>
          </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Aplica ARP<span class="Estilo4">*</span> </div></td>
          <td bgcolor='#FEF7ED'><p class="style2">
              <input name="nombreaplicaarp" type="text" id="nombreaplicaarp" value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['nombreaplicaarp'];}?>" />
          </p></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Empresa de Salud<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><select name="idempresasalud" id="idempresasalud">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $row_tomaideempresasalud['idempresasalud']?>"<?php if($row_consultacarrera>0){if($row_tomaideempresasalud['idempresasalud']==$row_consultacarrera['idempresasalud']){echo "selected";};}?>><?php echo $row_tomaideempresasalud['nombreempresasalud']?></option>
              <?php
              } while ($row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud));
              $rows = mysql_num_rows($tomaideempresasalud);
              if($rows > 0) {
              	mysql_data_seek($tomaideempresasalud, 0);
              	$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
              }
?>
            </select>
          </td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Porcentaje Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="porcentajeaplicaarp" type="text" id="porcentajeaplicaarp" value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['porcentajeaplicaarp'];}?>"/></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor fijo Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="valorfijoaplicaarp" type="text" id="valorfijoaplicaarp" value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['valorfijoaplicaarp'];}?>" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor base Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="valorbaseaplicaarp" type="text" id="valorbaseaplicaarp" value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['valorbaseaplicaarp'];}?>"></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><select name="codigoconcepto" id="codigoconcepto">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $row_tomatipoconcepto['codigoconcepto']?>"<?php if($row_consultacarrera>0){if($row_tomatipoconcepto['codigoconcepto']==$row_consultacarrera['codigoconcepto']){echo "selected";};}?>><?php echo $row_tomatipoconcepto['nombreconcepto']?></option>
              <?php
              } while ($row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto));
              $rows = mysql_num_rows($tomatipoconcepto);
              if($rows > 0) {
              	mysql_data_seek($tomatipoconcepto, 0);
              	$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
              }
?>
            </select>
          </td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre inicio de aplicaci&oacute;n ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="semestreinicioaplicaarp" type="text" id="semestreinicioaplicaarp"  value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['semestreinicioaplicaarp'];}?>" size="4" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre final de aplicaci&oacute;n ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="semestrefinalaplicaarp" type="text" id="semestrefinalaplicaarp"  value="<?php if($row_consultacarrera>0){echo $row_consultacarrera['semestrefinalaplicaarp'];}?>" size="4"/></td>
        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2" class="Estilo2"><div align="center">
              <input name="Grabar" type="submit" id="Grabar" value="Grabar">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Anular" type="submit" id="Anular" value="Anular">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Regresar2" type="submit" id="Regresar2" value="Regresar">			  
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <?php 
  if (isset($_POST['Anular']))
  {
  	//$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_GET['codigocarrera']."' AND p.codigoestadoperiodo = '1'";
  	//$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
  	//$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
  	//$query_modificar_aplicaarp="update aplicaarp set codigotipoaplicaarp='200' WHERE codigocarrera = '".$_GET['codigocarrera']."' and codigotipoaplicaarp='100'";
  	//echo $query_seleccionperiodoactivo;
  	//echo $query_modificar_aplicaarp;
  	$modificar_aplicaarp=mysql_query($query_modificar_aplicaarp,$sala);
  	if($modificar_aplicaarp)
  	{
  		echo "<script language='javascript'>alert('Datos modificados correctamente')</script>";
  		echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigocarrera=".$_GET['codigocarrera']."');</script>";
  	}
  	else
  	{
  		echo mysql_error();
  	}
  }
  }
    ?>
  
  <?php 

  if (isset($_POST['Grabar']))
  {
  	//decide que se va a ingresar datos nuevos, de lo contrario, se efectuar&aacute; update
  	if($numrows_consultacarrera==1)
  	{
  		$val_nombreaplicaarp=validar($_POST['nombreaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el Nombre Aplica ARP")</script>', true);
  		$val_idempresadesalud=validar($_POST['idempresasalud'],"requerido",'<script language="javascript">alert("No ha ingresado la empresa de salud")</script>', true);
  		$val_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el porcentaje de aplicaci&oacute;n ARP")</script>', true);
  		$val_num_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"flotante",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicaci&oacute;n ARP")</script>', true);
  		$val_numflot_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"porcentaje",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicaci&oacute;n ARP")</script>', true);
  		$val_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor fijo de aplicaci&oacute;n ARP")</script>', true);
  		$val_num_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor fijo de aplicaci&oacute;n ARP")</script>', true);
  		$val_concepto=validar($_POST['codigoconcepto'],"requerido",'<script language="javascript">alert("No ha ingresado el concepto de aplicaci&oacute;n ARP")</script>', true);
  		$val_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre inicio de aplicaci&oacute;n ARP")</script>', true);
  		$val_num_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre inicio de aplicaci&oacute;n ARP")</script>', true);
  		$val_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre final de aplicaci&oacute;n ARP")</script>', true);
  		$val_num_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre final de aplicaci&oacute;n ARP")</script>', true);
  		$val_semestres=validadosnumeros($_POST['semestreinicioaplicaarp'],$_POST['semestrefinalaplicaarp'],"mayor",'<script language="javascript">alert("El Semestre inicial de aplicaci&oacute;n ARP no puede ser mayor al semestre final de aplicaci&oacute;n  ARP")</script>',true);
  		$val_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor base de aplicaci&oacute;n ARP")</script>', true);
  		$val_num_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor base de aplicaci&oacute;n ARP")</script>', true);
  		if($val_nombreaplicaarp==true
  		and $val_idempresadesalud==true
  		and $val_porcentajeaplicaarp==true
  		and $val_num_porcentajeaplicaarp==true
  		and $val_numflot_porcentajeaplicaarp==true
  		and $val_valorfijoaplicaarp==true
  		and $val_num_valorfijoaplicaarp==true
  		and $val_concepto==true
  		and $val_semestreinicio==true
  		and $val_num_semestreinicio==true
  		and $val_semestrefinal==true
  		and $val_num_semestrefinal==true
  		and $val_semestres==true
  		and $val_valorbaseaplicaarp==true
  		and $val_num_valorbaseaplicaarp==true)
  		{
  			$query_fechas_periodo = "SELECT sp.idsubperiodo,sp.fechainicioacademicosubperiodo,sp.fechafinalacademicosubperiodo,sp.fechainiciofinancierosubperiodo,sp.fechafinalfinancierosubperiodo
			FROM subperiodo sp, carreraperiodo cp
			WHERE
			cp.codigoperiodo='".$_GET['codigoperiodo']."'
			AND sp.codigoestadosubperiodo like '1%'
			AND sp.idcarreraperiodo=cp.idcarreraperiodo
			AND cp.codigocarrera='".$_GET['codigocarrera']."'
			";
  			$fechas_periodo = mysql_query($query_fechas_periodo, $sala);
  			$row_fechas=mysql_fetch_assoc($fechas_periodo);

  			$query_modificar_aplicaarp="update aplicaarp set nombreaplicaarp='".$_POST['nombreaplicaarp']."',codigocarrera='".$_GET['codigocarrera']."',
			codigoperiodo='".$_GET['codigoperiodo']."',idempresasalud='".$_POST['idempresasalud']."',valorbaseaplicaarp='".$_POST['valorbaseaplicaarp']."',porcentajeaplicaarp='".$_POST['porcentajeaplicaarp']."',
			valorfijoaplicaarp='".$_POST['valorfijoaplicaarp']."',fechainicioaplicaarp='".$row_fechas['fechainiciofinancierosubperiodo']."',fechafinalaplicaarp='".$row_fechas['fechafinalfinancierosubperiodo']."',
			codigotipoaplicaarp='100',codigoconcepto='".$_POST['codigoconcepto']."',semestreinicioaplicaarp='".$_POST['semestreinicioaplicaarp']."',
			semestrefinalaplicaarp='".$_POST['semestrefinalaplicaarp']."' WHERE codigocarrera = '".$_GET['codigocarrera']."' and codigotipoaplicaarp='100'";
  			//echo $query_modificar_aplicaarp;
  			$modificar_aplicaarp=mysql_query($query_modificar_aplicaarp,$sala);
  			if($modificar_aplicaarp)
  			{
  				if(isset($_POST['modalidadacademica']))
  				{
  					echo "<script language='javascript'>alert('Datos modificados correctamente')</script>";
  					echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigocarrera=".$_GET['codigocarrera']."');</script>";
  				}

  				if(isset($_GET['modalidadacademica']))
  				{
  					echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigocarrera=".$_GET['codigocarrera']."');</script>";}
  			}
  			else
  			{
  				echo mysql_error();
  			}
  		}
  	}

  	elseif ($numrows_consultacarrera==0)
  	{
  		$val_nombreaplicaarp=validar($_POST['nombreaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el Nombre Aplica ARP")</script>', true);
  		$val_idempresadesalud=validar($_POST['idempresasalud'],"requerido",'<script language="javascript">alert("No ha ingresado la empresa de salud")</script>', true);
  		$val_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el porcentaje de aplicación ARP")</script>', true);
  		$val_num_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"flotante",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
  		$val_numflot_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"porcentaje",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
  		$val_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor fijo de aplicación ARP")</script>', true);
  		$val_num_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor fijo de aplicación ARP")</script>', true);
  		$val_concepto=validar($_POST['codigoconcepto'],"requerido",'<script language="javascript">alert("No ha ingresado el concepto de aplicación ARP")</script>', true);
  		$val_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre inicio de aplicación ARP")</script>', true);
  		$val_num_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre inicio de aplicación ARP")</script>', true);
  		$val_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre final de aplicación ARP")</script>', true);
  		$val_num_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre final de aplicación ARP")</script>', true);
  		$val_semestres=validadosnumeros($_POST['semestreinicioaplicaarp'],$_POST['semestrefinalaplicaarp'],"mayor",'<script language="javascript">alert("El Semestre inicial de aplicación ARP no puede ser mayor al semestre final de aplicaci&oacute;n  ARP")</script>',true);
  		$val_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor base de aplicación ARP")</script>', true);
  		$val_num_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor base de aplicación ARP")</script>', true);
  		if($val_nombreaplicaarp==true
  		and $val_idempresadesalud==true
  		and $val_porcentajeaplicaarp==true
  		and $val_num_porcentajeaplicaarp==true
  		and $val_numflot_porcentajeaplicaarp==true
  		and $val_valorfijoaplicaarp==true
  		and $val_num_valorfijoaplicaarp==true
  		and $val_concepto==true
  		and $val_semestreinicio==true
  		and $val_num_semestreinicio==true
  		and $val_semestrefinal==true
  		and $val_num_semestrefinal==true
  		and $val_semestres==true
  		and $val_valorbaseaplicaarp==true
  		and $val_num_valorbaseaplicaarp==true)
  		{
  			$query_fechas_periodo = "SELECT sp.idsubperiodo,sp.fechainicioacademicosubperiodo,sp.fechafinalacademicosubperiodo,sp.fechainiciofinancierosubperiodo,sp.fechafinalfinancierosubperiodo
			FROM subperiodo sp, carreraperiodo cp
			WHERE
			cp.codigoperiodo='".$_GET['codigoperiodo']."'
			AND sp.codigoestadosubperiodo like '1%'
			AND sp.idcarreraperiodo=cp.idcarreraperiodo
			AND cp.codigocarrera='".$_GET['codigocarrera']."'
			";
  			$fechas_periodo = mysql_query($query_fechas_periodo, $sala);
  			$row_fechas=mysql_fetch_assoc($fechas_periodo);

  			$query_insertar_aplicaarp="insert into aplicaarp(nombreaplicaarp,codigocarrera,codigoperiodo,idempresasalud,valorbaseaplicaarp,
				porcentajeaplicaarp,valorfijoaplicaarp,fechainicioaplicaarp,fechafinalaplicaarp,codigotipoaplicaarp,codigoconcepto,
				semestreinicioaplicaarp,semestrefinalaplicaarp) 
				values ('".$_POST['nombreaplicaarp']."','".$_GET['codigocarrera']."','".$_GET['codigoperiodo']."',
				'".$_POST['idempresasalud']."','".$_POST['valorbaseaplicaarp']."','".$_POST['porcentajeaplicaarp']."','".$_POST['valorfijoaplicaarp']."',
				'".$row_fechas['fechainiciofinancierosubperiodo']."','".$row_fechas['fechafinalfinancierosubperiodo']."','100','".$_POST['codigoconcepto']."',
				'".$_POST['semestreinicioaplicaarp']."','".$_POST['semestrefinalaplicaarp']."')";
  			$insertar_aplicaarp=mysql_query($query_insertar_aplicaarp,$sala);
  			if($insertar_aplicaarp)
  			{
  				unset($val_idempresadesalud,$val_porcentajeaplicaarp,$val_num_porcentajeaplicaarp,$val_numflot_porcentajeaplicaarp,$val_valorfijoaplicaarp,
  				$val_num_valorfijoaplicaarp,$val_concepto,$val_semestreinicio,$val_semestrefinal,$val_num_semestrefinal,$val_semestres,$val_num_valorbaseaplicaarp,$val_num_valorbaseaplicaarp);
  				if(isset($_POST['modalidadacademica']))
  				{
  					echo "<script language='javascript'>alert('Datos ingresados correctamente')</script>";
  					echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigocarrera=".$_GET['codigocarrera']."');</script>";
  				}

  				if(isset($_GET['modalidadacademica']))
  				{
  					echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigocarrera=".$_GET['codigocarrera']."&modalidadacademica=".$_GET['modalidadacademica']."');</script>";
  				}
  			}

  			else
  			{
  				echo mysql_error();
  			}
  		}
  		else
  		{
  			echo "<script language='javascript'>history.go(-1);</script>";
  		}
  	}


     ?>
  <br>

  
    <?php } ?>


    
  <p>&nbsp;</p>
</form>
<?php
if(isset($_POST['Regresar']))
{
	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
}
if(isset($_POST['Regresar2']))
{
	echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica'].");</script>";
}
?>



<?php
@mysql_free_result($sel_modalidadacademica);
@mysql_free_result($sel_codigocarrera);
@mysql_free_result($carrerapormodalidad);

?>
