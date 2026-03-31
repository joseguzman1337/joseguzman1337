<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<script language="javascript">
function enviar()
{
	document.aplicaarp.submit()
}
</script>
<?php 
 session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//print_r($_POST);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');


?>
<form name="aplicaarp" method="post" action="">
  <p align="center" class="Estilo3">CREAR REGIONAL - MENU PRINCIPAL </p>
  <table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">

    <tr>
      <td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Acci&oacute;n</div></td>
      <td width="49%" bordercolor="#FFFFFF" bgcolor='#FEF7ED'><div align="center">
          <select name="tipo" id="tipo" onChange="cambia_tipo()">
            <option>Seleccionar</option>
            <option value="1">Insertar datos</option>
            <option value="2">Modificar datos</option>
          </select>
      </div></td>
    </tr>

  </table>
</form>
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.aplicaarp.tipo[document.aplicaarp.tipo.selectedIndex].value 
    //miro a ver si el tipo estï¿½ definido 
    if (tipo == 1)
	{
		window.location.reload("crear_regional.php"); 
	} 
	if (tipo == 2)
	{
		window.location.reload("modificar_regional.php"); 
	} 
}
</script>