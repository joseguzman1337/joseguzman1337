<?php
/*
para conocer el numero total de paginas, se divide el numero de filas del resultado del sql
por el numero de filas a mostrar por pagina. Se puede identificar cual fila  
va a comenzar cada pagina multiplicando el numero de pagina por el numero de filas
que aparecen por pagina.
*/
class Paginador
{
	var $totalPaginas;
	var $paginaInicio;

	function Paginador($filasPorPagina, $numFilas, $paginaActual= 1)
	{
		// Calcular el numero total de paginas

		$this->totalPaginas = ceil($numFilas / $filasPorPagina);

		if ($paginaActual < 1)
		{
			$paginaActual = 1;
		}
		else if ($paginaActual > $this->totalPaginas)
		{
			$paginaActual = $this->totalPaginas;
		}
		// Calculate la fila con la que se arranca
		$this->paginaInicio = (($paginaActual- 1) * $filasPorPagina);
	}

	function ObtenerTotalPaginas()
	{
		return $this->totalPaginas;
	}

	function ObtenerPaginaInicio()
	{
		return $this->paginaInicio;
	}
}
?>