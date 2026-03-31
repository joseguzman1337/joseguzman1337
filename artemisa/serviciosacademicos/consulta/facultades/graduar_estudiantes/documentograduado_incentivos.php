<script language="javascript">
function resetearform()
{
document.form1.reset();
}
</script>
<?php require_once('../../../Connections/sala2.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
unset($incentivos);
unset($_SESSION["incentivos"]);
require_once('../../../Connections/sala2.php');
$idregistrograduado=$_GET['idregistrograduado'];
$idusuario=$_GET['idusuario'];
echo '<script language="Javascript">
function recargar() {window.location.reload("documentograduado_incentivos.php?idusuario='.$idusuario.'&idregistrograduado='.$idregistrograduado.'")}
</script>';
$maxRows_registroincentivo = 1;
$pageNum_registroincentivo = 0;
if (isset($_GET['pageNum_registroincentivo'])) {
  $pageNum_registroincentivo = $_GET['pageNum_registroincentivo'];
}
$startRow_registroincentivo = $pageNum_registroincentivo * $maxRows_registroincentivo;

mysql_select_db($database_sala, $sala);
$query_registroincentivo = "select * from registroincentivoacademico where idregistrograduado='$idregistrograduado' and codigoestado='100'";
$query_limit_registroincentivo = sprintf("%s LIMIT %d, %d", $query_registroincentivo, $startRow_registroincentivo, $maxRows_registroincentivo);
$registroincentivo = mysql_query($query_limit_registroincentivo, $sala) or die(mysql_error());
$row_registroincentivo = mysql_fetch_assoc($registroincentivo);

if (isset($_GET['totalRows_registroincentivo'])) {
  $totalRows_registroincentivo = $_GET['totalRows_registroincentivo'];
} else {
  $all_registroincentivo = mysql_query($query_registroincentivo);
  $totalRows_registroincentivo = mysql_num_rows($all_registroincentivo);
}
$totalPages_registroincentivo = ceil($totalRows_registroincentivo/$maxRows_registroincentivo)-1;
?>


<?php
$queryString_registroincentivo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_registroincentivo") == false && 
        stristr($param, "totalRows_registroincentivo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_registroincentivo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_registroincentivo = sprintf("&totalRows_registroincentivo=%d%s", $totalRows_registroincentivo, $queryString_registroincentivo);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
@session_start();
require_once('../../../Connections/sala2.php');
$usuario=$_SESSION['MM_Username'];
require('funciones/funcionip.php');
require('calendario/calendario.php');
require('../../../funciones/validacion.php');
$fecharegistroincenitvograduado=date("Y-m-d H:i:s");
$direccionipregistroincentivograduado=tomarip();


mysql_select_db($database_sala, $sala);
$query_incentivoacademico="select * from incentivoacademico";
$incentivoacademico=mysql_query($query_incentivoacademico,$sala) or die(mysql_error());
$row_incentivoacademico=mysql_fetch_assoc($incentivoacademico);
$totalrows_incentivoacademico=mysql_num_rows($incentivoacademico);


mysql_select_db($database_sala, $sala);
$query_verifica_registroincentivo="select * from registroincentivoacademico where idregistrograduado='$idregistrograduado' and codigoestado='100'";
$verifica_registroincentivo=mysql_query($query_verifica_registroincentivo,$sala) or die(mysql_error());
$totalrows_verifica_registroincentivo=mysql_num_rows($verifica_registroincentivo);
$row_verifica_registroincentivo=mysql_fetch_assoc($verifica_registroincentivo); 
//echo "<h1>",$totalrows_verifica_registroincentivo,"</h1>";
mysql_select_db($database_sala, $sala);
$query_verifica_incentivos="select * from documentograduado d where d.idregistrograduado='$idregistrograduado' and d.codigotipodocumentograduado='3' and codigoestado='100'";
$verifica_incentivos=mysql_query($query_verifica_incentivos,$sala);
$row_verifica_incentivos=mysql_fetch_assoc($verifica_incentivos);
$numrows_verifica_incentivos=mysql_num_rows($verifica_incentivos);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<div align="center" class="Estilo3">
  <form name="form1" method="post" action="">
    <div align="center" class="Estilo3">
      <p>REGISTRO INCENTIVOS ACADEMICOS </p>
    </div>
    <table border="2" align="center" cellpadding="2" bordercolor="#003333">
      <tr>
        <td><table border="0" align="center" cellpadding="0" bordercolor="#003333">
            <?php do { ?>
            <tr class="Estilo2">
              <td bgcolor="#C5D5D6"><div align="center">Descripci&oacute;n Incentivo Acad&eacute;mico<span class="Estilo4">*</span> </div></td>
              <td bgcolor="#FFFFFF"><input name="nombreregistroincentivoacademico" type="text" id="nombreregistroincentivoacademico" size="65" value="<?php if(isset($_POST['nombreregistroincentivoacademico'])){echo $_POST['nombreregistroincentivoacademico'];}else{echo $row_registroincentivo['nombreregistroincentivoacademico'];}?>"></td>
            </tr>
            <tr class="Estilo2">
              <td width="116" bgcolor="#C5D5D6"><div align="center">Incentivo<span class="Estilo4">*</span></div></td>
              <td width="42" bgcolor="#FFFFFF"><div align="center"><span class="Estilo1">
              <select name="idincentivoacademico">
                <option value="">Seleccionar</option>
                <?php
                    do {
						 $idregistroincentivoacademico=$row_registroincentivo['idregistroincentivoacademico'];
						 //$idregistroincentivoacademico_2=$idregistroincentivoacademico;	
						 $idincentivoacademico=$row_registroincentivo['idincentivoacademico'];


?>
                <option value="<?php echo $row_incentivoacademico['idincentivoacademico']?>" <?php if(isset($_POST['idincentivoacademico'])){if($_POST['idincentivoacademico']==$row_incentivoacademico['idincentivoacademico']){echo "selected";};}elseif($row_registroincentivo['idincentivoacademico']==$row_incentivoacademico['idincentivoacademico']){echo "selected";}?>><?php echo $row_incentivoacademico['nombreincentivoacademico']?></option>
                <?php
                    } while ($row_incentivoacademico = mysql_fetch_assoc($incentivoacademico));
					
					
 ?>
              </select>
</span></div></td>
            </tr>
            <tr class="Estilo2">
              <td bgcolor="#C5D5D6"><div align="center">Observaci&oacute;n<span class="Estilo4">*</span><span class="Estilo4"></span> </div></td>
              <td bgcolor="#FFFFFF"><textarea name="observacionregistroincentivoacademico" cols="55" id="observacionregistroincentivoacademico"><?php if(isset($_POST['observacionregistroincentivoacademico'])){echo $_POST['observacionregistroincentivoacademico'];}else{echo $row_registroincentivo['observacionregistroincentivoacademico'];}?></textarea></td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Fecha de Acuerdo<span class="Estilo4">*</span></div></td>
              <td><?php if(isset($_POST['fechaacuerdoregistroincentivoacademico'])){escribe_formulario_fecha_vacio("fechaacuerdoregistroincentivoacademico","form1","",@$_POST['fechaacuerdoregistroincentivoacademico']);}else{escribe_formulario_fecha_vacio("fechaacuerdoregistroincentivoacademico","form1","",@$row_registroincentivo['fechaacuerdoregistroincentivoacademico']);} ?> </td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">N&uacute;mero de Acuerdo<span class="Estilo4">*</span></span></div></td>
              <td><input name="numeroacuerdoregistroincentivoacademico" type="text" id="numeroacuerdoregistroincentivoacademico" size="65" value="<?php if(isset($_POST['numeroacuerdoregistroincentivoacademico'])){echo $_POST['numeroacuerdoregistroincentivoacademico'];}else{echo $row_registroincentivo['numeroacuerdoregistroincentivoacademico'];}?>"></td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Fecha de Acta<span class="Estilo4">*</span></span></div></td>
              <td><?php if(isset($_POST['fechaactaregistroincentivoacademico'])){escribe_formulario_fecha_vacio("fechaactaregistroincentivoacademico","form1","",@$_POST['fechaactaregistroincentivoacademico']);}else{escribe_formulario_fecha_vacio("fechaactaregistroincentivoacademico","form1","",@$row_registroincentivo['fechaactaregistroincentivoacademico']);} ?></td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">N&uacute;mero de Acta<span class="Estilo4">*</span></span></div></td>
              <td><input name="numeroactaregistroincentivoacademico" type="text" id="numeroactaregistroincentivoacademico" size="65" value="<?php if(isset($_POST['numeroactaregistroincentivoacademico'])){echo $_POST['numeroactaregistroincentivoacademico'];}else{echo $row_registroincentivo['numeroactaregistroincentivoacademico'];}?>"></td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Firmas<span class="Estilo4">*</span></span></div></td>
              <td><input name="firmas" type="submit" id="firmas" onclick="abrir('documentograduado_firmas_incentivos.php?idincentivoacademico=<?php if($totalrows_verifica_registroincentivo >0){echo $idincentivoacademico;}?>&documento=3&idregistrograduado=<?php echo $idregistrograduado;?>&idregistroincentivoacademico=<?php echo $idregistroincentivoacademico;?>','ventana2','width=300,height=300,top=200,left=150,scrollbars=yes');return false" value="Registrar Firmas"/>
                  <span class="Estilo4">*</span></td>
            </tr>
            <tr class="Estilo1">
              <td colspan="2" bgcolor="#C5D5D6">&nbsp;</td>
            </tr>
            <tr class="Estilo1">
              <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Firmas Registradas</span></div></td>
              <td><?php 
			  unset ($row_firmas_registroincentivoacademico);
			  //echo $idregistroincentivoacademico,"<br>",$idincentivoacademico;
			  $query_firmas_registroincentivoacademico="SELECT concat(nombresdirectivo, ' ', apellidosdirectivo) AS directivo FROM documentograduado dg, directivo d
						WHERE dg.codigoestado='100' AND dg.codigotipodocumentograduado='3' AND dg.idincentivoacademico='$idincentivoacademico' AND
						dg.iddirectivo=d.iddirectivo AND idregistroincentivoacademico='$idregistroincentivoacademico' and idregistrograduado='$idregistrograduado'";
						$firmas_registroincentivoacademico=mysql_query($query_firmas_registroincentivoacademico, $sala) or die(mysql_error);
				//echo $query_firmas_registroincentivoacademico;			
			  while($row_firmas_registroincentivoacademico=mysql_fetch_assoc($firmas_registroincentivoacademico)){echo $row_firmas_registroincentivoacademico['directivo'],"<br>";}?></td>
            </tr>
            <?php } while ($row_registroincentivo = mysql_fetch_assoc($registroincentivo)); ?>
          </table>
          <p>
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_registroincentivo > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_registroincentivo=%d%s", $currentPage, 0, $queryString_registroincentivo); ?>"><img src="../../../../imagenes/First.gif" width="18" height="13" border=0></a>
                  <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_registroincentivo > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_registroincentivo=%d%s", $currentPage, max(0, $pageNum_registroincentivo - 1), $queryString_registroincentivo); ?>"><img src="../../../../imagenes/Previous.gif" width="14" height="13" border=0></a>
                  <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_registroincentivo < $totalPages_registroincentivo) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_registroincentivo=%d%s", $currentPage, min($totalPages_registroincentivo, $pageNum_registroincentivo + 1), $queryString_registroincentivo); ?>"><img src="../../../../imagenes/Next.gif" width="14" height="13" border=0></a>
                  <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_registroincentivo < $totalPages_registroincentivo) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_registroincentivo=%d%s", $currentPage, $totalPages_registroincentivo, $queryString_registroincentivo); ?>"><img src="../../../../imagenes/Last.gif" width="18" height="13" border=0></a>
                  <?php } // Show if not last page ?>
              </td>
            </tr>
          </table>
          </p>
