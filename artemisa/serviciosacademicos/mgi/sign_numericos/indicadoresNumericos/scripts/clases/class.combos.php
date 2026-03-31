<?php

class selects extends MySQL
{
	var $code = "";
	
	function cargarPaises()
	{
		$consulta = parent::consulta("SELECT nombre,idsiq_periodo from siq_periodo ORDER BY nombre DESC");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$paises = array();
			while($pais = parent::fetch_assoc($consulta))
			{
				$code = $pais["idsiq_periodo"];
				$name = $pais["nombre"];				
				$paises[$code]=$name;
			}
			return $paises;
		}
		else
		{
			return false;
		}
	}
        
        function cargarPaisesEditar($per)
	{
		$consulta = parent::consulta("SELECT nombre,idsiq_periodo from siq_periodo where idsiq_periodo = ".$per);
                $num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$paises = array();
			while($pais = parent::fetch_assoc($consulta))
			{
				$code = $pais["idsiq_periodo"];
				$name = $pais["nombre"];				
				$paises[$code]=$name;
			}
			return $paises;
		}
		else
		{
			return false;
		}
	}
	function cargarEstados()
	{
		$consulta = parent::consulta("select a.idsiq_funcionTipo1 as code,id.nombre as Name,c.nombrecarrera as Carrera  from siq_funcionTipo1 a inner join siq_funcionIndicadores b on a.funcionIndicadores = b.idsiq_funcionIndicadores inner join siq_indicador g  on b.idIndicador = g.idsiq_indicador inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico left join carrera c on c.codigocarrera = g.idCarrera where idPeriodo = ".$this->code."");
                //$consulta = parent::consulta("select funcionIndicadores, idsiq_funcionTipo1 from siq_funcionTipo1 where idPeriodo = ".$this->code."");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$estados = array();
			while($estado = parent::fetch_assoc($consulta))
			{
				$code = $estado["code"];
                                $name = $estado["Name"]." ".$estado["Carrera"] ;
                                $estados[$code]=$name;
			}
			return $estados;
		}
		else
		{
			return false;
		}
	}
		
	function cargarCiudades()
	{
		$consulta = parent::consulta("select valor, idsiq_funcionTipo1 from siq_funcionTipo1 where idsiq_funcionTipo1 = ".$this->code."");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$ciudades = array();
			while($ciudad = parent::fetch_assoc($consulta))
			{
				$name = $ciudad["valor"];				
				$ciudades[$name]=$name;
			}
			return $ciudades;
		}
		else
		{
			return false;
		}
	}		
}
?>