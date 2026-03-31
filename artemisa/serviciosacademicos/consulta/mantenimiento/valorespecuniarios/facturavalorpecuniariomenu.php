<?php 
global $codigofacultad;
global $codigoperiodo;
global $fechaidfacturavalorpecuniario;
global $num_rows_buscafactura;
global $row_verifica_chequeado;
global $codigotipoestudiante;
$fechaidfacturavalorpecuniario=date("Y-m-d H:i:s");
?>
<?php 
require_once('../../../../Connections/sala.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<?php
mysql_select_db($database_sala, $sala);
$query_tomacodigocarrera = "SELECT codigocarrera, nombrecarrera FROM carrera";
$tomacodigocarrera = mysql_query($query_tomacodigocarrera, $sala) or die(mysql_error());
$row_tomacodigocarrera = mysql_fetch_assoc($tomacodigocarrera);
$totalRows_tomacodigocarrera = mysql_num_rows($tomacodigocarrera);
?>
<?php
mysql_select_db($database_sala, $sala);
$query_seleccionatipoestudiante = "SELECT codigotipoestudiante, nombretipoestudiante FROM tipoestudiante";
$seleccionatipoestudiante = mysql_query($query_seleccionatipoestudiante, $sala) or die(mysql_error());
$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
$totalRows_seleccionatipoestudiante = mysql_num_rows($seleccionatipoestudiante);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
  <script language="javascript">
  function selecciona_carrera()
  {
  	//tomo el valor del select del tipo elegido
  	var codigocarrera
  	codigocarrera = document.formvp.codigocarrera[document.formvp.codigocarrera.selectedIndex].value
  	//miro a ver si el tipo está definido
  	if (codigocarrera != 0)
  	{
  		window.location.reload("facturavalorpecuniariomenu.php?codigocarrera="+codigocarrera);
  	}
  }
</script>
<script language="javascript">
function botonok()
{
	var nombrefacturapecuniario
	nombrefacturavalorpecuniario=document.formvp.nombrefacturavalorpecuniario.value;
	window.location.reload("facturavalorpecuniariomenu.php?codigocarrera=<?php echo $codigofacultad;?>&nombrefacturavalorpecuniario="+nombrefacturavalorpecuniario);
}
</script>


<?php require_once('../../../Connections/sala2.php'); ?>
<?php 


?>
<form name="formvp" method="post" action="">



  <table border="1" align="center" cellpadding="3" bordercolor="#003333">
  <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera:</div></td>
      <td width="25" bgcolor='#FEF7ED'><p>
        <select name="codigocarrera" id="codigocarrera" onChange="selecciona_carrera()">
          <option value="0" selected>Seleccionar</option>
          <?php
          do {
?>
          <option value="<?php echo $row_tomacodigocarrera['codigocarrera']?>"><?php echo $row_tomacodigocarrera['nombrecarrera']?></option>
          <?php
          } while ($row_tomacodigocarrera = mysql_fetch_assoc($tomacodigocarrera));
          $rows = mysql_num_rows($tomacodigocarrera);
          if($rows > 0) {
          	mysql_data_seek($tomacodigocarrera, 0);
          	$row_tomacodigocarrera = mysql_fetch_assoc($tomacodigocarrera);
          }


?>
        </select>
</p></td>
  </tr>
  </table>
  <br>
<?php if (isset($_GET['codigocarrera'])){
	$codigofacultad=$_GET['codigocarrera'];
	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$codigofacultad."' AND p.codigoestadoperiodo = '1'";
	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
	$codigoperiodo=$row_periodoactivo['codigoperiodo'];
	//busca si hay factura para esa carrera, y para ese periodo, si es el caso, la muestra, de lo contrario, se debe insertar una nueva
	$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera=".$codigofacultad." and codigoperiodo=".$codigoperiodo.""; //busca si hay algun valor en la tabla facturavalorpecuniario
	$busca_factura=mysql_query($query_busca_factura,$sala);
	$num_rows_buscafactura=mysql_num_rows($busca_factura);
	$factura=mysql_fetch_assoc($busca_factura);
?>

  <table border="1" align="center" cellpadding="3" bordercolor="#003333">
  <tr><td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Factura:</div></td>
      <td bgcolor='#FEF7ED'>
	  <?php if ($num_rows_buscafactura < 1 and !isset($_GET['nombrefacturavalorpecuniario'])){?>
	  <input type="text" name="nombrefacturavalorpecuniario">
	  <?php }?>
	  <?php if ($num_rows_buscafactura > 0){echo $factura['nombrefacturavalorpecuniario'];echo "<input type='text' name='nombrefacturavalorpecuniario' value='".$factura['nombrefacturavalorpecuniario']."'";}?>
	  <?php if (isset($_GET['nombrefacturavalorpecuniario'])){echo $_GET['nombrefacturavalorpecuniario'];echo "<input type='hidden' name='nombrefacturavalorpecuniario' value='".$_GET['nombrefacturavalorpecuniario']."'";
	  } ?>
  	  </td>
      <td bgcolor='#FEF7ED'><?php if ($num_rows_buscafactura < 1){?>
	  <img src="../../../../imagenes/ok.PNG" width="23" height="23" onClick="botonok()"></td>
	  <?php } ?>
	  <?php if ($num_rows_buscafactura > 0 ){?>
	  
	


	  	  <?php } ?>
  </tr>
</table>

  <br>



<?php } ?>

  

  <?php if (isset($_GET['nombrefacturavalorpecuniario']) or $num_rows_buscafactura > 0){ ?>

 
  <table width="235" border="1" align="center" cellpadding="3" bordercolor="#003333">
  <td width="122" bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo Estudiante: </div></td>
      <td width="89" bgcolor='#FEF7ED'> <select name="codigotipoestudiante" id="codigotipoestudiante" onChange="selec_tipo_estudiante()">
	    
	  <!-- <option value="<?php if (isset($codigotipoestudiante)){echo $codigotipoestudiante;}else{}?>"><?php if (isset($codigotipoestudiante)){echo $codigotipoestudiante;}?></option>  -->
        <?php
        do {
?>
        <option value="<?php echo $row_seleccionatipoestudiante['codigotipoestudiante']?>" <?php if(@$row_seleccionatipoestudiante['codigotipoestudiante'] == @$codigotipoestudiante) {echo "selected";} ?>><?php echo $row_seleccionatipoestudiante['nombretipoestudiante']?></option>
        <?php
        } while ($row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante));
        $rows = mysql_num_rows($seleccionatipoestudiante);
        if($rows > 0) {
        	mysql_data_seek($seleccionatipoestudiante, 0);
        	$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
        }
?>
        </select>           
      </td>
  </tr>
</table>
<br>
  
  <?php } ?>
  
