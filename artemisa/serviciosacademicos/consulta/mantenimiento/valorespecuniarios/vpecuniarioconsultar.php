<?php 
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
global $nombrefacturavalorpecuniario;
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

  <p align="center" class="Estilo3">VALORES PECUNIARIOS - CONSULTAR </p>
  <table width="80%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#FFFFFF">
        <tr>
          <td width="51%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica</div></td>
          <td width="49%" bgcolor='#FEF7ED'><p align="center" class="style2">
              <?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?>          </p></td>
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
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Consulta TODOS</div></td>
          <td bgcolor='#FEF7ED' class="Estilo1"><div align="center">SI
                  <input name="masivo" type="radio" value="si" onClick="enviar()"<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){echo 'checked="checked"';}?>/>
        NO
        <input name="masivo" type="radio" onClick="enviar()" value="no" <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){echo 'checked="checked"';}?> />
		<?php } ?>
          <span class="Estilo2">
          <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){ 
          	mysql_select_db($database_sala, $sala);
          	$query_sel_codigocarrera = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
			WHERE c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."' 
			and c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' order by c.nombrecarrera ";
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
              	$query_carrerapormodalidad = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
				WHERE c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."' and
				c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' order by c.nombrecarrera ";
              	$carrerapormodalidad = mysql_query($query_carrerapormodalidad, $sala) or die(mysql_error());
              	$row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad);
              	$totalRows_carrerapormodalidad = mysql_num_rows($carrerapormodalidad);


   ?>
        &nbsp;</td>
        </tr>
		
		<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras</div></td>
          <td bgcolor="#CCDADD" class="Estilo2" align="center"><?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
            Tipo Estudiante
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
              </select>              <?php } ?></td> 
          <?php } ?>
        </tr>  
        <?php 


        do{
        	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$row_carrerapormodalidad['codigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
        	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
        	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
        	$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where
			codigoperiodo='".$_GET['codigoperiodo']."' and
			codigocarrera='".$row_carrerapormodalidad['codigocarrera']."'";
        	//echo $query_selecciona_idfvp;
        	$selecciona_idfvp=mysql_query($query_selecciona_idfvp, $sala);
        	$idfvp=mysql_fetch_assoc($selecciona_idfvp);
        	$chequear="";
        	$query_verifica_chequeado="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
					and codigotipoestudiante = '".$_POST['codigotipoestudiante']."'
					and codigoestado ='100'";
        	//echo $query_verifica_chequeado;
        	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
        	$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
        	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
        	if ($row_verifica_chequeado > 0){$chequear="<img src='../../../../imagenes/ok.PNG' width='16' height='16'>";}
        	echo "<tr>
			<td align='center' valign='bottom'>$chequear</td>
			<td colspan='2'><span class='Estilo1'><a href='vpecuniarioconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&codigotipoestudiante=".$_POST['codigotipoestudiante']."&codigocarrera=".$row_carrerapormodalidad['codigocarrera']."'>".$row_carrerapormodalidad['nombrecarrera']."</a></span>&nbsp;</td>
			</tr>
		  ";}
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
  <?php if (isset($_GET['codigocarrera']) or isset($_POST['Enviar']) or isset($_POST['selcodigocarrera']) or isset($_POST['Enviar2']) or isset($_POST['codigotipoestudiante']) and $_POST['masivo']=='no'){ 	
  	if(isset($_GET['codigocarrera'])){
  		$query_seleccionperiodoactivo ="SELECT p.codigoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_GET['codigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
  		$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
  		$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
  		$codigoperiodo=$row_periodoactivo['codigoperiodo'];
  		//busca si hay factura para esa carrera, y para ese periodo, si es el caso, la muestra, de lo contrario, se debe insertar una nueva
  		$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$_GET['codigocarrera']."' and codigoperiodo='".$_GET['codigoperiodo']."'"; //busca si hay alguna factura en la tabla facturavalorpecuniario, para ese periodo y para esa carrera
  		$busca_factura=mysql_query($query_busca_factura,$sala);
  		$num_rows_buscafactura=mysql_num_rows($busca_factura);
  		$factura=mysql_fetch_assoc($busca_factura);
  	}
  	else {
  		$query_seleccionperiodoactivo ="SELECT p.codigoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_POST['selcodigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
  		$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
  		$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
  		$codigoperiodo=$row_periodoactivo['codigoperiodo'];
  		//busca si hay factura para esa carrera, y para ese periodo, si es el caso, la muestra, de lo contrario, se debe insertar una nueva
  		$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$_POST['selcodigocarrera']."' and codigoperiodo='".$_GET['codigoperiodo']."'"; //busca si hay alguna factura en la tabla facturavalorpecuniario, para ese periodo y para esa carrera
  		$busca_factura=mysql_query($query_busca_factura,$sala);
  		$num_rows_buscafactura=mysql_num_rows($busca_factura);
  		$factura=mysql_fetch_assoc($busca_factura);
  	}
  	//echo "<br>",$query_busca_factura,"<br>";
  ?>
  
  <table  width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="636"><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Factura</div></td>
          <td bgcolor='#FEF7ED'><input name="nombrefacturavalorpecuniario" type="text" id="nombrefacturavalorpecuniario" value="<?php echo $factura['nombrefacturavalorpecuniario'] ?>"></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br>

   

    <table width="80%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
          <?php if (isset($_POST['Enviar']) or isset($_POST['codigotipoestudiante']) or isset($_POST['selcodigocarrera'])){ ?>
		  <tr>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo Estudiante</div></td>
            <td colspan="2" bgcolor="#FEF7ED" class="Estilo2">
              <div align="center">
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
       
        
   <?php if (isset($_POST['codigotipoestudiante']) or isset($_GET['codigocarrera'])){ ?>
          <tr>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto:</div></td>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor:</div></td>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Selecci&oacute;n:</div></td>
          </tr>

                    <?php 

                    if(isset($_GET['codigocarrera'])){
                    	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_GET['codigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
                    	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
                    	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
                    	//print_r($row_periodoactivo);
                    	$query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, v.codigoconcepto, v.valorpecuniario, c.nombreconcepto
						FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
						AND v.codigoperiodo='".$_GET['codigoperiodo']."'  and v.codigoestado=100
						order by c.nombreconcepto asc
						";
                    }

                    elseif($_POST['masivo']=='si'){
                    	$query_mostrar_conceptos="SELECT  v.idvalorpecuniario,v.codigoconcepto,v.valorpecuniario, c.nombreconcepto FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto  and v.codigoestado=100
			GROUP by nombreconcepto
			order by nombreconcepto asc";
                    }
                    elseif($_POST['masivo']=='no') {
                    	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_POST['selcodigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
                    	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
                    	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
                    	//print_r($row_periodoactivo);
                    	$query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, v.codigoconcepto, v.valorpecuniario, c.nombreconcepto
						FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
						AND v.codigoperiodo='".$_GET['codigoperiodo']."' and v.codigoestado=100
						order by c.nombreconcepto asc
						";
                    }
                    $mostrar_conceptos=mysql_query($query_mostrar_conceptos,$sala);
                    //echo $query_mostrar_conceptos;
                    if($_POST['masivo']=='no' or isset($_GET['codigocarrera'])) {
                    	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){
                    		$chequear="";
                    		if(isset($_GET['codigocarrera'])){
                    			$query_verifica_chequeado="SELECT df.idvalorpecuniario,df.codigotipoestudiante FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
								WHERE 
								df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
								AND df.idvalorpecuniario = vp.idvalorpecuniario
								AND df.codigotipoestudiante = ".$_GET['codigotipoestudiante']."
								AND df.codigoestado = '100'
								AND fvp.codigoperiodo = ".$_GET['codigoperiodo']."
								AND fvp.codigocarrera='".$_GET['codigocarrera']."'
								AND df.idvalorpecuniario = ".$concepto['idvalorpecuniario']."";
                    		}
                    		else{
                    			$query_verifica_chequeado="SELECT df.idvalorpecuniario,df.codigotipoestudiante FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
								WHERE 
								df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
								AND df.idvalorpecuniario = vp.idvalorpecuniario
								AND df.codigotipoestudiante = ".$_POST['codigotipoestudiante']."
								AND df.codigoestado = '100'
								AND fvp.codigoperiodo = ".$_GET['codigoperiodo']."
								AND fvp.codigocarrera='".$_POST['selcodigocarrera']."'
								AND df.idvalorpecuniario = ".$concepto['idvalorpecuniario']."";
                    		}
                    		$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
                    		@$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
                    		@$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
                    		if ($row_verifica_chequeado > 0){$chequear="checked";}
                    		//$chequear="";

                    		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['idvalorpecuniario']."'  $chequear value='".$concepto['idvalorpecuniario']."'></div></td>
		</tr>
	";
                    	}
                    }
                    elseif ($_POST['masivo']=='si')
                    {
                    	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){

                    		//$chequear="";

                    		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['codigoconcepto']."' value='".$concepto['codigoconcepto']."'></div></td>
		</tr>
	";
                    	}

                    }
	}?>  <tr>
            <td colspan="3" bgcolor="#CCDADD" class="Estilo2"><div align="center"><span class="style2">
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
            </span></div></td>
            </tr>
        </table></td>
      </tr>
  </table>
    <br>
    <?php } ?>
</form>
<p>&nbsp;</p>
</form>

<?php 
if (isset($_POST['Grabar']) and  $_POST['masivo']=='no'){

	$fechaidfacturavalorpecuniario=date("Y-m-d H:i:s");
	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_POST['selcodigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
	//echo $query_seleccionperiodoactivo;
	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);

	$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$_POST['selcodigocarrera']."' and codigoperiodo='".$row_periodoactivo['codigoperiodo']."'"; //busca si hay algun valor en la tabla facturavalorpecuniario
	$busca_factura=mysql_query($query_busca_factura,$sala);
	$num_rows_buscafactura=mysql_num_rows($busca_factura);
	$factura=mysql_fetch_assoc($busca_factura);
	$query_verifica_chequeado="SELECT df.idvalorpecuniario FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
	WHERE 
	df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
	AND df.idvalorpecuniario = vp.idvalorpecuniario
	AND df.codigotipoestudiante = '".$_POST['codigotipoestudiante']."'
	AND df.codigoestado = '100'
	AND fvp.codigoperiodo = '".$_GET['codigoperiodo']."'
	AND fvp.codigocarrera='".$_POST['selcodigocarrera']."'
	";
	//echo $query_verifica_chequeado;
	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
	//echo "factura",$num_rows_buscafactura,"<br>";
	//echo "detalle",$row_verifica_chequeado,"<br>";
	//verifica si hay algo en facturavalorpecuniario, si hay algo, entonces no tiene que efectuar insercion nueva, no tiene que insertar ninguna factura
	if ($num_rows_buscafactura > 0)	{//echo "ya hay factura";

		//verifica si hay algo en detallefacturavalorpecuniario, si no existe nada, debe insertar valores nuevos en detallefacturavalorpecuniario
		if ($row_verifica_chequeado != 0){
			//busca el idfacturavalorpecuniario, de la factura para poder ingresar nuevos datos en detallefacturavalorpecuniario
			$query_selecciona_idfvp="select idfacturavalorpecuniario from facturavalorpecuniario f where codigocarrera='".$_POST['selcodigocarrera']."' and codigoperiodo='".$row_periodoactivo['codigoperiodo']."'";
			$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
			$idfvp=mysql_fetch_assoc($seleciona_idfvp);
			//consulta la bd, para ver todo lo que hay con es idfactura
			$query_seleccionar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$_POST['codigotipoestudiante']."'
		and codigoestado ='100'";
			//echo($query_seleccionar_detallefvp);
			$seleccionar_detallefvp=mysql_query($query_seleccionar_detallefvp);

			//crea un arreglo con los idvalorpecuniario
			while ($detallefvp=mysql_fetch_assoc($seleccionar_detallefvp)){
				$array_detallefvp[]=$detallefvp['idvalorpecuniario'];
			}
			//print_r($array_detallefvp);

			//creaa un arreglo con lo qye hay en post
			foreach($_POST as $vpost => $valor)
			{
				if (ereg("sel",$vpost))
				{
					$idvalorpecuniario = $_POST[$vpost];
					$array_post[]=$idvalorpecuniario;

				}
			}

			//si hay algo en bd, y algo en post, debe insertar/actualizar bd
			if(isset($array_post) and isset($array_detallefvp)){
				$array_eliminar=array_diff($array_detallefvp,$array_post);
				$array_actualizar=array_diff($array_post,$array_detallefvp);
				//print_r($array_detallefvp);echo "<br>";
				//print_r($array_post);echo "<br>";
				echo "<br>";
				//print_r($array_actualizar);echo "<br>";
				//print_r($array_eliminar);echo "<br>";


				$query_actualizar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$_POST['codigotipoestudiante']."'
		and codigoestado ='100'";

				$seleccionar_actualizar_detallefvp=mysql_query($query_actualizar_detallefvp);
				while ($actualizar_detallefvp=mysql_fetch_assoc($seleccionar_actualizar_detallefvp)){
					foreach ($array_eliminar as $eliminacion => $valeliminar){
						$query_actualizar="update detallefacturavalorpecuniario SET codigoestado='200' where iddetallefacturavalorpecuniario='".$actualizar_detallefvp['iddetallefacturavalorpecuniario']."' and idvalorpecuniario='".$array_eliminar[$eliminacion]."' and idfacturavalorpecuniario='".$actualizar_detallefvp['idfacturavalorpecuniario']."'";
						//echo $query_actualizar;
						$eliminar=mysql_query($query_actualizar);
						if(!$eliminar){echo mysql_error();}
					}



					foreach ($array_actualizar as $inserccion => $valactualizar){
						$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
					('".$idfvp['idfacturavalorpecuniario']."','".$array_actualizar[$inserccion]."','".$_POST['codigotipoestudiante']."'
					,'100')";	


						//echo $query_insertar_nuevo_detallefvp;
						$insertar=mysql_query($query_insertar_nuevo_detallefvp);
						if(!$insertar){echo mysql_error();}
					}


				}
			?>
			<script language="javascript">
			//window.location.reload("vpecuniariomodificar.php");
			history.go(-1);
		</script>
		<?php
			}
			//si no hay nada seleccionado en el post, porque el usuario lo deselecciono, debe eliminar
			else if(!isset($array_post)){
				//se buscan los iddetallefacturavalorpecuniario que deben actualizarse en la tabla como 200
				$query_seleccionar_eliminar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$codigotipoestudiante."'
		and codigoestado ='100'";

				$seleccionar_eliminar_detallefvp=mysql_query($query_seleccionar_eliminar_detallefvp);
				while ($eliminar_detallefvp=mysql_fetch_assoc($seleccionar_eliminar_detallefvp)){
					$query_eliminar="update detallefacturavalorpecuniario SET codigoestado='200' where iddetallefacturavalorpecuniario='".$eliminar_detallefvp['iddetallefacturavalorpecuniario']."' and idvalorpecuniario='".$eliminar_detallefvp['idvalorpecuniario']."' and idfacturavalorpecuniario='".$eliminar_detallefvp['idfacturavalorpecuniario']."'";
					$eliminar=mysql_query($query_eliminar);
					if($eliminar){ ?>

		<script language="javascript">
		//window.location.reload("vpecuniariomodificar.php");
		history.go(-1);
		</script>
		<?php }else {echo mysql_error();} 
				}
			}
			else {
				echo "adicionar registros";

			}
		}

		//verifica si hay factura, pero no hay detalle, en ese caso debe insertar detalles nuevos
		if ($row_verifica_chequeado == 0 and $num_rows_buscafactura > 0){

			//busca el idfacturavalorpecuniario, de la factura para poder ingresar los datos nuevos en detallefacturavalorpecuniario
			$query_selecciona_idfvp="select idfacturavalorpecuniario from facturavalorpecuniario f where codigocarrera='".$_POST['selcodigocarrera']."' and codigoperiodo='".$row_periodoactivo['codigoperiodo']."'";
			$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
			$idfvp=mysql_fetch_assoc($seleciona_idfvp);

			foreach($_POST as $vpost => $valor)
			{
				//echo "$vpost => $valor<br>";
				if (ereg("sel",$vpost))
				{
					$idvalorpecuniario = $_POST[$vpost];
					//inserta lo que viene del post en la bd
					$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
			('".$idfvp['idfacturavalorpecuniario']."','".$_POST[$vpost]."','".$_POST['codigotipoestudiante']."'
			,'100')";
					//$query_insertar_nuevo_detallefvp;
					$insertar_nuevo_detallefvp=mysql_query($query_insertar_nuevo_detallefvp);
				}
			}
			//si se logro la insercion, se vuelve a cargar la pagina, con las variables para mostrar los datos
		if($insertar_nuevo_detallefvp){ ?>

		<script language="javascript">
		//window.location.reload("vpecuniariomodificar.php");
		history.go(-1);
		</script>
		<?php }else {echo mysql_error();} 
		}


	}



}
?>


<?php
if (isset($_POST['Grabar']) and isset($_GET['codigocarrera'])){

	$fechaidfacturavalorpecuniario=date("Y-m-d H:i:s");
	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_GET['codigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
	//echo $query_seleccionperiodoactivo;
	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);

	$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera='".$_GET['codigocarrera']."' and codigoperiodo='".$row_periodoactivo['codigoperiodo']."'"; //busca si hay algun valor en la tabla facturavalorpecuniario
	$busca_factura=mysql_query($query_busca_factura,$sala);
	$num_rows_buscafactura=mysql_num_rows($busca_factura);
	$factura=mysql_fetch_assoc($busca_factura);
	$query_verifica_chequeado="SELECT df.idvalorpecuniario FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
	WHERE 
	df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
	AND df.idvalorpecuniario = vp.idvalorpecuniario
	AND df.codigotipoestudiante = '".$_GET['codigotipoestudiante']."'
	AND df.codigoestado = '100'
	AND fvp.codigoperiodo = '".$_GET['codigoperiodo']."'
	AND fvp.codigocarrera='".$_GET['codigocarrera']."'
	";
	//echo $query_verifica_chequeado;
	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
	//echo "factura",$num_rows_buscafactura,"<br>";
	//echo "detalle",$row_verifica_chequeado,"<br>";
	//verifica si hay algo en facturavalorpecuniario, si hay algo, entonces no tiene que efectuar insercion nueva, no tiene que insertar ninguna factura
	if ($num_rows_buscafactura > 0)	{//echo "ya hay factura";

		//verifica si hay algo en detallefacturavalorpecuniario, si no existe nada, debe insertar valores nuevos en detallefacturavalorpecuniario
		if ($row_verifica_chequeado != 0){
			//busca el idfacturavalorpecuniario, de la factura para poder ingresar nuevos datos en detallefacturavalorpecuniario
			$query_selecciona_idfvp="select idfacturavalorpecuniario from facturavalorpecuniario f where codigocarrera='".$_GET['codigocarrera']."' and codigoperiodo='".$row_periodoactivo['codigoperiodo']."'";
			$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
			$idfvp=mysql_fetch_assoc($seleciona_idfvp);
			//consulta la bd, para ver todo lo que hay con es idfactura
			$query_seleccionar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$_GET['codigotipoestudiante']."'
		and codigoestado ='100'";
			//echo($query_seleccionar_detallefvp);
			$seleccionar_detallefvp=mysql_query($query_seleccionar_detallefvp);

			//crea un arreglo con los idvalorpecuniario
			while ($detallefvp=mysql_fetch_assoc($seleccionar_detallefvp)){
				$array_detallefvp[]=$detallefvp['idvalorpecuniario'];
			}
			//print_r($array_detallefvp);

			//creaa un arreglo con lo qye hay en post
			foreach($_POST as $vpost => $valor)
			{
				if (ereg("sel",$vpost))
				{
					$idvalorpecuniario = $_POST[$vpost];
					$array_post[]=$idvalorpecuniario;

				}
			}

			//si hay algo en bd, y algo en post, debe insertar/actualizar bd
			if(isset($array_post) and isset($array_detallefvp)){
				$array_eliminar=array_diff($array_detallefvp,$array_post);
				$array_actualizar=array_diff($array_post,$array_detallefvp);
				//print_r($array_detallefvp);echo "<br>";
				//print_r($array_post);echo "<br>";
				echo "<br>";
				//print_r($array_actualizar);echo "<br>";
				//print_r($array_eliminar);echo "<br>";


				$query_actualizar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$_GET['codigotipoestudiante']."'
		and codigoestado ='100'";

				$seleccionar_actualizar_detallefvp=mysql_query($query_actualizar_detallefvp);
				while ($actualizar_detallefvp=mysql_fetch_assoc($seleccionar_actualizar_detallefvp)){
					foreach ($array_eliminar as $eliminacion => $valeliminar){
						$query_actualizar="update detallefacturavalorpecuniario SET codigoestado='200' where iddetallefacturavalorpecuniario='".$actualizar_detallefvp['iddetallefacturavalorpecuniario']."' and idvalorpecuniario='".$array_eliminar[$eliminacion]."' and idfacturavalorpecuniario='".$actualizar_detallefvp['idfacturavalorpecuniario']."'";
						//echo $query_actualizar;
						$eliminar=mysql_query($query_actualizar);
						if(!$eliminar){echo mysql_error();}
					}



					foreach ($array_actualizar as $inserccion => $valactualizar){
						$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
					('".$idfvp['idfacturavalorpecuniario']."','".$array_actualizar[$inserccion]."','".$_GET['codigotipoestudiante']."'
					,'100')";	


						//echo $query_insertar_nuevo_detallefvp;
						$insertar=mysql_query($query_insertar_nuevo_detallefvp);
						if(!$insertar){echo mysql_error();}
					}


				}
			?>
			<script language="javascript">
			//window.location.reload("vpecuniariomodificar.php");
			//history.go(-1);
			window.location.href="menu.php?tipo=<?php echo $_GET['tipo']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>&modalidadacademica=<?php echo $_GET['modalidadacademica']; ?>";
		</script>
		<?php
			}
			//si no hay nada seleccionado en el post, porque el usuario lo deselecciono, debe eliminar
			else if(!isset($array_post)){
				//se buscan los iddetallefacturavalorpecuniario que deben actualizarse en la tabla como 200
				$query_seleccionar_eliminar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$codigotipoestudiante."'
		and codigoestado ='100'";

				$seleccionar_eliminar_detallefvp=mysql_query($query_seleccionar_eliminar_detallefvp);
				while ($eliminar_detallefvp=mysql_fetch_assoc($seleccionar_eliminar_detallefvp)){
					$query_eliminar="update detallefacturavalorpecuniario SET codigoestado='200' where iddetallefacturavalorpecuniario='".$eliminar_detallefvp['iddetallefacturavalorpecuniario']."' and idvalorpecuniario='".$eliminar_detallefvp['idvalorpecuniario']."' and idfacturavalorpecuniario='".$eliminar_detallefvp['idfacturavalorpecuniario']."'";
					$eliminar=mysql_query($query_eliminar);
					if($eliminar){ ?>

		<script language="javascript">
		//window.location.reload("vpecuniariomodificar.php");
		//history.go(-1);
		window.location.href="menu.php?tipo=<?php echo $_GET['tipo']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>&modalidadacademica=<?php echo $_GET['modalidadacademica']; ?>";

		</script>
		<?php }else {echo mysql_error();} 
				}
			}
			else {
				echo "adicionar registros";

			}
		}

		//verifica si hay factura, pero no hay detalle, en ese caso debe insertar detalles nuevos
		if ($row_verifica_chequeado == 0 and $num_rows_buscafactura > 0){

			//busca el idfacturavalorpecuniario, de la factura para poder ingresar los datos nuevos en detallefacturavalorpecuniario
			$query_selecciona_idfvp="select idfacturavalorpecuniario from facturavalorpecuniario f where codigocarrera='".$_GET['codigocarrera']."' and codigoperiodo='".$_GET['codigoperiodo']."'";
			$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
			$idfvp=mysql_fetch_assoc($seleciona_idfvp);

			foreach($_POST as $vpost => $valor)
			{
				//echo "$vpost => $valor<br>";
				if (ereg("sel",$vpost))
				{
					$idvalorpecuniario = $_POST[$vpost];
					//inserta lo que viene del post en la bd
					$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
			('".$idfvp['idfacturavalorpecuniario']."','".$_POST[$vpost]."','".$_GET['codigotipoestudiante']."'
			,'100')";
					//$query_insertar_nuevo_detallefvp;
					$insertar_nuevo_detallefvp=mysql_query($query_insertar_nuevo_detallefvp);
				}
			}
			//si se logro la insercion, se vuelve a cargar la pagina, con las variables para mostrar los datos
		if($insertar_nuevo_detallefvp){ ?>

		<script language="javascript">
		//window.location.reload("vpecuniariomodificar.php");
		//history.go(-1);
		window.location.href="menu.php?tipo=<?php echo $_GET['tipo']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>&modalidadacademica=<?php echo $_GET['modalidadacademica']; ?>";

		</script>
		<?php }else {echo mysql_error();} 
		}
	}
}
?>




<?php
@mysql_free_result($sel_modalidadacademica);

@mysql_free_result($sel_codigocarrera);
?>
<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php?tipo=".$_GET['tipo']."&codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."');</script>";
  }
?>
