<?php
class datos_ordenpago
{
	function datos_ordenpago($conexion,$codigoestudiante,$numeroordenpago)
	{
		$this->conexion=$conexion;
		$this->codigoestudiante=$codigoestudiante;
		$this->numeroordenpago=$numeroordenpago;
	}
	function obtener_datos_estudiante()
	{
		$query_datosestudiante= "select e.idestudiantegeneral, d.tipodocumento, eg.numerodocumento, o.numeroordenpago, d.nombrecortodocumento,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoestudiante, p.semestreprematricula, 
		o.codigoperiodo, c.codigosucursal, c.centrocosto, c.nombrecarrera, e.codigotipoestudiante, c.codigocarrera, 
		o.codigoimprimeordenpago, i.nombreimprimeordenpago, co.nombrecopiaordenpago
		from estudiante e, ordenpago o, prematricula p, carrera c, documento d, imprimeordenpago i, copiaordenpago co, estudiantegeneral eg
		where e.codigoestudiante = o.codigoestudiante
		and o.numeroordenpago = '$this->numeroordenpago'
		and e.codigoestudiante='$this->codigoestudiante'
		and p.idprematricula = o.idprematricula
		and e.codigocarrera = c.codigocarrera
		and d.tipodocumento = eg.tipodocumento
		and o.codigoimprimeordenpago = i.codigoimprimeordenpago
		and o.codigocopiaordenpago = co.codigocopiaordenpago
		and e.idestudiantegeneral = eg.idestudiantegeneral";
		$operacion=$this->conexion->query($query_datosestudiante);
		$this->estudiante=$operacion->fetchRow();
		$this->semestreprematricula=$this->estudiante['semestreprematricula'];
		$this->codigotipoestudiante=$this->estudiante['codigotipoestudiante'];
		$this->codigosucursal=$this->estudiante['codigosucursal'];
		$this->idestudiantegeneral=$this->estudiante['idestudiantegeneral'];
	}
	function obtener_conceptos()
	{
		$query_datosdetalles= "select d.codigoconcepto, c.nombreconcepto, d.valorconcepto, d.cantidaddetalleordenpago
		from detalleordenpago d, concepto c
		where d.numeroordenpago = '$this->numeroordenpago'
		and d.codigoconcepto = c.codigoconcepto";
		$operacion=$this->conexion->query($query_datosdetalles);
		$row_detalles=$operacion->fetchRow();
		do
		{
			$this->conceptos[]=$row_detalles;
		}
		while($row_detalles=$operacion->fetchRow());
		$this->valorbase=$valorbase;
	}

	function fechas_pago()
	{
		$query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
		from fechaordenpago f
		where f.numeroordenpago = '$this->numeroordenpago'
		order by fechaordenpago";
		$operacion=$this->conexion->query($query_datosfechas);
		$row_operacion=$operacion->fetchRow();
		$contador=0;
		$cuentafechas=1;
		do
		{
			$fechas[$contador][]=$row_operacion;
			switch($cuentafechas)
			{
				case "1":
					$nombreplazo = "PAGO OPORTUNO HASTA: ";
					$nombreplazo_2= "PRIMER PLAZO";
					break;
				case "2":
					$nombreplazo = "2DO VENCIMIENTO HASTA: ";
					$nombreplazo_2= "SEGUNGO PLAZO";
					break;
				case "3":
					$nombreplazo = "3ER VENCIMIENTO HASTA: ";
					$nombreplazo_2= "TERCER PLAZO";
					break;
			}
			$fechas[$contador]['nombreplazo']=$nombreplazo;
			$fechas[$contador]['valorapagar']=$row_operacion['valorfechaordenpago'];
			$fechas[$contador]['valorfechaordenpago']=$row_operacion['valorfechaordenpago'];
			$fechas[$contador]['fechaordenpago']=$row_operacion['fechaordenpago'];
			$fechas[$contador]['nombreplazo_2']=$nombreplazo_2;
			$contador++;
			$cuentafechas++;
		}
		while($row_operacion=$operacion->fetchRow());
		$this->fechas=$fechas;
		return $this->fechas;
	}
	function obtener_materias()
	{
		$contador=0;
		$query_datosmaterias= "select d.codigomateria, m.nombremateria
		from detalleprematricula d, materia m
		where d.numeroordenpago = '$this->numeroordenpago'
		and (d.codigoestadodetalleprematricula like '1%')
		and m.codigomateria = d.codigomateria";
		//echo $query_datosmaterias,"<br>";
		$operacion=$this->conexion->query($query_datosmaterias);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$materias[$contador]['codigomateria']=$row_operacion['codigomateria'];
			$materias[$contador]['nombremateria']=$row_operacion['nombremateria'];
			$contador++;
		}
		while($row_operacion=$operacion->fetchRow());
		$this->materias=$materias;
		//print_r($materias);
	}
	function armar_referencia()
	{
		if(ereg("^1[0-9]*$",$this->codigotipoestudiante))
		{
			$tipoestudiante = 0;
		}
		else
		{
			$tipoestudiante = 1;
		}
		$tamañocodigo = strlen($this->idestudiantegeneral);
		if($tamañocodigo < 8)
		{
			$codigoreferencia = "";
			for($i=$tamañocodigo; $i < 8; $i++)
			{
				$codigoreferencia = $codigoreferencia."0";
			}
		}
		if($this->semestreprematricula < 10)
		{
			$semestrereferencia = "0".$this->semestreprematricula;
		}
		else
		{
			$semestrereferencia = $this->semestreprematricula;
		}
		$codigoreferencia=$codigoreferencia.$this->idestudiantegeneral;
		$this->referencia="00000".$codigoreferencia.$this->numeroordenpago;
	}

	function generar_codigobarras_base()
	{
		$contador=0;
		foreach($this->fechas as $llave => $valor)
		{
			$tamañovalor = strlen($valor[$contador]['valorfechaordenpago']);
			if($tamañovalor < 8)
			{
				$valorfechareferencia = "";
				for($i=$tamañovalor; $i < 8; $i++)
				{
					$valorfechareferencia = $valorfechareferencia."0";
				}
			}
			$valorfechareferencia = $valorfechareferencia.$valor[$contador]['valorfechaordenpago'];
			$codigobarra = "415"."7709998001701"."8020".$this->referencia.chr(202)."3900".$valorfechareferencia.chr(202)."96".ereg_replace("-","",$valor[$contador]['fechaordenpago']);
			//echo $codigobarra,"<br>";
			$array_codigobarra[]=$codigobarra;
		}
		return $array_codigobarra;
	}
	
	function generar_titulobarras_base()
	{
		$contador=0;
		foreach($this->fechas as $llave => $valor)
		{
			$tamañovalor = strlen($valor[$contador]['valorfechaordenpago']);
			if($tamañovalor < 8)
			{
				$valorfechareferencia = "";
				for($i=$tamañovalor; $i < 8; $i++)
				{
					$valorfechareferencia = $valorfechareferencia."0";
				}
			}
			$valorfechareferencia = $valorfechareferencia.$valor[$contador]['valorfechaordenpago'];
			$titulobarra = "(415)"."7709998001701"."(8020)".$this->referencia."(3900)".$valorfechareferencia."(96)".ereg_replace("-","",$valor[$contador]['fechaordenpago']);
			$array_titulobarra[]=$titulobarra;
		}
		return $array_titulobarra;
	}	
}
?>