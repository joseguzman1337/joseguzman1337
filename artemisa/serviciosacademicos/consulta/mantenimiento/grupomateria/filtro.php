<?php
class filtro
{
	var $columnas=array();
	function crear_filtro($query_base)
	{
		$this->query_base=$query_base;
	}
	function agregarcolumna($nombrecolumna, $valorcolumna,$tipobusqueda) //puede ser cadena manda like, o normal manda =,
	{
		if($valorcolumna!="")
		{
			$this->columnas['nombrecolumna']=$nombrecolumna;
			$this->columnas['valorcolumna']=$valorcolumna;
			$this->columnas['tipobusqueda']=$tipobusqueda;
			$this->arraycolumnas[]=$this->columnas;
		}
	}
	function filtrar()
	{
		error_reporting(2048);
		foreach ($this->arraycolumnas as $key => $valor)
		{
			$porciento="";
			if($valor['tipobusqueda']=='like')
			{
				$porciento="%";
			}
			$query_columna=" and ".$valor['nombrecolumna']." ".$valor['tipobusqueda']." '".$porciento.$valor['valorcolumna'].$porciento."'";
			$query_filtro=$query_filtro.$query_columna;
			
		}
			$query_filtrado=$this->query_base.$query_filtro;
			return $query_filtrado;
	}
}
?>
