<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class Tabla
{

	function EscribirCabecerasTablaNormal($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function EscribirCabecerasTablaAgregarEditarEliminar($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "<td nowrap>Agregar</td>\n";
		echo "<td nowrap>Editar</td>\n";
		echo "<td nowrap>Eliminar</td>\n";
		echo "</tr>\n";
	}

	function DibujarTablaNormal($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->EscribirCabecerasTablaNormal($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}

	function DibujaTablaAgregarEditarEliminar($matriz,$columna_llave_principal,$columna_llave_secundaria,$link_destino,$llave_desactiva="codigoestado",$valor_llave_desactiva=200,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->EscribirCabecerasTablaAgregarEditarEliminar($matriz[0]);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo '<td nowrap><a href="'.$link_destino.'?adicionar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/adicionar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo '<td nowrap><a href="'.$link_destino.'?editar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/editar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo '<td nowrap><a href="'.$link_destino.'?eliminar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/eliminar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}
}
?>