<?php if (isset($_GET['codigotipoestudiante'])){$codigotipoestudiante=$_GET['codigotipoestudiante'];?>

<table width="290" border="1" align="center" cellpadding="3" bordercolor="#003333">
  <tr><td width="122" bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto:</div></td>
    <td width="122" bgcolor="#CCDADD" class="Estilo2">Valor:</td>
    <td width="122" bgcolor="#CCDADD" class="Estilo2">Selección:</td>
  </tr>
  
  <?php 

  //busca que existe en la tabla detallefactura, a lo que haya, le pondra el chulito
  $query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, c.codigoconcepto, v.valorpecuniario, c.nombreconcepto
FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
AND codigoperiodo='$codigoperiodo'";

  $mostrar_conceptos=mysql_query($query_mostrar_conceptos,$sala);
  while($concepto=mysql_fetch_assoc($mostrar_conceptos)){
  	$chequear="";
  	$query_verifica_chequeado="SELECT df.idvalorpecuniario FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
WHERE 
df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
AND df.idvalorpecuniario = vp.idvalorpecuniario
AND df.codigotipoestudiante = ".$codigotipoestudiante."
AND df.codigoestado = '100'
AND fvp.codigoperiodo = ".$codigoperiodo."
AND fvp.codigocarrera=".$codigofacultad."
AND df.idvalorpecuniario = ".$concepto['idvalorpecuniario']."";
  	//echo $query_verifica_chequeado;
  	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
  	$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
  	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
  	if ($row_verifica_chequeado > 0){$chequear="checked";}
  	echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><input type='checkbox' name='sel".$concepto['idvalorpecuniario']."' $chequear value='".$concepto['idvalorpecuniario']."'></td>
		</tr>
						
";}?>
		
</table>


 <br>
 <div align="center">
   <input name="enviar3" type="submit" id="enviar3" value="Enviar">
   <?php } ?>
  
<?php 
if (isset($_POST['enviar3'])){
	$query_busca_factura="select * from facturavalorpecuniario f where codigocarrera=".$codigofacultad." and codigoperiodo=".$codigoperiodo.""; //busca si hay algun valor en la tabla facturavalorpecuniario
	$busca_factura=mysql_query($query_busca_factura,$sala);
	$num_rows_buscafactura=mysql_num_rows($busca_factura);
	$factura=mysql_fetch_assoc($busca_factura);
	$query_verifica_chequeado="SELECT df.idvalorpecuniario FROM detallefacturavalorpecuniario df, valorpecuniario vp, facturavalorpecuniario fvp
	WHERE 
	df.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
	AND df.idvalorpecuniario = vp.idvalorpecuniario
	AND df.codigotipoestudiante = ".$codigotipoestudiante."
	AND df.codigoestado = '100'
	AND fvp.codigoperiodo = ".$codigoperiodo."
	AND fvp.codigocarrera=".$codigofacultad."
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
		$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where nombrefacturavalorpecuniario = '".$_GET['nombrefacturavalorpecuniario']."' and
		 codigoperiodo='".$codigoperiodo."' and
		codigocarrera='".$codigofacultad."' ";
		$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
		$idfvp=mysql_fetch_assoc($seleciona_idfvp);
		//verifica si hay algo en detallefacuravalorpecuniario, si existe algo, debe efectuar update o insert de algo nuevo


		//se debe buscar que existe en la tabla detallefactura, para ver a que se le va a efectuar el update

		//busca el idfacturavalorpecuniario, de la factura para poder ingresar consultar los datos en detallefacturavalorpecuniario
		$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where nombrefacturavalorpecuniario = '".$_GET['nombrefacturavalorpecuniario']."' and
		 codigoperiodo='".$codigoperiodo."' and
		codigocarrera='".$codigofacultad."' ";
		$seleciona_idfvp=mysql_query($query_selecciona_idfvp,$sala);
		$idfvp=mysql_fetch_assoc($seleciona_idfvp);

		//consulta la bd, para ver todo lo que hay con es idfactura
		$query_seleccionar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$codigotipoestudiante."'
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
			print_r($array_detallefvp);echo "<br>";
			print_r($array_post);echo "<br>";
			echo "<br>";
			print_r($array_actualizar);echo "<br>";
			print_r($array_eliminar);echo "<br>";


			$query_actualizar_detallefvp="select * from detallefacturavalorpecuniario where idfacturavalorpecuniario ='".$idfvp['idfacturavalorpecuniario']."'
		and codigotipoestudiante = '".$codigotipoestudiante."'
		and codigoestado ='100'";

			$seleccionar_actualizar_detallefvp=mysql_query($query_actualizar_detallefvp);
			while ($actualizar_detallefvp=mysql_fetch_assoc($seleccionar_actualizar_detallefvp)){
				foreach ($array_eliminar as $eliminacion => $valeliminar){
					$query_actualizar="update detallefacturavalorpecuniario SET codigoestado='200' where iddetallefacturavalorpecuniario='".$actualizar_detallefvp['iddetallefacturavalorpecuniario']."' and idvalorpecuniario='".$array_eliminar[$eliminacion]."' and idfacturavalorpecuniario='".$actualizar_detallefvp['idfacturavalorpecuniario']."'";
					echo $query_actualizar;
					$eliminar=mysql_query($query_actualizar);
				}



				foreach ($array_actualizar as $inserccion => $valactualizar){
					$query_insertar_nuevo_detallefvp="insert into detallefacturavalorpecuniario(idfacturavalorpecuniario,idvalorpecuniario,codigotipoestudiante,codigoestado) values
					('".$idfvp['idfacturavalorpecuniario']."','".$array_actualizar[$inserccion]."','".$codigotipoestudiante."'
					,'100')";	


					echo $query_insertar_nuevo_detallefvp;
					$insertar=mysql_query($query_insertar_nuevo_detallefvp);
				}


			}
			?>
			<script language="javascript">
			window.location.reload("facturavalorpecuniariomenu.php?nombrefacturavalorpecuniario=<?php echo $_GET['nombrefacturavalorpecuniario']?>&codigotipoestudiante=<?php echo $codigotipoestudiante?>");
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
		window.location.reload("facturavalorpecuniariomenu.php?nombrefacturavalorpecuniario=<?php echo $_GET['nombrefacturavalorpecuniario']?>&codigotipoestudiante=<?php echo $codigotipoestudiante?>");
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
		$query_selecciona_idfvp="select fvp.idfacturavalorpecuniario from facturavalorpecuniario fvp where nombrefacturavalorpecuniario = '".$_GET['nombrefacturavalorpecuniario']."' and
	 codigoperiodo='".$codigoperiodo."' and
	codigocarrera='".$codigofacultad."' ";
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
			('".$idfvp['idfacturavalorpecuniario']."','".$_POST[$vpost]."','".$codigotipoestudiante."'
			,'100')";
				//$query_insertar_nuevo_detallefvp;
				$insertar_nuevo_detallefvp=mysql_query($query_insertar_nuevo_detallefvp);
			}
		}
		//si se logro la insercion, se vuelve a cargar la pagina, con las variables para mostrar los datos
		if($insertar_nuevo_detallefvp){ ?>

		<script language="javascript">
		window.location.reload("facturavalorpecuniariomenu.php?nombrefacturavalorpecuniario=<?php echo $_GET['nombrefacturavalorpecuniario']?>&codigotipoestudiante=<?php echo $codigotipoestudiante?>");
		</script>
		<?php }else {echo mysql_error();} 
	}

	
	}



}



?>


  
 </div>
</form>

<?php
mysql_free_result($seleccionatipoestudiante);
mysql_free_result($tomacodigocarrera);
?>
<?php echo $codigofacultad;echo $codigoperiodo;?>