<div align="center">
              <input name="Atras" type="submit" id="Atras" value="Atras" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Grabar" type="submit" id="Grabar" value="Actualizar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Anular" type="submit" id="Anular" value="Anular" />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="Adicionar Incentivo" type="button" id="Adicionar Incentivo" value="Adicionar Nuevo" onclick="abrir('documentograduado_incentivos_nuevos.php?idusuario=<?php echo $_GET['idusuario']?>&idincentivoacademico=<?php if($totalrows_registroincentivo==1){echo $row_registroincentivo['idincentivoacademico'];}?>&documento=3&idregistrograduado=<?php echo $idregistrograduado;?>','ventana4','width=615,height=350,top=200,left=150,scrollbars=yes');return false">
		&nbsp;<?php	 
		//echo $idregistroincentivoacademico,"<br>",$idincentivoacademico; 
		$idregistroincentivoacademico_2=$idregistroincentivoacademico;
		?>
          </div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
<?php 

if(isset($_POST['Grabar'])){
	if(isset($_SESSION["incentivos"]))
	{
		$incentivos=$_SESSION["incentivos"];
	}
	$validacion_incentivo['req_nombreregistroincentivoacademico']=validar($_POST['nombreregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el nombre del trabajo de grado")</script>', true);
	$validacion_incentivo['req_idincentivoacademico']=validar($_POST['idincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado el incentivo académico")</script>', true);
	$validacion_incentivo['req_observacion']=validar($_POST['observacionregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado la Observación")</script>', true);
	$validacion_incentivo['req_fechaacuerdoregistroincentivoacademico']=validar($_POST['fechaacuerdoregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado la fecha del acuerdo")</script>', true);
	$validacion_incentivo['fech_fechaacuerdoregistroincentivoacademico']=validar($_POST['fechaacuerdoregistroincentivoacademico'],"fecha",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acuerdo")</script>', true);
	$validacion_incentivo['req_numeroacuerdoregistroincentivoacademico']=validar($_POST['numeroacuerdoregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del acuerdo")</script>', true);
	$validacion_incentivo['req_fechaactaregistroincentivoacademico']=validar($_POST['fechaactaregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acta")</script>', true);
	$validacion_incentivo['fech_fechaactaregistroincentivoacademico']=validar($_POST['fechaactaregistroincentivoacademico'],"fecha",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acta")</script>', true);
	$validacion_incentivo['req_numeroactaregistroincentivoacademico']=validar($_POST['numeroactaregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del acta")</script>', true);

	$validacion_general=true;
	foreach ($validacion_incentivo as $indice => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validacion_general=false;
		}
	}

	if($numrows_verifica_incentivos > 0)
	{
		$validaporbd=true;
	}
	else
	{
		$validaporbd=false;
	}
	if($validaporbd==true){
		if($validacion_general==true){
			require('insertar_datos_incentivos.php');
			require('insertar_datos_firmas_incentivos.php');
			unset($incentivos);
			unset($_SESSION['incentivos']);
		}
	}
	else
	{
		if($validacion_general==true and isset($incentivos)){
			require('insertar_datos_incentivos.php');
			require('insertar_datos_firmas_incentivos.php');
			unset($incentivos);
			unset($_SESSION['incentivos']);
		}
		else
		{
			if(!isset($incentivos)){
				unset($_SESSION["incentivos"]);
				unset($incentivos);
				echo '<script language="JavaScript">alert("No ha ingresado firmas para los incentivos de grado")</script>';
			}
		}
	}


}
?>
<?php 
if(isset($_POST['Anular']))
//echo $idregistroincentivoacademico;
{
	//if($totalrows_registroincentivo>0){
		$query_anular_incentivos="update registroincentivoacademico set codigoestado='200' where idregistrograduado = '".$_GET['idregistrograduado']."' and idregistroincentivoacademico='".$idregistroincentivoacademico."'";
		$anular_incentivos=mysql_query($query_anular_incentivos, $sala) or die(mysql_error());
		$query_anular_firmas_incentivos="update documentograduado set codigoestado='200' where idregistrograduado = '".$_GET['idregistrograduado']."' and codigotipodocumentograduado='3' and idincentivoacademico='".$idincentivoacademico."' and idregistroincentivoacademico='".$idregistroincentivoacademico."'";
		$anular_firmas_incentivos=mysql_query($query_anular_firmas_incentivos,$sala) or die(mysql_error());
		//echo $query_anular_firmas_incentivos;
		 if($anular_incentivos and $anular_firmas_incentivos){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';} 
	//}
}

if(isset($_POST['Atras'])){
unset($_SESSION["incentivos"]);
unset($incentivos);
echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
}

mysql_free_result($registroincentivo);
?>

