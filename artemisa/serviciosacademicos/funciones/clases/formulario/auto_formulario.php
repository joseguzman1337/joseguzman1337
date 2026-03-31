<?php
class GeneradorArchivoDescripcionTabla extends ADODB_Active_Record
{
	var $Conexion;
	var $Tabla;
	var $BaseDatos;
	var $Depurar;
	var $ArrayTablasBD;
	var $InfoObjetoTabla;
	var $ObjetoTabla;
	var $ArrayAtributosTabla;

	function GeneradorArchivoDescripcionTabla($Tabla, $Conexion, $BaseDatos,$Depurar=false)
	{
		$this->Conexion=$Conexion;
		$this->Tabla=$Tabla;
		$this->BaseDatos=$BaseDatos;
		$this->Depurar=$Depurar;
		if($this->Depurar==true)
		{
			$this->Conexion->debug=true;
		}
		$this->ArrayTablasBD=$this->ObtenerNombresTablasBD($this->BaseDatos);
	}

	function InstanciarObjeto($Tabla)
	{
		$this->ObjetoTabla= new ADODB_Active_Record($Tabla);
	}

	function ObtenerAtributosTabla()
	{
		$Atributos=$this->ObjetoTabla->GetAttributeNames();
		if($this->Depurar==true)
		{
			echo "<h1>Atributos:<br></h1>";
			print_r($Atributos);
		}
		return $Atributos;
	}

	function ObtenerInfoObjetoTabla()
	{
		$InfoObjeto=$this->ObjetoTabla->TableInfo();
		return $InfoObjeto;
	}

	function ObtenerLLaveObjetoTabla()
	{
		$Atributos=$this->ObjetoTabla->GetAttributeNames();
		$InfoObjeto=$this->ObjetoTabla->TableInfo();
		$Llave=array_keys($InfoObjeto->keys);
		if($this->Depurar==true)
		{
			echo "<h1>Llaves:<br></h1>";
			print_r($Llave);
		}
		return $Llave;
	}

	function ObtenerNombresTablasBD($BaseDatos)
	{
		$Query="SHOW TABLES FROM $BaseDatos";
		$Operacion=$this->Conexion->query($Query);
		$RowOperacion=$Operacion->fetchRow();
		do
		{
			$ArrayInterno[]=$RowOperacion;
		}
		while($RowOperacion=$Operacion->fetchRow());
		if($this->Depurar==true)
		{
			$this->DibujarTabla($ArrayInterno,"Array_Tablas_BD");
		}
		return $ArrayInterno;
	}

	function BuscarCoincidenciasTabla($Tabla)
	{
		$this->InstanciarObjeto($Tabla);
		$this->InfoObjetoTabla=$this->ObtenerInfoObjetoTabla();
		$this->ArrayAtributosTabla=$this->ObtenerAtributosTabla();
		if($this->debug==true)
		{
			$this->trace($this->ArrayAtributosTabla,"","Atributos tabla");
			$this->trace($this->InfoObjetoTabla,"","Objeto");
		}
		$array_llaves=array_keys($this->InfoObjetoTabla->keys);
		$llave_primaria=$array_llaves[0];
		foreach ($this->InfoObjetoTabla->flds as $llave => $valor)
		{
			if($valor->name <> $llave_primaria)
			{
				$coincidencia=$this->BuscarCoincidenciasCampo($valor->name);
				$existeTabla=$this->BuscaSiExisteTablaPosible($coincidencia['separacion']);
				if($existeTabla==true)
				{
					$existeCampo=$this->BuscaSiExisteCampo($coincidencia['nombreposible'],$coincidencia['separacion']);
				}
				if($coincidencia['separacion']<>$Tabla)
				{
					$array_coincidencias[]=array('campo'=>$valor->name,'coincidencia'=>$coincidencia['expresion'],'posibletabla'=>$coincidencia['separacion'],'nombreposible'=>$coincidencia['nombreposible'],'existetabla'=>$existeTabla,'existecampo'=>$existeCampo);
				}
			}
		}

		foreach ($array_coincidencias as $llave => $valor)
		{
			if($valor['existetabla']==true)
			{
				$array_tablas_existentes[]=$valor;
			}
			if($valor['existecampo']==true and $valor['existetabla']==true)
			{
				$array_tablas_para_archivo[]=$valor;
			}
		}
		if($this->Depurar==true)
		{
			$this->DibujarTabla($array_coincidencias,"array_coincidencias");
			$this->DibujarTabla($array_tablas_existentes,"array_tablas_existentes");
			$this->DibujarTabla($array_tablas_para_archivo,"array_tablas_para_arhivo");
		}
		return $array_tablas_para_archivo;
	}

