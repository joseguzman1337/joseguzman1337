<?php
class tablas
{
	function leer_llaves($matriz)
	{
		$matriz_columnas=array_keys($matriz[0]);
		return $matriz_columnas;

	}

	function escribir_cabeceras_chulitos($matriz)
	{
		echo "<tr>\n";
		if($this->llavechulitos!="")
		{
			echo "<td>Seleccione</a></td>\n";
		}
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}


	function tabla_chulitos($matriz,$llavechulitos,$metodo='post',$accion="",$texto="")
	{
		//echo "<form name='form' method='$metodo' action='$accion'>\n";

		$this->llavechulitos=$llavechulitos;
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		$this->escribir_cabeceras_chulitos($matriz[0]);
		for($i=0; $i < count($matriz); $i++)
		{
			if($metodo='GET' or $metodo='get')
			{
				if($_GET["sel".$matriz[$i][$llavechulitos]]==$matriz[$i][$llavechulitos])
				{
					$chequear="checked";
				}
				else
				{
					$chequear="";
				}
			}
			elseif($metodo='POST' or $metodo='post')
			{
				if($_POST["sel".$matriz[$i][$llavechulitos]]==$matriz[$i][$llavechulitos])
				{
					$chequear="checked";
				}
				else
				{
					$chequear="";
				}
			}

			echo "<tr>\n";
			echo "<td><div align='center'><input type='checkbox' name='sel".$matriz[$i][$llavechulitos]."' $chequear value='".$matriz[$i][$llavechulitos]."'></div></td>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
		echo "<input name='Enviar' type='submit' id='Enviar' value='Enviar'>\n";
		//echo "</form>";
	}


	function escribir_cabeceras($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}
	function tabla($matriz,$texto="")
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		escribir_cabeceras($matriz[0],$link);
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
}
?>