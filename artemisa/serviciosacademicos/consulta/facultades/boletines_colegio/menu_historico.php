<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
.amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
.Estilo6 {font-size: 13px}
.Estilo5 {font-family: Tahoma; font-size: 12px; }
-->
</style>
<form name="form1" method="post" action="">
<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
     
      <tr>
        <td>Semestre</td>
        <td><input name="semestre" type="text" id="semestre">          </td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <input name="Enviar" type="submit" id="Enviar" value="Enviar">
        </div></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
<?php
if(isset($_POST['Enviar']))
{
	error_reporting(0);
	$validaciongeneral=true;
	/* if($_POST['numerocorte']=="" or $_POST['numerocorte']==0)
	{
		$valido['mensaje']="Debe Digitar el número de corte";
		$valido['valido']=0;
		$validacion['numerocorte']=$valido;
	} */
	
	if($_POST['semestre']=="" or $_POST['semestre']==0)
	{
		$valido['mensaje']="Debe Digitar el número de semestre";
		$valido['valido']=0;
		$validacion['semestre']=$valido;
	}

	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{ ?>
	    <script language="javascript">window.location.reload("certificado_notas_masivo_historico.php?numerocorte=<?php echo $_POST['numerocorte']?>&semestre=<?php echo $_POST['semestre']?>&codigoestudiante=<?php echo $_GET['codigoestudiante']?>")</script>
	<?php }
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?> 
