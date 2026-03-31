<?php  require_once('../Connections/sala2.php');
?>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
-->
</style>
<p>&nbsp;</p>
<table width="100%"  border="3" bordercolor="#003333">
  <tr>
    <td>
        <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#003333">
          <tr>
            <td align="center" bgcolor="#C5D5D6" class="Estilo2">Descripci&oacute;n Mensaje&nbsp;</td>
          </tr>
<?php 
	         mysql_select_db($database_sala, $sala);
			$query_mensaje = "SELECT * from mensaje
			                  where idmensaje = '".$_GET['idmensaje']."'";
			//echo $query_valida;
			//exit();
			//echo $query_valida; and fechainiciomensaje <= '".date("Y-m-d")."'  and fechafinalmensaje >= '".date("Y-m-d")."'
			$mensaje = mysql_query($query_mensaje, $sala) or die(mysql_error());
			$row_mensaje = mysql_fetch_assoc($mensaje);
			$totalRows_mensaje = mysql_num_rows($mensaje);														
					echo '<tr>					
						<td><div align="center" class="Estilo1">'.$row_mensaje["descripcionmensaje"].'&nbsp;</div></td>
						</tr>';		    

         if($_GET['tipo'] <> 1)
		   {
		      $base="update mensaje 
			         set  codigoestadomensaje = '200'
					 where idmensaje = '".$_GET['idmensaje']."'"; 
	          $sol=mysql_db_query($database_sala,$base);	
		   }

?>
        </table>    </td> 
  </tr>
</table>
        
<div align="left">
  <input name="Aceptar" type="button" id="Aceptar" value="Cerrar" onClick="window.close()">
</div>