	function BuscaSiExisteCampo($Campo,$Tabla)
	{
		$QueryCamposTabla="SHOW FIELDS FROM $Tabla";
		$Operacion=$this->Conexion->query($QueryCamposTabla);
		$RowOperacion=$Operacion->fetchRow();
		echo $QueryCamposTabla,"<br>";
		do
		{
			$array_tabla[]=$RowOperacion;
		}
		while($RowOperacion=$Operacion->fetchRow());
		$existeCampo=false;
		foreach ($array_tabla as $llave => $valor)
		{
			if($valor['Field']==$Campo)
			{
				$existeCampo=true;
			}
		}
		return $existeCampo;
	}

	function BuscarCoincidenciasCampo($Campo)
	{
		if(ereg('codigo',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "codigo ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('codigo',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('codigo','nombre',$Campo);
			$coincidencia=array('expresion'=>'codigo','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('tipo',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "tipo ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('tipo',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('tipo','nombre',$Campo);
			$coincidencia=array('expresion'=>'tipo','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('id',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "id ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('id',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('id','nombre',$Campo);
			$coincidencia=array('expresion'=>'id','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('referencia',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "referencia ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('referencia',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('referencia','nombre',$Campo);
			$coincidencia=array('expresion'=>'referencia','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('estado',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "estado ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('estado',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('estado','nombre',$Campo);
			$coincidencia=array('expresion'=>'estado','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('numero',$Campo))
		{
			if($this->Depurar==true)
			{
				echo "numero ",$Campo,"<br>";
			}
			$nombreposiblecampomostrar=$Campo;
			$coincidencia=array('expresion'=>'numero','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		else
		{
			$coincidencia=false;
		}
		return $coincidencia;
	}

	function BuscaSiExisteTablaPosible($TablaPosible)
	{
		$existeTabla=false;
		foreach ($this->ArrayTablasBD as $llave => $valor)
		{
			if ($TablaPosible==$valor['Tables_in_sala'])
			{
				$existeTabla=true;
			}
		}
		return $existeTabla;
	}

	function EscribirCabeceras($matriz)
	{
		echo "<tr>\n";
		echo "<td>Conteo</a></td>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function GenerarArchivoSeparadoPorComas($array,$ruta,$nombrearchivo)
	{
		if ($this->Depurar==true)
		{
			error_reporting(2047);
		}
		else
		{
			error_reporting(0);
		}
		if(is_array($array))
		{
			if(!file_exists($ruta.$nombrearchivo))
			{
				$NuevoArchivo = fopen($ruta.$nombrearchivo, "x+");
				foreach ($array as $llave => $valor)
				{
					if($this->Depurar==true)
					{
						echo $valor['posibletabla'].",".$valor['campo'].",".$valor['nombreposible']."<br>";
					}
					$cadena=$valor['posibletabla'].",".$valor['campo'].",".$valor['nombreposible'].","."1"."\n";
					fwrite($NuevoArchivo,$cadena);
				}
				fclose($NuevoArchivo);
			}
		}
		else
		{
			return false;
		}
	}

	function DibujarTabla($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP><h1>$texto</h1></caption>";
			$this->EscribirCabeceras($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				$MostrarConteo=$i+1;
				echo "<tr>\n";
				echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
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

	function trace($var, $file, $line, $exit = false)
	{
		if (ENABLE_DEBUG) {
			$id = md5(microtime());
            ?>
            <div class="sa_trace_start"><a href="javascript:;" class="sa_trace_start_link" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV'); " title="click here to view the output of var_dump(<?= gettype($var) ?>)">:: Trace <span style="color: #ff6600"><?= $file ?></span> on line <?= $line ?> ::</a></div>
             <div id="var_<?= $id ?>" title="click to close" class="sa_trace_dump" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV');">
             <pre><?= print_r($var) ?></pre>
             <div class="sa_trace_end">:: Trace end ::</div>
             </div>
<?php
if ($exit) exit;
		}
	}



}
?>
<?
function incremento_contador($archivo)
{
	// $archivo contiene el numero que actualizamos
	$contador = 0;

	//Abrimos el archivo y leemos su contenido
	$fp = fopen($archivo,"r");
	$contador = fgets($fp, 26);
	fclose($fp);

	//Incrementamos el contador
	++$contador;

	//Actualizamos el archivo con el nuevo valor
	$fp = fopen($archivo,"w+");
	fwrite($fp, $contador, 26);
	fclose($fp);

	echo "Este script ha sido ejecutado $contador veces";
}

?>
 
