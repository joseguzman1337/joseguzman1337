<?php 
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
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
function enviar()
{
	document.form1.submit()
}
</script>

<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">DESCUENTOS - MENU PRINCIPAL </p>
  <table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Acci&oacute;n</div></td>
      <td width="49%" bordercolor="#FFFFFF" bgcolor='#FEF7ED'><div align="center">
          <select name="tipo" id="tipo" onChange="cambia_tipo()">
            <option>Seleccionar</option>
            <option value="1">Consultar descuentos</option>
            <option value="2">Consultar/asociar descuentos asociados a carreras</option>
			<option value="3">Consultar/asociar descuentos asociados a grupos</option>
			<option value="4">Consultar/asociar descuentos asociados a estudiantes</option>
          </select>
      </div></td>
    </tr>
  </table>
  <script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.form1.tipo[document.form1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if 	(tipo == 1)
	{
		window.location.reload("descuentoeducacioncontinuada_listado.php");
	}
	if (tipo == 2)
	{
		window.location.reload("descuentocarreraeducacioncontinuada_listado.php");
	}
	if (tipo == 3)
	{
		window.location.reload("descuentogrupoeducacioncontinuada_listado.php");
	}
	if (tipo == 4)
	{
		window.location.reload("busqueda_estudiante.php");
	}

}
  </script>
</form>
