<?php 
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
global $nombrefacturavalorpecuniario;
require_once('../../../funciones/clases/autenticacion/redirect.php');
//print_r($_POST);
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
mysql_select_db($database_sala, $sala);
$query_seleccionatipoestudiante = "SELECT codigotipoestudiante, nombretipoestudiante FROM tipoestudiante";
$seleccionatipoestudiante = mysql_query($query_seleccionatipoestudiante, $sala) or die(mysql_error());
$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
$totalRows_seleccionatipoestudiante = mysql_num_rows($seleccionatipoestudiante);
?>
<?php 
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica where codigomodalidadacademica='".$_GET['modalidadacademica']."'";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_tomatipoconcepto = "SELECT codigoconcepto, nombreconcepto FROM concepto where codigoreferenciaconcepto='700' order by nombreconcepto ASC";
$tomatipoconcepto = mysql_query($query_tomatipoconcepto, $sala) or die(mysql_error());
$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
$totalRows_tomatipoconcepto = mysql_num_rows($tomatipoconcepto);
?>
<script language="javascript">
function enviar()
{
	document.aplicaarp.submit()
}
</script>
  <script language="javascript">
  function HabilitarTodos(chkbox, seleccion)
  {
  	for (var i=0;i < document.forms[0].elements.length;i++)
  	{
  		var elemento = document.forms[0].elements[i];
  		if(elemento.type == "checkbox")
  		{
  			if (elemento.title == "carreras")
  			{
  				elemento.checked = chkbox.checked
  			}
  		}
  	}
  }
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="aplicaarp" method="post" action="">

  <p align="center" class="Estilo3">VALORES PECUNIARIOS - INSERTAR</p>
  <table width="80%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#FFFFFF">
        <tr>
          <td width="51%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica</div></td>
          <td width="49%" bgcolor='#FEF7ED'><p align="center" class="style2">
              <?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?></p></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
          <td bgcolor='#FEF7ED'><div align="center"><?php echo $_GET['codigoperiodo']?></div></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="style2">
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </span></div></td>
          </tr>
        <?php if(isset($_GET['modalidadacademica']) or isset($_POST['Enviar'])){ ?>
		<tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Aplicaci&oacute;n Masiva</div></td>
          <td bgcolor='#FEF7ED' class="Estilo1"><div align="center">SI
                  <input name="masivo" type="radio" value="si" onClick="enviar()"<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){echo 'checked="checked"';}?>/>
        NO
        <input name="masivo" type="radio" value="no" onClick="enviar()" <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){echo 'checked="checked"';}?> />
		
	<?php } ?>
          <span class="Estilo2">
          <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){ mysql_select_db($database_sala, $sala);
          $query_sel_codigocarrera = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
			WHERE c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."' 
			and c.codigomodalidadacademica = '".$_GET['modalidadacademica']."'  
			
			order by c.nombrecarrera
					";
          //and c.codigocarrera not in(select codigocarrera from facturavalorpecuniario where codigoperiodo='".$_GET['codigoperiodo']."')
          $sel_codigocarrera = mysql_query($query_sel_codigocarrera, $sala) or die(mysql_error());
          $row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
			$totalRows_sel_codigocarrera = mysql_num_rows($sel_codigocarrera);?>
          </span></div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras</div>
              <div align="center"></div></td>
          <td bgcolor="#CCDADD" class="Estilo2">
              <select name="selcodigocarrera" id="selcodigocarrera" onchange="enviar()">
                <option value="">Seleccionar</option>
                <?php
                do {
?>
                <option value="<?php echo $row_sel_codigocarrera['codigocarrera']?>"<?php if(isset($_POST['selcodigocarrera'])){if($_POST['selcodigocarrera'] == $row_sel_codigocarrera['codigocarrera']){echo "selected";}}?>><?php echo $row_sel_codigocarrera['nombrecarrera']?></option>
                <?php
                } while ($row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera));
                $rows = mysql_num_rows($sel_codigocarrera);
                if($rows > 0) {
                	mysql_data_seek($sel_codigocarrera, 0);
                	$row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
                }
