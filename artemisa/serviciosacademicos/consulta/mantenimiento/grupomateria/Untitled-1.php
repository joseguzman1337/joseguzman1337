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
<?php
$query_detallegrupomateria="select distinct dgm.idgrupomateria, gm.nombregrupomateria,m.nombremateria,m.codigomateria,c.nombrecarrera
from detallegrupomateria dgm,grupomateria gm,materia m,carrera c
where 
dgm.idgrupomateria=gm.idgrupomateria
and m.codigomateria=dgm.codigomateria
and m.codigocarrera=c.codigocarrera
";

$mifiltro = new filtro;
$mifiltro->query_base=($query_detallegrupomateria);
$mifiltro->agregarcolumna("dgm.idgrupomateria", "5","=");
$mifiltro->agregarcolumna("gm.nombregrupomateria", "grupo","like");
$mifiltro->agregarcolumna("m.nombremateria", "matematicas","like");
$mifiltro->agregarcolumna("m.nombremateria", "matematicas","like");
$mifiltro->agregarcolumna("m.codigomateria", "10","=");
$mifiltro->filtrar();
?>

