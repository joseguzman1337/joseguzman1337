<?php
//error_reporting(2047);//print_r($_GET);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php
print_r($_GET);
//error_reporting(2047);
@session_start();
//print_r($_SESSION);
//require_once('../funciones/validacion.php');
require_once('../../../../funciones/conexion/conexionpear.php');
require_once('../funciones/gui/combo_valida_get.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);
?>
<?php
$grupomaterialinea=&DB_DataObject::factory('grupomaterialinea');
if(isset($_GET['codigoperiodo']) and isset($_GET['idgrupomateria']) and $_GET['codigoperiodo']!="" and $_GET['idgrupomateria']!="")
{
	//DB_DataObject::debugLevel(5);
	$grupomaterialinea->whereAdd("codigoperiodo='".$_GET['codigoperiodo']."' and idgrupomateria='".$_GET['idgrupomateria']."'");
	$grupomaterialinea->get('','*');
}
?>
<form name="form1" method="get" action="">
<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr>
        <td width="45%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione Periodo</div></td>
        <td width="55%" bgcolor="#FEF7ED"><?php $validacion['codigoperiodo']=combo_valida_get("codigoperiodo","periodo","codigoperiodo","codigoperiodo",'onChange="enviar()"','',"codigoperiodo desc","si","Periodo")?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione Grupo </div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['idgrupomateria']=combo_valida_get("idgrupomateria","grupomateria","idgrupomateria","nombregrupomateria",'onChange="enviar()"','',"","si","Grupo materia")?></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td><div align="center">ID</div></td>
        <td bgcolor="#CCDADD"><div align="center">MATERIA</div></td>
        <td><div align="center">PERIODO</div></td>
        <td><div align="center">GRUPO</div></td>
      </tr>
	  <?php do{
	  if($grupomaterialinea->idgrupomaterialinea!=""){
	  $materia=$grupomaterialinea->getLink('codigomateria','materia','codigomateria');
	  $grupomateria=$grupomaterialinea->getLink('idgrupomateria','grupomateria','idgrupomateria');
	 
	  ?>
      <tr class="Estilo1">
        <td><div align="center"><?php echo $grupomaterialinea->idgrupomaterialinea?></div></td>
        <td><div align="center"><?php echo $materia->nombremateria?></div></td>
        <td><div align="center"><?php echo $grupomaterialinea->codigoperiodo?></div></td>
        <td><div align="center"><?php echo $grupomateria->nombregrupomateria?></div></td>
      </tr>
	  <?php };} while($grupomaterialinea->fetch())?>
    </table></td>
  </tr>
</table>
<br>
<p>&nbsp;</p>
</form>