?>
              </select>
              <?php } ?>
              <?php if(isset($_POST['masivo']) and $_POST['masivo']=='si' or isset($_POST['Enviar'])){ 
              	mysql_select_db($database_sala, $sala);
              	//echo  $_POST['modalidadacademica'];

              	if(isset($_GET['modalidadacademica'])){
              		$query_carrerapormodalidad="SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
					WHERE c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."' 
					and c.codigomodalidadacademica = '".$_GET['modalidadacademica']."'  
					
					order by c.nombrecarrera
					";
              		//and c.codigocarrera not in(select codigocarrera from facturavalorpecuniario where codigoperiodo='".$_GET['codigoperiodo']."')
              		$carrerapormodalidad = mysql_query($query_carrerapormodalidad, $sala) or die(mysql_error());
              		$row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad);
              		$totalRows_carrerapormodalidad = mysql_num_rows($carrerapormodalidad);
              		//echo $query_carrerapormodalidad;
              		//print_r($carrerapormodalidad);

              	}
   ?>
        &nbsp;</td>
        </tr>
		
		<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras</div></td>
          <td bgcolor="#CCDADD" class="Estilo2" align="center"><?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
            Seleccionar Todo
              <input type="checkbox" name="checkbox" value="checkbox" onClick="HabilitarTodos(this)">
              <?php } ?></td> <?php } ?>
        </tr>
        <?php 
        do {
        	$chequear="";
        	if (isset($_POST['Enviar']) or isset($_POST['Enviar2']) or isset($_POST['codigotipoestudiante']) or isset($_POST['selcodigocarrera'])){
        		foreach($_POST as $vpost => $valor)
        		{
        			if (ereg("^carreras".$row_carrerapormodalidad['codigocarrera']."$",$vpost))
        			{
        				$chequear="checked";
        			}
        		}
        	}
        	//print_r($row_carrerapormodalidad);
        	echo "<tr><td class='Estilo1'>".$row_carrerapormodalidad['nombrecarrera']."&nbsp;</td>
        	 <td><div align='center'><input type='checkbox' title='carreras' name='carreras".$row_carrerapormodalidad['codigocarrera']."' $chequear value='".$row_carrerapormodalidad['codigocarrera']."'>&nbsp;</div></td></tr>";
			 }
			 while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));

	  ?>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input type="submit" name="Enviar" value="Enviar">
            &nbsp;</div></td>
        </tr>
        <?php } ?>
      </table></td>
    </tr>
  </table>
  <br>
  <?php if (($totalRows_carrerapormodalidad<>0 or $totalRows_sel_codigocarrera<>0) and(isset($_POST['Enviar']) or isset($_POST['Enviar2']) or isset($_POST['codigotipoestudiante']) or isset($_POST['selcodigocarrera']))){ ?>
  <table  width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#FFFFFF">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Factura</div></td>
          <td bgcolor='#FEF7ED'><input name="nombrefacturavalorpecuniario" type="text" id="nombrefacturavalorpecuniario" value="<?php if(isset($_POST['nombrefacturavalorpecuniario'])){echo $_POST['nombrefacturavalorpecuniario'];} ?>"></td>
          </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Enviar2" type="submit" id="Enviar2" value="Enviar">
          </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br>
  <?php if (($totalRows_carrerapormodalidad<>0 or $totalRows_sel_codigocarrera<>0) and (isset($_POST['Enviar2']) or isset($_POST['codigotipoestudiante']))){ ?>
  <table width="80%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
          
		  <tr>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo Estudiante </div></td>
            <td colspan="2" bgcolor="#FEF7ED" class="Estilo2"><div align="center">
              <select name="codigotipoestudiante" id="codigotipoestudiante" onChange="enviar()">
                  <option value="">Seleccionar</option>
                  <?php
                  do {
?>
                  <option value="<?php echo $row_seleccionatipoestudiante['codigotipoestudiante']?>" <?php if(@$row_seleccionatipoestudiante['codigotipoestudiante'] == @$_POST['codigotipoestudiante']) {echo "selected";} ?>><?php echo $row_seleccionatipoestudiante['nombretipoestudiante']?></option>
                  <?php
                  } while ($row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante));
                  $rows = mysql_num_rows($seleccionatipoestudiante);
                  if($rows > 0) {
                  	mysql_data_seek($seleccionatipoestudiante, 0);
                  	$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
                  }
?>
              </select>
            </div></td>
          </tr><?php }?>
          <?php if (isset($_POST['codigotipoestudiante'])){ ?>
		  <tr>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto:</div></td>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor:</div></td>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Selecci&oacute;n:</div></td>
          </tr>
        
          <?php 


          if($_POST['masivo']=='si'){
          	$query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, v.codigoconcepto, v.valorpecuniario, c.nombreconcepto
			FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
			AND v.codigoperiodo='".$_GET['codigoperiodo']."' and v.codigoestado=100
			order by c.nombreconcepto asc
			";
          	//echo $query_mostrar_conceptos;
          }
          elseif($_POST['masivo']=='no') {

          	//print_r($row_periodoactivo);
          	$query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, v.codigoconcepto, v.valorpecuniario, c.nombreconcepto
			FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
			AND v.codigoperiodo='".$_GET['codigoperiodo']."' and v.codigoestado=100
			order by c.nombreconcepto asc
			";
          	//echo $query_mostrar_conceptos;
          }
          $mostrar_conceptos=mysql_query($query_mostrar_conceptos,$sala);
          //echo $query_mostrar_conceptos;
          if($_POST['masivo']=='no') {
          	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){
          		$chequear="";
          		foreach($_POST as $vpost => $valor)
          		{
          			if (ereg("^sel".$concepto['idvalorpecuniario']."$",$vpost))
          			{
          				$chequear="checked";

          			}
          		}


          		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['idvalorpecuniario']."' $chequear value='".$concepto['idvalorpecuniario']."'></div></td>
		</tr>
	";
          	}
          }
          elseif ($_POST['masivo']=='si')
          {
          	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){
          		$chequear="";
          		foreach($_POST as $vpost => $valor)
          		{
          			if (ereg("^sel".$concepto['codigoconcepto']."$",$vpost))
          			{
          				$chequear="checked";

          			}
          		}

          		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['codigoconcepto']."' $chequear value='".$concepto['codigoconcepto']."-".$concepto['valorpecuniario']."'></div></td>
		</tr>
	";
          	}

          }
	}?>  
	<?php if (isset($_POST['codigotipoestudiante'])){ ?>
	<tr>
            <td colspan="3" bgcolor="#CCDADD" class="Estilo2"><div align="center">
              <input name="Grabar" type="submit" id="Grabar" value="Grabar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
</div></td>
          </tr>
        </table></td>
      </tr>
	  <?php } ?>
  </table>
    <br>
    <?php } ?>
