<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #333333; }
.Estilo16 {font-size: 9px; color:#FFFFFF}
.Estilo19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #FFFFFF; }
.Estilo21 {font-size: 9px; color: #FFFFFF; }
.Estilo23 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #FFFFFF; }
.Estilo26 {font-size: 10px; color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
<form name="form1" method="post" action="usuarioaspirante/redireccionaingresousuario.php">
  <input  type="hidden" name="usuario" style="font-size:9px" size="15" value="<?php echo $_GET['usuario'];?>">
<table width="100%">
<tr>
 <td>
 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#94944C">

	<tr>
      <td align="left"><span class="Estilo11"><span class="Estilo21">E-mail</span><br>
      </span></td>
      <td align="left">
        <input  type="text" name="usuario" size="15" value="<?php echo $usuario;?>"  style="font-size:9px">
</td>
		</tr>
    <tr>
      <td align="left"><span class="Estilo19">Contraseña</span></td>
      <td align="left">
          <input  type="password" name="clave" size="15" style="font-size:10px">
        </td>
<tr>
      <td colspan="2" align="left"><span class="Estilo5">
            <input type="submit" name="ingresar" value="Entrar" style="font-size:9px">
            <!--<input type="submit" name="cancelar" value="Cancelar" style="font-size:9px">-->
      </span></td>
</tr>
 </table>
         </td>
</tr>
</table>