<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<?php
//header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
//header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 
//session_cache_limiter('private');
//session_start();
setlocale(LC_ALL,'es_ES');
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/fpdf/fpdf.php");
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require_once("funciones/foliacion_automatica.php");
$_SESSION['MM_Username']='admintecnologia';
$foliacion=new foliacion_automatica($sala,'validar');
$valido=$foliacion->validar();
?>
<?php if($valido==true){ ?>
<form name="form1" method="post" action="">
  <p>Generaci&oacute;n e impresi&oacute;n autom&aacute;tica de folios</p>
  <table width="298" border="1">
  <tr>
    <td width="251">Previsualizar nuevos Folios</td>
    <td width="31"><input name="previsualizar" type="radio" value="previsualizar" onClick="document.form1.submit()"></td>
  </tr>
  <tr>
    <td>Generar e Imprimir nuevos folios</td>
    <td><input name="generar" type="radio" value="generar" onClick="document.form1.submit()"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="Regresar" type="submit" id="Regresar" value="Regresar">
    </div></td>
    </tr>
</table>
</form>
<?php }?>

<?php if(isset($_POST['previsualizar'])){ ?>
<script language="javascript">window.open('mostrar_folios.php?accion=previsualizar')</script>
<?php }?>
<?php if(isset($_POST['generar'])){ ?>
<script language="javascript">window.open('generar_folios.php?accion=generar')</script>
<?php }?>
<?php if(isset($_POST['Regresar'])){ ?>
<script language="javascript">window.location.reload('menu.php')</script>
<?php }?>