</form>

<?php 
if (isset($_POST['Grabar']) and  $_POST['masivo']=='no'){
	//print_r($_POST);
	$fechaidfacturavalorpecuniario=date("Y-m-d H:i:s");
	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_POST['selcodigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
	$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$_POST['selcodigocarrera']."' and codigoperiodo='".$_GET['codigoperiodo']."'"; //busca si hay alguna factura en la tabla facturavalorpecuniario, para ese periodo y para esa carrera
	$busca_factura=mysql_query($query_busca_factura,$sala);
	$num_rows_buscafactura=mysql_num_rows($busca_factura);
	$factura=mysql_fetch_assoc($busca_factura);
	//echo $num_rows_buscafactura;
	if($num_rows_buscafactura==0)
	{
		$query_insertar_fvp="insert into facturavalorpecuniario (nombrefacturavalorpecuniario, fechafacturavalorpecuniario, codigoperiodo, codigocarrera)
		values ('".$_POST['nombrefacturavalorpecuniario']."','".$fechaidfacturavalorpecuniario."','".$_GET['codigoperiodo']."','".$_POST['selcodigocarrera']."')";
		$insertar_fvp=mysql_query($query_insertar_fvp, $sala);
		$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where nombrefacturavalorpecuniario = '".$_POST['nombrefacturavalorpecuniario']."' and
		codigoperiodo='".$_GET['codigoperiodo']."' and
		codigocarrera='".$_POST['selcodigocarrera']."'";
		$selecciona_idfvp=mysql_query($query_selecciona_idfvp, $sala);
		$idfvp=mysql_fetch_assoc($selecciona_idfvp);
		//echo $query_selecciona_idfvp;
	}


	foreach($_POST as $vpost => $valor)
	{
		//echo "$vpost => $valor<br>";
		if (ereg("sel",$vpost))
		{
			$idvalorpecuniario = $_POST[$vpost];
			//inserta lo que viene del post
			if($num_rows_buscafactura==0)
			{
				$query_buscasihay_nuevo_detallefvp="select iddetallefacturavalorpecuniario from detallefacturavalorpecuniario where
				idfacturavalorpecuniario='".$idfvp['idfacturavalorpecuniario']."' and idvalorpecuniario='".$_POST[$vpost]."' and codigotipoestudiante = '".$_POST['codigotipoestudiante']."' and codigoestado = '100'
				";
				$buscasihay_nuevo_detallefvp=mysql_query($query_buscasihay_nuevo_detallefvp) or die(mysql_error());
				$numrows_buscasihay_nuevo_detallefvp=mysql_num_rows($buscasihay_nuevo_detallefvp);
				//echo $query_buscasihay_nuevo_detallefvp;
				//echo $numrows_buscasihay_nuevo_detallefvp;
				//$row_buscasihay_nuevo_detallefvp=mysql_fetch_assoc($buscasihay_nuevo_detallefvp);

				$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
				('".$idfvp['idfacturavalorpecuniario']."','".$_POST[$vpost]."','".$_POST['codigotipoestudiante']."','100')";
			}//$query_insertar_nuevo_detallefvp;
			elseif ($num_rows_buscafactura==1)
			{
				$query_buscasihay_nuevo_detallefvp="select iddetallefacturavalorpecuniario from detallefacturavalorpecuniario where
				idfacturavalorpecuniario='".$factura['idfacturavalorpecuniario']."' and idvalorpecuniario='".$_POST[$vpost]."' and codigotipoestudiante = '".$_POST['codigotipoestudiante']."' and codigoestado = '100'
				";
				$buscasihay_nuevo_detallefvp=mysql_query($query_buscasihay_nuevo_detallefvp) or die(mysql_error());
				$numrows_buscasihay_nuevo_detallefvp=mysql_num_rows($buscasihay_nuevo_detallefvp);
				//echo $query_buscasihay_nuevo_detallefvp;
				//echo $numrows_buscasihay_nuevo_detallefvp;
				//$row_buscasihay_nuevo_detallefvp=mysql_fetch_assoc($buscasihay_nuevo_detallefvp);

				$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
				('".$factura['idfacturavalorpecuniario']."','".$_POST[$vpost]."','".$_POST['codigotipoestudiante']."','100')";
			}
			if($numrows_buscasihay_nuevo_detallefvp==0)
			{
				$insertar_nuevo_detallefvp=mysql_query($query_insertar_nuevo_detallefvp);
			}
			//echo $query_insertar_nuevo_detallefvp;
		}
	}

{ ?>

		<script language="javascript">
		alert("Datos ingresados correctamente");
		window.location.href="menu.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica']?>";
		//history.go(-1);
		</script>
		<?php }
}
if (isset($_POST['Grabar']) and  $_POST['masivo']=='si')
{
	//print_r($_POST);
	$fechaidfacturavalorpecuniario=date("Y-m-d H:i:s");

	foreach($_POST as $vpostcarreras => $valorcarreras)
	{
		if (ereg("carreras".$row_carrerapormodalidad['codigocarrera']."",$vpostcarreras))
		{
			$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$valorcarreras."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
			$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
			$row_periodoactivo=mysql_fetch_assoc($periodoactivo);


			$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$valorcarreras."' and codigoperiodo='".$_GET['codigoperiodo']."'"; //busca si hay alguna factura en la tabla facturavalorpecuniario, para ese periodo y para esa carrera
			$busca_factura=mysql_query($query_busca_factura,$sala);
			$num_rows_buscafactura=mysql_num_rows($busca_factura);
			$factura=mysql_fetch_assoc($busca_factura);
			//echo $num_rows_buscafactura;
			if ($num_rows_buscafactura==0){
				$query_insertar_fvp="insert into facturavalorpecuniario (nombrefacturavalorpecuniario, fechafacturavalorpecuniario, codigoperiodo, codigocarrera)
				values ('".$_POST['nombrefacturavalorpecuniario']."','".$fechaidfacturavalorpecuniario."','".$_GET['codigoperiodo']."','".$valorcarreras."')";
				$insertar_fvp=mysql_query($query_insertar_fvp, $sala);
				//echo "<br>",$query_insertar_fvp,"<br>";
			}
			$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where
			codigoperiodo='".$_GET['codigoperiodo']."' and
			codigocarrera='".$valorcarreras."'";
			//echo "<br>",$query_selecciona_idfvp;
			$selecciona_idfvp=mysql_query($query_selecciona_idfvp, $sala);
			$idfvp=mysql_fetch_assoc($selecciona_idfvp);
			//print_r($idfvp);

			foreach($_POST as $vpost => $valor)
			{
				//echo "$vpost => $valor<br>";
				if (ereg("sel",$vpost))
				{
					$query_seleccionar_detallefvp="select iddetallefacturavalorpecuniario from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
					and codigotipoestudiante = '".$_POST['codigotipoestudiante']."'
					and codigoestado ='100'";
					//echo "<br>",$query_seleccionar_detallefvp;
					$seleccionardetallefvp=mysql_query($query_seleccionar_detallefvp,$sala);
					$numrows_seleccionardetallefvp=mysql_num_rows($seleccionardetallefvp);
					//echo "<br>",$numrows_seleccionardetallefvp;
					/* if ($numrows_seleccionardetallefvp==0) */{
						//inserta lo que viene del post
						$concepto_partido=explode("-",$_POST[$vpost]);
						$query_seleccionar_idvalorpecuniario="SELECT idvalorpecuniario FROM valorpecuniario v WHERE codigoconcepto='".$concepto_partido[0]."' and valorpecuniario='".$concepto_partido[1]." and codigoestado=100'
						AND codigoperiodo = '".$_GET['codigoperiodo']."'";//selecciona el id del valorpecuniario, que le corresponde al periodo activo de la carrera.
						$seleccionar_idvalorpecuniario=mysql_query($query_seleccionar_idvalorpecuniario,$sala);
						$idvalorpecuniario=mysql_fetch_assoc($seleccionar_idvalorpecuniario);
						//echo $query_seleccionar_idvalorpecuniario;
						//print_r($idvalorpecuniario);echo "<br>";

						$query_buscasihay_nuevo_detallefvp="select iddetallefacturavalorpecuniario from detallefacturavalorpecuniario where
						idfacturavalorpecuniario='".$idfvp['idfacturavalorpecuniario']."' and idvalorpecuniario='".$idvalorpecuniario['idvalorpecuniario']."' and codigotipoestudiante = '".$_POST['codigotipoestudiante']."' and codigoestado = '100'
						";
						$buscasihay_nuevo_detallefvp=mysql_query($query_buscasihay_nuevo_detallefvp) or die(mysql_error());
						$numrows_buscasihay_nuevo_detallefvp=mysql_num_rows($buscasihay_nuevo_detallefvp);
						//echo $query_buscasihay_nuevo_detallefvp;
						//echo $numrows_buscasihay_nuevo_detallefvp;
						//$row_buscasihay_nuevo_detallefvp=mysql_fetch_assoc($buscasihay_nuevo_detallefvp);

						$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
						('".$idfvp['idfacturavalorpecuniario']."','".$idvalorpecuniario['idvalorpecuniario']."','".$_POST['codigotipoestudiante']."','100')";
						//echo "<br>",$query_insertar_nuevo_detallefvp,"<br>";
						if($numrows_buscasihay_nuevo_detallefvp==0)
						{
							$insertar_nuevo_detallefvp=mysql_query($query_insertar_nuevo_detallefvp,$sala);
						}
						else{echo mysql_error();}

					}
				}

			}

		{ ?>

		<script language="javascript">
		alert("Datos ingresados correctamente");
		window.location.href="menu.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&modalidadacademica=<?php echo $_GET['modalidadacademica']?>";
		//history.go(-1);
		</script>
		<?php }
		}

	}

}


?>


<?php
@mysql_free_result($sel_modalidadacademica);

@mysql_free_result($sel_codigocarrera);
?>
<?php if(isset($_POST['Regresar'])){
	echo "<script language='javascript'>window.location.href='menu.php?tipo=".$_GET['tipo']."&codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."';</script>";
}
?>